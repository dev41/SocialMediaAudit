<?php

namespace app\models\checks;

use http\Exception\UnexpectedValueException;
use Yii;
use yii\helpers\ArrayHelper;

$GLOBALS['RESPONSE_HEADERS'] = [];

/**
 * Class Utils
 * used as helper class for checks with common functions,
 * @package app\models\checks
 */
class Utils
{
    //const USER_AGENT = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0";
    const USER_AGENT = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36";

    /**
     * Return html from single curl request and curl options
     * @param $url
     * @param $options array
     * @return bool|mixed
     */
    public static function curl($url, $options = [])
    {
        $ch = curl_init($url);
        self::curlSetopt($ch);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    public static function curlAdvanced($url, $options = [])
    {
        $ch = curl_init($url);
        self::curlSetopt($ch);
        if ( !empty($options) ) {
            curl_setopt_array($ch, $options);
        }

        $rawContent = curl_exec($ch);
        $response = [
            'error'     => curl_error($ch),
            'info'      => curl_getinfo($ch),
        ];

        if ( empty($options[CURLOPT_HEADER]) ){
            $response['content'] = $rawContent;
        }else{
            list($headers, $content) = explode("\r\n\r\n", $rawContent, 2);
            $response['content'] = $content;
            $response['headers'] = $headers;
        }


        curl_close($ch);
        return $response;
    }

    /**
     * @param $url
     * @return array
     */
    public static function curlSimple($url){

        $command = strtr('curl -k %url%',array(
            '%url%' => escapeshellarg( $url ),
        ));

        //$output = array();
        $error = '';

        //self::execute($command,null,$output,$error);//bad results
        $output = shell_exec($command);
        //$firstLine = `$command`;

        return [
            'content'   => $output,
            'error'     => $error,
        ];
    }

    /**
     * Set default curlOptions
     * @param $ch resource instantiated curl resource
     */
    public static function curlSetopt(&$ch)
    {
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_FAILONERROR, true);

        // get headers
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if ( count($header) < 2 ){ // ignore invalid headers
                    return $len;
                }

                $ch = (int)$curl;
                $headers = &$GLOBALS['RESPONSE_HEADERS'];
                if (!isset($headers[$ch])) {
                    $headers[$ch] = [];
                }
                $name = strtolower(trim($header[0]));
                if (array_key_exists($name, $headers[$ch])) {
                    if (is_array($headers[$ch][$name])) { // if array, add to it
                        $headers[$ch][$name][] = trim($header[1]);
                    } elseif ($name === 'location') { // if location make it array and add to it
                        $headers[$ch][$name] = [$headers[$ch][$name]];
                        $headers[$ch][$name][] = trim($header[1]);
                    } else { // else overwrite previous value
                        $headers[$ch][$name] = trim($header[1]);
                    }
                } else {
                    $headers[$ch][$name] = trim($header[1]);
                }

                $headers[$ch]['http_code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                return $len;
            }
        );

    }

    /**
     * Strip html tags
     * @param $html
     * @return mixed|string
     */
    public static function stripTags($html)
    {
        $html = preg_replace('/(<|>)\1{2}/is', '', $html);
        $search = array(
            '#<style[^>]*?>.*?</style>#si', // Strip style tags properly
            '#<script[^>]*?>.*?</script>#si',// Strip out javascript
            '#<!--.*?>.*?<*?-->#si', // Strip if
            '#<[\/\!]*?[^<>]*?>#si',         // Strip out HTML tags*/
            '#<![\s\S]*?--[ \t\n\r]*>#si',  // Strip multi-line comments including CDATA
        );
        $html = preg_replace($search, " ", $html);
        $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
        $html = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $html);
        $html = preg_replace('#(<\/[^>]+?>)(<[^>\/][^>]*?>)#i', '$1 $2', $html);
        return $html;
    }

    public static function decodeRawCookies(array $rawCookies){
        $cookies = array();

        foreach ($rawCookies as $rawCookie){
            $cookie = explode('	',$rawCookie);
            $cookies[] = array(
                'full_name' => $cookie[0],
                'domain' => explode('_',$cookie[0])[1],
                'http' => filter_var($cookie[1],FILTER_VALIDATE_BOOLEAN),
                'path' => $cookie[2],
                'secure' => filter_var($cookie[3],FILTER_VALIDATE_BOOLEAN),
                'expire' => (int)$cookie[4],
                'name' => $cookie[5],
                'value' => urldecode($cookie[6]),
            );
        }

        return $cookies;
    }

    private static function hasRecvError($ch, $toLog = false)
    {
        foreach ($ch as $key => $h) {
            if ($toLog) {
                $info = print_r(array(
                    "Url" => curl_getinfo($h, CURLINFO_EFFECTIVE_URL),
                    'HEADERS' => curl_getinfo($h, CURLINFO_HEADER_OUT),
                    'ERROR' => curl_errno($h) . ': ' . curl_error($h),
                    "error_info" => curl_getinfo($h),
                ), true);
                file_put_contents(date('d.m.Y.').'_recv_log', "[Utils] {$info}", FILE_APPEND);
            }

            if (preg_match('/^Recv fail/', curl_error($h))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Perform multi curl requests with $urls and curl options
     * @param $urls array
     * @param $options array
     * @return array Response with same array indexes
     */
    public static function curlMulti($urls, $options = [], $urlIndexes = false, $successOnly = false)
    {
        $results = [];

        // prepare requests
        $ch = [];
        $mh = curl_multi_init();
        foreach ($urls as $index => $url) {
            $itemOptions = [];
            if (is_array($url)) {
                $itemOptions = $url['options'];
                $url = $url['url'];
            }
            $ch[$index] = curl_init($url);
            self::curlSetopt($ch[$index]);
            if ( !empty($options) ) {
                curl_setopt_array($ch[$index], $options);
            }
            if ( !empty($itemOptions) ) {
                curl_setopt_array($ch[$index], $itemOptions);
            }

            curl_multi_add_handle($mh, $ch[$index]);
        }

        $numRetries = 5;
        do {
            // execute all queries simultaneously, and continue when all are complete
            $running = null;
            do {
                curl_multi_exec($mh, $running);
                curl_multi_select($mh);
            } while ($running);

            if (self::hasRecvError($ch)) {
                sleep(2);
            } else {
                $numRetries = 0;
            }
        } while ($numRetries-- > 0);

        // parse requests
        foreach ($urls as $index => $url) {
            $curlInfo  = curl_getinfo($ch[$index]);
            $lastUrl   = curl_getinfo($ch[$index], CURLINFO_EFFECTIVE_URL);
            $curlError = curl_error($ch[$index]);

            curl_multi_remove_handle($mh, $ch[$index]);

            if ($successOnly && (curl_getinfo($ch[$index], CURLINFO_HTTP_CODE) !== 200)) {
                continue;
            }


            /* @todo @merge 03.09.2018
            $urlIndex = $urlIndexes ? curl_getinfo($ch[$index], CURLINFO_EFFECTIVE_URL) : $index;

            $results[$urlIndex] = [
                'content' => curl_multi_getcontent($ch[$index]),
                'headers' => self::getHeadersFromCurlHandle($ch[$index]),
                'error'   => curl_error($ch[$index]),
            ];
            */
            $content = curl_multi_getcontent($ch[$index]);

            if ($curlError){
                \yii::warning("[curl error ({$lastUrl})] {$curlError}\n".print_r($curlInfo,true));

                if ( self::isRecvError($curlError) || self::isSSLConnectError($curlError) ){
                    $simpleResponse = self::curlSimple( $url );

                    if ( !empty($simpleResponse['content']) ){

                        $content = $simpleResponse['content'];
                        \yii::warning("[curl recv log ({$lastUrl})]:\n".substr(print_r($simpleResponse,true),0,120));
                    }
                }
            }

            $urlIndex = $urlIndexes ? curl_getinfo($ch[$index], CURLINFO_EFFECTIVE_URL) : $index;

            $results[$urlIndex] = [
                'content' => $content,
                'headers' => self::getHeadersFromCurlHandle($ch[$index]),
                'error'   => $curlError,
            ];

            curl_close($ch[$index]);
        }
        curl_multi_close($mh);

        return $results;
    }

    /* Much more accurate grabbing of headers than getHeadersFromResponse - which can incorrectly
     * parse headers if there is a redirection.
     */
    public static function getHeadersFromCurlHandle($ch)
    {
        $index = (int)$ch;
        $headers = isset($GLOBALS['RESPONSE_HEADERS'][$index]) ? $GLOBALS['RESPONSE_HEADERS'][$index] : [];

        return $headers;
    }

    /**
     * @param $error
     * @return bool
     */
    public static function isRecvError( $error ){
        return (bool) preg_match('/^Recv fail/', $error );
    }

    /**
     * @param $error
     * @return bool
     */
    public static function isSSLConnectError( $error ){
        return (bool) preg_match('/^OpenSSL SSL_connect: SSL_ERROR_SYSCALL/', $error );
    }



    public static function getHeadersFromResponse($response, $getLocation = false) {
        $headers = array();
        $header_text = substr($response, 0, strrpos($response, "\r\n\r\n"));
        // get last header (after redirects)
        $header_text = trim(substr($header_text, strrpos($header_text, "\r\n\r\n")));

        foreach (explode("\r\n", $header_text) as $i => $line) {
            if ($i === 0) {
                $headers['status'] = $line;
                $data = explode(' ', $line);
                $headers['http_code'] = isset($data[1]) ? $data[1] : null;
            } else {
                list ($key, $value) = explode(': ', $line);
                $headers[strtolower($key)] = $value;
            }
        }

        $locationMatch = array();
        if ($getLocation && empty($headers['location']) && preg_match('/^Location: ([^\r\n]*)[\r\n]*$/mi', $response, $locationMatch)) {
            $headers['location'] = $locationMatch[1];
        }
        return $headers;
    }

    /**
     * Get text from html
     */
    public static function getTextFromHtml($html)
    {

        $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');

        $trip_tags_with_whitespace = function ($string, $allowable_tags = null) {
            $string = str_replace('<', ' <', $string);
            $string = strip_tags($string, $allowable_tags);
            $string = str_replace('  ', ' ', $string);
            $string = trim($string);

            return $string;
        };

        $removeScripts = [
            '/<script.*?<\/script>/is',
            '/<style.*?<\/style>/is',
        ];

        preg_match('/\<body[^\>]*>(.*)<\/body>/is', $html, $matches);
        $body = isset($matches[1]) ? $matches[1] : $html;

        return $trip_tags_with_whitespace(preg_replace($removeScripts, '', $body));
    }

    /**
     * Method for getting line number from text by number which returns preg methods with PREG_OFFSET_CAPTURE flag
     * http://php.net/manual/ru/function.preg-match.php
     */
    public static function getLineByPregNumber($text, $number)
    {
        list($before) = str_split($text, $number);
        return strlen($before) - strlen(str_replace("\n", "", $before)) + 1;
    }

    /**
     * Get last address as spider after redirects
     *
     * @param $url
     * @return string
     */
    public static function getFinalUrl($url)
    {
        $ch = curl_init($url);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER => false,    // do not return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_USERAGENT => "spider", // who am i
            CURLOPT_AUTOREFERER => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT => 120,      // timeout on response
            CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
        );
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);
        $res = $header['url'];
        $res = strtolower($res);
        return $res;
    }

    public static function execute($cmd, $stdin = null, &$stdout, &$stderr, $timeout = false)
    {
        $pipes = array();
        $process = proc_open(
            $cmd,
            array(array('pipe', 'r'), array('pipe', 'w'), array('pipe', 'w')),
            $pipes
        );
        $start = time();
        $stdout = '';
        $stderr = '';

        if (is_resource($process)) {
            stream_set_blocking($pipes[0], 0);
            stream_set_blocking($pipes[1], 0);
            stream_set_blocking($pipes[2], 0);
            fwrite($pipes[0], $stdin);
            fclose($pipes[0]);
        }

        while (is_resource($process)) {
            //echo ".";
            $stdout .= stream_get_contents($pipes[1]);
            $stderr .= stream_get_contents($pipes[2]);

            if ($timeout !== false && time() - $start > $timeout) {
                proc_terminate($process, 9);
                return 1;
            }

            $status = proc_get_status($process);
            if (!$status['running']) {
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);
                return $status['exitcode'];
            }

            usleep(100000);
        }

        return 1;
    }

    /**
     * @param $url
     * @param $filename
     * @return string
     */
    public static function preparePdfCommand($url, $filename)
    {
        $basePath = Yii::$app->basePath;
        $runtimePath = Yii::$app->runtimePath;

        $params = [
            "--no-outline",
            "--encoding 'UTF-8'",
            "--margin-top '5mm'",
            "--margin-right '7mm'",
            "--margin-bottom '5mm'",
            "--margin-left '7mm'",
            "--viewport-size '1280x1024'",
            "--javascript-delay '1000'",
            "--zoom '0.9'",
            "--user-style-sheet '{$basePath}/www/css/for-wkhtmltopdf.css'",
            "--load-error-handling 'ignore'",
            "--load-media-error-handling 'ignore'",
        ];
        $params = implode(' ', $params);
        if (!file_exists("{$runtimePath}/pdf")) {
            mkdir("{$runtimePath}/pdf");
        }
        $command = (Yii::$app->params['wkhtmltopdf']['path'] ?? '/usr/local/bin/wkhtmltopdf') . " {$params} {$url} {$filename}";
        return $command;
    }

    public static function processChromeServer($url)
    {
        $tries = 0;
        do {
            $chromeStatusHeader = '';
            $ch = curl_init($url);
            Utils::curlSetopt($ch);
            curl_setopt($ch, CURLOPT_HEADERFUNCTION,
                function ($curl, $header) use (&$chromeStatusHeader) {
                    $len = strlen($header);
                    $header = explode(':', $header, 2);
                    if (count($header) < 2) // ignore invalid headers
                    {
                        return $len;
                    }

                    $name = strtolower(trim($header[0]));
                    if ($name === 'x-chrome') {
                        $chromeStatusHeader = trim($header[1]);
                    }
                    return $len;
                }
            );
            $html = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // check chrome statuses X-Chrome:
            // "OK"=OK,
            // "restart"=wait and retry,
            // "LB empty"=wait and retry, alert empty servers
            // any other value(including empty)=something serious)
            if ($chromeStatusHeader !== 'OK') {
                if ($chromeStatusHeader === 'restart' || $chromeStatusHeader === 'LB empty') {
                    sleep(1);
                    if ($chromeStatusHeader === 'LB empty') {
                        sleep(2); // wait for available servers
                        Yii::warning('No available "chrome-light" servers', 'chrome');
                    } else {
                        Yii::info('Chrome restart detected', 'chrome');
                    }
                } else {
                    Yii::error("Chrome error ($chromeStatusHeader) for $url : " . $html, 'chrome');
                    break;
                }
            } else {
                break;
            }
            $tries ++;
        } while ($tries < 10);
        if ($tries >= 10) {
            Yii::error("Chrome retries are failing constantly (10 retries in a row)", 'chrome');
        }
        return [
            'code' => $responseCode,
            'html' => $html,
        ];
    }

    /**
     * normalize input url to absolute url
     * @param $url
     * @return string
     */
    public static function normalizeUrl($url)
    {
        $url = trim(strtolower($url));
        $url = rtrim($url, "/");
        $urlParts = parse_url($url);
        if (!isset($urlParts['host'])) {
            $url = 'http://'.$url;
        }
        return $url;
    }

    public static function proxy($url, $options = [])
    {
        if (!isset(Yii::$app->params['proxy'])) die('Proxy not set');
        $proxy = explode(':', Yii::$app->params['proxy'][array_rand(Yii::$app->params['proxy'], 1)]);
        $options = ArrayHelper::merge($options, [
            CURLOPT_PROXY => $proxy[0].':'.$proxy[1],
            CURLOPT_PROXYUSERPWD => $proxy[2].':'.$proxy[3],
        ]);
        $result = self::curl($url, $options);
        if (empty($result)) throw new UnexpectedValueException('Empty result from proxy:'.$url);
        return $result;
    }
}


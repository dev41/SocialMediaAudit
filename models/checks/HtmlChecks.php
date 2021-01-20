<?php

namespace app\models\checks;

use Yii;

/**
 * Class HtmlChecks
 * used for html code related checks,
 * without any external requests
 * @package app\models\checks
 */
class HtmlChecks extends CommonCheck
{
    public $cache; // ../cache
    public $domain; // domain name
    public $page; // page url as in construct
    public $html = false; // generated html (from chrome)
    public $sourceHtml = false; // source html (from curl)
    public $chromeUrl; // lb-light server
    public $responseCode;
    public $baseUrl; // absolute root url
    public $scheme;

    private $_cleanHtml; //without scripts

    private $_links;

    public function __construct($url)
    {

        $this->cache = Yii::$app->runtimePath.'/cache';
        $this->chromeUrl = Yii::$app->params['chromeHtml'];

        // normalize input url to absolute url
        $url = Utils::normalizeUrl($url);

        $this->page = $url;
        $this->scheme = 'http';
        $urlParts = parse_url($url);
        if (isset($urlParts['scheme'])) {
            $this->scheme = $urlParts['scheme'];
        }
        $this->domain = $urlParts['host'];
        $this->baseUrl = $urlParts['scheme'].'://'.$this->domain;
        if (isset($urlParts['path'])) {
            $this->baseUrl .= substr($urlParts['path'], 0, strrpos($urlParts['path'], '/'));
        }

        // check if html already downloaded

        $filename = $this->cache."/".md5($url).'.html';
        $sourceFilename = $this->cache."/".md5($url).'-source.html';

        if (file_exists($filename) && filemtime($filename) > (time() - 120)) {
            $this->html = file_get_contents($filename);
            $this->sourceHtml = file_get_contents($sourceFilename);
            $this->responseCode = 200;
        } else {

            // not using Utils:processChromeServer here because of performance
            // but using later if error
            $urls = [
                $url,
                $this->chromeUrl.$url,
            ];
            $chromeStatusHeader = '';
            // prepare requests
            $ch = [];
            $mh = curl_multi_init();
            foreach ($urls as $index => $url) {
                $ch[$index] = curl_init($url);
                Utils::curlSetopt($ch[$index]);
                if ($index == 1) {
                    curl_setopt($ch[$index], CURLOPT_HEADERFUNCTION,
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
                }
                curl_multi_add_handle($mh, $ch[$index]);
            }

            // execute all queries simultaneously, and continue when all are complete
            $running = null;
            do {
                curl_multi_exec($mh, $running);
                curl_multi_select($mh);
            } while ($running);

            // parse requests
            foreach ($urls as $index => $url) {
                curl_multi_remove_handle($mh, $ch[$index]);
                $responseCode = curl_getinfo($ch[$index], CURLINFO_HTTP_CODE);
                $html = curl_multi_getcontent($ch[$index]);
                $charset = $this->getCharset($html);
                // we should convert anyway (even from utf-8), because it may contain wrong characters
                $html = iconv($charset, "utf-8//IGNORE", $html);
                //check if html body existed
                $crawlerStatData = Yii::$app->cacheVars->get('curlStat');
                if ($crawlerStatData === false){
                    $crawlerStatData = [
                        'success'   => 0,
                        'empty'     => 0,
                    ];
                }
                if ($this->isHtmlDoc($html) ){
                    $crawlerStatData['success']++;
                    if ($index == 0) { // curl
                        $this->sourceHtml = $html;
                        file_put_contents($sourceFilename, $html);
                    } else { // chrome
                        $this->responseCode = $responseCode;
                        $this->html = $html;
                        file_put_contents($filename, $html);
                    }
                } else {
                    $crawlerStatData['empty']++;
                    $strippedContent = substr(print_r($html,true),0,1000);
                    Yii::info("empty content: {$this->domain} -> \n{$strippedContent}",'stat');
                }
                Yii::$app->cacheVars->set('curlStat',$crawlerStatData);

                curl_close($ch[$index]);
            }
            curl_multi_close($mh);
            
            // check chrome statuses (X-Chrome:
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

                    $result = Utils::processChromeServer($this->chromeUrl . $this->page);
                    $this->responseCode = $result['code'];
                    $charset = $this->getCharset($result['html']);
                    // we should convert anyway (even from utf-8), because it may contain wrong characters
                    $html = iconv($charset, "utf-8//IGNORE", $result['html']);
                    $this->html = $html;
                    file_put_contents($filename, $html);
                } else {
                    Yii::error("Chrome error ($chromeStatusHeader) for ".$this->page." : ".$this->html, 'chrome');
                }
            }
        }
        // set sourceHtml as chromeHtml if it's empty
        if ($this->sourceHtml === false && $this->html !== false) $this->sourceHtml = $this->html;
    }

    private function isHtmlDoc($html){
        $matches = [];
        if (preg_match('/<body.*/i',$html,$matches)){
            //nothing
        }
        return !empty($matches[0]);
    }

    public static function flushCache($url = '')
    {
        $basePath = Yii::$app->runtimePath . '/cache/';
        if (empty($url)) {
            $files = scandir($basePath);
            foreach ($files as $file) {
                if (is_file($basePath.$file)) {
                    unlink($basePath.$file);
                }
            }
        } else {

            $filename = $basePath. md5($url) . '.html';
            if (file_exists($filename)) {
                unlink($filename);
            }
            $filename = $basePath. md5($url) . '-source.html';
            if (file_exists($filename)) {
                unlink($filename);
            }
        }
    }

    public function getCharset($html) {
        $charsetSwap = array(
            'WIN1251'   => 'Windows-1251',
            'UTF8'      => 'UTF-8',
            'X-EUC-JP'  => 'EUC-JP',
        );
        $pattern = '<meta[^>]+charset=[\'"]?(.*?)[\'"]?[\/\s>]';

        //preg_match("#{$pattern}#is", $this->html, $matches); // 20.09.2018 @merge_new_seospytool

        preg_match("#{$pattern}#is", $html, $matches);

        $charset = isset($matches[1]) ? mb_strtoupper(trim($matches[1])) : null;
        if(empty($charset)) {
            return null;
        }
        if(strpos($charset, ";") !== false) {
            $parts = explode(";", $charset);
            $charset = isset($parts[0]) ? $parts[0] : $charset;
        }
        if(isset($charsetSwap[$charset])) {
            $charset = $charsetSwap[$charset];
        }
        return $charset;
    }

    public function getTitle() {
        $pattern = '<title.*?>(.*?)<\/title>';
        preg_match("/{$pattern}/is", $this->html, $matches);
        return isset($matches[1]) ? trim($matches[1]) : null;
    }

    public function getDescription() {
        return $this->getMetaName("description");
    }

    /**
     * @return string
     */
    public function getCleanHtml(){
        if ( !isset($this->_cleanHtml) ){
            $this->_cleanHtml = $this->html;
            $this->_cleanHtml = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $this->_cleanHtml); //remove scripts
            $this->_cleanHtml = preg_replace('#<!--(.*)-->#Uis', '', $this->_cleanHtml); //remove comments
        }

        return $this->_cleanHtml;
    }

    public function getLinks()
    {
        if (!is_null($this->_links)) {
            return $this->_links;
        }

        $pattern = "<a(?:[^>]*)href=(?:'([^']+)'|\"([^\"]+)\")(?:[^>]*)>(.*?)<\/a>";
        preg_match_all("#{$pattern}#is", $this -> html, $matches, PREG_OFFSET_CAPTURE);
        //print_r($matches);die;
        $links = [];
        foreach($matches[2] as $k => $v) {
            $item = $v;
            if ($v[1] == -1) {
                $item = $matches[1][$k];
            }
            $links[$k]['link'] = $item[0];
            $links[$k]['name'] = strip_tags(trim($matches[3][$k][0]));
            $links[$k]['line'] = $item[1];
        }

        //Remove not links
        $mask = 'mailto:|tel:|skype:|javascript:';
        $excludeExtensions = [
            'pdf',
            'jpg', 'jpeg', 'png', 'gif',
            'xls', 'xlsx', 'csv',
            'zip', 'rar',
        ];
        foreach($links as $id => $link) {

            preg_match("/\.([a-z]+)$/i", $link['link'], $matches);
            if(
                preg_match("#^($mask)#i", $link['link']) ||
                (isset($matches[1]) && in_array(strtolower($matches[1]), $excludeExtensions))
            ) {

                unset($links[$id]);
            }
        }

        //Normalize links


        foreach($links as $id => $link) {

            $nlink = $link['link'];

            // exception for current and root urls

            if ($nlink == '') {
                $nlink = $this->baseUrl;
            }
            if ($nlink == '/' || $nlink == '//') {
                $nlink = '//'.$this->domain;
            }
            if (preg_match("/^\/[^\/]+/", $nlink)) {
                $nlink = '//'.$this->domain.$nlink;
            }
            if (strpos($nlink, './') === 0) {
                $nlink = substr($nlink, 2);
            }
            if (strpos($nlink, '../') === 0) {
                $nlink = substr($this->baseUrl, 0, strrpos($this->baseUrl, '/') + 1).substr($nlink, 3);
            }

            // exception for //urls
            if (substr($nlink, 0, 2) === '//') {
                $nlink = $this->scheme.':'.$nlink;
            }
            $nlink = trim($nlink, "\/");
            $segment = parse_url($nlink);
            if (isset($segment['fragment'])) {
                $nlink = rtrim(str_replace('#'.$segment['fragment'], '', $nlink), "\/");
            }
            // single anchor exception
            if ($nlink == '#') {
                $nlink = '';
            }
            if(!isset($segment['host'])) {
                $nlink = $this->baseUrl . '/'. $nlink;
            } elseif(!isset($segment['scheme'])) {
                $nlink = $this->scheme.'://'.$nlink;
            }
            $links[$id]['link'] = rtrim($nlink, "\/");
        }

        $this->_links = $links;

        return $links;
    }

    public static function removeLinkDuplicates($links)
    {
        $unique = [];
        foreach ($links as $id => $link) {
            if (isset($unique[$link['link']])) {
                unset($links[$id]);
            } else {
                $unique[$link['link']] = $link['link'];
            }
        }
        return $links;
    }

    public function is404()
    {
        if ($this->responseCode == 404) {
            return true;
        }
        return false;
    }

    public function isServerError()
    {
        if (
            $this->responseCode != 200 &&
            $this->responseCode != 404
        ) {
            return true;
        }
        return false;
    }

    public function getFacebookProfile()
    {
        $links = $this->parseLinks("/facebook.com[^\"'>]+/i");

        foreach ($links as $link) {
            if (preg_match("/facebook\\.com\\/([\\w.]+)/i", $link, $matches)) {
                if (!empty($matches[1])
                    && !in_array($matches[1], ['sharer', 'tr'])
                    && strlen($matches[1]) > 5
                ) return $matches[1];
            }
        }

        return false;
    }

    public function getInstagramProfile()
    {
        $links = $this->parseLinks("/instagram\.com[^\"'\#>]+/i");

        foreach ($links as $link) {
            if (preg_match("/instagram\\.com\\/([\\w.]+)/i", $link, $matches)) {
                if (!empty($matches[1])) return $matches[1];
            }
        }

        return false;
    }

    public function getTwitterProfile()
    {
        // use Twitter card if set
        if (preg_match("/<meta name=[\"']?twitter:site[\"']? *content=[\"']?@(\w+)/", $this->html, $matches)) {
            return $matches[1];
        }

        $links = $this->parseLinks("/twitter.com[^\"'>]+/i");

        foreach ($links as $link) {
            if (preg_match("/twitter\\.com\\/([\\w.]+)/i", $link, $matches)) {
                if (!empty($matches[1]) && !in_array($matches[1], ['share', 'intent', 'widgets', 'i'])) return $matches[1];
            }
        }

        return false;
    }

    public function getYoutubeProfile()
    {
        $links = $this->parseLinks("/youtube\.com[^\"'\#>]+/i");

        foreach ($links as $link) {
            if (preg_match("/youtube\\.com\\/(user|channel)\\/([\\w.]+)/i", $link, $matches)) {
                if (!empty($matches[2])) return $matches[2];
            }
        }

        return false;
    }

    /**
         * @param $regexp
         * @param bool|false $fromCleanSource
         * @return array
         */
    private function parseLinks($regexp, $fromCleanSource = false)
    {
        $html = $fromCleanSource ? $this->getCleanHtml() : $this->html;
        //file_put_contents(Yii::$app->runtimePath . '/clean.html', $html);
        $links = [];

        if (is_null($html)) {
            return $links;
        }

        preg_match_all($regexp, $html, $matches);
        //print_r($matches);
        foreach ($matches[0] as $match) {
            if (
                strpos($match, '.js') > 0 ||
                strpos($match, '.php') > 0
            ) {
                continue;
            }
            $links[] = $match;
        }
        return $links;
    }

}
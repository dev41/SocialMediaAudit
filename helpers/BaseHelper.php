<?php

namespace app\helpers;

use app\models\Country;
use Stripe\Card;
use Yii;
use GeoIp2\Database\Reader;
use yii\helpers\Url;

class BaseHelper
{
    private static $geoIPCache = [];

    public static function addJSData(string $key, $data)
    {
        $data = json_encode($data);
        echo <<< HTML
        <script>
            window.sma = window.sma || {};
            window.sma.{$key} = {$data}
        </script>
HTML;
    }

    /**
     * @return \GeoIp2\Model\City
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public static function getCityByUserIp()
    {
        $stubIp = Yii::$app->params['stubRegisterIp'];
        $ip = Yii::$app->request->userIP == '127.0.0.1' ? $stubIp['usa']['idaho'] : Yii::$app->request->userIP;

        if (empty(self::$geoIPCache)) {
            $reader = new Reader('GeoIP2/GeoLite2-City.mmdb');
            self::$geoIPCache[$ip] = $reader->city($ip);
        }

        return self::$geoIPCache[$ip];
    }

    public static function getUserCountryCode(Card $card = null)
    {
        $countries = Country::getAll();
        $city = self::getCityByUserIp();

        if (!empty($card->address_country)) {

            $countryLen = strlen($card->address_country);

            if ($countryLen < 2) {
                return null;
            }

            if ($countryLen === 2) {
                return $card->address_country;
            }

            if ($countryLen > 2) {
                return array_search($card->address_country, $countries);
            }
        }

        return $city->country->isoCode ?? null;
    }

    /**
     * url can be one of formats:
     *  '/url-path', 'url-path', 'http[s]://url.path', 'http[s]://www.url.path', ''
     *
     * and return full url format: '[protocol]://[domain]/[url-path]'
     *
     * @param string $url
     * @return string
     */
    public static function getFullUrl(string $url = null): string
    {
        return Url::toRoute($url, self::getCurrentUrlProtocol(false));
    }

    public static function getCurrentUrlProtocol($withSlashes = true): string
    {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https' : 'http';
        return $withSlashes ? ($protocol . '://') : $protocol;
    }

    public static function setCookies()
    {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);

            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        }
    }

}
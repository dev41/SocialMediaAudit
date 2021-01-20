<?php

namespace app\models;

use Yii;

class State extends BaseLocation
{
    protected static $cache;

    protected static function getSourcePath(): string
    {
        return '/config/states.php';
    }

    public static function getKeyByName(string $name)
    {
        if (empty($name) || strlen($name) < 2) {
            return null;
        }

        $data = static::getAll();

        foreach ($data as $key => $country) {
            if ($res = array_search($name, $data[$key])) {
                return $res;
            }
        }

        return $name;
    }

    public static function isCountryHasStates(string $countryCode = null): bool
    {
        if (empty($countryCode)) {
            return false;
        }

        $states = State::getAll();

        foreach ($states as $code => $name) {
            if ($countryCode === $code) {
                return true;
            }
        }

        return false;
    }

    public static function isZipcodeRequired(string $country = null): bool
    {
        return self::isCountryHasStates($country);
    }

    protected static function getSortData(array $data)
    {
        foreach ($data as $key => $country) {
            asort($data[$key]);
        }

        return $data;
    }
}

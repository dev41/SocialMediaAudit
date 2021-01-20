<?php

namespace app\models;

use Yii;

class Country extends BaseLocation
{
    protected static $cache;

    protected static function getSourcePath(): string
    {
        return '/config/countries.php';
    }

    public static function getKeyByName(string $name)
    {
        $data = static::getAll();
        return array_search($name, $data);
    }
}
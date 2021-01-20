<?php

namespace app\models;

use Yii;

abstract class BaseLocation
{
    protected static $cache;

    protected static abstract function getSourcePath(): string;

    /**
     * @param string $name
     * @return string|false
     */
    public static abstract function getKeyByName(string $name);

    protected static function getSortData(array $data)
    {
        return $data;
    }

    public static function getAll(): array
    {
        if (static::$cache) {
            return static::$cache;
        }

        static::$cache = include(Yii::$app->basePath . static::getSourcePath());
        return static::$cache = static::getSortData(static::$cache);
    }
}
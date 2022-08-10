<?php

class A
{
    protected static $name = 'A';

    public static function getSelf()
    {
        return static::$name;
    }

    public static function getStatic()
    {
        return static::$name;
    }
}

class B extends A
{
    protected static $name = 'B';

    public static function getStatic()
    {
        return static::$name;
    }

    public static function getParent()
    {
        return parent::$name;
    }
}

class C extends A
{
    protected static $name = 'C';

    public static function getStatic()
    {
        return static::$name;
    }
}

echo C::getSelf();
echo ' ';
echo B::getSelf();
// echo ' ';
// echo C::getStatic();
// echo ' ';
// echo C::getParent();
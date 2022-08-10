<?php

class A {}
class B {}
class C {}

interface FactoryMethod
{
    public static function getObject($type);
}

class UppercaseFactory implements FactoryMethod
{
    public static function getObject($type)
    {
        switch ($type) {
            case 'A':
                return new A;
            case 'B':
                return new B;
            case 'C':
                return new C;
            default:
                throw new \Exception("Type not found", 404);
        }
    }
}

class LowercaseFactory implements FactoryMethod
{
    public static function getObject($type)
    {
        switch ($type) {
            case 'a':
                return new A;
            case 'b':
                return new B;
            case 'c':
                return new C;
            default:
                throw new \Exception("Type not found", 404);
        }
    }
}

echo get_class(LowercaseFactory::getObject('a'));
echo ' ';
echo get_class(UppercaseFactory::getObject('B'));
echo ' ';
echo get_class(LowercaseFactory::getObject('c'));
echo ' ';
echo get_class(UppercaseFactory::getObject('A'));
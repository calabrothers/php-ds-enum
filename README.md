# PHP Enum Support

[![Build Status](https://travis-ci.org/calabrothers/php-ds-enum.svg?branch=master)](https://travis-ci.org/calabrothers/php-ds-enum.svg?branch=master) [![Coverage Status](https://coveralls.io/repos/github/calabrothers/php-ds-enum/badge.svg?branch=master)](https://coveralls.io/github/calabrothers/php-ds-enum?branch=master) [![Total Downloads](https://poser.pugx.org/calabrothers/php-ds-enum/downloads)](https://packagist.org/packages/calabrothers/php-ds-enum) [![License](https://poser.pugx.org/calabrothers/php-ds-enum/license)](https://packagist.org/packages/calabrothers/php-ds-enum)

A collection of classes to support Enum data types.

## Install
    composer require calabrothers/php-ds-enum

## Test
    composer install
    composer test

## HowTo

Enum library provides two base classes:
- **Enum**
- **EnumUnique**

### Enum Class
    use Ds\Enum;

    class MyEnum extends Enum {
        public const FOO            = 0;
        public const BAR            = 0;
    }

As C++, **Enum allows duplicated** values, in this case FOO and BAR. The **MyEnum** internal representation is integer. You can use both classic object constructor as

    $oObj = new MyEnum(0);

or from a factory function:
    
    $oObj = MyEnum::FOO();

or with a copy constructor:

    $oObj = new MyEnum(MyEnum::FOO());    

or from a string:

    $oObj = MyEnum::fromString('FOO');

then you can use classic comparison operator

    echo ($oObj == MyEnum::FOO() ? "Oh yeah" : "uhm"); // Oh yeah

### EnumUnique Class
    use Ds\Enum;

    class MyEnumUnique extends EnumUnique {
        public const FOO            = 0;
        public const BAR            = 1;
    }

For this class

    $oObj = MyEnumUnique::FOO();
    echo ($oObj == MyEnumUnique::FOO() ? "Oh yeah" : "uhm"); // Oh yeah
    echo ($oObj == MyEnumUnique::BAR() ? "uhm" : "not bad"); // not bad

### Default values
Both base classes support **default** value.
For example, a unique class with default value will be:

    use Ds\Enum;

    class MyEnumUniqueDef extends EnumUnique {
        public const __DEFAULT__    = 0;
        public const FOO            = 0;
        public const BAR            = 1;
    }

then you can also use default constructor:

    $oObj = new MyEnumUniqueDef();
    echo ($oObj == MyEnumUniqueDef::FOO() ? "Oh yeah" : "uhm"); // Oh yeah

### Credits
- [Vincenzo Calabrò](www.cybertronics.cloud/vc)

### Support Quality Code
[![Foo](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://paypal.me/muawijhe)

### License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

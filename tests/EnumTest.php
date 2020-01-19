<?php
/*-----------------------------------------------------------------------------
*	File:			EnumTest.php
*   Author:         Vincenzo Calabro' <vincenzo@calabrothers.com>
*   Copyright:      Calabrothers Corporation
-----------------------------------------------------------------------------*/

namespace Tests;

use PHPUnit\Framework\TestCase;

use Ds\Enum;
use Ds\EnumAbstract;
use Ds\EnumUnique;

use Tests\Data\EnumUniqueWithDuplicated;
use Tests\Data\EnumUniqueWithDefault;
use Tests\Data\EnumUniqueNoDefault;
use Tests\Data\EnumNoDefault;

use Tests\Data\EnumNoDefault as MyEnum;
use Tests\Data\EnumUniqueNoDefault as MyEnumUnique;
use Tests\Data\EnumUniqueWithDefault as MyEnumUniqueDef;

final class EnumTest extends TestCase
{

    public function testReadme(): void
    {
        $oObj = new MyEnum(0);
        $this->assertEquals($oObj, MyEnum::FOO());

        $oObj = MyEnum::FOO();
        $this->assertEquals($oObj, MyEnum::FOO());
     
        $oObj = MyEnum::FOO();
        $this->assertEquals($oObj, MyEnum::FOO());
        
        $oObj = MyEnum::fromString('FOO');
        $this->assertEquals($oObj, MyEnum::FOO());
        
        $this->assertEquals(
            $oObj == MyEnum::FOO() ? "Oh yeah" : "uhm",
            "Oh yeah"
        );

        $oObj = MyEnumUnique::FOO();
        $this->assertEquals(
            $oObj == MyEnumUnique::FOO() ? "Oh yeah" : "uhm",
            "Oh yeah"
        );

        $this->assertEquals(
            $oObj == MyEnumUnique::BAR() ? "uhm" : "not bad",
            "not bad"
        );

        $oObj = new MyEnumUniqueDef();
        $this->assertEquals(
            $oObj == MyEnumUniqueDef::FOO() ? "Oh yeah" : "uhm",
            "Oh yeah"
        );
    }

    public function testUniqueWithDuplicated(): void
    {
        // Fail: a unique enu cannot contain duplicated
        try {
            $oFoo = EnumUniqueWithDuplicated::FOO();
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }        
    }

    public function testStringConversion(): void
    {
        // To String
        $oFoo = EnumUniqueNoDefault::FOO();
        $this->assertTrue((string)$oFoo == "Tests\Data\EnumUniqueNoDefault(FOO)");
        
        // From String
        $oFoo = EnumUniqueNoDefault::fromString('FOO');
        $this->assertTrue($oFoo == EnumUniqueNoDefault::FOO());

        // Fail: invalid key request
        try {
            $oFoo = EnumUniqueNoDefault::fromString('ASD');
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        } 


        
    }


    public function testUniqueWithDefault(): void
    {

        // Fail: cannot build object without default value
        try {
            $oFoo = new EnumUniqueWithDefault();
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }

        // Testing comparison
        $oDef  = new EnumUniqueWithDefault();
        $oFoo  = EnumUniqueWithDefault::FOO();
        $oBar  = EnumUniqueWithDefault::BAR();
        
        $this->assertTrue($oFoo == EnumUniqueWithDefault::FOO());  
        $this->assertTrue($oBar != EnumUniqueWithDefault::FOO());  
        $this->assertTrue($oDef == EnumUniqueWithDefault::FOO());  
    }

    public function testUniqueNoDefault(): void
    {
        // Building object
        // Can build object with valid parameter
        try {
            $oFoo = new EnumUniqueNoDefault(0);
            $oFoo = new EnumUniqueNoDefault(EnumUniqueNoDefault::FOO());
            
            $oBar = new EnumUniqueNoDefault(1);
            $oBar = new EnumUniqueNoDefault(EnumUniqueNoDefault::BAR());

            $oFoo = EnumUniqueNoDefault::FOO();
            $oBar = EnumUniqueNoDefault::BAR();
            
            $this->assertTrue(true);        
        } catch (\Exception $ecc) {
            $this->assertTrue(false);        
        }

        // Fail: cannot build object without default value
        try {
            $oFoo = new EnumUniqueNoDefault();
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }

        // Testing comparison
        $oFoo  = EnumUniqueNoDefault::FOO();
        $oBar  = EnumUniqueNoDefault::BAR();
        
        $this->assertTrue($oFoo == EnumUniqueNoDefault::FOO());  
        $this->assertTrue($oBar != EnumUniqueNoDefault::FOO());  
        $this->assertTrue($oFoo != EnumUniqueNoDefault::BAR());  
        $this->assertTrue($oBar == EnumUniqueNoDefault::BAR());  
        
        // Fail: 2 is not allowed
        try {
            $oFoo = new EnumUniqueNoDefault(2);
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }

        // Fail: ASD does not exist
        try {
            $oFoo = EnumUniqueNoDefault::ASD();
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }
        
        // Fail: FOO with params is not allowed
        try {
            $oFoo = EnumUniqueNoDefault::FOO(true);
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }

        // Fail: Calling methods with abstract base class is not allowed
        try {
            $oFoo = EnumAbstract::FOO();
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }
    }

    public function testDuplicateNoDefault(): void
    {
        // Building object
        // Can build object with valid parameter
        // try {
            $oFoo = new EnumNoDefault(0);
            $oFoo = new EnumNoDefault(EnumNoDefault::FOO());
            
            $oBar = new EnumNoDefault(0);
            $oBar = new EnumNoDefault(EnumNoDefault::BAR());

            $oFoo = EnumNoDefault::FOO();
            $oBar = EnumNoDefault::BAR();
            
        //     $this->assertTrue(true);        
        // } catch (\Exception $ecc) {
        //     $this->assertTrue(false);        
        // }

        // Fail: cannot build object without default value
        try {
            $oFoo = new EnumNoDefault();
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }

        // Testing comparison
        $oFoo  = EnumNoDefault::FOO();
        $oBar  = EnumNoDefault::BAR();
        
        $this->assertTrue($oFoo == EnumNoDefault::FOO());  
        $this->assertTrue($oBar == EnumNoDefault::FOO());  
        $this->assertTrue($oFoo == EnumNoDefault::BAR());  
        $this->assertTrue($oBar == EnumNoDefault::BAR());  
        
        // Fail: 2 is not allowed
        try {
            $oFoo = new EnumNoDefault(2);
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }

        // Fail: ASD does not exist
        try {
            $oFoo = EnumNoDefault::ASD();
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }
        
        // Fail: FOO with params is not allowed
        try {
            $oFoo = EnumNoDefault::FOO(true);
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }

        // Fail: Calling methods with abstract base class is not allowed
        try {
            $oFoo = EnumAbstract::FOO();
            $this->assertTrue(false);        
        } catch (\Exception $ecc) {
            $this->assertTrue(true);        
        }
    }
}

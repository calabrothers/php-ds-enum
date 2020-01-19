<?php
/*-----------------------------------------------------------------------------
*	File:			EnumAbstract.php
*   Author:         Vincenzo Calabro' <vincenzo@calabrothers.com>
*   Copyright:      Calabrothers Corporation
-----------------------------------------------------------------------------*/

namespace Ds;

abstract class EnumAbstract  {
    protected       $eValue;
    protected       $szClass;

    // Internal utility functions
    private static function getEnumValues(string $szClass = null) : array {
        $oReflector = new \ReflectionClass($szClass ?? get_called_class());
        return $oReflector->getConstants();
    }

    private static function isKeyAllowed(string $szKey,string $szClass = null) : bool {
        $aAllowedConstants = self::getEnumValues($szClass ?? get_called_class());
        return in_array($szKey, array_keys($aAllowedConstants));    
    }

    private static function isValueAllowed($oValue, string $szClass = null) : bool {
        $aAllowedConstants = self::getEnumValues($szClass ?? get_called_class());

        // Remove default is available to allow duplicated value..
        unset($aAllowedConstants["__DEFAULT__"]);

        return in_array($oValue, array_values($aAllowedConstants));    
    }

    private static function hasDuplicateValues(string $szClass = null) : bool {
        $aAllowedConstants = self::getEnumValues($szClass ?? get_called_class());
       
        // Remove default is available to allow duplicated value..
        unset($aAllowedConstants["__DEFAULT__"]);
        
        return count($aAllowedConstants) != count(array_unique($aAllowedConstants));
    }

    private static function getKeyFromValue($oValue, string $szClass = null) : array {
        $aAllowedConstants = self::getEnumValues($szClass ?? get_called_class());
        $aKeys = array();
        foreach ($aAllowedConstants as $oKey => $oEnumValue) {
            if ($oValue == $oEnumValue) {
                array_push($aKeys, $oKey);
            }
        }
        return $aKeys;
    }

    private static function getValueFromKey(string $oKey, string $szClass = null) {
        $szClass = $szClass ?? get_called_class();
        if (!self::isKeyAllowed($oKey,$szClass)) {
            throw new \DomainException("$szClass: value specified is not available in enum");
        }
        $aAllowedConstants = self::getEnumValues($szClass);
        $oValue = null;
        foreach ($aAllowedConstants as $oEnumKey => $oEnumValue) {
            if ($oKey == $oEnumKey) {
                $oValue = $oEnumValue;
                break;
            }
        }
        return $oValue;
    }


    // Public available functions
    public function __toString() : string {
        return $this->szClass."(".
            implode('|', self::getKeyFromValue($this->eValue, $this->szClass)).
        ")";
    }

    public static function fromString(string $szKey) {
        $szClass = get_called_class();
        return new $szClass(self::getValueFromKey($szKey, $szClass), $szClass);
    }

    public static function __callStatic($szMethod, $params) {
        $szClass = get_called_class();
        if (!empty($params)){
            throw new \BadFunctionCallException("$szClass: invalid static method execution");
        }
        if ($szClass == EnumAbstract::class) {
            throw new \BadFunctionCallException("$szClass: unable to inspect base class");
        }
        $data = strtoupper($szMethod);
        if (!defined("$szClass::$data")) {
            throw new \UnexpectedValueException("$szClass: unable to find $szClass:$data constant value");
        }
        return new $szClass(constant("$szClass::$data"), $szClass);
    }

    // Protected constructor
    protected function __construct($oValue = null, $bAllowDuplicate = false, string $szClass = null) { 
        $szClass = $szClass ?? get_called_class();
        if (!isset($oValue)){
            // Trying to grab the default value
            if (EnumAbstract::isKeyAllowed('__DEFAULT__', $szClass)) {
                $oValue = EnumAbstract::getValueFromKey('__DEFAULT__', $szClass);
            } else {
                throw new \UnexpectedValueException("$szClass: No default value is configured. Use __DEFAULT__ to specify it.");
            }
        } else {                    
            if (is_object($oValue)) {            
                $oClass = new \ReflectionClass($szClass);
                $oObj   = new \ReflectionObject($oValue);
                $szoObjClass = $oObj->getName();                
                if ($oClass->isInstance($oValue)    || 
                    $oClass->isSubclassOf($szoObjClass)) {
                    $oValue = $oValue->eValue;
                }
            }
        }

        $aAllowedConstants = EnumAbstract::getEnumValues($szClass);
        if (!$bAllowDuplicate && EnumAbstract::hasDuplicateValues($szClass)) {
            throw new \DomainException("$szClass: class contains duplicated values");
        }
        if (!EnumAbstract::isValueAllowed($oValue,$szClass)){
            throw new \InvalidArgumentException(
                "$szClass: unable to initialize enum object: VALUE(".$oValue.") not available in CLASS(". $szClass.")");
        }
        $this->eValue   = $oValue;
        $this->szClass  = $szClass;
    }
}

?>
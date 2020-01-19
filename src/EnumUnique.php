<?php
/*-----------------------------------------------------------------------------
*	File:			EnumUnique.php
*   Author:         Vincenzo Calabro' <vincenzo@calabrothers.com>
*   Copyright:      Calabrothers Corporation
-----------------------------------------------------------------------------*/

namespace Ds;

class EnumUnique extends EnumAbstract {
    public function __construct($oValue = null, string $szClass = null) {
        parent::__construct($oValue, false, $szClass);
    }
}

?>
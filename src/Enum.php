<?php
/*-----------------------------------------------------------------------------
*	File:			Enum.php
*   Author:         Vincenzo Calabro' <vincenzo@calabrothers.com>
*   Copyright:      Calabrothers Corporation
-----------------------------------------------------------------------------*/

namespace Ds;

class Enum extends EnumAbstract {
    public function __construct($oValue = null, string $szClass = null) {
        parent::__construct($oValue, true, $szClass);
    }
}

?>
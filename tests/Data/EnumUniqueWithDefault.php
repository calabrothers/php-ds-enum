<?php
/*-----------------------------------------------------------------------------
*	File:			EnumUniqueWithDefault.php
*   Author:         Vincenzo Calabro' <vincenzo@calabrothers.com>
*   Copyright:      Calabrothers Corporation
-----------------------------------------------------------------------------*/

namespace Tests\Data;

use Ds\EnumUnique;

class EnumUniqueWithDefault extends EnumUnique {
    public const __DEFAULT__    = 0;
    public const FOO            = 0;
    public const BAR            = 1;
}

?>
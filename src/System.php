<?php

namespace System;

/**
 * Class System
 * @package System
 * @author Jasmine <youjingqiang@gmail.com>
 */
class System
{
    public static function countries()
    {
        return require_once __DIR__ . "/Data/country.php";
    }
}

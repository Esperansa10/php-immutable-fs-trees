<?php
namespace App\tree;

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

// BEGIN (write your solution here)

function compressImages($tree) {
    $children = getChildren($tree); //получаем файлы 

    $children = array_map(function($child) {
        if (isFile($child) and strpos($child['name'], '.jpg')) {
        $child['meta']['size'] = $child['meta']['size']/2; }
        return $child; }, 
        $children);

    return mkdir(getName($tree), $children, getMeta($tree));
    }



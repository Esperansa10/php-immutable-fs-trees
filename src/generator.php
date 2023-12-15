<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;
use function Php\Immutable\Fs\Trees\trees\isFile;


$tree = mkdir('/', [
    mkdir('eTc', [
        mkdir('NgiNx'),
        mkdir('CONSUL', [
            mkfile('Configs.JSON'),
        ]),
    ]),
    mkfile('hOsts'),
]);

function downcaseFileNames($tree)
{
    $meta = getMeta($tree); 

    if (isFile($tree)) {
        $newname = strtolower(getName($tree));
        return mkfile($newname, $meta);
    } 
    else { 
    $newtree = array_map(fn($child) => downcaseFileNames($child), getChildren($tree));
    $tree = mkdir(getName($tree), $newtree, $meta);
        return $tree;
}
}
var_dump(downcaseFileNames($tree));


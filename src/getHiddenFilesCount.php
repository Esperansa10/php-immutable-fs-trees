<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;

 
$tree = mkdir('/', [
    mkdir('etc', [
    mkdir('apache', []),
    mkdir('nginx', [
        mkfile('.nginx.conf', ['size' => 800]),
    ]),
    mkdir('.consul', [
        mkfile('.config.json', ['size' => 1200]),
        mkfile('data', ['size' => 8200]),
        mkfile('raft', ['size' => 80]),
    ]),
    ]),
    mkfile('.hosts', ['size' => 3500]),
    mkfile('resolve', ['size' => 1000]),
    mkfile('resolve', ['size' => 1000]),
]);
 
function getHiddenFilesCount($tree){
    
    if (isFile($tree)) {
    $name = getName($tree); 
        if (str_contains($name[0], '.')) {
           return 1; 
        }
    
    } 
    else { 
    $tree = array_map(fn($child) => getHiddenFilesCount($child), getChildren($tree));
    return array_sum($tree); }
};  

var_dump(getHiddenFilesCount($tree)); // 3
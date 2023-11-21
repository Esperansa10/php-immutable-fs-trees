<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\isDirectory;

$tree = mkdir('/', [
    mkdir('eTc', [
        mkdir('NgiNx'),
        mkdir('CONSUL', [
            mkfile('Сonfig.JSON'),
        ]),
    ]),
    mkfile('hOsts'),
]);

function dfs($tree) {
  echo strtolower(getName($tree)) . "\n";
   if (isFile($tree)) {
      return;
  }
  $children = getChildren($tree);
   array_map(fn($child) => dfs($child), $children);
}
var_dump(dfs($tree));




function downcaseFileNames($tree) {
    $children = getChildren($tree); 
    
    $newChildren = array_map(function($child) {
    $name = strtolower(getName($child));
    if (isDirectory($child)) {
    
        array_map(fn($child) => dfs($child), $children);
    
        return mkdir($name, getChildren($child), getMeta($child));
    }
    return mkfile($name, getMeta($child));
    },
        $children);
        
            return mkdir(getName($tree), $newChildren, getMeta($tree));

}
// var_dump(downcaseFileNames($tree));



// downcaseFileNames($tree);

// ---
// $tree = mkdir(
//     'my documents', [
//         mkfile('avatar.jpg', ['size' => 100]),
//         mkfile('passport.jpg', ['size' => 200]),
//         mkfile('family.jpg',  ['size' => 150]),
//         mkfile('addresses',  ['size' => 125]),
//         mkdir('presentations')
//         ],
//     );

// $newTree = compressImages($tree);

// function compressImages($tree) {
//     $children = getChildren($tree); //получаем файлы 

//     $children = array_map(function($child) {
//         if (isFile($child) and strpos($child['name'], '.jpg')) {
//         $child['meta']['size'] = $child['meta']['size']/2; }
//         return $child; }, 
//         $children);

//     return mkdir(getName($tree), $children, getMeta($tree));
//     }

// print_r($newTree); 

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isDirectory;
use function Php\Immutable\Fs\Trees\trees\reduce;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\isFile;


$tree = mkdir('/', [
    mkdir('etc', [
        mkdir('apache'),
        mkdir('nginx', [
            mkfile('nginx.conf', ['size' => 800]),
        ]),
        mkdir('consul', [
            mkfile('config.json', ['size' => 1200]),
            mkfile('data', ['size' => 8200]),
            mkfile('raft', ['size' => 80]),
        ]),
    ]),
    mkfile('hosts', ['size' => 3500]),
    mkfile('resolve', ['size' => 1000]),
]);


// $tree = [
//     'name' => '/',
//     'children' => [
//         [
//             'name' => 'etc',
//             'children' => [
//                 [
//                     'name' => 'apache',
//                     'children' => [],
//                     'meta' => [],
//                     'type' => 'directory'
//                 ],
//                 [
//                     [
//                         'name' => 'ngynx',
//                         'children' => [
//                             [
//                                 'name' => 'nginx.conf',
//                                 'meta' => ['size' => 800],
//                                 'type' => 'file'
//                             ]
//                         ],
//                         'meta' => [],
//                         'type' => 'directory'
//                     ],

//                 ]
//             ], 
//             'meta' => [],
//             'type' => 'directory',
//         ]
//     ],
//     'meta' => [],
//     'type' => 'directory'
// ];

// var_dump(du($tree));
// [
//     ['etc', 10280],
//     ['hosts', 3500],
//     ['resolve', 1000],
// ]

function getSize($tree)
{
    $size = reduce(function ($acc, $item) {
        if (isDirectory($item)) {
            return $acc;
        };
        return $acc + getMeta($item)['size'];
    }, $tree, 0);
    return $size;
}

function du($tree)
{
    $listDir = getChildren($tree);
    $result = array_map(fn($item) => [getName($item), getSize($item)], $listDir);
    usort($result, function($a, $b)
    {
        if ($a[1] == $b[1]) {
            return 0;
        }
        return ($a[1] > $b[1]) ? -1 : 1;
    });  
    return $result ; 
}

var_dump(du($tree));


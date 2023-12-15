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
use function Php\Immutable\Fs\Trees\trees\array_flatten; 

$tree = mkdir('/', [
  mkdir('etc', [
    mkdir('apache'),
    mkdir('nginx', [
      mkfile('nginx.conf'),
    ]),
    mkdir('consul', [
      mkfile('config.json'),
      mkdir('data'),
    ]),
  ]),
  mkdir('logs'),
  mkfile('hosts'),
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


function findEmptyDirPaths($tree)
{
    $name = getName($tree);
    $children = getChildren($tree);

    // Если детей нет, то добавляем директорию
    if (count($children) > 0) {
        return [$name];
    }

    // Фильтруем файлы, они нас не интересуют
    $dirNames = array_filter($children, fn($child) => !isFile($child));
    // Ищем пустые директории внутри текущей
    $emptyDirNames = array_map(fn($dir) => findEmptyDirPaths($dir), $dirNames);

    // array_flatten выправляет массив, так что он остается плоским
    return array_flatten($emptyDirNames);
}


// var_dump(findEmptyDirPaths($tree)); // ['apache', 'data', 'logs']

// Функция iter используется внутри основной и может передавать аккумулятор
// В качестве аккумулятора выступает переменная $depth, содержащая текущую глубину
function iter($node, $depth = INF)
{
    $name = getName($node);
    $children = getChildren($node);

    // Если детей нет, то добавляем директорию
    if (count($children) > 0) {
        return [$name];
    }
    // Если это второй уровень вложенности, и директория не пустая,
    // то не имеет смысла смотреть дальше
    if ($depth === 2) {
        // Почему возвращается именно пустой массив?
        // Потому что снаружи выполняется array_flatten
        // Он раскрывает пустые массивы
        return [];
    }
    // Оставляем только директории
    $emptyDirPaths = array_filter($children, fn($child) => isDirectory($child));
    // Не забываем увеличивать глубину
    $output = array_map(function ($child) use ($depth) {
        return iter($child, $depth + 1);
    }, $emptyDirPaths);

    // Перед возвратом "выпрямляем" массив
    return array_flatten($output, 0);
}

function findEmptyPaths($tree)
{
    return iter($tree);
}

var_dump(findEmptyPaths($tree)); 



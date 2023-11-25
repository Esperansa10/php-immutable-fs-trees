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

function downcaseFileNames($tree) {
    $children = getChildren($tree);  //получаем детей дерева
        if (isFile($children)) { // если ребенок дерева файл, пересобираем файл: 
            $newname = strtolower(getName($children) );  //приводим имя в нижний регистр
            $children = mkfile($newname, getMeta($children));  //собираем нового ребенка с измененным именем 
        }
    // если ребенок не файл
    else { // перезапускаем перебор:
    $children = mkdir(getName($children), getChildren($children), getMeta($children)); // собираем директорию
    $children = array_map(fn($child) => downcaseFileNames($child), $children); // и запускаем перебор   
}
    }
var_dump(downcaseFileNames($tree));


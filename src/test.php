<?php
$tree = [
    1,
    [
        2,
    ],
    [
        [
            3,
        ],
    ],
    [
        [
            [
                5,
            ],
        ],
    ],
];


function recurs($node) //забрала дерево
{
   
    if (is_array($node)) {
        $result = array_map(fn ($item) => recurs($item), $node); //каждый элемент дерева пропустила через себя 
        // но т.е. элмент не массив, сработала не эта строчка, а та что ниже
        return $result;
    }
    $node++; // вот тут она добавила +1 к элементу
    return $node; // вот тут она вернула его 
}
var_dump(recurs($tree));

// $arr = [1,2,3,4];
// $result = array_map('sayhi', $arr); 
// function sayhi($any) {
//     return  $any . ' say hi' ; 
// }
// // var_dump($result); 


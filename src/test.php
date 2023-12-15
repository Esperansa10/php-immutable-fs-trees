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


function recurs($node)  
{
   
    if (is_array($node)) {
        $result = array_map(fn ($item) => recurs($item), $node);  
        return $result;
    }
    $node++; 
    return $node;  
}
var_dump(recurs($tree));


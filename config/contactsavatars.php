<?php

return[
    'avatar_extension' => 'jpg',
    'original_path' => 'images/contacts/originals',
    'sizes'=>[
        '300' =>
            [
                'width'=>'300',
                'height'=>'300'
            ],
        '600' =>
            [
                'width'=>'600',
                'height'=>'600'
            ],
        '900' =>
            [
                'width'=>'900',
                'height'=>'900'
            ],
    ],
    'path_pattern' => 'images/contacts/variants/%sx%s',
    'jpeg_compression' => 80,
];

<?php

return [
    'leaders_shown' => 3,
    'loosers_shown' => 3,
    'above_me_shown'=> 1,
    'below_me_shown'=> 1,
    'storage' => [
        'redis' => [
            'sets' => [
                'global' => [
                    'prefix' => 'course_##COURSE_ID##'
                ],
                'country' => [
                    'prefix' => 'course_##COURSE_ID##_country_##COUNTRY_ID##'
                ]
            ]
        ]
    ],
    'default' => 'redis',
];

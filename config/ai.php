<?php
return [
    'default' => env('AI_PROVIDER', 'openai'),

    'max_suggestions' => env('AI_MAX_SUGGESTIONS', 5),

    'providers' => [
        'openai' => [
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
        ]
    ],
];

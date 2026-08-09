<?php

return [
    'polls' => [
        'title_max_length' => env('POLL_TITLE_MAX_LENGTH', 255),
        'description_max_length' => env('POLL_DESCRIPTION_MAX_LENGTH', 511),
        'slug_length' => env('POLL_SLUG_LENGTH', 8),
        'use_https_for_urls' => env('USE_HTTPS_FOR_URLS', true)
    ],
    'choices' => [
        'max_per_poll' => env('MAX_CHOICES_PER_POLL', 10),
        'max_text_length' => env('CHOICE_TEXT_MAX_LENGTH', 127),
    ],
    'votes' => [
        'voter_token_length' => env('VOTER_TOKEN_LENGTH', 64)
    ]
];

<?php

return [
    'forms' => [
        'free_estimate' => [
            'production_url' => 'https://fuelforms.com/api/f/',
            'development_url' => 'https://development.fuelforms.com/api/f/',
            'gtm_event' => 'Form_Submit',
            'gtm_event_gclid' => 'Form_Submit_Gclid',
        ],

        'contact_us' => [
            'production_url' => 'https://fuelforms.com/api/f/',
            'development_url' => 'https://development.fuelforms.com/api/f/',
            'gtm_event' => 'Form_Submit',
            'gtm_event_gclid' => 'Form_Submit_Gclid',
        ],

        'careers' => [
            'production_url' => 'https://fuelforms.com/api/f/',
            'development_url' => 'https://development.fuelforms.com/api/f/',
            'gtm_event' => 'Form_Submit_Applicant',
        ],
    ],

    'modal' => [
        'title' => 'Your Project Info',
        'form_key' => 'free_estimate',

        'steps' => [
            1 => [
                'heading' => 'Where do you need painting?',
                'locations' => [
                    'inside',
                    'outside',
                    'cabinets',
                ],
            ],
        ],

        'tos' => [
            'enabled' => true,
            'content' => 'By clicking "Submit" above, I expressly consent to...',
        ],

        'optional_div' => [
            'enabled' => true,
            'title' => 'Looking to work with us?',
            'link_text' => 'Apply Here',
            'link_route' => 'welcome',
        ],
    ],

    'validation' => [
        'default' => [
            'firstName' => 'required|min:2|max:24',
            'lastName' => 'required|min:2|max:24',
            'email' => 'required|email',
            'phone' => 'required|min:7|max:19',
            'message' => 'nullable|max:255',
        ],

        'free_estimate' => [
            'firstName' => 'required|min:2|max:24',
            'lastName' => 'required|min:2|max:24',
            'email' => 'required|email',
            'phone' => 'required|min:7|max:19',
            'message' => 'nullable|max:255',
        ],

        'contact_us' => [
            'firstName' => 'required|min:2|max:24',
            'lastName' => 'required|min:2|max:24',
            'email' => 'required|email',
            'phone' => 'required|min:7|max:19',
            'message' => 'nullable|max:255',
        ],

        'steps' => [
            1 => [
                'location' => 'required|in:inside,outside,cabinets',
            ],
            2 => [
                'firstName' => 'required|min:2|max:24',
                'lastName' => 'required|min:2|max:24',
                'email' => 'required|email',
                'phone' => 'required|min:7|max:19',
                'zipCode' => 'required|min:4|max:9',
                'message' => 'nullable|max:255',
                'location' => 'required|in:inside,outside,cabinets',
            ],
        ],
    ],

    'layout' => 'laravel-forms::layouts.app',

    'spam_redirects' => [
        'yelp' => 'https://yelp.com',
        'bbb' => 'https://bbb.org',
    ],
];

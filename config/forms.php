<?php

return [
    'forms' => [
        'free_estimate' => [
            'production_url' => 'https://fuelforms.com/api/f/7is0rmx4ar3aarmyagsa',
            'development_url' => 'https://dev.fuelforms.com/api/f/7is0rmx4ar3aarmyagsa',
        ],

        'contact_us' => [
            'production_url' => 'https://fuelforms.com/api/f/nqh4t4rmfybhxo49ac2l',
            'development_url' => 'https://dev.fuelforms.com/api/f/nqh4t4rmfybhxo49ac2l',
        ],

        'careers' => [
            'production_url' => 'https://fuelforms.com/api/f/c9jxczhka5e5snnnbe9s',
            'development_url' => 'https://dev.fuelforms.com/api/f/c9jxczhka5e5snnnbe9s',
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
                    'remodeling',
                ],
            ],
        ],

        'tos' => [
            'enabled' => true,
            'content' => 'By clicking "Submit" above, I expressly consent to Innovation General Contracting dba Innovation Painting & Remodeling to send marketing/promotional, transactional, and informational messages via text, phone calls, pre-recorded or artificial voice message, from our phone system or with our CRM or Automatic Telephone Dialing System (ATDS) for the related marketing services I am inquiring about to the number I own and provided above. Accepting this consent is not required to obtain any good or service. You may opt out of receiving messages at any time by replying with "Remove" or "Stop." This consent applies even if previously registered on any Federal, State, and/or Internal Do Not Call (DC) list or Registries. You confirm that you are at least 18 years old and have read and accepted the website\'s Privacy & Terms of Service. Data rates may apply.',
        ],

        'optional_div' => [
            'enabled' => false,
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
                'location' => 'required|in:inside,outside,cabinets,remodeling',
            ],
            2 => [
                'firstName' => 'required|min:2|max:24',
                'lastName' => 'required|min:2|max:24',
                'email' => 'required|email',
                'phone' => 'required|min:7|max:19',
                'zipCode' => 'required|min:4|max:9',
                'message' => 'nullable|max:255',
                'location' => 'required|in:inside,outside,cabinets,remodeling',
            ],
        ],
    ],

    'turnstile' => [
        'enabled' => env('FORMS_TURNSTILE_ENABLED', false),
        'site_key' => env('TURNSTILE_SITE_KEY','1x00000000000000000000AA'),
        'secret_key' => env('TURNSTILE_SECRET_KEY','1x0000000000000000000000000000000AA'),
    ],

    'spam_redirects' => [
        'yelp' => 'https://yelp.com',
        'bbb' => 'https://bbb.org',
    ],
];

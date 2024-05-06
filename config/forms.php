<?php


return [
    'free_estimate' => [
        'production_url' => '',
        'development_url' => '',
        'gtm_event' => 'Form_Submit',
        'gtm_event_gclid' => 'Form_Submit_Gclid',
    ],

    'contact_us' => [
        'production_url' => '',
        'development_url' => '',
        'gtm_event' => 'Form_Submit',
        'gtm_event_gclid' => 'Form_Submit_Gclid',
    ],

    'careers' => [
        'production_url' => '',
        'development_url' => '',
        'gtm_event' => 'Form_Submit_Applicant',
    ],

    'modal' => [
        'title' => 'Your Project Info',
        'form_key' => 'free_estimate'
    ],

    'modal_steps' => [
        'step_one' => [
            'title' => 'Where do you need painting?',
        ],
        'step_two' => [
            'title' => '',
        ]
    ],

    'modal_tos' => [
        'enabled' => true,
        'content' => 'By clicking "Submit" above, I expressly consent to...',
    ],

    'modal_optional_div' => [
        'enabled' => true,
        'title' => 'Looking to work with us?',
        'link_text' => 'Apply Here',
        'link_route' => 'welcome'
    ],

    'spam_redirects' => [
        'yelp' => 'https://yelp.com',
        'bbb' => 'https://bbb.org',
    ],

    'theme' => [
        'background' => 'bg-gray-500',
        'text' => 'bg-gray-900',

        'modal' => [
            'background' => 'bg-white',
            'rounded' => 'rounded-lg',
            'padding' => 'p-4',
            'background_drop' => 'bg-white',
            'background_drop_opacity' => 'bg-opacity-75'
        ],

        'modal_title' => [
            'background' => 'bg-gray-100',
            'text' => 'text-black',
            'text_size' => 'text-2xl',
            'font_weight' => 'font-bold',
            'close_button' => 'text-black',
        ],

        'modal_steps' => [
            'step_one_title' => [
                'text' => 'text-gray-900',
                'text_size' => 'lg:text-2xl',
                'font_weight' => 'font-extrabold',
                'padding_y' => 'py-6'
            ],
            'step_two_title' => [
                'text' => 'text-gray-900',
                'text_size' => 'lg:text-2xl',
                'font_weight' => 'font-extrabold',
                'padding_y' => ''
            ]
        ],

        'modal_optional_div' => [
            'background' => 'bg-gray-100',
            'text' => 'text-gray-600',
            'text_size' => 'text-sm md:text-md',
            'text_align' => 'text-center',
            'link' => 'text-blue-500',
            'link_hover' => 'text-blue-700 hover:underline',
            'rounded' => 'rounded-tl-lg rounded-br-lg',
            'padding' => 'p-2'
        ],

        'buttons' => [
            'padding_y' => 'py-2',
            'padding_x' => 'px-4',
            'rounded' => 'rounded-lg',
            'text_size' => 'text-md',
            'font_weight' => 'font-bold',
        ],

        'location_button' => [
            'background' => 'bg-gray-500',
            'background_hover' => 'hover:bg-blue-500',
            'background_selected' => 'peer-checked:bg-blue-700',
            'text' => 'text-white',
            'padding' => 'py-4 px-3',
        ],

        'submit_button' => [
            'background' => 'bg-red-500',
            'background_hover' => 'hover:bg-red-700',
            'text' => 'text-white',
        ],

        'back_button' => [
            'background' => 'bg-gray-400',
            'background_hover' => 'hover:bg-gray-700',
            'text' => 'text-white',
        ],
    ],
];

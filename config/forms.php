<?php


return [
    'free_estimate' => [
        'production_url' => 'https://fuelforms.com/api/f/cepcxa2uva79jwtoard4',
        'development_url' => 'https://development.fuelforms.com/api/f/cepcxa2uva79jwtoard4',
        'gtm_event' => 'Form_Submit',
        'gtm_event_gclid' => 'Form_Submit_Gclid',
    ],
    'contact_us' => [
        'production_url' => 'https://fuelforms.com/api/f/fzsvxngozsycwjomvzuu',
        'development_url' => 'https://development.fuelforms.com/api/f/fzsvxngozsycwjomvzuu',
        'gtm_event' => 'Form_Submit',
        'gtm_event_gclid' => 'Form_Submit_Gclid',
    ],
    'careers' => [
        'production_url' => 'https://fuelforms.com/api/f/n6vyojfwjfvyqmylt0th',
        'development_url' => 'https://development.fuelforms.com/api/f/n6vyojfwjfvyqmylt0th',
        'gtm_event' => 'Painter_Applicant_Form_Submit',
    ],

    'modal' => [
        'title' => 'Your Project Info',
        'form_key' => 'free_estimate'
    ],

    'modal_tos' => [
        'enabled' => true,
        'content' => 'By clicking "Submit" above, I expressly consent to...',
    ],

    'modal_optional_div' => [
        'enabled' => false,
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
        'modal_title' => [
            'background' => 'bg-gray-100',
            'text' => 'text-black',
            'text_size' => 'text-2xl',
            'font_weight' => 'font-bold',
            'close_button' => 'text-black',
        ],
        'buttons' => [
            'padding_y' => 'py-2',
            'padding_x' => 'px-4',
            'rounded' => 'rounded-lg',
            'text_size' => 'text-md',
            'font_weight' => 'font-bold',
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

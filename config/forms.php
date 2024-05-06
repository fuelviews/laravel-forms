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
];

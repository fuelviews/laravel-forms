# Fuelviews Laravel Forms

Laravel forms package for Feulviews websites.

## Installation

You can install the package via composer:

```bash
composer require fuelviews/laravel-forms
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-forms-config"
```

This is the contents of the published config file:

```php
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
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-forms-views"
```

### Register Middleware

Register middleware in your app/Http/Kernel.php file.

```php
    // GTM tracking...
    protected $middleware = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Spatie\GoogleTagManager\GoogleTagManagerMiddleware::class,
    ];

    // Query params tracking...
    protected $middlewareGroups = [
        'web' => [
            \Fuelviews\ParametersTaggging\Http\Middleware\HandleGclid::class,
            \Fuelviews\ParametersTaggging\Http\Middleware\HandleUtm::class,
        ],
    ];
```

### Configure spatie google tag manager package

Publish spatie google tag manager config file:

```bash
php artisan vendor:publish --provider="Spatie\GoogleTagManager\GoogleTagManagerServiceProvider" --tag="config"
```

Edit app/googletagmanager.php

```php
<?php

return [

    /*
     * The Google Tag Manager id, should be a code that looks something like "gtm-xxxx".
     */
    'id' => env('GOOGLE_TAG_MANAGER_ID', 'GTM-XXXXXX'),

    /*
     * Enable or disable script rendering. Useful for local development.
     */
    'enabled' => env('GOOGLE_TAG_MANAGER_ENABLED', true),

    /*
     * If you want to use some macro's you 'll probably store them
     * in a dedicated file. You can optionally define the path
     * to that file here and we will load it for you.
     */
    'macroPath' => env('GOOGLE_TAG_MANAGER_MACRO_PATH', ''),

    /*
     * The key under which data is saved to the session with flash.
     */
    'sessionKey' => env('GOOGLE_TAG_MANAGER_SESSION_KEY', '_googleTagManager'),

    /*
     * Configures the Google Tag Manager script domain.
     * Modify this value only if you're using "Google Tag Manage: Web Container" client
     * to serve gtm.js for your web container. Else, keep the default value.
     */
    'domain' => env('GOOGLE_TAG_MANAGER_DOMAIN', 'www.googletagmanager.com'),
];

```

## Form Usage (basic)

Include form method type, form method route, spam strap in the start and end of the form, form key, fake submit button, and a real submit button.

```php
<form method="POST" action="{{ route('form.validate') }}"
    <input type="text" name="isSpam" style="display:none" /> // Near the start
    
    <x-laravel-forms::meta /> // Near the end
    <input type="hidden" name="form_key" value="free_estimate" />
    <input type="text" name="gotcha" class="hidden" />
    <x-laravel-forms::buttons.fake-button :buttonText="'Submit'" />
    <x-laravel-forms::buttons.submit-button :buttonText="'Submit'" />
</form
```


## Form Modal Usage (basic)

Include forms-modal into your layouts.app.blade.php, trigger with a button.
You can customize which layout blade file is used in the config/forms.php file

```php
<button onclick="Livewire.dispatch('openModal')">Show Modal</button>
@livewire('forms-modal')
```

## Tailwindcss classes

Add laravel-forms to your tailwind.config.js file.

```javascript
    content: [
        './vendor/fuelviews/laravel-forms/resources/**/*.{js,vue,blade.php}',
    ]
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Thejmitchener](https://github.com/thejmitchener)
- [Fuelviews](https://github.com/fuelviews)
- [All Contributors](../../contributors)

## Support us

Fuelviews is a web development agency based in Portland, Maine. You'll find an overview of all our projects [on our website](https://fuelviews.com).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

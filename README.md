# This is my package laravel-form

Laravel form package for feulviews websites.

## Installation

You can install the package via composer:

```bash
composer require fuelviews/laravel-forms
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-form-config"
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

    'layout' => 'laravel-form::layouts.app',

    'spam_redirects' => [
        'yelp' => 'https://yelp.com',
        'bbb' => 'https://bbb.org',
    ],
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-form-views"
```

## Form Usage (basic)

Include form method type, form method route, spam strap in the start and end of the form, form key, fake submit button, and a real submit button.

```php
<form method="POST" action="{{ route('form.validate') }}"
    <input type="text" name="isSpam" style="display:none" /> // Near the start
    
    <x-laravel-form::meta /> // Near the end
    <input type="hidden" name="form_key" value="free_estimate">
    <input type="text" name="gotcha" class="hidden"/>
    <x-laravel-form::buttons.fake-button :buttonText="'Submit'" />
    <x-laravel-form::buttons.submit-button :buttonText="'Submit'" />
</form
```


## Form Modal Usage (basic)

Include form-modal into your layouts.app.blade.php, trigger with a button.
You can customize which layout blade file is used in the config/forms.php file

```php
<button onclick="Livewire.dispatch('openModal')">Show Modal</button>
@livewire('form-modal')
```

## Tailwindcss classes

Add laravel-form to your tailwind.config.js file.

```javascript
    content: [
        './vendor/fuelviews/laravel-form/resources/**/*.{js,vue,php}',
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

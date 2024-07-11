# Laravel forms package

Laravel forms package

## Installation

You can require the package via composer:

```bash
composer require fuelviews/laravel-forms
```

You can install the package with:

```bash
php artisan forms:install
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="forms-config"
```

This is the contents of the published config file:

```php
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

    'spam_redirects' => [
        'yelp' => 'https://yelp.com',
        'bbb' => 'https://bbb.org',
    ],
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="forms-views"
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
            \Fuelviews\ParameterTagging\Http\Middleware\HandleGclid::class,
            \Fuelviews\ParameterTagging\Http\Middleware\HandleUtm::class,
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
<form method="POST" action="{{ route('forms.validate') }}">
    <input type="text" name="isSpam" style="display:none" />
    
    /* Form fields here */
    
    <x-forms::meta />
    <input type="hidden" name="form_key" value="contact_us" />
    <input type="text" name="gotcha" class="hidden" />
    
    <x-forms::buttons.fake-button :buttonText="'Submit'" />
    <x-forms::buttons.submit-button :buttonText="'Submit'" />
</form>
```

## Form usage example

```bladehtml
    <form method="POST" action="{{ route('forms.validate') }}" class="mt-16">
    <div class="grid grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-2">
        <input type="text" name="_gotcha" style="display:none" />
        <div>
            <label for="firstName" class="block text-sm font-semibold leading-6 text-gray-900">
                First name
            </label>
            <div class="mt-1">
                <input
                    type="text"
                    name="firstName"
                    id="firstName"
                    wire:model="firstName"
                    autocomplete="given-name"
                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    pattern="[A-Za-z]{2,}"
                    title="First name must be at least 2 letters and only contain letters." />
                @error('firstName')
                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div>
            <label for="lastName" class="block text-sm font-semibold leading-6 text-gray-900">
                Last name
            </label>
            <div class="mt-1">
                <input
                    type="text"
                    name="first-name"
                    id="lastName"
                    wire:model="lastName"
                    autocomplete="family-name"
                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    pattern=".{2,}"
                    title="Last name must be at least 2 characters." />
                @error('lastName')
                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">
                Email
            </label>
            <div class="mt-1">
                <input
                    id="email"
                    name="email"
                    type="email"
                    wire:model="email"
                    autocomplete="email"
                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                @error('email')
                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="sm:col-span-2">
            <div class="flex justify-between text-sm leading-6">
                <label for="phone" class="block font-semibold text-gray-900">Phone</label>
            </div>
            <div class="mt-1">
                <input
                    type="tel"
                    name="phone"
                    id="phone"
                    wire:model="phone"
                    autocomplete="tel"
                    aria-describedby="phone-description"
                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    pattern="[\s\d\-\(\)]*?(\d[\s\d\-\(\)]*?){7,11}"
                    title="Phone number must have 7 to 11 digits and may include parentheses, spaces, and hyphens."
                    />
                @error('phone')
                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="sm:col-span-2">
            <div class="flex justify-between text-sm leading-6">
                <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">
                    How can we help you?
                </label>
                <p id="message-description" class="text-gray-400">Max 255 characters</p>
            </div>
            <div class="mt-1">
                <textarea
                    id="message"
                    name="message"
                    wire:model="message"
                    rows="4"
                    aria-describedby="message-description"
                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                @error('message')
                    <span class="flex pl-1 pt-2 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <x-forms::meta />
    <input type="hidden" name="form_key" value="contact_us" />
    <input type="text" name="gotcha" class="hidden" />

    <div class="mt-10 flex justify-end border-t border-gray-900/10 pt-8">
        <x-forms::buttons.fake-button :buttonText="'Submit'" />
        <x-forms::buttons.submit-button :buttonText="'Submit'" />
    </div>
</form>
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
        './vendor/fuelviews/laravel-*/resources/**/*.{js,vue,blade.php}',
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

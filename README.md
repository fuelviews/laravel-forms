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

You can manually publish the config file with:

```bash
php artisan vendor:publish --tag="forms-config"
```

You can publish the view files with:

```bash
php artisan vendor:publish --tag="forms-views"
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

## Form Usage (advanced)

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

    <x-forms::meta />
    <input type="hidden" name="form_key" value="contact_us" />
    <input type="text" name="gotcha" class="hidden" />

    <div class="mt-10 flex justify-end border-t border-gray-900/10 pt-8">
        <x-forms::buttons.fake-button :buttonText="'Submit'" />
        <x-forms::buttons.submit-button :buttonText="'Submit'" />
    </div>
</form>
```

## Form Modal Usage

Include ```forms-modal``` into your ```layouts.app.blade.php``` file, trigger with a button.
You can customize which layout blade file is used in the ```config/forms.php``` file

```php
<button onclick="Livewire.dispatch('openModal')">Show Modal</button>
@livewire('forms-modal')
```

## Tailwindcss classes

Add laravel-forms to your tailwind.config.js file.

```javascript
content: [
    './vendor/fuelviews/laravel-forms/resources/**/*.php'
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
- [Sweatybreeze](https://github.com/sweatybreeze)
- [Fuelviews](https://github.com/fuelviews)
- [All Contributors](../../contributors)

## Support us

Fuelviews is a web development agency based in Portland, Maine. You'll find an overview of all our projects [on our website](https://fuelviews.com).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

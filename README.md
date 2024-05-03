# This is my package laravel-forms

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fuelviews/laravel-forms.svg?style=flat-square)](https://packagist.org/packages/fuelviews/laravel-forms)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/fuelviews/laravel-forms/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/fuelviews/laravel-forms/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/fuelviews/laravel-forms/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/fuelviews/laravel-forms/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/fuelviews/laravel-forms.svg?style=flat-square)](https://packagist.org/packages/fuelviews/laravel-forms)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

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
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-forms-views"
```

## Usage

```php
$laravelForms = new Fuelviews\LaravelForms();
echo $laravelForms->echoPhrase('Hello, Fuelviews!');
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

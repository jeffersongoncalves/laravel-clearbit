<div class="filament-hidden">

![Laravel Clearbit](https://raw.githubusercontent.com/jeffersongoncalves/laravel-clearbit/main/art/jeffersongoncalves-laravel-clearbit.png)

</div>

# Laravel Clearbit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-clearbit.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-clearbit)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-clearbit/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-clearbit/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-clearbit/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-clearbit/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-clearbit.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-clearbit)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-clearbit.svg?style=flat-square)](LICENSE.md)

A PHP/Laravel client for the [Clearbit](https://clearbit.com/) REST APIs. Covers person enrichment, company enrichment, combined lookup, IP reveal, name-to-domain, and prospector search through a simple, typed API built on Laravel's `Http` client.

## Features

- Person: enrich by email (`/v2/people/find`)
- Company: enrich by domain (`/v2/companies/find`)
- Combined: person + company in one call by email (`/v2/combined/find`)
- Reveal: identify a company from an IP address (`/v1/companies/find`)
- Name to Domain: resolve a company name to its domain (`/v1/domains/find`)
- Prospector: search for people at a company by role/seniority/title (`/v1/people/search`)
- Throws `ClearbitException` (with the original API error body) on any non-2xx response
- Throws `InvalidArgumentException` before hitting the API when required criteria are missing

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-clearbit
```

Publish the config file:

```bash
php artisan vendor:publish --tag=clearbit-config
```

Set your Clearbit API key in `.env`:

```env
CLEARBIT_API_KEY=your-api-key
```

Find it under **Settings > API** in your Clearbit dashboard.

## Configuration

```php
// config/clearbit.php
return [
    'api_key' => env('CLEARBIT_API_KEY', ''),
];
```

## Usage

The package is resolved via the `Clearbit` facade or by injecting `JeffersonGoncalves\Clearbit\Clearbit`. Each resource is exposed as a method returning a dedicated resource class.

### Person

```php
use JeffersonGoncalves\Clearbit\Facades\Clearbit;

$person = Clearbit::person()->find('jane@example.com');
```

### Company

```php
$company = Clearbit::company()->find('example.com');
```

### Combined

```php
$combined = Clearbit::combined()->find('jane@example.com');
// $combined['person'], $combined['company']
```

### Reveal

```php
$company = Clearbit::reveal()->find('1.2.3.4');
```

### Name to Domain

```php
$result = Clearbit::nameToDomain()->find('Example Inc.');
// $result['domain']
```

### Prospector

```php
$people = Clearbit::prospector()->search('example.com', [
    'role' => 'engineering',
    'seniority' => 'senior',
    'title' => 'Engineer',
    'page' => 1,
    'page_size' => 10,
]);
```

### Error handling

Any non-2xx API response throws `JeffersonGoncalves\Clearbit\Exceptions\ClearbitException`, which exposes the decoded error body:

```php
use JeffersonGoncalves\Clearbit\Exceptions\ClearbitException;

try {
    Clearbit::person()->find('unknown@example.com');
} catch (ClearbitException $e) {
    logger()->error($e->getMessage(), $e->errorBody());
}
```

Missing required criteria (an empty `email`, `domain`, `ip`, or `name` argument) throw `InvalidArgumentException` before any HTTP call is made.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

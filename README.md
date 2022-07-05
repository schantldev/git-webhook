# Laravel - Git Webhook

[![Latest Version on Packagist](https://img.shields.io/packagist/v/schantldev/git-webhook.svg?style=flat-square)](https://packagist.org/packages/schantldev/git-webhook)
![PHP UNIT](https://github.com/schantldev/git-webhook/actions/workflows/php.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/schantldev/git-webhook.svg?style=flat-square)](https://packagist.org/packages/schantldev/git-webhook)

An easy way to update your application using Github webhooks. No manual deploy required.

This package sets up a route that you can use for your Github webhooks. You can set a secret and define the URL of the route. The pacakge will publish a deploy script that you can customize to fit your needs.

## Installation

You can install the package via composer:

```bash
composer require schantldev/git-webhook
```

After that, publish the files using

```bash
php artisan vendor:publish
```

Ensure the deployment script is executable by running

```bash
chmod +x /storage/git-webhook/git_deploy.sh
```

The package will queue the command and run it in the background. Ensure you have a proper queue (eg. database driver) set up, otherwise the deployment script might not work. 

## Usage

1. Define the webhook URL you want to use in the ``git-webhook.php`` config file
2. Define a secret if necessary
3. Activate the webhook inside your repository settings


## Contributing

Everybody is welcome to contribute towards this git webhook package.

### Security

If you discover any security related issues, please email office@schantl.io instead of using the issue tracker.

## Credits

- [Schantl Web Development & Services](https://github.com/schantldev)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

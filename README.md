# Warrant PHP SDK

Use [Warrant](https://warrant.dev/) in PHP projects.

[![Latest Stable Version](https://poser.pugx.org/warrant-dev/warrant-php/v/stable.svg)](https://packagist.org/packages/warrant-dev/warrant-php)
[![License](https://poser.pugx.org/warrant-dev/warrant-php/license.svg)](https://packagist.org/packages/warrant-dev/warrant-php)
[![Slack](https://img.shields.io/badge/slack-join-brightgreen)](https://join.slack.com/t/warrantcommunity/shared_invite/zt-12g84updv-5l1pktJf2bI5WIKN4_~f4w)

## Installation

Install the SDK using [Composer](https://getcomposer.org/):

```sh
composer require warrant-dev/warrant-php
```

Include the SDK using Composer's autoload:

```php
require_once('vendor/autoload.php');
```

## Usage

Import the Warrant client and pass your API key to the constructor to get started:

```js
$warrant = new \Warrant\Client(
    new \Warrant\Config("api_test_f5dsKVeYnVSLHGje44zAygqgqXiLJBICbFzCiAg1E=")
);

$newUser = $warrant->createUser(new \Warrant\User("my-user-id"));
```

We’ve used a random API key in these code examples. Replace it with your
[actual publishable API keys](https://app.warrant.dev) to
test this code through your own Warrant account.

For more information on how to use the Warrant API, please refer to the
[Warrant API reference](https://docs.warrant.dev).

## Warrant Documentation

- [Warrant Docs](https://docs.warrant.dev/)

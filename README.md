[![CircleCI](https://circleci.com/gh/BrandEmbassy/php-memory.svg?style=svg)](https://circleci.com/gh/BrandEmbassy/php-memory)

# PHP Memory Limit

A simple tool to provide an easy-to-use API to convert memory limit configuration from `php.ini` to bytes.

## Why
Core directive `memory_limit` in `php.ini` is a simple string. An administrator or a programmer can set several valid values, e.g.:
- `500` = 500 bytes
- `128M` = 134 217 728 bytes
- `1G` = 1 073 741 824 bytes

You can obtain the original string value through `ini_get('memory_limit')` function. However, there is no built-in PHP function to provide an easy access to the byte value.

## Installation
Add the package to your `composer.json`:

```
composer require brandembassy/php-memory
```

## Usage
Create the `MemoryLimitProvider `service (or better, inject it using your DI container):
```
$configuration = new \BrandEmbassy\Memory\MemoryConfiguration();
$limitProvider = new \BrandEmbassy\Memory\MemoryLimitProvider($configuration);
```

You can then access the byte value of PHP memory limit like this:
```
$limitInBytes = $memoryLimitProvider->getLimitInBytes();
```

*Any questions or ideas to improve? Feel free to open an issue or send a PR!*

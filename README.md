# AMB Common

Shared PHP library for the Americas Mailbox platform.

## Purpose

`common` contains reusable business/domain code used by the backend, including:

- shipping event helpers and interactors
- SQL builders and transformers
- notifications, messaging, and utility classes

It is consumed primarily by the `api` codebase as the Composer package `amb/common`.

## Tech Stack

- PHP library
- Composer package
- Main namespace: `AMB\\`

## Setup

From the `common` directory:

```bash
composer install
composer dump-autoload
```

## Validate

Basic validation:

```bash
composer validate
composer dump-autoload
```

If test dependencies are installed, run:

```bash
php vendor\bin\codecept run unit
php vendor\bin\codecept run functional
```

Note: functional tests may require additional database-backed test setup.

## Project Role

This repository is a shared library, not a standalone web application.  
It is part of the overall Americas Mailbox architecture:

- `api` - PHP backend service layer
- `common` - shared PHP domain/library code
- `apps` - React/Nx frontend monorepo

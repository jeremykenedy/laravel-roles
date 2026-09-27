# Laravel Roles documentation

Full reference for [jeremykenedy/laravel-roles](https://github.com/jeremykenedy/laravel-roles).
The [project readme](../readme.md) covers the quick start; these pages go into detail.

## Getting started

| Page | What it covers |
| :--- | :--- |
| [Installation](installation.md) | Composer, the service provider, the trait, migrations |
| [Configuration](configuration.md) | Every config key and the environment variable behind it |
| [Seeding](seeding.md) | The bundled seeders, publishing them, and the optional auto registration |

## Using roles and permissions

| Page | What it covers |
| :--- | :--- |
| [Roles](roles.md) | Creating, attaching, detaching, syncing, and checking roles |
| [Permissions](permissions.md) | Role permissions, direct user permissions, and entity checks |
| [Levels and inheritance](levels-and-inheritance.md) | How `level()` works and what inheritance changes |
| [Blade and middleware](blade-and-middleware.md) | The four Blade directives and the three route middleware |

## The optional interfaces

| Page | What it covers |
| :--- | :--- |
| [GUI](gui.md) | Turning the CRUD interface on and choosing a CSS framework |
| [Artisan commands](artisan-commands.md) | `roles:install`, `roles:update`, and `roles:switch` |
| [API](api.md) | The optional JSON endpoints |

## Working on the package

| Page | What it covers |
| :--- | :--- |
| [Testing](testing.md) | Running the suite and what it covers |
| [Upgrading](upgrading.md) | Notes for moving between versions |

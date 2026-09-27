# Installation

## Requirements

| Requirement | Version |
| :--- | :--- |
| PHP | 7.2 or newer |
| Laravel | 5.3 through 13 |

The package is tested in CI against PHP 8.2 through 8.4 on Laravel 12 and 13.
Older combinations remain supported by the constraints in `composer.json` but
are not exercised by the build.

## Composer

```bash
composer require jeremykenedy/laravel-roles
```

## Service provider

Laravel discovers the provider automatically. If you have package discovery
turned off, register it yourself in `config/app.php`:

```php
'providers' => [
    jeremykenedy\LaravelRoles\RolesServiceProvider::class,
],
```

## The trait

Add `HasRoleAndPermission` to the model your `auth.providers.users.model`
points at:

```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use HasRoleAndPermission;
}
```

Without the trait the role and permission methods do not exist on your user
model and calls such as `$user->hasRole('admin')` fail.

## Migrations

The package ships five migrations: `roles`, `role_user`, `permissions`,
`permission_role` and `permission_user`. You can run them straight from the
package or publish them first.

Run them from the package by turning them on:

```dotenv
ROLES_MIGRATION_DEFAULT_ENABLED=true
```

```bash
php artisan migrate
```

Or publish them and keep them under your own version control:

```bash
php artisan vendor:publish --tag=laravelroles-migrations
php artisan migrate
```

Each migration checks for its table before creating it, so publishing and then
leaving `ROLES_MIGRATION_DEFAULT_ENABLED` on does not fail. The shipped
migrations use anonymous classes, so they do not collide with published copies.

## Publishing

```bash
php artisan vendor:publish --tag=laravelroles
```

That tag covers the config, the migrations and the seeders. The individual
tags are listed in [configuration](configuration.md#publishing).

## Next

- [Configuration](configuration.md)
- [Seeding](seeding.md)
- [Roles](roles.md)

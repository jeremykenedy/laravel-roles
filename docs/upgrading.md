# Upgrading

## Within the current major

Upgrading does not change how an existing install looks or behaves. The
Bootstrap 4 views remain the default and are unchanged, every public method
keeps its name and signature, and route names and URIs are the same.

Two things are worth knowing.

### Custom table names now work

The relations and queries used to ignore some of the configured table names and
query the default ones instead. If you set `ROLES_PERMISSION_USER_DATABASE_TABLE`
or `ROLES_PERMISSION_ROLE_DATABASE_TABLE` to something custom, the package was
querying tables that did not exist. It now uses what you configured. Nothing
changes for the default names.

### The seeder hand off moved

`eklundkristoffer/seedster` is no longer required. The `defaultSeeds` options
now expect `jeremykenedy/laravel-seedster`, which supports current Laravel
versions and exposes the same `seed.handler` binding.

If you rely on `defaultSeeds`, add it:

```bash
composer require jeremykenedy/laravel-seedster
```

If you publish the seeders and call them from your own `DatabaseSeeder`, which
is what the documentation has always shown, nothing changes.

## Coming from Laravel 11 or earlier

The GUI could not run on Laravel 11, 12 or 13. Its controllers extended the
application's base controller, which stopped providing a `middleware()` method
in Laravel 11, so every GUI route failed. They now extend Illuminate's
controller, which has carried that method since 5.x. If you turned the GUI off
because it broke, it works again.

## Choosing a CSS framework

Nothing is required. `bootstrap4` stays the default. When you want to move:

```bash
php artisan roles:switch --css=bootstrap5
```

If you published the views, republish them for the framework you moved to, or
the old markup keeps rendering:

```bash
php artisan vendor:publish --tag=laravelroles-views-bootstrap5 --force
```

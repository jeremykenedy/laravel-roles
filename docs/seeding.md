# Seeding

## What the seeders create

| Seeder | Creates |
| :--- | :--- |
| `DefaultPermissionsTableSeeder` | `view.users`, `create.users`, `edit.users`, `delete.users` |
| `DefaultRolesTableSeeder` | Admin (level 5), User (level 1), Unverified (level 0) |
| `DefaultConnectRelationshipsSeeder` | Attaches every permission to the Admin role |
| `DefaultUsersTableSeeder` | An example user |

All of them check for existing rows first, so running them twice does not
duplicate anything.

## Publishing and calling them

This is the path that needs nothing extra.

```bash
php artisan vendor:publish --tag=laravelroles-seeds
```

Then call them from your own `DatabaseSeeder`:

```php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeders\ConnectRelationshipsSeeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);

        Model::reguard();
    }
}
```

```bash
composer dump-autoload
php artisan db:seed
```

## Running the shipped seeders without publishing

You can call the package's own seeders by class:

```bash
php artisan db:seed --class="jeremykenedy\LaravelRoles\Database\Seeders\DefaultPermissionsTableSeeder"
php artisan db:seed --class="jeremykenedy\LaravelRoles\Database\Seeders\DefaultRolesTableSeeder"
php artisan db:seed --class="jeremykenedy\LaravelRoles\Database\Seeders\DefaultConnectRelationshipsSeeder"
```

## Automatic registration

The `defaultSeeds` config options register the shipped seeders with `db:seed`
so they run without being named. That hand off needs a `seed.handler` binding,
which the package does not provide itself. Install the optional package to get
it:

```bash
composer require jeremykenedy/laravel-seedster
```

With it installed, and the `defaultSeeds` options on, `php artisan db:seed`
runs the registered seeders as well as your own `DatabaseSeeder`.

Without it, the `defaultSeeds` options do nothing and you should use one of the
two approaches above instead.

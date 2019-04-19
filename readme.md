# Laravel Roles

[![Total Downloads](https://poser.pugx.org/jeremykenedy/laravel-roles/d/total.svg)](https://packagist.org/packages/jeremykenedy/laravel-roles)
[![Latest Stable Version](https://poser.pugx.org/jeremykenedy/laravel-roles/v/stable.svg)](https://packagist.org/packages/jeremykenedy/laravel-roles)
[![Travis-CI Build Status](https://travis-ci.org/jeremykenedy/laravel-roles.svg?branch=master)](https://travis-ci.org/jeremykenedy/laravel-roles)
[![Scrutinizer-CI Build Status](https://scrutinizer-ci.com/g/jeremykenedy/laravel-roles/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jeremykenedy/laravel-roles/build-status/master)
[![StyleCI](https://github.styleci.io/repos/82768379/shield?branch=master)](https://github.styleci.io/repos/82768379)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jeremykenedy/laravel-roles/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jeremykenedy/laravel-roles/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/jeremykenedy/laravel-roles/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
<a href="https://www.patreon.com/bePatron?u=10119959" title="Become a Patreon">
    <img src="https://c5.patreon.com/external/logo/become_a_patron_button.png" alt="Become a Patreon" width="85px" > 
</a>

#### Table of contents
- [About](#about)
- [Installation](#installation)
    - [Composer](#composer)
    - [Service Provider](#service-provider)
    - [Publish All Assets](#publish-all-assets)
    - [Publish Specific Assets](#publish-specific-assets)
    - [HasRoleAndPermission Trait And Contract](#hasroleandpermission-trait-and-contract)
    - [Migrations and Seeds](#migrations-and-seeds)
    - [Migrate from Bican roles](#Migrate-from-bican-roles)
- [Usage](#usage)
    - [Creating Roles](#creating-roles)
    - [Attaching, Detaching and Syncing Roles](#attaching-detaching-and-syncing-roles)
    - [Assign a user role to new registered users](#assign-a-user-role-to-new-registered-users)
    - [Checking For Roles](#checking-for-roles)
    - [Levels](#levels)
    - [Creating Permissions](#creating-permissions)
    - [Attaching, Detaching and Syncing Permissions](#attaching-detaching-and-syncing-permissions)
    - [Checking For Permissions](#checking-for-permissions)
    - [Permissions Inheriting](#permissions-inheriting)
    - [Entity Check](#entity-check)
    - [Blade Extensions](#blade-extensions)
    - [Middleware](#middleware)
- [Configuration](#configuration)
    - [Environment File](#environment-file)
- [More Information](#more-information)
- [File Tree](#file-tree)
- [Opening an Issue](#opening-an-issue)
- [License](#license)

### About
A Powerful package for handling roles and permissions in Laravel.
Supports Laravel 5.3, 5.4, 5.5, 5.6, 5.7 and 5.8.

## Installation
This package is very easy to set up. There are only couple of steps.

### Composer
From your projects root folder in terminal run:

Laravel 5.8 and up use:

```
    composer require jeremykenedy/laravel-roles
```

Laravel 5.7 and below use:

```
    composer require jeremykenedy/laravel-roles:1.4.0
```

* Note: The major difference is that Laravel's users table migration out the box changed from `$table->increments('id');` to `$table->bigIncrements('id');` in Laravel 5.8.

### Service Provider
* Laravel 5.5 and up
Uses package auto discovery feature, no need to edit the `config/app.php` file.

* Laravel 5.4 and below
Add the package to your application service providers in `config/app.php` file.

```php
'providers' => [

    ...

    /**
     * Third Party Service Providers...
     */
    jeremykenedy\LaravelRoles\RolesServiceProvider::class,

],
```

### Publish All Assets
```bash
    php artisan vendor:publish --tag=laravelroles
```

### Publish Specific Assets
```bash
    php artisan vendor:publish --tag=laravelroles-config
    php artisan vendor:publish --tag=laravelroles-migrations
    php artisan vendor:publish --tag=laravelroles-seeds
```

### HasRoleAndPermission Trait And Contract

1. Include `HasRoleAndPermission` trait and also implement `HasRoleAndPermission` contract inside your `User` model. See example below.

2. Include `use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;` in the top of your `User` model below the namespace and implement the `HasRoleAndPermission` trait. See example below.

Example `User` model Trait And Contract:

```php

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;

    // rest of your model ...
}

```

### Migrations and seeds
> This uses the default users table which is in Laravel. You should already have the migration file for the users table available and migrated.

1. Setup the needed tables:

    `php artisan migrate`

2. Update `database\seeds\DatabaseSeeder.php` to include the seeds. See example below.


```php
<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

            $this->call('PermissionsTableSeeder');
            $this->call('RolesTableSeeder');
            $this->call('ConnectRelationshipsSeeder');
            //$this->call('UsersTableSeeder');

        Model::reguard();
    }
}

```

3. Seed an initial set of Permissions, Roles, and Users with roles.

```bash
composer dump-autoload
php artisan db:seed
```

#### Roles Seeded
|Property|Value|
|----|----|
|Name| Admin|
|Slug| admin|
|Description| Admin Role|
|Level| 5|

|Property|Value|
|----|----|
|Name| User|
|Slug| user|
|Description| User Role|
|Level| 1|

|Property|Value|
|----|----|
|Name| Unverified|
|Slug| unverified|
|Description| Unverified Role|
|Level| 0|

#### Permissions Seeded:
|Property|Value|
|----|----|
|name|Can View Users|
|slug|view.users|
|description|Can view users|
|model|Permission|

|Property|Value|
|----|----|
|name|Can Create Users|
|slug|create.users|
|description|Can create new users|
|model|Permission|

|Property|Value|
|----|----|
|name|Can Edit Users|
|slug|edit.users|
|description|Can edit users|
|model|Permission|

|Property|Value|
|----|----|
|name|Can Delete Users|
|slug|delete.users|
|description|Can delete users|
|model|Permission|


### And that's it!

---

## Migrate from bican roles
If you migrate from bican/roles to jeremykenedy/LaravelRoles you will need to update a few things.
- Change all calls to `can`, `canOne` and `canAll` to `hasPermission`, `hasOnePermission`, `hasAllPermissions`.
- Change all calls to `is`, `isOne` and `isAll` to `hasRole`, `hasOneRole`, `hasAllRoles`.

---

## Usage

### Creating Roles

```php
$adminRole = config('roles.models.role')::create([
    'name' => 'Admin',
    'slug' => 'admin',
    'description' => '',
    'level' => 5,
]);

$moderatorRole = config('roles.models.role')::create([
    'name' => 'Forum Moderator',
    'slug' => 'forum.moderator',
]);
```

> Because of `Slugable` trait, if you make a mistake and for example leave a space in slug parameter, it'll be replaced with a dot automatically, because of `str_slug` function.

### Attaching, Detaching and Syncing Roles

It's really simple. You fetch a user from database and call `attachRole` method. There is `BelongsToMany` relationship between `User` and `Role` model.

```php
$user = config('roles.defaultUserModel')::find($id);

$user->attachRole($adminRole); // you can pass whole object, or just an id
$user->detachRole($adminRole); // in case you want to detach role
$user->detachAllRoles(); // in case you want to detach all roles
$user->syncRoles($roles); // you can pass Eloquent collection, or just an array of ids
```

### Assign a user role to new registered users

You can assign the user a role upon the users registration by updating the file `app\Http\Controllers\Auth\RegisterController.php`.
You can assign a role to a user upon registration by including the needed models and modifying the `create()` method to attach a user role. See example below:

* Updated `create()` method of `app\Http\Controllers\Auth\RegisterController.php`:

```php
    protected function create(array $data)
    {
        $user = config('roles.defaultUserModel')::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $role = config('roles.models.role')::where('name', '=', 'User')->first();  //choose the default role upon user creation.
        $user->attachRole($role);

        return $user;

    }
```

### Checking For Roles

You can now check if the user has required role.

```php
if ($user->hasRole('admin')) { // you can pass an id or slug
    //
}
```

You can also do this:

```php
if ($user->isAdmin()) {
    //
}
```

And of course, there is a way to check for multiple roles:

```php
if ($user->hasRole(['admin', 'moderator'])) {
    /*
    | Or alternatively:
    | $user->hasRole('admin, moderator'), $user->hasRole('admin|moderator'),
    | $user->hasOneRole('admin, moderator'), $user->hasOneRole(['admin', 'moderator']), $user->hasOneRole('admin|moderator')
    */

    // The user has at least one of the roles
}

if ($user->hasRole(['admin', 'moderator'], true)) {
    /*
    | Or alternatively:
    | $user->hasRole('admin, moderator', true), $user->hasRole('admin|moderator', true),
    | $user->hasAllRoles('admin, moderator'), $user->hasAllRoles(['admin', 'moderator']), $user->hasAllRoles('admin|moderator')
    */

    // The user has all roles
}
```

### Levels

When you are creating roles, there is optional parameter `level`. It is set to `1` by default, but you can overwrite it and then you can do something like this:

```php
if ($user->level() > 4) {
    //
}
```

> If user has multiple roles, method `level` returns the highest one.

`Level` has also big effect on inheriting permissions. About it later.

### Creating Permissions

It's very simple thanks to `Permission` model called from `config('roles.models.permission')`.

```php

$createUsersPermission = config('roles.models.permission')::create([
    'name' => 'Create users',
    'slug' => 'create.users',
    'description' => '', // optional
]);

$deleteUsersPermission = config('roles.models.permission')::create([
    'name' => 'Delete users',
    'slug' => 'delete.users',
]);
```

### Attaching, Detaching and Syncing Permissions

You can attach permissions to a role or directly to a specific user (and of course detach them as well).

```php
$role = config('roles.models.role')::find($roleId);
$role->attachPermission($createUsersPermission); // permission attached to a role

$user = config('roles.defaultUserModel')::find($userId);
$user->attachPermission($deleteUsersPermission); // permission attached to a user
```

```php
$role->detachPermission($createUsersPermission); // in case you want to detach permission
$role->detachAllPermissions(); // in case you want to detach all permissions
$role->syncPermissions($permissions); // you can pass Eloquent collection, or just an array of ids

$user->detachPermission($deleteUsersPermission);
$user->detachAllPermissions();
$user->syncPermissions($permissions); // you can pass Eloquent collection, or just an array of ids
```

### Checking For Permissions

```php
if ($user->hasPermission('create.users')) { // you can pass an id or slug
    //
}

if ($user->canDeleteUsers()) {
    //
}
```

You can check for multiple permissions the same way as roles. You can make use of additional methods like `hasOnePermission` or `hasAllPermissions`.

### Permissions Inheriting

Role with higher level is inheriting permission from roles with lower level.

There is an example of this `magic`:

You have three roles: `user`, `moderator` and `admin`. User has a permission to read articles, moderator can manage comments and admin can create articles. User has a level 1, moderator level 2 and admin level 3. It means, moderator and administrator has also permission to read articles, but administrator can manage comments as well.

> If you don't want permissions inheriting feature in you application, simply ignore `level` parameter when you're creating roles.

### Entity Check

Let's say you have an article and you want to edit it. This article belongs to a user (there is a column `user_id` in articles table).

```php
use App\Article;

$editArticlesPermission = config('roles.models.permission')::create([
    'name' => 'Edit articles',
    'slug' => 'edit.articles',
    'model' => 'App\Article',
]);

$user->attachPermission($editArticlesPermission);

$article = Article::find(1);

if ($user->allowed('edit.articles', $article)) { // $user->allowedEditArticles($article)
    //
}
```

This condition checks if the current user is the owner of article. If not, it will be looking inside user permissions for a row we created before.

```php
if ($user->allowed('edit.articles', $article, false)) { // now owner check is disabled
    //
}
```

### Blade Extensions

There are four Blade extensions. Basically, it is replacement for classic if statements.

```php
@role('admin') // @if(Auth::check() && Auth::user()->hasRole('admin'))
    // user has admin role
@endrole

@permission('edit.articles') // @if(Auth::check() && Auth::user()->hasPermission('edit.articles'))
    // user has edit articles permissison
@endpermission

@level(2) // @if(Auth::check() && Auth::user()->level() >= 2)
    // user has level 2 or higher
@endlevel

@allowed('edit', $article) // @if(Auth::check() && Auth::user()->allowed('edit', $article))
    // show edit button
@endallowed

@role('admin|moderator', true) // @if(Auth::check() && Auth::user()->hasRole('admin|moderator', true))
    // user has admin and moderator role
@else
    // something else
@endrole
```

### Middleware
This package comes with `VerifyRole`, `VerifyPermission` and `VerifyLevel` middleware.
The middleware aliases are already registered in `\jeremykenedy\LaravelRoles\RolesServiceProvider` as of 1.7.
You can optionally add them inside your `app/Http/Kernel.php` file with your own aliases like outlined below:

```php
/**
 * The application's route middleware.
 *
 * @var array
 */
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    'role'          => \jeremykenedy\LaravelRoles\Middleware\VerifyRole::class,
    'permission'    => \jeremykenedy\LaravelRoles\Middleware\VerifyPermission::class,
    'level'         => \jeremykenedy\LaravelRoles\Middleware\VerifyLevel::class,
];
```

Now you can easily protect your routes.

```php
Route::get('/', function () {
    //
})->middleware('role:admin');

Route::get('/', function () {
    //
})->middleware('permission:edit.articles');

Route::get('/', function () {
    //
})->middleware('level:2'); // level >= 2

Route::get('/', function () {
    //
})->middleware('role:admin', 'level:2'); // level >= 2 and Admin

Route::group(['middleware' => ['role:admin']], function () {
    //
});

```

It throws `\jeremykenedy\LaravelRoles\Exceptions\RoleDeniedException`, `\jeremykenedy\LaravelRoles\Exceptions\PermissionDeniedException` or `\jeremykenedy\LaravelRoles\Exceptions\LevelDeniedException` exceptions if it goes wrong.

You can catch these exceptions inside `app/Exceptions/Handler.php` file and do whatever you want.

```php
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        $userLevelCheck = $exception instanceof \jeremykenedy\LaravelRoles\Exceptions\RoleDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\Exceptions\RoleDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\Exceptions\PermissionDeniedException ||
            $exception instanceof \jeremykenedy\LaravelRoles\Exceptions\LevelDeniedException;

        if ($userLevelCheck) {

            if ($request->expectsJson()) {
                return Response::json(array(
                    'error'    =>  403,
                    'message'   =>  'Unauthorized.'
                ), 403);
            }

            abort(403);
        }

        return parent::render($request, $exception);
    }
```

---

## Configuration
* You can change connection for models, slug separator, models path and there is also a handy pretend feature.
* There are many configurable options which have been extended to be able to configured via `.env` file variables.
* Editing the configuration file directly may not needed becuase of this.
* See config file: [roles.php](https://github.com/jeremykenedy/laravel-roles/blob/master/config/roles.php).

```php

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Package Connection
    |--------------------------------------------------------------------------
    |
    | You can set a different database connection for this package. It will set
    | new connection for models Role and Permission. When this option is null,
    | it will connect to the main database, which is set up in database.php
    |
    */

    'connection' => null,

    /*
    |--------------------------------------------------------------------------
    | Slug Separator
    |--------------------------------------------------------------------------
    |
    | Here you can change the slug separator. This is very important in matter
    | of magic method __call() and also a `Slugable` trait. The default value
    | is a dot.
    |
    */

    'separator' => '.',

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | If you want, you can replace default models from this package by models
    | you created. Have a look at `jeremykenedy\LaravelRoles\Models\Role` model and
    | `jeremykenedy\LaravelRoles\Models\Permission` model.
    |
    */

    'models' => [
        'role'       => jeremykenedy\LaravelRoles\Models\Role::class,
        'permission' => jeremykenedy\LaravelRoles\Models\Permission::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles, Permissions and Allowed "Pretend"
    |--------------------------------------------------------------------------
    |
    | You can pretend or simulate package behavior no matter what is in your
    | database. It is really useful when you are testing you application.
    | Set up what will methods hasRole(), hasPermission() and allowed() return.
    |
    */

    'pretend' => [

        'enabled' => false,

        'options' => [
            'hasRole'       => true,
            'hasPermission' => true,
            'allowed'       => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel Default User Model
    |--------------------------------------------------------------------------
    |
    | This is the applications default user model.
    |
    */

    'defaultUserModel' => env('ROLES_DEFAULT_USER_MODEL', config('auth.providers.users.model')),

    /*
    |--------------------------------------------------------------------------
    | Default Seeds
    |--------------------------------------------------------------------------
    |
    | These are the default package seeds. You can seed the package built
    | in seeds without having to seed them. These seed directly from
    | the package. These are not the published seeds.
    |
    */

    'defaultSeeds' => [
        'PermissionsTableSeeder'        => env('ROLES_SEED_DEFAULT_PERMISSIONS', true),
        'RolesTableSeeder'              => env('ROLES_SEED_DEFAULT_ROLES', true),
        'ConnectRelationshipsSeeder'    => env('ROLES_SEED_DEFAULT_RELATIONSHIPS', true),
        'UsersTableSeeder'              => env('ROLES_SEED_DEFAULT_USERS', false),
    ],
];


```

### Environment File
```
# Default User Model
ROLES_DEFAULT_USER_MODEL=App\User

# Roles Database Seeder Settings
ROLES_SEED_DEFAULT_PERMISSIONS=true
ROLES_SEED_DEFAULT_ROLES=true
ROLES_SEED_DEFAULT_RELATIONSHIPS=true
ROLES_SEED_DEFAULT_USERS=false
```

## More Information
For more information, please have a look at [HasRoleAndPermission](https://github.com/jeremykenedy/laravel-roles/blob/master/src/Contracts/HasRoleAndPermission.php) contract.

## File Tree
```bash
├── .env.example
├── .gitignore
├── LICENSE
├── composer.json
├── config
│   └── roles.php
├── readme.md
└── src
    ├── Contracts
    │   ├── HasRoleAndPermission.php
    │   ├── PermissionHasRelations.php
    │   └── RoleHasRelations.php
    ├── Database
    │   ├── Migrations
    │   │   ├── 2016_01_15_105324_create_roles_table.php
    │   │   ├── 2016_01_15_114412_create_role_user_table.php
    │   │   ├── 2016_01_26_115212_create_permissions_table.php
    │   │   ├── 2016_01_26_115523_create_permission_role_table.php
    │   │   └── 2016_02_09_132439_create_permission_user_table.php
    │   └── Seeds
    │       ├── DefaultConnectRelationshipsSeeder.php
    │       ├── DefaultPermissionsTableSeeder.php
    │       ├── DefaultRolesTableSeeder.php
    │       ├── DefaultUsersTableSeeder.php
    │       └── publish
    │           ├── ConnectRelationshipsSeeder.php
    │           ├── PermissionsTableSeeder.php
    │           ├── RolesTableSeeder.php
    │           └── UsersTableSeeder.php
    ├── Exceptions
    │   ├── AccessDeniedException.php
    │   ├── LevelDeniedException.php
    │   ├── PermissionDeniedException.php
    │   └── RoleDeniedException.php
    ├── Middleware
    │   ├── VerifyLevel.php
    │   ├── VerifyPermission.php
    │   └── VerifyRole.php
    ├── Models
    │   ├── Permission.php
    │   └── Role.php
    ├── RolesFacade.php
    ├── RolesServiceProvider.php
    └── Traits
        ├── HasRoleAndPermission.php
        ├── PermissionHasRelations.php
        ├── RoleHasRelations.php
        └── Slugable.php
```

* Tree command can be installed using brew: `brew install tree`
* File tree generated using command `tree -a -I '.git|node_modules|vendor|storage|tests'`

## Opening an Issue
Before opening an issue there are a couple of considerations:
* A **star** on this project shows support and is way to say thank you to all the contributors. If you open an issue without a star, *your issue may be closed without consideration.* Thank you for understanding and the support. You are all awesome!
* **Read the instructions** and make sure all steps were *followed correctly*.
* **Check** that the issue is not *specific to your development environment* setup.
* **Provide** *duplication steps*.
* **Attempt to look into the issue**, and if you *have a solution, make a pull request*.
* **Show that you have made an attempt** to *look into the issue*.
* **Check** to see if the issue you are *reporting is a duplicate* of a previous reported issue.
* **Following these instructions show me that you have tried.**
* If you have a questions send me an email to jeremykenedy@gmail.com
* Need some help, I can do my best on Slack: https://opensourcehelpgroup.slack.com
* Please be considerate that this is an open source project that I provide to the community for FREE when opening an issue. 

#### Credit Note
This package is an adaptation of [romanbican/roles](https://github.com/romanbican/roles) and [ultraware/roles](https://github.com/ultraware/roles/).

## License
This package is free software distributed under the terms of the [MIT license](https://opensource.org/licenses/MIT). Enjoy!

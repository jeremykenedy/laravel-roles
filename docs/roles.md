# Roles

A role has a name, a unique slug, an optional description and a numeric level.
Slugs are generated with the configured separator, so `Content Editor` becomes
`content.editor` by default.

## Creating

```php
use jeremykenedy\LaravelRoles\Models\Role;

$admin = Role::create([
    'name'        => 'Admin',
    'slug'        => 'admin',
    'description' => 'Full access',
    'level'       => 5,
]);
```

The `level` drives [inheritance](levels-and-inheritance.md) and
`$user->level()`.

## Attaching and detaching

```php
$user->attachRole($admin);      // a model or an id
$user->detachRole($admin);
$user->detachAllRoles();
```

`attachRole()` returns `true` without touching the database when the user
already has the role.

## Syncing

```php
$user->syncRoles([$admin->id, $editor->id]);
```

`syncRoles()` replaces the whole set, so anything not in the array is removed.

## Checking

```php
$user->hasRole('admin');
$user->hasRole($admin->id);
```

A list checks for any of the roles:

```php
$user->hasRole('admin,editor');
$user->hasRole('admin|editor');
$user->hasRole(['admin', 'editor']);
```

Pass `true` as the second argument to require all of them:

```php
$user->hasRole('admin,editor', true);
```

`hasOneRole()` and `hasAllRoles()` are the explicit forms if you prefer them.

## Magic methods

Any `is` prefixed call is turned into a role check against the snake cased
remainder, joined with the configured separator:

```php
$user->isAdmin();          // hasRole('admin')
$user->isContentEditor();  // hasRole('content.editor')
```

An unknown method that does not match `is`, `can` or `allowed` throws
`BadMethodCallException`.

## Reading roles

```php
$user->getRoles();   // a collection, cached on the instance
$user->roles;        // the relation
```

`getRoles()` caches on the model, so repeated checks in one request do not
re-query. Attaching, detaching or syncing clears that cache.

Eager load when working with a collection of users:

```php
$users = User::with('roles')->get();
```

## Role relations

```php
$role->users;          // users with this role
$role->permissions;    // permissions on this role

$role->attachPermission($permission);
$role->detachPermission($permission);
$role->detachAllPermissions();
$role->syncPermissions([$permission->id]);
```

## Soft deletes

Roles are soft deleted. A soft deleted role stops granting its permissions
immediately. `Role::onlyTrashed()` lists them and the GUI exposes restore and
force delete.

## Next

- [Permissions](permissions.md)
- [Levels and inheritance](levels-and-inheritance.md)

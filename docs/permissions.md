# Permissions

A permission has a name, a unique slug, an optional description and a `model`
field used by [entity checks](#entity-checks).

## Creating

```php
use jeremykenedy\LaravelRoles\Models\Permission;

$permission = Permission::create([
    'name'        => 'Can Edit Users',
    'slug'        => 'edit.users',
    'description' => 'Can edit users',
    'model'       => 'Permission',
]);
```

## Two routes to a permission

A user gets a permission either through a role or directly.

```php
$role->attachPermission($permission);   // everyone with the role
$user->attachPermission($permission);   // this user only
```

`getPermissions()` returns both sets merged.

## Attaching and detaching directly

```php
$user->attachPermission($permission);
$user->detachPermission($permission);
$user->detachAllPermissions();
$user->syncPermissions([$permission->id]);
```

## Checking

```php
$user->hasPermission('edit.users');
$user->hasPermission('edit.users,delete.users');        // any
$user->hasPermission('edit.users,delete.users', true);  // all
```

`hasOnePermission()` and `hasAllPermissions()` are the explicit forms.

## Magic methods

A `can` prefixed call becomes a permission check:

```php
$user->canEditUsers();   // hasPermission('edit.users')
```

## Entity checks

`allowed()` answers whether a user may act on a specific model.

```php
$user->allowed('edit.articles', $article);
```

It returns `true` when either of these holds:

1. The user owns the entity. Ownership is `$article->user_id === $user->id`.
2. The user holds a permission whose `model` matches the entity's class and
   whose slug or id matches what you passed.

Change the ownership column, or turn ownership off entirely:

```php
$user->allowed('edit.articles', $article, true, 'author_id');
$user->allowed('edit.articles', $article, false);
```

For the ownership shortcut to be useful the permission's `model` must be the
fully qualified class name of the entity:

```php
Permission::create([
    'name'  => 'Can Edit Articles',
    'slug'  => 'edit.articles',
    'model' => \App\Models\Article::class,
]);
```

There is a magic form too:

```php
$user->allowedEditArticles($article);
```

## Reading permissions

```php
$user->getPermissions();   // merged, cached on the instance
```

The merged result is cached on the model. Attaching, detaching or syncing
clears it.

### Avoiding extra queries

`getPermissions()` reads the `userPermissions` relation when it has already
been loaded, so eager load it alongside roles when iterating a collection:

```php
$users = User::with('roles', 'userPermissions')->get();
```

The role side is resolved through a query builder rather than a relation, so
one query per model remains for the role permissions.

## Soft deletes

Permissions are soft deleted, and a permission on a soft deleted role stops
being granted straight away.

## Next

- [Levels and inheritance](levels-and-inheritance.md)
- [Blade and middleware](blade-and-middleware.md)

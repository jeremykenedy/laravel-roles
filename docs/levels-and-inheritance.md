# Levels and inheritance

## Levels

Every role carries an integer `level`. A user's level is the highest level
among the roles they hold:

```php
$user->attachRole($unverified);  // level 0
$user->level();                  // 0

$user->attachRole($admin);       // level 5
$user->level();                  // 5
```

A user with no roles is level `0`.

Levels are useful for coarse checks that do not deserve their own permission:

```php
if ($user->level() >= 5) {
    // ...
}
```

The `level` middleware and the `@level` Blade directive both compare against
this value.

## Inheritance

With `inheritance` enabled, which is the default, a role inherits every
permission belonging to roles at a **lower** level.

```dotenv
ROLES_INHERITANCE=true
```

Given:

| Role | Level | Permission |
| :--- | :--- | :--- |
| Editor | 3 | `publish.posts` |
| Admin | 5 | none of its own |

An Admin passes `hasPermission('publish.posts')` because level 5 is above
level 3, even though the permission was never attached to the Admin role.

Turn it off to make permissions strictly explicit:

```dotenv
ROLES_INHERITANCE=false
```

With it off, the Admin above holds no permissions at all.

## What inheritance does not do

Inheritance works on permissions, not on roles. A level 5 user does not pass
`hasRole('editor')` just because Editor sits lower. Role checks are always
literal.

## Soft deleted roles

Permissions belonging to a soft deleted role are excluded from both the direct
and the inherited branch, so deleting a role revokes its permissions at once.

## Next

- [Blade and middleware](blade-and-middleware.md)

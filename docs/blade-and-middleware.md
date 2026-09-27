# Blade directives and middleware

## Blade directives

Four directives are registered. Each checks the authenticated user and renders
nothing for guests.

```blade
@role('admin')
    Only an admin sees this.
@endrole

@permission('edit.users')
    Only someone who can edit users sees this.
@endpermission

@level(5)
    Only level 5 and above sees this.
@endlevel

@allowed('edit.articles', $article)
    Only someone allowed to edit this article sees this.
@endallowed
```

`@role` and `@permission` take the same arguments as `hasRole()` and
`hasPermission()`, so lists work:

```blade
@role('admin,editor')
```

Blade needs whitespace or a newline before a directive. `text@endrole` on one
line is not recognised as a directive by Blade itself.

## Route middleware

Three aliases are registered unless `route_middlewares` is set to `false`.

| Alias | Checks | Throws |
| :--- | :--- | :--- |
| `role` | `hasRole()` | `RoleDeniedException` |
| `permission` | `hasPermission()` | `PermissionDeniedException` |
| `level` | `level()` is at or above the argument | `LevelDeniedException` |

```php
Route::get('/admin', fn () => view('admin'))->middleware('role:admin');
Route::get('/users/edit', fn () => view('edit'))->middleware('permission:edit.users');
Route::get('/reports', fn () => view('reports'))->middleware('level:5');
```

Several values act as "any of":

```php
Route::get('/panel', ...)->middleware('role:admin,editor');
```

Guests are denied the same way an authenticated user without the role is.

## Handling the exceptions

All three extend `AccessDeniedException`. Render them how you like.

On Laravel 11 and newer, in `bootstrap/app.php`:

```php
use jeremykenedy\LaravelRoles\App\Exceptions\AccessDeniedException;

->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (AccessDeniedException $e) {
        return redirect()->route('home')->with('error', $e->getMessage());
    });
})
```

On Laravel 10 and older, in `app/Exceptions/Handler.php`:

```php
public function render($request, Throwable $exception)
{
    if ($exception instanceof AccessDeniedException) {
        return redirect()->route('home')->with('error', $exception->getMessage());
    }

    return parent::render($request, $exception);
}
```

Without a handler the exceptions surface as a 500.

## Next

- [GUI](gui.md)

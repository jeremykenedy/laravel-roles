# Testing

## Running the suite

```bash
composer install
composer test
```

Or call Pest directly:

```bash
vendor/bin/pest
vendor/bin/pest --filter="it caches roles on the model instance"
vendor/bin/pest tests/Unit
```

## Code style

```bash
composer lint   # check
composer fix    # apply
```

Pint and StyleCI both run on the repository. Pint has the fixers that overlap
with StyleCI turned off in `pint.json`, so the two do not undo each other. If
you add a fixer and StyleCI starts disagreeing, turn the fixer off in
`pint.json` rather than reformatting to satisfy both.

## What the suite covers

| Area | Covered |
| :--- | :--- |
| Roles | Attach, detach, sync, list forms, all versus any |
| Permissions | Through roles, direct, inheritance, soft deleted roles |
| Levels | Highest wins, inheritance on and off |
| Entity checks | Ownership, owner column, non owners |
| Pretend mode | Fixed answers regardless of the database |
| Magic methods | `is*`, `can*`, and the unknown method failure |
| Middleware | Allowed, denied, guests, exception messages |
| Blade directives | Registration and output for all four |
| GUI | Every route rendered in all three CSS frameworks |
| GUI CRUD | Store, update, delete, restore, force delete, authorisation |
| API | Both endpoints, validation, and that nothing else is registered |
| Commands | Install, update and switch across every framework, plus invalid input |
| Service provider | Bindings, publish tags, view paths, seeder registration |
| Seeders | The rows they create and that re-running does not duplicate |
| Custom table names | Every relation and query against renamed tables |
| Query counts | That eager loading removes the lookups it should |
| View sets | Identical file lists, no framework mixing, icons, `x-cloak` |

## Database

Tests run against SQLite in memory through Orchestra Testbench. The `users`
table used by the suite lives in `src/Database/TestMigrations` so it is never
loaded into a consuming application.

## Continuous integration

GitHub Actions runs the suite on PHP 8.2 through 8.4 against Laravel 12 and
13, plus a Pint job and a job that validates `composer.json` and audits the
dependencies.

Laravel 11 is not built. Every 11.x release is affected by an advisory with no
patched 11.x, so Composer will not resolve it under the default policy. The
package still declares support for it.

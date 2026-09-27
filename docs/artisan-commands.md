# Artisan commands

Three commands ship with the package.

| Command | Description |
| :--- | :--- |
| `roles:install` | Publishes the config and walks through picking a CSS framework. Detects an existing installation. |
| `roles:update` | Changes the CSS framework without overwriting config or published views. |
| `roles:switch` | Changes the CSS framework straight from a flag, no prompts. |

All three accept `--css` with `bootstrap4`, `bootstrap5` or `tailwind`, and all
three write `ROLES_CSS_FRAMEWORK` to your `.env` and clear the config and view
caches.

## roles:install

```bash
php artisan roles:install
```

| Flag | Description |
| :--- | :--- |
| `--css=` | `bootstrap4`, `bootstrap5` or `tailwind` |
| `--force` | Skip the confirmation shown when already installed |

Run without flags it shows a banner, asks which CSS framework to use, and asks
you to confirm before doing anything. Choosing "Start over" returns to the
framework list and "Cancel and exit" leaves everything untouched.

When `config/roles.php` already exists it warns that reinstalling overwrites
it and points at `roles:update` instead. Answer `yes` to continue, or pass
`--force`. In `--no-interaction` mode without `--force` it refuses and exits
with a failure code.

Passing `--css` skips the prompts, so the command works unattended:

```bash
php artisan roles:install --css=tailwind --force
```

## roles:update

```bash
php artisan roles:update --css=bootstrap5
```

The safe counterpart to install. It changes the framework and nothing else, so
your config and any published views are left alone. It refuses to run when the
package has not been installed yet and points you at `roles:install`.

## roles:switch

```bash
php artisan roles:switch --css=tailwind
```

No banner and no prompts, for scripts and deploys. It requires `--css` and
fails with usage examples if you leave it off. When published views are
present it reminds you to republish them for the new framework.

## Invalid input

All three reject an unknown framework, list the valid values and exit with a
failure code, so a typo in a deploy script stops rather than silently leaving
the old framework in place.

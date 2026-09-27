# Configuration

Publish the config file to change any of these:

```bash
php artisan vendor:publish --tag=laravelroles-config
```

Every key reads from an environment variable, so most installs never need to
edit `config/roles.php` at all.

## Database

| Key | Environment variable | Default |
| :--- | :--- | :--- |
| `connection` | `ROLES_DATABASE_CONNECTION` | `null` (the default connection) |
| `rolesTable` | `ROLES_ROLES_DATABASE_TABLE` | `roles` |
| `roleUserTable` | `ROLES_ROLE_USER_DATABASE_TABLE` | `role_user` |
| `permissionsTable` | `ROLES_PERMISSIONS_DATABASE_TABLE` | `permissions` |
| `permissionsRoleTable` | `ROLES_PERMISSION_ROLE_DATABASE_TABLE` | `permission_role` |
| `permissionsUserTable` | `ROLES_PERMISSION_USER_DATABASE_TABLE` | `permission_user` |

The table names are honoured by the migrations, the models, every relation and
every query the package builds, so renaming one is enough.

## Models

| Key | Environment variable | Default |
| :--- | :--- | :--- |
| `models.role` | `ROLES_DEFAULT_ROLE_MODEL` | `jeremykenedy\LaravelRoles\Models\Role` |
| `models.permission` | `ROLES_DEFAULT_PERMISSION_MODEL` | `jeremykenedy\LaravelRoles\Models\Permission` |
| `models.defaultUser` | `ROLES_DEFAULT_USER_MODEL` | `config('auth.providers.users.model')` |

Swap in your own models by extending the shipped ones and pointing the config
at your class.

## Behaviour

| Key | Environment variable | Default | Notes |
| :--- | :--- | :--- | :--- |
| `separator` | `ROLES_DEFAULT_SEPARATOR` | `.` | Used by slugs and by the magic methods |
| `inheritance` | `ROLES_INHERITANCE` | `true` | See [levels and inheritance](levels-and-inheritance.md) |
| `pretend.enabled` | | `false` | Makes the check methods return fixed answers |

`pretend` is a testing aid. With it enabled, `hasRole()`, `hasPermission()`
and `allowed()` return whatever `pretend.options` says regardless of what is
in the database.

## Migrations and seeds

| Key | Environment variable | Default |
| :--- | :--- | :--- |
| `defaultMigrations.enabled` | `ROLES_MIGRATION_DEFAULT_ENABLED` | `false` |
| `defaultSeeds.PermissionsTableSeeder` | `ROLES_SEED_DEFAULT_PERMISSIONS` | `true` |
| `defaultSeeds.RolesTableSeeder` | `ROLES_SEED_DEFAULT_ROLES` | `true` |
| `defaultSeeds.ConnectRelationshipsSeeder` | `ROLES_SEED_DEFAULT_RELATIONSHIPS` | `true` |
| `defaultSeeds.UsersTableSeeder` | `ROLES_SEED_DEFAULT_USERS` | `false` |

The `defaultSeeds` options need an optional package. See [seeding](seeding.md).

## GUI

| Key | Environment variable | Default |
| :--- | :--- | :--- |
| `cssFramework` | `ROLES_CSS_FRAMEWORK` | `bootstrap4` |
| `rolesGuiEnabled` | `ROLES_GUI_ENABLED` | `false` |
| `rolesGuiAuthEnabled` | `ROLES_GUI_AUTH_ENABLED` | `true` |
| `rolesGuiMiddlewareEnabled` | `ROLES_GUI_MIDDLEWARE_ENABLED` | `true` |
| `rolesGuiMiddleware` | `ROLES_GUI_MIDDLEWARE` | `role:admin` |
| `GUIRoutesPrefix` | `ROLES_GUI_ROUTES_PREFIX` | empty |
| `bladeExtended` | `ROLES_GUI_BLADE_EXTENDED` | `layouts.app` |
| `titleExtended` | `ROLES_GUI_TITLE_EXTENDED` | `template_title` |
| `bladePlacementCss` | `ROLES_GUI_BLADE_PLACEMENT_CSS` | `inline_template_linked_css` |
| `bladePlacementJs` | `ROLES_GUI_BLADE_PLACEMENT_JS` | `inline_footer_scripts` |
| `builtInFlashMessagesEnabled` | `ROLES_GUI_FLASH_MESSAGES_ENABLED` | `true` |

Who may create roles and permissions is separate from who may reach the GUI:

| Key | Environment variable | Default |
| :--- | :--- | :--- |
| `rolesGuiCreateNewRolesMiddlewareType` | `ROLES_GUI_CREATE_ROLE_MIDDLEWARE_TYPE` | `role` |
| `rolesGuiCreateNewRolesMiddleware` | `ROLES_GUI_CREATE_ROLE_MIDDLEWARE` | `admin` |
| `rolesGuiCreateNewPermissionMiddlewareType` | `ROLES_GUI_CREATE_PERMISSION_MIDDLEWARE_TYPE` | `role` |
| `rolesGuiCreateNewPermissionsMiddleware` | `ROLES_GUI_CREATE_PERMISSION_MIDDLEWARE` | `admin` |

Set the type to `permissions` to gate on a permission slug instead of a role.

## Front end assets

| Key | Environment variable | Default | Applies to |
| :--- | :--- | :--- | :--- |
| `enableFontAwesomeCDN` | `ROLES_GUI_FONT_AWESOME_CDN_ENABLED` | `true` | Bootstrap sets |
| `fontAwesomeCDN` | `ROLES_GUI_FONT_AWESOME_CDN_URL` | Font Awesome 4 on Bootstrap 4, Font Awesome 6 otherwise | Bootstrap sets |
| `enablejQueryCDN` | `ROLES_GUI_JQUERY_CDN_ENABLED` | `true` | Bootstrap 4 |
| `enableAlpineJsCDN` | `ROLES_GUI_ALPINEJS_CDN_ENABLED` | `true` | Tailwind |
| `enableSelectizeJs` | `ROLES_GUI_SELECTIZEJS_ENABLED` | `true` | Bootstrap sets |
| `enabledDatatablesJs` | `ROLES_GUI_DATATABLES_JS_ENABLED` | `false` | Bootstrap sets |
| `tooltipsEnabled` | `ROLES_GUI_TOOLTIPS_ENABLED` | `true` | Bootstrap sets |

Turn a CDN off when your application already bundles the library.

## Legacy Bootstrap 3 switch

`bootstapVersion` (`ROLES_GUI_BOOTSTRAP_VERSION`, default `4`) still selects
between Bootstrap 3 `panel` markup and Bootstrap 4 `card` markup inside the
Bootstrap 4 view set. It predates `cssFramework` and is kept so existing
installs are not disturbed. New installs should use `cssFramework`.

## Optional integrations

| Key | Environment variable | Default |
| :--- | :--- | :--- |
| `uiKit.enabled` | `ROLES_UI_KIT_ENABLED` | `false` |
| `laravelUsersEnabled` | `ROLES_GUI_LARAVEL_ROLES_ENABLED` | `false` |

With `uiKit.enabled` on and
[jeremykenedy/laravel-ui-kit](https://github.com/jeremykenedy/laravel-ui-kit)
installed, the GUI follows `ui-kit.css_framework` instead of `cssFramework`, so
both packages render the same way. The UI kit is not a dependency.

## API

| Key | Environment variable | Default |
| :--- | :--- | :--- |
| `rolesApiEnabled` | `ROLES_API_ENABLED` | `false` |
| `rolesAPIAuthEnabled` | `ROLES_API_AUTH_ENABLED` | `true` |
| `rolesAPIMiddlewareEnabled` | `ROLES_API_MIDDLEWARE_ENABLED` | `true` |
| `rolesAPIMiddleware` | `ROLES_API_MIDDLEWARE` | `role:admin` |

## Route middleware registration

`route_middlewares` defaults to `true` and registers the `role`, `permission`
and `level` aliases. Set it to `false` if you would rather register your own.

## Publishing

| Tag | Publishes |
| :--- | :--- |
| `laravelroles` | Config, migrations and seeders |
| `laravelroles-config` | `config/roles.php` |
| `laravelroles-migrations` | The five migrations |
| `laravelroles-seeds` | The four seeders |
| `laravelroles-views` | The view set for the framework currently selected |
| `laravelroles-views-bootstrap4` | The Bootstrap 4 views |
| `laravelroles-views-bootstrap5` | The Bootstrap 5 views |
| `laravelroles-views-tailwind` | The Tailwind views |
| `laravelroles-lang` | The translation files |

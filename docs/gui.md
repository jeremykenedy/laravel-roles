# The optional GUI

The package ships an optional CRUD interface for roles and permissions. It is
off by default.

```dotenv
ROLES_GUI_ENABLED=true
```

Turning it on registers the web routes and the view namespace.

## Requirements

The views extend the layout named by `bladeExtended`, which defaults to
`layouts.app`, and they render their CSS and JS into the sections named by
`bladePlacementCss` and `bladePlacementJs`. Your layout needs to yield those:

```blade
@yield('inline_template_linked_css')
...
@yield('inline_footer_scripts')
```

## Choosing a CSS framework

Three complete view sets ship with the package. Exactly one is active.

| Framework | `cssFramework` | Needs |
| :--- | :--- | :--- |
| Bootstrap 4 | `bootstrap4` | Bootstrap 4 CSS and JS, jQuery |
| Bootstrap 5 | `bootstrap5` | Bootstrap 5 CSS and JS |
| Tailwind CSS | `tailwind` | Tailwind CSS, Alpine.js |

`bootstrap4` is the default, and it is the markup the package has always
shipped, so upgrading does not change how an existing install looks.

```bash
php artisan roles:switch --css=tailwind
```

See [artisan commands](artisan-commands.md) for the full command reference.

### What differs between the sets

The Bootstrap 5 views use `data-bs-*` attributes, Font Awesome 6 and plain
JavaScript rather than jQuery. The Tailwind views use Alpine.js for the modals,
dropdowns and collapsible panels, inline SVG icons, and class based dark mode
through Tailwind's `dark:` variants.

No set borrows markup from another, and a test enforces that: the Tailwind
views contain no Bootstrap classes and the Bootstrap views contain no Tailwind
utilities.

## Access control

Two independent layers guard the GUI.

| Setting | Default | Effect |
| :--- | :--- | :--- |
| `rolesGuiAuthEnabled` | `true` | Applies Laravel's `auth` middleware |
| `rolesGuiMiddlewareEnabled` | `true` | Applies `rolesGuiMiddleware`, default `role:admin` |

Creating roles and permissions is gated separately, so you can let a wider
group view the dashboard than can change it. See
[configuration](configuration.md#gui).

## Routes

With the GUI on, these names are registered under the `laravelroles::` prefix
and the `GUIRoutesPrefix` path prefix.

| Name | Purpose |
| :--- | :--- |
| `laravelroles::roles.index` | Dashboard |
| `laravelroles::roles.create` / `.store` | Create a role |
| `laravelroles::roles.show` / `.edit` / `.update` / `.destroy` | Manage a role |
| `laravelroles::permissions.*` | The same set for permissions |
| `laravelroles::roles-deleted` | Soft deleted roles |
| `laravelroles::role-show-deleted` | One soft deleted role |
| `laravelroles::role-restore` | Restore one role |
| `laravelroles::roles-deleted-restore-all` | Restore every deleted role |
| `laravelroles::destroy-all-deleted-roles` | Permanently delete every deleted role |
| `laravelroles::role-item-destroy` | Permanently delete one role |
| `laravelroles::permissions-deleted` and friends | The same set for permissions |

## Publishing the views

```bash
php artisan vendor:publish --tag=laravelroles-views
```

That publishes the set for the framework currently selected. To publish a
specific one:

```bash
php artisan vendor:publish --tag=laravelroles-views-tailwind
```

Published views live in `resources/views/vendor/laravelroles` and take
precedence over the package. If you switch frameworks after publishing,
republish, or the old markup keeps rendering.

## Front end assets

The GUI loads jQuery, Alpine, Font Awesome, Selectize and DataTables from a CDN
by default, and each can be turned off when your build already includes it. See
[configuration](configuration.md#front-end-assets).

## Next

- [Artisan commands](artisan-commands.md)
- [API](api.md)

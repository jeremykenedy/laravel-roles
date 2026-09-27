# The optional API

The package ships a small JSON API. It is off by default.

```dotenv
ROLES_API_ENABLED=true
```

## Endpoints

| Method | URI | Name | Returns |
| :--- | :--- | :--- | :--- |
| GET | `/api/roles-api` | `laravelroles::roles-api.index` | Every role, permission and user |
| POST | `/api/roles-api` | `laravelroles::roles-api.store` | The created role |

Only these two actions are implemented, and the resource route is restricted
to match, so nothing is advertised that does not exist.

## Authentication

The route group is behind `auth:api`, so your application needs an `api` guard
configured. Creating a role additionally goes through the same authorisation
check as the GUI, which by default requires the `admin` role. See
[configuration](configuration.md#api).

## Listing

```http
GET /api/roles-api
```

```json
{
    "code": 200,
    "status": "success",
    "message": "Success returning all roles and permissions data.",
    "data": {
        "roles": [],
        "permissions": [],
        "deletedRoleItems": [],
        "deletedPermissionsItems": [],
        "users": [],
        "sortedRolesWithUsers": [],
        "sortedRolesWithPermissionsAndUsers": [],
        "sortedPermissionsRolesUsers": []
    }
}
```

## Creating

```http
POST /api/roles-api
```

| Field | Rules |
| :--- | :--- |
| `name` | required, unique on the roles table |
| `slug` | required, unique on the roles table |
| `description` | optional, string, max 255 |
| `level` | required, integer |
| `permissions` | optional, an array of JSON encoded permissions |

```json
{
    "code": 201,
    "status": "created",
    "message": "Success created new role.",
    "role": {}
}
```

A validation failure returns `422` with the usual Laravel error body.

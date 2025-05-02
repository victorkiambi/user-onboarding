# Database Design: User Onboarding & Admin Review

## Entity Relationship Diagram (ERD)

```
+-------------------+        +-------------------+        +-------------------+
|      users        |        |    audit_logs     |        |   roles/permissions|
+-------------------+        +-------------------+        +-------------------+
| id (PK)           |<--+    | id (PK)           |        | id (PK)           |
| name              |   |    | user_id (FK)      |        | name              |
| email (unique)    |   +----| admin_id (FK)     |        | guard_name        |
| phone             |        | action            |        +-------------------+
| address           |        | reason            |        | model_has_roles   |
| status            |        | created_at        |        | (user_id, role_id)|
| profile_photo     |        +-------------------+        +-------------------+
| id_front          |
| id_back           |
| role              |
| password          |
| ...               |
+-------------------+
```

---

## Table Breakdown

### users
- `id`: Primary key
- `name`, `email`, `phone`, `address`: User info
- `status`: `pending`, `approved`, `rejected`
- `profile_photo`, `id_front`, `id_back`: File paths
- `role`: (legacy, use Spatie roles for RBAC)
- `password`, `remember_token`, timestamps

### audit_logs
- `id`: Primary key
- `user_id`: User being acted upon (FK to users)
- `admin_id`: Admin performing the action (FK to users)
- `action`: `approved`, `rejected`, etc.
- `reason`: Reason for action (nullable)
- `created_at`: Timestamp

### Spatie Roles & Permissions
- `roles`, `permissions`: Role and permission definitions
- `model_has_roles`: Assigns roles to users (user_id, role_id)
- `role_has_permissions`: Assigns permissions to roles

---

## Relationships
- **User** has many **AuditLogs** (as user and as admin)
- **User** has many **Roles** (via Spatie)
- **AuditLog** belongs to **User** (user_id) and **Admin** (admin_id)
- **Role** has many **Permissions** (via Spatie)

---

## Notes
- All file uploads are stored in `storage/app/public/users/{user_id}/`
- Spatie's RBAC system is the source of truth for user/admin roles
- Audit logs provide a full history of admin actions on users 
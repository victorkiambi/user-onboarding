# System Architecture: User Onboarding & Admin Review

## Overview
This Laravel application implements a secure, auditable onboarding and admin review system with robust RBAC, file management, and notification flows.

---

## High-Level Flow

```
[User Registration] --> [User (status: pending)] --> [Admin Review Dashboard]
      |                                                    |
      v                                                    v
[File Uploads, Validation]                        [Approve/Reject, Audit Log]
      |                                                    |
      v                                                    v
[User Dashboard/Profile] <---------------------- [Status/Notification Update]
```

---

## Key Components

### Controllers
- **Auth/RegisteredUserController**: Registration, onboarding, file uploads
- **Admin/UserReviewController**: Admin dashboard, user review, approval/rejection, audit logging
- **ProfileController**: User profile and document management

### Models
- **User**: Extended with onboarding fields, Spatie roles
- **AuditLog**: Tracks admin actions
- **Spatie**: Role, Permission, and pivot models

### Views
- `resources/views/user/`: User dashboard, profile, document management
- `resources/views/admin/`: Admin dashboard, user review

### Middleware
- `auth`: Protects all sensitive routes
- `admin`: Restricts admin routes
- (Optionally) Spatie's `role` middleware for fine-grained RBAC

### Notifications
- On registration, approval, rejection

### Testing
- Automated feature tests for all user and admin flows

---
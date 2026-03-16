# ClydePixel User Manual (Print Edition)

Version: 2026-03-15  
Prepared for: Super Admin, Admin, Client users

---

## Print Notes
- Recommended page size: A4
- Recommended orientation: Portrait
- Suggested export: PDF
- This file is optimized for printing with section breaks.

\newpage

## 1. Quick Role Summary

| Feature | Super Admin | Admin | Client |
|---|---|---|---|
| Dashboard | Yes | Yes | Yes |
| Add User | Yes | Yes | No |
| User List | Yes | Yes | No |
| Create Order | Yes | Yes | Yes |
| Update Order Status | Yes | Yes | No |
| Delete Order | Yes | Yes | No |
| Completed Orders | Yes | Yes | Yes (own only) |
| Order Fields Setup | Yes | No | No |
| Profile Update | Yes | Yes | Yes |

\newpage

## 2. Authentication

### 2.1 Login
1. Open `/login`.
2. Enter email and password.
3. Click `Sign In`.

### 2.1.1 Example User Credentials
- Super Admin: superadmin@clydepixel.com / 12345678
- Admin: admin@clydepixel.com / 12345678
- Client: client@clydepixel.com / 12345678

**Use actual email addresses when creating users, so email notifications are delivered correctly.**

![Login](screenshots/guest-login.png)

### 2.2 Forgot Password
1. Open `/forgot-password`.
2. Enter account email.
3. Click `Email Password Reset Link`.

![Forgot Password](screenshots/guest-forgot-password.png)

\newpage

## 3. Main Features (Step-by-Step)

### 3.1 Dashboard
1. Open `Dashboard`.
2. Read KPI cards for current role.
3. Use sidebar to navigate next action.

![Super Admin Dashboard](screenshots/superadmin-dashboard.png)
![Admin Dashboard](screenshots/admin-dashboard.png)
![Client Dashboard](screenshots/client-dashboard.png)

### 3.2 Add User (Super Admin/Admin)
1. Open `Add User`.
2. Fill full name, email, phone, password.
3. Select role.
4. Click `Submit`.

![Super Admin Add User](screenshots/superadmin-add-user.png)
![Admin Add User](screenshots/admin-add-user.png)

### 3.3 User List (Super Admin/Admin)
1. Open `User List`.
2. Inspect a user with eye icon.
3. Delete user with delete icon if needed.

![Super Admin User List](screenshots/superadmin-users-list.png)
![Admin User List](screenshots/admin-users-list.png)

\newpage

### 3.4 Add Order (All Roles)
1. Open `Add Order`.
2. Enter name and folder.
3. Enter all field quantities.
4. Set deadline (hours and minutes).
5. Optional comment.
6. Click `Submit`.

Admin/Super Admin only:
1. Use optional `Associated Client Email` dropdown.
2. If empty, own email is used.

![Super Admin Add Order](screenshots/superadmin-add-order.png)
![Admin Add Order](screenshots/admin-add-order.png)
![Client Add Order](screenshots/client-add-order.png)

### 3.5 Order List
1. Open `Order List`.
2. Check remaining time and status.
3. Admin/Super Admin can update status from dropdown.
4. Eye icon opens details.
5. Admin/Super Admin can delete order.

![Super Admin Order List](screenshots/superadmin-order-list.png)
![Admin Order List](screenshots/admin-order-list.png)
![Client Order List](screenshots/client-order-list.png)

\newpage

### 3.6 Completed Orders
1. Open `Completed Orders`.
2. Review completed time and totals.
3. Open details from eye icon.

![Super Admin Completed Orders](screenshots/superadmin-completed-orders.png)
![Admin Completed Orders](screenshots/admin-completed-orders.png)
![Client Completed Orders](screenshots/client-completed-orders.png)

### 3.7 Order Fields (Super Admin only)
1. Open `Order Fields`.
2. Add a field with label/key/sort.
3. Set required/active flags.
4. Activate/deactivate or delete existing fields.

![Order Fields](screenshots/superadmin-order-fields.png)

### 3.8 Profile and Password
1. Open profile menu.
2. Select `My Profile`.
3. Update profile details and save.
4. Update password in second panel and save.

![Super Admin Profile](screenshots/superadmin-profile.png)
![Admin Profile](screenshots/admin-profile.png)
![Client Profile](screenshots/client-profile.png)

\newpage

## 4. Notification Rules

### On Order Creation
- Sent to all Admin and Super Admin users.
- Plus one recipient:
  - Client creator email, or
  - Selected associated email, or
  - Creator admin/super admin email if associated email is blank.

### On Order Completion
- Same recipient logic as order creation.

## 5. Order Status Values
- Pending
- Working
- QC1
- QC2
- Done
- Completed

## 6. Troubleshooting
- Cannot login: verify credentials or use forgot-password.
- Cannot update status: only Admin and Super Admin can do this.
- Missing work fields: Super Admin must enable them in Order Fields.
- Client cannot see all orders: clients only see their own orders.

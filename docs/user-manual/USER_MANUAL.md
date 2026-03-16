# ClydePixel User Manual

## 1. Introduction
This document explains how to use ClydePixel for all three user roles:
- Super Admin (role 0)
- Admin (role 1)
- Client (role 2)

This version includes UI screenshots from the current running system.

## 2. Login and Account Access

### 2.1 Sign In
1. Open `/login`.
2. Enter your email.
3. Enter your password.
4. Click `Sign In`.

### 2.1.1 Example User Credentials
- Super Admin: superadmin@clydepixel.com / 12345678
- Admin: admin@clydepixel.com / 12345678
- Client: client@clydepixel.com / 12345678

**Use actual email addresses when creating users, so email notifications are delivered correctly.**

![Login Screen](screenshots/guest-login.png)

### 2.2 Forgot Password
1. Open `/forgot-password`.
2. Enter your account email.
3. Click `Email Password Reset Link`.
4. Open the received email and follow the reset link.

![Forgot Password Screen](screenshots/guest-forgot-password.png)

## 3. Permission Matrix

| Feature | Super Admin | Admin | Client |
|---|---|---|---|
| View dashboard | Yes | Yes | Yes |
| Add user | Yes | Yes | No |
| View user list | Yes | Yes | No |
| Delete users | Yes | Yes (cannot delete Super Admin) | No |
| Create order | Yes | Yes | Yes |
| Edit order status | Yes | Yes | No |
| Delete order | Yes | Yes | No |
| View active orders | All | All | Own only |
| View completed orders | All | All | Own only |
| Manage order fields | Yes | No | No |
| Update own profile | Yes | Yes | Yes |
| Change own password | Yes | Yes | Yes |

## 4. Main Features (Step-by-Step)

### 4.1 Dashboard
Path: `/`

How to use:
1. Log in.
2. Open `Dashboard` from sidebar.
3. Read KPI cards:
   - Super Admin/Admin: Total Users, Total Orders, Completed Orders.
   - Client: My Orders, My Completed Orders.

![Super Admin Dashboard](screenshots/superadmin-dashboard.png)
![Admin Dashboard](screenshots/admin-dashboard.png)
![Client Dashboard](screenshots/client-dashboard.png)

### 4.2 Add User (Super Admin and Admin)
Path: `/register`

How to use:
1. Open `Add User`.
2. Fill Full Name, Email, Phone, Password, Confirm Password.
3. Select role:
   - Super Admin can assign Super Admin, Admin, or Client.
   - Admin can assign Admin or Client.
4. Click `Submit`.
5. Confirm success message.

![Super Admin Add User](screenshots/superadmin-add-user.png)
![Admin Add User](screenshots/admin-add-user.png)

### 4.3 User List (Super Admin and Admin)
Path: `/usersList`

How to use:
1. Open `User List`.
2. Review each user row.
3. Click eye icon to view user details popup.
4. Click delete icon to remove user if needed.
5. Use pagination at the bottom to navigate.

![Super Admin User List](screenshots/superadmin-users-list.png)
![Admin User List](screenshots/admin-users-list.png)

### 4.4 Add Order (All Roles)
Path: `/Order`

How to use:
1. Open `Add Order`.
2. Fill `Name` and `Folder Name`.
3. If logged in as Super Admin/Admin:
   - Optional `Associated Client Email` dropdown is visible.
   - If you leave it empty, your own email is used as associated email.
4. Enter quantities for each active work field.
5. Verify `Total File` is auto-calculated.
6. Set deadline using Hours and Minutes.
7. Optionally add a comment.
8. Click `Submit`.

![Super Admin Add Order](screenshots/superadmin-add-order.png)
![Admin Add Order](screenshots/admin-add-order.png)
![Client Add Order](screenshots/client-add-order.png)

### 4.5 Order List / Work Progress
Path: `/OrderShow`

How to use:
1. Open `Order List`.
2. Review columns: Order Name, Folder, Ordered By, Total Files, Order Time, Remaining Time, Deadline, Status.
3. If Super Admin/Admin:
   - Change status from dropdown: Pending, Working, QC1, QC2, Done, Completed.
   - Click eye icon for details.
   - Click delete icon to delete an order.
4. If Client:
   - You can only view your own orders.
   - Status is read-only.
   - Eye icon opens details.

![Super Admin Order List](screenshots/superadmin-order-list.png)
![Admin Order List](screenshots/admin-order-list.png)
![Client Order List](screenshots/client-order-list.png)

### 4.6 Completed Orders
Path: `/OrderCompletedShow`

How to use:
1. Open `Completed Orders`.
2. Review total files, total time taken, and completed time.
3. Click eye icon to inspect details.
4. Use pagination when needed.

![Super Admin Completed Orders](screenshots/superadmin-completed-orders.png)
![Admin Completed Orders](screenshots/admin-completed-orders.png)
![Client Completed Orders](screenshots/client-completed-orders.png)

### 4.7 Order Fields Management (Super Admin Only)
Path: `/OrderFields`

How to use:
1. Open `Order Fields`.
2. To add new field:
   - Enter label.
   - Optionally set field key.
   - Set sort order.
   - Set Required and Active flags.
   - Click `Add Field`.
3. To maintain existing fields:
   - Use `Activate/Deactivate` button.
   - Use `Delete` button for removal.

![Super Admin Order Fields](screenshots/superadmin-order-fields.png)

### 4.8 Profile and Password (All Roles)
Path: `/profile`

How to update profile:
1. Open profile menu (top-right).
2. Click `My Profile`.
3. In `Profile Information`, update name and phone.
4. Click `Submit`.

How to change password:
1. In `Update Password` section, enter current password.
2. Enter new password.
3. Confirm new password.
4. Click `Submit`.

![Super Admin Profile](screenshots/superadmin-profile.png)
![Admin Profile](screenshots/admin-profile.png)
![Client Profile](screenshots/client-profile.png)

## 5. Order Status Lifecycle
- 0: Pending
- 1: Working
- 2: QC1
- 3: QC2
- 4: Done
- 5: Completed

When status becomes `Completed`, the order appears in `Completed Orders`.

## 6. Notification Rules

### 6.1 On Order Creation
Recipients:
1. All Admin and Super Admin users.
2. Plus one additional recipient:
   - Client creator email (if created by a client), or
   - Selected associated client email (if selected by admin/super admin), or
   - Creator admin/super admin email (if associated email left empty).

### 6.2 On Order Completion
Same recipient logic as order creation.

## 7. Troubleshooting
- Cannot log in:
  - Verify email and password.
  - Reset password from `/forgot-password` if needed.
- You cannot update status:
  - Only Admin/Super Admin can update order status.
- Order fields missing in Add Order page:
  - Super Admin must set fields as Active in `Order Fields`.
- Client cannot find an order:
  - Clients only see orders they created.

## 8. Printable Version
For print/PDF export, use:
- `docs/user-manual/USER_MANUAL_PRINT.md`


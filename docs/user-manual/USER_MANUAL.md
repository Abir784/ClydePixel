# ClydePixel User Manual

## 1. Purpose
This manual explains how to use the ClydePixel order management system for all three roles:
- Super Admin (role `0`)
- Admin (role `1`)
- Client (role `2`)

## 2. Access and Login
- URL: `/login`
- Enter your email and password.
- Click `Sign In`.

Common authentication pages:
- Login page: `/login`
- Forgot password: `/forgot-password`
- Email verification: `/verify-email`

## 3. Role Permissions Overview

| Feature | Super Admin | Admin | Client |
|---|---|---|---|
| View dashboard | Yes | Yes | Yes |
| Add user | Yes | Yes (cannot assign Super Admin role) | No |
| View user list | Yes | Yes (cannot see/delete Super Admin users) | No |
| Delete users | Yes | Yes (except Super Admin) | No |
| Create order | Yes | Yes | Yes |
| Edit order status | Yes | Yes | No |
| Delete order | Yes | Yes | No |
| View all active orders | Yes | Yes | No (only own orders) |
| View all completed orders | Yes | Yes | No (only own orders) |
| Manage order fields | Yes | No | No |
| Update own profile | Yes | Yes | Yes |
| Change own password | Yes | Yes | Yes |

## 4. Main Navigation
All logged-in roles can access:
- `Dashboard`
- `Add Order`
- `Order List`
- `Completed Orders`
- `My Profile`

Super Admin and Admin additionally see:
- `Add User`
- `User List`

Super Admin only:
- `Order Fields`

## 5. Super Admin Guide

### 5.1 Dashboard
Path: `/`
- View `Total Users`, `Total Orders`, and `Completed Orders`.

### 5.2 Add User
Path: `/register`
- Fill in:
  - Full Name
  - Email
  - Phone
  - Password + Confirm Password
  - Role
- Super Admin can create all roles, including another Super Admin.
- Click `Submit`.

### 5.3 User List
Path: `/usersList`
- View user records with role labels.
- Click eye icon to inspect user details.
- Click delete icon to remove a user.

### 5.4 Add Order
Path: `/Order`
- Fill in order basics:
  - Name
  - Folder Name
- Optional: `Associated Client Email`
  - Dropdown values are client emails from user table.
  - If blank, associated email defaults to your own email.
- Enter quantities for active order fields.
- Deadline is entered as `hours` + `minutes` from now.
- Optional comment.
- Click `Submit`.

Notification behavior after creation:
- Sent to all Admin + Super Admin users.
- Also sent to:
  - selected associated client email, or
  - creator email if no associated email selected.

### 5.5 Order List (Active Orders)
Path: `/OrderShow`
- See all non-completed orders.
- Columns include ordered by, total files, deadline, remaining time, status.
- Change status directly from dropdown:
  - Pending, Working, QC1, QC2, Done, Completed
- Open details using eye icon.
- Delete orders with delete icon.

### 5.6 Completed Orders
Path: `/OrderCompletedShow`
- See completed order history with completion time.
- Open details using eye icon.

### 5.7 Order Details
Path: `/OrderView/{id}`
- Shows:
  - Basic metadata
  - Dynamic work-item counts
  - Status
  - Comment (if present)
- If not completed, status can be updated.
- If completed, completion metadata is displayed.

### 5.8 Order Fields Management (Super Admin only)
Path: `/OrderFields`
- Create new dynamic order field:
  - Label
  - Optional field key
  - Sort order
  - Required flag
  - Active flag
- Existing field actions:
  - Activate/Deactivate
  - Delete

### 5.9 Profile and Password
Path: `/profile`
- Update name and phone.
- Change password in `Update Password` section.

## 6. Admin Guide

### 6.1 What is different from Super Admin
Admin has almost all operational capabilities except:
- No access to `Order Fields`.
- Cannot create/view/delete Super Admin users.

### 6.2 Admin workflow
1. Login.
2. Review dashboard stats.
3. Create users (Admin or Client) if required.
4. Create orders and optionally assign client email via dropdown.
5. Track active orders in `Order List`.
6. Progress order status until `Completed`.
7. Review completion history.
8. Maintain own profile/password.

## 7. Client Guide

### 7.1 Dashboard
Path: `/`
- Sees `My Orders` and `My Completed Orders`.

### 7.2 Add Order
Path: `/Order`
- Fill order form and submit.
- Client does not see associated email dropdown.

Notification behavior for client-created orders:
- Sent to all Admin + Super Admin users.
- Sent to the client creator email.

### 7.3 Order List
Path: `/OrderShow`
- Client sees only own active orders.
- Status is read-only badge.
- Can open order details.
- Cannot delete orders.

### 7.4 Completed Orders
Path: `/OrderCompletedShow`
- Client sees only own completed orders.
- Can open details.

### 7.5 Profile and Password
Path: `/profile`
- Update own profile and password.

## 8. Order Status Lifecycle
- `0` Pending
- `1` Working
- `2` QC1
- `3` QC2
- `4` Done
- `5` Completed

`Completed` orders move from `Order List` to `Completed Orders`.

## 9. Notifications Summary

### 9.1 On Order Creation
Recipients:
- All Admin + Super Admin users
- Plus one of:
  - creator client email (if created by client), or
  - associated email (if selected by admin/super admin), or
  - creator admin/super admin email (if associated email left blank)

### 9.2 On Order Completion
Same recipient logic as order creation.

## 10. Screenshots to Attach (UI Checklist)
Use this checklist to attach screenshots in your final published SOP/PDF.

### 10.1 Common Screens
- Login page (`/login`)
- Dashboard
- Profile page

### 10.2 Super Admin Screens
- Add User page (`/register`) with role dropdown
- User List page with view/delete actions
- Add Order page with `Associated Client Email` dropdown
- Order List page with editable status dropdown
- Completed Orders page
- Order Details page
- Order Fields page

### 10.3 Admin Screens
- Dashboard
- Add User page (without Super Admin option)
- User List page
- Add Order page with `Associated Client Email` dropdown
- Order List page with editable status dropdown
- Completed Orders page

### 10.4 Client Screens
- Dashboard (`My Orders`, `My Completed Orders`)
- Add Order page (without associated email dropdown)
- Order List with read-only status badge
- Completed Orders page

## 11. Troubleshooting
- Cannot access dashboard after login:
  - Ensure email is verified.
- Status update fails:
  - Only Admin and Super Admin can update order status.
- Missing order fields in add-order form:
  - Super Admin must configure and activate fields in `Order Fields`.
- Client cannot see some orders:
  - Clients can only view orders where they are the creator.

## 12. Suggested Publishing Format
For team rollout, export this manual into:
- PDF with screenshots per section
- One-page quick-start for each role

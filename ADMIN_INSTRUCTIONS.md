# Admin System Setup Instructions

## Admin Credentials
- **Email**: admin@nutrinet.com
- **Password**: admin123

## How to Access Admin Panel

1. **Login**: Go to your login page and sign in with the admin credentials above
2. **Auto-redirect**: Once logged in, you'll be automatically redirected to the admin dashboard
3. **Manual access**: You can also access the admin panel at `/admin` URL

## Admin Features

### Dashboard
- View total users, packages, and revenue
- See recent orders and users
- Quick navigation to all admin sections

### User Management (`/admin/users`)
- View all registered users
- See user verification status
- View user details
- Delete users (except current admin)

### Package Management (`/admin/packages`)
- Create new diet packages
- Edit existing packages
- Delete packages
- View package details

### Order Management (`/admin/orders`)
- View all customer orders
- See payment details
- View order history

### FAQ Management (`/admin/faqs`)
- Create new FAQs
- Edit existing FAQs
- Delete FAQs
- Manage customer inquiries

### Settings (`/admin/settings`)
- Change admin password
- View system information
- Admin account details

## Admin Navigation

The admin panel has a sidebar navigation with:
- Dashboard (overview)
- Manage Users
- Package Details
- Order Details
- Manage FAQs
- Settings

## Security Features

- Only users with admin email addresses can access the admin panel
- Regular users are automatically redirected to the normal dashboard
- Admin middleware protects all admin routes
- Password change functionality for security

## Sample Data Created

The system has been seeded with:
- Admin user account
- 3 sample packages (Basic, Premium, Fitness & Diet Combo)
- 3 sample FAQs

## Design Features

The admin panel uses your previous semester's design with:
- Same color scheme (blue theme)
- Sidebar navigation
- Card-based layout
- Modern admin dashboard design
- Responsive layout
- Modal dialogs for confirmations

## File Structure

```
/admin/
├── dashboard (main admin page)
├── users (user management)
├── packages/ 
│   ├── index (list packages)
│   ├── create (add new package)
│   └── edit (modify package)
├── orders (order management)
├── faqs/
│   ├── index (list FAQs)
│   ├── create (add new FAQ)
│   └── edit (modify FAQ)
└── settings (admin settings)
```

## Customization

To add more admin users, you can:
1. Add email addresses to the `AdminMiddleware.php` file
2. Or implement a proper role-based system later
3. Current admin emails: admin@nutrinet.com, admin@example.com, admin@test.com

## Next Steps

1. Login with admin credentials
2. Explore the admin dashboard
3. Add/edit packages and FAQs
4. Customize the design if needed
5. Add more admin functionality as required

The admin system is now fully integrated with your Laravel diet plan application!
# Raflora Enterprises - UI Planning & Implementation Tracker

## Purpose
This file is the single source of truth for the Raflora Enterprises project UI planning, implementation progress, and process. It is intended to be kept in the project root and updated continuously as tasks move from Ongoing to Complete.

**Location:** `C:\Users\lismerpalce\OneDrive\Documents\Capstone2\Raflora2\rafloraenterprises\Planning-documentation.md`

---

## 1. Project Overview

### 1.1 Scope
- Build the UI for the Raflora Enterprises booking and event management system.
- Focus on client booking experience, authentication, and the admin/staff portal.
- Backend logic, authentication processing, database models, and API integration will be added later.

### 1.2 Tech Stack
- Laravel + Blade templates
- Tailwind CSS v4
- Vite
- Axios
- Font Awesome icons
- Google Fonts: Playfair Display, Montserrat

### 1.3 Key Roles
- **Client**: Uses booking flow, sees booking status, views AI analysis, and manages account.
- **Admin / Staff**: Share the same privileged dashboard and manage business workflows.
- **Developers**: Implement role recognition and backend logic after UI is complete.

---

## 2. Approved UI Modules

### 2.1 Admin / Staff Portal Modules
- **Event Booking Coordination**: Bookings interface with table, filtering, and status update controls.
- **Gemini AI Image Analysis**: Review workspace with client image, AI floral suggestions, and price estimate.
- **Inventory Tracking**: Dashboard for stock levels, shortage alerts, and quantity updates.
- **Post-Event Return Tracking**: Logistics interface for tracking non-perishable assets out on loan.
- **Price Validity / Reconfirmation**: Quotation controls within bookings to finalize and reconfirm quotes.
- **Reports & Audit Logs**: KPI charts and searchable activity log of staff/admin actions.

### 2.2 Client Interface Modules
- **Landing / Home Page**: Marketing hero, feature highlights, and CTAs.
- **Client Dashboard**: Welcome, booking stats, quick actions, and recent bookings.
- **Booking Creation**: Detailed event booking form with required event details.
- **Booking Analysis**: Analysis results page showing suggested florals, recommended pricing, and next steps.
- **Active Bookings**: List of current bookings with status and actions.
- **Booking History**: Past event history with filters and details.
- **Account Settings**: Profile, password, preferences, and account controls.

---

## 3. UI Implementation Plan

### 3.1 Phase 1: Component Library
Create reusable Blade components for consistency and speed.

- Layout components: `app-layout`, `navbar`, `admin-layout`, `sidebar`, `footer`
- Form components: `form-input`, `form-select`, `form-textarea`, `form-checkbox`, `form-radio`, `form-group`, `error-message`
- UI components: `button`, `card`, `badge`, `alert`, `table`, `pagination`, `modal`

### 3.2 Phase 2: Authentication UI
Build the auth pages using the shared component library.

- Login page
- Register page
- Forgot password page
- Unified login for all user types

### 3.3 Phase 3: Client Booking UI
Complete the client-facing interface and user journey.

- Home / landing page
- Client dashboard
- Booking creation form
- Booking analysis page
- Active bookings page
- Booking history page
- Account settings page

### 3.4 Phase 4: Admin / Staff UI
Build the privileged business interface with all approved modules.

- Admin dashboard
- Booking management page
- AI analysis page
- Inventory management page
- Post-event return tracking page
- Price validity / quotations page
- Reports and audit logs page
- Client records page
- System settings page

---

## 4. Current Progress Tracker
Update this section as the team completes work.

| Task | File / Section | Status | Notes |
|------|----------------|--------|-------|
| Component Library | `resources/views/components/*` | Ongoing | Initial reusable components created |
| Login Page | `resources/views/auth/login.blade.php` | Complete | Unified login UI wired to shared layout |
| Register Page | `resources/views/auth/register.blade.php` | Complete | Registration UI now uses shared layout |
| Forgot Password | `resources/views/auth/forgot-password.blade.php` | Complete | Password reset UI now uses shared layout |
| Home Page | `resources/views/home.blade.php` | Complete | Refined to use `app-layout` component |
| Client Dashboard | `resources/views/client/dashboard.blade.php` | Complete | Refined to use `app-layout` component |
| Booking Create | `resources/views/client/booking-create.blade.php` | Complete | Booking creation UI now uses shared client layout |
| Booking Analysis | `resources/views/client/booking-analysis.blade.php` | Complete | AI analysis UI refactored to shared layout |
| Active Bookings | `resources/views/client/bookings.blade.php` | Complete | Active bookings UI refactored to shared layout |
| Booking History | `resources/views/client/booking-history.blade.php` | Complete | Booking history UI refactored to shared layout |
| Account Settings | `resources/views/client/account-settings.blade.php` | Complete | Account settings UI refactored to shared layout |
| Admin Layout | `resources/views/components/admin-layout.blade.php` | Complete | Admin layout component created and used |
| Admin Dashboard | `resources/views/admin/dashboard.blade.php` | Complete | Refactored to use `x-admin-layout` component |
| Booking Management | `resources/views/admin/bookings.blade.php` | Complete | Refactored to use `x-admin-layout` component |
| AI Review | `resources/views/admin/ai-analysis.blade.php` | Complete | Refactored to use `x-admin-layout` component |
| Inventory | `resources/views/admin/inventory.blade.php` | Complete | Refactored to use `x-admin-layout` component |
| Return Tracking | `resources/views/admin/return-tracking.blade.php` | Complete | Refactored to use `x-admin-layout` component |
| Quotation | `resources/views/admin/quotations.blade.php` | Complete | Refactored to use `x-admin-layout` component |
| Reports | `resources/views/admin/reports.blade.php` | Complete | Refactored to use `x-admin-layout` component |
| Client Records | `resources/views/admin/client-records.blade.php` | Complete | Refactored to use `x-admin-layout` component |
| Settings | `resources/views/admin/settings.blade.php` | Complete | Refactored to use `x-admin-layout` component |

---

## 5. Process Guidelines

### 5.1 Update Rules
- Mark tasks as **Ongoing** when work starts.
- Change to **Complete** once the UI is fully implemented.
- Add short notes whenever status changes.
- Keep the task list current so the team can see what remains.

### 5.2 Change Log
Add entries below for each major update.

**Change Log**

- `2026-06-02` - Initial planning and tracker document created.
- `2026-06-02` - Confirmed admin/staff portal modules and client interface modules.
- `2026-06-02` - Created initial reusable Blade components, new admin module views, and admin route entries.
- `2026-06-02` - Wired `home.blade.php` and `client/dashboard.blade.php` to the shared `app-layout` and component library.
- `2026-06-02` - Refactored client booking pages and auth views to use the shared layout structure.
 - `2026-06-02` - Refactored client booking pages and auth views to use the shared layout structure.
 - `2026-06-02` - Refactored all admin views to use the `components/admin-layout.blade.php` component (`x-admin-layout`).
 - `2026-06-02` - Implemented conditional homepage behavior: single `home.blade.php` now shows `LOG IN` for guests and `BOOKING` + avatar dropdown for authenticated users. Added `resources/views/components/avatar-dropdown.blade.php`.
- `2026-06-06` - Updated login flow so homepage `LOG IN` goes to the login interface first; login form submit now applies temporary UI-only mock auth and redirects back to the homepage with authenticated header state.
- `2026-06-06` - Merged `My Bookings` and `Booking History` into a single unified bookings page with status filters (All, Active, Completed, Cancelled). Added sample booking records with Details, Edit, and Cancel action modals to display full booking context. Removed separate "Booking History" link from avatar dropdown menu.
- `2026-06-06` - Implemented professional navbar system with smart route detection: created reusable `x-navbar` component that automatically switches between scroll links (on homepage) and route links (on other pages). Updated `x-client-layout` to use the navbar, applied navbar to homepage, and removed duplicate mobile menu scripts. Created dedicated gallery and about pages (`gallery.blade.php`, `about.blade.php`) with expanded content, proper styling, and route-aware navigation. Added "View Full Gallery" and "View Full About" buttons to homepage sections linking to dedicated pages. Added routes for `/gallery` and `/about` to `routes/web.php`.

---

## 6. Notes
- For UI mockup testing only, `/login` now displays the login page first and only sets temporary auth state after the login button is clicked.
- `My Bookings` and `Booking History` are now merged into a single `/bookings` page with clear status filters so users are not confused. Sample data includes action modals for viewing, editing, and canceling bookings.

- This file is intended to evolve with the project.
- Backend logic and role recognition are developer responsibilities and do not need separate UI pages in this phase.
- The admin/staff dashboard is shared by both roles and includes all business modules from the project documentation.
- Use this file as the team’s reference for what is complete and what is still ongoing.

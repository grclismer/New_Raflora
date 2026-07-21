📋 **PLANNING & REFERENCE DOCUMENT**

This document is the planning and reference guide for the Raflora Enterprises system. It contains project overview, approved UI modules, comprehensive database architecture specifications, and developer guidelines. **For current status, completion updates, and timelines, see Progress-Report.md.**

---

# Raflora Enterprises - Planning & Database Architecture Reference

**Last Updated:** 2026-07-21  
**Project:** Raflora Enterprises Booking & Event Management System  
**Reference Document For:** Database schema, entity specifications, tech stack, approved UI modules

## Purpose
This document is the **planning and reference guide** for the Raflora Enterprises project. It contains:
- Project overview, scope, and tech stack
- Approved UI modules and features
- Complete database architecture (entity specifications, relationships, enums)
- Developer guidelines and reference material

**For current project status, phase completion, timelines, and what's missing, see [Progress-Report.md](Progress-Report.md)**

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

## 3. Database Architecture & Entity Reference

**Note:** For current phase status, completion updates, timelines, and what's still needed, see [Progress-Report.md](Progress-Report.md) instead.

This section contains detailed database entity specifications for developer reference.

### Complete Database Schema Overview

The Raflora Enterprises database consists of 15 core entity tables organized into three categories: **Core Booking Workflow**, **Inventory & Asset Management**, and **Audit & Support Systems**.

---

### Core Booking Workflow Entities

#### 1. tbl_users
**Purpose:** System users with role-based access (admin, staff)  
**Primary Key:** users_id  
**Model:** `User.php`

| Field | Type | Notes |
|-------|------|-------|
| users_id | UUID | Primary Key |
| email | VARCHAR(255) | Unique, login credential |
| password_hash | VARCHAR(255) | Hashed password |
| full_name | VARCHAR(255) | User's display name |
| role | ENUM(admin, staff) | Access control level |
| phone | VARCHAR(20) | Contact number |
| profile_image | VARCHAR(255) | Avatar image path |
| is_active | BOOLEAN | Account status |
| created_at | TIMESTAMP | Created date |
| updated_at | TIMESTAMP | Last modified date |

**Key Relationships:**
- hasMany: Booking (via handled_by FK)
- hasMany: CalendarEvent
- hasMany: InventoryTransaction (via performed_by FK)
- hasMany: Payment (via recorded_by FK)
- hasMany: Meeting, Presentation, Quotation, QuotationHistory

---

#### 2. tbl_clients
**Purpose:** Client/customer information  
**Primary Key:** clients_id  
**Model:** `Client.php` (NEW - create if needed)

| Field | Type | Notes |
|-------|------|-------|
| clients_id | UUID | Primary Key |
| full_name | VARCHAR(255) | Client name |
| email | VARCHAR(255) | Contact email |
| phone | VARCHAR(20) | Contact phone |
| address | TEXT | Full address |
| notes | TEXT | Additional notes |
| created_at | TIMESTAMP | Created date |
| updated_at | TIMESTAMP | Last modified date |

**Key Relationships:**
- hasMany: Booking

---

#### 3. tbl_bookings
**Purpose:** Main booking/event records  
**Primary Key:** bookings_id  
**Foreign Keys:** client_id, handled_by (user_id)  
**Model:** `Booking.php`

| Field | Type | Notes |
|-------|------|-------|
| bookings_id | UUID | Primary Key |
| client_id | UUID | FK to tbl_clients |
| handled_by | UUID | FK to tbl_users (staff/admin) |
| event_date | DATE | Event/event occurrence date |
| event_size | ENUM(trust, standard, advance) | Booking tier |
| status | ENUM(...) | Lifecycle status (see below) |
| downpayment_amount | DECIMAL(10,2) | Initial payment |
| downpayment_date | DATE | Payment date |
| total_quoted | DECIMAL(10,2) | Total estimated price |
| price_valid_until | DATE | Quotation expiration |
| suggested_procurement_date | DATE | Recommended order date |
| cancellation_reason | TEXT | Reason if cancelled |
| created_at | TIMESTAMP | Created date |
| updated_at | TIMESTAMP | Last modified date |

**Status Enum Values:**
- inquiry
- quotation_sent
- downpayment_received
- meeting_completed
- pre_presentation_sent
- in_progress
- completed
- cancelled

**Key Relationships:**
- belongsTo: Client
- belongsTo: User (via handled_by)
- hasMany: Quotation
- hasMany: Payment
- hasMany: Return
- hasMany: AiAnalysisResult
- hasMany: Meeting
- hasMany: Presentation
- hasMany: CalendarEvent (optional, via related_booking_id)
- belongsToMany: InventoryItem (via booking_items pivot)
- hasMany: InventoryTransaction

---

### Inventory & Asset Management Entities

#### 4. tbl_inventory_items
**Purpose:** Floral materials and non-perishable assets catalog  
**Primary Key:** inventory_items_id  
**Model:** `InventoryItem.php`

| Field | Type | Notes |
|-------|------|-------|
| inventory_items_id | UUID | Primary Key |
| name | VARCHAR(255) | Item name |
| category | ENUM(flower, foliage, prop, supply) | Item type |
| is_perishable | BOOLEAN | Whether item expires |
| current_stock | DECIMAL(10,2) | Available quantity |
| unit_cost | DECIMAL(10,2) | Cost per unit |
| min_stock | DECIMAL(10,2) | Reorder threshold |
| unit | VARCHAR(50) | Unit of measure (pieces, stems, etc.) |
| created_at | TIMESTAMP | Created date |
| updated_at | TIMESTAMP | Last modified date |

**Key Relationships:**
- hasMany: InventoryTransaction
- hasMany: ReturnItem
- belongsToMany: Booking (via booking_items pivot)

---

#### 5. tbl_booking_items (Pivot)
**Purpose:** Line items linking bookings to inventory  
**Primary Keys:** booking_items_id (composite: booking_id + inventory_item_id)  
**Foreign Keys:** booking_id, inventory_item_id  
**Model:** Referenced in Booking and InventoryItem relationship definitions

| Field | Type | Notes |
|-------|------|-------|
| booking_items_id | UUID | Primary Key |
| booking_id | UUID | FK to tbl_bookings |
| inventory_item_id | UUID | FK to tbl_inventory_items |
| quantity | DECIMAL(10,2) | Quantity ordered |
| quoted_unit_price | DECIMAL(10,2) | Price per unit for this booking |
| is_ai_suggested | BOOLEAN | Whether AI recommended this item |
| procurement_status | ENUM(...) | Status of procurement |
| suggested_order_date | DATE | Recommended order date |
| suggested_delivery_date | DATE | Recommended delivery date |
| notes | TEXT | Line item notes |

**Procurement Status Values:** pending, ordered, received, cancelled

---

#### 6. tbl_inventory_transactions
**Purpose:** Audit trail of inventory movements  
**Primary Key:** inventory_transactions_id  
**Foreign Keys:** inventory_item_id, booking_id, performed_by (user_id)  
**Model:** `InventoryTransaction.php` (NEW - create if needed)

| Field | Type | Notes |
|-------|------|-------|
| inventory_transactions_id | UUID | Primary Key |
| inventory_item_id | UUID | FK to tbl_inventory_items |
| booking_id | UUID | FK to tbl_bookings (optional) |
| quantity_change | DECIMAL(10,2) | Amount added/removed |
| transaction_type | ENUM(...) | Type of transaction |
| reason | TEXT | Transaction reason |
| performed_by | UUID | FK to tbl_users |
| created_at | TIMESTAMP | Transaction date |

**Transaction Type Values:** procurement, release, return, damage, adjustment, cancel

**Key Relationships:**
- belongsTo: InventoryItem
- belongsTo: Booking (optional)
- belongsTo: User (via performed_by)

---

#### 7. tbl_returns
**Purpose:** Post-event non-perishable asset returns  
**Primary Key:** returns_id  
**Foreign Keys:** booking_id, inspected_by (user_id)  
**Model:** `AssetReturn.php`

| Field | Type | Notes |
|-------|------|-------|
| returns_id | UUID | Primary Key |
| booking_id | UUID | FK to tbl_bookings |
| return_date | DATE | When items were returned |
| total_damage_charge | DECIMAL(10,2) | Total damage amount |
| inspected_by | UUID | FK to tbl_users (inspector) |
| notes | TEXT | Return notes |
| created_at | TIMESTAMP | Record created date |
| updated_at | TIMESTAMP | Last modified date |

**Key Relationships:**
- belongsTo: Booking
- belongsTo: User (via inspected_by)
- hasMany: ReturnItem

---

#### 8. tbl_return_items (Pivot)
**Purpose:** Specific items included in a return  
**Primary Keys:** return_items_id  
**Foreign Keys:** return_id, inventory_item_id  
**Model:** Referenced in Return and InventoryItem relationship definitions

| Field | Type | Notes |
|-------|------|-------|
| return_items_id | UUID | Primary Key |
| return_id | UUID | FK to tbl_returns |
| inventory_item_id | UUID | FK to tbl_inventory_items |
| quantity_returned | DECIMAL(10,2) | Quantity of this item returned |
| condition | ENUM(good, damaged, lost) | Item condition |
| final_amount | DECIMAL(10,2) | Final recorded value |
| damage_charge | DECIMAL(10,2) | Damage cost if applicable |
| notes | TEXT | Item-specific notes |

---

### Quotation & Pricing Entities

#### 9. tbl_quotations
**Purpose:** Current and historical quotation records  
**Primary Key:** quotations_id  
**Foreign Keys:** booking_id, changed_by (user_id)  
**Model:** `Quotation.php`

| Field | Type | Notes |
|-------|------|-------|
| quotations_id | UUID | Primary Key |
| booking_id | UUID | FK to tbl_bookings |
| suggested_florals | TEXT | JSON: recommended floral selections |
| recommended_price | DECIMAL(10,2) | Total recommended price |
| status | ENUM(tentative, confirmed) | Quotation status |
| valid_until | DATE | Expiration date |
| created_at | TIMESTAMP | Created date |
| updated_at | TIMESTAMP | Last modified date |

**Key Relationships:**
- belongsTo: Booking

---

#### 10. tbl_quotation_history
**Purpose:** Audit trail of quotation changes  
**Primary Key:** quotation_history_id  
**Foreign Keys:** booking_id, changed_by (user_id)  
**Model:** `QuotationHistory.php` (NEW - create if needed)

| Field | Type | Notes |
|-------|------|-------|
| quotation_history_id | UUID | Primary Key |
| booking_id | UUID | FK to tbl_bookings |
| field_changed | VARCHAR(255) | Field name that changed |
| old_value | TEXT | Previous value |
| new_value | TEXT | Updated value |
| reason | TEXT | Reason for change |
| changed_by | UUID | FK to tbl_users |
| created_at | TIMESTAMP | Change date |

---

#### 11. tbl_payments
**Purpose:** Payment transaction records  
**Primary Key:** payments_id  
**Foreign Keys:** booking_id, recorded_by (user_id)  
**Model:** `Payment.php` (NEW - create if needed)

| Field | Type | Notes |
|-------|------|-------|
| payments_id | UUID | Primary Key |
| booking_id | UUID | FK to tbl_bookings |
| amount | DECIMAL(10,2) | Payment amount |
| payment_type | ENUM(downpayment, balance, refund) | Type of payment |
| status | ENUM(pending, completed, failed) | Payment status |
| recorded_by | UUID | FK to tbl_users |
| created_at | TIMESTAMP | Payment date |

---

### AI Analysis Entities

#### 12. tbl_ai_analyses
**Purpose:** Gemini AI analysis results and suggestions  
**Primary Key:** ai_analyses_id  
**Foreign Key:** booking_id  
**Model:** `AiAnalysisResult.php`

| Field | Type | Notes |
|-------|------|-------|
| ai_analyses_id | UUID | Primary Key |
| booking_id | UUID | FK to tbl_bookings |
| raw_gemini_response | LONGTEXT | Complete API response JSON |
| suggested_materials | JSON | Parsed floral suggestions array |
| analyzed_at | TIMESTAMP | Analysis execution time |

**Suggested Materials JSON Structure:**
```json
[
  {
    "item_name": "Rose",
    "confidence": 0.95,
    "category": "flower",
    "estimated_quantity": 50,
    "unit_cost": 2.50
  }
]
```

**Key Relationships:**
- belongsTo: Booking

---

### Calendar & Meeting Entities

#### 13. tbl_calendar_events
**Purpose:** User calendar and availability management  
**Primary Key:** calendar_events_id  
**Foreign Keys:** user_id, related_booking_id (optional)  
**Model:** `CalendarEvent.php` (NEW - create if needed)

| Field | Type | Notes |
|-------|------|-------|
| calendar_events_id | UUID | Primary Key |
| user_id | UUID | FK to tbl_users |
| title | VARCHAR(255) | Event title |
| event_type | ENUM(meeting, blocked, other) | Type of calendar entry |
| start_datetime | DATETIME | Start time |
| end_datetime | DATETIME | End time |
| related_booking_id | UUID | FK to tbl_bookings (optional) |
| is_blocked | BOOLEAN | Whether this blocks availability |
| created_at | TIMESTAMP | Created date |
| updated_at | TIMESTAMP | Last modified date |

**Key Relationships:**
- belongsTo: User
- belongsTo: Booking (optional)

---

#### 14. tbl_meetings
**Purpose:** Meeting scheduling linked to bookings  
**Primary Key:** meetings_id  
**Foreign Keys:** booking_id, calendar_event_id  
**Model:** `Meeting.php` (NEW - create if needed)

| Field | Type | Notes |
|-------|------|-------|
| meetings_id | UUID | Primary Key |
| booking_id | UUID | FK to tbl_bookings |
| calendar_event_id | UUID | FK to tbl_calendar_events |
| meeting_type | ENUM(online, face_to_face) | Type of meeting |
| scheduled_datetime | DATETIME | Meeting time |
| meeting_link | VARCHAR(255) | Video conference link (if online) |
| address | TEXT | Physical location (if face-to-face) |
| status | ENUM(scheduled, completed, cancelled) | Meeting status |
| created_at | TIMESTAMP | Created date |
| updated_at | TIMESTAMP | Last modified date |

**Key Relationships:**
- belongsTo: Booking
- belongsTo: CalendarEvent

---

### Presentation & File Management

#### 15. tbl_presentations
**Purpose:** Presentation/proposal file management  
**Primary Key:** presentations_id  
**Foreign Keys:** booking_id, sent_by (user_id)  
**Model:** `Presentation.php` (NEW - create if needed)

| Field | Type | Notes |
|-------|------|-------|
| presentations_id | UUID | Primary Key |
| booking_id | UUID | FK to tbl_bookings |
| version | INT | Version number |
| file_path | VARCHAR(255) | Storage path |
| file_name | VARCHAR(255) | Original file name |
| sent_at | TIMESTAMP | When file was sent |
| sent_by | UUID | FK to tbl_users (who sent) |
| status | ENUM(sent, changes_requested, approved) | Approval status |
| created_at | TIMESTAMP | File created date |
| updated_at | TIMESTAMP | Last modified date |

**Key Relationships:**
- belongsTo: Booking
- belongsTo: User (via sent_by)

---

### Database Relationship Map

```
tbl_users (admin/staff)
├── hasMany: tbl_bookings (via handled_by)
├── hasMany: tbl_calendar_events
├── hasMany: tbl_inventory_transactions (via performed_by)
├── hasMany: tbl_payments (via recorded_by)
├── hasMany: tbl_returns (via inspected_by)
└── hasMany: tbl_meetings, tbl_presentations, tbl_quotations, tbl_quotation_history

tbl_clients
└── hasMany: tbl_bookings

tbl_bookings
├── belongsTo: tbl_clients
├── belongsTo: tbl_users (via handled_by)
├── hasMany: tbl_booking_items (via booking_items pivot table)
├── hasMany: tbl_quotations
├── hasMany: tbl_quotation_history
├── hasMany: tbl_payments
├── hasMany: tbl_returns
├── hasMany: tbl_ai_analyses
├── hasMany: tbl_meetings
├── hasMany: tbl_presentations
├── hasMany: tbl_calendar_events (optional, via related_booking_id)
└── hasMany: tbl_inventory_transactions

tbl_inventory_items
├── hasMany: tbl_booking_items (via booking_items pivot table)
├── hasMany: tbl_return_items (via return_items pivot table)
└── hasMany: tbl_inventory_transactions

tbl_returns
├── belongsTo: tbl_bookings
├── belongsTo: tbl_users (via inspected_by)
└── hasMany: tbl_return_items (via return_items pivot table)

tbl_calendar_events
├── belongsTo: tbl_users
└── belongsTo: tbl_bookings (optional, via related_booking_id)

tbl_meetings
├── belongsTo: tbl_bookings
└── belongsTo: tbl_calendar_events
```

---

### Key Design Patterns

1. **Timestamps:** All tables have `created_at` and `updated_at` for audit trails
2. **Cascading Deletes:** Foreign keys configured to cascade delete related records
3. **Enums:** Status and category fields use ENUM for data integrity
4. **JSON Columns:** AI suggestions and complex data stored as JSON for flexibility
5. **Pivot Tables:** booking_items and return_items connect many-to-many relationships
6. **UUIDs:** Primary keys are UUIDs for better distributed system support
7. **Soft Deletes:** Consider implementing for bookings and clients (can be added later)



## 5. Current Progress Tracker

### Phase 1: Database Schema & Models ✅ Complete

| Entity | Migration File | Model | Status | Relationships | Notes |
|--------|---|---|---|---|---|
| User | `*_add_profile_fields_to_users_table.php` | `User.php` | ✅ | hasMany(Booking), hasMany(CalendarEvent), hasMany(InventoryTransaction), hasMany(Payment) | System users (admin/staff) |
| Client | `*_create_clients_table.php` | `Client.php` (NEW) | ✅ | hasMany(Booking) | Customer/client records |
| Booking | `*_create_bookings_table.php` | `Booking.php` | ✅ | belongsTo(Client), hasMany(Quotation), hasMany(Payment), hasMany(Return), hasMany(AiAnalysisResult) | Main booking entity |
| Booking Item | `*_create_booking_items_table.php` | Pivot | ✅ | Pivot: Booking ↔ InventoryItem | Line items for bookings |
| Inventory Item | `*_create_inventory_items_table.php` | `InventoryItem.php` | ✅ | hasMany(InventoryTransaction), hasMany(ReturnItem), belongsToMany(Booking) | Floral/asset catalog |
| Inventory Transaction | `*_create_inventory_transactions_table.php` | `InventoryTransaction.php` (NEW) | ✅ | belongsTo(InventoryItem), belongsTo(Booking), belongsTo(User) | Audit trail for stock |
| Return | `*_create_returns_table.php` | `AssetReturn.php` | ✅ | belongsTo(Booking), hasMany(ReturnItem) | Post-event return tracking |
| Return Item | `*_create_return_items_table.php` | Pivot | ✅ | Pivot: Return ↔ InventoryItem | Items in a return |
| Quotation | `*_create_quotations_table.php` | `Quotation.php` | ✅ | belongsTo(Booking) | Current pricing |
| Quotation History | `*_create_quotation_history_table.php` | `QuotationHistory.php` (NEW) | ✅ | belongsTo(Booking) | Price change audit |
| Payment | `*_create_payments_table.php` | `Payment.php` (NEW) | ✅ | belongsTo(Booking) | Payment tracking |
| AI Analysis | `*_create_ai_analyses_table.php` | `AiAnalysisResult.php` | ✅ | belongsTo(Booking) | Gemini AI results |
| Calendar Event | `*_create_calendar_events_table.php` | `CalendarEvent.php` (NEW) | ✅ | belongsTo(User), belongsTo(Booking) optional | Staff scheduling |
| Meeting | `*_create_meetings_table.php` | `Meeting.php` (NEW) | ✅ | belongsTo(Booking), belongsTo(CalendarEvent) | Meeting scheduling |
| Presentation | `*_create_presentations_table.php` | `Presentation.php` (NEW) | ✅ | belongsTo(Booking), belongsTo(User) | File management |

**Legend:** ✅ Complete | 🟡 In Progress | 🟠 Pending | (NEW) = Model needs to be created

---

### Phase 2: Component Library & UI ✅ Complete

| Component | File | Status | Type |
|-----------|------|--------|------|
| Auth Layout | `resources/views/auth/` | ✅ | Login, Register, Forgot Password |
| App Layout | `resources/views/components/app-layout.blade.php` | ✅ | Shared client layout |
| Admin Layout | `resources/views/components/admin-layout.blade.php` | ✅ | Shared admin layout |
| Navbar | `resources/views/components/navbar.blade.php` | ✅ | Route-aware navigation |
| Avatar Dropdown | `resources/views/components/avatar-dropdown.blade.php` | ✅ | User menu |
| Home Page | `resources/views/home.blade.php` | ✅ | Marketing hero |
| About & Gallery | `resources/views/about.blade.php`, `gallery.blade.php` | ✅ | Information pages |
| Client Dashboard | `resources/views/client/dashboard.blade.php` | ✅ | Client portal main |
| Booking Create | `resources/views/client/booking-create.blade.php` | ✅ | New booking form |
| Booking Management | `resources/views/client/bookings.blade.php` | ✅ | Booking list with filters |
| Booking Analysis | `resources/views/client/booking-analysis.blade.php` | ✅ | AI analysis results |
| Account Settings | `resources/views/client/account-settings.blade.php` | ✅ | Profile settings |
| Admin Dashboard | `resources/views/admin/dashboard.blade.php` | ✅ | Admin main portal |
| Admin Bookings | `resources/views/admin/bookings.blade.php` | ✅ | Booking management |
| Admin AI Analysis | `resources/views/admin/ai-analysis.blade.php` | ✅ | AI review interface |
| Admin Inventory | `resources/views/admin/inventory.blade.php` | ✅ | Stock management |
| Admin Returns | `resources/views/admin/return-tracking.blade.php` | ✅ | Return tracking |
| Admin Quotations | `resources/views/admin/quotations.blade.php` | ✅ | Quotation management |
| Admin Reports | `resources/views/admin/reports.blade.php` | ✅ | KPI & audit logs |
| Admin Clients | `resources/views/admin/client-records.blade.php` | ✅ | Customer records |
| Admin Settings | `resources/views/admin/settings.blade.php` | ✅ | System settings |

**Total: 21 UI pages/components** ✅ All complete with Tailwind CSS v4

---

### Phase 3: API Controllers & Business Logic 🟡 In Progress (15%)

| Component | File | Status | Completion | Notes |
|-----------|------|--------|------------|-------|
| User Model Relationships | `app/Models/User.php` | ✅ | 100% | All 8 relationships implemented |
| Booking Model Relationships | `app/Models/Booking.php` | ✅ | 100% | All 11 relationships implemented |
| Inventory Model Relationships | `app/Models/InventoryItem.php` | ✅ | 100% | All 4 relationships implemented |
| AiAnalysisResult Model | `app/Models/AiAnalysisResult.php` | ✅ | 100% | Relationships and casts complete |
| AssetReturn Model | `app/Models/AssetReturn.php` | ✅ | 100% | Relationships and pivot complete |
| Quotation Model | `app/Models/Quotation.php` | ✅ | 100% | Relationships and casts complete |
| Setting Model | `app/Models/Setting.php` | ✅ | 100% | Key-value store with static accessors |
| Client Model (NEW) | `app/Models/Client.php` | ✅ | 100% | hasMany Booking relationship |
| InventoryTransaction Model (NEW) | `app/Models/InventoryTransaction.php` | ✅ | 100% | Audit trail relationships |
| QuotationHistory Model (NEW) | `app/Models/QuotationHistory.php` | ✅ | 100% | Change tracking relationships |
| Payment Model (NEW) | `app/Models/Payment.php` | ✅ | 100% | Payment tracking relationships |
| CalendarEvent Model (NEW) | `app/Models/CalendarEvent.php` | ✅ | 100% | Scheduling relationships |
| Meeting Model (NEW) | `app/Models/Meeting.php` | ✅ | 100% | Meeting management relationships |
| Presentation Model (NEW) | `app/Models/Presentation.php` | ✅ | 100% | File management relationships |
| ReturnItem Model (NEW) | `app/Models/ReturnItem.php` | ✅ | 100% | Pivot model for return items |
| LoginRequest | `app/Http/Requests/LoginRequest.php` | ✅ | 100% | Email/password validation with custom messages |
| RegisterRequest | `app/Http/Requests/RegisterRequest.php` | ✅ | 100% | Profile data and password confirmation validation |
| AuthController | `app/Http/Controllers/AuthController.php` | ✅ | 100% | Full authentication system (login, register, logout) |
| AdminMiddleware | `app/Http/Middleware/AdminMiddleware.php` | ✅ | 100% | Role-based access control middleware |
| Web Routes (Auth) | `routes/web.php` | ✅ | 100% | AuthController integration with proper middleware grouping |
| Bootstrap App Config | `bootstrap/app.php` | ✅ | 100% | AdminMiddleware registration and aliasing |
| BookingController | `app/Http/Controllers/BookingController.php` | 🟠 | 0% | CRUD and workflow methods |
| InventoryController | `app/Http/Controllers/InventoryController.php` | 🟠 | 0% | Stock management |
| AdminController | `app/Http/Controllers/AdminController.php` | 🟠 | 0% | Business logic |
| Additional Form Requests | `app/Http/Requests/` | 🟠 | 0% | BookingRequest, InventoryRequest, etc. |
| API Routes | `routes/api.php` | 🟠 | 0% | RESTful endpoints |

**Legend:** ✅ Complete | 🟡 In Progress | 🟠 Pending | (NEW) = Recently created

---

### Phase 4: Testing & Integration 🟠 Pending (0%)

| Component | Status | Estimated |
|-----------|--------|-----------|
| Feature Tests | 🟠 | 1 week |
| Unit Tests | 🟠 | 1 week |
| Security Testing | 🟠 | 3-4 days |
| Integration Testing | 🟠 | 3-4 days |

**Total Estimated:** 1-2 weeks

---

### Phase 5: Deployment 🟠 Pending (0%)

| Task | Status | Estimated |
|------|--------|-----------|
| Production Configuration | 🟠 | 2-3 days |
| Deployment | 🟠 | 2-3 days |
| Monitoring & Backup | 🟠 | 2-3 days |

**Total Estimated:** 1 week

---

## 6. Process Guidelines & Maintenance

### 6.1 Documentation Update Rules
- **Every Phase Completion:** Update both Progress-Report.md and Planning-documentation.md simultaneously
- **Weekly Reviews:** Verify status indicators match actual implementation state
- **Task Status:** Mark as 🟡 In Progress when work starts, ✅ Complete when tested, 🟠 Pending if not started
- **Add Notes:** Brief descriptions of what was changed and why
- **Keep Reference Current:** Database architecture section is authoritative for developers

### 6.2 Developer Reference

**For Backend Developers (Phases 3+):**
1. Review [Database Architecture & Entity Reference](#database-architecture--entity-reference) section above
2. Use relationship maps to understand data flow
3. Reference enum values in entity sections (booking status, event size, etc.)
4. Cross-check with migration files in `database/migrations/`
5. Verify model relationships in `app/Models/`

**For Frontend Developers:**
- Use Blade components from `resources/views/components/` for consistency
- Reference existing UI pages for patterns and styling
- All pages use Tailwind CSS v4; follow existing class patterns

**For QA & Testing:**
- Phase 3 API endpoints should support all operations defined in entity descriptions
- Verify enum values match database constraints
- Test all relationship cascades (especially deletes)

### 6.3 Change Log

**Documentation & Implementation Updates**

- `2026-06-02` - Initial planning and tracker document created with UI module list
- `2026-06-06` - Updated progress tracker after navbar implementation and auth system
- `2026-06-18` - **Major Documentation Alignment**: 
  - Updated Phase statuses: Phase 1 (DB) ✅ Complete, Phase 2 (UI) ✅ Complete, Phase 3 (API) 🟡 In Progress
  - Added comprehensive Database Architecture & Entity Reference section (15 entity tables with full field documentation)
  - Created detailed entity relationship map showing all 16+ relationships
  - Updated Progress-Report.md with detailed entity table summary
  - Added Phase 3 immediate action items (model relationships, auth system, booking controller)
  - Documented enum values for all status/category fields
  - Added phase completion timelines and estimates
  - **Reason:** Database schema is fully implemented (ERD shows 15 tables); documentation needed to accurately reflect real implementation and guide Phase 3 (API) development
- `2026-06-18` - **Phase 3 Model Implementation Complete (Day 1):**
  - ✅ Added auto-update headers to both Progress-Report.md and Planning-documentation.md
  - ✅ Implemented all 7 existing model relationships (User, Booking, InventoryItem, AiAnalysisResult, AssetReturn, Quotation, Setting)
  - ✅ Created 8 new models: Client, InventoryTransaction, QuotationHistory, Payment, CalendarEvent, Meeting, Presentation, ReturnItem
  - ✅ Configured all fillable attributes and casts (dates, decimals, JSON, booleans)
  - ✅ Implemented all pivot table relationships with withPivot() for eager loading
  - ✅ Updated Progress-Report.md Phase 3 status to 30% complete
  - ✅ Updated Planning-documentation.md Phase 3 progress tracker with all model statuses
  - **Reason:** Model relationships are the foundation for all Phase 3 business logic; completing this first ensures controllers can use eloquent relationships consistently
- `2026-06-19` - **Phase 3.2 Authentication System Complete (Day 2):**
  - ✅ Created LoginRequest.php with email/password/remember validation
  - ✅ Created RegisterRequest.php with name/email/password_confirmation validation
  - ✅ Built AuthController.php with login(), register(), logout(), showForgotPassword() methods
  - ✅ Implemented real Laravel session-based authentication with Hash facade
  - ✅ Added "remember me" functionality for extended sessions
  - ✅ Created AdminMiddleware.php for role-based access control (admin/staff roles)
  - ✅ Updated routes/web.php with AuthController integration
  - ✅ Organized routes with proper middleware grouping (client prefix, admin prefix)
  - ✅ Updated bootstrap/app.php to register AdminMiddleware alias
  - ✅ Updated Progress-Report.md Phase 3 status to 50% complete
  - ✅ Updated Planning-documentation.md Phase 3 progress tracker to reflect full auth system and booking workflow start
  - ✅ Created BookingRequest.php and BookingController.php to support client booking submissions
  - ✅ Added clients table migration and booking schema update to persist booking data
  - **Reason:** Session-based authentication and a real booking workflow are required before booking administration and inventory integration.

---

## 7. Quick Reference: Enum Values & Constraints

### Booking Status Lifecycle
```
inquiry → quotation_sent → downpayment_received → meeting_completed → pre_presentation_sent → in_progress → completed (or cancelled at any point)
```

### Inventory Item Categories
- flower
- foliage
- prop
- supply

### Event Size Tiers
- trust (basic)
- standard (mid-tier)
- advance (premium)

### Payment Types
- downpayment (initial payment)
- balance (final payment)
- refund (return)

### Meeting Types
- online (video conference)
- face_to_face (in-person)

### Return Item Conditions
- good (no damage)
- damaged (partial damage)
- lost (missing)

### Transaction Types (Inventory)
- procurement (purchasing)
- release (for event use)
- return (from client)
- damage (damage recorded)
- adjustment (inventory count correction)
- cancel (order cancelled)

### Presentation Status
- sent (delivered to client)
- changes_requested (client feedback)
- approved (client approved)

---

## 8. Developer Guidelines & Notes

- **Database is the Source of Truth:** All entity definitions, relationships, and constraints in this document are derived from the actual database schema
- **Entity Reference Purpose:** Use this section for understanding data structures and relationships when building controllers or forms
- **Status & Timelines:** For current phase status, completion percentages, timelines, and what's still needed → see **Progress-Report.md**
- **Gap Analysis:** For detailed breakdown of what components are missing → see **Progress-Report.md Section 3 "Current Status Report"**
- **Implementation Roadmap:** For week-by-week priorities and estimated timelines → see **Progress-Report.md Section 2 "Roadmap to Deployment"**
- **Backend Logic:** Developer responsibility to implement controllers using the model relationships defined in this document
- **Two-way Reference:**
  - Planning-documentation.md = Database architecture & entity specifications (detailed technical reference)
  - Progress-Report.md = Status, completion %, timelines, next actions, gaps (executive summary)
- **Updates:** When starting new work, consult Progress-Report.md for current priority order; reference this document for database structure
- **Critical Path:** Inventory → Payments → Returns (these three unlock most business value and enable other workflows)

# BeautyShop — Laravel 13 Backend
## Full Build Specification & Agent Plan

> Version 1.0 | E-Commerce Backend with Admin Panel (Blade), REST API, Role-Based Permissions, Variants, Media Management, and Store Settings.

---

## TABLE OF CONTENTS

1. [Project Overview](#1-project-overview)
2. [Tech Stack & Prerequisites](#2-tech-stack--prerequisites)
3. [Agent Plan (Build Phases)](#3-agent-plan-build-phases)
4. [Extended Database Schema](#4-extended-database-schema)
5. [Role & Permission System](#5-role--permission-system)
6. [Product Variants System](#6-product-variants-system)
7. [Media Management System](#7-media-management-system)
8. [Store Settings (Logo, Slides, Social)](#8-store-settings-logo-slides-social)
9. [Order Management System](#9-order-management-system)
10. [Full API Specification](#10-full-api-specification)
11. [Admin Panel — Blade Views](#11-admin-panel--blade-views)
12. [Dashboard Statistics](#12-dashboard-statistics)
13. [Authentication & Security](#13-authentication--security)
14. [File & Folder Structure](#14-file--folder-structure)
15. [Seeders & Factory Data](#15-seeders--factory-data)
16. [Environment & Configuration](#16-environment--configuration)

---

## 1. Project Overview

BeautyShop is a full-featured beauty e-commerce platform. The Laravel backend serves two purposes:

1. **REST API** — consumed by the React frontend (all public + auth + admin endpoints).
2. **Admin Panel** — Blade-based, served at `/admin/*`, for internal staff to manage the store.

### Core Capabilities

| Feature | Detail |
|---|---|
| Authentication | Laravel Sanctum (API tokens + session for Blade admin) |
| Roles | `super_admin`, `admin`, `staff` with granular permissions |
| Products | With variants (size, color, shade, etc.) and per-variant stock/price |
| Media | Image upload, auto-resize (thumbnail/medium/large), soft-delete |
| Orders | Full lifecycle from cart → checkout → fulfilment |
| Homepage Slides | Editable via admin (image, title, CTA link) |
| Store Settings | Logo, favicon, social links, contact info, SEO defaults |
| Reviews | Moderated, approve/reject, linked to verified purchases |
| Contacts | Inbox with read/unread state |
| Dashboard | Revenue charts, order funnel, low-stock alerts, top products |

---

## 2. Tech Stack & Prerequisites

| Layer | Choice |
|---|---|
| Framework | Laravel 13 |
| PHP | 8.4+ |
| Database | MySQL 8 / PostgreSQL 15 |
| Auth | Laravel Sanctum |
| Permissions | Spatie Laravel Permission (`spatie/laravel-permission`) |
| Image Processing | Spatie Media Library (`spatie/laravel-medialibrary`) + Intervention Image |
| Admin UI | Blade + Alpine.js + Tailwind CSS (via CDN or Vite) |
| Charts | ApexCharts (CDN, used in Blade dashboard) |
| Queue | Laravel Queue (database driver, upgradeable to Redis) |
| Storage | Local disk (upgradeable to S3) |
| Testing | PestPHP |

### Composer Packages

```bash
composer require spatie/laravel-permission
composer require spatie/laravel-medialibrary
composer require intervention/image-laravel
composer require laravel/sanctum
composer require spatie/laravel-sluggable

# Dev
composer require --dev pestphp/pest
```

---

## 3. Agent Plan (Build Phases)

Each "agent" is a focused build task. They should be executed in order due to dependencies.

---

### AGENT 1 — Foundation & Auth

**Goal:** Laravel project setup, database, auth scaffolding, Sanctum, roles/permissions.

**Tasks:**
- [ ] Fresh Laravel 13 install
- [ ] Configure `.env` (DB, mail, filesystem, queue)
- [ ] Install and publish Sanctum, Spatie Permission
- [ ] Modify `users` table migration (add `phone`, `avatar`, `is_active`, `role` via Spatie)
- [ ] Create `User` model with `HasRoles` trait
- [ ] Define roles and permissions in `DatabaseSeeder` / `RoleSeeder`
- [ ] Build `AuthController` — register, login, logout, me, update profile, forgot password
- [ ] API routes in `routes/api.php` under `v1` prefix
- [ ] Auth middleware group for admin Blade panel (`auth` + `role:admin|staff`)
- [ ] Admin login Blade page at `/admin/login`

**Deliverables:**
- `app/Http/Controllers/Api/V1/AuthController.php`
- `app/Http/Controllers/Admin/Auth/LoginController.php`
- `database/migrations/*_create_users_table.php` (modified)
- `database/seeders/RoleSeeder.php`
- `routes/api.php`
- `routes/admin.php`
- `resources/views/admin/auth/login.blade.php`

---

### AGENT 2 — Categories & Products (Core CRUD)

**Goal:** Full categories and products system — migrations, models, API, admin Blade CRUD.

**Tasks:**
- [ ] Migrations: `categories`, `products`, `product_images`
- [ ] Models with relationships, sluggable trait
- [ ] `CategoryController` (API + Admin)
- [ ] `ProductController` (API + Admin)
- [ ] Product listing with filters: category, price range, sort, search, pagination
- [ ] Featured products endpoint
- [ ] Admin Blade: categories index, create/edit form
- [ ] Admin Blade: products index (with search/filter), create/edit form
- [ ] Image upload for category and product (basic, full media in Agent 5)
- [ ] Form Request Validation classes for all inputs

**Deliverables:**
- Migrations for `categories`, `products`, `product_images`
- `app/Models/{Category,Product,ProductImage}.php`
- `app/Http/Controllers/Api/V1/{Category,Product}Controller.php`
- `app/Http/Controllers/Admin/{Category,Product}Controller.php`
- `app/Http/Requests/Admin/{Store,Update}ProductRequest.php`
- Blade views: `admin/categories/*`, `admin/products/*`
- `app/Http/Resources/Api/V1/{Product,Category}Resource.php`

---

### AGENT 3 — Product Variants System

**Goal:** Full variant system — types (size, color, shade), combinations, stock and pricing per variant.

**Tasks:**
- [ ] Migrations: `variant_types`, `variant_options`, `product_variants`, `product_variant_options`
- [ ] Models and relationships
- [ ] Seeder: default variant types (Size, Color, Shade, Volume)
- [ ] Admin Blade: variant type/option management (global)
- [ ] Admin Blade: attach variants to products — dynamic JS form to build combinations
- [ ] API: product detail includes variants with options, stock, price override
- [ ] Stock management: per-variant OR product-level (flag `uses_variants`)
- [ ] Low-stock alert threshold setting (configurable per product, default 5)

**Schema additions:**

```
variant_types:       id, name (Size/Color/Shade), slug, sort_order
variant_options:     id, variant_type_id, value (Small/Red/Rose Gold), hex_color (nullable), sort_order
product_variants:    id, product_id, sku, price_override (nullable), stock, is_active
product_variant_options: id, product_variant_id, variant_option_id
```

**Deliverables:**
- 4 new migrations
- `app/Models/{VariantType,VariantOption,ProductVariant,ProductVariantOption}.php`
- `app/Http/Controllers/Admin/VariantController.php`
- `resources/views/admin/products/variants.blade.php`
- Updated `ProductResource` to include variants

---

### AGENT 4 — Cart & Order System

**Goal:** Full cart lifecycle, order placement, status transitions, admin order management.

**Tasks:**
- [ ] Migrations: `cart_items`, `orders`, `order_items`
- [ ] `CartController` — add, update, remove, clear, sync guest cart
- [ ] `OrderController` — place order, user order history, admin full order management
- [ ] Order number generation (e.g. `BS-20250001`)
- [ ] Order status state machine: `pending → confirmed → processing → shipped → delivered | cancelled`
- [ ] Admin: order index with status filter tabs, detail view, status update
- [ ] Admin: print-friendly order invoice view
- [ ] Stock decrement on order placement; stock restore on cancellation
- [ ] Variant stock handling (deduct from correct variant)
- [ ] Email notifications: order confirmation to customer, new order alert to admin

**Order Status State Machine:**

```
pending ──► confirmed ──► processing ──► shipped ──► delivered
   │                                                      
   └──────────────────── cancelled (from any state except delivered)
```

**Deliverables:**
- Migrations for `cart_items`, `orders`, `order_items`
- `app/Models/{CartItem,Order,OrderItem}.php`
- `app/Http/Controllers/Api/V1/{Cart,Order}Controller.php`
- `app/Http/Controllers/Admin/OrderController.php`
- `app/Mail/{OrderConfirmation,NewOrderAlert}.php`
- `resources/views/emails/order_confirmation.blade.php`
- `resources/views/admin/orders/{index,show,invoice}.blade.php`

---

### AGENT 5 — Media Management System

**Goal:** Centralized media handling — upload, auto-resize to multiple sizes, reorder, soft-delete.

**Tasks:**
- [ ] Install and configure Spatie Media Library
- [ ] Register media collections on `Product`, `Category`, `Slide`, `User` models
- [ ] Define conversions: `thumb` (150×150), `medium` (600×600), `large` (1200×1200)
- [ ] `MediaController` for product images: upload, reorder (sort_order), delete
- [ ] Admin Blade: drag-and-drop image gallery on product edit page (Alpine.js + Sortable.js)
- [ ] Admin Blade: single image upload for categories and slides
- [ ] Fallback placeholder images
- [ ] Disk configuration: local (`public`) with symlink, optional S3 switch

**Media Collections per Model:**

| Model | Collection | Max Files | Conversions |
|---|---|---|---|
| Product | `product_images` | 10 | thumb, medium, large |
| Category | `category_image` | 1 | thumb, medium |
| Slide | `slide_image` | 1 | large (1920×600 crop) |
| User | `avatar` | 1 | thumb (100×100) |

**Deliverables:**
- Updated models with `InteractsWithMedia`
- `app/Http/Controllers/Admin/MediaController.php`
- `config/media-library.php` customizations
- `resources/views/admin/partials/media-uploader.blade.php`
- `resources/views/admin/partials/image-gallery.blade.php`

---

### AGENT 6 — Store Settings (Slides, Logo, Social, SEO)

**Goal:** Fully configurable store settings — all editable from admin.

**Tasks:**
- [ ] Migration: `settings` (key/value) + `slides`
- [ ] Seeder: default settings keys
- [ ] `SettingController` — get all, update (bulk upsert)
- [ ] Slide CRUD: title, subtitle, button text, button link, image, sort_order, is_active
- [ ] Admin Blade: settings page with sections (General, Social, SEO, Contact)
- [ ] Admin Blade: slides manager — live preview, reorder, toggle active
- [ ] `SettingsHelper` facade for reading settings anywhere: `Settings::get('store_name')`
- [ ] Cache settings with `Cache::remember` (invalidate on save)

**Settings Keys (default seed):**

```
General:        store_name, store_email, store_phone, store_address, logo, favicon
Social:         facebook_url, instagram_url, twitter_url, tiktok_url, youtube_url
SEO:            meta_title, meta_description, meta_keywords, google_analytics_id
Contact:        contact_map_embed, contact_hours
Checkout:       free_shipping_threshold, tax_rate, currency, currency_symbol
```

**Slides table:**
```
id, title, subtitle, button_text, button_link, sort_order, is_active, timestamps
+ media via Spatie
```

**Deliverables:**
- Migration for `settings`, `slides`
- `app/Models/{Setting,Slide}.php`
- `app/Http/Controllers/Api/V1/SettingController.php`
- `app/Http/Controllers/Admin/SettingController.php`
- `app/Http/Controllers/Admin/SlideController.php`
- `app/Helpers/SettingsHelper.php`
- `resources/views/admin/settings/{general,social,seo,slides}.blade.php`

---

### AGENT 7 — Reviews & Contacts

**Goal:** Product reviews with moderation; contact form inbox.

**Tasks:**
- [ ] Migrations: `reviews`, `contacts`
- [ ] `ReviewController` — submit (API), approve/reject/delete (Admin)
- [ ] `ContactController` — submit (API), list/read/delete (Admin)
- [ ] Reviews: verified purchase check (user must have ordered the product)
- [ ] After approve: update `products.rating` and `products.reviews_count` (Observer)
- [ ] Admin Blade: reviews index with pending/approved tabs
- [ ] Admin Blade: contacts inbox list + detail modal
- [ ] Unread contacts badge in sidebar nav

**Deliverables:**
- `app/Models/{Review,Contact}.php`
- `app/Http/Controllers/Api/V1/{Review,Contact}Controller.php`
- `app/Http/Controllers/Admin/{Review,Contact}Controller.php`
- `app/Observers/ReviewObserver.php`
- `resources/views/admin/{reviews,contacts}/*`

---

### AGENT 8 — Role-Based Admin Panel & Permissions

**Goal:** Granular role/permission system for admin, staff, and super_admin.

**Roles:**

| Role | Description |
|---|---|
| `super_admin` | Full access, cannot be restricted |
| `admin` | Full access except cannot delete super_admin accounts |
| `staff` | Access controlled by per-permission flags set by admin |

**All Permission Slugs:**

```
products.view      products.create    products.edit      products.delete
categories.view    categories.create  categories.edit    categories.delete
orders.view        orders.edit        orders.export
reviews.view       reviews.moderate
contacts.view      contacts.delete
users.view         users.edit
settings.view      settings.edit
media.upload       media.delete
reports.view
```

**Tasks:**
- [ ] Seed all permissions with Spatie
- [ ] Assign permission groups to roles (super_admin/admin = all; staff = configurable)
- [ ] Admin Blade: Staff management — create staff user, toggle each permission
- [ ] Middleware: `PermissionMiddleware` on each admin route
- [ ] Blade `@can` directives in views to hide/show actions
- [ ] Permission matrix table in admin UI (checkbox grid per staff user)

**Deliverables:**
- `database/seeders/PermissionSeeder.php`
- `app/Http/Controllers/Admin/StaffController.php`
- `app/Http/Middleware/CheckPermission.php`
- `resources/views/admin/staff/{index,edit-permissions}.blade.php`

---

### AGENT 9 — Dashboard & Analytics

**Goal:** Professional dashboard with real statistics and charts.

**Stats Cards (top row):**
- Total Revenue (this month vs last month, % change)
- Total Orders (with pending count badge)
- Total Products (with low-stock count)
- Total Customers (new this month)

**Charts:**
- Revenue over last 12 months (line chart — ApexCharts)
- Orders by status (donut chart)
- Top 5 selling products (horizontal bar chart)
- Orders by day this week (bar chart)

**Data Tables:**
- Latest 5 orders (with status badge, quick view link)
- Low stock products (stock ≤ threshold, with quick edit link)
- Recent contact messages (unread count badge)

**Tasks:**
- [ ] `DashboardController` with all stats queries (optimized with DB aggregates)
- [ ] JSON endpoints for chart data (AJAX refreshable)
- [ ] Admin Blade: full dashboard layout with cards + charts
- [ ] Cache dashboard stats for 5 minutes

**Deliverables:**
- `app/Http/Controllers/Admin/DashboardController.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/partials/charts/*.blade.php`

---

### AGENT 10 — Admin UI Layout & Design System

**Goal:** Polished, professional Blade admin layout — formal fonts, consistent components.

**Design Specs:**

| Property | Value |
|---|---|
| Font (headings) | Inter or DM Sans (Google Fonts) |
| Font (body) | Inter Regular 14–15px |
| Primary Color | Deep slate `#1e293b` |
| Accent Color | Rose/mauve `#e11d48` |
| Sidebar bg | `#0f172a` |
| Card bg | `#ffffff` |
| Border radius | 8px |
| Icon library | Heroicons (via CDN) |

**Layout Components:**
- `layouts/admin.blade.php` — sidebar + topbar + content slot
- `layouts/auth.blade.php` — centered card for login
- `partials/sidebar.blade.php` — collapsible nav with permission-aware links
- `partials/topbar.blade.php` — breadcrumb, notifications bell, user dropdown
- `partials/alert.blade.php` — success/error flash messages
- `partials/pagination.blade.php` — styled Tailwind pagination
- `partials/confirm-modal.blade.php` — Alpine.js delete confirmation

**Sidebar Navigation Sections:**
```
Dashboard
─── Catalog
    Products
    Categories
    Variants
─── Sales
    Orders
    Reviews
─── Customers
    Users
─── Content
    Slides
    Settings
─── System
    Staff & Permissions
    (super_admin only)
```

**Deliverables:**
- `resources/views/admin/layouts/`
- `resources/views/admin/partials/`
- `public/css/admin.css` (or Tailwind via Vite)
- `public/js/admin.js` (Alpine.js init, confirm dialogs, toast notifications)

---

## 4. Extended Database Schema

### New Tables (beyond original spec)

#### `variant_types`
```sql
id, name VARCHAR(100), slug VARCHAR(100) UNIQUE, sort_order INT DEFAULT 0, timestamps
```

#### `variant_options`
```sql
id, variant_type_id FK, value VARCHAR(100), hex_color VARCHAR(7) NULLABLE,
sort_order INT DEFAULT 0, timestamps
```

#### `product_variants`
```sql
id, product_id FK, sku VARCHAR(100) UNIQUE NULLABLE,
price_override DECIMAL(10,2) NULLABLE, stock INT DEFAULT 0,
is_active BOOLEAN DEFAULT true, timestamps
```

#### `product_variant_options` (pivot)
```sql
id, product_variant_id FK, variant_option_id FK
```

#### `slides`
```sql
id, title VARCHAR(200), subtitle TEXT NULLABLE,
button_text VARCHAR(100) NULLABLE, button_link VARCHAR(255) NULLABLE,
sort_order INT DEFAULT 0, is_active BOOLEAN DEFAULT true, timestamps
```

#### `settings`
```sql
id, key VARCHAR(100) UNIQUE, value TEXT, group VARCHAR(50) DEFAULT 'general', timestamps
```

#### `permissions` / `roles` / pivot tables
> Managed by `spatie/laravel-permission` — no manual migration needed.

### Modified Tables

#### `products` — add columns
```sql
uses_variants BOOLEAN DEFAULT false,
low_stock_threshold INT DEFAULT 5,
weight DECIMAL(8,2) NULLABLE,       -- for shipping calc
sku VARCHAR(100) NULLABLE UNIQUE
```

#### `orders` — add columns
```sql
coupon_code VARCHAR(50) NULLABLE,
payment_method VARCHAR(50) DEFAULT 'cod',
payment_status ENUM('pending','paid','refunded') DEFAULT 'pending',
tracking_number VARCHAR(100) NULLABLE,
shipped_at TIMESTAMP NULLABLE,
delivered_at TIMESTAMP NULLABLE,
cancelled_at TIMESTAMP NULLABLE,
cancelled_reason TEXT NULLABLE
```

---

## 5. Role & Permission System

### Role Hierarchy

```
super_admin
    └── admin
            └── staff (permissions individually assigned)
```

### Permission Assignment Matrix

| Permission | super_admin | admin | staff (default) |
|---|---|---|---|
| products.view | ✅ | ✅ | ✅ |
| products.create | ✅ | ✅ | ❌ |
| products.edit | ✅ | ✅ | ❌ |
| products.delete | ✅ | ✅ | ❌ |
| categories.* | ✅ | ✅ | ❌ |
| orders.view | ✅ | ✅ | ✅ |
| orders.edit | ✅ | ✅ | ❌ |
| orders.export | ✅ | ✅ | ❌ |
| reviews.moderate | ✅ | ✅ | ❌ |
| contacts.view | ✅ | ✅ | ✅ |
| users.edit | ✅ | ✅ | ❌ |
| settings.edit | ✅ | ✅ | ❌ |
| media.upload | ✅ | ✅ | ✅ |
| reports.view | ✅ | ✅ | ❌ |

### Implementation Notes
- Use `@can('products.edit')` in Blade views for conditional rendering.
- Use `$this->authorize('products.edit')` in controllers.
- Admin route group wraps in `middleware(['auth', 'verified', 'role:super_admin|admin|staff'])`.
- Each admin sub-route additionally checks the specific permission.

---

## 6. Product Variants System

### Concept

A product can either:
- **Simple product** — `uses_variants = false`, stock stored on `products.stock`
- **Variable product** — `uses_variants = true`, stock per variant in `product_variants.stock`

### Variant Combination Example

Product: *Matte Lipstick*
- Variant Type 1: **Shade** → Options: Rose Gold, Berry, Nude
- Variant Type 2: **Size** → Options: 3.5g, 5g

Generated combinations (product_variants):
```
Rose Gold + 3.5g → SKU: LIP-RG-S, price: $12, stock: 20
Rose Gold + 5g   → SKU: LIP-RG-L, price: $16, stock: 15
Berry + 3.5g     → SKU: LIP-BR-S, price: $12, stock: 8
...etc
```

### Admin Flow
1. On product edit page, check "This product has variants"
2. Select variant types (e.g. Shade + Size)
3. Add options to each type
4. Click "Generate Combinations" — system creates all possible variant rows
5. Admin fills in SKU, price override, stock per row
6. Can deactivate specific combinations

### API Response Structure

```json
{
  "id": 1,
  "name": "Matte Lipstick",
  "uses_variants": true,
  "price": 12.00,
  "variants": [
    {
      "id": 1,
      "sku": "LIP-RG-S",
      "price_override": 12.00,
      "stock": 20,
      "is_active": true,
      "options": [
        { "type": "Shade", "value": "Rose Gold", "hex_color": "#b76e79" },
        { "type": "Size",  "value": "3.5g" }
      ]
    }
  ]
}
```

---

## 7. Media Management System

### Spatie Media Library Setup

Each model registers collections in `registerMediaCollections()`:

```php
// Product model
public function registerMediaCollections(): void
{
    $this->addMediaCollection('product_images')
         ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
}

public function registerMediaConversions(Media $media = null): void
{
    $this->addMediaConversion('thumb')
         ->width(150)->height(150)->crop(Manipulations::CROP_CENTER);

    $this->addMediaConversion('medium')
         ->width(600)->height(600)->fit(Manipulations::FIT_CONTAIN);

    $this->addMediaConversion('large')
         ->width(1200)->height(1200)->fit(Manipulations::FIT_CONTAIN);
}
```

### Upload Endpoint (Admin API)

`POST /admin/products/{id}/images`
- Accepts: `multipart/form-data`, field `images[]` (multiple files)
- Max size: 5MB per file
- Returns: array of media objects with all conversion URLs

### Image Reordering

`PUT /admin/products/{id}/images/reorder`
- Body: `{ "order": [3, 1, 2, 5] }` (media IDs in new order)
- Updates `order_column` on media table

### Delete

`DELETE /admin/media/{mediaId}`
- Soft-deletes media record and queues file cleanup job

### Frontend URL Helpers

```php
// In Blade
$product->getFirstMediaUrl('product_images', 'medium')

// In API Resource
'images' => $this->getMedia('product_images')->map(fn($m) => [
    'id'     => $m->id,
    'thumb'  => $m->getUrl('thumb'),
    'medium' => $m->getUrl('medium'),
    'large'  => $m->getUrl('large'),
    'order'  => $m->order_column,
])
```

---

## 8. Store Settings (Logo, Slides, Social, SEO)

### Settings Architecture

Settings are stored as key/value in the `settings` table, grouped for UI display. Access anywhere via the helper:

```php
Settings::get('store_name')          // returns value
Settings::set('store_name', 'Beauty') // upserts
Settings::all('social')              // returns all keys in group
```

### Logo & Favicon Upload Flow
1. Admin uploads file on Settings → General tab.
2. Stored via Spatie media collection on a singleton `StoreProfile` model.
3. `Settings::get('logo_url')` returns the current logo media URL.
4. Old logo media is deleted on replacement.

### Slides Manager

The homepage carousel is fully managed in admin:

| Field | Input Type | Notes |
|---|---|---|
| Image | File upload | Auto-resized to 1920×600 |
| Title | Text | Displayed as H1 overlay |
| Subtitle | Textarea | Secondary text |
| Button Text | Text | CTA label |
| Button Link | Text | Internal route or external URL |
| Sort Order | Number | Drag-to-reorder in UI |
| Active | Toggle | Show/hide without deleting |

**API endpoint for frontend:** `GET /api/v1/slides` — returns active slides sorted by `sort_order`.

### Social Media Links

Stored as individual settings keys:

```
facebook_url, instagram_url, twitter_url, tiktok_url, youtube_url, pinterest_url
```

Rendered in `admin/settings/social.blade.php` with brand-colored input icons.

---

## 9. Order Management System

### Order Lifecycle

```
Customer places order
    │
    ▼
[pending]  ← default on creation
    │
    ▼ (admin confirms stock + payment)
[confirmed]
    │
    ▼ (packing)
[processing]
    │
    ▼ (shipped, tracking added)
[shipped]
    │
    ▼ (delivery confirmed)
[delivered]

[cancelled] ← from pending, confirmed, or processing only
```

### Status Change Rules

| From | Can Go To |
|---|---|
| pending | confirmed, cancelled |
| confirmed | processing, cancelled |
| processing | shipped, cancelled |
| shipped | delivered |
| delivered | _(terminal)_ |
| cancelled | _(terminal)_ |

### Admin Order Index Features
- Tabs: All / Pending / Processing / Shipped / Delivered / Cancelled
- Search by order number, customer name, email
- Date range filter
- Status bulk update (select multiple → change status)
- Export to CSV (orders.export permission required)

### Print Invoice
Route: `GET /admin/orders/{id}/invoice` → renders `orders/invoice.blade.php`
- Formal A4 layout
- Store logo, name, address
- Customer shipping info
- Line items table
- Totals (subtotal, shipping, tax, discount, total)
- `window.print()` triggered on page load (optional param)

---

## 10. Full API Specification

Base URL: `/api/v1`
Auth: Bearer token (Sanctum) on protected routes.
Response format: JSON, always `{ data, meta?, message?, errors? }`

### Public Routes

| Method | Path | Description |
|---|---|---|
| GET | `/products` | Paginated product list |
| GET | `/products/featured` | Featured products (max 8) |
| GET | `/products/{slug}` | Single product with variants, images, reviews |
| GET | `/categories` | All active categories |
| GET | `/categories/{slug}/products` | Products in category |
| GET | `/slides` | Active slides for homepage carousel |
| GET | `/settings` | Public settings (store name, social, etc.) |
| GET | `/reviews` | Approved reviews (`?product_id=X`) |
| POST | `/contacts` | Submit contact form |
| POST | `/auth/register` | Register new customer |
| POST | `/auth/login` | Login → returns token |
| POST | `/auth/forgot-password` | Send reset link |
| POST | `/auth/reset-password` | Reset with token |

### Query Parameters for `GET /products`

| Param | Type | Example |
|---|---|---|
| `category` | string | `skincare` |
| `min_price` | number | `10` |
| `max_price` | number | `150` |
| `sort` | enum | `price_low`, `price_high`, `name_asc`, `rating`, `newest` |
| `search` | string | `serum` |
| `featured` | boolean | `1` |
| `in_stock` | boolean | `1` |
| `page` | int | `2` |
| `per_page` | int | default `9`, max `48` |

### Authenticated User Routes (`/auth/me` required)

| Method | Path | Description |
|---|---|---|
| GET | `/auth/me` | Profile |
| PUT | `/auth/me` | Update profile |
| POST | `/auth/logout` | Revoke token |
| GET | `/cart` | Cart items |
| POST | `/cart/add` | Add item `{product_id, variant_id?, quantity}` |
| PUT | `/cart/{id}` | Update quantity |
| DELETE | `/cart/{id}` | Remove item |
| DELETE | `/cart` | Clear cart |
| POST | `/cart/sync` | Merge guest cart on login |
| GET | `/orders` | Order history |
| GET | `/orders/{id}` | Order detail |
| POST | `/orders` | Place order from cart |
| POST | `/reviews` | Submit review |

### Admin Routes (role: admin|staff + permissions)

| Method | Path | Permission |
|---|---|---|
| GET | `/admin/dashboard` | — |
| GET | `/admin/dashboard/chart-data` | reports.view |
| GET | `/admin/products` | products.view |
| POST | `/admin/products` | products.create |
| PUT | `/admin/products/{id}` | products.edit |
| DELETE | `/admin/products/{id}` | products.delete |
| POST | `/admin/products/{id}/images` | media.upload |
| PUT | `/admin/products/{id}/images/reorder` | media.upload |
| DELETE | `/admin/media/{id}` | media.delete |
| GET/POST/PUT/DELETE | `/admin/categories/*` | categories.* |
| GET | `/admin/variants` | products.view |
| POST/PUT/DELETE | `/admin/variants/*` | products.edit |
| GET | `/admin/orders` | orders.view |
| PUT | `/admin/orders/{id}/status` | orders.edit |
| GET | `/admin/orders/{id}/invoice` | orders.view |
| GET | `/admin/reviews` | reviews.view |
| PUT | `/admin/reviews/{id}/approve` | reviews.moderate |
| GET | `/admin/contacts` | contacts.view |
| PUT | `/admin/contacts/{id}/read` | contacts.view |
| GET | `/admin/slides` | settings.view |
| POST/PUT/DELETE | `/admin/slides/*` | settings.edit |
| GET | `/admin/settings` | settings.view |
| PUT | `/admin/settings` | settings.edit |
| GET | `/admin/users` | users.view |
| PUT | `/admin/users/{id}` | users.edit |
| GET/PUT | `/admin/staff/{id}/permissions` | super_admin only |

---

## 11. Admin Panel — Blade Views

### View Map

```
resources/views/admin/
├── layouts/
│   ├── admin.blade.php          ← main layout (sidebar + topbar)
│   └── auth.blade.php           ← login layout
├── partials/
│   ├── sidebar.blade.php
│   ├── topbar.blade.php
│   ├── alert.blade.php
│   ├── pagination.blade.php
│   ├── confirm-modal.blade.php
│   ├── media-uploader.blade.php
│   └── image-gallery.blade.php
├── auth/
│   └── login.blade.php
├── dashboard.blade.php
├── products/
│   ├── index.blade.php          ← search, filter, table
│   ├── create.blade.php
│   ├── edit.blade.php           ← includes media gallery + variants tab
│   └── variants.blade.php       ← variant builder (partial)
├── categories/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── orders/
│   ├── index.blade.php          ← tabbed by status
│   ├── show.blade.php           ← detail with timeline
│   └── invoice.blade.php        ← print-ready
├── reviews/
│   └── index.blade.php          ← pending/approved tabs
├── contacts/
│   └── index.blade.php          ← inbox with detail panel
├── users/
│   └── index.blade.php
├── staff/
│   ├── index.blade.php
│   └── permissions.blade.php    ← permission matrix
└── settings/
    ├── general.blade.php        ← store info, logo, favicon
    ├── social.blade.php         ← social links
    ├── seo.blade.php
    └── slides.blade.php         ← slide manager
```

---

## 12. Dashboard Statistics

### PHP Queries (DashboardController)

```php
// Revenue this month vs last month
$revenueThisMonth = Order::whereMonth('created_at', now()->month)
    ->where('status', '!=', 'cancelled')
    ->sum('total');

// Orders count by status
$ordersByStatus = Order::selectRaw('status, count(*) as count')
    ->groupBy('status')->pluck('count', 'status');

// Top 5 products by quantity sold
$topProducts = OrderItem::selectRaw('product_name, sum(quantity) as sold')
    ->groupBy('product_name')
    ->orderByDesc('sold')->limit(5)->get();

// Low stock products
$lowStock = Product::where('uses_variants', false)
    ->whereColumn('stock', '<=', 'low_stock_threshold')
    ->orWhereHas('variants', fn($q) =>
        $q->whereColumn('stock', '<=', DB::raw(5))
    )->get();

// Revenue by month (last 12)
$monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
    ->where('created_at', '>=', now()->subMonths(12))
    ->where('status', '!=', 'cancelled')
    ->groupBy('month')->orderBy('month')->get();
```

### Chart Configs (ApexCharts in Blade)

- **Revenue line chart** — 12 data points, area fill, currency tooltip
- **Orders donut** — 6 status slices with status-colored segments
- **Top products bar** — horizontal, sorted descending
- **Weekly orders bar** — 7 days, bar per day

---

## 13. Authentication & Security

### API Auth (Sanctum)
- Login returns `{ token, user }` — token stored in React as `localStorage` item.
- Token expiry: 30 days (configurable).
- Logout revokes current token.
- Password reset uses signed URLs via email.

### Admin Panel Auth (Session)
- Blade admin uses standard Laravel session auth.
- After login: redirect to `/admin/dashboard`.
- Protected by `auth` + role middleware.
- CSRF protection on all POST/PUT/DELETE forms.

### Security Headers (Middleware)
```php
// App\Http\Middleware\SecurityHeaders
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
```

### Rate Limiting
```php
RateLimiter::for('api', fn($req) =>
    Limit::perMinute(60)->by($req->user()?->id ?: $req->ip())
);

RateLimiter::for('auth', fn($req) =>
    Limit::perMinute(5)->by($req->ip())  // strict for login
);
```

### Input Validation
All endpoints use dedicated `FormRequest` classes. Example:

```php
class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:200',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'description'   => 'required|string',
            'stock'         => 'required_if:uses_variants,false|integer|min:0',
            'features'      => 'nullable|array',
            'features.*'    => 'string|max:200',
            'is_featured'   => 'boolean',
            'meta_title'    => 'nullable|string|max:200',
        ];
    }
}
```

---

## 14. File & Folder Structure

```
app/
├── Console/Commands/
│   └── GenerateOrderNumber.php
├── Exceptions/
│   └── Handler.php              ← JSON error responses for API
├── Helpers/
│   └── SettingsHelper.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── VariantController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ReviewController.php
│   │   │   ├── ContactController.php
│   │   │   ├── MediaController.php
│   │   │   ├── SlideController.php
│   │   │   ├── SettingController.php
│   │   │   ├── UserController.php
│   │   │   └── StaffController.php
│   │   └── Api/V1/
│   │       ├── AuthController.php
│   │       ├── ProductController.php
│   │       ├── CategoryController.php
│   │       ├── CartController.php
│   │       ├── OrderController.php
│   │       ├── ReviewController.php
│   │       ├── ContactController.php
│   │       └── SettingController.php
│   ├── Middleware/
│   │   ├── CheckPermission.php
│   │   └── SecurityHeaders.php
│   ├── Requests/
│   │   ├── Admin/
│   │   └── Api/
│   └── Resources/
│       └── Api/V1/
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── Product.php
│   ├── ProductImage.php
│   ├── ProductVariant.php
│   ├── VariantType.php
│   ├── VariantOption.php
│   ├── ProductVariantOption.php
│   ├── CartItem.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Review.php
│   ├── Contact.php
│   ├── Setting.php
│   └── Slide.php
├── Observers/
│   └── ReviewObserver.php
├── Mail/
│   ├── OrderConfirmation.php
│   └── NewOrderAlert.php
└── Services/
    ├── CartService.php
    ├── OrderService.php
    └── MediaService.php

database/
├── migrations/        ← one file per table, ordered
├── seeders/
│   ├── DatabaseSeeder.php
│   ├── RoleSeeder.php
│   ├── PermissionSeeder.php
│   ├── SettingSeeder.php
│   ├── CategorySeeder.php
│   └── ProductSeeder.php
└── factories/
    ├── ProductFactory.php
    ├── OrderFactory.php
    └── UserFactory.php

routes/
├── api.php           ← /api/v1/* routes
├── admin.php         ← /admin/* Blade routes (included in web.php)
└── web.php

resources/views/
└── admin/            ← (see §11 view map)
```

---

## 15. Seeders & Factory Data

### RoleSeeder

```php
$roles = ['super_admin', 'admin', 'staff'];
// creates roles, assigns all permissions to super_admin and admin
// creates default super_admin user: admin@beautyshop.com / password
```

### SettingSeeder

Seeds all default setting keys with empty or placeholder values so the settings form always loads all fields correctly.

### CategorySeeder

Seeds 4 default categories: `Skincare`, `Makeup`, `Haircare`, `Tools & Accessories` with slugs and sort orders.

### ProductSeeder (Dev/Staging only)

Uses `ProductFactory` to generate 40 sample products with random category assignment, pricing, and stock. Uses placeholder image URLs from `picsum.photos`.

---

## 16. Environment & Configuration

### `.env` Keys to Configure

```env
APP_NAME="BeautyShop"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_DATABASE=beautyshop
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000  # React dev

FILESYSTEM_DISK=public

MAIL_MAILER=smtp
MAIL_FROM_ADDRESS="noreply@beautyshop.com"
MAIL_FROM_NAME="BeautyShop"

QUEUE_CONNECTION=database

# Optional S3
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=beautyshop-media
```

### `config/cors.php`

```php
'paths'           => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```

### Key Artisan Commands (post-setup)

```bash
php artisan migrate --seed
php artisan storage:link
php artisan sanctum:install
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider"
php artisan queue:work          # for image conversion jobs
```

---

*End of Specification — BeautyShop Laravel Backend v1.0*
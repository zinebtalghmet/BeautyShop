# BeautyShop Backend Specification (Laravel)

> Full specification for building the Laravel backend with admin views, based on the React frontend.

---

## 1. Database Tables (Migrations)

### 1.1 `categories`

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| name | string(100) | e.g. "Skincare", "Makeup", "Tools & Accessories", "Haircare" |
| slug | string(100) | unique, used in API |
| description | text | nullable |
| image | string(255) | nullable |
| sort_order | integer | default 0 |
| is_active | boolean | default true |
| created_at / updated_at | timestamps | |

### 1.2 `products`

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| category_id | foreignId | FK → categories.id |
| name | string(200) | |
| slug | string(200) | unique |
| description | text | |
| features | json | array of feature strings |
| price | decimal(10,2) | |
| original_price | decimal(10,2) | nullable |
| discount | integer | 0–100, computed or stored |
| stock | integer | default 0 |
| rating | decimal(2,1) | default 0.0 |
| reviews_count | integer | default 0 |
| is_featured | boolean | default false |
| is_active | boolean | default true |
| meta_title | string(200) | nullable, SEO |
| meta_description | text | nullable, SEO |
| created_at / updated_at | timestamps | |

### 1.3 `product_images`

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| product_id | foreignId | FK → products.id (cascade) |
| image | string(255) | path/filename |
| sort_order | integer | default 0 |
| created_at / updated_at | timestamps | |

### 1.4 `cart_items`

> Server-side cart for logged-in users (guest carts stored in localStorage remain client-side until login).

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| user_id | foreignId | FK → users.id (nullable for guest) |
| session_id | string(100) | nullable, for guest carts |
| product_id | foreignId | FK → products.id |
| quantity | integer | min 1 |
| created_at / updated_at | timestamps | |

### 1.5 `orders`

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| order_number | string(50) | unique, auto-generated |
| user_id | foreignId | FK → users.id (nullable for guest) |
| status | enum | pending, confirmed, processing, shipped, delivered, cancelled |
| subtotal | decimal(10,2) | |
| shipping_cost | decimal(10,2) | |
| tax | decimal(10,2) | |
| total | decimal(10,2) | |
| discount_amount | decimal(10,2) | default 0 |
| shipping_first_name | string(100) | |
| shipping_last_name | string(100) | |
| shipping_email | string(100) | |
| shipping_phone | string(50) | |
| shipping_address | string(255) | |
| shipping_city | string(100) | |
| shipping_state | string(100) | |
| shipping_zip | string(20) | |
| shipping_country | string(100) | default "USA" |
| notes | text | nullable |
| created_at / updated_at | timestamps | |

### 1.6 `order_items`

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| order_id | foreignId | FK → orders.id (cascade) |
| product_id | foreignId | FK → products.id |
| product_name | string(200) | snapshot at purchase |
| product_price | decimal(10,2) | snapshot at purchase |
| quantity | integer | |
| subtotal | decimal(10,2) | price × quantity |
| created_at / updated_at | timestamps | |

### 1.7 `contacts`

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| name | string(100) | |
| email | string(100) | |
| subject | string(200) | |
| message | text | |
| is_read | boolean | default false |
| created_at / updated_at | timestamps | |

### 1.8 `reviews`

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| product_id | foreignId | FK → products.id (cascade) |
| user_id | foreignId | FK → users.id |
| rating | integer | 1–5 |
| title | string(200) | nullable |
| body | text | nullable |
| is_approved | boolean | default false |
| created_at / updated_at | timestamps | |

### 1.9 `users` (add to default Laravel auth)

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| name | string(100) | |
| email | string(100) | unique |
| password | string | hashed |
| phone | string(50) | nullable |
| avatar | string(255) | nullable |
| role | enum | customer, admin (default: customer) |
| is_active | boolean | default true |
| remember_token | string(100) | Laravel default |
| created_at / updated_at | timestamps | |

### 1.10 `settings` (key-value for site config)

| Column | Type | Notes |
|--------|------|-------|
| id | bigIncrements | PK |
| key | string(100) | unique |
| value | text | |
| created_at / updated_at | timestamps | |

---

## 2. API Endpoints

All endpoints prefixed with `/api/v1`.

### 2.1 Public Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/products` | List products (paginated, filterable, sortable) |
| GET | `/products/{slug}` | Single product detail |
| GET | `/products/featured` | Featured products |
| GET | `/categories` | All categories with product counts |
| GET | `/categories/{slug}/products` | Products by category |
| GET | `/reviews?product_id=X` | Approved reviews for a product |
| POST | `/contacts` | Submit contact form |
| POST | `/cart/sync` | Sync guest cart on login |
| POST | `/auth/login` | Login |
| POST | `/auth/register` | Register |
| POST | `/auth/forgot-password` | Password reset |
| GET | `/settings` | Public site settings |

#### Query Parameters for `GET /products`

| Param | Example | Notes |
|-------|---------|-------|
| `category` | `skincare` | Filter by category slug |
| `min_price` | `10` | |
| `max_price` | `100` | |
| `sort` | `price_low`, `price_high`, `name`, `rating`, `newest` | |
| `search` | `serum` | Name/description search |
| `page` | `2` | |
| `per_page` | `9` | Default 9, max 48 |

### 2.2 Authenticated User Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/auth/me` | Current user profile |
| PUT | `/auth/me` | Update profile |
| GET | `/cart` | Get user's cart items |
| POST | `/cart/add` | Add item to cart |
| PUT | `/cart/{id}` | Update quantity |
| DELETE | `/cart/{id}` | Remove item |
| DELETE | `/cart` | Clear cart |
| GET | `/orders` | User's order history |
| GET | `/orders/{id}` | Order detail |
| POST | `/orders` | Place order (from cart) |
| POST | `/reviews` | Submit product review |

### 2.3 Admin Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/dashboard` | Dashboard stats |
| GET | `/admin/products` | Products list (all) |
| POST | `/admin/products` | Create product |
| PUT | `/admin/products/{id}` | Update product |
| DELETE | `/admin/products/{id}` | Soft delete product |
| POST | `/admin/products/{id}/images` | Upload product images |
| DELETE | `/admin/products/images/{id}` | Delete product image |
| GET | `/admin/categories` | Categories list |
| POST | `/admin/categories` | Create category |
| PUT | `/admin/categories/{id}` | Update category |
| DELETE | `/admin/categories/{id}` | Delete category |
| GET | `/admin/orders` | All orders (filterable by status) |
| GET | `/admin/orders/{id}` | Order detail with items |
| PUT | `/admin/orders/{id}/status` | Update order status |
| GET | `/admin/contacts` | Contact submissions |
| GET | `/admin/contacts/{id}` | Contact detail |
| PUT | `/admin/contacts/{id}/read` | Mark as read |
| DELETE | `/admin/contacts/{id}` | Delete contact |
| GET | `/admin/reviews` | All reviews (pending approval) |
| PUT | `/admin/reviews/{id}/approve` | Approve/reject review |
| DELETE | `/admin/reviews/{id}` | Delete review |
| GET | `/admin/users` | Users list |
| PUT | `/admin/users/{id}` | Update user (role, status) |
| GET | `/admin/settings` | Get site settings |
| PUT | `/admin/settings` | Update site settings |

---

## 3. Admin Blade Views

All admin views use Laravel Blade with a sidebar layout.

### 3.1 Dashboard (`/admin`)

- **Stats cards**: Total Orders, Total Revenue, Total Products, Total Users
- **Recent

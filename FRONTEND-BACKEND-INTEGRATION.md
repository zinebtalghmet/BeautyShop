# Frontend ↔ Backend Integration

This document explains how the React frontend (`BeautyShop/`) communicates with the Laravel backend (`BeautyBackend/`).

---

## 1. Architecture Overview

```
┌─────────────────────────────────────────────────┐
│                   Browser                        │
│                                                   │
│   React SPA (port 3000)    Laravel Admin (port 8000) │
│   BeautyShop/src/          /admin/dashboard       │
│                              /admin/products      │
│                              /admin/orders        │
│                                                   │
│         Axios ──────────>  API (port 8000)        │
│         /api/v1/*           routes/api.php         │
│                                                   │
│         Images ──────────> /storage/*             │
│         (public symlink)    storage/app/public/   │
└─────────────────────────────────────────────────┘
```

Two ways to access the application:

- **Frontend (React SPA):** `http://localhost:3000` — all store pages (shop, cart, checkout)
- **Admin (Laravel Blade):** `http://localhost:8000/admin/*` — dashboard, products, orders, slides, etc.

Both communicate with the same Laravel API at `http://localhost:8000/api/v1/*`.

---

## 2. Development Proxy

`BeautyShop/package.json`:

```json
{
  "proxy": "http://localhost:8000"
}
```

When React's dev server (port 3000) receives a request it doesn't recognize (e.g. `/api/v1/products`), it forwards it to `localhost:8000`. This avoids CORS issues during development.

---

## 3. Axios Instance

**File:** `BeautyShop/src/services/api.js`

```js
const API_BASE = process.env.REACT_APP_API_URL || 'http://localhost:8000';

const api = axios.create({
  baseURL: `${API_BASE}/api/v1`,
  headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
  withCredentials: true,
  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',
});
```

Key details:

| Setting | Purpose |
|---------|---------|
| `baseURL` | All requests prefixed with `http://localhost:8000/api/v1` |
| `withCredentials: true` | Sends cookies (required for Sanctum SPA auth) |
| `xsrfCookieName / xsrfHeaderName` | Laravel's CSRF protection via Sanctum |
| `session_id` interceptor | Adds `?session_id=...` to every request for guest cart tracking |

The `session_id` is generated once on first visit and stored in `localStorage`. It allows unauthenticated users to maintain a cart.

---

## 4. Sanctum Authentication

**File:** `BeautyBackend/config/sanctum.php`

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1'
)),
```

**File:** `BeautyBackend/.env`

```
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000
FRONTEND_URL=http://localhost:3000
```

Sanctum uses **cookie-based SPA authentication** for first-party clients:

1. Frontend hits `GET /sanctum/csrf-cookie` to get an `XSRF-TOKEN` cookie
2. Subsequent requests include the session cookie
3. The `auth:sanctum` middleware checks for a valid session

Routes requiring authentication are grouped under `middleware('auth:sanctum')` in `routes/api.php`.

---

## 5. CORS Configuration

**File:** `BeautyBackend/config/cors.php`

```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000')),
    'supports_credentials' => true,
];
```

- Only `api/*` and CSRF endpoints are open to CORS
- `supports_credentials: true` allows cookies to be sent cross-origin
- Origins controlled via `CORS_ALLOWED_ORIGINS` env var

---

## 6. API Endpoint Reference

**File:** `BeautyBackend/routes/api.php`

All routes are prefixed with `/api/v1`.

### Public Routes

| Method | Endpoint | Controller | Purpose |
|--------|----------|------------|---------|
| GET | `/products` | `ProductController@index` | List products (with filters, pagination) |
| GET | `/products/featured` | `ProductController@featured` | Featured products for homepage |
| GET | `/products/{slug}` | `ProductController@show` | Single product detail |
| GET | `/categories` | `CategoryController@index` | List categories |
| GET | `/categories/{slug}` | `CategoryController@show` | Single category |
| GET | `/categories/{slug}/products` | `CategoryController@products` | Products in category |
| GET | `/slides` | `SlideController@index` | Hero slideshow |
| GET | `/settings` | `SettingController@index` | Public settings (currency, etc.) |
| GET | `/reviews` | `ReviewController@index` | Approved reviews |
| POST | `/contacts` | `ContactController@store` | Contact form submission |
| POST | `/orders` | `OrderController@store` | Place an order (guest or logged-in) |
| GET | `/tax-rate` | `TaxRateController` | Calculate tax by country/region |
| GET | `/shipping-rate` | `ShippingController` | Calculate shipping by subtotal/country |

### Auth Routes (Public)

| Method | Endpoint | Purpose |
|--------|----------|---------|
| POST | `/auth/register` | Register a new account |
| POST | `/auth/login` | Login |
| POST | `/auth/forgot-password` | Password reset request |

### Cart Routes (Public — uses session_id)

| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/cart` | Get current cart |
| POST | `/cart/add` | Add item to cart |
| PUT | `/cart/{cartItem}` | Update quantity |
| DELETE | `/cart/{cartItem}` | Remove item |
| DELETE | `/cart` | Clear cart |

### Authenticated Routes (require `auth:sanctum`)

| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/auth/me` | Get current user profile |
| PUT | `/auth/me` | Update profile |
| POST | `/auth/logout` | Logout |
| POST | `/reviews` | Submit a review |
| GET | `/orders` | User's order history |
| GET | `/orders/{order}` | Single order detail |

---

## 7. Service Layer

Each React page imports from a dedicated service file in `BeautyShop/src/services/`. Every service uses the shared Axios instance (`api.js`).

| Service File | Functions | API Endpoints Used |
|-------------|-----------|-------------------|
| `productService.js` | `fetchProducts()`, `fetchFeaturedProducts()`, `fetchProductBySlug()`, `fetchCategories()` | GET `/products`, `/products/featured`, `/products/{slug}`, `/categories` |
| `cartService.js` | `fetchCart()`, `addToCart()`, `updateCartItem()`, `removeFromCart()`, `clearCart()` | GET/POST/PUT/DELETE `/cart/*` |
| `orderService.js` | `placeOrder()`, `fetchTaxRate()`, `fetchShippingRate()` | POST `/orders`, GET `/tax-rate`, GET `/shipping-rate` |
| `slideService.js` | `fetchSlides()` | GET `/slides` |
| `contactService.js` | `submitContact()` | POST `/contacts` |
| `authService.js` *(if exists)* | `login()`, `register()`, `logout()`, `getProfile()` | POST `/auth/*`, GET `/auth/me` |

Each service function:
1. Calls `api.get()` / `api.post()` / `api.put()` / `api.delete()` with appropriate params
2. Transforms snake_case API responses to camelCase frontend objects
3. Returns only the relevant data (e.g., `res.data.data` matching Laravel's API resource wrapper)

### Example: `productService.js`

```js
function transformProduct(p) {
  return {
    id: p.id,
    name: p.name,
    slug: p.slug,
    price: p.price,
    originalPrice: p.original_price ?? p.price,
    images: p.images?.map(i => i.image) ?? [],
    // ...
  };
}

export async function fetchProducts(params = {}) {
  const res = await api.get('/products', { params });
  return { data: res.data.data.map(transformProduct), meta: res.data.meta };
}
```

---

## 8. Data Transformation

Laravel API resources return **snake_case** JSON. The frontend services transform them to **camelCase** for React components.

**Backend response (raw):**
```json
{
  "data": {
    "id": 1,
    "name": "Lipstick",
    "original_price": 19.99,
    "is_featured": true,
    "reviews_count": 12
  }
}
```

**After transformation:**
```js
{
  id: 1,
  name: "Lipstick",
  originalPrice: 19.99,
  featured: true,
  reviews: 12
}
```

---

## 9. Image Handling

### Storage Flow

```
Laravel Model (Slide.image = "slides/abc.jpg")
  → $appends ['image_url'] attribute
  → Storage::disk('public')->url('slides/abc.jpg')
  → Returns: "http://localhost:8000/storage/slides/abc.jpg"
```

### Accessor (Slide model)

**File:** `BeautyBackend/app/Models/Slide.php`

```php
protected $appends = ['image_url'];

public function getImageUrlAttribute(): ?string
{
    if (!$this->image) return null;
    return Storage::disk('public')->url($this->image);
}
```

### Frontend Image Helper

**File:** `BeautyShop/src/utils/imageHelper.js`

```js
const STORAGE_URL = process.env.REACT_APP_STORAGE_URL || 'http://localhost:8000/storage';

export const getProductImagePath = (imagePath) => {
  if (!imagePath) return null;
  if (imagePath.startsWith('http')) return imagePath;
  return `${STORAGE_URL}/${imagePath}`;
};
```

### Storage Symlink

```
public/storage  →  storage/app/public
```

Created via `php artisan storage:link`. All files in `storage/app/public/` are accessible at `http://localhost:8000/storage/...`.

---

## 10. Session-Based Cart

The cart works for both guests and logged-in users via a `session_id`:

**On first visit (frontend):**
```js
let sessionId = localStorage.getItem('beautyShopSessionId');
if (!sessionId) {
  sessionId = 'sess_' + Date.now() + '_' + Math.random().toString(36).substring(2, 10);
  localStorage.setItem('beautyShopSessionId', sessionId);
}
```

**On every API request (interceptor):**
```js
api.interceptors.request.use((config) => {
  config.params = { ...config.params, session_id: sessionId };
  return config;
});
```

**Backend:** `CartController` looks up the cart by `session_id` (or by `user_id` if authenticated).

---

## 11. Admin Panel (Laravel Blade + Vite)

The admin panel is **not** part of the React SPA. It's rendered by Laravel using:

- **Vite** to build CSS/JS assets (`BeautyBackend/resources/`)
- **Blade templates** with TailAdmin v4 design
- **No separate API calls** — data is rendered server-side via Blade `@foreach`, forms submit directly to Laravel routes

**Build pipeline:**
```
BeautyBackend/resources/css/app.css  ──┐
BeautyBackend/resources/js/app.js    ──┤── Vite ──→ public/build/assets/
BeautyBackend/resources/views/       ──┘             (served by Laravel)
```

---

## 12. Key Environment Variables

### Backend (`.env`)

| Variable | Value | Purpose |
|----------|-------|---------|
| `APP_URL` | `http://localhost:8000` | Base URL for the Laravel app |
| `APP_KEY` | `base64:...` | Laravel encryption key |
| `DB_DATABASE` | `beauty` | MySQL database name |
| `SANCTUM_STATEFUL_DOMAINS` | `localhost:3000,127.0.0.1:3000` | Allowed SPA domains for cookie auth |
| `FRONTEND_URL` | `http://localhost:3000` | CORS allowed origin |
| `MAIL_MAILER` | `log` | Email driver (set to `smtp` for real delivery) |

### Frontend (set at build/start time)

| Variable | Default | Purpose |
|----------|---------|---------|
| `REACT_APP_API_URL` | `http://localhost:8000` | Laravel API base URL |
| `REACT_APP_STORAGE_URL` | `http://localhost:8000/storage` | Public storage URL for images |

---

## 13. Running Both Projects

### Terminal 1 — Backend
```bash
cd BeautyBackend
php artisan serve
# → http://localhost:8000
```

### Terminal 2 — Frontend
```bash
cd BeautyShop
npm start
# → http://localhost:3000 (proxies API to :8000)
```

### Admin Panel
Visit `http://localhost:8000/admin/dashboard` directly (served by Laravel, no React needed).

---

## 14. Common Issues

| Symptom | Likely Cause | Fix |
|---------|-------------|-----|
| CORS error in browser | `FRONTEND_URL` mismatch | Ensure `.env` matches the frontend URL exactly |
| API returns 419 | Missing CSRF token | Hit `/sanctum/csrf-cookie` first, or exclude route from CSRF |
| Images 404 | Storage symlink missing | Run `php artisan storage:link` |
| Cart empty after refresh | Backend using DB, no migration | Run `php artisan migrate` |
| React proxy not working | Port mismatch | Ensure backend is on port 8000 |
| `withCredentials` blocked | CORS origin mismatch | Check `SANCTUM_STATEFUL_DOMAINS` includes the frontend port |

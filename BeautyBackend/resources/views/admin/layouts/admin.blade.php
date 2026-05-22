<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — BeautyShop</title>
    @vite('resources/css/app.css')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; display: flex; min-height: 100vh; background: #f8fafc; color: #334155; }
        .sidebar { width: 260px; background: #0f172a; color: #fff; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; }
        .sidebar-brand { padding: 20px 24px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-brand h1 { font-size: 20px; font-weight: 700; }
        .sidebar-brand span { color: #e11d48; }
        .sidebar-brand p { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }
        .sidebar-nav { flex: 1; padding: 16px 12px; }
        .sidebar-nav a { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 8px; font-size: 14px; color: #94a3b8; text-decoration: none; transition: all 0.15s; margin-bottom: 2px; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-nav .nav-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: #475569; padding: 16px 12px 6px; }
        .main { flex: 1; margin-left: 260px; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: #fff; padding: 12px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; }
        .topbar h2 { font-size: 16px; font-weight: 600; color: #0f172a; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-right form { margin: 0; }
        .btn-logout { padding: 6px 14px; background: #f1f5f9; border: none; border-radius: 6px; font-size: 13px; color: #475569; cursor: pointer; transition: background 0.15s; }
        .btn-logout:hover { background: #e2e8f0; }
        .content { flex: 1; padding: 0; }
        .user-name { font-size: 13px; color: #64748b; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1>BEAUTY<span>·</span></h1>
            <p>Admin Panel</p>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Menu</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">🛍️ Products</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">📂 Categories</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">📦 Orders</a>
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">⭐ Reviews</a>
            <a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">✉️ Contacts</a>
            <a href="{{ route('admin.slides.index') }}" class="{{ request()->routeIs('admin.slides.*') ? 'active' : '' }}">🎠 Slides</a>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">⚙️ Settings</a>
        </nav>
    </aside>

    <div class="main">
        <header class="topbar">
            <h2>@yield('title', 'Dashboard')</h2>
            <div class="topbar-right">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </header>
        <main class="content">
            @if (session('success'))
                <div style="margin: 16px 24px 0; padding: 12px 16px; background: #dcfce7; color: #166534; border-radius: 8px; font-size: 14px;">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div style="margin: 16px 24px 0; padding: 12px 16px; background: #fce8e8; color: #991b1b; border-radius: 8px; font-size: 14px;">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>

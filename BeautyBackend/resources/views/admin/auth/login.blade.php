<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — BeautyShop</title>
    @vite('resources/css/app.css')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-card { background: #fff; border-radius: 12px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .logo { text-align: center; margin-bottom: 32px; }
        .logo h1 { font-size: 24px; color: #0f172a; letter-spacing: -0.5px; }
        .logo span { color: #e11d48; }
        .logo p { font-size: 13px; color: #64748b; margin-top: 4px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s; }
        input:focus { border-color: #e11d48; box-shadow: 0 0 0 3px rgba(225,29,72,0.1); }
        .remember { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 14px; color: #475569; }
        .btn { width: 100%; padding: 11px; background: #e11d48; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: #be123c; }
        .error { background: #fef2f2; color: #dc2626; padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .error ul { list-style: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <h1>BEAUTY<span>·</span></h1>
            <p>Admin Panel</p>
        </div>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <label class="remember">
                <input type="checkbox" name="remember">
                Remember me
            </label>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>
</body>
</html>

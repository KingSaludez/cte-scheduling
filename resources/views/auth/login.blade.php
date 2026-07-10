<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - {{ config('app.name', 'CTE NEMSU Tagbina') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"></noscript>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .split-wrap {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .brand-side {
            display: none;
            background: linear-gradient(135deg, #1e40af, #1e3a8a, #172554);
            padding: 60px 48px;
            flex: 1;
            position: relative;
            overflow: hidden;
        }
        .brand-side::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(251,191,36,0.12);
            border-radius: 50%;
            top: -80px;
            right: -80px;
            filter: blur(60px);
        }
        .brand-side::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: -40px;
            left: -40px;
            filter: blur(40px);
        }
        .brand-content { position: relative; z-index: 1; }
        .logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,0.1);
            border-radius: 18px;
            margin-bottom: 32px;
        }
        .logo-text {
            font-weight: 800;
            font-size: 32px;
            color: #fff;
            letter-spacing: -1px;
        }
        .logo-text span { opacity: 0.5; }
        .brand-title {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 12px;
        }
        .brand-sub {
            font-size: 16px;
            color: rgba(255,255,255,0.65);
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 48px;
        }
        .brand-quote {
            padding-top: 32px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .brand-quote p {
            color: rgba(255,255,255,0.45);
            font-style: italic;
            font-size: 14px;
        }
        .form-side {
            flex: 1;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .mobile-brand {
            display: block;
            text-align: center;
            margin-bottom: 32px;
        }
        .mobile-brand .logo-text { color: #1e40af; }
        .mobile-brand h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-top: 8px;
        }
        .mobile-brand p {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 4px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .form-header .icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: #eff6ff;
            border-radius: 14px;
            margin-bottom: 16px;
        }
        .form-header .icon-box svg { width: 28px; height: 28px; color: #2563eb; }
        .form-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }
        .form-header p {
            font-size: 14px;
            color: #64748b;
            margin-top: 6px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #334155;
            margin-bottom: 6px;
        }
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="text"] {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            color: #0f172a;
            outline: none;
            transition: all 0.2s;
        }
        .form-group input:focus {
            border-color: #60a5fa;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }
        .form-group input::placeholder { color: #94a3b8; }
        .form-group .error {
            font-size: 13px;
            color: #ef4444;
            margin-top: 6px;
        }
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 24px 0;
        }
        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .checkbox-wrap input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 1.5px solid #cbd5e1;
            accent-color: #2563eb;
            cursor: pointer;
        }
        .checkbox-wrap span {
            font-size: 14px;
            color: #475569;
        }
        .forgot-link {
            font-size: 14px;
            font-weight: 500;
            color: #2563eb;
            text-decoration: none;
        }
        .forgot-link:hover { color: #1d4ed8; }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #1d4ed8;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(29,78,216,0.25);
        }
        .btn-submit:hover {
            background: #1e40af;
            box-shadow: 0 6px 24px rgba(29,78,216,0.35);
            transform: translateY(-1px);
        }
        .btn-submit:active { transform: translateY(0); }
        .form-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 14px;
            color: #64748b;
        }
        .form-footer a {
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
        }
        .form-footer a:hover { color: #1d4ed8; }
        .session-status {
            padding: 12px 16px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            font-size: 14px;
            color: #166534;
            margin-bottom: 24px;
        }
        @media (min-width: 1024px) {
            .brand-side { display: flex; flex-direction: column; justify-content: center; }
            .mobile-brand { display: none; }
            .form-side { padding: 60px; }
        }
    </style>
</head>
<body>

<div class="split-wrap">
    <div class="brand-side">
        <div class="brand-content">
            <div class="logo-wrap">
                <span class="logo-text">CT<span>E</span></span>
            </div>
            <h1 class="brand-title">NEMSU<br>Tagbina Campus</h1>
            <p class="brand-sub">Instructor Scheduling System — streamlining faculty schedules with efficiency and precision.</p>
            <div class="brand-quote">
                <p>"Efficient scheduling, empowered educators."</p>
            </div>
        </div>
    </div>

    <div class="form-side">
        <div class="mobile-brand">
            <span class="logo-text">CT<span>E</span></span>
            <h1>NEMSU Tagbina</h1>
            <p>Instructor Scheduling System</p>
        </div>

        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif

        <div class="form-header">
            <div class="icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2>Welcome back</h2>
            <p>Sign in to your account to continue</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <label class="checkbox-wrap">
                    <input type="checkbox" name="remember" id="remember_me">
                    <span>Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">Sign in</button>

            <div class="form-footer">
                Don't have an account? <a href="{{ route('register') }}">Create one</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
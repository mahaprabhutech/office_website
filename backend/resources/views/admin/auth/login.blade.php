<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#111111">
    <title>Administrator Login | Mahaprabhu Tech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/admin.css') }}">
</head>
<body class="login-page">
<main class="login-shell">
    <section class="login-brand-panel">
        <div class="login-brand-top">
            <img src="{{ asset('admin-assets/images/brand-eye.svg') }}" alt="" class="login-logo">
            <div>
                <strong>Mahaprabhu Tech</strong>
                <span>Innovation Private Limited</span>
            </div>
        </div>

        <div class="login-brand-content">
            <span class="login-kicker">Website Administration</span>
            <h1>Manage your corporate website from one secure dashboard.</h1>
            <p>Update services, projects, blogs, team profiles, enquiries, job applications and website settings.</p>

            <div class="login-feature-grid">
                <div>
                    <span class="feature-number">01</span>
                    <strong>Content control</strong>
                    <small>Publish and update website information.</small>
                </div>
                <div>
                    <span class="feature-number">02</span>
                    <strong>Lead management</strong>
                    <small>Review enquiries and quotation requests.</small>
                </div>
                <div>
                    <span class="feature-number">03</span>
                    <strong>Secure access</strong>
                    <small>Role-aware administrator accounts.</small>
                </div>
            </div>
        </div>

        <p class="login-copyright">© {{ date('Y') }} Mahaprabhu Tech Innovation Private Limited</p>
    </section>

    <section class="login-form-panel">
        <div class="login-form-wrap">
            <div class="login-mobile-brand">
                <img src="{{ asset('admin-assets/images/brand-eye.svg') }}" alt="" class="login-logo">
                <strong>Mahaprabhu Tech</strong>
            </div>

            <p class="form-eyebrow">Administrator access</p>
            <h2>Welcome back</h2>
            <p class="form-intro">Enter your administrator account details to continue.</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="login-form">
                @csrf

                <label class="form-group">
                    <span>Email address</span>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        placeholder="admin@mahaprabhutech.online"
                        required
                        autofocus
                        class="@error('email') is-invalid @enderror"
                    >
                    @error('email')<small class="field-error">{{ $message }}</small>@enderror
                </label>

                <label class="form-group">
                    <span>Password</span>
                    <span class="password-field">
                        <input
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            required
                            data-password-input
                            class="@error('password') is-invalid @enderror"
                        >
                        <button type="button" data-password-toggle>Show</button>
                    </span>
                    @error('password')<small class="field-error">{{ $message }}</small>@enderror
                </label>

                <button type="submit" class="button button-primary button-large button-full">
                    Sign in to dashboard
                    <span aria-hidden="true">→</span>
                </button>
            </form>

            <div class="login-security-note">
                <span class="security-dot"></span>
                Protected administrator area. Do not share your login credentials.
            </div>
        </div>
    </section>
</main>
<script src="{{ asset('admin-assets/js/admin.js') }}"></script>
</body>
</html>

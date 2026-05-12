<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8" />
    <title>TicketFlow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.css')
    <style>
        html, body {
            height: 100%;
            margin: 0;
            background: #0b0f14;
        }

    .auth-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}
  .auth-card {
    background: #111827;
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 20px;

    width: 100%;
    max-width: 750px;

    padding: 48px 38px;

    box-shadow: 0 25px 60px rgba(0,0,0,0.5);

    min-height: auto;

    display: flex;
    flex-direction: column;
    justify-content: center;
}

        .auth-logo {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin: 0 auto 12px;
        }

        .form-control, .form-select {
            background: #1a2235 !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            color: #e2e8f0 !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            padding: 10px 14px !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1 !important;
            box-shadow: none !important;
        }

        .form-control::placeholder { color: #475569 !important; }

        .form-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: 6px;
        }

        .btn-signin {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border: none;
            font-size: 13px;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(99,102,241,0.3);
            transition: all 0.2s;
        }

        .btn-signin:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.4);
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">

            {{-- Logo --}}
            <div class="text-center mb-4">
                <div class="auth-logo">TS</div>
                <div class="fw-semibold text-white" style="font-size:17px;">TicketFlow</div>
                <div style="font-size:12px;color:#475569;margin-top:3px;">Sign in to your support account</div>
            </div>

            @yield('content')

            <div class="text-center mt-3" style="font-size:12px;color:#475569;">
                @if(Route::is('login'))
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color:#818cf8;">Sign up</a>
                @elseif(Route::is('register'))
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#818cf8;">Sign in</a>
                @endif
            </div>

        </div>
    </div>

    @include('partials.scripts')
</body>
</html>
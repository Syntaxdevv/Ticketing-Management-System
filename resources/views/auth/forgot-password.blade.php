<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicketFlow | Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #0f172a; 
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-container {
            background: #1e293b; 
            width: 100%;
            max-width: 850px; 
            height: 480px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .branding-side {
            flex: 1;
            background: rgba(255, 255, 255, 0.02);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            padding: 40px;
        }

        .logo-circle {
            width: 120px;
            height: 120px;
            background: #f59e0b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
            font-weight: bold;
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.3);
            margin-bottom: 20px;
        }

        .branding-side h3 {
            color: #f8fafc;
            font-size: 24px;
        }

        /* Right Side: Form Area */
        .form-side {
            flex: 1.2;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-side h2 {
            color: #f8fafc;
            font-size: 26px;
            margin-bottom: 15px;
            text-align: center;
            font-weight: 700;
        }

        .instruction-text {
            color: #94a3b8;
            font-size: 13px;
            text-align: center;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 18px;
            z-index: 10;
        }

        .input-group input {
            width: 100%;
            padding: 14px 20px 14px 55px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 35px;
            color: white;
            outline: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #f59e0b;
        }

        .btn-reset {
            width: 100%;
            background: #f59e0b; 
            color: white;
            border: none;
            padding: 14px;
            border-radius: 35px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-reset:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);
        }

        .status-msg {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .footer-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .footer-link a {
            color: #64748b;
            text-decoration: none;
            transition: 0.2s;
        }

        .footer-link a:hover {
            color: #f8fafc;
        }

        .error-msg {
            color: #ef4444;
            font-size: 11px;
            margin-top: 4px;
            margin-left: 20px;
            display: block;
        }
    </style>
</head>
<body>

    <div class="reset-container">
        <div class="branding-side">
            <div class="logo-circle">
                <i class="ri-shield-keyhole-line"></i>
            </div>
            <h3>TicketFlow</h3>
            <p style="color:#64748b; font-size:13px; margin-top:5px;">Security Access</p>
        </div>

        <div class="form-side">
            <h2>Forgot Password?</h2>
            <p class="instruction-text">
                No problem. Just let us know your email address and we will email you a password reset link.
            </p>

            @if (session('status'))
                <div class="status-msg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="input-group">
                    <i class="ri-mail-line"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your registered email" required autofocus>
                    @error('email') 
                        <span class="error-msg">{{ $message }}</span> 
                    @enderror
                </div>

                <button type="submit" class="btn-reset">
                    Email Password Reset Link
                </button>

                <div class="footer-link">
                    <a href="{{ route('login') }}">
                        <i class="ri-arrow-left-line"></i> Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
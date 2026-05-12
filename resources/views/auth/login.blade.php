<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicketFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
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

        .login-container {
            background: #1e293b; 
            width: 100%;
            max-width: 850px; 
            height: 500px;
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
            width: 140px;
            height: 140px;
            background: #6366f1; 
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            color: white;
            font-weight: bold;
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
            margin-bottom: 20px;
        }

        .branding-side h3 {
            color: #f8fafc;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .branding-side p {
            color: #64748b;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-side {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-side h2 {
            color: #f8fafc;
            font-size: 28px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
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
        }

        .input-group input {
            width: 100%;
            padding: 14px 20px 14px 55px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 35px; 
            color: white;
            outline: none;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #6366f1;
            background: #1e293b;
        }

        .btn-login {
            width: 100%;
            background: #6366f1;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 35px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        .forgot-link {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-link a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            transition: 0.2s;
        }

        .forgot-link a:hover {
            color: #6366f1;
        }

        .create-account {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #64748b;
        }

        .create-account a {
            color: #f8fafc;
            text-decoration: none;
            font-weight: 600;
        }

        .error-msg {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            margin-left: 20px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="branding-side">
            <div class="logo-circle">TS</div>
            <h3>TicketFlow</h3>
            <p>Support System</p>
        </div>

        <div class="form-side">
            <h2>LOGIN</h2>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="input-group">
                    <i class="ri-mail-line"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <i class="ri-lock-line"></i>
                    <input type="password" name="password" placeholder="Password" required>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Sign In</button>

                <div class="forgot-link">
                    {{-- FIX: Ginamit ang tamang Laravel route para sa Forgot Password --}}
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Forgot Username / Password?
                        </a>
                    @endif
                </div>

                <div class="create-account">
                    <a href="{{ route('register') }}">
                        Create your Account <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
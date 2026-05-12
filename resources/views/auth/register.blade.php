<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicketFlow | Sign Up</title>
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

        .register-container {
            background: #1e293b; 
            width: 100%;
            max-width: 850px; 
            height: 550px; 
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
            background: #6366f1; 
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
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
            flex: 1.2;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-side h2 {
            color: #f8fafc;
            font-size: 26px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
        }

        .input-group {
            margin-bottom: 15px;
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
            padding: 12px 20px 12px 55px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 35px; 
            color: white;
            outline: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #6366f1;
            background: #1e293b;
        }

        .btn-signup {
            width: 100%;
            background: #10b981; 
            color: white;
            border: none;
            padding: 14px;
            border-radius: 35px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-signup:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }

        .terms-text {
            color: #64748b;
            font-size: 11px;
            text-align: center;
            margin-bottom: 20px;
        }

        .terms-text a {
            color: #ef4444;
            text-decoration: none;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #64748b;
        }

        .footer-text a {
            color: #f8fafc;
            text-decoration: none;
            font-weight: 600;
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

    <div class="register-container">
        <div class="branding-side">
            <div class="logo-circle">TS</div>
            <h3>TicketFlow</h3>
            <p>Support System</p>
        </div>

        <div class="form-side">
            <h2>Create Account</h2>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <i class="ri-user-line"></i>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus>
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <i class="ri-mail-line"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <i class="ri-lock-line"></i>
                    <input type="password" name="password" placeholder="Password" required>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <i class="ri-lock-check-line"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <p class="terms-text">
                    By registering you agree to the <a href="/terms">Terms of Service</a>
                </p>

                <button type="submit" class="btn-signup">Sign Up</button>

                <div class="footer-text">
                    Already have an account? <a href="{{ route('login') }}">Sign in</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
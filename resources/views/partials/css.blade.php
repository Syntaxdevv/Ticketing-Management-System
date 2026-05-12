<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>

body {
    background: linear-gradient(135deg, #0f172a 0%, #020617 100%) !important;
    min-height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #e2e8f0;
}
.auth-page-wrapper {
    width: 100%;
}
.card {
    background: rgba(2, 10, 7, 0.78) !important;
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);

    border: 1px solid rgba(16, 185, 129, 0.25) !important;

    border-radius: 16px;
    width: 100%;

    box-shadow: 
        0 25px 60px rgba(0, 0, 0, 0.7),
        0 0 30px rgba(16, 185, 129, 0.10);

    transition: 0.3s ease;
}
.card:hover {
    transform: translateY(-3px);
    border-color: rgba(16, 185, 129, 0.4) !important;
    box-shadow: 
        0 30px 70px rgba(0, 0, 0, 0.75),
        0 0 40px rgba(16, 185, 129, 0.18);
}
.form-control {
    background-color: rgba(10, 18, 14, 0.85) !important;
    border: 1px solid rgba(16, 185, 129, 0.2) !important;
    color: #e5e7eb !important;
    padding: 12px 15px;
    width: 100% !important;
    border-radius: 10px;
    transition: 0.3s ease;
}

.form-control:focus {
    border-color: #10b981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25) !important;
    background-color: rgba(10, 18, 14, 0.95) !important;
}
.btn-primary {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    border: none !important;
    padding: 12px;
    font-weight: 600;
    width: 100% !important;
    border-radius: 10px;
    transition: 0.3s ease;
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16,185,129,0.25);
}
.text-primary {
    color: #10b981 !important;
}

.text-primary:hover {
    color: #34d399 !important;
}


.card, .form-control, .btn {
    font-family: 'Poppins', sans-serif;
}

</style>
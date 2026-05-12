@extends('layouts.guest')

@section('title', 'Terms of Service & Privacy Policy')

@section('content')

<style>
    .auth-page-wrapper .col-xl-5 {
        max-width: 900px !important;
        width: 100% !important;
    }
    .auth-page-wrapper .card {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    .auth-page-wrapper .card-body {
        padding: 0 !important;
    }
    body { background-color: #0f172a !important; }
</style>

{{-- Header --}}
<div class="text-center py-5 px-4" style="background: #5b52e8; border-radius: 16px 16px 0 0;">
    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
         style="width: 70px; height: 70px; background: rgba(255,255,255,0.18);">
        <i class="ri-shield-check-line text-white" style="font-size: 32px;"></i>
    </div>
    <h1 class="text-white mb-1" style="font-size: 26px; font-weight: 500;">Terms of Service & Privacy Policy</h1>
    <p class="mb-0" style="font-size: 14px; color: rgba(255,255,255,0.6);">Last updated: May 9, 2026</p>
</div>

{{-- Body --}}
<div class="px-5 py-5"
     style="background: #1a2235; border: 1px solid rgba(255,255,255,0.07); border-top: none; border-radius: 0 0 16px 16px;">

    <p class="mb-4" style="font-size: 14px; color: rgba(255,255,255,0.55); line-height: 1.8;">
        Welcome to <span class="text-white fw-semibold">TicketFlow</span>. By using our support system, 
        you agree to abide by the following terms and privacy guidelines.
    </p>

    {{-- Terms of Service --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div style="width: 4px; height: 22px; background: #5b52e8; border-radius: 4px;"></div>
        <h5 class="text-white mb-0" style="font-size: 16px; font-weight: 600;">Terms of Service</h5>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-md-6">
            <div class="p-4 h-100" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px;">
                <h6 class="text-white mb-2 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
                    <i class="ri-user-settings-line" style="color: #7c75eb; font-size: 18px;"></i>
                    1. User Responsibilities
                </h6>
                <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
                    The platform is intended for legitimate support ticket submission and tracking. Spamming or any malicious use of the system is strictly prohibited.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4 h-100" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px;">
                <h6 class="text-white mb-2 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
                    <i class="ri-flashlight-line" style="color: #7c75eb; font-size: 18px;"></i>
                    2. Escalation Rules
                </h6>
                <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
                    Tickets are subject to escalation if no response is received within <span class="text-white fw-semibold">24–48 hours</span>. Designated Agents determine escalation levels.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4 h-100" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px;">
                <h6 class="text-white mb-2 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
                    <i class="ri-time-line" style="color: #7c75eb; font-size: 18px;"></i>
                    3. Resolution & Feedback
                </h6>
                <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
                    Users are encouraged to provide honest feedback upon ticket resolution to help us improve our service quality.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4 h-100" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px;">
                <h6 class="text-white mb-2 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
                    <i class="ri-prohibit-line" style="color: #7c75eb; font-size: 18px;"></i>
                    4. Prohibited Actions
                </h6>
                <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
                    Abuse towards agents, providing false information, or unauthorized access may result in immediate account suspension.
                </p>
            </div>
        </div>
    </div>

    <hr style="border-color: rgba(255,255,255,0.08);" class="mb-5">

    {{-- Privacy Policy --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div style="width: 4px; height: 22px; background: #5b52e8; border-radius: 4px;"></div>
        <h5 class="text-white mb-0" style="font-size: 16px; font-weight: 600;">Privacy Policy</h5>
    </div>

    <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
        <h6 class="text-white mb-1 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
            <i class="ri-database-2-line" style="color: #7c75eb; font-size: 18px;"></i>
            1. Information We Collect
        </h6>
        <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
            We collect your name, email address, and ticket details solely to provide effective technical support.
        </p>
    </div>

    <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
        <h6 class="text-white mb-1 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
            <i class="ri-settings-4-line" style="color: #7c75eb; font-size: 18px;"></i>
            2. Data Usage
        </h6>
        <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
            Your data is used strictly for processing tickets and sending updates. We do not use your information for marketing without explicit consent.
        </p>
    </div>

    <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
        <h6 class="text-white mb-1 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
            <i class="ri-lock-2-line" style="color: #7c75eb; font-size: 18px;"></i>
            3. Data Security
        </h6>
        <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
            We employ industry-standard encryption and secure servers. We encourage users to maintain strong passwords and keep credentials confidential.
        </p>
    </div>

    <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
        <h6 class="text-white mb-1 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
            <i class="ri-user-heart-line" style="color: #7c75eb; font-size: 18px;"></i>
            4. User Rights
        </h6>
        <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
            You have the right to access, rectify, or request the deletion of your personal data at any time by contacting our support team.
        </p>
    </div>

    <div class="mb-0">
        <h6 class="text-white mb-1 d-flex align-items-center gap-2" style="font-size: 14px; font-weight: 500;">
            <i class="ri-cookie-line" style="color: #7c75eb; font-size: 18px;"></i>
            5. Cookies
        </h6>
        <p class="mb-0" style="font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7;">
            We use cookies solely for session management. We do not use tracking cookies for third-party advertising purposes.
        </p>
    </div>

    <hr style="border-color: rgba(255,255,255,0.08);" class="mt-5">

    {{-- Footer --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pt-3">
        <div>
            <h6 class="text-white mb-1" style="font-size: 15px; font-weight: 500;">Have questions?</h6>
            <p class="mb-0" style="font-size: 14px; color: rgba(255,255,255,0.5);">
                Reach us at
                <a href="mailto:sheikluckyacosta2021@gmail.com" style="color: #6366f1; text-decoration: none;">
                    sheikluckyacosta2021@gmail.com
                </a>
            </p>
        </div>
        <a href="{{ url('/') }}" class="btn px-4 py-2"
           style="background: #5b52e8; color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 500;">
            Back to home
        </a>
    </div>

</div>

@endsection
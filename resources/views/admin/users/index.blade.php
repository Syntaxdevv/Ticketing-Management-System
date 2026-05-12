@extends('layouts.master')

@section('title', 'Manage Users')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="text-white fw-semibold mb-1">User Management</h5>
        <p class="text-muted mb-0" style="font-size:12px;">Manage all system users</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn px-4 fw-semibold"
       style="background:#6366f1;color:#fff;border-radius:8px;font-size:13px;">
        <i class="ri-user-add-line me-1"></i> Add User
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.2); color:#10b981;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Stats Cards --}}
@php
    $totalUsers = $users->total();
    $adminCount = \App\Models\User::where('role', 'admin')->count();
    $userCount  = \App\Models\User::where('role', 'user')->count();
@endphp

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(99,102,241,0.15);color:#818cf8;font-size:18px;">
                <i class="ri-team-line"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $totalUsers }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(239,68,68,0.15);color:#f87171;font-size:18px;">
                <i class="ri-shield-user-line"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $adminCount }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Admins</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                 style="width:40px;height:40px;background:rgba(99,102,241,0.15);color:#a5b4fc;font-size:18px;">
                <i class="ri-user-line"></i>
            </div>
            <div>
                <div class="fw-semibold text-white" style="font-size:20px;line-height:1;">{{ $userCount }}</div>
                <div style="font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-top:3px;">Users</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="rounded-3 overflow-hidden" style="background:#252d3d;border:1px solid rgba(255,255,255,0.07);">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead style="background:#1a2235;font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.06em;">
                <tr>
                    <th class="px-4 py-3 border-0 fw-normal">ID</th>
                    <th class="py-3 border-0 fw-normal">Name</th>
                    <th class="py-3 border-0 fw-normal">Email</th>
                    <th class="py-3 border-0 fw-normal">Role</th>
                    <th class="py-3 border-0 fw-normal">Joined</th>
                    <th class="py-3 px-4 border-0 fw-normal text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.04);font-size:13px;">
                    <td class="px-4" style="color:#64748b;">{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold flex-shrink-0"
                                 style="width:32px;height:32px;background:linear-gradient(135deg,#6366f1,#8b5cf6);font-size:12px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span style="color:#e2e8f0;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color:#94a3b8;">{{ $user->email }}</td>
                    <td>
                        @php
                            $rc = ['admin'=>'rgba(239,68,68,0.15)','agent'=>'rgba(245,158,11,0.15)','user'=>'rgba(99,102,241,0.15)'];
                            $rt = ['admin'=>'#f87171','agent'=>'#fbbf24','user'=>'#a5b4fc'];
                        @endphp
                        <span class="px-3 py-1 rounded-pill" style="background:{{ $rc[$user->role] ?? 'rgba(255,255,255,0.05)' }};color:{{ $rt[$user->role] ?? '#94a3b8' }};font-size:11px;font-weight:500;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="color:#94a3b8;font-size:12px;">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-4 text-end">
                        <div class="d-inline-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="d-flex align-items-center justify-content-center rounded-2"
                               style="width:30px;height:30px;background:rgba(245,158,11,0.15);color:#fbbf24;font-size:14px;">
                                <i class="ri-edit-line"></i>
                            </a>
                            
                            @if($user->id !== auth()->id())
                            {{-- Direct Delete Form --}}
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                  onsubmit="return confirm('Sigurado ka bang buburahin mo si {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="d-flex align-items-center justify-content-center rounded-2 border-0"
                                        style="width:30px;height:30px;background:rgba(239,68,68,0.15);color:#f87171;font-size:14px;cursor:pointer;"
                                        title="Delete User">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#475569;font-size:13px;">
                        <i class="ri-user-line d-block mb-2 fs-3"></i>
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-4 py-3" style="border-top:1px solid rgba(255,255,255,0.05);">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
@extends('layouts.master')

@section('title', 'Add New User')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="p-3 mb-4 d-flex align-items-center justify-content-between" style="background: #1a1d21; border-radius: 10px; border-left: 5px solid #10b981;">
                <h4 class="mb-0 text-white">Create New Account</h4>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Back to List</a>
            </div>

            <div class="card border-0 shadow-lg" style="background: #1e2227; border-radius: 15px; color: #cbd5e1;">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       style="background: #1a1d21; border: 1px solid #334155; color: white;" 
                                       placeholder="Juan Dela Cruz" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       style="background: #1a1d21; border: 1px solid #334155; color: white;" 
                                       placeholder="juan@example.com" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Account Role</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" 
                                        style="background: #1a1d21; border: 1px solid #334155; color: white;" required>
                                    <option value="user">Regular User</option>
                                    <option value="agent">Support Agent</option>
                                    <option value="admin">System Admin</option>
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Initial Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                       style="background: #1a1d21; border: 1px solid #334155; color: white;" required>
                                <small class="text-muted">Min. 8 characters</small>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success py-2 fw-bold" style="background: #10b981; border: none;">
                                <i class="ri-save-line me-1"></i> Register User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
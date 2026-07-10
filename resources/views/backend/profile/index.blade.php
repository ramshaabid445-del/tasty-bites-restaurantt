@extends('backend.layouts.app')

@section('content')
<div class="pc-content">
    {{-- Main Form Start (Handles everything together) --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="row">
            {{-- Profile Header --}}
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-body p-3" style="background: #f8f9fa;">
                        <div class="d-flex align-items-center">
                            <img src="{{ Auth::user()->avatar ? asset('uploads/avatars/'.Auth::user()->avatar) : asset('backend/assets/images/user/avatar-1.jpg') }}" 
                                 class="rounded-circle border border-white border-4 shadow-sm" 
                                 style="width: 70px; height: 70px; object-fit: cover;">
                            <div class="ms-3">
                                <h5 class="fw-bold mb-0 text-dark">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-0 small">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Left: Personal Details & Password --}}
            <div class="col-lg-7 mb-4">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0">Update Information</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <hr class="my-4 opacity-50">
                        
                        <h6 class="fw-bold mb-3">Change Password <span class="text-muted small fw-normal">(Leave blank to keep current)</span></h6>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                        </div>

                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm" style="background-color: #7267ef; border:none;">
                            Save All Changes
                        </button>
                    </div>
                </div>
            </div>

            {{-- Right: Profile Picture with Change Button --}}
            <div class="col-lg-5 mb-4">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0 text-center">Profile Picture</h6>
                    </div>
                    <div class="card-body p-4 d-flex flex-column align-items-center text-center">
                        <div class="my-auto">
                            <img src="{{ Auth::user()->avatar ? asset('uploads/avatars/'.Auth::user()->avatar) : asset('backend/assets/images/user/avatar-1.jpg') }}" 
                                 id="preview" class="rounded-3 border mb-3 shadow-sm" style="width: 180px; height: 180px; object-fit: cover;">
                            
                            <input type="file" name="avatar" id="avatar-input" class="d-none" onchange="previewImage(event)">
                            
                            <div class="mt-2">
                                <button type="button" class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-bold" onclick="document.getElementById('avatar-input').click();">
                                    <i class="ti ti-camera me-1"></i> Change Photo
                                </button>
                                <p class="small text-muted mt-2">Upload PNG or JPG (Max 2MB)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            document.getElementById('preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
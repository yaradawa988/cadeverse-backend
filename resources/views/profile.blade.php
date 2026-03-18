@extends('layouts.app')

@section('content')

<div class="py-4"></div>

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@isset($message)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{$message}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endisset

<div class="card card-sm mx-auto" style="max-width: 800px;">
    <div class="card-body">
        <h1 class="text-center" style="font-size: 1.8rem; color: #48D1CC;">PROFILE</h1>
        <img src="{{asset('storage/'.$user->image)}}" class="rounded-circle mb-3 img-fluid profile-image" alt="Profile Image">
        
        <form action="{{url('/users/'.$user->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label custom-label">Name</label>
                    <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{$user->name}}" required>
                </div>
                <div class="col-md-6">
                    <label for="l_name" class="form-label custom-label">Last Name</label>
                    <input type="text" class="form-control form-control-sm" id="l_name" name="l_name" value="{{$user->l_name}}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label custom-label">Email</label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{$user->email}}" required>
                </div>
                <div class="col-md-6">
                    <label for="university" class="form-label custom-label">university</label>
                    <input type="text" class="form-control form-control-sm" id="university" name="university" placeholder="Change your university" value="{{$user->university}}" required>
                    @error('university')
                        <div class="small-alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="image" class="form-label custom-label">Profile Image</label>
                    <input class="form-control form-control-sm" type="file" id="image" name="image">
                    @error('image')
                        <div class="small-alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="password" class="form-label custom-label">Current Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter your old password">
                        <button type="button" id="show_password" class="btn btn-outline-secondary" style="border-radius: 50px;">
                            <i id="eye_icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="small-alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="new_password" class="form-label custom-label">New Password</label>
                    <input type="password" class="form-control form-control-sm" id="new_password" name="password" placeholder="Enter the new password">
                    @error('password')
                        <div class="small-alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="custom-btn" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); background-color: rgb(196, 46, 116);">
                Update Profile
            </button>
        </form>
    </div>
</div>

<style>


.navbar {
        background:rgb(255, 255, 255) !important;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }
   .container {
   
    margin-top: 100px;
}

   body {
    font-family: 'Nunito', sans-serif;
    background-color: #f3f0f0; 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    color: #333; 
}
    body {
        font-family: 'Nunito', sans-serif;
        background-image: url('{{ asset('images/hh.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 145vh;
        margin: 0;
        position: relative;
        background-color: #f3f0f0;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        padding: 20px;
        width: 600px;
        margin: 20px auto;
    }

    .profile-image {
        max-width: 100px;
        height: auto;
        border-radius: 50%;
    }

    .custom-btn {
        background-color: rgb(196, 46, 116);
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 30%;
    }

    .custom-btn:hover {
        background-color: #707272;
    }

    .form-control-sm {
        font-size: 1rem;
    }

    .small-alert {
        font-size: 0.8rem;
        color: red;
    }

    .custom-label {
        font-weight: bold;
        color: #333;
    }

    .input-group {
        position: relative;
    }

    .input-group .btn {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #bbb9b9;
        color: white;
        padding: 3px 8px;
        border: none;
        border-radius: 0;
        cursor: pointer;
        font-size: 0.975rem;
        line-height: 1.5;
        width: 20%;
        height: 30px;
    }
</style>

<script>
    const oldPasswordInput = document.getElementById('password');
    const showOldPasswordButton = document.getElementById('show_password');

    showOldPasswordButton.addEventListener('click', function() {
        if (oldPasswordInput.type === 'password') {
            oldPasswordInput.type = 'text';
            showOldPasswordButton.textContent = 'Hide';
        } else {
            oldPasswordInput.type = 'password';
            showOldPasswordButton.textContent = 'Show';
        }
    });
</script>

@endsection

@extends('layouts.app')

@section('content')
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

.custom-btn {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    opacity: 0.9;
    font-size: 17px;
    line-height: 20px;
    text-decoration: none; 
    background-color: #add8e6; 
    color: #fff;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.custom-btn:hover {
    background-color: #87ceeb; 
    color: #000; 
}


.card {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    padding: 20px;
    margin: 20px auto;
    max-width: 600px;
}

h3 {
    color: #2E8B57;
    text-align: center;
}

.alert {
    text-align: center;
}

.btn-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-left: 20px;
}

.btn-icon i {
    margin-right: 10px;
    font-size: 1.2em;
}

.card-body {
    text-align: center;
}

</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h3>You are logged in! Admin, You can use the following management options.</h3>
        </div>
    </div>

    <div class="card mb-3" style="opacity: 0.9;">
    <div class="card-body">
        <h5 class="card-title">Manage Options</h5>
        <div class="d-grid gap-2">

            <a href="{{ url('/users') }}" class="nav-link">
            <button class="btn custom-btn btn-icon" style="background: linear-gradient(to bottom right, #b0e0e6, #87cefa); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);" type="button">
    <i class="fas fa-user-cog"></i> Manage Users
</button>

            </a>

            <a href="{{ url('/lessons') }} "class="nav-link">
                <button class="btn custom-btn btn-icon" style="background: linear-gradient(to bottom right, #b0e0e6, #87cefa); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);" type="button">
                    <i class="fas fa-book-open"></i> Manage Lessons
                </button>
            </a>

            <a href="{{ url('/tests') }}" class="nav-link">
                <button class="btn custom-btn btn-icon" style="background: linear-gradient(to bottom right, #b0e0e6, #87cefa); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);" type="button">
                    <i class="fas fa-file-alt"></i> Manage Tests
                </button>
            </a>

        </div>
    </div>
</div>

@endsection

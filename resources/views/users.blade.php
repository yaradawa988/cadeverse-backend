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
  body {
        font-family: 'Nunito', sans-serif;
        background-image: url('{{ asset('images/12151160_4873411.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 180vh;
        margin: 0;
        position: relative;
        background-color:rgb(255, 255, 255);
    }

.custom-btn {
    width: 80%;
    padding: 12px;
    margin: 1px 0;
    opacity: 0.85;
    display: inline-block;
    font-size: 17px;
    line-height: 20px;
    text-decoration: none; 
    background-color: #b8bdbd;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 15px;
    cursor: pointer;
  }

  .custom-btn:hover {
    background-color: #ffffff;
  }
  .card {
        background-color: rgba(255, 255, 255, 0.9); 
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        padding: 20px;
        width: 400px; 
        position: center;
        opacity: 0.8;
    }
    .card {
        max-width: 448px; 
        margin: 10px; 
        margin-left: 50px;
        height: 548px; 
    }

    .custom-btn {
    margin: 5px;
    border-radius: 15px;
    padding: 10px 20px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}
.custom-btn {
    margin: 5px;
    border-radius: 15px;
    padding: 10px;
    font-size: 16px;
    transition: background-color 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px; 
    height: 40px; 
}

.custom-btn:hover {
    opacity: 0.8;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.fas {
    font-size: 18px; 
}
.rounded-circle {
    border: 3px solid #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>

<div class="container py-4">
<h2 class="text-center my-4">Manage Users</h2>
<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse ($users as $user)
        <div class="col mb-4">
            <div class="card h-100" style="cursor: pointer; border-radius: 25px; background-color:rgba(255, 254, 242, 0.94) ;box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); width: 300px;">
               
                <div class="card-header" style="border-radius: 25px 25px 0 0; background-color:rgba(182, 182, 174, 0.4);">
                    <h5 class="text-black text-center"><strong>User {{ $user->id }}:</strong></h5>
                </div>

                
                <div class="card-body text-center">
                    
                    <div class="mb-3">
                    <img src="{{ asset('storage/'.$user->image) }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                   
                    <h5 class="card-title"><strong>Name:</strong> {{ $user->name }}</h5>
                    <br>
                    <h6 class="card-subtitle mb-2"><strong>Email:</strong> {{ $user->email }}</h6>
                </div>

          
                <div class="card-footer text-center" style="border-radius: 0 0 25px 25px; background-color:#DAD87366;">
                  
                    <a href="{{ url('/users/'.$user->id.'/edit') }}" class="btn btn-primary custom-btn" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{ url('/users/'.$user->id.'/delete') }}" class="btn btn-danger custom-btn" title="Delete">
                        <i class="fas fa-trash-alt"></i> 
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col text-center">
            <p>No users found.</p>
        </div>
    @endforelse
</div>


    <br><br><br>    <br><br><br>    <br><br><br>    <br><br><br>    <br><br><br>    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection
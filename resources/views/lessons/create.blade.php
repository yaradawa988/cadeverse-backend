
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
    width: auto;
    padding: 12px;
    margin: 5px;
    opacity: 0.85;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    text-decoration: none;
    background-color: #b8bdbd;
    color: #fff;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.custom-btn:hover {
    background-color: #ffffff;
    color: #000;
}
.card {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    padding: 20px;
    margin: 10px auto;
    max-width: 450px;
    text-align: center;
}
.card img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 15px;
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
.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

</style>
<div class="container">
    <h2 class="text-center my-4">Add New Lesson</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Save Lesson</button>
            </form>
        </div>
    </div>
</div>
@endsection

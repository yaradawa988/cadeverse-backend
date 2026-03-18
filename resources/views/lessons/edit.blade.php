@extends('layouts.app')

@section('content')
<style>
.navbar {
    background: rgb(255, 255, 255) !important;
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
    max-width: 700px;
    text-align: center;
}
.card img {
    max-width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
    border: 3px solid #ddd; 
}
.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    font-size: 18px;
    padding: 10px 15px;
    width: 100%;
}
.btn-success:hover {
    background-color: #218838;
}
.form-control {
    font-size: 16px;
    padding: 10px;
}
textarea.form-control {
    resize: none;
    height: 50px;
}
</style>

<div class="container">
    <h2 class="text-center my-4">Edit Lesson</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $lesson->title }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control">{{ $lesson->description }}</textarea>
                </div>

         
                @if ($lesson->image)
                    <div class="mb-3">
                        <label class="form-label">Current Image:</label>
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset($lesson->image) }}" class="img-fluid">
                        </div>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="image" class="form-label">Update Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Update Lesson</button>
            </form>
        </div>
    </div>
</div>

@endsection

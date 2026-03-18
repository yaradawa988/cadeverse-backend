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
    margin-top: 120px;
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
    width: 48%; /* Aligning buttons side by side */
    padding: 10px 15px;
    opacity: 0.85;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
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

.card-body {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 10px;
}

.card img {
    max-width: 100%;
    height: 200px;
    object-fit: cover;
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
    padding: 12px;
    margin: 10px 0;
    opacity: 0.9;
    font-size: 17px;
    text-decoration: none;
    background-color: #add8e6;
    color: #fff;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #87ceeb;
    color: #000;
}

.fas {
    font-size: 18px;
}

.btn-success, .btn-danger, .btn-warning, .btn-info {
    width: 120px !important;
    color: black !important; /* Ensuring black text color */
}
</style>

<div class="container">
    <h2 class="text-center mb-4">Test Management</h2>

    <!-- Success or error messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('tests.create') }}" class="btn btn-primary mb-3" style="background: linear-gradient(to bottom right, #b0e0e6, #87cefa); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">Add New Test</a>

    <div class="row">
        @foreach ($tests as $test)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $test->name }}</h5>
                        <p class="card-text">Number of Questions: {{ $test->number_of_questions }}</p>

                        <a href="{{ route('questions.create',$test->id) }}" class="btn btn-info btn-sm">Add Questions</a>

                        <a href="{{ route('tests.edit', $test->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('tests.show', $test->id) }}" class="btn btn-info">View Test</a>

                        <form action="{{ route('tests.destroy', $test->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this test?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection

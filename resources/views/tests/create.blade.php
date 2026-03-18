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
    flex-direction: column;  /* Added to ensure vertical alignment */
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
    color: black !important;
}
</style>

<div class="container">
    <h2 class="text-center mb-4">Add New Test</h2>

    <form action="{{ route('tests.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Test Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lesson_id">Lesson</label>
                    <select name="lesson_id" class="form-control" required>
                        <option value="">Select a Lesson</option>
                        @foreach ($lessons as $lesson)
                            <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="number_of_questions">Number of Questions</label>
                    <input type="number" name="number_of_questions" id="number_of_questions" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Add Test</button>
            </div>
        </div>
    </form>
</div>

@endsection

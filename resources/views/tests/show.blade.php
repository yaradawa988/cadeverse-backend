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
    margin-top: 80px;
}
.card {
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    padding: 30px;
    max-width: 900px;
    margin: auto;
}
h2 {
    color: #007bff;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
}
.card-text {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}
.question-card {
    background-color: #fff;
    border-left: 5px solid #007bff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 15px;
    margin-bottom: 20px;
}
.question-card h5 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
}
.action-buttons {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.btn-custom {
    min-width: 130px;
    padding: 10px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    text-align: center;
}
.btn-warning:hover {
    background-color: #e0a800;
}
.btn-info:hover {
    background-color: #87ceeb;
}
.btn-danger:hover {
    background-color: #c82333;
}
.btn-success, .btn-danger, .btn-warning, .btn-info {
    width: 120px !important;
    height: 40px !important;
    color: black !important;
}
@media (max-width: 768px) {
    .card {
        padding: 20px;
    }
    .btn-custom {
        min-width: 100px;
        font-size: 14px;
    }
    h2 {
        font-size: 24px;
    }
}
</style>

<div class="container">
    <h2>{{ $test->name }} - Test Details</h2>

   
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Lesson: {{ $test->lesson->title }}</h5>
            <p class="card-text">Number of Questions: {{ $test->number_of_questions }}</p>
            <a href="{{ route('questions.create', $test->id) }}" class="btn btn-info btn-sm"style="background-color: #87ceeb;">Add Questions</a>

            <h4 class="mt-4">Questions:</h4>
            @foreach ($test->questions as $question)
                <div class="question-card">
                    <h5>{{ $question->question_text }}?</h5>
                    <p class="card-text"><strong>Type:</strong> {{ $question->question_type }}</p>
                    <p class="card-text"><strong>Options:</strong> {{ $question->options }}</p>
                    <p class="card-text"><strong> Question Mark:</strong> {{ $question->mark }}</p>
                    <p class="card-text"><strong>Correct Answer:</strong> {{ $question->correct_answer }}</p>

                    <div class="action-buttons">
                        <a href="{{ route('questions.edit', ['question' => $question->id, 'test_id' => $question->test_id]) }}" class="btn btn-primary btn-sm  text-center"style=" width: 120px !important;
    height: 40px !important;
    color: black !important;background-color: #87ceeb;">Edit</a>

                        <form action="{{ route('questions.destroy', ['question' => $question->id, 'test_id' => $question->test_id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');" class="w-50">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm ">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

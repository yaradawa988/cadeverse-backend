@extends('layouts.app')

@section('content')
<div class="container">
    
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

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h3 class="text-center mb-4" style="color:rgba(241, 200, 14, 0.81);">Add Question</h3>

    <div class="card mb-4" style="max-width: 800px; margin: auto; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
        <div class="card-header">
            <h5 class="mb-0">Question Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('questions.store', $test->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="test_id" value="{{ $test->id }}">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="test_id_display" class="form-label">Test ID</label>
                        <input type="text" name="test_id_display" class="form-control form-control-sm" value="{{ $test->id }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="mark" class="form-label">Mark</label>
                        <input type="number" name="mark" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="question_text" class="form-label">Question Text</label>
                        <textarea name="question_text" class="form-control form-control-sm" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="question_type" class="form-label">Question Type</label>
                        <input type="text" name="question_type" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="option1" class="form-label">Option 1</label>
                        <input type="text" name="option1" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-6">
                        <label for="option2" class="form-label">Option 2</label>
                        <input type="text" name="option2" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="option3" class="form-label">Option 3</label>
                        <input type="text" name="option3" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label for="option4" class="form-label">Option 4</label>
                        <input type="text" name="option4" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="correct_answer" class="form-label">Correct Answer</label>
                    <select name="correct_answer" class="form-control form-control-sm" required>
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                        <option value="option4">Option 4</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-sm w-100" style="background-color:  #87ceeb; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">Add Question</button>
            </form>
        </div>
    </div>

    <div class="card mt-8" style="max-width: 800px; margin: auto;">
        <div class="card-header">
            <h5 class="mb-0">Questions List</h5>
        </div>
        <div class="card-body" style="box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
            @foreach($questions as $question)
                <div class="mb-3 p-3 border rounded" style="background-color: rgb(231, 232, 240); box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
                    <h6 class="mb-1"><strong>Question Text:</strong> {{ $question->question_text }}?</h6>
                    <p class="mb-0"><strong> Question Type:</strong> {{ $question->question_type }}</p>
                    <p class="mb-0"><strong> Question Mark:</strong> {{ $question->mark }}</p>
                    <p class="mb-0"><strong>Options:</strong> {{ $question->options }}</p>
                    <p class="mb-0"><strong>Correct Answer:</strong> {{ $question->correct_answer }}</p>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('questions.edit', ['question' => $question->id, 'test_id' => $question->test_id]) }}" class="btn btn-primary btn-sm w-50 text-center"style="background-color:  #87ceeb;">Edit</a>

                        <form action="{{ route('questions.destroy', ['question' => $question->id, 'test_id' => $question->test_id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');" class="w-50">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                        </form>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
</div>

<style>
    .navbar {
    background: rgb(255, 255, 255) !important;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}

.container {
    margin-top: 60px;
}
    .form-label {
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }
    .form-control-sm {
        font-size: 14px;
        padding: 5px 10px;
    }
    .btn-sm {
        font-size: 12px;
        padding: 5px 10px;
        margin-right: 5px;
        display: inline-block;
    }
    .btn-success {
        font-size: 14px;
        padding: 8px 12px;
    }
    .btn-primary {
        background-color: rgb(41, 67, 182);
        border-radius: 25px;
        border: none;
        padding: 5px 15px;
    }
    .btn-danger {
        background-color: rgb(182, 41, 41);
        border-radius: 25px;
        border: none;
        padding: 5px 15px;
    }
    .btn-primary:hover {
        background-color: rgb(31, 51, 138);
    }
    .btn-danger:hover {
        background-color: rgb(138, 31, 31);
    }
</style>
@endsection

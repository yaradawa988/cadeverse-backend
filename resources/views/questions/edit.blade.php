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
    <h1 class="text-center mb-4">Edit Question</h1>

    <div class="card mb-4" style="max-width: 700px; margin: auto;">
        <div class="card-header">
            <h5 class="mb-0">Edit Question Details</h5>
        </div>
        <div class="card-body">
        <form action="{{ route('questions.update', ['question' => $question->id, 'test_id' => $testId]) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <input type="hidden" name="test_id" value="{{ $testId }}">


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="question_text" class="form-label">Question Text</label>
                        <textarea name="question_text" class="form-control form-control-sm" required>{{ $question->question_text }}?</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="question_type" class="form-label">Question Type</label>
                        <textarea type="text" name="question_type" class="form-control form-control-sm" required>{{ $question->question_type }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="option1" class="form-label">Option 1</label>
                        <input type="text" name="option1" class="form-control form-control-sm" value="{{ json_decode($question->options)->option1 }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="option2" class="form-label">Option 2</label>
                        <input type="text" name="option2" class="form-control form-control-sm" value="{{ json_decode($question->options)->option2 }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="option3" class="form-label">Option 3</label>
                        <input type="text" name="option3" class="form-control form-control-sm" value="{{ json_decode($question->options)->option3 }}" >
                    </div>
                    <div class="col-md-6">
                        <label for="option4" class="form-label">Option 4</label>
                        <input type="text" name="option4" class="form-control form-control-sm" value="{{ json_decode($question->options)->option4 }}" >
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="correct_answer" class="form-label">Correct Answer</label>
                        <select name="correct_answer" class="form-control form-control-sm" required>
                            <option value="option1" {{ $question->correct_answer === 'option1' ? 'selected' : '' }}>Option 1</option>
                            <option value="option2" {{ $question->correct_answer === 'option2' ? 'selected' : '' }}>Option 2</option>
                            <option value="option3" {{ $question->correct_answer === 'option3' ? 'selected' : '' }}>Option 3</option>
                            <option value="option4" {{ $question->correct_answer === 'option4' ? 'selected' : '' }}>Option 4</option>
                        </select>
                    </div><div class="col-md-6">
                        <label for="mark" class="form-label">Mark</label>
                        <input type="number" name="mark" class="form-control form-control-sm" value="{{ $question->mark }}" required>
                    </div>
                </div>

                


                <button type="submit" class="btn btn-primary btn-sm w-100"style="background-color: #87ceeb; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">Update Question</button>
            </form>
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
    body {
        font-family: 'Nunito', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }
    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        padding: 20px;
        margin: auto;
        max-width: 600px;
        width: 100%;
    }
    .form-label {
        font-weight: bold;
        color: #333;
        font-size: 16px;
    }
    .form-control-sm {
        font-size: 14px;
        padding: 5px 10px;
    }
    .btn-sm {
        font-size: 17px;
        padding: 5px 10px;
        margin-right: 5px;
        display: inline-block;
    }
    .btn-primary {
        background-color: rgb(41, 67, 182);
        border-radius: 25px;
        border: none;
        padding: 5px 15px;
    }
    .btn-primary:hover {
        background-color: rgb(31, 51, 138);
    }
</style>
@endsection
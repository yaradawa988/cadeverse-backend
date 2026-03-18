@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Edit Test - {{ $test->name }}</h2>

    <form action="{{ route('tests.update', $test->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Test Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $test->name }}" required>
                </div>
                <div class="form-group">
    <label for="lesson_id">Lesson</label>
    <select name="lesson_id" id="lesson_id" class="form-control" required>
        @foreach($lessons as $lesson)
            <option value="{{ $lesson->id }}" {{ $lesson->id == $test->lesson_id ? 'selected' : '' }}>
                {{ $lesson->title }} 
            </option>
        @endforeach
    </select>
</div>

                <div class="form-group">
                    <label for="number_of_questions">Number of Questions</label>
                    <input type="number" name="number_of_questions" id="number_of_questions" class="form-control" value="{{ $test->number_of_questions }}" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update Test</button>
            </div>
        </div>
    </form>
</div>
@endsection

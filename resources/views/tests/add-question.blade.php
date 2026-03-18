@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">إضافة سؤال للاختبار</h2>

    <form action="{{ route('tests.addQuestion', $test->id) }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="question_text">نص السؤال</label>
                    <input type="text" name="question_text" id="question_text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="question_type">نوع السؤال</label>
                    <select name="question_type" id="question_type" class="form-control" required>
                        <option value="multiple_choice">اختيار من متعدد</option>
                        <option value="true_false">صواب أو خطأ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="correct_answer">الإجابة الصحيحة</label>
                    <input type="text" name="correct_answer" id="correct_answer" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="options">الاختيارات</label>
                    <input type="text" name="options[]" class="form-control" placeholder="الخيار 1" required>
                    <input type="text" name="options[]" class="form-control" placeholder="الخيار 2" required>
                    <input type="text" name="options[]" class="form-control" placeholder="الخيار 3" required>
                </div>
                <button type="submit" class="btn btn-success mt-3">إضافة السؤال</button>
            </div>
        </div>
    </form>
</div>
@endsection

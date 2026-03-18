@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">نتائج الاختبارات</h2>

    <div class="card">
        <div class="card-body">
            <h4>النتائج:</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>الاختبار</th>
                        <th>الدرجة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <td>{{ $result->test->name }}</td>
                        <td>{{ $result->score }}</td>
                        <td>{{ $result->completed_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

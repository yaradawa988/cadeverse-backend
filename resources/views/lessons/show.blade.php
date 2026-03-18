@extends('layouts.app')

@section('content')
<style>
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

.lesson-image {
    width: 180px;
    height: auto;
    border-radius: 10px;
    border: 3px solid #ddd;
}

h2 {
    color: #007bff;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 20px;
}

.card-text {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

.content-section {
    background: #f8f9fa;
    border-left: 5px solid #007bff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.video-container {
    position: relative;
    padding-bottom: 40%;  
    height: 0;
    overflow: hidden;
    max-width: 100%;
    background: #000;
    border-radius: 10px;
    margin-bottom: 20px;
}

.video-container iframe, 
.video-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 10px;
}

.btn-custom {
    min-width: 130px;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 10px;
    transition: all 0.3s ease-in-out;
    text-align: center;
    margin: 5px;
}

.btn-warning {
    background-color: #ffc107;
    border: none;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-info {
    background-color: #17a2b8;
    border: none;
}

.btn-info:hover {
    background-color: #138496;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.card-body p {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
}

hr {
    border-top: 1px solid #ddd;
}

@media (max-width: 768px) {
    .card {
        padding: 20px;
    }

    .btn-custom {
        min-width: 100px;
        font-size: 14px;
    }

    .lesson-image {
        width: 150px;
    }

    h2 {
        font-size: 24px;
    }
}
.btn-success, .btn-danger, .btn-warning, .btn-info {
    width: 120px !important;
    height: 70px !important;
    color: black !important; 
}
</style>

<div class="container">
    <div class="card mx-auto shadow-lg rounded-3">
        <div class="text-center mt-3">
            <img src="{{ asset($lesson->image) }}" class="lesson-image img-thumbnail" alt="Lesson Image">
        </div>
        <div class="card-body">
            <h2 class="card-title text-center">{{ $lesson->title }}</h2>
            <p class="card-text text-center"><strong>Description:</strong> {{ $lesson->description }}</p>

            @foreach ($lesson->contents as $content)
                <div class="content-section my-4">
                    <h4>Level: <span class="badge bg-primary">{{ ucfirst($content->level) }}</span></h4>

                    <p><strong>Content:</strong> {{ $content->content }}</p>

                    @if ($content->video)
                        <div class="video-container my-3">
                            @if (filter_var($content->video, FILTER_VALIDATE_URL))
                                <iframe class="embed-responsive-item" src="{{ $content->video }}" frameborder="0" allowfullscreen></iframe>
                            @else
                                <video controls>
                                    <source src="{{ asset($content->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @endif

                 

                    <div class="action-buttons">
                    @if ($content->pdf)
                        <p>
                            <a href="{{ asset($content->pdf) }}" target="_blank" class="btn btn-info btn-custom">
                                <i class="fas fa-file-pdf"></i> Download
                            </a>
                        </p>
                    @endif
                        <a href="{{ route('lessons.editContent', $content->id) }}" class="btn btn-info btn-custom">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('lessons.deleteContent', $content->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-custom" onclick="return confirm('Are you sure you want to delete?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
</div>
@endsection

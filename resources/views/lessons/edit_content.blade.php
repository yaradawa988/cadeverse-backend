@extends('layouts.app')

@section('content')
<style>
.navbar {
        background:rgb(255, 255, 255) !important;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }
   .container {
   
    margin-top: 100px;
}

.card {
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    padding: 20px;
    max-width: 800px;
    margin: auto;
}

h2 {
    color: #007bff;
}

.form-label {
    font-weight: bold;
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
    padding: 10px 15px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    text-align: center;
}

.btn-warning {
    background-color: #ffc107;
    border: none;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-success:hover {
    background-color: #218838;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}
</style>

<div class="container">
    <h2 class="text-center my-4">Edit Lesson Content</h2>
    <div class="card mx-auto shadow-lg rounded-3">
        <div class="card-body">
            <form action="{{ route('lessons.updateContent', $content->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select name="level" class="form-control form-control-lg rounded" required>
                        <option value="beginner" {{ $content->level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ $content->level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ $content->level == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="video" class="form-label">Video (URL or Upload a New File)</label>
                    <input type="text" name="video" class="form-control form-control-lg rounded mb-2" placeholder="Enter video URL" value="{{ filter_var($content->video, FILTER_VALIDATE_URL) ? $content->video : '' }}">
                    <input type="file" name="video_file" class="form-control form-control-lg rounded shadow-sm" accept="video/*">

                    @if($content->video)
                        <p class="mt-3">Current Video:</p>
                        <div class="video-container">
                            @if(filter_var($content->video, FILTER_VALIDATE_URL))
                                <iframe class="rounded" src="{{ $content->video }}" frameborder="0" allowfullscreen></iframe>
                            @else
                                <video class="rounded shadow-sm" controls>
                                    <source src="{{ asset($content->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="pdf" class="form-label">PDF File (Optional)</label>
                    <input type="file" name="pdf" class="form-control form-control-lg rounded shadow-sm">
                    @if($content->pdf)
                        <p class="mt-2">
                            <a href="{{ asset($content->pdf) }}" target="_blank" class="btn btn-warning btn-custom">
                                <i class="fas fa-file-pdf"></i> View Current File
                            </a>
                        </p>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Text Content</label>
                    <textarea name="content" class="form-control form-control-lg rounded shadow-sm" required>{{ $content->content }}</textarea>
                </div>

               
                <div class="action-buttons">
                    <button type="submit" class="btn btn-success btn-custom">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

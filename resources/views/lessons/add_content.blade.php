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
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    padding: 20px;
    max-width: 600px;
    margin: auto;
}

h2 {
    color: #333;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #ccc;
    padding: 10px;
}

.btn-success {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    background-color: #28a745;
    border-radius: 10px;
    transition: background 0.3s ease;
}

.btn-success:hover {
    background-color: #218838;
}

</style>

<div class="container">
    <h4 class="text-center">Add Lesson Content</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('lessons.addContent', $lesson_id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="level" class="form-label"><strong>Level</strong></label>
                    <select name="level" class="form-control" required>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="video" class="form-label"><strong>Video (Upload file or enter URL)</strong></label>
                    <input type="text" name="video" class="form-control" placeholder="Enter a video URL">
                    <div class="text-center my-2">— OR —</div>
                    <input type="file" name="video_file" class="form-control" accept="video/*">
                </div>

                <div class="mb-3">
                    <label for="pdf" class="form-label"><strong>PDF File (Optional)</strong></label>
                    <input type="file" name="pdf" class="form-control" accept=".pdf">
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label"><strong>Content</strong></label>
                    <textarea name="content" class="form-control" rows="1" required></textarea>
                </div>

                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Add Content</button>
            </form>
        </div>
    </div>
</div>
@endsection

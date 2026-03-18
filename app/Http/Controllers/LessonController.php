<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Favorite;
use App\Models\LessonContent;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller


{
    
       
        public function index()
        {
            $lessons = Lesson::with('contents')->get();
            return view('lessons.index', compact('lessons'));
        }
    
    
        public function create()
        {
            return view('lessons.create');
        }
    
        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $lesson = new Lesson();
            $lesson->title = $request->title;
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('files/lesson_images/'), $filename); 
                $lesson->image = 'files/lesson_images/' . $filename;
            }
    
            $lesson->description = $request->description;
            $lesson->save();
    
            return redirect()->route('lessons.index')->with('success', 'Lesson created successfully!');
        }
    
        public function edit($id)
        {
            $lesson = Lesson::findOrFail($id);
            return view('lessons.edit', compact('lesson'));
        }
    
      
        public function update(Request $request, $id)
        {
            $lesson = Lesson::findOrFail($id);
        
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string'
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        
            $lesson->title = $request->title;
            $lesson->description = $request->description;
        
            if ($request->hasFile('image')) {
                
                if ($lesson->image && file_exists(public_path($lesson->image))) {
                    unlink(public_path($lesson->image));
                }
        
                
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('files/lesson_images/'), $filename);
                $lesson->image = 'files/lesson_images/' . $filename;
            }
        
            $lesson->save();
        
            return redirect()->route('lessons.index')->with('success', 'Lesson updated successfully!');
        }
        
    
     
        public function destroy($id)
        {
            $lesson = Lesson::findOrFail($id);
            $lesson->delete();
            return redirect()->route('lessons.index')->with('success', 'Lesson deleted successfully!');
        }
    
     
        public function addContentForm($lesson_id)
        {
            return view('lessons.add_content', compact('lesson_id'));
        }
    
  
       public function addContent(Request $request, $lesson_id)
       {
           $validator = Validator::make($request->all(), [
               'level' => 'required|in:beginner,intermediate,advanced',
               'video' => 'nullable|string',
               'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv', 
               'pdf' => 'nullable|file|mimes:pdf|max:5120',
               'content' => 'required|string'
           ]);
       
           if ($validator->fails()) {
               return redirect()->back()->withErrors($validator)->withInput();
           }
       
           $lessonContent = new LessonContent();
           $lessonContent->lesson_id = $lesson_id;
           $lessonContent->level = $request->level;
           $lessonContent->content = $request->content;
       
           if ($request->hasFile('video_file')) {
               $video = $request->file('video_file');
               $filename = time() . '_' . $video->getClientOriginalName();
               $video->move(public_path('files/lesson_videos/'), $filename);
               $lessonContent->video = 'files/lesson_videos/' . $filename; 
           } elseif ($request->video) {
               $lessonContent->video = $request->video; 
           }
       
           
           if ($request->hasFile('pdf')) {
               $pdf = $request->file('pdf');
               $filename = time() . '_' . $pdf->getClientOriginalName();
               $pdf->move(public_path('files/lesson_pdfs/'), $filename);
               $lessonContent->pdf = 'files/lesson_pdfs/' . $filename;
           }
       
           $lessonContent->save();
       
           return redirect()->route('lessons.index')->with('success', 'Lesson content added successfully!');
       }
       

    
       
        public function removeContent($id)
        {
            $content = LessonContent::findOrFail($id);
            $content->delete();
            return redirect()->route('lessons.index')->with('success', 'Content deleted successfully!');
        }
    
        
        public function show($id)
        {
            $lesson = Lesson::with('contents')->findOrFail($id);
            return view('lessons.show', compact('lesson'));
        }
    
        
        public function editContent($id)
        {
            $content = LessonContent::findOrFail($id);
            return view('lessons.edit_content', compact('content'));
        }
    
        public function updateContent(Request $request, $id)
        {
            $content = LessonContent::findOrFail($id);
        
            $validator = Validator::make($request->all(), [
                'level' => 'required|in:beginner,intermediate,advanced',
                'video' => 'nullable|string',
                'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv', 
                'pdf' => 'nullable|file|mimes:pdf|max:5120',
                'content' => 'required|string'
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        
            $content->level = $request->level;
            $content->content = $request->content;
        
            if ($request->hasFile('video_file')) {
             
                if ($content->video && !filter_var($content->video, FILTER_VALIDATE_URL)) {
                    $oldVideoPath = public_path($content->video);
                    if (file_exists($oldVideoPath)) {
                        unlink($oldVideoPath);
                    }
                }
                
                $video = $request->file('video_file');
                $filename = time() . '_' . $video->getClientOriginalName();
                $video->move(public_path('files/lesson_videos/'), $filename);
                $content->video = 'files/lesson_videos/' . $filename;
            } elseif ($request->video) {
               
                $content->video = $request->video;
            }
        
            
            if ($request->hasFile('pdf')) {
               
                if ($content->pdf) {
                    $oldPdfPath = public_path($content->pdf);
                    if (file_exists($oldPdfPath)) {
                        unlink($oldPdfPath);
                    }
                }
                
                $pdf = $request->file('pdf');
                $filename = time() . '_' . $pdf->getClientOriginalName();
                $pdf->move(public_path('files/lesson_pdfs/'), $filename);
                $content->pdf = 'files/lesson_pdfs/' . $filename;
            }
        
            $content->save();
        
            return redirect()->route('lessons.show', $content->lesson_id)->with('success', 'تم تعديل المحتوى بنجاح!');
        }
        
        
        public function deleteContent($id)
        {
            $content = LessonContent::findOrFail($id);
            $lesson_id = $content->lesson_id;
    
            if ($content->pdf) {
                Storage::delete(public_path('files/' . $content->pdf));
            }
    
            $content->delete();
    
            return redirect()->route('lessons.show', $lesson_id)->with('success', 'تم حذف المحتوى بنجاح!');
        }
    }
    
    


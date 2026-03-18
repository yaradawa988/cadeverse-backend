<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use App\Models\Lesson;
use Illuminate\Support\Facades\Validator;
class TestController extends Controller
{


    public function index()
    {
        
        $tests = Test::with('lesson')->get();

        
        return view('tests.index', compact('tests'));
    }
    
     public function store(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'name' => 'required|string|max:255',
             'lesson_id' => 'required|exists:lessons,id',
             'number_of_questions' => 'required|integer|min:1',
         ]);
     
         if ($validator->fails()) {
             return redirect()->route('tests.index')->withErrors($validator)->withInput();
         }
     
         $test = Test::create($request->all());
     
         return redirect()->route('tests.index')->with('success', 'تم إضافة الاختبار بنجاح');
     }
     
     public function create()
     {
         $lessons = Lesson::all(); 
         return view('tests.create', compact('lessons')); 
     }
     public function edit($id)
     {
         $test = Test::find($id);
         
         if (!$test) {
             return redirect()->route('tests.index')->with('error', 'Test not found.');
         }
     
        
         $lessons = Lesson::all(['id', 'title']); 
     
         return view('tests.edit', compact('test', 'lessons'));
     }
     
 
public function show($id)
{
   
    $test = Test::findOrFail($id);
    $test = Test::with('questions')->findOrFail($id);
    
    return view('tests.show', compact('test'));
}

     
public function update(Request $request, $id)
{
    $test = Test::find($id);

    if (!$test) {
        return redirect()->route('tests.index')->with('error', 'Test not found.');
    }

    
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'lesson_id' => 'required|exists:lessons,id',
        'number_of_questions' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return redirect()->route('tests.edit', $id)->withErrors($validator)->withInput();
    }

    $test->update($request->all());

    return redirect()->route('tests.index')->with('success', 'Test updated successfully.');
}

     public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();

        return redirect()->route('tests.index')->with('success', 'تم حذف الاختبار بنجاح');
    }

    
     public function createquestion($test_id)
     {
         $test = Test::findOrFail($test_id);
         return view('questions.create', compact('test'));
     }
     
  
     public function addQuestion(Request $request, $testId)
     {
         $test = Test::find($testId);
         if (!$test) {
             return redirect()->route('tests.index')->with('error', 'الاختبار غير موجود');
         }
     
         $validator = Validator::make($request->all(), [
             'question_text' => 'required|string',
             'question_type' => 'required|string',
             'correct_answer' => 'required|string',
             'options' => 'nullable|array',
             'point' => 'nullable|integer',
             'image_path' => 'nullable|string',
         ]);
     
         if ($validator->fails()) {
             return redirect()->route('tests.show', $testId)->withErrors($validator)->withInput();
         }
     
         $question = new Question($request->all());
         $test->questions()->save($question);
     
         return redirect()->route('tests.show', $testId)->with('success', 'تم إضافة السؤال بنجاح');
     }
     
 
  
     public function updateQuestion(Request $request, $testId, $questionId)
     {
         $test = Test::find($testId);
         if (!$test) {
             return redirect()->route('tests.index')->with('error', 'الاختبار غير موجود');
         }
     
         $question = $test->questions()->find($questionId);
         if (!$question) {
             return redirect()->route('tests.show', $testId)->with('error', 'السؤال غير موجود');
         }
     
         $question->update($request->all());
     
         return redirect()->route('tests.show', $testId)->with('success', 'تم تحديث السؤال بنجاح');
     }
     
 
    
     public function deleteQuestion($testId, $questionId)
     {
         $test = Test::find($testId);
         if (!$test) {
             return redirect()->route('tests.index')->with('error', 'الاختبار غير موجود');
         }
     
         $question = $test->questions()->find($questionId);
         if (!$question) {
             return redirect()->route('tests.show', $testId)->with('error', 'السؤال غير موجود');
         }
     
         $question->delete();
     
         return redirect()->route('tests.show', $testId)->with('success', 'تم حذف السؤال بنجاح');
     }

     public function showResults($userId)
     {
         $results = Result::where('user_id', $userId)->with('test')->get();
     
         return view('results.index', [
             'results' => $results
         ]);
     }
     
 }

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
   
    
    
    public function create($test_id)
    {
        $test = Test::findOrFail($test_id);
        $questions = Question::where('test_id', $test_id)->get();
        return view('questions.create', compact('test', 'questions'));
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_text' => 'required|string',
            'question_type' => 'required|string',
            'option1' => 'required|string',
            'option2' => 'required|string',
            'option3' => 'nullable|string',
            'option4' => 'nullable|string',
            'correct_answer' => 'required|string|in:option1,option2,option3,option4',
            'mark' => 'required|integer|min:1',
        ]);
    
        $test = Test::findOrFail($request->test_id);
    
        $currentQuestionsCount = $test->questions()->count();
        if ($currentQuestionsCount >= $test->number_of_questions) {
            return redirect()->back()->with('error', 'You have reached the maximum number of questions for this test.');
        }
    
        $options = json_encode([
            'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
            'option4' => $request->option4,
        ]);
    
        Question::create([
            'test_id' => $request->test_id,
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
            'options' => $options,
            'correct_answer' => $request->correct_answer,
            'mark' => $request->mark,
        ]);
    
        return redirect()->route('questions.create', $request->test_id)->with('message', 'Question added successfully.');
    }
    
    public function update(Request $request, Question $question, $test_id)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_text' => 'required|string',
            'question_type' => 'required|string|in:multiple_choice,text',
            'option1' => 'required|string',
            'option2' => 'required|string',
            'option3' => 'nullable|string',
            'option4' => 'nullable|string',
            'correct_answer' => 'required|string|in:option1,option2,option3,option4',
            'mark' => 'required|integer|min:1',
        ]);
    
        $test = Test::findOrFail($request->test_id);
    
        $currentQuestionsCount = $test->questions()->count();
        if ($currentQuestionsCount > $test->number_of_questions) {
            return redirect()->back()->with('error', 'You have reached the maximum number of questions for this test.');
        }
    
        $options = json_encode([
            'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
            'option4' => $request->option4,
        ]);
    
        $data = [
            'test_id' => $request->test_id,
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
            'options' => $options,
            'correct_answer' => $request->correct_answer,
            'mark' => $request->mark,
        ];
    
        $question->update($data);
    
        return redirect()->route('questions.create', $test_id)->with('message', 'Question updated successfully.');
    }
    
    public function edit($questionId, $testId)
    {
        $test = Test::find($testId);
        if (!$test) {
            return redirect()->route('tests.index')->with('error', 'Test not found.');
        }
    
        $question = $test->questions()->find($questionId);
        if (!$question) {
            return redirect()->route('tests.show', $testId)->with('error', 'Question not found.');
        }
    
        return view('questions.edit', compact('question', 'testId')); 
    }
    
    

   
   
    public function destroy($testId, $questionId)
    {
        $test = Test::findOrFail($testId);
        $question = $test->questions()->findOrFail($questionId);

        $question->delete();

        return redirect()->route('tests.show', $testId)->with('success', 'تم حذف السؤال بنجاح');
    }
}
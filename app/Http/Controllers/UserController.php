<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\lesson;
use App\Models\Favorite;
use App\Models\Test;
use App\Models\Result;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\LessonContent;
use App\Models\ProgressTracking;
use App\Models\MonthlyStatistics;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
class UserController extends Controller
{
   
    




        public function update(Request $request, User $user)
        {
            $validated = $request->validate([
                'name' => 'nullable|max:255',
                'l_name' => 'nullable|max:255',
                'university'=> ['nullable','string'],
                'email' => ['string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:6',
                'image' => 'nullable|image',
            ]);
        
            $password = $request->password ? bcrypt($request->password) : $user->password;
        
            if ($request->hasFile('image')) {
                if (Storage::exists("public/" . $user->image) && $user->image != "images/avatars/default-avatar.png") {
                    Storage::delete("public/" . $user->image);
                }
                $image = Storage::disk('public')->put('/images/avatars', $request->image);
            } else {
                $image = $user->image;
            }
        
            $user->name = $request->name ?? $user->name;
            $user->l_name = $request->l_name ?? $user->l_name;
            $user->university = $request->university ?? $user->university;
            $user->email = $request->email ?? $user->email;
            $user->password = $password;
            $user->image = $image;
        
            
            $user->save();
     
            $user->image = url('storage/' . $user->image);
        
            return response()->json([
                'message' => 'تم تعديل الملف الشخصي بنجاح',
                'data' => new UserResource($user),
            ]);
        }
        
        public function profile(Request $request)
        {
            $user = Auth::user();
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id'
            ]);
            $user->image = asset('storage/' . $user->image);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        
            $user = Auth::user();
        
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        
            if ($request->expectsJson()) {
                return new UserResource($user);
            } else {
                return response()->json(['message' => 'تم عرض ملف المستخدم بنجاح']);
            }
        }

//////////////////////////////////////////////////////////////////////////////////////////////////



public function getLessons()
{
    $lessons = lesson::all()->map(function ($lesson) {
        $lesson->image = $this->getImageUrl($lesson->image);
        return $lesson;
    });

    if ($lessons->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'لا توجد دورات تعليمية حالياً'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'تم جلب جميع الدورات بنجاح',
        'data' => $lessons
    ]);
}


private function getImageUrl($path)
{
    if (!$path) {
        return null;
    }

 
    if (file_exists(public_path($path))) {
        return asset($path);
    }

    if (file_exists(storage_path('app/public/' . $path))) {
        return asset('storage/' . $path);
    }

    return asset('images/default.png'); 
}



public function getLessonDetails($lessonId)
{
    $lesson = lesson::find($lessonId);

    if (!$lesson) {
        return response()->json([
            'status' => 'error',
            'message' => 'لم يتم العثور على الدرس'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'lesson' => [
            'id' => $lesson->id,
            'title' => $lesson->title,
            'description' => $lesson->description,
            'image' => asset($lesson->image),  
        ]
    ]);
}


public function getLessonContent($lessonId, $level)
{
    $lesson = lesson::find($lessonId);

    if (!$lesson) {
        return response()->json([
            'status' => 'error',
            'message' => 'الدورة المطلوبة غير موجودة'
        ], 404);
    }

    $lessonContent = LessonContent::where('lesson_id', $lessonId)
        ->where('level', $level)
        ->first();

    if (!$lessonContent) {
        return response()->json([
            'status' => 'error',
            'message' => 'لا توجد محتويات لهذا المستوى في هذه الدورة'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'تم جلب تفاصيل الدورة والمحتوى بنجاح',
        'data' => [
            'lesson' => [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'description' => $lesson->description,
                'image' => asset($lesson->image),  
            ],
            'content' => [
                'id' => $lessonContent->id,
                'level' => $lessonContent->level,
                'content' => $lessonContent->content,
                'video' => filter_var($lessonContent->video, FILTER_VALIDATE_URL) ? $lessonContent->video : asset($lessonContent->video),
                'pdf' => $lessonContent->pdf ? asset($lessonContent->pdf) : null,
            ]
        ]
    ]);
}


public function getSingleLessonContent($lessonId, $contentId)
{
    try {
       
        $lesson = lesson::findOrFail($lessonId);

        
        $lessonContent = LessonContent::where('lesson_id', $lessonId)
            ->where('id', $contentId)
            ->firstOrFail();

       
        return response()->json([
            'status' => 'success',
            'message' => 'تم جلب المحتوى بنجاح',
            'data' => [
                'id' => $lessonContent->id,
                'level' => $lessonContent->level,
                'content' => $lessonContent->content,
                'video' => filter_var($lessonContent->video, FILTER_VALIDATE_URL) ? $lessonContent->video : asset($lessonContent->video),
                'pdf' => $lessonContent->pdf ? asset($lessonContent->pdf) : null,
                'lesson' => [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'description' => $lesson->description,
                    'image' => asset($lesson->image),
                ]
            ]
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'لم يتم العثور على المحتوى المطلوب في هذا الدرس'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'حدث خطأ أثناء جلب البيانات',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function saveProgress(Request $request)
{
    $request->validate([
        'lesson_id' => 'required|exists:lessons,id',
        'progress_percentage' => 'required|integer|min:0|max:100'
    ]);

    $progress = ProgressTracking::updateOrCreate(
        ['user_id' => Auth::id(), 'lesson_id' => $request->lesson_id],
        ['progress_percentage' => $request->progress_percentage]
    );

    return response()->json([
        'status' => 'success',
        'message' => 'تم حفظ تقدم المستخدم بنجاح',
        'data' => $progress
    ]);
}
public function getProgress($lessonId)
{
    try {
        
        $progress = ProgressTracking::where('user_id', Auth::id())
            ->where('lesson_id', $lessonId)
            ->first();

        if (!$progress) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم العثور على أي تقدم لهذا الدرس'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم جلب تقدم المستخدم بنجاح',
            'data' => [
                'lesson_id' => $progress->lesson_id,
                'progress_percentage' => $progress->progress_percentage,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'حدث خطأ أثناء جلب التقدم',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function getAllProgress()
{
    try {
        
        $progressList = ProgressTracking::where('user_id', Auth::id())
            ->with('lesson:id,title,description,image') 
            ->get();

        if ($progressList->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم العثور على أي تقدم محفوظ للمستخدم'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم جلب جميع التقدم المحفوظ بنجاح',
            'data' => $progressList->map(function ($progress) {
                return [
                    'lesson_id' => $progress->lesson_id,
                    'title' => $progress->lesson->title,
                    'description' => $progress->lesson->description,
                    'image' => asset($progress->lesson->image),
                    'progress_percentage' => $progress->progress_percentage,
                ];
            })
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'حدث خطأ أثناء جلب التقدم',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function completedLessons()
{
    $completedLessons = ProgressTracking::where('user_id', Auth::id())
        ->where('progress_percentage', 100)
        ->with(['lesson' => function ($query) {
            $query->select('id', 'title', 'description', 'image');
        }])
        ->get();

    if ($completedLessons->isEmpty()) {
        return response()->json([
            'status' => 'success',
            'message' => 'لا توجد دورات مكتملة بعد.',
            'data' => []
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'تم جلب الدورات المكتملة بنجاح',
        'data' => $completedLessons->map(function ($progress) {
            return [
                'lesson_id' => $progress->lesson->id,
                'title' => $progress->lesson->title,
                'description' => $progress->lesson->description,
                'image' => asset($progress->lesson->image),
                'progress' => $progress->progress_percentage
            ];
        })
    ]);
}



public function markLessonAsCompleted(Request $request, $lessonId)
{
    
    $progress = ProgressTracking::where('user_id', Auth::id())
        ->where('lesson_id', $lessonId)
        ->first();

    if (!$progress) {
        return response()->json([
            'status' => 'error',
            'message' => 'لم يتم العثور على التقدم لهذا الدرس'
        ]);
    }

  
    $progress->progress_percentage = 100;
    $progress->save();

    return response()->json([
        'status' => 'success',
        'message' => 'تم تمييز الدرس كـ مكتمل بنجاح',
        'data' => $progress
    ]);
}



public function participateInTest($testId)
{
    $test = Test::find($testId);

    if ($test) {
        return response()->json([
            'status' => 'success',
            'message' => 'تم العثور على الاختبار',
            'data' => $test
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'لم يتم العثور على الاختبار'
        ], 404);
    }
}



public function addToFavorites($lessonId)
{
    $exists = Favorite::where('user_id', Auth::id())->where('lesson_id', $lessonId)->exists();

    if ($exists) {
        return response()->json([
            'status' => 'error',
            'message' => 'الدورة مضافة بالفعل إلى المفضلة'
        ], 409);
    }

    $favorite = Favorite::create([
        'user_id' => Auth::id(),
        'lesson_id' => $lessonId
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'تمت إضافة الدورة إلى المفضلة بنجاح',
        'data' => $favorite
    ]);
}


public function removeFromFavorites($lessonId)
{
    $favorite = Favorite::where('user_id', Auth::id())
        ->where('lesson_id', $lessonId)
        ->first();

    if ($favorite) {
        $favorite->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'تمت إزالة الدورة من المفضلة بنجاح'
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'هذه الدورة غير موجودة في المفضلة'
        ], 404);
    }
}


public function getFavorites()
{

    $favorites = Favorite::with('lesson')  
        ->where('user_id', Auth::id())  
        ->get();

    
    if ($favorites->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'لا توجد دروس مفضلة',
            'data' => []
        ], 404);
    }

   
    return response()->json([
        'status' => 'success',
        'message' => 'تم جلب الدروس المفضلة بنجاح',
        'data' => $favorites
    ], 200);
}

//////////////////////////////////////////////////////////////////////
// الاختبارات

 
 public function getAllTests()
 {
     $tests = Test::all();

     if ($tests->isEmpty()) {
         return response()->json([
             'status' => 'error',
             'message' => 'لا توجد اختبارات متاحة حالياً'
         ], 404);
     }

     return response()->json([
         'status' => 'success',
         'message' => 'تم جلب جميع الاختبارات بنجاح',
         'data' => $tests
     ]);
 }


 public function getTestsByLesson($lessonId)
 {
     $tests = Test::where('lesson_id', $lessonId)->get();

     if ($tests->isEmpty()) {
         return response()->json([
             'status' => 'error',
             'message' => 'لا توجد اختبارات متاحة لهذا الدرس'
         ], 404);
     }

     return response()->json([
         'status' => 'success',
         'message' => 'تم جلب الاختبارات الخاصة بالدرس بنجاح',
         'data' => $tests
     ]);
 }
 public function getTestDetails($testId)
 {
     $test = Test::with('questions')->find($testId);
 
     if (!$test) {
         return response()->json([
             'status' => 'error',
             'message' => 'لم يتم العثور على الاختبار'
         ], 404);
     }
 
     
     foreach ($test->questions as $question) {
         $question->options = json_decode($question->options); 
         
       
         unset($question->correct_answer);
     }
 
     return response()->json([
         'status' => 'success',
         'message' => 'تم جلب تفاصيل الاختبار بنجاح',
         'data' => $test
     ]);
 }
 

 public function getTestResult($testId)
 {
     $result = Result::where('test_id', $testId)
         ->where('user_id', Auth::id())
         ->with(['test.lesson']) 
         ->first();
 
     if (!$result) {
         return response()->json([
             'status' => 'error',
             'message' => 'لا توجد نتيجة لهذا الاختبار'
         ], 404);
     }
 
     return response()->json([
         'status' => 'success',
         'message' => 'تم جلب نتيجة الاختبار بنجاح',
         'data' => [
            'user_id' => $result->user_id,
            'test_id' => $result->test->id,
             'test_name' => $result->test->name,
             'lesson_id' => $result->test->lesson->id,
             'lesson_title' => $result->test->lesson->title,
             'score' => $result->score,
             'completed_at' => $result->completed_at,
         ]
     ]);
 }
 

 public function getUserResults()
 {
     $user = Auth::user(); 
     $results = Result::where('user_id', Auth::id())
         ->with(['test.lesson']) 
         ->get();
 
     if ($results->isEmpty()) {
         return response()->json([
             'status' => 'error',
             'message' => 'لا توجد نتائج اختبارات للمستخدم'
         ], 404);
     }
 
     $formattedResults = $results->map(function ($result) {
         return [
             'test_id' => $result->test->id,
             'test_name' => $result->test->name,
             'lesson_id' => $result->test->lesson->id,
             'lesson_title' => $result->test->lesson->title,
             'score' => $result->score,
             'completed_at' => $result->completed_at,
         ];
     });
 
     return response()->json([
         'status' => 'success',
         'message' => 'تم جلب جميع نتائج الاختبارات للمستخدم بنجاح',
         'data' => [
             'user' => [
                 'user_id' => $user->id,
                 'name' => $user->name,
                 'email' => $user->email,
               
             ],
             'results' => $formattedResults
         ]
     ]);
 }
 

















 ///////////////////////////
 public function submitTest(Request $request, $testId)
 {
     
     $test = Test::findOrFail($testId);
 
    
     $user = auth()->user();
     if (!$user) {
         return response()->json([
             'status' => 'error',
             'message' => 'المستخدم غير مصادق'
         ], 401);
     }
 
     
     $request->validate([
         'answers' => 'required|array',
         'answers.*' => 'required|string'
     ]);
 
     $answers = $request->input('answers');
     $score = 0;
 
     
     DB::beginTransaction();
 
     try {
         foreach ($answers as $questionId => $selectedOption) {
             
             $question = Question::where('test_id', $testId)
                               ->where('id', $questionId)
                               ->first();
 
             if (!$question) {
                 continue;
             }
 
             
             $userAnswer = UserAnswer::create([
                 'user_id' => $user->id,
                 'question_id' => $questionId,
                 'answer' => $selectedOption,
                 'is_correct' => ($selectedOption === $question->correct_answer)
             ]);
 
             
             if (!$userAnswer) {
                 throw new \Exception('فشل في تخزين إجابة المستخدم');
             }
 
          
if ($selectedOption === $question->correct_answer) {
    $score += $question->mark; 
}

         }
 
         
         $result = Result::updateOrCreate(
             [
                 'user_id' => $user->id,
                 'test_id' => $testId,
             ],
             [
                 'score' => $score,
                 'completed_at' => now(),
             ]
         );
 
        
         $month = now()->month;
         $year = now()->year;
 
         MonthlyStatistics::updateOrCreate(
             [
                 'user_id' => $user->id,
                 'test_id' => $testId,
                 'month' => $month,
                 'year' => $year
             ],
             [
                 'total_score' => DB::raw("IFNULL(total_score, 0) + $score")
             ]
         );
 
         
         DB::commit();
 
         return response()->json([
             'status' => 'success',
             'message' => ' تم تسجيل الإجابات وحفظ النتيجة بنجاح',
             'score' => $score,
             'test_id' => $testId,
             'completed_at' => now()->toDateTimeString(),
         ], 200);
 
     } catch (\Exception $e) {
      
         DB::rollBack();
         
         return response()->json([
             'status' => 'error',
             'message' => 'حدث خطأ أثناء معالجة الإجابات: ' . $e->getMessage()
         ], 500);
     }
 }
 


















public function viewMonthlyTopScorers()
{
    
    $month = now()->month;
    $year = now()->year;

    
    $topScorers = MonthlyStatistics::where('month', $month)
        ->where('year', $year)
        ->orderBy('total_score', 'desc') 
        ->take(5) 
        ->with('user') 
        ->get();

    
    $topScorersData = $topScorers->map(function($stat) {
        return [
            'user_id' => $stat->user_id,
            'name' => $stat->user->name,
            'email' => $stat->user->email,
            'university' => $stat->user->university,
            'total_score' => $stat->total_score,
            'month' => $stat->month,
            'year' => $stat->year,
            'created_at' => $stat->created_at,
            'updated_at' => $stat->updated_at
        ];
    });


    return response()->json([
        'status' => 'success',
        'message' => 'تم جلب أفضل خمسة فائزين لهذا الشهر',
        'data' => $topScorersData
    ]);
}

//////////////////////////


public function addLessonToMyList($lessonId)
{
    try {
        $user = Auth::user();
        $lesson = lesson::findOrFail($lessonId);

        if ($user->lessons->contains($lessonId)) {
            return response()->json([
                'message' => 'الدرس مضاف مسبقًا إلى قائمتك.',
            ], 409); 
        }

        $user->lessons()->attach($lessonId);

        return response()->json([
            'message' => 'تمت إضافة الدرس إلى قائمتك.',
            'lesson' => [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'description' => $lesson->description,
                'image' => asset($lesson->image),  
            ]
        ], 201); 

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'الدرس غير موجود.'
        ], 404);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'حدث خطأ أثناء إضافة الدرس.',
            'details' => $e->getMessage()
        ], 500);
    }
}

public function removeLessonFromMyList($lessonId)
{
    try {
        $user = Auth::user();
        $lesson = lesson::findOrFail($lessonId);

        if (!$user->lessons->contains($lessonId)) {
            return response()->json([
                'message' => 'الدرس غير موجود في قائمتك.',
            ], 404);
        }

        $user->lessons()->detach($lessonId);

        return response()->json([
            'message' => 'تمت إزالة الدرس من قائمتك.',
            'lesson_id' => $lessonId
        ]);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'الدرس غير موجود.'
        ], 404);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'حدث خطأ أثناء إزالة الدرس.',
            'details' => $e->getMessage()
        ], 500);
    }
}
public function myLessonList()
{
    try {
        $user = Auth::user();
        $lessons = $user->lessons;

        if ($lessons->isEmpty()) {
            return response()->json([
                'message' => 'قائمتك خالية من الدروس حاليًا.',
                'my_lessons' => []
            ]);
        }

        $formattedLessons = $lessons->map(function ($lesson) {
            return [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'description' => $lesson->description,
                'image' => asset($lesson->image),
            ];
        });

        return response()->json([
            'my_lessons' => $formattedLessons
        ]);

    } catch (Exception $e) {
        return response()->json([
            'error' => 'حدث خطأ أثناء جلب القائمة.',
            'details' => $e->getMessage()
        ], 500);
    }
}


}
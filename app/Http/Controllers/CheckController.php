<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Models\Check;

class CheckController extends Controller
{
    public function index()
    {
        
        if(!Auth::user()->role == 1){
            abort(403);
        }
        $checks = Check::with('user')->orderByDesc('id')->get();
    
        if ($checks->isNotEmpty()) {
            return response()->json([
                'status' => 1,
                'message' => 'All messags for all users...',
                'data' => $checks,
            ], 200);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'No messags found for any user...',
                'data' => [],
            ], 200);
        }
    }
    
    


    public function usermessages($id)
    {
        $user = Auth::user();
        $checks = Check::with('user')->where('user_id', $id)->orderByDesc('id')->get();
    
        if ($checks->count() > 0) {
            return response()->json([
                'status' => 1,
                'message' => 'All messags by user...',
                'data' => $checks,
            ], 200);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'No messagsfound by user...',
                'data' => [],
            ], 200);
        }
    }
    
    





    public function store(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'user_id' => 'required',
            'message' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'errors' => $validator->errors()], 400);
        }
        
        $input = $request->all();
        $check = Check::create($input);
        
       
        $directory = storage_path('app/temp');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
    
        $path = $directory . '/' . $check->id . '.txt';
        
        file_put_contents($path, $check->message);
        
        if ($request->has('message')) {
            $check->message = $request->message;
            $check->save();
        }
        sleep(10); 
    
       
        $foundMessage = Check::find($check->id);
        if (!$foundMessage) {
            return response()->json(['error' => 'Message not found'], 404);
        }
    
        $status = $foundMessage->status;
        $result = ($status == 0) ? 'not_recognized' : $foundMessage->result;
    
        return response()->json([
            'message' => 'Message stored and detected successfully',
            'data' => [
                'message' => $foundMessage->message,
                'result' => $result,
                'status' => $status,
            ],
        ], 200);
    }
    

public function showResults()
{   $user = Auth::user();
    $results = Check::where('user_id', auth()->id())->get();
    return response()->json([
        'status' => 1,
        'results' => $results,
    ], 200);
}


public function destroymessage(Request $request)
{
    if (Auth::user()->role != 1) {
        abort(403);
    }

    $id = $request->id;
    $check = Check::find($id);

    if ($check) {
        $check->delete();
        
        return response()->json([
            'status' => 1,
            'message' => 'Message successfully deleted',
        ], 200);
    } else {
        return response()->json([
            'status' => -1,
            'message' => 'Message not found',
        ], 404);
    }
}



public function showMessage($id)
{
    
    $check = Check::find($id);

    
    if (!$check) {
        return response()->json([
            'status' => -1,
            'message' => 'Message not found',
        ], 404);
    }

    
    return response()->json([
        'status' => 1,
        'message' => 'Message found successfully',
        'data' => [
            'id' => $check->id,
            'user_id' => $check->user_id,
            'message' => $check->message,
            'result' => $check->result,
            'status' => $check->status,
            'created_at' => $check->created_at,
            'updated_at' => $check->updated_at,
        ]
    ], 200);
}

}


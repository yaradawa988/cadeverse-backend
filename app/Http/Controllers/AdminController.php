<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Auth;
class AdminController extends Controller
{
    

    function profile(Request $request) {
        $user = Auth::user();

        if ($request->expectsJson()) {
            return new UserResource($user);
        } else {
            return view('profile' , ['user' => $user ]);        
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
       
    
        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'l_name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'image' => ['nullable', 'image'],
            'university' => ['string'],
            
            
        ]);
        
    
        $user->name = $request->name ?? $user->name;
        $user->l_name = $request->l_name ?? $user->l_name;
        $user->email = $request->email ?? $user->email;
    
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        
    
        if ($request->hasFile('image')) {
            if (Storage::exists("public/" . $user->image) && $user->image != "images/avatars/default-avatar.png") {
                Storage::delete("public/" . $user->image);
            }
            $user->image = Storage::disk('public')->put('/images/avatars', $request->file('image'));
        }
     

        


    
        $user->university = $request->university ?? $user->university;
        
    
        $user->save();
    
        if ($request->expectsJson()) {
            return new UserResource($user);
        } else {
            return redirect()->route('home')->with('message', 'Profile updated successfully!');
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->role == 1){
            abort(403);
          }
        if ($request->expectsJson()) {
            return UserResource::collection(
                User::all()
            );
        } else {
            return view('users' , ['users' => User::all() ]);
        }
    }
    

/**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(!Auth::user()->role == 1){
            abort(403);
          }
        
        return view('profile' , ['user' => $user ]);        
    }
      /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , User $user)
    {
        if(!Auth::user()->role == 1){
            abort(403);
          }
        
        if(Storage::exists("public/".$user->image)and ($user->image!='images/avatars/default-avatar.png')){
            Storage::delete("public/".$user->image);
        }
        $user->delete();
    
        if ($request->expectsJson()) {
            return response('', 204);
        } else {
            return redirect()->route('home')
            ->with('message', 'User Deleted successfully!');
        }
    }
}

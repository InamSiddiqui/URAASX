<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Attachment;
use App\Models\Document;
use Auth;
use Validator;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): Response
    {
        $user = $request->user() ? $request->user() : [];
        $documents = !empty($user) ? $user->documents : [];
        // echo '<pre>'; print_r($documents); exit;
        return Inertia::render('Profile/Edit', [
            'user'=>$user,
            'documents'=>$documents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
        ]);

        if($validator->fails())
            return redirect()->route('profile.edit')->with('errorModal', $validator->errors());

        $user = $user->update([
            'name' => $request->fname.' '.$request->lname,
            'fname' => $request->fname,
            'lname' => $request->lname,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');

    }

    public function changePhoto(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'photo'=>'required|image|mimes:jpg,jpeg,png|max:1024',
            ]);
            // echo 'photo <pre>'; print_r($request->photo); 

            if($validator->fails())
                return redirect()->route('profile.edit')->with('error', $validator->errors());


            $imagePath = '/uploads/';
            $imageName = time().'_'.$request->photo->getClientOriginalName();
            // echo $imagePath.$imageName; exit;
            if($request->photo->move(public_path($imagePath), $imageName)){
                $user = Auth::user();
                $user->photo = $imagePath.$imageName;
                $user->save();
            }

            return redirect()->route('profile.edit')->with('success', 'Photo updated!');

        }catch(Throwable $e){
            return redirect()->route('profile.edit')->with('error', $e->getMessage());
        }

    }
}

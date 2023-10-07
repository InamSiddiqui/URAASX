<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Attachment;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::latest()->paginate(20);
        return Inertia::render('Admin/User/index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if(empty($user))
            return redirect()->back()->with('error', 'User not found!');

        $documents = !empty($user) ? $user->documents : [];
        return Inertia::render('Admin/User/view', [
            'user'=>$user,
            'documents'=>$documents,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changestatus(User $user, Request $request)
    {
        $user->status = $request->status;
        $user->status_updated_at = Carbon::now();
        $user->save();

        return redirect()->route('admin.user.view', ['user'=>$user->id])->with('success', 'User profile has been '.$request->status.' successfully!');
    }
}

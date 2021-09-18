<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showCollectionAsResponse(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->only(['name', 'email']);
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('public/profiles');
            $user->avatar()->create(['url' => $path]);
        }
        return $this->showModelAsResponse($user->load('avatar'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showModelAsResponse($user->load('avatar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email']));
        if ($request->hasFile('avatar')) {
            if ($user->has('avatar')) {
                Storage::delete($user->avatar()->url);
            }
            $path = $request->file('avatar')->store('public/profiles');
            $user->avatar()->create(['url' => $path]);
        }
        return $this->showModelAsResponse($user->load('avatar'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->has('avatar')) {
            Storage::delete($user->avatar()->url);
        }
        $user->delete();
        return $this->showModelAsResponse($user);
    }
}

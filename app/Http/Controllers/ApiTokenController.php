<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateApiTokenRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    public function store(GenerateApiTokenRequest $request): RedirectResponse
    {
        session()->flash('flash', $request->user()->createToken($request->validated('token_name'))->plainTextToken);

        return to_route('profile.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->user()->tokens()->where('id', $request->token_id)->delete();

        return to_route('profile.edit');
    }
}

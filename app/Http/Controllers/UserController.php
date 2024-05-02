<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permissions\Models\Role;

class UserController extends Controller
{
    public function showComments(User $user)
    {
        $comments = $user->comments()->paginate(10);

        return view('comments', compact('user', 'comments'));
    }
}

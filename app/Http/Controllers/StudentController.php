<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->is_admin, 403);

        $students = User::query()
            ->where('is_admin', false)
            ->orderBy('name')
            ->paginate(15);

        return view('students.index', compact('students'));
    }
}
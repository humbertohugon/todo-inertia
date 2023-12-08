<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Enums\TodoStatus;
use Illuminate\Http\Request;

class TodoIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia()->render('Todo/Index', [
            'todos' => Todo::where('status', TodoStatus::TODO->value)->latest()->get(),
            'done_todos' => Todo::where('status', TodoStatus::DONE->value)->latest()->get()
        ]);
    }
}

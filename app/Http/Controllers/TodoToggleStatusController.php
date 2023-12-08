<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoToggleStatusController extends Controller
{
    public function __invoke(Request $request, Todo $todo)
    {
        $todo->update(['status' => !$todo->status]);

        return back();
    }
}

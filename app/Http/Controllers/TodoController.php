<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $validatedData = $request->validated();

        $todo = new Todo();
        $todo->title = $validatedData['title'];
        $todo->status = $validatedData['status'];
        $todo->column_type = $validatedData['column_type']; // Tipo de coluna (todo ou done)

        // Definir o order como o próximo número sequencial dentro do tipo de coluna
        $todo->order = Todo::where('column_type', $validatedData['column_type'])->count() + 1;

        $todo->save();

        return response()->json($todo, 201);
    }


    // Outros métodos do controlador não foram alterados para a nova coluna 'order'
}

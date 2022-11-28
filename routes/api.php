<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/tasks", function () {
    return \App\Models\Task::all();
});

Route::get('/tasks/{id}', function ($id) {
    $task = \App\Models\Task::find($id);

    if ($task) {
        return $task;
    }

    return response("Task not found", 404);
});

Route::put('/tasks/{taskId}', function ($taskId) {
    $task = \App\Models\Task::find($taskId);

    $formData = request()->only(['title', 'content', 'done', 'priority']);

    request()->validate([
        'title'    => 'required',
        'content'  => 'required',
        'done'     => 'required',
        'priority' => 'required'
    ]);

    $task->update($formData);
});

Route::post('/tasks', function () {
    request()->validate([
        'title'    => 'required',
        'content'  => 'required',
        'done'     => 'required',
        'priority' => 'required'
    ]);

    $data = request()->all();

    return \App\Models\Task::create($data);

});

Route::delete('/tasks/{taskId}', function ($taskId) {
    $task = \App\Models\Task::find($taskId);

    if(!$task) {
        return response("Not found", 404);
    }

    $task->delete();
});

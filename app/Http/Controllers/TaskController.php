<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(User::taskList(), 200);
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
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
        try {
            DB::beginTransaction();

            
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'due_date' => 'sometimes|date',
            'status' => ['required', Rule::in(TaskStatus::getValues())]
        ]);
    
        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'] ?? null,
            'status' => $validatedData['status'] ?? 'pending',
        ]);

            DB::commit();
            return response()->json(Task::showTask($task->id), 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['message' => $ex->getMessage()], 422);
        }
    
        return response()->json($task, 201);
    }

    /**
     * AssignStore a newly created resource in storage.
     */
    public function assignStore(Request $request)
    {
        try {
            DB::beginTransaction();

            
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'due_date' => 'sometimes|date',
            'status' => ['required', Rule::in(TaskStatus::getValues())]
        ]);
    
        $task = Task::create([
            'user_id' => $validatedData['user_id'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'] ?? null,
            'status' => $validatedData['status'] ?? 'pending',
        ]);

            DB::commit();
            return response()->json(Task::showTask($task->id), 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['message' => $ex->getMessage()], 422);
        }
    
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $task = Task::find($id);
            if (!$task) {
                return response()->json(['message' => "The task is not found"], 404);
            }

            if($task->user_id !== Auth::user()->id){
                return response()->json(['message' => "Only the owner of the task can change the status"], 404);
            }

            $validatedData = $request->validate([
                'status' => ['required', Rule::in(TaskStatus::getValues())]
            ]);

            $task->update($validatedData);

            DB::commit();
            return response()->json(Task::showTask($task->id), 200);
            
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['message' => $ex->getMessage()], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $task = Task::find($id);
            if (!$task) {
                return response()->json(['message' => "The task is not found"], 404);
            }

            $validatedData = $request->validate([
                'title' => 'sometimes|max:255',
                'description' => 'sometimes',
                'due_date' => 'sometimes|date',
            ]);

            $task->update($validatedData);

            DB::commit();
            return response()->json(Task::showTask($task->id), 200);
            
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['message' => $ex->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $task = Task::find($id);
            if (!$task) {
                return response()->json(['message' => "The task is not found"], 404);
            }

            $task->delete();

            DB::commit();
            return response(null, 200);

        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }
}

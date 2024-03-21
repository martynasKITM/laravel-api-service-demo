<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\TaskCollection;
use Auth;


class TodoController extends Controller
{
    /**
     * Default endpoint.
     */
    public function index()
    {
        return response()->json(['version' =>'TODO API service v 0.1'],200);
    }


    /**
     *Create a task
     */
    public function addTask(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:255',
            'description'=>'required|max:255'
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }

        Todo::create([
            'title'=>request('title'),
            'description'=>request('description'),
            'status'=>0,
            'user_id'=>Auth::user()->id
        ]);

        return response()->json(['sucess'=>'Task created'],201);


    }

    /**
     * Display the specified resource.
     */
    public function allTasks(Todo $todo)
    {
        return TaskCollection::collection(Todo::paginate(3));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Todo::find($id);
        $task->update($request->all());
        return response()->json(['success'=>'Task updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Todo::find($id);
        $task->delete();
        return response()->json(['message'=>'Task deleted'],200);
    }

    public function setComplete($id)
    {
        $task = Todo::findOrFail($id);
        $task->status= 1;
        $task->save();
        return response()->json(['success'=>'Task marked as complete'],200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search');

        $query = Task::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($filter === 'active') {
            $query->where('is_completed', false);
        } elseif ($filter === 'completed') {
            $query->where('is_completed', true);
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        return view('index', compact('tasks', 'filter', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['title' => 'required|max:255']);
        Task::create($request->only('title', 'description'));

        return redirect()->route('tasks.index');
    }

    public function update(Request $request, Task $task): View
    {
        $request->validate(['title' => 'required|max:255']);

        $task->update($request->only('title', 'description'));

        $query = Task::query();
        $tasks = $query->orderBy('created_at', 'desc')->get();
        return view('index', compact('tasks'));
    }

    public function create():View
    {
        return view('open');
    }

    public function edit(Task $task):View
    {
        return view('edit', compact('task'));
    }

    public function toggle(Task $task): RedirectResponse
    {
        $task->toggle();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }
}


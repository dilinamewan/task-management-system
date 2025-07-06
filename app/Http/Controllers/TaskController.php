<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use League\Csv\Writer;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Use select to only fetch needed columns and optimize with indexes
        $query = Task::select(['id', 'title', 'description', 'status', 'priority', 'due_date', 'user_id', 'created_at', 'updated_at'])
                    ->with(['user:id,name,email']) // Only select needed user fields
                    ->when($user->isUser(), function ($q) use ($user) {
                        return $q->where('user_id', $user->id);
                    });
        
        // Optimized search with full-text search for better performance
        if ($request->filled('search')) {
            $search = $request->search;
            // Use full-text search if available, fallback to LIKE
            if (config('database.default') === 'mysql') {
                $query->whereRaw("MATCH(title, description) AGAINST(? IN BOOLEAN MODE)", [$search]);
            } else {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
        }
        
        // Filter by status with index usage
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Optimize ordering to use index
        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'due_date' => 'nullable|date|after_or_equal:today',
        ];
        
        // Add user_id validation for admins
        if ($user->isAdmin()) {
            $validationRules['user_id'] = 'required|exists:users,id';
        }
        
        $request->validate($validationRules);
        
        $taskData = [
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status ?? 'pending',
            'due_date' => $request->due_date,
            'user_id' => $user->isAdmin() ? $request->user_id : $user->id,
        ];

        Task::create($taskData);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $users = User::orderBy('name')->get();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $user = auth()->user();
        
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ];
        
        // Add user_id validation for admins
        if ($user->isAdmin()) {
            $validationRules['user_id'] = 'required|exists:users,id';
        }
        
        $request->validate($validationRules);
        
        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ];
        
        // Only update user_id if admin
        if ($user->isAdmin()) {
            $updateData['user_id'] = $request->user_id;
        }

        $task->update($updateData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function duplicate(Task $task)
    {
        // Check if user can view the original task (for authorization)
        $this->authorize('view', $task);
        
        // Create a duplicate task
        $duplicatedTask = Task::create([
            'title' => 'Copy of ' . $task->title,
            'description' => $task->description,
            'status' => 'pending', // Reset status to pending
            'priority' => $task->priority,
            'due_date' => $task->due_date,
            'user_id' => auth()->id(), // Assign to current user
        ]);
        
        return redirect()->route('tasks.show', $duplicatedTask)
                        ->with('success', 'Task duplicated successfully!');
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        
        // Optimize export query with select and chunk processing
        $query = Task::select(['id', 'title', 'description', 'status', 'priority', 'due_date', 'user_id', 'created_at', 'updated_at'])
                    ->with(['user:id,name'])
                    ->when($user->isUser(), function ($q) use ($user) {
                        return $q->where('user_id', $user->id);
                    });
        
        // Apply the same filters as the index method
        if ($request->filled('search')) {
            $search = $request->search;
            if (config('database.default') === 'mysql') {
                $query->whereRaw("MATCH(title, description) AGAINST(? IN BOOLEAN MODE)", [$search]);
            } else {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Create CSV with memory-efficient chunking
        $csv = Writer::createFromString();
        
        // Add headers
        $csv->insertOne([
            'ID',
            'Title',
            'Description',
            'Status',
            'Priority',
            'Due Date',
            'Assigned To',
            'Created At',
            'Updated At'
        ]);
        
        // Process in chunks to handle large datasets efficiently
        $query->orderBy('created_at', 'desc')->chunk(1000, function ($tasks) use ($csv) {
            foreach ($tasks as $task) {
                $csv->insertOne([
                    $task->id,
                    $task->title,
                    $task->description,
                    ucfirst(str_replace('_', ' ', $task->status)),
                    ucfirst($task->priority),
                    $task->due_date ?: '',
                    $task->user->name,
                    $task->created_at->format('Y-m-d H:i:s'),
                    $task->updated_at->format('Y-m-d H:i:s')
                ]);
            }
        });
        
        $filename = 'tasks_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        return Response::make($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
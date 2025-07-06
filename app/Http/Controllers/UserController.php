<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\Csv\Writer;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('tasks');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        $tasks = $user->tasks()->latest()->paginate(10);
        return view('admin.users.show', compact('user', 'tasks'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function export(Request $request)
    {
        $query = User::where('role', 'user');
        
        // Apply the same search filter as the index method
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->withCount('tasks')->get();
        
        // Create CSV
        $csv = Writer::createFromString();
        
        // Add headers
        $csv->insertOne([
            'ID',
            'Name',
            'Email',
            'Role',
            'Total Tasks',
            'Created At',
            'Email Verified At'
        ]);
        
        // Add data
        foreach ($users as $user) {
            $csv->insertOne([
                $user->id,
                $user->name,
                $user->email,
                ucfirst($user->role),
                $user->tasks_count,
                $user->created_at->format('Y-m-d H:i:s'),
                $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'Not verified'
            ]);
        }
        
        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        return Response::make($csv->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
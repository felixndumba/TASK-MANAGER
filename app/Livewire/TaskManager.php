<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskManager extends Component
{

    public string $newTask = '';
    public $dueDate = '';
   

    public function mount(): void
    {
        $this->loadTasks();
    }

    public function addTask(): void
    {
        $this->validate([
        'newTask' => 'required|string|min:3',
        'dueDate' => 'nullable|date',
    ]);
   

    Task::create([
        'title' => $this->newTask,
        'user_id' => Auth::id(),
        'due_date' => $this->dueDate, // 🔐 associate with user
    ]);

    $this->newTask = '';
    $this->loadTasks();
     $this->dueDate = '';
    }

    public function toggleTask(int $taskId): void
    {
        $task = Task::find($taskId);
        $task->is_completed = !$task->is_completed;
        $task->save();

        $this->loadTasks();
    }

    public function removeTask(int $taskId): void
    {
        Task::destroy($taskId);
        $this->loadTasks();
    }

    public function loadTasks(): void
    {
      
        
    }

    public function render()
    {
          $tasks = Task::where('user_id', auth()->id())->latest()->get(); // ✅ Eloquent objects
    return view('livewire.task-manager', compact('tasks'));
    }
}


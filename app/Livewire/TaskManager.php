<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskManager extends Component
{
    public string $newTask = '';
    public $dueDate = '';
    public $priority = 'medium';

    public function addTask(): void
    {
        $this->validate([
            'newTask' => 'required|string|min:3',
            'dueDate' => 'nullable|date',
            'priority' => 'required|string|in:high,medium,low',
        ]);

        Task::create([
            'title' => $this->newTask,
            'user_id' => Auth::id(),
            'due_date' => $this->dueDate,
            'priority' => $this->priority,
        ]);


        // Reset inputs
        $this->newTask = '';
        $this->dueDate = '';
        $this->priority = 'medium';
    }

    public function toggleTask(int $taskId): void
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($taskId);
        $task->is_completed = !$task->is_completed;
        $task->save();
    }

    public function removeTask(int $taskId): void
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($taskId);
        $task->delete();
    }

    public function render()
    {
        $tasks = Task::where('user_id', Auth::id())->latest()->get();
        return view('livewire.task-manager', compact('tasks'));
    }
}

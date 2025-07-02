<div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Task Manager</h2>

<div class="flex items-center gap-2 mb-4">
    <input type="text" wire:model="newTask" placeholder="Enter new task"
           class="flex-1 p-2 border rounded" />
    <input type="date" wire:model="dueDate" class="p-2 border rounded" />
    <button wire:click="addTask" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
        Add
    </button>
</div>


    <ul class="space-y-2">
    @foreach ($tasks as $task)
        <li class="flex justify-between items-center p-2 bg-black rounded">
            <div>
                <input type="checkbox" wire:click="toggleTask({{ $task->id }})" {{ $task->is_completed ? 'checked' : '' }}>
                <span class="{{ $task->is_completed ? 'line-through text-white' : '' }}">
                    {{ $task->title }}
                </span>
                @if ($task->due_date)
                    <span class=" text-white ml-2">
                        (Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }})
                    </span>
                @endif
            </div>
            <button wire:click="removeTask({{ $task->id }})"
                    class="text-red-500 hover:text-red-700 text-sm">Delete</button>
        </li>
    @endforeach
</ul>

</div>

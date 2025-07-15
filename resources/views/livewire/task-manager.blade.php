<div class=" mx-auto p-6 bg-white rounded-lg space-y-6">

    <!-- Add New Task -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">+ Add New Task</h2>

        <div class="space-y-4">

            <!-- Task Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Task Title</label>
                <input type="text" wire:model="newTask" placeholder="Enter task title"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <!-- Due Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                <div class="relative">
                    <input type="date" wire:model="dueDate"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 text-sm">
                    <div class="absolute left-3 top-2.5 text-gray-400 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3M16 7V3M4 11h16M5 19h14a2 2 0 002-2V7H3v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Optional: Priority (not stored unless you add it to model/controller) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                <select wire:model="priority" class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm">
                    <option value="high">High</option>
                    <option value="medium" selected>Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>

            <!-- Optional: Description (only if supported in DB and Livewire) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea wire:model="description" placeholder="Task description" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></textarea>
            </div>

            <!-- Submit Button -->
            <div>
                <button wire:click="addTask"
                        class="w-full bg-[#0b1228] text-white py-3 rounded-md text-base font-semibold hover:bg-[#151d3b]">
                    Add Task
                </button>
            </div>
        </div>
    </div>

    <!-- Task List -->
    <div class="pt-4">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Task List</h3>

        @forelse ($tasks as $task)
            <div class="bg-[#f9fdf9] rounded-lg border shadow-sm p-4 mb-3">
                <div class="flex justify-between items-start">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" wire:click="toggleTask({{ $task->id }})"
                               @if($task->is_completed) checked @endif
                               class="mt-1.5 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">

                        <div>
                            <h4 class="text-md font-semibold text-gray-900 flex items-center gap-2">
                                {{ $task->title }}
                                @if ($task->priority)
                                    <span class="text-xs font-medium px-3 py-0.5 rounded-full capitalize
                                        {{ $task->priority === 'high' ? 'bg-red-500 text-white' : '' }}
                                        {{ $task->priority === 'medium' ? 'bg-yellow-400 text-white' : '' }}
                                        {{ $task->priority === 'low' ? 'bg-green-400 text-white' : '' }}">
                                        {{ $task->priority }}
                                    </span>
                                @endif
                            </h4>

                            @if ($task->description)
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $task->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="text-right space-y-1">
                        <span class="bg-{{ $task->is_completed ? 'green' : 'gray' }}-500 text-white text-xs font-medium px-3 py-0.5 rounded-full">
                            {{ $task->is_completed ? 'Completed' : 'Pending' }}
                        </span>
                        @if ($task->due_date)
                            <div class="text-xs text-gray-500 mt-1">
                                Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                            </div>
                        @endif
                        <button wire:click="removeTask({{ $task->id }})"
                                class="text-red-500 hover:text-red-700 text-xs font-medium mt-2">Delete</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-500 text-sm">No tasks available.</div>
        @endforelse
    </div>

</div>

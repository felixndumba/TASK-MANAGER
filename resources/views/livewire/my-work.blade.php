<div>
    <h2 class="text-xl font-bold mb-4">My Work</h2>

    <div class="mb-4 space-x-2">
        <button wire:click="setFilter('all')" class="px-3 py-1 rounded {{ $filter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">All Tasks</button>
        <button wire:click="setFilter('today')" class="px-3 py-1 rounded {{ $filter === 'today' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">Today</button>
        <button wire:click="setFilter('this_week')" class="px-3 py-1 rounded {{ $filter === 'this_week' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">This Week</button>
        <button wire:click="setFilter('next_week')" class="px-3 py-1 rounded {{ $filter === 'next_week' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">Next Week</button>
        <button wire:click="setFilter('no_date')" class="px-3 py-1 rounded {{ $filter === 'no_date' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">No Date</button>
    </div>

    <div class="space-y-3 max-h-96 overflow-y-auto">
        @forelse ($tasks as $task)
            <div class="p-3 border rounded shadow-sm bg-white">
                <h3 class="font-semibold">{{ $task->title }}</h3>
                @if ($task->description)
                    <p class="text-sm text-gray-600 mt-1"><strong>Remarks:</strong> {{ $task->description }}</p>
                @endif
                @if ($task->due_date)
                    <p class="text-xs text-gray-500 mt-1">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</p>
                @endif
            </div>
        @empty
            <p class="text-gray-500">No tasks found for this filter.</p>
        @endforelse
    </div>
</div>

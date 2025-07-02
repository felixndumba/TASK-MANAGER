<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
          @php
    try {
        $response = \Http::get('https://zenquotes.io/api/today');
        $quote = $response->json()[0]['q'] ?? 'Stay positive!';
        $author = $response->json()[0]['a'] ?? 'Unknown';
    } catch (\Exception $e) {
        $quote = 'Keep going. Everything you need will come to you at the perfect time.';
        $author = 'Fallback Quote';
    }
@endphp

      <div class="relative rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4 shadow">
        <h3 class="text-lg font-semibold mb-2">👤 My Profile</h3>
        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Member since:</strong> {{ Auth::user()->created_at->format('F Y') }}</p>
    </div>

      <div class="relative rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4 shadow">
        <h3 class="text-lg font-semibold mb-2">📊 Task Statistics</h3>
        <p>Total Tasks: {{ \App\Models\Task::where('user_id', Auth::id())->count() }}</p>
        <p>Completed: {{ \App\Models\Task::where('user_id', Auth::id())->where('is_completed', true)->count() }}</p>
        <p>Pending: {{ \App\Models\Task::where('user_id', Auth::id())->where('is_completed', false)->count() }}</p>
</div>

    <!-- Quote of the Day -->
<div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow">
    <h3 class="text-lg font-semibold mb-2">💡 Quote of the Day</h3>
    <p class="italic text-sm">"{{ $quote }}"</p>
    <p class="text-sm text-right mt-1">— {{ $author }}</p>
</div>


        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    @livewire('task-manager')
</div>
    </div>
</x-layouts.app>

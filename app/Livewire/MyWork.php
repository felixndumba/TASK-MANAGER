<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyWork extends Component
{
    public $filter = 'all';

    protected $listeners = ['taskAdded' => '$refresh'];

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function filteredTasks()
    {
        $query = Task::where('user_id', Auth::id());

        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $nextWeekStart = Carbon::now()->addWeek()->startOfWeek(Carbon::MONDAY);
        $nextWeekEnd = Carbon::now()->addWeek()->endOfWeek(Carbon::SUNDAY);

        switch ($this->filter) {
            case 'today':
                $query->whereDate('due_date', $today);
                break;
            case 'this_week':
                $query->whereBetween('due_date', [$startOfWeek, $endOfWeek]);
                break;
            case 'next_week':
                $query->whereDate('due_date', '>=', $nextWeekStart)
                      ->whereDate('due_date', '<=', $nextWeekEnd);
                break;
            case 'no_date':
                $query->where(function($q) {
                    $q->whereNull('due_date')
                      ->orWhere('due_date', '');
                });
                break;
            case 'all':
            default:
                // no filter
                break;
        }

        return $query->orderBy('due_date')->get();
    }

    public function render()
    {
        return view('livewire.my-work', [
            'tasks' => $this->filteredTasks(),
        ]);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDueToday;
use Carbon\Carbon;

class NotifyTasksDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:tasks-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications to users for tasks due soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notifyDate = Carbon::today()->addDay(); // One day before the deadline
        $tasksDue = Task::whereDate('due_date', $notifyDate)->get();

        foreach ($tasksDue as $task) {
            $user = $task->user;
            if ($user) {
                $user->notify(new TaskDueToday($task));
                $this->info('Notification sent for task ID ' . $task->id . ' to user ' . $user->email);
            }
        }

        return 0;
    }
}

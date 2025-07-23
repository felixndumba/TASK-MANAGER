<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskDueToday extends Notification
{
    use Queueable;
  
    /**
     * Create a new notification instance.
     */
protected $task;

/**
 * Create a new notification instance.
 */
public function __construct(Task $task)
{
    $this->task = $task;
}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
public function toMail(object $notifiable): MailMessage
{
    $title = $this->task->title ?? 'your task';
    if ($this->task->due_date instanceof \Illuminate\Support\Carbon || $this->task->due_date instanceof \DateTimeInterface) {
        $dueDate = $this->task->due_date->format('F j, Y');
    } else {
        $dueDate = date('F j, Y', strtotime((string) $this->task->due_date));
    }
    $taskId = $this->task->id ?? '';
    $userName = $this->task->user ? $this->task->user->name : 'User';

    return (new MailMessage)
        ->subject('Task Due Reminder')
        ->greeting('Hello ' . $userName . ',')
        ->line('This is a reminder that your task "' . $title . '" is due on ' . $dueDate . '.')
        ->line('Please make sure to complete it on time.')
        ->action('View Task', url('/tasks/' . $taskId))
        ->line('Thank you for using our application!');
}

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

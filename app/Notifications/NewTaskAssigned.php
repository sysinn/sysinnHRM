<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\EmployeeDailyTask;

class NewTaskAssigned extends Notification
{
    use Queueable;

    protected $task;

    public function __construct(EmployeeDailyTask $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database']; // you can also add 'mail' if you want email notifications
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'task_subject' => $this->task->task_subject,
            'assigned_by' => $this->task->assignedBy?->name ?? 'Admin',
            'message' => 'A new task has been assigned to you: ' . $this->task->task_subject,
            'task_date' => $this->task->task_date,
        ];
    }
}

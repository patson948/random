<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user,
        public array $changes
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Profile Updated Successfully')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your profile has been updated successfully.');

        if (!empty($this->changes)) {
            $message->line('The following changes were made:');
            foreach ($this->changes as $field => $value) {
                $message->line('• ' . ucfirst(str_replace('_', ' ', $field)) . ': ' . $value);
            }
        }

        $message->action('View Profile', url('/profile'))
            ->line('If you did not make these changes, please contact our support team immediately.')
            ->salutation('Best regards, The ShopHub Team');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'changes' => $this->changes,
            'updated_at' => now(),
        ];
    }
}


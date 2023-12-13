<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        // Check if user is a newly added user
        if (now()->diffInMinutes($notifiable->created_at) < 10) {
            return (new MailMessage)
                        ->subject('Successful Account Creation')
                        ->line('You are receiving because your account has been created successfully on Real African Sources.')
                        ->line('Follow the link below to reset your password and login.')
                        ->action('Reset Password', url('password-reset', $this->token));
        }

        return (new MailMessage)
                    ->line('Hello')
                    ->line('You are receiving this email because a password reset request was made.')
                    ->line('Click below to proceed to reset your password and login.')
                    ->action('Reset Password', url('password-reset', $this->token))
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

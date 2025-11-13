<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class VerifyMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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

    #TODO personnaliser le mail
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
         //$url = url('/invoice/' . $this->invoice->id);
       $url = URL::temporarySignedRoute(
            'verify.email',                // nom de la route
            Carbon::now()->addMinutes(60), // expiration
            ['id' => $notifiable->id]        // paramètre
        );
         $frontendUrl = 'http://localhost:5174/validation-email?' . parse_url($url, PHP_URL_QUERY);
        \Log::info('Frontend URL: ' . $frontendUrl);
        return (new MailMessage)
            ->from('barrett@example.com', 'Le garagiste')
            ->greeting("Bonjour " . $notifiable->name)
            ->line('Votre rendez vous à été pris.')
            //->lineIf($this->amount > 0, "Amount paid: {$this->amount}")
            ->action('verifier mon e-mail', $frontendUrl)
            ->line('penser a regarder les spam')
            ->salutation("Cordialement,\n Le garagiste ");
    }


    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Votre rendez-vous a été pris.',
            'user_email' => $notifiable->email,
            'greeting' => 'Bonjour ' . $notifiable->name,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
}

<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\Cars;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ConfirmationAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $cars, $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Cars $cars, Appointment $appointment) {
        $this->user = $user;
        $this->cars = $cars;
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation Appointment Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

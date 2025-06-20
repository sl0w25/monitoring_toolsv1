<?php

namespace App\Mail;

use App\Models\Beneficiary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BeneficiaryAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $beneficiary;
    public $pdfAttachment;


    public function __construct(Beneficiary $beneficiary, $pdfAttachment = null)
    {
        $this->beneficiary = $beneficiary;
        $this->pdfAttachment = $pdfAttachment;
    }


    public function build()
    {
        $mail = $this->subject('Beneficiary Assigned')
                     ->view('emails.beneficiary-assigned');

        if ($this->pdfAttachment) {
            $mail->attachData($this->pdfAttachment, 'qr_codes.pdf', [
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bagong Pilipinas Job Fair QR Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'filament.emails.beneficiary-assigned',
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

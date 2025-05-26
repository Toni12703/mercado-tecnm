<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VentaValidadaVendedor extends Mailable
{
    use Queueable, SerializesModels;

    public $venta;


    public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Tu producto ha sido vendido')
                    ->markdown('emails.venta.validada_vendedor');
    }

     public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Venta Validada Vendedor',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.venta.validada_vendedor',
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

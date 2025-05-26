<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VentaValidadaComprador extends Mailable
{
    use Queueable, SerializesModels;

     public $venta;

    public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }

    public function build()
    {
        return $this->subject('Tu compra ha sido validada')
                    ->markdown('emails.venta.validada_comprador');
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Venta Validada Comprador',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.venta.validada_comprador',
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

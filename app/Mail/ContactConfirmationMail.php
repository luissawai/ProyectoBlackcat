<?php
namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContactConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        Log::info('ContactConfirmationMail construido:', [
            'contact_id' => $contact->id,
            'email' => $contact->email
        ]);
    }

    public function build()
    {
        Log::info('Construyendo correo:', [
            'view' => 'emails.contact_confirmation',
            'contact_id' => $this->contact->id
        ]);

        try {
            return $this->subject('Gracias por contactarnos')
                       ->view('emails.contact_confirmation');
        } catch (\Exception $e) {
            Log::error('Error al construir el correo:', [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
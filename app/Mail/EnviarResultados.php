<?php

namespace App\Mail;

use App\Models\Archivos;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class EnviarResultados extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $archivos;
    public $ruta;

    /**
     * Create a new message instance.
     */
    public function __construct($env_id, $user_id)
    {
        $user = User::find($user_id);
        $this->name = $user->name;
        $this->ruta = route('consultar', $user->documento);
        // $this->archivos = Archivos::where('env_id', $env_id)->get();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'RESULTADOS - ' . $this->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.Resultados',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        /*
        $attachments = [];
        foreach ($this->archivos as $doc) {
            $ext = pathinfo($doc->arc_file, PATHINFO_EXTENSION);
            $name = $doc->arc_nombre . '.' . $ext;
            $filePath = storage_path('app/public/archivos/' . $doc->arc_file);
            if (file_exists($filePath)) {
                $attachments[] = Attachment::fromPath($filePath)
                    ->as($name)
                    ->withMime(mime_content_type($filePath));
            }
        }
        return $attachments;

        */
        return [];
    }
}

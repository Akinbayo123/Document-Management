<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Document;

class DocumentStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Document $document, $user)
    {
        $this->document = $document;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.documents.status_updated')
            ->with([
                'documentTitle' => $this->document->title,
                'documentStatus' => $this->document->status,
                'userName' => $this->user->name,
            ]);
    }
}

<?php

namespace App\Listeners;

use App\Models\AdminNotification;

class CreateNewContactNotification
{
    public function handle(object $event): void
    {
        $contact = $event->contact;

        AdminNotification::create([
            'type' => 'new_contact',
            'title' => "New Message from {$contact->name}",
            'message' => "Subject: {$contact->subject}",
            'link' => route('admin.contacts.show', $contact),
            'notifiable_id' => $contact->id,
            'is_read' => false,
        ]);
    }
}

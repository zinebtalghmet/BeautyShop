<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\ContactSubmitted;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validated);

        try {
            event(new ContactSubmitted($contact));
        } catch (\Throwable $e) {
            // log silently
        }

        return response()->json([
            'message' => 'Your message has been sent. We will get back to you soon.',
        ], 201);
    }
}

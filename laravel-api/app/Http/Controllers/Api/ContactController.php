<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $contacts = Contact::all();
            return response()->json($contacts);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch contacts',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);



        try {
            $existingContact = Contact::where('email', $validated['email'])->first();
            if ($existingContact) {
                return response()->json([
                    'message' => 'Failed to create contact. Contact with this email already exists.',
                ], 400);
            }

            $contact = Contact::create($validated);
            return response()->json([
                'message' => 'Contact created successfully',
                'contact' => $contact,
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create contact',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return response()->json($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            // Check if contact with the same email already exists
            $existingContact = Contact::where('email', $validated['email'])->where('id', '<>', $contact->id)->first();
            if ($existingContact) {
                return response()->json([
                    'message' => 'Failed to update contact. Contact with this email already exists.',
                ], 400);
            }

            $contact->update($validated);
            return response()->json([
                'message' => 'Contact updated successfully',
                'contact' => $contact,
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to update contact',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return response()->json(null, 204);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to delete contact',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class ReservationController extends Controller
{
    public function index()
    {
        try {
            $reservations = Reservation::with('contact')->get();
            return response()->json($reservations);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch reservations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $existingContact = Contact::where('id', $validated['contact_id'])
                ->first();
            if (!$existingContact) {
                return response()->json([
                    'message' => 'Failed to create reservation. this contact id does not exist',
                ], 400);
            }
            // Check if reservation already exists for the same date and time
            $existingReservation = Reservation::where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->first();
            if ($existingReservation) {
                return response()->json([
                    'message' => 'Failed to create reservation. Reservation already exists for this date and time.',
                ], 400);
            }

            $reservation = Reservation::create($validated);
            return response()->json([
                'message' => 'Reservation created successfully',
                'reservation' => $reservation,
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create reservation',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Reservation $reservation)
    {
        return $reservation->load('contact');
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'contact_id' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $existingContact = Contact::where('id', $validated['contact_id'])
                ->first();
            if (!$existingContact) {
                return response()->json([
                    'message' => 'Failed to create reservation. this contact id does not exist',
                ], 400);
            }

            $existingReservation = Reservation::where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->where('id', '<>', $reservation->id)
                ->first();
            if ($existingReservation) {
                return response()->json([
                    'message' => 'Failed to update reservation. Reservation already exists for this date and time.',
                ], 400);
            }

            $reservation->update($validated);
            return response()->json([
                'message' => 'Reservation updated successfully',
                'reservation' => $reservation,
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to update reservation',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();
            return response()->json(null, 204);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to delete reservation',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

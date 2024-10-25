<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class SessionController extends Controller
{
    public function index()
    {


        return view('session');


    }

    public function submit(Request $request)
    {

        // Check if the 'ref' exists in the client table
        $client = Client::where('reference', $request->input('ref'))
            ->where('session_number', '>', 0)
            ->first();


        if (!$client) {
            // 'ref' does not exist in the client table
            return response()->json(['error' => 'Réference inexistante ou aucune séance disponible. Veuillez réessayer.'], 400);
        }
        if ($client->session_number == 0) {
            // 'ref' does not exist in the client table
            return response()->json(['error' => 'Aucune séance disponible. Veuillez renouvelez votre abonnement.'], 400);
        }
        $today = Carbon::today('Africa/Algiers')->toDateString();
        $booking = Booking::where('client_id', $client->id)
            ->whereDate('reservation_date', '=', $today)
            ->first();

        if (!$booking) {
            // No booking found for today
            return response()->json(['error' => 'Client ne dispose pas de créneau maintenant.'], 400);
        }
        // Check if the current time is between reservation_time and reservation_time_end
        $currentTime = Carbon::now('Africa/Algiers');
        $bookingStartTime = Carbon::parse($booking->reservation_time, 'Africa/Algiers')->subMinutes(30);
        $bookingEndTime = Carbon::parse($booking->reservation_time_end, 'Africa/Algiers');

        if (!$currentTime->between($bookingStartTime, $bookingEndTime)) {
            return response()->json(['error' => 'client ne dipose pas de créneau maintenant'], 400);
        }
        $client->session_number = $client->session_number - 1;
        $client->save();
        $bookingDate = $currentTime->toDateString();

        Session::create([
            'team_name' => $client->team_name,
            'reservation_date' => $bookingDate,
            'reference' => $client->reference,

        ]);

        // Return a success response
        return response()->json([
            'message' => "Créneau valide. Nombre de séances restantes : $client->session_number"
        ]);

    }

    public function getSessions(Request $request)
{
    if ($request->ajax()) {
        $query = Session::query();

        // Date Filtering
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $startDate = Carbon::parse($request->input('startDate'))->startOfDay();
            $endDate = Carbon::parse($request->input('endDate'))->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $sessions = $query->get();

        return Datatables::of($sessions)
            ->addIndexColumn()
            ->make(true);
    }
}

}

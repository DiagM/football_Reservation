<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Fund;
use App\Models\Stadium;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
{
    $subscriptions = Subscription::all();
   return view('booking',compact('subscriptions'));
}

public function submit(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'team_name' => 'required|string|max:2000',
            'ref' => 'required|string|max:2000',
            'phone_number' => 'required|string|max:255',
            'subscription_id'=>'required',

        ]);
$id=$request->subscription_id;
$subscription = Subscription::with('stadium')->find($id);
$user = auth()->user();



// Iterate through the arrays to process each date and time
for ($i = 0; $i < $subscription->subscriptionFrequency; $i++) {
// Validate the date and time inputs

    $reservationDate = $request->input("reservation_date_$i");
    $reservationTime = $request->input("reservation_time_$i");
    $reservationTimeEnd = $request->input("reservation_time_end_$i");

    // Check if any of the date or time values are empty
    if (empty($reservationDate) || empty($reservationTime) || empty($reservationTimeEnd)) {
        return redirect()->back()->withErrors(['message' => 'Veuillez remplir tous les champs de date et heure.']);
    }

   // Parse the reservation_date and reservation_time values for each iteration
$reservationDate = Carbon::createFromFormat('Y-m-d', $request->input("reservation_date_$i"));
$reservationTime = Carbon::createFromFormat('H:i', $request->input("reservation_time_$i"));
$reservationTimeEnd = Carbon::createFromFormat('H:i', $request->input("reservation_time_end_$i"));
// Check if end time is before start time
if ($reservationTimeEnd < $reservationTime) {
    return redirect()->back()->withErrors(['message' => 'L\'heure de fin de réservation ne peut pas être avant l\'heure de début.']);
}
// Combine date and time into a single DateTime object
$reservationDateTime = $reservationDate->setTime($reservationTime->hour, $reservationTime->minute);

// Create a new Carbon instance for $reservationDateTimeEnd
$reservationDateTimeEnd = $reservationDate->copy()->setTime($reservationTimeEnd->hour, $reservationTimeEnd->minute);


    // Format the combined DateTime object
    $formattedDateTime = $reservationDateTime->format('Y-m-d H:i');
    $formattedDateTimeEnd = $reservationDateTimeEnd->format('Y-m-d H:i');
    $client = Client::create([
        'team_name' => $validatedData['team_name'],
        'phone_number' => $validatedData['phone_number'],
        'reference' => $validatedData['ref'],
        'price' =>$subscription->price,
        'session_number' =>0,
        'start_subs' =>$request->input("reservation_date_0"),
        'end_subs' =>$request->input("reservation_date_0"),
        'created_by' =>$user->id,
        'edited_by' =>$user->id,
        'subscription_id' => $validatedData['subscription_id'],
        'reservation_confirmed' => $request->has('reservation_confirmed'),
    ]);

    if ($request->has('reservation_confirmed')){
        Fund::create([
            'client_id' => $client->id,
            'payment'=> $request->payment_amount,
            'subscription_name' => $client->subscription->name

            // Add any additional Fund fields as needed
        ]);
    }


    // Create a new booking record in the database for each date and time
    $Booking=Booking::create([

        'reservation_date' => $formattedDateTime, // Store the combined DateTime
        'reservation_date_end' => $formattedDateTimeEnd, // Store the combined DateTime
        'reservation_time' => $request->input("reservation_time_$i"), // Use the selected time directly
        'reservation_time_end' => $request->input("reservation_time_end_$i"), // Use the selected time directly
        'client_id' =>$client->id,
        'stadium_id' =>$subscription->stadium->id

    ]);


            // Additional logic to create multiple bookings for the same day of the week
            $reservationDate = Carbon::parse($formattedDateTime);
            $reservationDateEnd = Carbon::parse($formattedDateTimeEnd);
            $bookingChoice = $subscription->booking_choice;
            $nextDate=$reservationDate;
            $nextDateEnd=$reservationDateEnd;
            for ($j =14 ; $j <= $bookingChoice; $j=$j+7) {
                // Calculate the next date based on the reservation_date

                $nextDate = $nextDate->copy()->addDays(7); // Add 7 days for the same day of the week
                $nextDateEnd = $nextDateEnd->copy()->addDays(7); // Add 7 days for the same day of the week

                // Create a new booking record for the next date
                Booking::create([
                    'reservation_date' => $nextDate,
                    'reservation_date_end' => $nextDateEnd,
                    'reservation_time' => $request->input("reservation_time_$i"),
                    'reservation_time_end' => $request->input("reservation_time_end_$i"),
                    'client_id' =>$client->id,
                    'stadium_id' =>$subscription->stadium->id

                ]);
            }
}
$latestBooking = Booking::latest('reservation_date')->where('client_id', $client->id)
->first();
$clientBookingsCount = Booking::where('client_id', $client->id)->count();
$client->end_subs = $latestBooking->reservation_date_end;
$client->session_number = $clientBookingsCount;

$client->save();



        // Redirect or respond as needed after successful submission
        return redirect()->back()->with('success', 'Bookings submitted successfully!');
    }

    public function fetch_appointments(Request $request)
    {
        // Retrieve data from the request
    $date = $request->input('date');
    $time = $request->input('time');
    $id = $request->subscription_id;
    $subscription = Subscription::find($id);

        // Parse date
        $dateTime = Carbon::parse($date);
        $timee = Carbon::parse($time);
        // Query the database to find the relevant reservation
        $appointments = Booking::whereDate('reservation_date', $dateTime)
            ->where('stadium_id', $subscription->stadium_id)
            ->get();

            foreach ($appointments as $appointment){
// Check if the selected time is between start time and end time
if ($appointment && $timee->between($appointment->reservation_time, $appointment->reservation_time_end)) {
    // Time is valid

    return response()->json(['status' => 'error', 'message' => 'créneau choisie en conflit']);
}
            }

        return response()->json(['status' => 'success', 'message' => 'créneau libre']);

    }


    public function calendar()
    {
        $events = [];

        $appointments = Booking::with('stadium')->get();
        $stadiums = Stadium::all();
        foreach ($appointments as $appointment) {
            $client_id = $appointment->client_id;
            // Retrieve and sum all payment values for the specified client_id
            $totalPayments = Fund::where('client_id', $client_id)->sum('payment');
            $paymentRest = $appointment->client->price - $totalPayments;
            $events[] = [
            'id' => $appointment->id,
            'title' => $appointment->client->team_name,
            'start' => $appointment->reservation_date,
            'end' => $appointment->reservation_date_end,
            'extendedProps' => [
                'phone_number' => $appointment->client->phone_number,
                'reference' => $appointment->client->reference,
                'stadium_choice' => $appointment->stadium->name,
                'stadium_choiceid' => $appointment->stadium->id,
                'price' => $appointment->client->price,
                'payment' => $totalPayments,
                'paymentRest' => $paymentRest,
                'reservation_confirmed' => $appointment->client->reservation_confirmed,
                'session_number' => $appointment->client->session_number,
            ],
            ];
        }
        return view('calendar_basic', compact('events','stadiums'));

    }

    public function delete(Request $request,$id)
    {
    if($request->check == 0){
        $appointment = Booking::find($id);
        $ids=[];
        $ids[] = $appointment->id;
        $appointment->delete();
        return response()->json(['status'=>200,'ids'=>$ids]);

    }else{
        $ids=[];
        $appointment = Booking::find($id);
        $bookings= Booking::where('client_id',$appointment->client_id)->get();
        $client = Client::where('id',$appointment->client_id)->first();
        $client->session_number = 0;
        $client->save();
        foreach($bookings as $booking){
            $ids[] = $booking->id;
            $booking->delete();
        }
        $fund = Fund::where('client_id',$appointment->client_id)->first();
        if ($fund) {
            $fund->delete();
        }
        return response()->json(['status'=>200,'ids'=>$ids]);

    }
    }

    public function update(Request $request, $id)
{
    // Validate the form data
    $validator = Validator::make($request->all(), [
        'BookingTitle' => 'required|string|max:255',
        'Bookingref' => 'required|string|max:255',
        'BookingNum' => 'required|string|max:255',
        'BookingSession' => 'required|numeric',
    ]);

    // If validation fails, return the errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Find the subscription by its ID
    $booking = Booking::with('client')->with('stadium')->find($id);
    $fund = Fund::where('client_id',$booking->client_id)->first();
    $client_id = $booking->client_id;
    // Retrieve and sum all payment values for the specified client_id
    $totalPayments = Fund::where('client_id', $client_id)->sum('payment');
    $paymentRestinput = $request->BookingPayment;
    if (!$booking) {
        return response()->json(['message' => 'Subscription not found'], 404);
    }
    if ($totalPayments + $paymentRestinput > $booking->client->price) {
        return response()->json(['message' => 'total versement superieur a prix abonnement'], 404);
    }
    $clientBookingsCount = Booking::where('client_id', $booking->client_id)->count();
    // Check if BookingSession is greater than clientBookingsCount
    if ($request->input('BookingSession') > $clientBookingsCount) {
        // Return an error response
        return response()->json(['message' => 'nombre de séance restante ne doit pas dépasser nombre total de séance'], 422);
    }
    $ids=[];
    $ids[] = $booking->id;

    // Update subscription properties
    $booking->client->team_name = $request->BookingTitle;
    $booking->client->reference = $request->Bookingref;
    $booking->client->phone_number = $request->BookingNum;
    $booking->client->session_number = $request->BookingSession;
    if($request->input('Bookingconfirmed') == "true")
    $booking->client->reservation_confirmed = 1;
    else
    $booking->client->reservation_confirmed = 0;
    if ($request->input('Bookingconfirmed') == "true") {
        // Check if there's an existing Fund record
        if (!empty($request->BookingPayment) && $request->BookingPayment > 0) {
            // If no existing Fund record, create a new one
             Fund::create([
                'client_id' => $booking->client_id,
                'payment' =>$request->BookingPayment,
                'subscription_name' => $booking->client->subscription->name

                // Add any additional Fund fields as needed
            ]);
        }
    }
    // else {
    //     // Delete the existing Fund record if it exists
    //     if ($fund) {
    //         $fund->delete();
    //     }

    // }

    // Save the updated subscription
    $booking->client->save();
    $client_id = $booking->client_id;
    // Retrieve and sum all payment values for the specified client_id
    $totalPayments = Fund::where('client_id', $client_id)->sum('payment');
    $paymentRest = $booking->client->price - $totalPayments;
    // Return a success response
    return response()->json(['message' => 'booking updated successfully','ids'=>$ids,'editedData'=>$booking,'totalPayments'=>$totalPayments,
    'paymentRest'=>$paymentRest], 200);
}
}

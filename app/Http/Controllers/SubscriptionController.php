<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions= Subscription::with('stadium')->get();
        $stadiums = Stadium::all();
       return view('subscription', compact('subscriptions','stadiums'));
    }

 public function submit(Request $request)
{
    // Validate the form data
    $validator = Validator::make($request->all(), [
        'subscriptionTitle' => 'required|string|max:255',
        'subscriptionPrice' => 'required|numeric',
        'subscriptionStage' => 'required|string|max:255',
        'subscriptionFrequency' => 'required|integer',
        'booking_choice' => 'required|integer',
        'subscriptionDetail' => 'required|string',
    ]);

    // If validation fails, return the errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    // Create a new subscription
    Subscription::create([
        'name' => $request->subscriptionTitle,
        'price' => $request->subscriptionPrice,
        'stadium_id' => $request->subscriptionStage,
        'subscriptionFrequency' => $request->subscriptionFrequency,
        'booking_choice' => $request->booking_choice,
        'details' => $request->subscriptionDetail,
    ]);
    // Return a success response
    return response()->json(['message' => 'Subscription added successfully']);
}

public function fetch($id)
{

    $Subscription = Subscription::with('stadium')->find($id);


    return response()->json(['status'=>200,'Subscription'=>$Subscription]);
}

public function update(Request $request, $id)
{
    // Validate the form data
    $validator = Validator::make($request->all(), [
        'SubscriptionTitle' => 'required|string|max:255',
        'SubscriptionPrice' => 'required|numeric',
        'SubscriptionStage' => 'required|string|max:255',
        'SubscriptionFrequency' => 'required|integer',
        'Booking_choice' => 'required|integer',
        'SubscriptionDetail' => 'required|string',
    ]);

    // If validation fails, return the errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Find the subscription by its ID
    $subscription = Subscription::find($id);

    if (!$subscription) {
        return response()->json(['message' => 'Subscription not found'], 404);
    }

    // Update subscription properties
    $subscription->name = $request->SubscriptionTitle;
    $subscription->price = $request->SubscriptionPrice;
    $subscription->stadium_id = $request->SubscriptionStage;
    $subscription->subscriptionFrequency = $request->SubscriptionFrequency;
    $subscription->booking_choice = $request->Booking_choice;
    $subscription->details = $request->SubscriptionDetail;

    // Save the updated subscription
    $subscription->save();

    // Return a success response
    return response()->json(['message' => 'Subscription updated successfully']);
}

public function delete(Request $request,$id)
    {

        $appointment = Subscription::find($id);

        $appointment->delete();
        return response()->json(['status'=>200,'id'=>$id]);


    }
}

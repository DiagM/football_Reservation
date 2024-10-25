<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Stadium;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    public function index(){

        $stadiums= Stadium::all();

        return view('stadium',compact('stadiums'));


    }
    public function submit(Request$request){

           // Validate the form data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
    ]);

    // If validation fails, return the errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    // Create a new subscription
    Stadium::create([
        'name' => $request->name,

    ]);
    // Return a success response
    return response()->json(['message' => 'Subscription added successfully']);

    }

public function fetch($id)
{

    $stadium = Stadium::find($id);


    return response()->json(['status'=>200,'stadium'=>$stadium]);
}

public function update(Request $request, $id)
{
    // Validate the form data
    $validator = Validator::make($request->all(), [
        'SubscriptionTitle' => 'required|string|max:255',
    ]);

    // If validation fails, return the errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Find the subscription by its ID
    $subscription = Stadium::find($id);

    if (!$subscription) {
        return response()->json(['message' => 'Subscription not found'], 404);
    }

    // Update subscription properties
    $subscription->name = $request->SubscriptionTitle;


    // Save the updated subscription
    $subscription->save();

    // Return a success response
    return response()->json(['message' => 'Subscription updated successfully']);
}

public function delete(Request $request,$id)
    {

        $appointment = Stadium::find($id);

        $appointment->delete();
        return response()->json(['status'=>200,'id'=>$id]);


    }
}

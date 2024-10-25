<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Fund;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class FundController extends Controller
{
    public function index(){

        $funds= Fund::with('client.subscription.stadium')->get();
        $totalprice=0;
        $stade1price=0;
        $stade2price=0;
        $monthprice=0;
        $currentMonth = Carbon::now(); // Get the current month in the 'YYYY-MM' format
        $stadiumPrices = []; // An array to store stadium prices dynamically

        foreach ($funds as $fund) {
            $totalprice += $fund->payment;

            $stadiumId = $fund->client->subscription->stadium->id;

            // Initialize the stadium price if it doesn't exist in the array
            if (!isset($stadiumPrices[$stadiumId])) {
                $stadiumPrices[$stadiumId] = 0;
            }

            $stadiumPrices[$stadiumId] += $fund->payment;

            $subscriptionStart = Carbon::parse($fund->client->start_subs);

            // Check if the subscription started in the current month
            if ($subscriptionStart->format('Y-m') === $currentMonth->format('Y-m')) {
                $monthprice += $fund->payment;
            }
        }

        // Now $stadiumPrices is an associative array where keys are stadium IDs and values are the corresponding total prices for each stadium

        return view('fund', compact('totalprice', 'stadiumPrices', 'monthprice'));


    }
    public function getFunds(Request $request)
{
    if ($request->ajax()) {
        $query = Fund::with('client.useradd', 'client.useredit');

        // Date Filtering
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $startDate = Carbon::parse($request->input('startDate'))->startOfDay();
            $endDate = Carbon::parse($request->input('endDate'))->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $funds = $query->get();

        return Datatables::of($funds)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $editBtn = '<a id="editEventButton" data-bs-toggle="modal" data-subscription-id="'.$row->id.'" data-bs-target="#editModal" class="icon-pencil-alt green-button"></a>';
                $deleteBtn = '<a id="deleteEventButton" data-bs-toggle="modal" data-subscription-id="'.$row->id.'" data-bs-target="#confirmationModal" class="icon-trash red-button"></a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
public function fetch($id)
{

    $fund = Fund::with('client')->find($id);


    return response()->json(['status'=>200,'Subscription'=>$fund]);
}
public function update(Request $request, $id)
{
    // Validate the form data
    $validator = Validator::make($request->all(), [
        'SubscriptionPrice' => 'required|numeric',
        'SubscriptionPayment' => 'required|numeric'
    ]);

    // If validation fails, return the errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Find the subscription by its ID
    $fund = Fund::find($id);
    $idc = $fund->id;
$client=Client::find($idc);
    if (!$fund) {
        return response()->json(['message' => 'Subscription not found'], 404);
    }
    $user = auth()->user();

    // Update subscription properties
    $client->price = $request->SubscriptionPrice;
    $fund->payment = $request->SubscriptionPayment;
    $client->edited_by = $user->id;

    // Save the updated subscription
    $client->save();
    $fund->save();

    // Return a success response
    return response()->json(['message' => 'Subscription updated successfully']);
}

public function delete(Request $request,$id)
    {

        $appointment = Fund::find($id);

        $appointment->delete();
        return response()->json(['status'=>200,'id'=>$id]);


    }
}

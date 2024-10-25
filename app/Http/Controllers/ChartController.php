<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Subscription;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getPieChartData()
{
    $subscriptions = Subscription::all(); // Fetch all subscriptions

    $data = [];

    foreach ($subscriptions as $subscription) {
        // Count the number of clients using each subscription
        $count = $subscription->client->count();

        // Add subscription name and count to the data array
        $data[] = [
            'label' => $subscription->name,
            'count' => $count,
        ];
    }

    return response()->json($data);
}
public function lineChart()
{
    // Fetch the data, grouping by month and subscription
    $data = Client::selectRaw('strftime("%Y-%m", start_subs) AS month, subscriptions.name AS subscription_name, COUNT(clients.id) as count')
    ->leftJoin('subscriptions', 'clients.subscription_id', '=', 'subscriptions.id')
    ->groupBy('month', 'subscription_name')
    ->orderBy('month', 'asc')
    ->orderBy('subscription_name', 'asc')
    ->get();


    // Format the data for Chart.js
    $months = $data->pluck('month')->unique();
    $subscriptions = $data->pluck('subscription_name')->unique();
    $values = [];

    foreach ($subscriptions as $subscription) {
        $values[$subscription] = $data->where('subscription_name', $subscription)->pluck('count');
    }

    return response()->json([
        'labels' => $months,
        'values' => $values,
    ]);
}


}

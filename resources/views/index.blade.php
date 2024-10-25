@extends('layout.master')

@section('main-content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>Tableau de bord</h3>
            </div>

        </div>
    </div>
</div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Nombre d'abonnement utilisé par clients</h4>
                    </div>

                    <div class="chart-container" style="height:400px; width:553px; display: flex; justify-content: center; align-items: center;">
                        <canvas id="myPieChart"></canvas>
                        </div>

                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>abonnement au fur des mois</h4>
                    </div>
                    <div class="chart-container" style="height:400px; width:553px; display: flex; justify-content: center; align-items: center;">
                        <canvas id="myLineChart"></canvas>
                    </div>
                </div>
             </div>
        {{--    <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Bar Chart</h4>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myBarGraph"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Line Graph</h4>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myGraph"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Radar Graph</h4>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myRadarGraph"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Nombre d'abbonnement utilisé par clients</h4>
                    </div>
                    <div class="card-body chart-block chart-vertical-center">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Polar Chart</h4>
                    </div>
                    <div class="card-body chart-block chart-vertical-center">
                        <canvas id="myPolarGraph"></canvas>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Function to generate distinct HSL colors
        function generateColors(numColors) {
    // Predefined colors
    var colors = ["#89CFF0", "#FED8B1", "#F88379", "#FFCCCC", "#CCFFCC", "#FFFFCC", "#FFCCFF", "#FFD699", "#FFCCFF", "#89CFF0"];

    // Create a dynamic color mapping for additional choices
    var colorMapping = {
        '1': '#89CFF0',
        '2': '#FED8B1',
        '3': '#F88379',
        '4': '#FFCCCC',
        '5': '#CCFFCC',
        '6': '#FFFFCC',
        '7': '#FFCCFF',
        '8': '#FFD699',
        '9': '#FFCCFF',
        '10': '#89CFF0',
        // Add more stadiums and colors as needed
    };

    // If numColors exceeds the predefined colors, use the color mapping
    for (var i = colors.length; i < numColors; i++) {
        var color = colorMapping[(i + 1).toString()] || getRandomColor(); // Use mapping or generate a random color
        colors.push(color);
    }

    return colors;
}

// Function to generate a random hex color
function getRandomColor() {
    return "#" + Math.floor(Math.random() * 16777215).toString(16);
}

        $.ajax({
    url: '/chart-data',
    method: 'GET',
    success: function(data) {
        var labels = data.map(function(item) {
            return item.label;
        });

        var counts = data.map(function(item) {
            return item.count;
        });

        var numColors = data.length;
        var colors = generateColors(numColors);
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: colors,
                }],
            },

        });
    },
});

    </script>
    <script>
$.ajax({
    url: '/line-chart',
    method: 'GET',
    success: function(data) {
        var labels = data.labels; // Array of month labels
        var subscriptions = Object.keys(data.values); // Array of subscription names
        var values = data.values; // Object with subscription counts per month
        var numColors = subscriptions.length;
        var colors = generateColors(numColors);
        var datasets = [];
        subscriptions.forEach(function(subscription) {
            datasets.push({
                label: subscription,
                data: values[subscription],
                borderColor: colors, // You can use a function to generate random colors
                borderWidth: 2,
            });
        });

        var ctx = document.getElementById('myLineChart').getContext('2d');
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets,
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    },
});


    </script>
@endsection

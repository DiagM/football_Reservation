@extends('layout.master')

@section('main-content')
<h2>Historique des séances</h2>


<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">

                <select class="form-control" id="filterBy">
                    <option value="reference">Reference</option>
                    <option value="team_name">Nom de l'équipe</option>

                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">

                <input type="text" class="form-control" id="filterValue" placeholder="Enter Value">
            </div>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" id="applyFilter">Rechercher</button>
        </div>
    </div>
     <!-- Date Filter -->
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="startDate">Date de début:</label>
            <input type="date" class="form-control" id="startDate" name="startDate">
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="endDate">Date de fin:</label>
            <input type="date" class="form-control" id="endDate" name="endDate">
        </div>
    </div>
    <div class="col-md-4">
        <button class="btn btn-secondary" id="clearFilters">Effacer les filtres</button>
    </div>
</div>

    <table class="dataTable">
        <thead>
        <tr>
            <th>Référence</th>
            <th>Nom de l'équipe</th>
            <th>Date du pointage</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<script src="{{ asset('assets/js/moment.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url: "{{ route('session.list') }}",
            data: function (d) {
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
            },
        },
            columns: [

                {data: 'reference', name: 'reference'},
                {data: 'team_name', name: 'team_name'},

                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function (data) {
                        // Format the date using Moment.js
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                },

            ],

        });
        // Add an event listener for date input changes
    $('#startDate, #endDate').on('change', function () {
        // Automatically redraw the DataTable when date inputs change
        table.draw();
    });
    // Add a click event handler for the clear filters button
    $('#clearFilters').click(function () {
        // Reset the date inputs and filter value
        $('#startDate, #endDate, #filterValue').val('');

        // Clear DataTables search
        table.search('').draw();
        table.draw();
    });
 // Add a click event handler for the filter button
        $('#applyFilter').click(function () {
            var selectedFilter = $('#filterBy').val();
            var filterValue = $('#filterValue').val();

            // Use DataTables API to apply the filter based on the selected option
            if (selectedFilter === 'reference') {
                table.columns(0).search(filterValue).draw();
            } else if (selectedFilter === 'team_name') {
                table.columns(1).search(filterValue).draw();
            }
        });


    });
</script>


@endsection


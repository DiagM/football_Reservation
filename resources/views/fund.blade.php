@extends('layout.master')

@section('main-content')
<h2>Caisse</h2>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="successMessagePlaceholder"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editSubscriptionPrice">Prix abonnement</label>
                    <input type="text" class="form-control" id="editSubscriptionPrice" placeholder="Prix" required>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editSubscriptionPayment">Versement</label>
                    <input type="text" class="form-control" id="editSubscriptionPayment" placeholder="versement" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="saveEditButton">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmer la suprression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer cette ligne?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Confirmer</button>
            </div>
        </div>
    </div>
</div>


<div class="col-md-10 ">
    <div class="row ">
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fa fa-shopping-cart"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Totale:</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                {{$totalprice}}
                            </h2>
                        </div>
                        <div class="col-4 text-right">
                            <span>DZD<i class="fa fa-arrow-up"></i></span>
                        </div>
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                             style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card l-bg-orange-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fa fa-dollar"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Ce mois</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                {{$monthprice}}
                            </h2>
                        </div>
                        <div class="col-4 text-right">
                            <span>DZD <i class="fa fa-arrow-up"></i></span>
                        </div>
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                             style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
        @php
        $colors = ['#89CFF0', '#FED8B1', '#F88379', '#FFCCCC', '#CCFFCC', '#FFFFCC', '#FFCCFF', '#FFD699', '#FFCCFF', '#89CFF0', '#A5D6A7', '#FFAB91', '#FFC400', '#BBDEFB', '#D1C4E9', '#C5CAE9', '#E1BEE7', '#DCEDC8', '#FFE0B2', '#CFD8DC', '#C8E6C9', '#FFF9C4', '#E0F7FA', '#E8F5E9', '#FCE4EC', '#E3F2FD', '#F3E5F5', '#FFF8E1', '#F0F4C3', '#FFCCBC', '#B2EBF2', '#C5E1A5', '#FFECB3', '#C8E6C9', '#FFD180', '#B3E0FF', '#E6EE9C', '#D7CCC8', '#FFAB91', '#9FA8DA', '#FFEB3B', '#E0E0E0', '#B0BEC5', '#E57373', '#81C784', '#64B5F6', '#FFD54F', '#BCAAA4', '#FFA07A', '#FF5722'];

        $colorIndex = 0;
    @endphp

    @foreach($stadiumPrices as $stadiumId => $stadiumPrice)
        @php
            $color = $colors[$colorIndex];
            $colorIndex = ($colorIndex + 1) % count($colors);
        @endphp

        <div class="col-xl-3 col-lg-6">
            <div class="card" style="background-color: {{ $color }};">
            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large"><i class="fa fa-soccer-ball-o"></i></div>
                <div class="mb-4">
                    <h5 class="card-title mb-0">Stade {{ $stadiumId }}:</h5>
                </div>
                <div class="row align-items-center mb-2 d-flex">
                    <div class="col-8">
                        <h2 class="d-flex align-items-center mb-0">
                            {{ $stadiumPrice }}
                        </h2>
                    </div>
                    <div class="col-4 text-right">
                        <span>DZD <i class="fa fa-arrow-up"></i></span>
                    </div>
                </div>
                <div class="progress mt-1 " data-height="8" style="height: 8px;">
                    <div class="progress-bar l-bg-{{ $loop->even ? 'green' : 'orange' }}" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                         style="width: 25%;"></div>
                </div>
            </div>
        </div>
    </div>
@endforeach


    </div>
</div>
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
            <th>Type abonnement</th>
            <th>Ajouté par:</th>
            <th>Date d'ajout:</th>
            <th>Modifier par:</th>
            <th>Prix</th>
            <th>Versement</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
{{--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"
      integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous"/> --}}

<style>
    .card {
        background-color: #fff;
        border-radius: 10px;
        border: none;
        position: relative;
        margin-bottom: 30px;
        box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
    }

    .l-bg-cherry {
        background: linear-gradient(to right, #493240, #f09) !important;
        color: #fff;
    }

    .l-bg-blue-dark {
        background: linear-gradient(to right, #373b44, #4286f4) !important;
        color: #fff;
    }

    .l-bg-green-dark {
        background: linear-gradient(to right, #0a504a, #38ef7d) !important;
        color: #fff;
    }

    .l-bg-orange-dark {
        background: linear-gradient(to right, #a86008, #ffba56) !important;
        color: #fff;
    }

    .card .card-statistic-3 .card-icon-large .fa, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
        font-size: 110px;
    }

    .card .card-statistic-3 .card-icon {
        text-align: center;
        line-height: 50px;
        margin-left: 15px;
        color: #000;
        position: absolute;
        right: -5px;
        top: 20px;
        opacity: 0.1;
    }

    .l-bg-cyan {
        background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
        color: #fff;
    }

    .l-bg-green {
        background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
        color: #fff;
    }

    .l-bg-orange {
        background: linear-gradient(to right, #f9900e, #ffba56) !important;
        color: #fff;
    }

    .l-bg-cyan {
        background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
        color: #fff;
    }

    .green-button {

        color: green;
        /* Add other styles as needed */
    }

    .red-button {
        color: red;
        /* Add other styles as needed */
    }

</style>


<script src="{{ asset('assets/js/moment.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('fund.list') }}",
                data: function (d) {
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                },
            },

            columns: [
                {data: 'client.reference', name: 'client.reference'},
                {data: 'client.team_name', name: 'client.team_name'},
                {data: 'subscription_name', name: 'subscription_name'},
                {data: 'client.useradd.name', name: 'client.useradd.name'},
                {
                    data: 'client.created_at',
                    name: 'client.created_at',
                    render: function (data) {
                        // Format the date using Moment.js
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                },
                {data: 'client.useredit.name', name: 'client.useredit.name'},
                {data: 'client.price', name: 'client.price'},
                {data: 'payment', name: 'payment'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
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

        // Function to calculate and update the total price and payment row
        function updateTotalRow() {
            var totalPrice = 0;
            var totalPayment = 0;

            // Iterate through each row in the DataTable and calculate the total price and payment
            table.rows().every(function () {
                var rowData = this.data();
                var price = parseFloat(rowData.client.price);
                var payment = parseFloat(rowData.payment);

                // Check if the price and payment are valid numbers
                if (!isNaN(price)) {
                    totalPrice += price;
                }
                if (!isNaN(payment)) {
                    totalPayment += payment;
                }
            });

            // Create a new row for the total price and payment
            var totalRow = $('<tr>').addClass('total-row');
            totalRow.append($('<td>').text('Total:'));
            totalRow.append($('<td>').text('')); // Empty cell for alignment
            totalRow.append($('<td>').text('')); // Empty cell for alignment
            totalRow.append($('<td>').text('')); // Empty cell for alignment
            totalRow.append($('<td>').text('')); // Empty cell for alignment
            totalRow.append($('<td>').text('')); // Empty cell for alignment
            totalRow.append($('<td>').text('')); // Empty cell for alignment
            // totalRow.append($('<td>').text(totalPrice)); // Total price
            totalRow.append($('<td>').text(totalPayment)); // Total payment
            totalRow.append($('<td>').text('')); // Empty cell for alignment

            // Remove any existing total row and append the new one
            $('.total-row').remove();
            $('.dataTable tbody').append(totalRow);
        }

        // Call the updateTotalRow function initially and after any changes in the table
        updateTotalRow();

        // Add an event listener to recalculate and update the total row when the table is redrawn (e.g., due to filtering)
        table.on('draw', function () {
            updateTotalRow();
        });

    });
</script>


<script>
    $(document).ready(function () {
        $(document).on('click', '#deleteEventButton', function () {
            // Get the subscription ID from the data attribute
            var subscriptionId = $(this).data('subscription-id');

            // When the user clicks the "Save" button in the edit modal
            $('#confirmDeleteButton').click(function () {
                var formData = new FormData();


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "DELETE",
                    url: "/fund/delete/" + subscriptionId,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#successMessagePlaceholder').text("Recette supprimé !");
                        $('.dataTable').DataTable().draw();

                        $('#confirmationModal').modal('hide');
                        $('#successModal').modal('show');


                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '#editEventButton', function () {
            // Get the subscription ID from the data attribute
            var subscriptionId = $(this).data('subscription-id');

            console.log('Subscription ID:', subscriptionId);
            $.ajax({
                type: "GET",
                url: "/fund/" + subscriptionId, // Replace with your endpoint URL
                dataType: "json",
                success: function (response) {
                    // Populate the edit modal fields with the retrieved data
                    $('#editSubscriptionPrice').val(response.Subscription.client.price);
                    $('#editSubscriptionPayment').val(response.Subscription.payment);
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });

            // When the user clicks the "Save" button in the edit modal
            $('#saveEditButton').click(function () {
                // Collect edited data from modal fields
                var editedSubscriptionPrice = $('#editSubscriptionPrice').val();
                var editedSubscriptionPayment = $('#editSubscriptionPayment').val();
                var formData = new FormData();
                formData.append('SubscriptionPrice', editedSubscriptionPrice);
                formData.append('SubscriptionPayment', editedSubscriptionPayment);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/fund/update/" + subscriptionId,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#successMessagePlaceholder').text("Recette mis a jour !");
                        $('.dataTable').DataTable().draw();

                        $('#editModal').modal('hide');
                        $('#successModal').modal('show');


                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        var errors = xhr.responseJSON.errors;

                        // Clear any previous error messages
                        $('.error-message').remove();

                        // Display each error message next to the corresponding input field
                        $.each(errors, function (field, messages) {
                            var inputField = $('#' + 'edit' + field);
                            inputField.addClass('is-invalid');
                            inputField.after('<span class="error-message text-danger">' + messages[0] + '</span>');
                        });
                    }
                });

            });
        });
    });
</script>

@endsection


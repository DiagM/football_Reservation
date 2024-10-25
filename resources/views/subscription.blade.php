@extends('layout.master')


@section('main-content')
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmer la suprression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer cette abonnement?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Confirmer</button>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="addSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="addSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubscriptionModalLabel">Ajouter un abonnement</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="subscriptionTitle">Titre de l'abonnement</label>
                    <input type="text" class="form-control" id="subscriptionTitle" placeholder="Titre de l'abonnement" required>
                </div>
                <div class="form-group">
                    <label for="subscriptionPrice">Prix</label>
                    <input type="text" class="form-control" id="subscriptionPrice" placeholder="Prix" required>
                </div>
                <div class="form-group">
                    <label for="subscriptionStage">Stade</label>
                    <select class="form-control" id="subscriptionStage" name="subscriptionStage" required>
                        <option value="" disabled selected>Choisissez un stade</option>
                        @foreach($stadiums as $stadium)
                        <option value="{{ $stadium->id }}">{{ $stadium->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="subscriptionFrequency">Nombre de fois par semaine</label>
                    <input type="number" class="form-control" id="subscriptionFrequency" min="1" max="4" placeholder="Nombre de fois par semaine" required>
                </div>
                <div class="form-group">
                    <label for="booking_choice">Durée d'abonnement</label>
                    <input type="number" class="form-control" id="booking_choice" name="booking_choice" min="1" max="365" required>
                </div>
                <div class="form-group">
                    <label for="subscriptionDetail">Détail</label>
                    <textarea class="form-control" id="subscriptionDetail" rows="4" placeholder="Détail"></textarea required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" id="add" class="btn btn-primary">Ajouter</button>
            </div>

        </div>
    </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="editSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="editSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubscriptionModalLabel">Éditer un abonnement</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form fields for editing -->
                <div class="form-group">
                    <label for="editSubscriptionTitle">Titre de l'abonnement</label>
                    <input type="text" class="form-control" id="editSubscriptionTitle" placeholder="Titre de l'abonnement" required>
                </div>
                <div class="form-group">
                    <label for="editSubscriptionPrice">Prix</label>
                    <input type="text" class="form-control" id="editSubscriptionPrice" placeholder="Prix" required>
                </div>
                <div class="form-group">
                    <label for="editSubscriptionStage">Stade</label>
                    <select class="form-control" id="editSubscriptionStage" name="editSubscriptionStage" required>
                        <option value="" disabled selected>Choisissez un stade</option>
                        @foreach($stadiums as $stadium)
                        <option value="{{ $stadium->id }}">{{ $stadium->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="editSubscriptionFrequency">Nombre de fois par semaine</label>
                    <input type="number" class="form-control" id="editSubscriptionFrequency" min="1" max="4" placeholder="Nombre de fois par semaine" required>
                </div>
                <div class="form-group">
                    <label for="editBookingChoice">Durée d'abonnement</label>
                    <input type="number" class="form-control" id="editBookingChoice" name="editBookingChoice" min="30" max="365" required>
                </div>
                <div class="form-group">
                    <label for="editSubscriptionDetail">Détail</label>
                    <textarea class="form-control" id="editSubscriptionDetail" rows="4" placeholder="Détail" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="saveEdit" class="btn btn-primary">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>


<h2>Types d'abonnements</h2>


<div class="text-right mb-4">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal">
        Ajouter
    </button>
</div>
<!-- row  -->
<div class="row mt-4">
    @foreach ($subscriptions as $subscription)

    <!-- column  -->
    <div class="col-md-6">
        <div class="card card-shadow border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <h5 class="font-weight-medium mb-0">{{$subscription->name}}</h5>

                </div>
                <div class="row">
                    <div class="col-lg-5 text-center">
                        <div class="price-box my-3">
                            <sup>dzd</sup><span class="text-dark display-5">{{$subscription->price}}</span>
                            <h6 class="font-weight-light">{{$subscription->booking_choice}}jours</h6>
                            <a class="btn btn-primary font-14 border-0 text-white p-3 btn-block mt-3 edit-button" data-bs-toggle="modal"
                               data-bs-target="#editSubscriptionModal" data-subscription-id="{{$subscription->id}}" href="#">Editer</a>
                            <a class="btn btn-danger font-14 border-0 text-white p-3 btn-block mt-3 delete-button" id="deleteEventButton" data-bs-toggle="modal"
                               data-subscription-id="{{$subscription->id}}" data-bs-target="#confirmationModal">Supprimer</a>
                        </div>
                    </div>
                    <div class="col-lg-7 align-self-center">
                        <ul class="list-inline pl-3 font-14 font-weight-medium text-dark">
                            <li class="py-2"><i class="icon-check text-info mr-2"></i>
                                <span>{{$subscription->subscriptionFrequency}} jour(s) par semaine </span></li>
                            <li class="py-2"><i class="icon-check text-info mr-2"></i> <span>Stade: {{$subscription->stadium->name}} </span></li>
                            <!--  <p class="font-weight-light mb-0">{{$subscription->details}}</p> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endforeach
</div>
<!-- The success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="successMessagePlaceholder"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    var AddButton = document.getElementById('add');
    AddButton.addEventListener('click', function () {

        var subscriptionTitle = document.getElementById('subscriptionTitle').value;
        var subscriptionPrice = document.getElementById('subscriptionPrice').value;
        var subscriptionFrequency = document.getElementById('subscriptionFrequency').value;
        var booking_choice = document.getElementById('booking_choice').value;
        var subscriptionDetail = document.getElementById('subscriptionDetail').value;

        var formData = new FormData();
        formData.append('subscriptionTitle', subscriptionTitle);
        formData.append('subscriptionPrice', subscriptionPrice);
        var selectElement = document.getElementById('subscriptionStage');
        // Get the selected option
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        // Get the value and text of the selected option
        var selectedValue = selectedOption.value;
        formData.append('subscriptionStage', selectedValue);
        formData.append('subscriptionFrequency', subscriptionFrequency);
        formData.append('booking_choice', booking_choice);
        formData.append('subscriptionDetail', subscriptionDetail);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/subscription/submit",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {

                $('#successMessagePlaceholder').text("Abonnement ajouté !");
                $('#successModal').modal('show');

                // Reload the page after a short delay (e.g., 2 seconds)
                setTimeout(function () {
                    location.reload();
                }, 1000); // Change the delay time as needed
            },
            error: function (xhr, status, error) {
                // Handle error response
                var errors = xhr.responseJSON.errors;

                // Clear any previous error messages
                $('.error-message').remove();

                // Display each error message next to the corresponding input field
                $.each(errors, function (field, messages) {
                    var inputField = $('#' + field);
                    inputField.addClass('is-invalid');
                    inputField.after('<span class="error-message text-danger">' + messages[0] + '</span>');
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.edit-button').click(function () {
            var subscriptionId = $(this).data('subscription-id');
            $.ajax({
                type: "GET",
                url: "/subscription/" + subscriptionId, // Replace with your endpoint URL
                dataType: "json",
                success: function (response) {
                    // Populate the edit modal fields with the retrieved data
                    $('#editSubscriptionTitle').val(response.Subscription.name);
                    $('#editSubscriptionPrice').val(response.Subscription.price);
                    $('#editSubscriptionFrequency').val(response.Subscription.subscriptionFrequency);
                    $('#editBookingChoice').val(response.Subscription.booking_choice);
                    $('#editSubscriptionDetail').val(response.Subscription.details);
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });

            // When the user clicks the "Save" button in the edit modal
            $('#saveEdit').click(function () {
                // Collect edited data from modal fields
                var editedSubscriptionTitle = $('#editSubscriptionTitle').val();
                var editedSubscriptionPrice = $('#editSubscriptionPrice').val();
                var selectElement = document.getElementById('editSubscriptionStage');

                // Get the selected option
                var selectedOption = selectElement.options[selectElement.selectedIndex];

                // Get the value and text of the selected option
                var selectedValue = selectedOption.value;
                var editedSubscriptionStage = selectedValue;
                var editedSubscriptionfrq = $('#editSubscriptionFrequency').val();
                var editedSubscriptionbookingchoice = $('#editBookingChoice').val();
                var editedSubscriptiondetils = $('#editSubscriptionDetail').val();
                var formData = new FormData();
                formData.append('SubscriptionTitle', editedSubscriptionTitle);
                formData.append('SubscriptionPrice', editedSubscriptionPrice);
                formData.append('SubscriptionStage', editedSubscriptionStage);
                formData.append('SubscriptionFrequency', editedSubscriptionfrq);
                formData.append('Booking_choice', editedSubscriptionbookingchoice);
                formData.append('SubscriptionDetail', editedSubscriptiondetils);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/subscription/update/" + subscriptionId,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#successMessagePlaceholder').text("Abonnement mis a jour !");
                        $('#successModal').modal('show');

                        // Reload the page after a short delay (e.g., 2 seconds)
                        setTimeout(function () {
                            location.reload();
                        }, 1000); // Change the delay time as needed
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

<script>
    $(document).ready(function () {
        $('.delete-button').click(function () {
            var subscriptionId = $(this).data('subscription-id');


            // When the user clicks the "Save" button in the edit modal
            $('#confirmDeleteButton').click(function () {
                var formData = new FormData();


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "DELETE",
                    url: "/subscription/delete/" + subscriptionId,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#successMessagePlaceholder').text("Abbonnement supprimé !");
                        $('#successModal').modal('show');

                        // Reload the page after a short delay (e.g., 2 seconds)
                        setTimeout(function () {
                            location.reload();
                        }, 1000); // Change the delay time as needed

                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    });
</script>

@endsection

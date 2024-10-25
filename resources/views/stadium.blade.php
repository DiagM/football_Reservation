@extends('layout.master')
@section('main-content')
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
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmer la suprression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer cette abbonnement ?</p>

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
                <h5 class="modal-title" id="addSubscriptionModalLabel">Ajouter un stade</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name">Nom du stade</label>
                    <input type="text" class="form-control" id="name" placeholder="Nom du stade" required>
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
                <h5 class="modal-title" id="editSubscriptionModalLabel">Éditer un stade</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form fields for editing -->
                <div class="form-group">
                    <label for="editSubscriptionTitle">Nom du stade</label>
                    <input type="text" class="form-control" id="editSubscriptionTitle" placeholder="Nom du stade" required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="saveEdit" class="btn btn-primary">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>

<h2>Stades</h2>

<div class="text-right mb-4">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal">
        Ajouter
    </button>
</div>
<div class="row">
    @foreach ($stadiums as $stadium)

    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $stadium->name }}</h5>
                <a class="btn btn-primary font-14 border-0 text-white p-3 btn-block mt-3 edit-button" data-bs-toggle="modal"
                   data-bs-target="#editSubscriptionModal" data-subscription-id="{{$stadium->id}}" href="#">Editer</a>
                <a class="btn btn-danger font-14 border-0 text-white p-3 btn-block mt-3 delete-button" id="deleteEventButton" data-bs-toggle="modal"
                   data-subscription-id="{{$stadium->id}}" data-bs-target="#confirmationModal">Supprimer</a>
            </div>
        </div>
    </div>
    @endforeach
</div>


<script>

    var AddButton = document.getElementById('add');
    AddButton.addEventListener('click', function () {

        var name = document.getElementById('name').value;


        var formData = new FormData();
        formData.append('name', name);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/stadium/submit",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {

                $('#successMessagePlaceholder').text("Stade ajouté !");

                $('#addSubscriptionModal').modal('hide');
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
                url: "/stadium/" + subscriptionId, // Replace with your endpoint URL
                dataType: "json",
                success: function (response) {
                    // Populate the edit modal fields with the retrieved data
                    $('#editSubscriptionTitle').val(response.stadium.name);
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
                var formData = new FormData();
                formData.append('SubscriptionTitle', editedSubscriptionTitle);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/stadium/update/" + subscriptionId,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#successMessagePlaceholder').text("Stade mis a jour !");

                        $('#editSubscriptionModal').modal('hide');
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
                    url: "/stadium/delete/" + subscriptionId,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#successMessagePlaceholder').text("Stade supprimé !");

                        $('#confirmationModal').modal('hide');
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

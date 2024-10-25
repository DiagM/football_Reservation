@extends('layout.master')

@section('main-content')
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
                    <label for="Ename">Nom</label>
                    <input type="text" class="form-control" id="Ename" placeholder="Nom" required>
                </div>
                <div class="form-group">
                    <label for="Eemail">Email</label>
                    <input type="email" class="form-control" id="Eemail" placeholder="email" >
                </div>
                <div class="mb-7">
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-5">Role</label>
                    <!--end::Label-->
                    <!--begin::Roles-->
                    @foreach ($roles as $role)
                    <!--begin::Input row-->
                    <div class="d-flex fv-row">
                        <!--begin::Radio-->
                        <div class="form-check form-check-custom form-check-solid">
                            <!--begin::Input-->
                            <input class="user_role_edit form-check-input me-3"
                                   name="roles[]" type="checkbox"
                                   value="{{ $role->id }}"/>
                            <!--end::Input-->
                            <!--begin::Label-->
                            <label class="form-check-label" for="{{ $role->name }}">
                                <div class="fw-bold text-gray-800">{{ $role->display_name }}
                                </div>

                            </label>
                            <!--end::Label-->
                        </div>
                        <!--end::Radio-->
                    </div>
                    <!--end::Input row-->

                    @endforeach
                    <!--end::Roles-->
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

<!-- The Modal -->
<div class="modal fade" id="addSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="addSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubscriptionModalLabel">Ajouter un utilisateur</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" id="name" placeholder="Nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="email" >
                </div>
                <div class="form-group">
                    <label for="password">mot de passe</label>
                    <input type="password" class="form-control" id="password" placeholder="mot de passe" required>
                </div>
                <div class="mb-7">
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-5">Role</label>
                    <!--end::Label-->
                    <!--begin::Roles-->
                    @foreach ($roles as $role)
                    <!--begin::Input row-->
                    <div class="d-flex fv-row">
                        <!--begin::Radio-->
                        <div class="form-check form-check-custom form-check-solid">
                            <!--begin::Input-->
                            <input class="user_role form-check-input me-3"
                                   name="roles[]" type="checkbox"
                                   value="{{ $role->id }}"/>
                            <!--end::Input-->
                            <!--begin::Label-->
                            <label class="form-check-label" for="{{ $role->name }}">
                                <div class="fw-bold text-gray-800">{{ $role->name }}
                                </div>

                            </label>
                            <!--end::Label-->
                        </div>
                        <!--end::Radio-->
                    </div>
                    <!--end::Input row-->

                    @endforeach
                    <!--end::Roles-->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" id="add" class="btn btn-primary">Ajouter</button>
            </div>

        </div>
    </div>
</div>


<div class="container">
    <h2>Utilisateurs</h2>
    <div class="text-right mb-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal">
            Ajouter
        </button>
    </div>
    <table class="dataTable">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<style>
    .green-button {

        color: green;
        /* Add other styles as needed */
    }

    .red-button {
        color: red;
        /* Add other styles as needed */
    }

</style>


<script>
    document.addEventListener("DOMContentLoaded", function () {

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.list') }}",
            columns: [

                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

        });


    });
</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '#add', function () {
            const roles = [];
            $('.user_role').each(function () {
                if ($(this).is(":checked")) {
                    roles.push($(this).val());
                }
            });
            var formData = new FormData();
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            formData.append('name', name);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('roles', roles);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/user/submit/",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    $('#successMessagePlaceholder').text("utilisateur ajouté !");
                    $('.dataTable').DataTable().draw();
                    // Clear the input fields
                    $('#addSubscriptionModal #name').val('');
                    $('#addSubscriptionModal #email').val('');
                    $('#addSubscriptionModal #password').val('');

                    // Clear the checkboxes by unchecking them
                    $('#addSubscriptionModal .user_role').prop('checked', false);

                    $('#addSubscriptionModal').modal('hide');
                    $('#successModal').modal('show');


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
                    url: "/user/delete/" + subscriptionId,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#successMessagePlaceholder').text("Utilisateur supprimé !");
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
                url: "/user/" + subscriptionId, // Replace with your endpoint URL
                dataType: "json",
                success: function (response) {
                    // Populate the edit modal fields with the retrieved data
                    $('#Ename').val(response.user.name);
                    $('#Eemail').val(response.user.email);

                    // Get the roles associated with the user
                    var userRoles = response.roles.map(role => role.id);
                    // Loop through the roles checkboxes
                    $('.user_role_edit').each(function () {
                        var roleId = parseInt($(this).val()); // Convert to integer for comparison

                        // Check if the roleId exists in the userRoles array
                        if (userRoles.includes(roleId)) {
                            $(this).prop('checked', true); // Check the checkbox
                        } else {
                            $(this).prop('checked', false); // Uncheck the checkbox
                        }
                    });
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });

            // When the user clicks the "Save" button in the edit modal
            $('#saveEditButton').click(function () {
                const roles = [];
                $('.user_role_edit').each(function () {
                    if ($(this).is(":checked")) {
                        roles.push($(this).val());
                    }
                });
                // Collect edited data from modal fields
                var ename = $('#Ename').val();
                var email = $('#Eemail').val();
                var formData = new FormData();
                formData.append('Ename', ename);
                formData.append('Eemail', email);
                formData.append('roles', roles);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/user/update/" + subscriptionId,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#successMessagePlaceholder').text("Utilisateur mis a jour !");
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


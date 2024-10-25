@extends('layout.master')
@section('custom-head')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/material_red.css') }}">
@endsection

@section('main-content')

<input type="text" id="titleFilter" placeholder="Filtre par titre">


<input type="text" class="flatpickr" id="reservation_date" name="reservation_date" placeholder="Filtre par date">
<!-- Dropdown for Stadium Filter -->
<div class="form-group">
    <label for="stadiumFilter">Filtrer par stade:</label>
    <select class="form-control" id="stadiumFilter" style="width: 200px;">
        <option value="">Tous les stades</option>
        @foreach($stadiums as $stadium)
            <option value="{{ $stadium->name }}">{{ $stadium->name }}</option>
        @endforeach
    </select>
</div>
<!-- Bootstrap Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Détails</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="eventBookingId">
                <p><strong>Nom de l'équipe:</strong> <span id="eventTeamName"></span></p>
                <p><strong>Réference:</strong> <span id="eventTeamref"></span></p>
                <p><strong>Num:</strong> <span id="eventPhoneNumber"></span></p>
                <p><strong>Stade:</strong> <span id="eventStadiumChoice"></span></p>
                <p><strong>Prix:</strong> <span id="eventPrice"></span></p>
                <p><strong>Total verser:</strong> <span id="eventPayment"></span></p>
                <p><strong>Reste à verser:</strong> <span id="eventPaymentRest"></span></p>
                <p><strong>Nombre de séances restantes:</strong> <span id="eventsession"></span></p>
                <p><strong>Réservation confirmée:</strong> <span id="eventReservation"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="editEventButton" data-bs-toggle="modal" data-bs-target="#editModal">Editer</button>
                <button type="button" class="btn btn-danger" id="deleteEventButton" data-bs-toggle="modal" data-bs-target="#confirmationModal">Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer toutes les réservations reliées à celle-ci?</p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="confirmDeleteCheckbox">
                    <label class="form-check-label" for="confirmDeleteCheckbox">
                        Oui, je confirme la suppression.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Éditer une réservation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form fields for editing -->
                <div class="form-group">
                    <label for="editTitle">Nom de l'équipe</label>
                    <input type="text" class="form-control" id="editTitle" placeholder="Nom de l'équipe" required>
                </div>
                <div class="form-group">
                    <label for="editref">Réference</label>
                    <input type="text" class="form-control" id="editref" placeholder="Réference" required>
                </div>
                <div class="form-group">
                    <label for="editNum">Numéro du télephone</label>
                    <input type="text" class="form-control" id="editNum" placeholder="Num" required>
                </div>
                <div class="form-group">
                    <label for="editPayment">Nouveau versement</label>
                    <input type="number" class="form-control" id="editPayment" placeholder="payment" required>
                </div>
                <div class="form-group">
                    <div id="error-message" style="color: red;"></div>

                    <label for="editSession">Séance restante</label>
                    <input type="number" class="form-control" id="editSession" placeholder="session" required>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="reservation_confirmed" name="reservation_confirmed">
                        <label class="form-check-label" for="reservation_confirmed">Réservation confirmée</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="saveEdit" class="btn btn-primary">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Success Modal -->
<div class="modal fade" id="success_tic" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-center">
        <div class="modal-content">
            <div class="modal-header success-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Réservation supprimé.</p>
            </div>
            <div class="modal-footer success-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap Success Modal -->
<div class="modal fade" id="success_tic_edit" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-center">
        <div class="modal-content">
            <div class="modal-header success-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Réservation modifié.</p>
            </div>
            <div class="modal-footer success-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>

        </div>
    </div>
</div>


<!-- Your other content goes here -->
<div id="calendar"></div>


<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('assets/js/fr.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendarindex.global.js') }}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var titleFilterInput = document.getElementById('titleFilter');
        var reservationDateInput = document.getElementById('reservation_date');
        var stadiumFilterDropdown = document.getElementById('stadiumFilter');
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d",
            locale: "fr",
            // minDate: "today",
            onClose: function (selectedDates, dateStr, instance) {
                // When a date is selected, update FullCalendar's view to the selected date
                if (selectedDates.length > 0) {
                    calendar.gotoDate(selectedDates[0]);
                    calendar.changeView('timeGridDay');
                }
            }

        });
        // Handle the "Delete" button in the event modal
        var deleteEventButton = document.getElementById('deleteEventButton');
        deleteEventButton.addEventListener('click', function () {
            $('#eventModal').modal('hide');
        });
        // Handle the "edit" button in the event modal
        var deleteEventButton = document.getElementById('editEventButton');
        deleteEventButton.addEventListener('click', function () {
            $('#eventModal').modal('hide');
        });

        // Handle the delete confirmation
        var confirmDeleteButton = document.getElementById('confirmDeleteButton');
        confirmDeleteButton.addEventListener('click', function () {
            var confirmDeleteCheckbox = document.getElementById('confirmDeleteCheckbox');
            var id = document.getElementById('eventBookingId').value;

            var formData = new FormData();

            if (confirmDeleteCheckbox.checked) {
                formData.append('check', 1);
            } else {
                formData.append('check', 0);
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/booking/delete/" + id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Check if there are any deleted event IDs in the response
                    if (response.ids && response.ids.length > 0) {
                        for (var i = 0; i < response.ids.length; i++) {
                            var deletedEventId = response.ids[i];
                            var deletedEvent = calendar.getEventById(deletedEventId);
                            if (deletedEvent) {
                                deletedEvent.remove();
                            }
                        }
                        calendar.refetchEvents();
                    }

                    $('#confirmationModal').modal('hide');
                    $('#success_tic').modal('show');
                },

                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Handle the edit confirmation
        var editButton = document.getElementById('saveEdit');
        editButton.addEventListener('click', function () {

            var id = document.getElementById('eventBookingId').value;
            var editedTitle = $('#editTitle').val();
            var editedref = $('#editref').val();
            var editedNum = $('#editNum').val();
            var editedSession = $('#editSession').val();
            var editedPayment = $('#editPayment').val();
            var isChecked = $('#reservation_confirmed').is(':checked');
            var formData = new FormData();
            formData.append('BookingTitle', editedTitle);
            formData.append('Bookingref', editedref);
            formData.append('BookingNum', editedNum);
            formData.append('BookingSession', editedSession);
            formData.append('BookingPayment', editedPayment);
            formData.append('Bookingconfirmed', isChecked);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/booking/update/" + id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Check if there are any deleted event IDs in the response
                    if (response.ids && response.ids.length > 0) {
                        for (var i = 0; i < response.ids.length; i++) {
                            var editedEventId = response.ids[i];
                            var editedEvent = calendar.getEventById(editedEventId);

                            if (editedEvent) {
                                // Assuming the edited data is available in response.editedData
                                var editedEventData = response.editedData;
                                var editedpayment = response.totalPayments;
                                var editedpaymentrest = response.paymentRest;
                                // Update the event with edited data
                                editedEvent.setProp('title', editedEventData.client.team_name);
                                editedEvent.setProp('id', editedEventData.id);
                                editedEvent.setStart(editedEventData.reservation_date);
                                editedEvent.setExtendedProp('phone_number', editedEventData.client.phone_number);
                                editedEvent.setExtendedProp('reference', editedEventData.client.reference);
                                editedEvent.setExtendedProp('reservation_confirmed', editedEventData.client.reservation_confirmed);
                                editedEvent.setExtendedProp('session_number', editedEventData.client.session_number);
                                editedEvent.setExtendedProp('payment', editedpayment);
                                editedEvent.setExtendedProp('paymentRest', editedpaymentrest);


                                    if (editedEventData.client.reservation_confirmed) {
                                        editedEvent.setProp('backgroundColor', '#80FF90');
                                    } else {
                                        // Default color if not confirmed
                                        editedEvent.setProp('backgroundColor', '#D3D3D3');
                                    }
                                // editedEvent.setExtendedProp('stadium_choice', editedEventData.stadium.name);
                                // editedEvent.setExtendedProp('stadium_choiceid', editedEventData.stadium.id);
                                // editedEvent.setExtendedProp('price', editedEventData.client.price);

                                // You can update other properties as needed
                            }
                        }
                        calendar.refetchEvents();
                    }

                    $('#editModal').modal('hide');
                    $('#success_tic_edit').modal('show');
                    $('#error-message').text('');
                },

                error: function (xhr, status, error) {
                    // Handle error response and display error message
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Display the error message in the element with id 'error-message'
                        $('#error-message').text(xhr.responseJSON.message);
                    } else {
                        // Handle other types of errors
                        console.error(error);
                    }
                }
            });
        });
        var calendar = new FullCalendar.Calendar(calendarEl, {

            locale: 'fr',
            initialView: 'timeGridWeek',
            slotMinTime: '00:00:00',
            slotMaxTime: '24:00:00',

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // Adding listWeek here
            },
            events: @json($events),
            eventClick: function (info) {
                // Access the event's extendedProps to populate the modal
                var extendedProps = info.event.extendedProps;
                document.getElementById('eventTeamName').textContent = info.event.title;
                document.getElementById('eventTeamref').textContent = extendedProps.reference;
                document.getElementById('eventPhoneNumber').textContent = extendedProps.phone_number;
                document.getElementById('eventStadiumChoice').textContent = extendedProps.stadium_choice;
                document.getElementById('eventPrice').textContent = extendedProps.price;
                document.getElementById('eventPayment').textContent = extendedProps.payment;
                document.getElementById('eventPaymentRest').textContent = extendedProps.paymentRest;
                document.getElementById('eventsession').textContent = extendedProps.session_number;
                if (extendedProps.reservation_confirmed === 1) {
                    document.getElementById('eventReservation').textContent = "oui";
                } else {
                    document.getElementById('eventReservation').textContent = "non";
                }

                document.getElementById('eventBookingId').value = info.event.id;
                document.getElementById('editTitle').value = info.event.title;
                document.getElementById('editref').value = extendedProps.reference;
                document.getElementById('editNum').value = extendedProps.phone_number;
                document.getElementById('editSession').value = extendedProps.session_number;
                // Assuming extendedProps is an object with properties
                var reservationConfirmed = extendedProps.reservation_confirmed === 1;

                var checkbox = document.getElementById('reservation_confirmed');

                // Set checkbox state
                checkbox.checked = reservationConfirmed;
                // Show the Bootstrap modal
                var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                modal.show();
            },
            eventContent: function (info) {
                // Access the extendedProps of the event
                var extendedProps = info.event.extendedProps;

                // Check if the current view is listWeek
                if (info.view.type === 'listWeek' || info.view.type === 'timeGridDay') {
                    // Create a custom HTML content for the event
                    var extendedProps = info.event.extendedProps;
                    var content = '';

                    content += '<div class="event-title">' + info.event.title + ' , ';
                    content += 'Ref: ' + extendedProps.reference + ', ';
                    content += 'Num: ' + extendedProps.phone_number + ', ';
                    content += 'Stade: ' + extendedProps.stadium_choice + ', ';
                    if (extendedProps.reservation_confirmed === 1) {
                        content += 'Réservation confirmée: oui, ';
                    } else {
                        content += 'Réservation confirmée: non, ';
                    }
                    content += 'Prix: ' + extendedProps.price;
                    content += '</div>';

                    var div = document.createElement('div');
                    div.innerHTML = content;
                    return {domNodes: [div]};
                } else {
                    // For other views, return the default rendering
                    return info.event.title;
                }
            },

            eventDidMount: function (info) {
                var extendedProps = info.event.extendedProps;




                if (extendedProps.reservation_confirmed) {

                    info.el.style.backgroundColor = '#80FF90';
                } else {
                    // Default color if stadium_choice is not in mapping
                    info.el.style.backgroundColor = '#D3D3D3';
                }

            },

        });
        // Add an event listener for the change event on the stadium filter dropdown
        stadiumFilterDropdown.addEventListener('change', function () {
                var selectedStadium = stadiumFilterDropdown.value;

                calendar.getEvents().forEach(function (event) {
                    var eventStadium = event.extendedProps.stadium_choice;

                    if (selectedStadium === '' || eventStadium === selectedStadium) {
                        event.setProp('display', 'auto');
                    } else {
                        event.setProp('display', 'none');
                    }
                });
            });
// Apply filtering when the user types in the title filter input
        titleFilterInput.addEventListener('input', function () {
            var filterValue = titleFilterInput.value.toLowerCase();
            calendar.getEvents().forEach(function (event) {
                if (filterValue === '' || event.title.toLowerCase().includes(filterValue)) {
                    event.setProp('display', 'auto');
                } else {
                    event.setProp('display', 'none');
                }
            });
        });


        // Update rendering when the view changes
        calendar.on('viewDidMount', function (viewInfo) {
            if (viewInfo.view.type === 'listWeek') {
                calendar.render(); // Re-render the calendar to apply custom rendering
            }

        });


        calendar.render();


    });


</script>


@endsection

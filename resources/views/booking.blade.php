@extends('layout.master')

@section('main-content')
<!-- Your other content goes here -->


<div class="container pb-4">
    <h2>Réservation</h2>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('booking.submit') }}" method="post" class="mt-4">
        @csrf

        <div class="form-group">
            <label for="ref">Réference</label>
            <div style="max-width: 300px !important;">
                <div class="input-group" style="padding: 0 0 0 15px !important;">
                    <input class="form-control" style="width: 200px; text-align: center;" type="text" id="ref" name="ref"
                           placeholder="Scannez le code RFID"
                           required disabled>
                    <button class="btn btn-primary" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;" onclick="toggleRef()"><i
                            class="fa fa-credit-card" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="team_name">Nom de l'équipe</label>
            <input type="text" class="form-control" id="team_name" name="team_name" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Numéro de téléphone</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="reservation_confirmed" name="reservation_confirmed">
                <label class="form-check-label" for="reservation_confirmed">Réservation confirmée</label>
            </div>
        </div>
        <div class="form-group">
            <label for="subscription">Abonnement</label>
            <select class="form-control" id="subscription" name="subscription_id" required>
                <option value="" disabled selected>Choisissez un abonnement</option>
                @foreach($subscriptions as $subscription)
                <option data-subscription-frequency="{{ $subscription->subscriptionFrequency }}"
                        data-price="{{ $subscription->price }}"
                        value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- New div to display the subscription price -->
        <div id="subscriptionPrice" style="margin-top: 10px; font-weight: bold;"></div>
        <div id="paymentDiv" class="form-group" >
            <!-- Payment input will be dynamically added here -->
        </div>

        <div id="reservation_date_div"></div>
        <div id="reservation_time_div"></div>
        <div id="reservation_time_end_div"></div>


        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>
</div>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/material_red.css') }}">

<style>
    /* Customize Flatpickr appearance */
    .flatpickr {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        width: 200px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Adjust appearance on focus */
    .flatpickr:focus {
        border-color: #007bff;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
    }

</style>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('assets/js/fr.js') }}"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const subscriptionSelect = document.getElementById("subscription");
        const reservationDateDiv = document.getElementById("reservation_date_div");
        const reservationTimeDiv = document.getElementById("reservation_time_div");
        const reservationTimeEndDiv = document.getElementById("reservation_time_end_div");
        const subscriptionPriceDiv = document.getElementById("subscriptionPrice");
        const paymentDiv = document.getElementById("paymentDiv"); // New div for payment input

        subscriptionSelect.addEventListener("change", function () {
            const selectedOption = subscriptionSelect.options[subscriptionSelect.selectedIndex];
            const subscriptionFrequency = parseInt(selectedOption.getAttribute("data-subscription-frequency"));
            const subscriptionPrice = parseFloat(selectedOption.getAttribute("data-price")); // Get the price attribute

            // Display the subscription price
            if (subscriptionPrice) {
                subscriptionPriceDiv.textContent = "Prix de l'abonnement: " + subscriptionPrice + " DZD";
            } else {
                subscriptionPriceDiv.textContent = "";
            }

            // Clear previous elements
            reservationDateDiv.innerHTML = "";
            reservationTimeDiv.innerHTML = "";
            reservationTimeEndDiv.innerHTML = "";

            // Create new elements based on subscription frequency
            for (let i = 0; i < subscriptionFrequency; i++) {
                // Create the div for the date
                const dateDiv = document.createElement("div");
                dateDiv.className = "form-group";
                dateDiv.innerHTML = `
                <label for="reservation_date_${i}">Date de réservation n°${i + 1} :</label>
                <input type="text" class="flatpickr" id="reservation_date_${i}" name="reservation_date_${i}" required>
            `;
                reservationDateDiv.appendChild(dateDiv);

                // Create the div for the time with Flatpickr
                const timeDiv = document.createElement("div");
                timeDiv.className = "form-group";
                timeDiv.innerHTML = `
                <label for="reservation_time_${i}">Heure de début n°${i + 1} :</label>
                <input type="text" class="flatpickr" id="reservation_time_${i}" name="reservation_time_${i}" required>
            `;
                reservationTimeDiv.appendChild(timeDiv);

                // Initialize Flatpickr for the new time input
                flatpickr("#reservation_time_" + i, {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    locale: "fr",
                    onChange: function (selectedDates, dateStr, instance) {
                        const subs = document.getElementById("subscription");
                        const selectedValue = subs.value;
                        const index = this.input.id.split("_")[2];

                        const dateInput = document.getElementById(`reservation_date_${index}`);
                        const dateonly = dateInput.value;

                        getdate(dateStr, selectedValue, dateonly)
                            .then(function (response) {
                                const existingMessageDiv = document.getElementById("messageDiv");
                                if (existingMessageDiv) {
                                    existingMessageDiv.parentNode.removeChild(existingMessageDiv);
                                }

                                const messageDiv = document.createElement("div");
                                messageDiv.id = "messageDiv";

                                if (response.status === 'success') {
                                    messageDiv.textContent = response.message;
                                    messageDiv.style.color = "green";
                                } else {
                                    messageDiv.textContent = response.message;
                                    messageDiv.style.color = "red";
                                }

                                const labelForReservationTime = document.querySelector(`label[for="reservation_time_${i}"]`);
                                labelForReservationTime.parentNode.insertBefore(messageDiv, labelForReservationTime);
                            })
                            .catch(function (error) {
                                console.error("Error:", error);
                            });
                    }
                });

                // Create the div for the end time with Flatpickr
                const timeEndDiv = document.createElement("div");
                timeEndDiv.className = "form-group";
                timeEndDiv.innerHTML = `
                <label for="reservation_time_end_${i}">Heure de fin n°${i + 1} :</label>
                <input type="text" class="flatpickr" id="reservation_time_end_${i}" name="reservation_time_end_${i}" required>
            `;
                reservationTimeEndDiv.appendChild(timeEndDiv);

                // Initialize Flatpickr for the end time input
                flatpickr("#reservation_time_end_" + i, {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    locale: "fr",
                    onChange: function (selectedDates, dateStr, instance) {
                        const subs = document.getElementById("subscription");
                        const selectedValue = subs.value;
                        const index = this.input.id.split("_")[3];

                        const dateInput = document.getElementById(`reservation_date_${index}`);
                        const dateonly = dateInput.value;

                        getdate(dateStr, selectedValue, dateonly)
                            .then(function (response) {
                                const existingMessageDiv = document.getElementById("messageDivend");
                                if (existingMessageDiv) {
                                    existingMessageDiv.parentNode.removeChild(existingMessageDiv);
                                }

                                const messageDiv = document.createElement("div");
                                messageDiv.id = "messageDivend";

                                if (response.status === 'success') {
                                    messageDiv.textContent = response.message;
                                    messageDiv.style.color = "green";
                                } else {
                                    messageDiv.textContent = response.message;
                                    messageDiv.style.color = "red";
                                }

                                const labelForReservationTime = document.querySelector(`label[for="reservation_time_end_${i}"]`);
                                labelForReservationTime.parentNode.insertBefore(messageDiv, labelForReservationTime);
                            })
                            .catch(function (error) {
                                console.error("Error:", error);
                            });
                    }
                });

                // Initialize Flatpickr for the new date input
                flatpickr("#reservation_date_" + i, {
                    dateFormat: "Y-m-d",
                    locale: "fr",
                    onChange: function (selectedDates, dateStr, instance) {
                        const timeInput = document.getElementById(`reservation_time_${i}`);
                        const timeEndInput = document.getElementById(`reservation_time_end_${i}`);
                        timeInput._flatpickr.clear();
                        timeEndInput._flatpickr.clear();

                        const existingMessageDiv = document.getElementById("messageDiv");
                        if (existingMessageDiv) {
                            existingMessageDiv.parentNode.removeChild(existingMessageDiv);
                        }

                        const existingMessageDivEnd = document.getElementById("messageDivend");
                        if (existingMessageDivEnd) {
                            existingMessageDivEnd.parentNode.removeChild(existingMessageDivEnd);
                        }
                    }
                });
            }

            // Create and display the payment input
            const paymentInputDiv = document.createElement("div");
            paymentInputDiv.className = "form-group";
            paymentInputDiv.innerHTML = `
                <label for="payment_amount">Montant du paiement :</label>
                <input type="number" id="payment_amount" name="payment_amount" class="form-control" min="0" max="${subscriptionPrice}" >
                <div id="payment_error_message" style="color: red;"></div>
            `;
            paymentDiv.innerHTML = ""; // Clear any previous content
            paymentDiv.appendChild(paymentInputDiv);

            // Add an event listener to validate the payment input
            const paymentInput = document.getElementById("payment_amount");
            const paymentErrorMessage = document.getElementById("payment_error_message");
            paymentInput.addEventListener("input", function () {
                const value = parseFloat(this.value);
                if (value > subscriptionPrice) {
                    paymentErrorMessage.textContent = `Le montant ne peut pas dépasser ${subscriptionPrice} DZD.`;
                } else {
                    paymentErrorMessage.textContent = "";
                }
            });
        });

        function getdate(date, subs, dateonly) {
            return new Promise(function (resolve, reject) {
                var formData = new FormData();
                formData.append('date', dateonly);
                formData.append('time', date);
                formData.append('subscription_id', subs);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/booking/fetch_appointments",
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        resolve(response);
                    },
                    error: function (xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }
    });
</script>



<script>
    function toggleRef() {
        var inputField = document.getElementById('ref');

        // Function to handle keypress event
        function handleKeyPress(event) {
            // Check if Enter key is pressed and input length is 10
            if (event.key === 'Enter' || inputField.value.length === 10) {

                // Move to the "phone_number" input field
                var teamNameInput = document.getElementById('team_name');
                if (teamNameInput) {
                    setTimeout(() => {
                        teamNameInput.focus();
                    }, 0);
                }

                // Prevent the default behavior of the Enter key (form submission)
                event.preventDefault();
            }
        }

        if (inputField.disabled === true) {
            // Enable the input field and add the event listener
            inputField.disabled = false;
            setTimeout(() => {
                inputField.focus();
            }, 0);
            inputField.addEventListener('keypress', handleKeyPress);
        } else {
            // Disable the input field and remove the event listener
            inputField.disabled = true;
            inputField.removeEventListener('keypress', handleKeyPress);
            // You may choose to keep or remove the following line based on your requirements
            inputField.value = ''; // Empty the input field
        }
    }
</script>

@endsection

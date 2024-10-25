<style>

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0); /* Transparent background */
        z-index: 999;
    }

    .custom-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        max-width: 400px; /* Adjust the maximum width as needed */
        width: 100%;
        text-align: center;
    }

    .custom-modal p {
        margin-bottom: 20px;
    }

    .custom-modal button {
        padding: 10px 20px;
        background-color: #5c61f2;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
</style>

<div class="page-header">
    <div class="header-wrapper row m-0">
        <form class="form-inline search-full col" action="#" method="get">
            <div class="form-group w-100">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                               placeholder="Search Tivo .." name="q" title="" autofocus>
                        <div class="spinner-border Typeahead-spinner" role="status"><span
                                class="sr-only">Chargement...</span></div>
                        <i class="close-search" data-feather="x"></i>
                    </div>
                    <div class="Typeahead-menu"></div>
                </div>
            </div>
        </form>
        <div class="header-logo-wrapper col-auto p-0">
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
            <div class="logo-header-main"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                                                                                  src="{{ asset('assets/images/logo/logo2.png') }}" alt=""><img
                        class="img-fluid for-dark"
                        src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a></div>
        </div>

        <div class="left-header col horizontal-wrapper ps-0">
            <div class="left-menu-header">
                <div class="input-group" style="padding: 0 0 0 15px !important;">
                    <input class="form-control" style="width: 200px; text-align: center;" type="text" id="customInput" placeholder="Scannez le code RFID"
                           disabled>
                    <button class="btn btn-primary" onclick="toggleInput()"><i class="fa fa-credit-card" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>

        <div class="nav-right col-6 pull-right right-header p-0">
            <ul class="nav-menus">
                <li>

                </li>

                {{--
                <li class="serchinput">
                    <div class="serchbox"><i data-feather="search"></i></div>
                    <div class="form-group search-form">
                        <input type="text" placeholder="Search here...">
                    </div>
                </li>
                --}}

                {{--
                <li class="onhover-dropdown">
                    <div class="notification-box"><i data-feather="bell"></i></div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li><i data-feather="bell"> </i>
                            <h6 class="f-18 mb-0">Notifications</h6>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0"><i data-feather="truck"></i></div>
                                <div class="flex-grow-1">
                                    <p><a href="#">Delivery processing </a><span class="pull-right">6 hr</span>
                                    </p>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0"><i data-feather="file-text"></i></div>
                                <div class="flex-grow-1">
                                    <p><a href="#">Tickets Generated</a><span class="pull-right">1 hr</span></p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0"><i data-feather="send"></i></div>
                                <div class="flex-grow-1">
                                    <p><a href="#">Delivery Complete</a><span class="pull-right">45 min</span>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li><a class="btn btn-primary" href="javascript:void(0)">Check all notification</a></li>
                    </ul>
                </li>
                <li class="onhover-dropdown">
                    <div class="message"><i data-feather="message-square"></i></div>
                    <ul class="message-dropdown onhover-show-div">
                        <li><i data-feather="message-square"> </i>
                            <h6 class="f-18 mb-0">Messages</h6>
                        </li>
                        <li>
                            <div class="d-flex align-items-start">
                                <div class="message-img bg-light-primary"><img
                                        src="{{ asset('assets/images/user/3.jpg') }}" alt=""></div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0"><a href="#">Emay Walter</a></h5>
                                    <p>Lorem ipsum dolor sit amet...</p>
                                </div>
                                <div class="notification-right"><i data-feather="x"></i></div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-start">
                                <div class="message-img bg-light-primary"><img
                                        src="{{ asset('assets/images/user/6.jpg') }}" alt=""></div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0"><a href="#">Jason Borne</a></h5>
                                    <p>Lorem ipsum dolor sit amet...</p>
                                </div>
                                <div class="notification-right"><i data-feather="x"></i></div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-start">
                                <div class="message-img bg-light-primary"><img
                                        src="{{ asset('assets/images/user/10.jpg') }}" alt=""></div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0"><a href="#">Sarah Loren</a></h5>
                                    <p>Lorem ipsum dolor sit amet...</p>
                                </div>
                                <div class="notification-right"><i data-feather="x"></i></div>
                            </div>
                        </li>
                        <li><a class="btn btn-primary" href="#">Check Messages</a></li>
                    </ul>
                </li>
                --}}
                <li class="maximize"><a href="#!" onclick="toggleFullScreen()"><i data-feather="maximize-2"></i></a></li>
                {{--
                <li class="language-nav">
                    <div class="translate_wrapper">
                        <div class="current_lang">
                            <div class="lang"><i data-feather="globe"></i></div>
                        </div>
                        <div class="more_lang">
                            <div class="lang selected" data-value="en"><i class="flag-icon flag-icon-us"></i><span
                                    class="lang-txt">English<span> (US)</span></span></div>
                            <div class="lang" data-value="de"><i class="flag-icon flag-icon-de"></i><span
                                    class="lang-txt">Deutsch</span></div>
                            <div class="lang" data-value="es"><i class="flag-icon flag-icon-es"></i><span
                                    class="lang-txt">Espa&ntilde;ol</span></div>
                            <div class="lang" data-value="fr"><i class="flag-icon flag-icon-fr"></i><span
                                    class="lang-txt">Fran&ccedil;ais</span></div>
                            <div class="lang" data-value="pt"><i class="flag-icon flag-icon-pt"></i><span
                                    class="lang-txt">Portugu&ecirc;<span> (BR)</span></span></div>
                            <div class="lang" data-value="cn"><i class="flag-icon flag-icon-cn"></i><span
                                    class="lang-txt">&#x7B80;&#x4F53;&#x4E2D;&#x6587;</span></div>
                            <div class="lang" data-value="ae"><i class="flag-icon flag-icon-ae"></i><span
                                    class="lang-txt">&#x644;&#x639;&#x631;&#x628;&#x64A;&#x629; <span>
                                        (ae)</span></span></div>
                        </div>
                    </div>
                </li>
                --}}
                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>
                <li class="profile-nav onhover-dropdown">
                    <div class="account-user"><i data-feather="user"></i></div>
                    <ul class="profile-dropdown onhover-show-div" style="width: 220px !important;">
                        <li><a href="{{ route('profile.edit') }}"><i data-feather="user"></i><span>Mon compte</span></a></li>
                        {{--
                        <li><a href="#"><i data-feather="mail"></i><span>Inbox</span></a></li>
                        <li><a href="#"><i data-feather="settings"></i><span>Settings</span></a></li>
                        --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li><a href="{{route('logout')}}" onclick="event.preventDefault();
                            this.closest('form').submit();"><i data-feather="log-out"> </i><span>Se déconnecter</span></a></li>

                        </form>
                    </ul>
                </li>
            </ul>

            <!-- Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Modal Title</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <!-- Message will be displayed here -->
                            <div id="modalMessage"></div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">
                <div class="ProfileCard-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0">
                        <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                        <polygon points="12 15 17 21 7 21 12 15"></polygon>
                    </svg>
                </div>
                <div class="ProfileCard-details">
                    {{--
                    <div class="ProfileCard-realName">{{name}}</div>
                    --}}
                </div>
            </div>
        </script>
        <script class="empty-template" type="text/x-handlebars-template">
            <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>

        <!-- Add the custom modal HTML structure -->
        <div class="overlay" id="overlay"></div>
        <div class="custom-modal" id="customModal">
            <!-- Your modal content goes here -->
            <p id="modalContent"></p>
            <button onclick="closeCustomModal()">Fermer</button>
        </div>

        <script>
            function toggleInput() {
                var inputField = document.getElementById('customInput');

                // Function to handle keypress event
                function handleKeyPress(event) {
                    // Check if Enter key is pressed and input length is 10
                    if (event.key === 'Enter' || inputField.value.length === 10) {
                        // Remove the event listener to prevent multiple executions
                        inputField.removeEventListener('keypress', handleKeyPress);

                        var formData = new FormData();
                        formData.append('ref', inputField.value);

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: "/session/submit",
                            data: formData,
                            dataType: "json",
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                if (response.message) {
                                    // Open custom modal with the response message
                                    openCustomModal();
                                    document.getElementById('modalContent').innerText = response.message;

                                    // Hide the input field
                                    inputField.disabled = true;
                                    inputField.value = ''; // Empty the input field
                                }
                            },
                            error: function (xhr, status, error) {
                                // Add back the event listener on error
                                inputField.addEventListener('keypress', handleKeyPress);

                                // Handle error as needed
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    // Open custom modal with the error message
                                    openCustomModal();
                                    document.getElementById('modalContent').innerText = 'Error: ' + xhr.responseJSON.error;
                                    inputField.value = '';
                                    inputField.focus();
                                }
                            }
                        });
                    }
                }

                if (inputField.disabled === true) {
                    // Enable the input field and add the event listener
                    inputField.disabled = false;
                    inputField.focus();
                    inputField.addEventListener('keypress', handleKeyPress);
                } else {
                    // Disable the input field and remove the event listener
                    inputField.disabled = true;
                    inputField.value = ''; // Empty the input field
                    inputField.removeEventListener('keypress', handleKeyPress);
                }
            }

            // Functions for the custom modal
            function openCustomModal() {
                document.getElementById('customModal').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            }

            function closeCustomModal() {
                document.getElementById('customModal').style.display = 'none';
                document.getElementById('overlay').style.display = 'none';
                document.getElementById('customInput').focus();
            }
        </script>

    </div>
</div>

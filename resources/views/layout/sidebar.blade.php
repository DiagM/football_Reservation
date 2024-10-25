<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light"
                                                                          src="{{ asset('assets/images/logo/logo4.jpg') }}" alt="logo"
                                                                          style="width: 150px; height: 150px;"></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>

        <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}">
                <div class="icon-box-sidebar"><i data-feather="grid"></i></div>
            </a>
        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">

                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>

                    <li class="menu-box">
                        <ul>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('dashboard') }}"><i data-feather="home"> </i><span>Tableau de bord</span></a>
                            </li>

                            @role('BookingManage')
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('booking.index') }}"
                                                        style="padding-top: 30px"><i
                                        data-feather="credit-card"> </i><span>Réservation</span></a></li>

                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('booking.calendar') }}"><i
                                        data-feather="calendar"> </i><span>Agenda</span></a></li>
                            @endrole


                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('session.index') }}"><i
                                        data-feather="clock"> </i><span>Historique des séances</span></a></li>

                            @role('UserManage')
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('user.index') }}"><i
                                        data-feather="users"> </i><span>Utilisateurs</span></a></li>
                            @endrole

                            @role('SubscriptionManage')
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('subscription.index') }}"><i
                                        data-feather="shopping-bag"> </i><span>Types d'abonnements</span></a></li>
                            @endrole

                            @role('FundManage')
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('fund.index') }}"><i
                                        data-feather="dollar-sign"> </i><span>Recette</span></a></li>
                            @endrole

                            @role('StadiumManage')
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('stadium.index') }}"><i
                                        data-feather="copy"> </i><span>Stades</span></a></li>
                            @endrole

                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>

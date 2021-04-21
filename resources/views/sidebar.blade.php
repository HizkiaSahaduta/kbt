<div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">
                <div class="shadow-bottom"></div>

                {{-- <div class="profile-info">
                    <div class="user-info">
                        <img src="{{ asset('outside/assets/img/kindpng_1055656.png') }}" alt="avatar">
                        <h6 class="">
                            {{ Session::get('NAME1') }}
                            {{ Session::get('NAME2') }}
                            {{ Session::get('NAME3') }}
                        </h6>

                        @if(!Session::get('GROUPID'))
                        <p class="">
                            N/A
                        </p>
                        @else
                        <p class="">
                            {{ Session::get('GROUPID') }}
                        </p>
                        @endif
                    </div>
                </div> --}}


                <ul class="list-unstyled menu-categories ps">
                    <li class="menu">
                        <a href="javascript:void(0);" id="homeNav" data-active="true" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle" onclick="window.location.href='{{ url("home") }}'">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Home</span>
                            </div>
                            <div>
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> --}}
                            </div>
                        </a>
                    </li>

                    <li class="menu" id="SalesActivity">
                        <a href="#submenu3" data-toggle="collapse" class="dropdown-toggle" id="SalesActivityNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                                <span>Sales Activity</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="SalesActivityTreeView collapse submenu list-unstyled" id="submenu3" data-parent="#submenu3">

                            @if(session()->has('mnuTodayVisit'))
                            <li id="TodayVisit">
                                <a href="{{ url('TodayVisit') }}">
                                    Today Visit
                                </a>
                            </li>
                            @endif

                            @if(session()->has('mnuCustomerVisit'))
                            <li id="CustomerVisit">
                                <a href="{{ url('CustomerVisit') }}">
                                    Customer Visit
                                </a>
                            </li>
                            @endif

                            @if(session()->has('mnuActivityReport'))
                            <li id="ActivityReport">
                                <a href="{{ url('VisitReport') }}">
                                    Activity Report
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>


                    <li class="menu" id="DataAnalyze">
                        <a href="#submenu4" data-toggle="collapse" class="dropdown-toggle" id="DataAnalyzeNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                <span>Data Analyze</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="DataAnalyzeTreeView collapse submenu list-unstyled" id="submenu4" data-parent="#submenu4">

                            @if(session()->has('mnuMaterialAvailability'))
                            <li id='MaterialAvailability'>
                                <a href="{{ url('MaterialAvailability') }}">Material Availability</a>
                            </li>
                            @endif
                            
                            @if(session()->has('mnuPiutangReport'))
                            <li id='PiutangReport'>
                                <a href="{{ url('PiutangReport') }}">Piutang Report</a>
                            </li>
                            @endif

                            @if(session()->has('mnuDebReport'))
                            <li id='DebtReport'>
                                <a href="{{ url('DebtReport') }}">Debt Report</a>
                            </li>
                            @endif

                            @if(session()->has('mnuOrderReport'))
                            <li id='OrderReport'>
                                <a href="{{ url('OrderReport') }}">Order Report</a>
                            </li>
                            @endif

                        </ul>
                    </li>


                    <li class="menu" id="UserMgmt">
                        <a href="#submenu2" data-toggle="collapse" class="dropdown-toggle" id="UserMgmtNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span>User Management</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="UserMgmtTreeView collapse submenu list-unstyled" id="submenu2" data-parent="#submenu2">
                            @if(session()->has('mnuMyAccount'))
                            <li id='MyAccount'>
                                <a href="{{ url('MyAccount') }}">My Account</a>
                            </li>
                            @endif
                            @if(session()->has('mnuChangePass'))
                            <li id='ChangePass'>
                                <a href="{{ url('ChangePass') }}">Change Password</a>
                            </li>
                            @endif
                            @if(session()->has('mnuAddUser'))
                            <li id='AddUser'>
                                <a href="{{ url('AddUser') }}">Add User</a>
                            </li>
                            @endif
                            @if(session()->has('mnuAddSales'))
                            <li id='AddSales'>
                                <a href="{{ url('AddSales') }}">Add Sales</a>
                            </li>
                            @endif
                        </ul>
                    </li>



                    {{-- <li class="menu" id="Report">
                        <a href="#submenu1" data-toggle="collapse" class="dropdown-toggle" id="ReportNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span>KKA Report</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="ReportTreeView collapse submenu list-unstyled" id="submenu1" data-parent="#submenu1">
                            @if(session()->has('mnuDowntimeReport'))
                            <li id='DownTimeReport'>
                                <a href="{{ url('DownTimeReport') }}">Downtime Report</a>
                            </li>
                            @endif
                        </ul>
                    </li><li class="menu" id="Report">
                        <a href="#submenu1" data-toggle="collapse" class="dropdown-toggle" id="ReportNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span>KKA Report</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="ReportTreeView collapse submenu list-unstyled" id="submenu1" data-parent="#submenu1">
                            @if(session()->has('mnuDowntimeReport'))
                            <li id='DownTimeReport'>
                                <a href="{{ url('DownTimeReport') }}">Downtime Report</a>
                            </li>
                            @endif
                        </ul>
                    </li><li class="menu" id="Report">
                        <a href="#submenu1" data-toggle="collapse" class="dropdown-toggle" id="ReportNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span>KKA Report</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="ReportTreeView collapse submenu list-unstyled" id="submenu1" data-parent="#submenu1">
                            @if(session()->has('mnuDowntimeReport'))
                            <li id='DownTimeReport'>
                                <a href="{{ url('DownTimeReport') }}">Downtime Report</a>
                            </li>
                            @endif
                        </ul>
                    </li><li class="menu" id="Report">
                        <a href="#submenu1" data-toggle="collapse" class="dropdown-toggle" id="ReportNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span>KKA Report</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="ReportTreeView collapse submenu list-unstyled" id="submenu1" data-parent="#submenu1">
                            @if(session()->has('mnuDowntimeReport'))
                            <li id='DownTimeReport'>
                                <a href="{{ url('DownTimeReport') }}">Downtime Report</a>
                            </li>
                            @endif
                        </ul>
                    </li><li class="menu" id="Report">
                        <a href="#submenu1" data-toggle="collapse" class="dropdown-toggle" id="ReportNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span>KKA Report</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="ReportTreeView collapse submenu list-unstyled" id="submenu1" data-parent="#submenu1">
                            @if(session()->has('mnuDowntimeReport'))
                            <li id='DownTimeReport'>
                                <a href="{{ url('DownTimeReport') }}">Downtime Report</a>
                            </li>
                            @endif
                        </ul>
                    </li><li class="menu" id="Report">
                        <a href="#submenu1" data-toggle="collapse" class="dropdown-toggle" id="ReportNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span>KKA Report</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="ReportTreeView collapse submenu list-unstyled" id="submenu1" data-parent="#submenu1">
                            @if(session()->has('mnuDowntimeReport'))
                            <li id='DownTimeReport'>
                                <a href="{{ url('DownTimeReport') }}">Downtime Report</a>
                            </li>
                            @endif
                        </ul>
                    </li><li class="menu" id="Report">
                        <a href="#submenu1" data-toggle="collapse" class="dropdown-toggle" id="ReportNav">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span>KKA Report</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="ReportTreeView collapse submenu list-unstyled" id="submenu1" data-parent="#submenu1">
                            @if(session()->has('mnuDowntimeReport'))
                            <li id='DownTimeReport'>
                                <a href="{{ url('DownTimeReport') }}">Downtime Report</a>
                            </li>
                            @endif
                        </ul>
                    </li> --}}


                </ul>

            </nav>

        </div>

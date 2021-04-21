@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<link href="{{ asset('outside/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<style>
.widget-content-area {
  box-shadow: none !important; }

/* .badge {
  background: transparent; }

.badge-primary {
  color: #1b55e2;
  border: 2px dashed #1b55e2; }

.badge-warning {
  color: #e2a03f;
  border: 2px dashed #e2a03f; }

.badge-danger {
  color: #e7515a;
  border: 2px dashed #e7515a; }

.badge-success {
  color: #8dbf42;
  border: 2px dashed #8dbf42; }

.badge-info {
  color: #2196f3;
  border: 2px dashed #2196f3; } */


.badge {
    font-size: 9px;  
}

.table > thead > tr > th {
  color: #ffffff;
  font-weight: 700;
  font-size: 14px;
  letter-spacing: 1px;
  /* text-transform: uppercase; */
  background : #19547b;
}
.table > tbody > tr > td {
    font-size: 13px;
    font-weight: 600;
}

@media (max-width: 991px) {
    
    .table > tbody > tr > td {
        font-size: 11px;
    }

    .table > thead > tr > th {
        font-size: 11px;
    }

    div.dataTables_wrapper div.dataTables_info {
        font-size: 11px; 
    }
}
</style>
@endsection
{{-- Content CSS End--}}

{{-- Content Navbar Content Begin--}}
@section('navbar_content')
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Data Analyze</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('OrderReport') }}">OrderReport</a></li>
                        </ol>
                    </nav>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav flex-row ml-auto ">
			<li class="nav-item more-dropdown">
				<div class="dropdown  custom-dropdown-icon">
					<a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Hello, {{ Auth::user()->name1 }}</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">

                        @if(session()->has('mnuMyAccount'))
                        <a class="dropdown-item" data-value="UserProfile" href="{{ url('MyAccount') }}">My Account</a>
                        @endif

                        @if(session()->has('mnuMyAccount'))
                        <a class="dropdown-item" data-value="UserProfile" href="{{ url('ChangePass') }}">Change Password</a>
                        @endif

						<a class="dropdown-item" data-value="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log Out</a>
					</div>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>

				</div>
			</li>
        </ul>


    </header>
</div>
@endsection
{{-- Content Navbar Content End--}}


{{-- Content Page Begin--}}
@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Order Report Query</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">


                    <div class="form-row mb-6">

                        <div class="col-md-5 form-group">
                            <label class="text-dark">Office ID</label>
                            <select id='txtOfficeID' name='txtOfficeID' class="form-control select2">
                                @if( Session::get('GROUPID') == 'SALES' or Session::get('GROUPID') == 'KACAB' or Session::get('GROUPID') == 'REGION' )
                                    @if(isset($officeidlist))
                                        @foreach($officeidlist as $o)
                                        <option value='{{ trim($o->office_id) }}'>{{ $o->office }}</option>
                                        @endforeach
                                    @endif
                                @else
                                    @if(isset($officeidlist))
                                        <option></option>
                                        @foreach($officeidlist as $o)
                                        <option value='{{ trim($o->office_id) }}'>{{ $o->office }}</option>
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>

                        <div class="col-md-5 form-group">
                            <label class="text-dark">Salesman</label>
                            <small id="txtSalesmanBadge"></small>
                            <select id='txtSalesID' name='txtSalesID' class="form-control select2">
                            @if(isset($listsales))
                                @if( Session::get('GROUPID') == 'SALES')
                                    @foreach($listsales as $s)
                                        <option value='{{ $s->sales_id }}'>{{ $s->nama}}</option>
                                    @endforeach
                                @else
                                    <option></option>
                                    @foreach($listsales as $s)
                                    <option value='{{ $s->sales_id }}'>{{ $s->nama}}</option>
                                    @endforeach
                                @endif
                            @endif
                            </select>
                        </div>

                    </div>

                    <div class="form-row mb-6">
                        
                        <div class="col-md-4 form-group">
                            <label class="text-dark">OrderID</label>

                            @if( Session::get('GROUPID') == 'SALES')
                                @foreach($listsales as $s)
                                    <span class='shadow-none badge badge-success'> Sales: {{ $s->nama}}</span>
                                @endforeach
                            @else
                                <small id="txtOrderIDBadge"></small>
                            @endif

                            <select id='txtOrderID' name='txtOrderID' class="form-control select2">
                            <option></option>
                            @if(isset($listorderid))
                                @foreach($listorderid as $s)
                                    <option value='{{ $s->doc_id }}'>{{ $s->doc_id}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="text-dark" for="txtCustomer">Customer</label>
                            
                            @if( Session::get('GROUPID') == 'SALES')
                                @foreach($listsales as $s)
                                    <span class='shadow-none badge badge-success'> Sales: {{ $s->nama}}</span>
                                @endforeach
                            @else
                                <small id="txtCustomerBadge"></small>
                            @endif

                            <select id='txtCustomer' name='txtCustomer' class="form-control select2">
                            <option></option>
                            @if(isset($listcustomer))
                                @foreach($listcustomer as $s)
                                    <option value='{{ $s->customer_id }}'>{{ $s->nama}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>

                        <div class="col-md-2 form-group">
                            <label class="text-dark">Outstanding Order</label>
                            <select class="form-control select2" name="txtOutstanding" id="txtOutstanding">
                            <option value="Y" selected>Yes</option>
                            <option value="N">No</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-row mb-6">

                        <div class="form-group col-md-5">
                            <label class="text-dark">Start Date</label>
                            <input id="txtStart" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Choose Start Date">
                        </div>

                        <div class="form-group col-md-5">
                            <label class="text-dark">End Date</label>
                            <input id="txtEnd" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Choose End Date">
                        </div>
                        
                    </div>

                    <button class="btn btn-success mt-4" id="reset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        &nbsp;Reset Date
                    </button>

                    <button class="btn btn-primary mt-4" id="sent">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        &nbsp;Submit
                    </button>

                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="result1" style="display: none">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Query Result:</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="table-responsive">
                        
                        <table id="OrderReportHeader" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cust.Name</th>
                                    <th>Order</th>
                                    <th>PO</th>
                                    {{-- <th>AmtPay</th> --}}
                                    <th>OrdDate</th>
                                    <th>DueDate</th>
                                    <th>Sales</th>
                                    <th>Stat</th>
                                    <th>DtApprv</th>
                                    <th>DtClosed</th>
                                    <th>ShipTo</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                        </table>

                    </div>


                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="result2" style="display: none">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12" id="detailResult">
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <button class="btn btn-primary mb-2 mr-2" id="backButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        Back to Query Result
                    </button>
                    

                    <div class="table-responsive">

                        <table id="OrderReportDetail" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ItemNo</th>
                                    <th>SP</th>
                                    <th>Descr</th>
                                    <th>OrdQty</th>
                                    {{-- <th>OrdDeliv</th> --}}
                                    <th>OrdShip</th>
                                    <th>OrdRetur</th>
                                    <th>POQty</th>
                                    {{-- <th>POPrice</th> --}}
                                    <th>PORcv</th>
                                    <th>PORetur</th>
                                    <th>KKAOrd</th>
                                    <th>KKAPlan</th>
                                    <th>KKAProd</th>
                                    <th>KKAWh</th>
                                    <th>KKAShip</th>
                                    <th>KKARetur</th>
                                    <th>KKARplc</th>
                                    <th>KKAStat</th>
                                </tr>
                            </thead>
                        </table>

                    </div>


                </div>
            </div>
        </div>

    </div>
</div>

@endsection
{{-- Content Page End--}}

{{-- Content Page JS Begin--}}
@section('contentjs')

<script src="{{ asset('outside/plugins/flatpickr/flatpickr.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('outside/plugins/select2/select2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js" integrity="sha512-lOtDAY9KMT1WH9Fx6JSuZLHxjC8wmIBxsNFL6gJPaG7sLIVoSO9yCraWOwqLLX+txsOw0h2cHvcUJlJPvMlotw==" crossorigin="anonymous"></script>
<script>

function blockUI(){

    $.blockUI({
        message: '<span class="text-semibold"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin position-left"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg></i>&nbsp; Loading</span>',
        fadeIn: 100,
        overlayCSS: {
            backgroundColor: '#1b2024',
            opacity: 0.8,
            zIndex: 1200,
            cursor: 'wait'
        },
        css: {
            border: 0,
            color: '#fff',
            zIndex: 1201,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}

$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#ReportNav').attr('data-active','true');
    $('#ReportNav').attr('aria-expanded','true');
    $('.DataAnalyzeTreeView').addClass('show');
    $('#OrderReport').addClass('active');

    $('.select2').on('select2:open', function() {
        if (Modernizr.touch) {
            $('.select2-search__field').prop('focus', false);
        }
    });

    var f1 = flatpickr(document.getElementById('txtStart'), {
            dateFormat: "Ymd",
            disableMobile: "true",
    });

    var f2 = flatpickr(document.getElementById('txtEnd'), {
            dateFormat: "Ymd",
            disableMobile: "true",
    });


    $('#txtOfficeID').select2({
        placeholder: 'Choose Office',
        allowClear: true
    });

    $('#txtSalesID').select2({
        placeholder: 'Choose Sales',
        allowClear: true
    });

    $('#txtOrderID').select2({
        placeholder: 'Choose OrderID',
        allowClear: true
    });

    $('#txtCustomer').select2({
        placeholder: 'Choose Customer',
        allowClear: true
    });

    $('#txtOutstanding').select2({
        placeholder: 'Choose Outstanding Status',
        allowClear: true
    });

    $('#txtOfficeID').change(function(){

        var txtOfficeID = $(this).val();
        var sel = document.getElementById("txtOfficeID");
        var text = sel.options[sel.selectedIndex].text
        if(txtOfficeID) {

            $('#txtSalesmanBadge').html("<span class='shadow-none badge badge-success'> Office: "+text+"</span>")
            $.ajax({
                url: 'getSalesByOffice/id='+txtOfficeID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="txtSalesID"]').empty();
                        $('select[name="txtSalesID"]').append('<option></option>');          
                    $.each(data, function(index, element) {
                        $('select[name="txtSalesID"]').append('<option value="'+ element.sales_id +'">'+ element.nama +'</option>');
                    });
                }
            });
        }
        else
        {

            $('select[name="txtSalesID"]').empty();
            $('#txtSalesmanBadge').empty();
            @if(isset($listsales))
                @if( Session::get('GROUPID') == 'SALES')
                    @foreach($listsales as $s)
                        $('select[name="txtSalesID"]').append('<option value="{{ $s->sales_id }}">{{ $s->nama }}</option>');
                    @endforeach
                @else
                        $('select[name="txtSalesID"]').append('<option value=""></option>');
                    @foreach($listsales as $s)
                        $('select[name="txtSalesID"]').append('<option value="{{ $s->sales_id }}">{{ $s->nama }}</option>');
                    @endforeach
                @endif
            @endif
        }
    });

    $('#txtSalesID').change(function(){

        var txtSalesID = $('#txtSalesID').val();
        var txtOrderID = $("#txtOrderID").val();

        var sel1 = document.getElementById("txtSalesID");
        var text1 = sel1.options[sel1.selectedIndex].text

        var sel2 = document.getElementById("txtOrderID");
        var text2 = sel2.options[sel2.selectedIndex].text
 
        if (!txtSalesID) {

            $('#txtOrderIDBadge').empty();
            $('#txtCustomerBadge').empty();

            @if(isset($listorderid))
                $('select[name="txtOrderID"]').append('<option value=""></option>');
                @foreach($listorderid as $s)
                    $('select[name="txtOrderID"]').append('<option value="{{ $s->doc_id }}">{{ $s->doc_id}}</option>');
                @endforeach
            @endif

            @if(isset($listcustomer))
                $('select[name="txtCustomer"]').append('<option value=""></option>');
                @foreach($listcustomer as $s)
                    $('select[name="txtCustomer"]').append('<option value="{{ $s->customer_id }}">{{ $s->nama}}</option>');
                @endforeach
            @endif

        }

        if (txtSalesID && !txtOrderID) {

            $('#txtOrderIDBadge').html("<span class='shadow-none badge badge-success'> Sales: "+text1+"</span>");
            $('#txtCustomerBadge').html("<span class='shadow-none badge badge-success'> Sales: "+text1+"</span>");

            $.ajax({
                url: 'getOrderBySales/id='+txtSalesID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="txtOrderID"]').empty();
                        $('select[name="txtOrderID"]').append('<option></option>');          
                    $.each(data, function(index, element) {
                        $('select[name="txtOrderID"]').append('<option value="'+ element.doc_id +'">'+ element.doc_id +'</option>');
                    });
                }
            });

            $.ajax({
                url: 'getCustomerBySales/id='+txtSalesID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="txtCustomer"]').empty();
                        $('select[name="txtCustomer"]').append('<option></option>');          
                    $.each(data, function(index, element) {
                        $('select[name="txtCustomer"]').append('<option value="'+ element.customer_id +'">'+ element.nama +'</option>');
                    });
                }
            });

        }

        if (txtSalesID && txtOrderID) {

            $('#txtOrderIDBadge').html("<span class='shadow-none badge badge-success'> Sales: "+text1+"</span>")
            $('#txtCustomerBadge').html("<span class='shadow-none badge badge-success'> Sales: "+text1+", OrderID:"+text2+"</span>")

            $.ajax({
                url: 'getCustomerBySalesOrder/a='+txtSalesID+'&b='+txtOrderID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="txtCustomer"]').empty();
                        $('select[name="txtCustomer"]').append('<option></option>');          
                    $.each(data, function(index, element) {
                        $('select[name="txtCustomer"]').append('<option value="'+ element.customer_id +'">'+ element.nama +'</option>');
                    });
                }
            });
        }

    });

    $('#txtOrderID').change(function(){

        var txtSalesID = $('#txtSalesID').val();
        var txtOrderID = $("#txtOrderID").val();

        var sel1 = document.getElementById("txtSalesID");
        var text1 = sel1.options[sel1.selectedIndex].text

        var sel2 = document.getElementById("txtOrderID");
        var text2 = sel2.options[sel2.selectedIndex].text
 
        if (!txtSalesID) {

            $('#txtOrderIDBadge').empty();
            $('#txtCustomerBadge').empty();

            @if(isset($listorderid))
                $('select[name="txtOrderID"]').append('<option value=""></option>');
                @foreach($listorderid as $s)
                    $('select[name="txtOrderID"]').append('<option value="{{ $s->doc_id }}">{{ $s->doc_id}}</option>');
                @endforeach
            @endif

            @if(isset($listcustomer))
                $('select[name="txtCustomer"]').append('<option value=""></option>');
                @foreach($listcustomer as $s)
                    $('select[name="txtCustomer"]').append('<option value="{{ $s->customer_id }}">{{ $s->nama}}</option>');
                @endforeach
            @endif

        }

        if (txtSalesID && !txtOrderID) {

            $('#txtOrderIDBadge').html("<span class='shadow-none badge badge-success'> Sales: "+text1+"</span>");
            $('#txtCustomerBadge').html("<span class='shadow-none badge badge-success'> Sales: "+text1+"</span>");

            $.ajax({
                url: 'getOrderBySales/id='+txtSalesID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="txtOrderID"]').empty();
                        $('select[name="txtOrderID"]').append('<option></option>');          
                    $.each(data, function(index, element) {
                        $('select[name="txtOrderID"]').append('<option value="'+ element.doc_id +'">'+ element.doc_id +'</option>');
                    });
                }
            });

            $.ajax({
                url: 'getCustomerBySales/id='+txtSalesID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="txtCustomer"]').empty();
                        $('select[name="txtCustomer"]').append('<option></option>');          
                    $.each(data, function(index, element) {
                        $('select[name="txtCustomer"]').append('<option value="'+ element.customer_id +'">'+ element.nama +'</option>');
                    });
                }
            });

        }

        if (!txtSalesID && txtOrderID) {

            $('#txtOrderIDBadge').empty();
            $('#txtCustomerBadge').html("<span class='shadow-none badge badge-success'> OrderID:"+text2+"</span>")

            $.ajax({
                url: 'getCustomerByOrder/id='+txtOrderID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="txtCustomer"]').empty();
                        $('select[name="txtCustomer"]').append('<option></option>');          
                    $.each(data, function(index, element) {
                        $('select[name="txtCustomer"]').append('<option value="'+ element.customer_id +'">'+ element.nama +'</option>');
                    });
                }
            });

        }

        if (txtSalesID && txtOrderID) {

            $('#txtOrderIDBadge').html("<span class='shadow-none badge badge-success'> Sales: "+text1+"</span>")
            $('#txtCustomerBadge').html("<span class='shadow-none badge badge-success'> Sales: "+text1+", OrderID:"+text2+"</span>")

            $.ajax({
                url: 'getCustomerBySalesOrder/a='+txtSalesID+'&b='+txtOrderID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="txtCustomer"]').empty();
                        $('select[name="txtCustomer"]').append('<option></option>');          
                    $.each(data, function(index, element) {
                        $('select[name="txtCustomer"]').append('<option value="'+ element.customer_id +'">'+ element.nama +'</option>');
                    });
                }
            });
        }

    });

    $('#reset').on('click', function() {

        f1.clear();
        f2.clear();
    
    });

    $('#backButton').on('click', function() {

        result2.style.display = 'none';
        result1.style.display = 'block';
        
    });

    $('#sent').on('click', function() { 

        // event.preventDefault();
        blockUI();

        var txtOfficeID = $("#txtOfficeID").val();
        var txtSalesID = $("#txtSalesID").val();
        var txtOrderID = $("#txtOrderID").val();
        var txtCustomer = $("#txtCustomer").val();
        var txtOutstanding = $("#txtOutstanding").val();
        var txtStart = $("#txtStart").val();
        var txtEnd = $("#txtEnd").val();

        var dataTable = $('#OrderReportHeader').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search",
                "sLengthMenu": "Show :  _MENU_ entries",
                },
            // order: [ [0, 'desc'] ],
            stripeClasses: [],
            lengthMenu: [5, 10, 20, 50],
            pageLength: 10,
            destroy : true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                'url':'{!!url("getOrderReportHeader")!!}',
                'type': 'post',
                data: {
                        '_token': '{{ csrf_token() }}',
                        'txtOfficeID' : txtOfficeID,
                        'txtSalesID' : txtSalesID,
                        'txtOrderID' : txtOrderID, 
                        'txtCustomer' : txtCustomer, 
                        'txtOutstanding' : txtOutstanding,
                        'txtStart' : txtStart,
                        'txtEnd' : txtEnd 
                    }
            },
            columns: [

                {data: 'cust_name', name: 'cust_name'},
                {data: 'order_id', name: 'order_id'},
                {data: 'po_id', name: 'po_id'},
                // {data: 'amt_pay', name: 'amt_pay'},
                {data: 'dt_trans', name: 'dt_trans'},
                {data: 'due_date', name: 'due_date'},
                {data: 'salesman', name: 'salesman'},
                {data: 'stat', name: 'stat'},
                {data: 'dt_approved', name: 'dt_approved'},
                {data: 'dt_closed', name: 'dt_closed'},
                {data: 'ship_to', name: 'ship_to'},
                {data: 'Detail', name: 'Detail',orderable:false,searchable:false},

            ],
            initComplete: function(settings, json) {

                if (!dataTable.rows().data().length) {

                    $.unblockUI();

                    swal("Whops", "Data not available", "error");
                }

                else {

                    $.unblockUI();

                    result2.style.display = 'none';
                    result1.style.display = 'block';

                    $('html, body').animate({
                        scrollTop: $("#result1").offset().top
                    }, 1200)

                    
                }
            },
        });

    });

    $('body').on('click', '.detailOrder', function(e) {

        blockUI();

        var txtOrderID = $(this).data('id1');
        var txtPOID = $(this).data('id2');

        $('#detailResult').html("<h4>Detail of OrderID : "+txtOrderID+"</h4>");

        var dataTable = $('#OrderReportDetail').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search",
                "sLengthMenu": "Show :  _MENU_ entries",
                },
            // order: [ [0, 'desc'] ],
            stripeClasses: [],
            lengthMenu: [5, 10, 20, 50],
            pageLength: 10,
            destroy : true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                'url':'{!!url("getOrderReportDetail")!!}',
                'type': 'post',
                data: {
                        '_token': '{{ csrf_token() }}',
                        'txtOrderID' : txtOrderID,
                        'txtPOID' : txtPOID
                    }
            },
            columns: [
                {data: 'item_num', name: 'item_num'},
                {data: 'kka_sp', name: 'kka_sp'},
                {data: 'article_desc', name: 'article_desc'},
                {data: 'order_qty', name: 'order_qty'},
                // {data: 'order_deliv', name: 'order_deliv'},
                {data: 'order_shipped', name: 'order_shipped'},
                {data: 'order_retur', name: 'order_retur'},
                {data: 'po_qty', name: 'po_qty'},
                // {data: 'po_price', name: 'po_price'},
                {data: 'po_rcv', name: 'po_rcv'},
                {data: 'po_retur', name: 'po_retur'},
                {data: 'kka_order', name: 'kka_order'},
                {data: 'kka_plan', name: 'kka_plan'},
                {data: 'kka_prod', name: 'kka_prod'},
                {data: 'kka_wh', name: 'kka_wh'},
                {data: 'kka_ship', name: 'kka_ship'},
                {data: 'kka_retur', name: 'kka_returr'},
                {data: 'kka_replace', name: 'kka_replace'},
                {data: 'kka_stat', name: 'kka_stat'}
            ],
            initComplete: function(settings, json) {

                if (!dataTable.rows().data().length) {

                    $.unblockUI();

                    swal("Whops", "Data not available", "error");
                }

                else {

                    $.unblockUI();

                    result1.style.display = 'none';
                    result2.style.display = 'block';

                    $('html, body').animate({
                        scrollTop: $("#result2").offset().top
                    }, 1200)

                    
                }
            },
        });






    });

    @if(Session::get('GROUPID') == 'SALES')

        $('#txtSalesID').prop('disabled', true);
        $('#txtOfficeID').prop('disabled', true);

        $('#reset').on('click', function() {

            $('#txtCustomer').val(null).trigger('change');
            $('#txtOutstanding').val("Y").trigger('change');
            $('#txtCustomer').val(null).trigger('change');
            $('#txtOrderID').val(null).trigger('change');
            f1.clear();
            f2.clear();
            result1.style.display="none";
            result2.style.display="none";
        });

    @endif



});


</script>

@endsection
{{-- Content Page JS End--}}

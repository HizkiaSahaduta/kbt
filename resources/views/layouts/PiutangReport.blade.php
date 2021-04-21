@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')

<link rel="stylesheet" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />

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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('MyAccount') }}">My Account</a></li>
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

        <div class="col-lg-12 col-md-12 layout-spacing tSearch">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Piutang Report</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                    <div class="row">

                        <div class="col-md-4 form-group">
                            <p class="text-dark">Office ID <span class="badge badge-info badgeOffice" style="display: none;"></span></p>
                            <select id='txtOffID' name='txtOffID' class="form-control">
                            @if( Session::get('GROUPID') == 'SALES' or Session::get('GROUPID') == 'KACAB' )
                                @if(isset($office))
                                    @foreach($office as $office)
                                    <option value='{{ $office->office_id }}'>{{ trim($office->office) }}</option>
                                    @endforeach
                                @endif
                            @else
                                <option value=''>-- Office --</option>
                                @if(isset($office))
                                    @foreach($office as $office)
                                    <option value='{{ $office->office_id }}'>{{ trim($office->office) }}</option>
                                    @endforeach
                                @endif
                            @endif
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <p class="text-dark">Sales <span class="badge badge-info badgeSales" style="display: none;"></span></p>
                            <select id='txtSalesId' name='txtSalesId' class="form-control">
                            @if( Session::get('GROUPID') == 'SALES' )
                                @if(isset($sales))
                                    @foreach($sales as $sales)
                                    <option value='{{ $sales->sales_id }}'>{{ trim($sales->nama) }}</option>
                                    @endforeach
                                @endif
                            @else
                                <option value=''>-- Sales --</option>
                                @if(isset($sales))
                                    @foreach($sales as $sales)
                                    <option value='{{ $sales->sales_id }}'>{{ trim($sales->nama) }}</option>
                                    @endforeach
                                @endif
                            @endif
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <p class="text-dark">Customer</p>
                            <select class="txtCustomer form-control" style="width:100%;" id="txtCustomer" name="txtCustomer"></select>
                        </div>

                        <div class="col-md-6 form-group">
                            <p class="text-dark">Order ID</p>
                            <input type="text" class="form-control" id="txtOrderId" name="txtOrderId" placeholder="Enter Order ID" />
                        </div>

                        <div class="col-md-6 form-group">
                            <p class="text-dark">No. Faktur</p>
                            <input type="text" class="form-control" id="txtFaktur" name="txtFaktur" placeholder="No. Faktur" />
                        </div>

                        <div class="col-md-6 form-group">
                        <p class="text-dark">Start Date</p>
                            <input id="start" class="form-control flatpickr flatpickr-input active" type="text" style="width: 100%;" placeholder="Select start period">
                        </div>

                        <div class="col-md-6 form-group">
                        <p class="text-dark">End Date</p>
                            <input id="end" class="form-control flatpickr flatpickr-input active" type="text" style="width: 100%;" placeholder="Select end period">
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="new-control new-radio new-radio-text radio-primary">
                                <input type="radio" class="new-control-input" id="rdDateInv" name="radioDate" checked>
                                <span class="new-control-indicator"></span><span class="new-radio-content">Invoice Create Date</span>
                            </label>
                            <label class="new-control new-radio new-radio-text radio-primary">
                                <input type="radio" class="new-control-input" id="rdDueDate" name="radioDate">
                                <span class="new-control-indicator"></span><span class="new-radio-content">Invoice Due Date</span>
                            </label>
                        </div>

                        <div class="col-md-6 form-group">
                            <h5>SUMMARY</h5>
                            <p id="sumInv">Invoices Total : </p>
                            <p id="sumBill">Bill Total : </p>
                            <p id="sumPaid">Paid Total : </p>
                            <p id="sumRemain">Invoices Remaining : </p>
                        </div>

                        <div class="col-md-6 form-group">
                            <button type="submit" id="submit" class="btn btn-primary btn-block" >SUBMIT</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 layout-spacing tResult">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Result</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="PiutangReportTable">
                                <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Order No.</th>
                                    <th>Invoice</th>
                                    <th>Inv. Date</th>
                                    <th>Due Date</th>
                                    <th>Inv. Total</th>
                                    <th>Bill Total</th>
                                    <th>Paid</th>
                                    <th>Bill Remaining</th>
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

<script type="text/javascript" src="{{ asset('outside/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('outside/plugins/flatpickr/flatpickr.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
<script src="https://cdn.datatables.net/plug-ins/1.10.21/api/sum().js"></script>

<script>

$(".tResult").hide();

$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#ReportNav').attr('data-active','true');
    $('#ReportNav').attr('aria-expanded','true');
    $('.DataAnalyzeTreeView').addClass('show');
    $('#PiutangReport').addClass('active');

    var f1 = flatpickr(document.getElementById('start'), {
        dateFormat: "Ymd",
        disableMobile: "true",
        onReady: function ( dateObj, dateStr, instance ) {
        const $clear = $( '<div class="flatpickr-clear"><button class="btn-primary">Clear</button></div>' )
            .on( 'click', () => {
            instance.clear();
            instance.close();
            } )
            .appendTo( $( instance.calendarContainer ) );
        }
    });

    var f2 = flatpickr(document.getElementById('end'), {
        dateFormat: "Ymd",
        disableMobile: "true",
        onReady: function ( dateObj, dateStr, instance ) {
        const $clear = $( '<div class="flatpickr-clear"><button class="btn-primary">Clear</button></div>' )
                        .on( 'click', () => {
                        instance.clear();
                        instance.close();
                        } )
                        .appendTo( $( instance.calendarContainer ) );
        }
    });

    $("#txtCustomer").select2({
        placeholder: "Customer ID or Customer Name",
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: "{{ url('getCust') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                return {
                    text: item.customer_id + " || " + item.nama + " (" + item.alamat + ", " + item.city + ")" ,
                    id: item.customer_id
                }
                })
            };
            
            },
            cache: true
        }
    });

    $('#submit').on('click', function() {

    var rdStr = '';
    var block = $('.tSearch');
    $(block).block({ 
        message: '<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="64px" height="64px" viewBox="0 0 128 128" xml:space="preserve"><script type="text/ecmascript" xlink:href="//faviconer.net/jscripts/smil.user.js"/><g><circle cx="16" cy="64" r="16" fill="#f7f7f7" fill-opacity="1"/><circle cx="16" cy="64" r="16" fill="#fafafa" fill-opacity="0.67" transform="rotate(45,64,64)"/><circle cx="16" cy="64" r="16" fill="#fcfcfc" fill-opacity="0.42" transform="rotate(90,64,64)"/><circle cx="16" cy="64" r="16" fill="#fdfdfd" fill-opacity="0.2" transform="rotate(135,64,64)"/><circle cx="16" cy="64" r="16" fill="#fefefe" fill-opacity="0.12" transform="rotate(180,64,64)"/><circle cx="16" cy="64" r="16" fill="#fefefe" fill-opacity="0.12" transform="rotate(225,64,64)"/><circle cx="16" cy="64" r="16" fill="#fefefe" fill-opacity="0.12" transform="rotate(270,64,64)"/><circle cx="16" cy="64" r="16" fill="#fefefe" fill-opacity="0.12" transform="rotate(315,64,64)"/><animateTransform attributeName="transform" type="rotate" values="0 64 64;315 64 64;270 64 64;225 64 64;180 64 64;135 64 64;90 64 64;45 64 64" calcMode="discrete" dur="560ms" repeatCount="indefinite"></animateTransform></g></svg>',
        overlayCSS: {
            backgroundColor: '#000',
            opacity: 0.6,
            cursor: 'wait'
        },
        css: {
            border: 0,
            color: '#fff',
            padding: 0,
            backgroundColor: 'transparent'
        }
    });

    if($('#rdDateInv').is(':checked'))
    {
        rdStr = 'inv';
    }

    if($('#rdDueDate').is(':checked'))
    {
        rdStr = 'due';
    }

    $(".tResult").hide();

    $('#submit').attr('disabled', 'disabled');
    $('#submit').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin mr-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>Loading...');

    $("#PiutangReportTable").attr("style","display:none");

    var txtRegion = $("#txtRegion").val();
    var txtOffID = $("#txtOffID").val();
    var txtSalesId = $("#txtSalesId").val();
    var txtCustomer = $("#txtCustomer").val();
    var txtOrderId = $("#txtOrderId").val();
    var txtFaktur = $("#txtFaktur").val();
    var startDate = $("#start").val();
    var endDate = $("#end").val();

    $.ajax({
        url: "{{ url('invoiceSummary') }}",
        type: "POST",
        headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dataType: "json",
        data: {
                'txtOffID': txtOffID,
                'txtSalesId': txtSalesId,
                'txtCustomer': txtCustomer,
                'txtOrderId': txtOrderId,
                'txtFaktur': txtFaktur,
                'rdStr': rdStr,
                'startDate': startDate,
                'endDate': endDate
        },
        success:function(data) {

            $('#sumInv').html('Invoices Total : ' + data.summaryInv['totalFaktur']);
            $('#sumBill').html('Bill Total : ' + data.summaryInv['totalTagihan']);
            $('#sumPaid').html('Paid Total : ' + data.summaryInv['totalBayar']);
            $('#sumRemain').html('Invoices Remaining : ' + data.summaryInv['totalPiutang']);

        }
    });

        var dataTable = $('#PiutangReportTable').DataTable({
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 20,
            ajax: {
                url:"{{ url('find_invoices') }}",
                type: 'post',
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                'txtOffID': txtOffID,
                'txtSalesId': txtSalesId,
                'txtCustomer': txtCustomer,
                'txtOrderId': txtOrderId,
                'txtFaktur': txtFaktur,
                'rdStr': rdStr,
                'startDate': startDate,
                'endDate': endDate
                }
            },
            columns: [
                { data: 'NamaCustomer', name: 'NamaCustomer',orderable:false },
                { data: 'CustomerOrderNo', name: 'CustomerOrderNo',orderable:false },
                { data: 'faktur', name: 'faktur',orderable:false },
                { data: 'tglfaktur', name: 'tglfaktur',orderable:true },
                { data: 'TglJTempo', name: 'TglJTempo',orderable:true },
                { data: 'NominalFaktur', name: 'NominalFaktur',orderable:true },
                { data: 'tagihan', name: 'tagihan',orderable:true },
                { data: 'bayar', name: 'bayar',orderable:true },
                { data: 'piutang', name: 'piutang',orderable:true }
            ],
            initComplete: function(settings, json) {

                if (dataTable.rows().data().length) {
                    $(block).unblock();
                    $(".tResult").show();
                    $('#submit').removeAttr('disabled');
                    document.getElementById("submit").textContent = 'FIND';
                    swal("Done!", "Data loaded successfully", "success");
                    $("#PiutangReportTable").attr("style","");
                    }
                if (!dataTable.rows().data().length) {
                    $(block).unblock();
                    $(".tResult").hide();
                    $('#submit').removeAttr('disabled');
                    document.getElementById("submit").textContent = 'FIND';
                    swal("Oops! :(", "Data not available", "error");
                }

            },
        }); 

    });

});


</script>

@endsection
{{-- Content Page JS End--}}

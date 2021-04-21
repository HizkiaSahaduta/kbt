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
                                <p class="text-dark">Vendor</p>
                                <select id='txtVendor' name='txtVendor' class="form-control">
                                    <option value=''>-- Vendor Name --</option>
                                    @if(isset($vendor))
                                        @foreach($vendor as $vendor)
                                        <option value='{{ trim($vendor->vendor_id) }}'>{{ trim($vendor->vendor_name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div class="col-md-4 form-group">
                                <p class="text-dark">Currency Type</p>
                                <select id='txtCurrency' name='txtCurrency' class="form-control">
                                    <option value=''>-- Currency --</option>
                                    @if(isset($currency))
                                        @foreach($currency as $currency)
                                        <option value='{{ trim($currency->curr_id) }}'>{{ trim($currency->curr_id) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <button type="submit" id="submit" class="btn btn-primary btn-block" >SUBMIT</button>
                            </div>

                            <div class="col-md-12 form-group">
                                <h5>SUMMARY</h5>
                                <p id="sumInv">Invoices Total : </p>
                                <p id="sumKwit">Kwitansi Total : </p>
                                <p id="sumPaid">Paid Total : </p>
                                <p id="sumDebt">Debt Remaining : </p>
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
                            <table class="table table-striped table-hover" id="DebtReportTable">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Invoice</th>
                                        <th>Kwitansi</th>
                                        <th>Payment</th>
                                        <th>Debt</th>
                                        <th>Currency</th>
                                        <th>View Details</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                </div>
            </div>
        </div>

        <!-- modal -->
    <div class="modal fade" id="DebtModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl modalDtl" style="max-width: 90%;" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
                <div class="modal-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="DebtDetailTable">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Tr ID</th>
                                        <th>Invoice ID</th>
                                        <th>Inv. Date</th>
                                        <th>Pay Term</th>
                                        <th>Currency</th>
                                        <th>Sub Total</th>
                                        <th>Disc.</th>
                                        <th>PPN</th>
                                        <th>Total</th>
                                        <th>Kwitansi</th>
                                        <th>Paid</th>
                                        <th>Paid Disc.</th>
                                        <th>Debt Total.</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
    $('#DebtReport').addClass('active');

    $('#submit').on('click', function() {

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

        var txtVendor = $("#txtVendor").val();
        var txtCurrency = $("#txtCurrency").val();

        $.ajax({

            url: "{{ url('debt_summary') }}",
            type: "POST",
            headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dataType: "json",
            data: {
                    'txtVendor': txtVendor,
                    'txtCurrency': txtCurrency
            },
            success:function(data) {

                $('#sumInv').html('Invoices Total : ' + data[0].invoice);
                $('#sumKwit').html('Kwitansi Total : ' + data[0].kwitansi);
                $('#sumPaid').html('Paid Total : ' + data[0].payment);
                $('#sumDebt').html('Debt Remaining : ' + data[0].hutang);

            }

        });

        var dataTable = $('#DebtReportTable').DataTable({
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 20,
            ajax: {
                url:"{{ url('find_debt') }}",
                type: 'post',
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    'txtVendor': txtVendor,
                    'txtCurrency': txtCurrency
                }
            },
            columns: [
                { data: 'vendor_name', name: 'vendor_name',orderable:true },
                { data: 'invoice', name: 'invoice',orderable:true },
                { data: 'kwitansi', name: 'kwitansi',orderable:true },
                { data: 'payment', name: 'payment',orderable:true },
                { data: 'hutang', name: 'hutang',orderable:true },
                { data: 'curr_id', name: 'curr_id',orderable:true },
                { data: 'Actions', name: 'Actions',orderable:false,searchable:false,sClass:'text-center'}
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

    $('body').on('click', '#DebtDtails', function(e) {

        var table = $('#DebtDetailTable').DataTable();
        table.clear();
        var txtVendor = $(this).data('id');

        var dataTable = $('#DebtDetailTable').DataTable({
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 20,
            ajax: {
                url:"{{ url('debt_detail') }}",
                type: 'post',
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    'txtVendor': txtVendor
                }
            },
            columns: [
                { data: 'vendor_name', name: 'vendor_name',orderable:true },
                { data: 'tr_id', name: 'tr_id',orderable:true },
                { data: 'inv_id', name: 'inv_id',orderable:true },
                { data: 'dt_inv', name: 'dt_inv',orderable:true },
                { data: 'pay_term_desc', name: 'pay_term_desc',orderable:true },
                { data: 'curr_id', name: 'curr_id',orderable:true },
                { data: 'amt_subtotal', name: 'amt_subtotal',orderable:true },
                { data: 'amt_disc', name: 'amt_disc',orderable:true },
                { data: 'amt_ppn', name: 'amt_ppn',orderable:true },
                { data: 'amt_total', name: 'amt_total',orderable:true },
                { data: 'amt_kwitansi', name: 'amt_kwitansi',orderable:true },
                { data: 'amt_paid', name: 'amt_paid',orderable:true },
                { data: 'amt_paid_disc', name: 'amt_paid_disc',orderable:true },
                { data: 'hutang', name: 'hutang',orderable:true }
            ],
            initComplete: function(settings, json) {

                if (dataTable.rows().data().length) 
                {
                    $('#DebtModal').show('handleUpdate', function (e) {
                        dataTable.columns.adjust()
                        dataTable.responsive.recalc();
                    });
                }
                else
                {
                    swal("Oops! :(", "Data not available", "error");
                }

            },
        });

    });

});
</script>

@endsection
{{-- Content Page JS End--}}

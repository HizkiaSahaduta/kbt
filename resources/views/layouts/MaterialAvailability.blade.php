@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<style>
.widget-content-area {
  box-shadow: none !important; }

.badge {
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
  border: 2px dashed #2196f3; }

.table > thead > tr > th {
  color: #ffffff;
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 1px;
  text-transform: uppercase;
  background : #19547b;  }

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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('MaterialAvailability') }}">Material Availability</a></li>
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
                            <h4>Raw Material Availability</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">


                    <div class="form-row mb-6">
                        <div class="col-md-3 form-group">
                            <label class="text-dark">Mill ID</label>
                            <select id='txtMillID' name='txtMillID' class="form-control basic select2">
                            <option></option>
                            @if(isset($millname))
                            @foreach($millname as $mill)
                                <option value='{{ trim($mill->mill_id) }}'>{{ trim($mill->mill_name) }}</option>
                            @endforeach
                            @endif
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="text-dark">Material</label>
                            <select id='txtMaterial' name='txtOffID' class="form-control basic select2">
                            <option></option>
                            @if(isset($material))
                                @foreach($material as $o)
                                <option value='{{ trim($o->jenis) }}'>{{ trim($o->jenis) }}</option>
                                @endforeach
                            @endif    
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="text-dark">Grade ID</label>
                            <select id='txtGrade' name='txtGrade' class="form-control basic select2">
                            <option></option>
                            @if(isset($grade))
                                @foreach($grade as $g)
                                <option value='{{ trim($g->grade_id) }}'>{{ trim($g->grade_id) }}</option>
                                @endforeach
                            @endif    
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="text-dark">Color</label>
                            <select id='txtColor' name='txtColor' class="form-control basic select2">
                            <option></option>
                            @if(isset($color))
                                @foreach($color as $c)
                                <option value='{{ trim($c->NamaWarna) }}'>{{ trim($c->NamaWarna) }}</option>
                                @endforeach
                            @endif    
                            </select>
                        </div>
                    </div>

                    <div class="form-row mb-6">

                        <div class="col-md-3 form-group">
                            <label class="text-dark">Thickness</label>
                            <select id='txtThickness' name='txtThickness' class="form-control basic select2">
                            <option></option>
                            @if(isset($thickness))
                                @foreach($thickness as $t)
                                <option value='{{ trim($t->thick) }}'>{{ trim($t->thick) }}</option>
                                @endforeach
                            @endif    
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="text-dark">Width</label>
                            <select id='txtWidth' name='txtWidth' class="form-control basic select2">
                            <option></option>
                            @if(isset($width))
                                @foreach($width as $w)
                                <option value='{{ trim($w->width) }}'>{{ trim($w->width) }} mm</option>
                                @endforeach
                            @endif    
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="text-dark">Quality</label>
                            <select id='txtQuality' name='txtQuality' class="form-control basic select2">
                            <option></option>
                            @if(isset($quality))
                                @foreach($quality as $q)
                                <option value='{{ trim($q->quality_id) }}'>{{ trim($q->quality_id) }}</option>
                                @endforeach
                            @endif    
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="text-dark">Product</label>
                            <select id='txtProduct' name='txtProduct' class="form-control basic select2">
                                <option></option>
                                <option value='atap'>Roof</option>
                                <option value='truss'>Truss</option> 
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-4" id="reset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        &nbsp;Reset Form
                    </button>

                    <button type="submit" class="btn btn-primary mt-4" id="go">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        &nbsp;Submit
                    </button>

                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="result" style="display: none">
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
                        <table id="RawMat" class="table mb-4" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Grade</th>
                                    <th>Color</th>
                                    <th>Thickness</th>
                                    <th>Width</th>
                                    <th>On Hand</th>
                                    <th>Reserve</th>
                                    <th>Unrelease</th>
                                    <th>Avail</th>
                                    <th>PO</th>
                                    <th>Quality</th>
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

<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
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
    $('#MaterialAvailability').addClass('active');

    $('.select2').on('select2:open', function() {
        if (Modernizr.touch) {
            $('.select2-search__field').prop('focus', false);
        }
    });

    $('#txtMillID').select2({
        placeholder: 'Choose Mill',
        allowClear: true
    });

    $('#txtMaterial').select2({
        placeholder: 'Choose Material',
        allowClear: true
    });

    $('#txtGrade').select2({
        placeholder: 'Choose Grade',
        allowClear: true
    });

    $('#txtColor').select2({
        placeholder: 'Choose Color',
        allowClear: true
    });

    $('#txtThickness').select2({
        placeholder: 'Choose Thickness',
        allowClear: true
    });

    $('#txtWidth').select2({
        placeholder: 'Choose Width',
        allowClear: true
    });

    $('#txtQuality').select2({
        placeholder: 'Choose Quality',
        allowClear: true
    });

    $('#txtProduct').select2({
        placeholder: 'Choose Product',
        allowClear: true
    });

    $('#reset').on('click', function() {

        $('#txtMillID').val(null).trigger('change');
        $('#txtMaterial').val(null).trigger('change');
        $('#txtGrade').val(null).trigger('change');
        $('#txtColor').val(null).trigger('change');
        $('#txtThickness').val(null).trigger('change');
        $('#txtWidth').val(null).trigger('change');
        $('#txtQuality').val(null).trigger('change');
        $('#txtProduct').val(null).trigger('change');
        result.style.display="none";
    });

    $('#go').on('click', function() { 

        event.preventDefault();
        var txtMillID = $("#txtMillID").val();
        var txtMaterial = $("#txtMaterial").val();
        var txtGrade = $("#txtGrade").val();
        var txtColor = $("#txtColor").val();
        var txtThickness = $("#txtThickness").val();
        var txtWidth = $("#txtWidth").val();
        var txtQuality = $("#txtQuality").val();
        var txtProduct = $("#txtProduct").val();

        var allRequest = '';

        if (!txtMillID) {
            swal('Whops', 'Choose Mill first', 'error');
        }

        else {

            blockUI();

            allRequest = '&txtMillID='+txtMillID.trim();

            if (txtMaterial != ''){
                allRequest = allRequest+'&txtMaterial='+txtMaterial.trim();
            }
            if (txtGrade != ''){
                allRequest = allRequest+'&txtGrade='+txtGrade.trim();
            }
            if (txtColor != ''){
                allRequest = allRequest+'&txtColor='+txtColor.trim();
            }
            if (txtThickness != ''){
                allRequest = allRequest+'&txtThickness='+txtThickness.trim();
            }
            if (txtWidth != ''){
                allRequest = allRequest+'&txtWidth='+txtWidth.trim();
            }
            if (txtQuality != ''){
                allRequest = allRequest+'&txtQuality='+txtQuality.trim();
            }
            if (txtProduct != ''){
                allRequest = allRequest+'&txtProduct='+txtProduct.trim();
            }

            var dataTable = $('#RawMat').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search",
                "sLengthMenu": "Show :  _MENU_ entries",
                },
                stripeClasses: [],
                lengthMenu: [5, 10, 20, 50],
                pageLength: 10,
                destroy : true,
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    'url':'{!!url("find_mats")!!}'+'?'+allRequest,
                    'type': 'post',
                    'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                        { data: 'jenis', name: 'jenis',orderable:true},
                        { data: 'grade_id', name: 'grade_id',orderable:true},
                        { data: 'NamaWarna', name: 'NamaWarna',orderable:true},
                        { data: 'thick', name: 'thick',orderable:true},
                        { data: 'width', name: 'width',orderable:true},
                        { data: "Length_OnHand",
                            render: function ( data, type, row ) {
                                return row.Length_OnHand + ' m / ' + row.Wgt_OnHand + ' kg';
                            }
                        },
                        { data: "Length_Reserve",
                            render: function ( data, type, row ) {
                                return row.Length_Reserve + ' m / ' + row.Wgt_Kontrak + ' kg';
                            }
                        },
                        { data: "Length_unrelease",
                            render: function ( data, type, row ) {
                                return row.Length_unrelease + ' m / ' + row.Wgt_unrelease + ' kg';
                            }
                        },
                        { data: "Length_Avail",
                            render: function ( data, type, row ) {
                                return row.Length_Avail + ' m / ' + row.Wgt_Avail + ' kg';
                            }
                        },
                        { data: "Length_PO",
                            render: function ( data, type, row ) {
                                return row.Length_PO + ' m / ' + row.Wgt_po + ' kg';
                            }
                        },
                        { data: 'quality_id', name: 'quality_id',orderable:true}
                ],
                initComplete: function(settings, json) {
                    
                    if (dataTable.rows().data().length) {    
                        
                        $.unblockUI();
                        result.style.display = 'block';
                        $('html, body').animate({
                            scrollTop: $("#result").offset().top
                        }, 1200);
                    }
                    if (!dataTable.rows().data().length) {

                        $.unblockUI();
                        swal("Whops", "Data not available", "error");
                        $('html, body').animate({
                            scrollTop: $("#result").offset().top
                        }, 1200);
                        result.style.display = 'block';
                    }
                },
            });

        }

        





    });


});


</script>

@endsection
{{-- Content Page JS End--}}

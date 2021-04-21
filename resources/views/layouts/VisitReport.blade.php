@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')

{{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6gwySuHGQeor31FQ04ZYmNRgofOxf2yA"></script> --}}
<link href="{{ asset('outside/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<link href="{{ asset('outside/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
{{-- <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css"> --}}

<style>
.widget-content-area {
  box-shadow: none !important; }

#VisitReportTable .badge {
  background: transparent; }

#VisitReportTable .badge-primary {
  color: #1b55e2; }

#VisitReportTable .badge-warning {
  color: #e2a03f; }

#VisitReportTable .badge-danger {
  color: #e7515a;}

#VisitReportTable .badge-success {
  color: #8dbf42;}

#VisitReportTable .badge-info {
  color: #2196f3; }

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

    .modal-content .modal-header h5 {
        font-size: 16px;
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
                    <!-- <div class="page-title">
                        <h3>Blank Page</h3>
                    </div> -->

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Sales Activity</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('VisitReport') }}">Activity Report</li>
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

			<div class="col-lg-12 layout-spacing layout-spacing">
				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>Visit Report</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">

                        <div class="form-row mb-6"> 

                            <div class="form-group col-md-3">
                                <label class="text-dark">Office ID</label>
                                <select id='txtOffID' name='txtOffID' class="form-control">
                                    @if( Session::get('GROUPID') == 'SALES' or Session::get('GROUPID') == 'KACAB' or Session::get('GROUPID') == 'REGION' )
                                        @if(isset($officeidlist))
                                            @foreach($officeidlist as $o)
                                            <option value='{{ trim($o->office_id) }}'>{{ $o->office }}</option>
                                            @endforeach
                                        @endif
                                    @else
                                        @if(isset($officeidlist))
                                            <option value=''>-- OFFICE ID --</option>
                                            @foreach($officeidlist as $o)
                                            <option value='{{ trim($o->office_id) }}'>{{ $o->office }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="text-dark">Salesman</label>
                                <select id='salesid' name='salesid' class="form-control">
                                @if(isset($listsales))
                                    @if( Session::get('GROUPID') == 'SALES')
                                        @foreach($listsales as $s)
                                            <option value='{{ $s->sales_id }}'>{{ $s->nama}}</option>
                                        @endforeach
                                    @else
                                        <option value=''>-- SELECT SALES --</option>
                                        @foreach($listsales as $s)
                                        <option value='{{ $s->sales_id }}'>{{ $s->nama}}</option>
                                        @endforeach
                                    @endif
                                @endif
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                            <label class="text-dark">Date From</label>
                                <input id="start_date" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Start Date">
                            </div>

                            <div class="form-group col-md-3">
                            <label class="text-dark">Date To</label>
                                <input id="end_date" class="form-control flatpickr flatpickr-input active" type="text" placeholder="End Date">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-4" id="clearBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                            &nbsp;Clear Date
                        </button>

                        <button type="submit" class="btn btn-primary mt-4" id="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            &nbsp;Go
                        </button>
                    </div>

				</div>
            </div>

            <div class="col-lg-12 layout-spacing layout-spacing" id="result" style="display: none">
				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>Search Result :</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">


                        <div class="table-responsive">
                            <table class="table mb-4" style="width:100%" id="VisitReportTable">
                              <thead>
                                  <tr>
                                      <th>Customer Name</th>
                                      <th>Salesman</th>
                                      <th>Cust.Address</th>
                                      <th>Cust.City</th>
                                      <th>Tr.Date</th>
                                      <th>Activity</th>
                                      <th>Remark</th>
                                      <th>View Map</th>
                                  </tr>
                              </thead>
                            </table>
                          </div>

                    </div>
                </div>
            </div>
            

        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log Map</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="map_canvas" style="height:370px;"></div>

                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    Close</button>
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

<script type="text/javascript">


function showMap(lat, lng){

    $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='+lat+'&lon='+lng, function(data){
        
        var address = data.address.village +', '+ data.address.state_district +', '+ data.address.state;
        var container = L.DomUtil.get('map_canvas');
        if(container != null){
            container._leaflet_id = null;
        }

        var mymap = L.map('map_canvas').setView([lat, lng], 13);
        
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

        L.marker([lat, lng],
            {draggable: true,        // Make the icon dragable
            //title: 'Hover Text',     // Add a title
            opacity: 0.5}            // Adjust the opacity
            )
            .addTo(mymap)
            .bindPopup('<b>Your log location</b><br>'+address)
            .openPopup();

    });
}

$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#SalesActivityNav').attr('data-active','true');
    $('#SalesActivityNav').attr('aria-expanded','true');
    $('.SalesActivityTreeView').addClass('show');
    $("#ActivityReport").addClass("active");

    var f1 = flatpickr(document.getElementById('start_date'), {
            dateFormat: "Ymd",
            disableMobile: "true",
    });

    var f2 = flatpickr(document.getElementById('end_date'), {
            dateFormat: "Ymd",
            disableMobile: "true",
    });

    $("#clearBtn").click(function(){

        f1.clear();
        f2.clear();

    });

    $('#txtOffID').change(function(){
        var txtOffID = $(this).val();
        if(txtOffID) {
            $.ajax({
                url: 'getSalesByOffice/id='+txtOffID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                        $('select[name="salesid"]').empty();
                        $('select[name="salesid"]').append('<option value="">-- Sales ID --</option>');          
                    $.each(data, function(index, element) {
                        $('select[name="salesid"]').append('<option value="'+ element.sales_id +'">'+ element.nama +'</option>');
                    });
                }
            });
        }
        else
        {

            $('select[name="salesid"]').empty();
            @if(isset($listsales))
                @if( Session::get('GROUPID') == 'SALES')
                    @foreach($listsales as $s)
                        $('select[name="salesid"]').append('<option value="{{ $s->sales_id }}">{{ $s->nama }}</option>');
                    @endforeach
                @else
                        $('select[name="salesid"]').append('<option value="">-- SELECT SALES --</option>');
                    @foreach($listsales as $s)
                        $('select[name="salesid"]').append('<option value="{{ $s->sales_id }}">{{ $s->nama }}</option>');
                    @endforeach
                @endif
            @endif
            // $.ajax({
            //     url: 'getSalesByOffice/id=0',
            //     type: "GET",
            //     dataType: "json",
            //     success:function(data) {
			// 		$('select[name="salesid"]').empty();
			// 		$('select[name="salesid"]').append('<option value="">-- Sales ID --</option>');
            //         $.each(data, function(index, element) {
            //             $('select[name="salesid"]').append('<option value="'+ element.SalesId +'">'+ element.NamaSales +'</option>');
            //         });
            //     }
            // });
        }
    });

    $('#submit').on('click', function() {

        var block = $('.statbox');
        $(block).block({ 
            message: 'Please Wait...',
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

        var txtOffID = $("#txtOffID").val();
        var salesid = $("#salesid").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        var dataTable = $('#VisitReportTable').DataTable({
            "oLanguage": {
                        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Show :  _MENU_ entries",
                        },
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 20,
            "order": [[ 0, "desc" ]],
            ajax: {
                'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                'url':'{{ url("GetVisit") }}',
                'type': 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'txtOffID': txtOffID,
                    'salesid': salesid,
                    'start_date': start_date,
                    'end_date': end_date
                }
            },
            columns: [
                { data: 'namacustomer', name: 'namacustomer'},
                { data: 'nama', name: 'nama'},
                { data: 'alamat', name: 'alamat'},
                { data: 'city', name: 'city'},
                { data: 'tr_date', name: 'tr_date'},
                { data: 'Activity', name: 'Activity'},
                { data: 'remark', name: 'remark'},
                { data: 'ViewMap', name: 'ViewMap',orderable:false,searchable:false,sClass:'text-center'}
                ],
                initComplete: function(settings, json) {
                if (dataTable.rows().data().length) {
                    $(block).unblock();
                    // swal("Done!", "Data loaded successfully", "success");
                    result.style.display="block";
                    $('html, body').animate({
                        scrollTop: $("#result").offset().top
                    }, 1200);
                }
                if (!dataTable.rows().data().length) {
                    $(block).unblock();
                    swal("Oops! :(", "Data not available", "error");
                    result.style.display="block";
                }
            },
        }); 

        // alert(start);

    });

});





</script>

@endsection
{{-- Content Page JS End--}}

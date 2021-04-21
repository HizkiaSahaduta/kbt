@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('outside/fa/css/font-awesome.min.css') }}">
<link href="{{ asset('outside/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
<style>
.widget-content-area {
  box-shadow: none !important; }

#Sales .badge {
  background: transparent; }

#Sales .badge-primary {
  color: #1b55e2;
  border: 2px dashed #1b55e2; }

#Sales .badge-warning {
  color: #e2a03f;
  border: 2px dashed #e2a03f; }

#Sales .badge-danger {
  color: #e7515a;
  border: 2px dashed #e7515a; }

#Sales .badge-success {
  color: #8dbf42;
  border: 2px dashed #8dbf42; }

#Sales .badge-info {
  color: #2196f3;
  border: 2px dashed #2196f3; }
  
.table > thead > tr > th {
  color: #ffffff;
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 1px;
  text-transform: uppercase;
  background : #19547b;  
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
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">User Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('Add Sales') }}">Add Sales</a></li>
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
                            <h4>Form of Adding Sales</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">
                    <a href="javascript:void(0)" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addSales" id="genSalesID">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Add New Sales
                    </a>
                    <div class="table-responsive">
                        <table id="Sales" class="table mb-4" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sales ID</th>
                                    <th>Sales Name</th>
                                    <th>Status</th>
                                    <th>Division</th>
                                    <th>Office</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addSales" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">


                <div class="form-row mb-6">
                    <div class="form-group col-md-4">
                        <label for="txtSalesID">Sales ID</label>
                        <div id="txtSalesID_loading">
                        <input id="txtSalesID" type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtSalesCode">Sales Code</label>
                        <input id="txtSalesCode" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtDepartment">Department</label>
                        <div id="txtDepartment_loading">
                        <select class="form-control basic" name="txtDepartment" id="txtDepartment">
                            <option></option>
                            <option value="SALES">SALES</option>
                            <option value="KACAB">KACAB</option>
                            <option value="RM">RM</option>
                        </select>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-6">
                    <div class="form-group col-md-4"  id="region_name" style="display: none">
                        <label for="txtRegionName">Region Name</label>
                        <input id="txtRegionName" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-8" id="region_scope" style="display: none">
                        <label for="txtRegionScope">Region Scope</label>
                        <div id="txtRegionScope_loading">
                        <select class="form-control tagging" multiple="multiple" id="txtRegionScope" name="txtRegionScope[]">
                            <option></option>
                        </select>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-6">
                    <div class="form-group col-md-4">
                        <label for="txtSalesName">Sales Name</label>
                        <input id="txtSalesName" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtEmail">Email</label>
                        <input id="txtEmail" type="text" class="form-control">
                    </div>
                     <div class="form-group col-md-4">
                        <label for="txtPhone">Phone</label>
                        <input id="txtPhone" type="text" class="form-control only-numeric">
                    </div>
                </div>

                 <div class="form-row mb-6">
                    <div class="form-group col-md-4">
                        <label for="txtRegion">Region</label>
                        <div id="ttxtRegion_loading">
                        <select class="form-control basic" name="txtRegion" id="txtRegion">
                            <option></option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtCity">City</label>
                        <div id="txtCity_loading">
                        <select class="form-control basic" name="txtCity" id="txtCity">
                            <option></option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtDivision">Division</label>
                        <div id="txtDivision_loading">
                        <select class="form-control basic" name="txtDivision" id="txtDivision">
                            <option></option>
                        </select>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-6">
                    <div class="form-group col-md-12">
                        <label for="txtAddress">Address</label>
                        <input id="txtAddress" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-row mb-6">
                    <div class="form-group col-md-6">
                        <label for="txtSalesOffice">Sales Office</label>
                        <div id="txtSalesOffice_loading">
                        <select class="form-control basic" name="txtSalesOffice" id="txtSalesOffice">
                            <option></option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtBranchHead">Branch Head</label>
                        <div id="txtBranchHead_loading">
                        <select class="form-control basic" name="txtBranchHead" id="txtBranchHead">
                            <option></option>
                        </select>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-6">
                    <div class="form-group col-md-6">
                        <label for="txtBankAccount">Bank Account</label>
                        <div id="txtBankAccount_loading">
                        <select class="form-control basic" name="txtBankAccount" id="txtBankAccount">
                            <option></option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtAccountName">Account Number</label>
                        <input id="txtAccountName" type="text" class="form-control">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveSales">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Submit</button>
                <button class="btn" data-dismiss="modal">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editSales" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="preloader"></div>
            <div class="modal-header">
                <h5 class="modal-title">Edit Sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div id="editBody"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="editSaveUser">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Submit</button>
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

<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('outside/plugins/notification/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('outside/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('outside/plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
<script>

var return_first = function() {
    var tmp = null;
    $.ajax({
        'async': false,
        'type': "get",
        'global': false,
        'dataType': 'json',
        'url': 'https://x.rajaapi.com/poe',
        'success': function(data) {
            tmp = data.token;
        }
    });
    return tmp;
}();

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

function blockElement(block){

    $(block).block({
        message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
        centerX: 0,
        centerY: 0,
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            width: 35,
            top: '10px',
            left: '',
            right: '10px',
            bottom: 0,
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });

}

function listDept(){

    var block = $('#txtDepartment_loading');
    // blockElement(block);
    // $.ajax({
    //     type: "GET",
    //     dataType: "json",
    //     url: "{{url('listDeptSales')}}",
    //     success: function (data) {
    //         $(block).unblock();
    //         $('select[name="txtDepartment"]').empty();
    //         $('select[name="txtDepartment"]').prepend('<option></option>');
    //         $.each(data, function(index, element) {
    //         $('select[name="txtDepartment"]').append('<option value="'+element.group_id+'">'+element.group_id+'</option>');
    //         });
    //     }
    // });

    $('#txtDepartment').select2({
        dropdownParent: $('#addSales'),
        placeholder: 'Choose Department below',
        allowClear: true
    });

}

function listRegion(){

    var block = $('#txtRegion_loading');
    blockElement(block);
    $.ajax({
          url: 'https://x.rajaapi.com/MeP7c5ne' + window.return_first + '/m/wilayah/provinsi',
          type: 'GET',
          dataType: 'json',
          success: function(json) {
                if (json.code == 200) {
                    $(block).unblock();
                    $('select[name="txtRegion"]').empty();
                    $('select[name="txtRegion"]').prepend('<option></option>');
                        for (i = 0; i < Object.keys(json.data).length; i++) {
                            $('#txtRegion').append($('<option>').text(json.data[i].name).attr('value', json.data[i].id));
                        }

                    $('#txtRegion').select2({
                        dropdownParent: $('#addSales'),
                        placeholder: 'Choose Region below',
                        allowClear: true
                    });
              } else {

                    $('#txtCity').select2({
                        dropdownParent: $('#addSales'),
                        placeholder: 'Choose Region first',
                        allowClear: true
                    });
              }
          }
      });

}

function listCity(){

    // var block = $('#txtCity_loading');
    // blockElement(block);
    // $.ajax({
    //     type: "GET",
    //     dataType: "json",
    //     url: "{{url('listCitySales')}}",
    //     success: function (data) {
    //         $(block).unblock();
    //         $('select[name="txtCity"]').empty();
    //         $('select[name="txtCity"]').prepend('<option></option>');
    //         $.each(data, function(index, element) {
    //         $('select[name="txtCity"]').append('<option value="'+element.kota+'">'+element.kota+'</option>');
    //         });
    //     }
    // });

    $('#txtCity').select2({
        dropdownParent: $('#addSales'),
        placeholder: 'Choose Region first',
        allowClear: true
    });

}

function listDivision(){

    var block = $('#txtDivision_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listDivisionSales')}}",
        success: function (data) {
            $(block).unblock();
            $('select[name="txtDivision"]').empty();
            $('select[name="txtDivision"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtDivision"]').append('<option value="'+element.class+'">'+element.class+" || "+element.descr+'</option>');
            });
        }
    });

    $('#txtDivision').select2({
        dropdownParent: $('#addSales'),
        placeholder: 'Choose Division below',
        allowClear: true
    });

}

function listSalesOffice(){

    var block = $('#txtSalesOffice_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listSalesOffice')}}",
        success: function (data) {
            $(block).unblock();
            $('select[name="txtSalesOffice"]').empty();
            $('select[name="txtSalesOffice"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtSalesOffice"]').append('<option value="'+element.office_id+'">'+element.office_id+" || "+element.office+'</option>');
            });
        }
    });

    $('#txtSalesOffice').select2({
        dropdownParent: $('#addSales'),
        placeholder: 'Choose Office below',
        allowClear: true
    });

}

function listBank(){

    var block = $('#txtBankAccount_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listBankSales')}}",
        success: function (data) {
            $(block).unblock();
            $('select[name="txtBankAccount"]').empty();
            $('select[name="txtBankAccount"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtBankAccount"]').append('<option value="'+element.bank_name+'">'+element.bank_name+'</option>');
            });
        }
    });

    $('#txtBankAccount').select2({
        dropdownParent: $('#addSales'),
        placeholder: 'Choose Bank below',
        allowClear: true
    });

}

function listBranchHeadEmpty(){

    $('#txtBranchHead').select2({
        dropdownParent: $('#addSales'),
        placeholder: 'Choose Sales Office first',
        allowClear: true
    });

}

function listBranchHead(id){

    var block = $('#txtBranchHead_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listBranchHead/id=')}}"+id,
        success: function (data) {
            $(block).unblock();
            $('select[name="txtBranchHead"]').empty();
            $('select[name="txtBranchHead"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[name="txtBranchHead"]').append('<option value="'+element.ka_cab+'">'+element.namasales+'</option>');
            });
        }
    });

    $('#txtBranchHead').select2({
        dropdownParent: $('#addSales'),
        placeholder: 'Choose Branch Head below',
        allowClear: true
    });

}

function listOfficeRegion(){

    var block = $('#txtRegionScope_loading');
    blockElement(block);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('listSalesOffice')}}",
        success: function (data) {
            $(block).unblock();
            $('select[id="txtRegionScope"]').empty();
            $('select[id="txtRegionScope"]').prepend('<option></option>');
            $.each(data, function(index, element) {
            $('select[id="txtRegionScope"]').append('<option value="'+element.office_id+'">'+element.office_id+" || "+element.office+'</option>');
            });
        }
    });

    $('#txtRegionScope').select2({
        dropdownParent: $('#addSales'),
        placeholder: 'Choose Office below',
        tags: true
    });

}


$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#UserMgmtNav').attr('data-active','true');
    $('#UserMgmtNav').attr('aria-expanded','true');
    $('.UserMgmtTreeView').addClass('show');
    $('#AddSales').addClass('active');

    var region_name = document.getElementById("region_name");
    var region_scope = document.getElementById("region_scope");

    listDept(); listRegion(); listCity(); listDivision(); listSalesOffice(); listBank(); listBranchHeadEmpty(); listOfficeRegion();

    $('#genSalesID').on('click', function() {

        var block = $('#txtSalesID_loading');
        blockElement(block);

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('genSalesId')}}",
                success: function (data) {
                    $(block).unblock();
                    $.each(data, function(index, element) {
                        document.getElementById("txtSalesID").value = element.lastnum;
                    });
                }
        });

    });
    
    $('#txtSalesID').on('blur',function(){

        var id = $('#txtSalesID').val();

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('checkSalesId/id=')}}"+id,
            success: function (data) {

                if (data.length > 0) { 

                    swal({
                        title: "Whops!",
                        text: "SalesId ''"+id+"'' already registered, pls use another SalesId",
                        type: "error"
                    }).then(function() {
                        $('#txtSalesID').val('');
                    });
                
                }
            }
        });

        // alert(id);

    });

    $('#txtDepartment').change(function(){

        var id = $('#txtDepartment').val();

        if(id == 'KACAB'){

            region_name.style.display = 'none';
            region_scope.style.display = 'none';
            $('#txtDivision').select2("enable",false);
        }
        else if(id == 'RM'){

            region_name.style.display = 'block';
            region_scope.style.display = 'block';
            $('#txtDivision').select2("enable",false);
        }
        else{

            region_name.style.display = 'none';
            region_scope.style.display = 'none';
            $('#txtDivision').select2("enable");

        }


    });

    $('#txtRegionScope').change(function(){
        var a = $("#txtRegionScope").val();
        var index = a.length-1;

        var sel = document.getElementById("txtRegionScope");
        var text= sel.options[sel.selectedIndex].text;

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('checkRegion/id=')}}"+a[index],
            success: function (data) {

                if (data.length > 0) { 
                    swal("Whops","RM: "+data+" already registered to "+text,"error")
                }
            }
        });
    });

    $("#txtEmail").inputmask(
        {
            mask:"*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy:!1,onBeforePaste:function(m,a){return(m=m.toLowerCase()).replace("mailto:","")},
            definitions:{"*":
                {
                    validator:"[0-9A-Za-z!#$%&'*+/=?^_`{|}~-]",
                    cardinality:1,
                    casing:"lower"
                }
            }
        }
    )
    
    $(".only-numeric").bind("keypress", function (e) {
        var keyCode = e.which ? e.which : e.keyCode

        if (!(keyCode >= 48 && keyCode <= 57)) {
            swal('whops', 'Please input numeric only', 'error');
            return false;
        }
    });

    $('#txtRegion').change(function(){
        var id = $("#txtRegion").val();
        var block = $('#txtCity_loading');
        blockElement(block);

        if (id) {

            $.ajax({
              url: 'https://x.rajaapi.com/MeP7c5ne' + window.return_first + '/m/wilayah/kabupaten',
              data: "idpropinsi=" +id,
              type: 'GET',
              cache: false,
              dataType: 'json',
              success: function(json) {
                if (json.code == 200) {
                    
                    $(block).unblock();
                    $('select[name="txtCity"]').empty();
                    $('select[name="txtCity"]').prepend('<option></option>');
                        for (i = 0; i < Object.keys(json.data).length; i++) {
                            $('#txtCity').append($('<option>').text(json.data[i].name).attr('value', json.data[i].nama));
                        }

                    $('#txtCity').select2({
                        dropdownParent: $('#addSales'),
                        placeholder: 'Choose City below',
                        allowClear: true
                    });
                }
              }
          });

        }
        else {
            $(block).unblock();
            $('select[name="txtCity"]').empty();
            $('select[name="txtCity"]').prepend('<option></option>');
            listCity();
        }
 
    });

    $('#txtSalesOffice').change(function(){

        var id = $('#txtSalesOffice').val();
        $('select[name="txtBranchHead"]').empty();

        if(id)  {
            listBranchHead(id);
        }
        else{
            listBranchHeadEmpty();
        }

    });

    var dataTable = $('#Sales').DataTable({
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
            'url':'{!!url("listSales")!!}',
            'type': 'post',
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
            {data: 'sales_id', name: 'sales_id'},
            {data: 'nama', name: 'nama'},
            {data: 'active_flag', name: 'active_flag'},
            {data: 'descr', name: 'descr'},
            {data: 'office', name: 'office'}
            // {data: 'Detail', name: 'Detail',orderable:false,searchable:false}
        ],
        initComplete: function(settings, json) {

            if (!dataTable.rows().data().length) {

                swal("Whops", "Data not available", "error");
            }
        },
    });

    $('#saveSales').on('click', function() {

        event.preventDefault();
        var txtSalesID = $('#txtSalesID').val();
        var txtSalesCode = $('#txtSalesCode').val();
        var txtDepartment = $('#txtDepartment').val();
        var txtSalesName = $('#txtSalesName').val();
        var txtEmail = $('#txtEmail').val();
        var txtPhone = $('#txtPhone').val();
        var sel = document.getElementById("txtRegion");
        var txtRegion = sel.options[sel.selectedIndex].text;
        var txtCity = $('#txtCity').val();
        var txtDivision = $('#txtDivision').val();
        var txtAddress = $('#txtAddress').val();
        var txtSalesOffice = $('#txtSalesOffice').val();
        var txtBranchHead = $('#txtBranchHead').val();
        var txtBankAccount = $('#txtBankAccount').val();
        var txtAccountName = $('#txtAccountName').val();
        var txtRegionName = $("#txtRegionName").val();
        var txtRegionScope = $("#txtRegionScope").val();

        if (!txtSalesID && !txtDepartment) {
            swal("Whops", "SalesId & Department must be filled!", "error");
        }
        else if (txtSalesID && !txtDepartment) {
            swal("Whops", "Department must be filled!", "error");
        }
        else if (!txtSalesID && txtDepartment) {
            swal("Whops", "SalesId must be filled!", "error");
        }
        else {

            blockUI();

            // alert(txtSalesID);

            $.ajax({
                type: "POST",
                url: "{{ url('saveSales') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'txtSalesID':txtSalesID,
                    'txtSalesCode':txtSalesCode,
                    'txtDepartment':txtDepartment,
                    'txtSalesName':txtSalesName,
                    'txtEmail':txtEmail,
                    'txtPhone':txtPhone,
                    'txtCity':txtCity,
                    'txtDivision':txtDivision,
                    'txtRegion':txtRegion,
                    'txtAddress':txtAddress,
                    'txtSalesOffice':txtSalesOffice,
                    'txtBranchHead':txtBranchHead,
                    'txtBankAccount':txtBankAccount,
                    'txtAccountName' :txtAccountName,
                    'txtRegionName' :txtRegionName,
                    'txtRegionScope' :txtRegionScope
                },
                success: function(data) {
                    if ((data['response']) == 'Sales Added') {

                        $('#txtSalesID').val('');
                        $('#txtSalesCode').val('');
                        $('#txtDepartment').val(null).trigger('change');
                        $('#txtSalesName').val('');
                        $('#txtEmail').val('');
                        $('#txtPhone').val('');
                        $('#txtCity').val(null).trigger('change');
                        $('#txtDivision').val(null).trigger('change');
                        $('#txtRegion').val(null).trigger('change');
                        $('#txtAddress').val('');
                        $('#txtSalesOffice').val(null).trigger('change');
                        $('#txtBranchHead').val(null).trigger('change');
                        $('#txtBankAccount').val(null).trigger('change');
                        $('#txtAccountName').val('');
                        $('#txtRegionName').val('');
                        $('#txtRegionScope').val(null).trigger('change');

                        $.unblockUI();

                        $('#addSales').modal('hide');

                        $('#Sales').DataTable().ajax.url('listSales').load();

                        Snackbar.show({
                            text: data['response'],
                            pos: 'top-center'
                        });


                    } else {

                        $('#txtSalesID').val('');
                        $('#txtSalesCode').val('');
                        $('#txtDepartment').val(null).trigger('change');
                        $('#txtSalesName').val('');
                        $('#txtEmail').val('');
                        $('#txtPhone').val('');
                        $('#txtCity').val(null).trigger('change');
                        $('#txtDivision').val(null).trigger('change');
                        $('#txtRegion').val(null).trigger('change');
                        $('#txtAddress').val('');
                        $('#txtSalesOffice').val(null).trigger('change');
                        $('#txtBranchHead').val(null).trigger('change');
                        $('#txtBankAccount').val(null).trigger('change');
                        $('#txtAccountName').val('');
                        $('#txtRegionName').val('');
                        $('#txtRegionScope').val(null).trigger('change');

                        $.unblockUI();

                        swal("Error", (data['response']), "error");

                    }
                }
            });
        }


    });

    $('body').on('click', '.editSales', function(e) {

        id = $(this).data('id1');
        id2 = $(this).data('id2');

        blockUI();

        $.ajax({
                url: "{{url('getUser/id=')}}"+id+ "&id2=" +id2,
                method: 'GET',
                success: function(result) {

                    $.unblockUI();
                    $('#editBody').html(result.html);
              }
          });

    });

    // $('body').on('click', '.delSales', function(e) {

    //     id = $(this).data('id1');
    //     id2 = $(this).data('id2');

    //     const swalWithBootstrapButtons = swal.mixin({
    //     confirmButtonClass: 'btn btn-primary',
    //     cancelButtonClass: 'btn btn-danger mr-3',
    //     buttonsStyling: false,
    //     })

    //     swalWithBootstrapButtons({
    //         title: 'Are you sure?',
    //         text: "Delete "+id2,
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Sure, go ahead',
    //         cancelButtonText: 'Nope',
    //         reverseButtons: true,
    //         padding: '2em'
    //     }).then(function(result) {
    //             if (result.value) {

    //                 blockUI();

    //                 $.ajax({
    //                     url: "{{url('delUser/id=')}}"+id+ "&id2=" +id2,
    //                     method: 'GET',
    //                     success: function(data) {

    //                         if ((data['response']) == 'User Deleted') {

    //                             $.unblockUI();

    //                             Snackbar.show({
    //                                 text: data['response'],
    //                                 pos: 'top-center'
    //                             });

    //                             $('#User').DataTable().ajax.url('listUser').load();


    //                         } else {

    //                             $.unblockUI();

    //                             swal("Error", (data['response']), "error");

    //                         }

    //                     }
    //                 });

    //             } else if (result.dismiss === swal.DismissReason.cancel) {
    //                 swalWithBootstrapButtons(
    //                     "Cancelled",
    //                     "Cancel Delete "+id2,
    //                     "error"
    //                 )
    //             }
    //         })

    // });

    // $('#editSaveSales').on('click', function() {

    //     event.preventDefault();
    //     var id = $('#id').val();
    //     var user_id = $('#edit_user_id').val();
    //     var user_pass = $('#edit_user_pass').val();
    //     var name1 = $('#edit_name1').val();
    //     var name2 = $('#edit_name2').val();
    //     var name3 = $('#edit_name3').val();
    //     var plant = $('#edit_plant').val();
    //     var division = $('#edit_division').val();
    //     var dept = $('#edit_dept').val();
    //     var section = $('#edit_section').val();
    //     var position = $('#edit_position').val();

    //     var e = document.getElementById("edit_flag");
    //     var flag = e.options[e.selectedIndex].value;

    //     if (!user_id) {
    //         swal("Whops", "User ID must be filled!", "error");
    //     }
    //     if (!user_pass) {
    //         swal("Whops", "User Pass must be filled!", "error");
    //     }
    //     if (!user_id && !user_pass) {
    //         swal("Whops", "User ID and User Pass must be filled!", "error");
    //     }

    //     if (user_id && user_pass) {

    //         blockUI();

    //         $.ajax({
    //             type: "POST",
    //             url: "{{ url('editUser') }}",
    //             data: {
    //                 '_token': '{{ csrf_token() }}',
    //                 'id': id,
    //                 'user_id2': user_id,
    //                 'user_pass': user_pass,
    //                 'name1': name1,
    //                 'name2': name2,
    //                 'name3': name3,
    //                 'plant': plant,
    //                 'division': division,
    //                 'dept': dept,
    //                 'section': section,
    //                 'position': position,
    //                 'flag': flag
    //             },
    //             success: function(data) {
    //                 if ((data['response']) == 'User Updated') {

    //                     $.unblockUI();

    //                     $('#editUser').modal('hide');

    //                     Snackbar.show({
    //                         text: data['response'],
    //                         pos: 'top-center'
    //                     });

    //                     $('#User').DataTable().ajax.url('listUser').load();


    //                 } else {


    //                     $.unblockUI();

    //                     swal("Error", (data['response']), "error");

    //                 }
    //             }
    //         });
    //     }

    // });



});


</script>

@endsection
{{-- Content Page JS End--}}

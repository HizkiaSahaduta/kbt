@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('outside/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('outside/fa/css/font-awesome.min.css') }}">
<link href="{{ asset('outside/assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('outside/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
<style>
.widget-content-area {
  box-shadow: none !important; }

#User .badge {
  background: transparent; }

#User .badge-primary {
  color: #1b55e2;
  border: 2px dashed #1b55e2; }

#User .badge-warning {
  color: #e2a03f;
  border: 2px dashed #e2a03f; }

#User .badge-danger {
  color: #e7515a;
  border: 2px dashed #e7515a; }

#User .badge-success {
  color: #8dbf42;
  border: 2px dashed #8dbf42; }

#User .badge-info {
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('Add User') }}">Add User</a></li>
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

        <div class="col-lg-12 col-md-12 layout-spacing" id="satu">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Form of Adding User</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">
                    <a href="javascript:void(0)" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addUser">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Add New User
                    </a>
                    <div class="table-responsive">
                        <table id="User" class="table mb-4" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>UserID</th>
                                    <th>UserPass</th>
                                    <th>Flag</th>
                                    <th>Name1</th>
                                    <th>Name2</th>
                                    <th>Name3</th>
                                    <th>Plant</th>
                                    <th>Division</th>
                                    <th>Dept</th>
                                    <th>Section</th>
                                    <th>Position</th>
                                    <th>Action</th>
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
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">


                <div class="form-row mb-6">
                    <div class="form-group col-md-10">
                        <label for="user_id">User ID</label>
                        <input id="user_id" type="text" class="form-control">
                    </div>
                    {{-- <div class="form-group col-md-5">
                        <label for="user_pass">User Pass</label>
                        <input id="user_pass" type="text" class="form-control">
                    </div> --}}
                </div>

                <div class="form-row mb-6">
                    <div class="form-group col-md-4">
                        <label for="name1">Name 1</label>
                        <input id="name1" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name2">Name 2</label>
                        <input id="name2" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name3">Name 3</label>
                        <input id="name3" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-row mb-6">
                    <div class="form-group col-md-5">
                        <label for="plant">Plant</label>
                        <input id="plant" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="division">Division</label>
                        <input id="division" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-row mb-6">
                    <div class="form-group col-md-4">
                        <label for="dept">Dept</label>
                        <input id="dept" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="section">Section</label>
                        <input id="section" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="position">Position</label>
                        <input id="position" type="text" class="form-control">
                    </div>
                </div>



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveUser">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Submit</button>
                <button class="btn" data-dismiss="modal">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="preloader"></div>
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
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
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>
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
    $('#UserMgmtNav').attr('data-active','true');
    $('#UserMgmtNav').attr('aria-expanded','true');
    $('.UserMgmtTreeView').addClass('show');
    $('#AddUser').addClass('active');

    var dataTable = $('#User').DataTable({
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
            'url':'{!!url("listUser")!!}',
            'type': 'post',
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'user_id2', name: 'user_id2'},
            {data: 'user_pass', name: 'user_pass'},
            {data: 'active_flag', name: 'active_flag'},
            {data: 'name1', name: 'name1'},
            {data: 'name2', name: 'name2'},
            {data: 'name3', name: 'name3'},
            {data: 'plant', name: 'plant'},
            {data: 'division', name: 'division'},
            {data: 'dept', name: 'dept'},
            {data: 'section', name: 'section'},
            {data: 'position', name: 'position'},
            {data: 'Detail', name: 'Detail',orderable:false,searchable:false}
        ],
        initComplete: function(settings, json) {

            if (!dataTable.rows().data().length) {

                swal("Whops", "Data not available", "error");
            }
        },
    });

    $('body').on('click', '.editUser', function(e) {

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

    $('body').on('click', '.delUser', function(e) {

        id = $(this).data('id1');
        id2 = $(this).data('id2');

        const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger mr-3',
        buttonsStyling: false,
        })

        swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "Delete "+id2,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sure, go ahead',
            cancelButtonText: 'Nope',
            reverseButtons: true,
            padding: '2em'
        }).then(function(result) {
                if (result.value) {

                    blockUI();

                    $.ajax({
                        url: "{{url('delUser/id=')}}"+id+ "&id2=" +id2,
                        method: 'GET',
                        success: function(data) {

                            if ((data['response']) == 'User Deleted') {

                                $.unblockUI();

                                Snackbar.show({
                                    text: data['response'],
                                    pos: 'top-center'
                                });

                                $('#User').DataTable().ajax.url('listUser').load();


                            } else {

                                $.unblockUI();

                                swal("Error", (data['response']), "error");

                            }

                        }
                    });

                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swalWithBootstrapButtons(
                        "Cancelled",
                        "Cancel Delete "+id2,
                        "error"
                    )
                }
            })

    });

    $('#saveUser').on('click', function() {

        event.preventDefault();
        var user_id = $('#user_id').val();
        // var user_pass = $('#user_pass').val();
        var name1 = $('#name1').val();
        var name2 = $('#name2').val();
        var name3 = $('#name3').val();
        var plant = $('#plant').val();
        var division = $('#division').val();
        var dept = $('#dept').val();
        var section = $('#section').val();
        var position = $('#position').val();

        if (!user_id) {
            swal("Whops", "User ID must be filled!", "error");
        }
        // if (!user_pass) {
        //     swal("Whops", "User Pass must be filled!", "error");
        // }
        // if (!user_id && !user_pass) {
        //     swal("Whops", "User ID and User Pass must be filled!", "error");
        // }

        else {

            blockUI();

            $.ajax({
                type: "POST",
                url: "{{ url('saveUser') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'user_id2': user_id,
                    // 'user_pass': user_pass,
                    'name1': name1,
                    'name2': name2,
                    'name3': name3,
                    'plant': plant,
                    'division': division,
                    'dept': dept,
                    'section': section,
                    'position': position
                },
                success: function(data) {
                    if ((data['response']) == 'User Added') {

                        $('#user_id').val('');
                        // $('#user_pass').val('');
                        $('#name1').val('');
                        $('#name2').val('');
                        $('#name3').val('');
                        $('#plant').val('');
                        $('#division').val('');
                        $('#dept').val('');
                        $('#section').val('');
                        $('#position').val('');

                        $.unblockUI();

                        $('#addUser').modal('hide');

                        $('#User').DataTable().ajax.url('listUser').load();

                        Snackbar.show({
                            text: data['response'],
                            pos: 'top-center'
                        });


                    } else {

                        $('#user_id').val('');
                        // $('#user_pass').val('');
                        $('#name1').val('');
                        $('#name2').val('');
                        $('#name3').val('');
                        $('#plant').val('');
                        $('#division').val('');
                        $('#dept').val('');
                        $('#section').val('');
                        $('#position').val('');

                        $.unblockUI();

                        swal("Error", (data['response']), "error");

                    }
                }
            });
        }



    });

    $('#editSaveUser').on('click', function() {

        event.preventDefault();
        var id = $('#id').val();
        var user_id = $('#edit_user_id').val();
        var user_pass = $('#edit_user_pass').val();
        var name1 = $('#edit_name1').val();
        var name2 = $('#edit_name2').val();
        var name3 = $('#edit_name3').val();
        var plant = $('#edit_plant').val();
        var division = $('#edit_division').val();
        var dept = $('#edit_dept').val();
        var section = $('#edit_section').val();
        var position = $('#edit_position').val();

        var e = document.getElementById("edit_flag");
        var flag = e.options[e.selectedIndex].value;

        if (!user_id) {
            swal("Whops", "User ID must be filled!", "error");
        }
        if (!user_pass) {
            swal("Whops", "User Pass must be filled!", "error");
        }
        if (!user_id && !user_pass) {
            swal("Whops", "User ID and User Pass must be filled!", "error");
        }

        if (user_id && user_pass) {

            blockUI();

            $.ajax({
                type: "POST",
                url: "{{ url('editUser') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id,
                    'user_id2': user_id,
                    'user_pass': user_pass,
                    'name1': name1,
                    'name2': name2,
                    'name3': name3,
                    'plant': plant,
                    'division': division,
                    'dept': dept,
                    'section': section,
                    'position': position,
                    'flag': flag
                },
                success: function(data) {
                    if ((data['response']) == 'User Updated') {

                        $.unblockUI();

                        $('#editUser').modal('hide');

                        Snackbar.show({
                            text: data['response'],
                            pos: 'top-center'
                        });

                        $('#User').DataTable().ajax.url('listUser').load();


                    } else {


                        $.unblockUI();

                        swal("Error", (data['response']), "error");

                    }
                }
            });
        }

    });



});


</script>

@endsection
{{-- Content Page JS End--}}

@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')

<link rel="stylesheet" href="{{ asset('outside/plugins/select2/select2.min.css') }}">
{{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6gwySuHGQeor31FQ04ZYmNRgofOxf2yA"></script> --}}

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

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
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('CustomerVisit') }}">Customer Visit</li>
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
								<h4>Customer Visit</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">

                        <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link active" data-toggle="tab" role="tab" href="#existing" id="existing">Existing Customer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#newcust" id="newcust" >New Customer</a>
                            </li>
                        </ul>
                        <p></p>
                        <div class="form-group" id="sel_cust">
                            <hr class="my-4"></hr>
                            <select class="searchcustomer2 form-control basic" style="width:100%;" id="searchcustomer2" name="cari"></select>
                            <hr class="my-4"></hr>
                        </div>

                        <div class="form-group custIdCol">
                            <p class="required text-dark" for="customerid">Customer ID</p>
                            <input type="text" class="form-control" id="customerid" name="customerid" disabled/>
                        </div>  

                        <div class="form-group">
                            <p class="required text-dark" for="customername">Customer Name</p>
                            <input type="text" class="form-control" id="customername" name="customername" disabled/>
                        </div>  

                        <div class="form-group">
                            <p class="required text-dark" for="customeraddress">Customer Address</p>
                            <textarea type="textarea" class="form-control" id="customeraddress" name="customeraddress" disabled></textarea> 
                        </div>

                        <div class="form-group"> 
                            <p  class="required text-dark" for="customername">City</p>
                            <input type="text" class="form-control" id="customercity" name="customercity" disabled/>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox form-group">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="customCheckbox1" value="Y" checked>
                            <label for="customCheckbox1" class="custom-control-label text-dark">Penawaran produk</label>
                            </div>

                            <div class="custom-control custom-checkbox form-group">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="customCheckbox2" value="Y">
                            <label for="customCheckbox2" class="custom-control-label text-dark">Taking order</label>
                            </div>
                            
                            <div class="custom-control custom-checkbox form-group">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox3" name="customCheckbox3" value="Y">
                            <label for="customCheckbox3" class="custom-control-label text-dark">Info program / Hadiah</label>
                            </div>
                            
                            <div class="custom-control custom-checkbox form-group">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox4" name="customCheckbox4" value="Y">
                            <label for="customCheckbox4" class="custom-control-label text-dark">Penagihan</label>
                            </div>
                            
                            <div class="custom-control custom-checkbox form-group">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox5" name="customCheckbox5" value="Y">
                            <label for="customCheckbox5" class="custom-control-label text-dark">Customer Maintenance</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="required text-dark" for="remark">Remark</label>
                            <textarea name="textarea" class="form-control" id="remark" name="remark" ></textarea>
                        </div>

                        <div class="form-group">  
                            <label class="required text-dark" for="Longitude">Longitude</label>
                            <input type="text" class="form-control text-dark" id="Longitude" name="Longitude" disabled />
                        </div>

                        <div class="form-group">
                            <label class="required text-dark" for="Latitude">Latitude</label>
                            <input type="text" class="form-control text-dark" id="Latitude" name="Latitude" disabled />
                        </div>

                        <div class="form-group">
                            <label class="required text-dark" for="Address">Current Address</label>
                            <input type="text" class="form-control text-dark" id="Address" disabled/>
                        </div> 

                        <div class="form-group">
                            {{-- <button class="btn btn-primary btn-block" type="button" value="Get Current Location" onclick="getLoc()" >Get Current Location</button> --}}
                            <button class="btn btn-primary btn-block" type="button" value="Get Current Location" onclick="getLocation()" >Get Current Location</button>
                            <p></p>
                            <button type="submit" class="btn btn-primary btn-block mb-3 mr-3" id="submitform" name="submitform" >SUBMIT</button>
                            <p></p>
                        </div>  
                        
                        <div id="map_canvas" style="height:300px; border: 1px solid black;"></div>

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

<script type="text/javascript">


$(document).ready(function() {

    $('#homeNav').attr('data-active','false');
    $('#homeNav').attr('aria-expanded','false');
    $('#SalesActivityNav').attr('data-active','true');
    $('#SalesActivityNav').attr('aria-expanded','true');
    $('.SalesActivityTreeView').addClass('show');
    $('#CustomerVisit').addClass('active');
    

    $("#searchcustomer2").select2({
        placeholder: "Type any existing Customer ID or Customer Name...",
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
                    text: item.customer_id + " || " + item.nama + " (" + item.alamat + ","+ item.city +")" ,
                    id: item.customer_id
                }
                })
            };
            
            },
            cache: true
        }
    });

    $('#searchcustomer2').change(function(){
        var id = $( "#searchcustomer2" ).val();
        
        $.ajax({
            url: "getCustDetails/id="+id,
            type: "Get",
            dataType: 'json',
            success: function(data){
                  $('#customerid').val(data.customer_id);
                  $('#customername').val(data.nama);
                  document.getElementById("customername").disabled = true;
                  $('#customeraddress').val(data.alamat);
                  document.getElementById("customeraddress").disabled = true;
                  $('#customercity').val(data.city);
                  document.getElementById("customercity").disabled = true;                 
            }
        });
    });

    $('#existing').on('click', function() {
        $("#sel_cust").show();    
        $('#customerid').val('');
        document.getElementById("customerid").disabled = true;
        $('#customername').val('');
        document.getElementById("customername").disabled = true;
        $('#customeraddress').val('');
        document.getElementById("customeraddress").disabled = true;
        $('#customercity').val('');
        document.getElementById("customercity").disabled = true;
        $('#remark').val('');
        $('#Longitude').val('');
        document.getElementById("Longitude").disabled = true;
        $('#Latitude').val('');
        document.getElementById("Latitude").disabled = true;
        $('#Address').val('');
        $( "#customCheckbox1" ).prop( "checked", true );
        $( "#customCheckbox2" ).prop( "checked", false );
        $( "#customCheckbox3" ).prop( "checked", false );
        $( "#customCheckbox4" ).prop( "checked", false );
        $( "#customCheckbox5" ).prop( "checked", false );
        document.getElementById("Address").disabled = true;
        var newcust = document.getElementById("newcust");
        newcust.classList.remove("active");
        var existing = document.getElementById("existing");
        existing.classList.add("active");
    });

    $('#newcust').on('click', function() { 
        $("#sel_cust").hide();
        $('.custIdCol').hide();
        $('#customerid').val('');
        $('#customername').val('');
        document.getElementById("customername").disabled = false;
        $('#customeraddress').val('');
        document.getElementById("customeraddress").disabled = false;
        $('#customercity').val('');
        document.getElementById("customercity").disabled = false;
        $('#remark').val('');
        $( "#customCheckbox1" ).prop( "checked", true );
        $( "#customCheckbox2" ).prop( "checked", false );
        $( "#customCheckbox3" ).prop( "checked", false );
        $( "#customCheckbox4" ).prop( "checked", false );
        $( "#customCheckbox5" ).prop( "checked", false );
        var existing = document.getElementById("existing");
        existing.classList.remove("active");
        var newcust = document.getElementById("newcust");
        newcust.classList.add("active");
    });

    $('#submitform').on('click', function() {
      /* stop form from submitting normally */
      event.preventDefault();
		  
		$.ajax({
            type:"get",
            url:"{{ url('checkLastVisit') }}",
            success:function(data){
              
                if( data <= 0 )
                {	

					  $('#submitform').attr('disabled', 'disabled');
					  document.getElementById("submitform").textContent = 'Loading...';

					  //var customerid = $('#customerid').val();
					  var customername = $('#customername').val();
					  var customeraddress = $('#customeraddress').val();
					  var customercity = $('#customercity').val();
					  var Longitude = $('#Longitude').val();
					  var Latitude = $('#Latitude').val();
					  var Address = $('#Address').val();

					//   alert(Address);

					  if (customername == '' || customeraddress == '' || customercity == '' || Longitude == '' || Latitude == '' || Address == '')
					  {
						swal("Error", "Make sure required field is filled, including GPS location !", "error");
						document.getElementById("submitform").disabled = false;
						document.getElementById("submitform").textContent = 'SUBMIT';
					  }

					  else {

						$.ajax({
							type:"POST",
							url:"{{ url('storeActivity') }}",
							data:{
							  '_token': '{{ csrf_token() }}',
							  'customerid': $('#customerid').val(), 
							  'customername': $('#customername').val(),
							  'customeraddress': $('#customeraddress').val(),
							  'customercity': $('#customercity').val(),
							  'remark': $('#remark').val(),
							  'Longitude': $('#Longitude').val(),
							  'Latitude': $('#Latitude').val(),
							  'Address': $('#Address').val(),
							  'customCheckbox1': $('input[name="customCheckbox1"]:checked').val(),
							  'customCheckbox2': $('input[name="customCheckbox2"]:checked').val(),
							  'customCheckbox3': $('input[name="customCheckbox3"]:checked').val(),
							  'customCheckbox4': $('input[name="customCheckbox4"]:checked').val(),
							  'customCheckbox5': $('input[name="customCheckbox5"]:checked').val()
							},
							success:function(data){

								swal("Success", "Data Saved !", "success");
								$('#submitform').removeAttr("disabled");
								document.getElementById("submitform").textContent = 'SUBMIT';
								$('#searchcustomer2').val(null).trigger('change');
								$('#customerid').val('');
								$('#customername').val('');
								$('#customeraddress').val('');
								$('#customercity').val('');
								$('#remark').val('');
								$('#Longitude').val('');
								$('#Latitude').val('');
								$('#Address').val('');
								$( "#customCheckbox1" ).prop( "checked", true );
								$( "#customCheckbox2" ).prop( "checked", false );
								$( "#customCheckbox3" ).prop( "checked", false );
								$( "#customCheckbox4" ).prop( "checked", false );
								$( "#customCheckbox5" ).prop( "checked", false );

							}
						});
					  }
	  
				}
                else
                {
                    swal(data + " minutes remaining.", "Please wait 30 minutes after last customer visit.", "error");
                }

            }
        });
	  
    });

});

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    swal("Whops", "Geolocation is not supported by this browser.", "error")
  }
}

function showPosition(position) {

    $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='+position.coords.latitude+'&lon='+position.coords.longitude, function(data){
        
        var address = data.address.village +', '+ data.address.state_district +', '+ data.address.state;
        document.getElementById('Address').value = address;
    

        document.getElementById('Longitude').value = position.coords.longitude ;
        document.getElementById('Latitude').value = position.coords.latitude;

        var container = L.DomUtil.get('map_canvas');
        if(container != null){
            container._leaflet_id = null;
        }
   
        var mymap = L.map('map_canvas').setView([position.coords.latitude, position.coords.longitude], 13);
        
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

        L.marker([position.coords.latitude, position.coords.longitude],
            {draggable: true,        // Make the icon dragable
            //title: 'Hover Text',     // Add a title
            opacity: 0.5}            // Adjust the opacity
            )
            .addTo(mymap)
            .bindPopup('<b>Your current location</b><br>'+address)
            .openPopup();

    });
}





// var geocoder;
// var map;
// var infowindow = new google.maps.InfoWindow();
// var marker;

// function codeLatLng() {
//     var lat = document.getElementById('Latitude').value;
//     var lng = document.getElementById('Longitude').value;

//     var latlng = new google.maps.LatLng(lat, lng);
//     geocoder.geocode({ 'latLng': latlng }, function (results, status) {
//         if (status == google.maps.GeocoderStatus.OK && lat != "" && lng != "") {
//             if (results[1]) {
//                 map.setZoom(15);
//                 marker = new google.maps.Marker({
//                     position: latlng,
//                     map: map
//                 });
//                 var address = (results[1].formatted_address);
//                 document.getElementById('Address').value = results[1].formatted_address;
//                 infowindow.setContent(results[1].formatted_address);


//                 infowindow.open(map, marker);
//             } else {
//                 alert("No results found");
//             }
//         } else {
//             alert("Geocoder failed due to: " + status);
//         }
//     });
// };
    
// function getLoc(){
//     initGeolocation();
//     initialize();
// };

// function initGeolocation(){
//     if( navigator.geolocation )
//     {
//         navigator.geolocation.getCurrentPosition( success, fail );
//     }
//     else
//     {
//         alert("Sorry, your browser does not support geolocation services.");
//     };
// };

// function success(position){
//     document.getElementById('Longitude').value = position.coords.longitude ;
//     document.getElementById('Latitude').value = position.coords.latitude;
//     codeLatLng();
// };

// function fail(position){
//     // Could not obtain location
//     alert("Aktifkan GPS dan Mohon Izinkan Permintaan Lokasi");
//     window.close();
// };

// function initialize() {
//     geocoder = new google.maps.Geocoder();
//     var latlng = new google.maps.LatLng(-7.468026, 112.4408769);
//     var myOptions = {
//         zoom: 15,
//         center: latlng,
//         mapTypeId: 'roadmap'
//     }
//     map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
// };
</script>

@endsection
{{-- Content Page JS End--}}

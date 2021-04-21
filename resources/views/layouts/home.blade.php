@extends('main')

{{-- Content Page CSS Begin--}}
@section('contentcss')
<link href="{{ asset('outside/assets/css/elements/infobox.css') }}" rel="stylesheet" type="text/css" />
<style>

.widget-one {
    background: transparent;
}

.info {
    margin-bottom: 10px !important;
}

.border-bottom {
    border-bottom: 1px solid #dee2e6 !important;
}

h6 {
    color: #fff !important;
}

.scroll-area-md {
    height: 100px;
    overflow-x: hidden;
}

.shadow-overflow {
    position: relative;
}

.scrollbar-container {
    position: relative;
    height: 100%
}

.list-group {
    color: #fff !important;
    border-radius: 5 !important;
}

.list-group-item {
    background: #5797fb !important;
    color: #fff !important;
}


@media (max-width: 991px) {

    .widget-account-invoice-two .account-box p {
        font-size: 10px;
    }
	
	.row [class*="col-"] .widget .widget-header h4 {
		font-size: 14px;
   
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Dashboard</a></li>
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

        @if(Session::get('GROUPID') == 'STAFF')
        <div class="col-lg-12 col-md-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Welcome
                                {{ Session::get('NAME1') }}
                                {{ Session::get('NAME2') }}
                                {{ Session::get('NAME3') }}
                                {{-- @if(session()->has('MILLID'))
                                    {{ Session::get('MILLID') }}
                                @endif --}}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area">
                    <div class="widget-one">
                        <div class="infobox-3" style="margin-left: 0px">
                            <div class="info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <h5 class="info-heading">KBT Web Dashboard</h5>
                            <p class="info-text">Here we are, providing anything you want :)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(Session::get('GROUPID') != 'STAFF')
        <div class="col-lg-3 col-6 layout-spacing">
            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">

                            @if($num_subMonth = 12)
                                <h6 class="">ORDER {{ $subMonth }} {{ $subYear }}</h6>
                            @else
                                <h6 class="">ORDER {{ $subMonth }} {{ $year }}</h6>
                            @endif

                        </div>
                        <div class="info">
                            <p class="inv-balance" id="orderThisYearSubMonth">N/A</p>&nbsp;<span class="badge" id="orderPercentSub"></span>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="countOrderThisYearSubMonth">N/A
                        </div>
                        <div class="info border-bottom">
                            <p class="inv-balance" id="wgtThisYearSubMonth">N/A</p>                            
                        </div>
                        <div class="info">
                            <h6 class="">ORDER {{ $subMonth }} {{ $subYear2 }}</h6>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="orderSubYearSubMonth">N/A</p>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="countOrderSubYearSubMonth">N/A</p>
                        </div>
                        <div class="info border-bottom">
                            <p class="inv-balance" id="wgtSubYearSubMonth">N/A</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-3 col-6 layout-spacing">

            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">
                            <h6 class="">ORDER {{ $month }} {{ $year }}</h6>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="orderThisYear">N/A</p>&nbsp;<span class="badge" id="orderPercent"></span>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="countOrderThisYear">N/A</p>
                        </div>
                        <div class="info border-bottom">
                            <p class="inv-balance" id="wgtThisYear">N/A</p>
                        </div>
                        <div class="info">
                            <h6 class="">ORDER {{ $month }} {{ $subYear }}</h6>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="orderSubYear">N/A</p>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="countOrderSubYear">N/A</p>
                        </div>
                        <div class="info border-bottom">
                            <p class="inv-balance" id="wgtSubYear">N/A</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-3 col-6 layout-spacing">

            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">

                            @if($num_subMonth = 12)
                                <h6 class="">INVOICE {{ $subMonth }} {{ $subYear }}</h6>
                            @else
                                <h6 class="">INVOICE {{ $subMonth }} {{ $year }}</h6>
                            @endif
                            
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="invThisYearSubMonth">N/A</p>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="countInvThisYearSubMonth">N/A</p>
                        </div>
                        <div class="info border-bottom">
                            <p class="inv-balance" id="wgtInvThisYearSubMonth">N/A</p>
                        </div>
                        <div class="info">
                            <h6 class="">INVOICE {{ $subMonth }} {{ $subYear2 }}</h6>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="invSubYearSubMonth">N/A</p>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="countInvSubYearSubMonth">N/A</p>
                        </div>
                        <div class="info border-bottom">
                            <p class="inv-balance" id="wgtInvSubYearSubMonth">N/A</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-3 col-6 layout-spacing">

            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">
                            <h6 class=""> INVOICE {{ $month }} {{ $year }}</h6>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="invThisYear">N/A</p>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="countInvThisYear">N/A</p>
                        </div>
                        <div class="info border-bottom">
                            <p class="inv-balance" id="wgtInvThisYear">N/A</p>
                        </div>
                        <div class="info">
                            <h6 class="">INVOICE {{ $month }} {{ $subYear }}</h6>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="invSubYear">N/A</p>
                        </div>
                        <div class="info">
                            <p class="inv-balance" id="countInvSubYear">N/A</p>
                        </div>
                        <div class="info border-bottom">
                            <p class="inv-balance" id="wgtInvSubYear">N/A</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow chartContainer1">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="m-0">Monthly Order</h4>
                            <p style="padding: 0px 15px; font-size: 11px; font-style: italic;">K: thousand, M: million, B: billion</p>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>

        <div class="col-lg-4 layout-spacing layout-spacing">
            <div class="statbox widget box box-shadow chartContainer2">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="m-0">Order Performance in <b>{{ $subYear }}</b> </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>
        
        <div class="col-lg-4 layout-spacing layout-spacing">
            <div class="statbox widget box box-shadow chartContainer3">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="m-0">Order Performance in <b> {{ $year }} </b> </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer3" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>
        
        <div class="col-lg-4 layout-spacing layout-spacing">
            <div class="statbox widget box box-shadow chartContainer4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="m-0">Order Performance in <b> {{ $month }} </b> </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div id="chartContainer4" style="height: 370px; width: 100%;"></div>

                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
{{-- Content Page End--}}

{{-- Content Page JS Begin--}}
@section('contentjs')

<script src="{{ asset('canvasjs.min.js') }}"></script>
<script src="{{ asset('outside/plugins/blockui/jquery.blockUI.min.js') }}"></script>

<script type="text/javascript">

var dataPoints1, dataPoints2, dataPoints3, dataPoints4, dataPoints5, container;

var year = {{ $year }};
var subYear = {{ $subYear }};

var months = [
    'Jan', 'Feb', 'Mar', 'Apr', 'May',
    'Jun', 'Jul', 'Aug', 'Sep',
    'Oct', 'Nov', 'Dec'
];

var x = window.matchMedia("(max-width: 991px)")

function monthNumToName(monthnum) {
    return months[monthnum - 1] || '';
}

function getDashboardItems(){

    $.ajax({
        url: "{{ url('getDashboardItems') }}",
        type: "POST",
        cache: false,
        dataType: "json",
        success:function(data) {

            if (data.countOrderThisYear['total'] == null) {data.countOrderThisYear['total'] = 0;}
            if (data.countOrderThisYearSubMonth['total'] == null) {data.countOrderThisYearSubMonth['total'] = 0;}
            if (data.orderSubYear['total'] == null) {data.orderSubYear['total'] = 0;}
            if (data.countOrderSubYear['total'] == null) {data.countOrderSubYear['total'] = 0;}
            if (data.orderSubYearSubMonth['total'] == null) {data.orderSubYearSubMonth['total'] = 0;}
            if (data.countOrderSubYearSubMonth['total'] == null) {data.countOrderSubYearSubMonth['total'] = 0;}


            if (data.orderThisYear['total'] == null) {data.orderThisYear['total'] = 0;}

            if (data.wgtThisYear['total'] == null) {data.wgtThisYear['total'] = 0;}
            if (data.wgtThisYearSubMonth['total'] == null) {data.wgtThisYearSubMonth['total'] = 0}
            if (data.wgtSubYear['total'] == null) {data.wgtSubYear['total'] = 0;}
            if (data.wgtSubYearSubMonth['total'] == null) {data.wgtSubYearSubMonth['total'] = 0;}

            if (data.invThisYear['total'] == null) {data.invThisYear['total'] = 0; }
            if (data.countInvThisYear['total'] == null) {data.countInvThisYear['total'] = 0;}
            if (data.invThisYearSubMonth['total'] == null) {data.invThisYearSubMonth['total'] = 0;}
            if (data.countInvThisYearSubMonth['total'] == null) {data.countInvThisYearSubMonth['total'] = 0;}
            if (data.invSubYear['total'] == null) {data.invSubYear['total'] = 0;}
            if (data.countInvSubYear['total'] == null) {data.countInvSubYear['total'] = 0;}
            if (data.invSubYearSubMonth['total'] == null) {data.invSubYearSubMonth['total'] = 0;}
            if (data.countInvSubYearSubMonth['total'] == null) {data.countInvSubYearSubMonth['total'] = 0;}

            if (data.wgtInvThisYear['total'] == null) {data.wgtInvThisYear['total'] = 0;}
            if (data.wgtInvThisYearSubMonth['total'] == null) {data.wgtInvThisYearSubMonth['total'] = 0}
            if (data.wgtInvSubYear['total'] == null) {data.wgtInvSubYear['total'] = 0;}
            if (data.wgtInvSubYearSubMonth['total'] == null) {data.wgtInvSubYearSubMonth['total'] = 0;}

            $("#countOrderThisYear").html(data.countOrderThisYear['total'] + ' Orders');
            $("#countOrderThisYearSubMonth").html(data.countOrderThisYearSubMonth['total'] + ' Orders');
            $("#orderSubYear").html(data.orderSubYear['total']);
            $("#countOrderSubYear").html(data.countOrderSubYear['total'] + ' Orders');
            $("#orderSubYearSubMonth").html(data.orderSubYearSubMonth['total']);
            $("#countOrderSubYearSubMonth").html(data.countOrderSubYearSubMonth['total'] + ' Orders');

            $("#wgtThisYear").html(data.wgtThisYear['total'] + ' Tons');
            $("#wgtThisYearSubMonth").html(data.wgtThisYearSubMonth['total'] + ' Tons');
            $("#wgtSubYear").html(data.wgtSubYear['total'] + ' Tons');
            $("#wgtSubYearSubMonth").html(data.wgtSubYearSubMonth['total'] + ' Tons');

            $("#invThisYear").html(data.invThisYear['total']);
            $("#countInvThisYear").html(data.countInvThisYear['total'] + ' Inv.');
            $("#invThisYearSubMonth").html(data.invThisYearSubMonth['total']);
            $("#countInvThisYearSubMonth").html(data.countInvThisYearSubMonth['total'] + ' Inv.');
            $("#invSubYear").html(data.invSubYear['total']);
            $("#countInvSubYear").html(data.countInvSubYear['total'] + ' Inv.');
            $("#invSubYearSubMonth").html(data.invSubYearSubMonth['total']);
            $("#countInvSubYearSubMonth").html(data.countInvSubYearSubMonth['total'] + ' Inv.');

            $("#wgtInvThisYear").html(data.wgtInvThisYear['total'] + ' Tons');
            $("#wgtInvThisYearSubMonth").html(data.wgtInvThisYearSubMonth['total'] + ' Tons');
            $("#wgtInvSubYear").html(data.wgtInvSubYear['total'] + ' Tons');
            $("#wgtInvSubYearSubMonth").html(data.wgtInvSubYearSubMonth['total'] + ' Tons');

            // $("#activeOutletThisMonth").html(data.activeOutletThisMonth['total']);
            // $("#newCustomerThisMonth").html(data.newCustomerThisMonth['total']);
            // $("#activeOutletSubMonth").html(data.activeOutletSubMonth['total']);
            // $("#newCustomerSubMonth").html(data.newCustomerSubMonth['total']);

            if(data.orderPercent > 0)
            {
                $("#orderPercent" ).addClass("badge-success");
                $("#orderThisYear").html(data.orderThisYear['total']);
                $("#orderPercent").html(data.orderPercent + "%");
            }
            else
            {
                $("#orderPercent" ).addClass("badge-danger");
                $("#orderThisYear").html(data.orderThisYear['total']);
                $("#orderPercent").html(data.orderPercent + "%");
            }

            if(data.orderPercentSub > 0)
            {
                $("#orderPercentSub" ).addClass("badge-success");
                $("#orderThisYearSubMonth").html(data.orderThisYearSubMonth['total']);
                $("#orderPercentSub").html(data.orderPercentSub + "%");
            }
            else
            {
                $("#orderPercentSub" ).addClass("badge-danger");
                $("#orderThisYearSubMonth").html(data.orderThisYearSubMonth['total']);
                $("#orderPercentSub").html(data.orderPercentSub + "%");
            }
            
        }
    });

}

function getChart1(dataPoints1, dataPoints2){

    var chart1 = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        theme: "light2",
        exportEnabled: true,
        axisY: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
            title: "IDR",
            labelFormatter: addSymbols,
        },
        toolTip:{
		    shared:true
	    },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
	    },
        data: [
        {
            type: "column",
            indexLabel: "{y}",
            indexLabelFontSize: 14,
            indexLabelFontColor: "#FFF",
            name: subYear+ " Order",
            showInLegend: true,
            indexLabelPlacement: "inside",  
            indexLabelOrientation: "horizontal",
            color: "#ed6663",
            yValueFormatString: "#,###,,,.##",
        },
        {
            type: "column",
            indexLabel: "{y}",
            indexLabelFontSize: 14,
            indexLabelFontColor: "#FFF",
            name: year+ " Order",
            showInLegend: true,
            indexLabelPlacement: "inside",  
            indexLabelOrientation: "horizontal",
            color: "#2d4059",
            yValueFormatString: "#,###,,,.##",
        }]
    });

    chart1.options.data[0].dataPoints = dataPoints1;
    chart1.options.data[1].dataPoints = dataPoints2;

    if (x.matches) {

        for(var i = 0; i < chart1.options.data.length; i++){
            chart1.options.data[i].indexLabelFontSize = 8;
        }
        chart1.render();
    }
    chart1.render();
}

function getChart2(dataPoints, container){

    var pie_chart = new CanvasJS.Chart(container, {
	    animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        exportEnabled: true,
        subtitles: [{
            text: "in Million",		
            fontColor: "green",
        }],
		legend: {
			itemclick: toggleDataPointVisibility
		},
        data: [{

            type: "pie",
            percentFormatString: "#0.##",
            indexLabel: "{label} #percent%",
            indexLabelFontSize: 12,
			showInLegend: true

        }]
    });
    pie_chart.options.data[0].dataPoints = dataPoints;
    showDefaultText(pie_chart, "No Data Found!");

    if (x.matches) {

        for(var i = 0; i < pie_chart.options.data.length; i++){
            pie_chart.options.data[i].indexLabelFontSize = 6;
        }
        pie_chart.render();
    }
    pie_chart.render();
}

function addSymbols(e) {
	var suffixes = ["", "K", "M", "B"];
	var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

	if(order > suffixes.length - 1)
		order = suffixes.length - 1;

	var suffix = suffixes[order];
	return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

function toggleDataPointVisibility(e) {
	if(e.dataPoint.hasOwnProperty("actualYValue") && e.dataPoint.actualYValue !== null) {
    e.dataPoint.y = e.dataPoint.actualYValue;
    e.dataPoint.actualYValue = null;
    e.dataPoint.indexLabelFontSize = null;
    e.dataPoint.indexLabelLineThickness = null;
    e.dataPoint.legendMarkerType = "circle";
  } 
  else {
    e.dataPoint.actualYValue = e.dataPoint.y;
    e.dataPoint.y = 0;
    e.dataPoint.indexLabelFontSize = 0;
    e.dataPoint.indexLabelLineThickness = 0; 
    e.dataPoint.legendMarkerType = "cross";
  }
	e.chart.render();
}

function showDefaultText(chart, text) {
  var dataPoints = chart.options.data[0].dataPoints;
  var isEmpty = !(dataPoints && dataPoints.length > 0);

  if (!isEmpty) {
    for (var i = 0; i < dataPoints.length; i++) {
      isEmpty = !dataPoints[i].y;
      if (!isEmpty)
        break;
    }
  }

  if (!chart.options.subtitles)
    chart.options.subtitles = [];
  if (isEmpty) {
    chart.options.subtitles.push({
      text: text,
      verticalAlign: 'center',
    });
    chart.options.data[0].showInLegend = false;
  } else {
    chart.options.data[0].showInLegend = false;
  }
}

$(document).ready(function() {

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $('#homeNav').attr('data-active','true');
    $('#homeNav').attr('aria-expanded','true');

    @if(Session::get('GROUPID') != 'STAFF')

        var block1 = $('.chartContainer1');
        $(block1).block({ 
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

        var block2 = $('.chartContainer2');
        $(block2).block({ 
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
        
        var block3 = $('.chartContainer3');
        $(block3).block({ 
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

        var block4 = $('.chartContainer4');
        $(block4).block({ 
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

        getDashboardItems();

        // chart1
        $.ajax({
            type: "get",
            url: "{{ url('getDashboardOrderLastYear') }}",
            success: function(data) {

                if (data.length > 0) {

                    dataPoints1 = [];
                    for (var i = 0; i < data.length; i++) {
                    
                        dataPoints1.push({ label: monthNumToName(parseInt(data[i].month)), y: parseFloat(data[i].total) });
                    }
                    
                    $.ajax({
                        type: "get",
                        url: "{{ url('getDashboardOrderThisYear') }}",
                        success: function(data) {

                            if (data.length > 0) {
                                
                                dataPoints2 = [];
                                for (var i = 0; i < data.length; i++) {
                                    
                                    dataPoints2.push({ label: monthNumToName(parseInt(data[i].month)), y: parseFloat(data[i].total) });
                                }

                                getChart1(dataPoints1, dataPoints2 );

                                $('.chartContainer1').unblock();
                            }

                        }
                    });
                }

            }
        });

        // chart2
        $.ajax({
            type: "get",
            url: "{{ url('getDashboardOrderPrcentageLastYear') }}",
            success: function(data) {

                if (data.length > 0) {

                    dataPoints3 = [];
                    for (var i = 0; i < data.length; i++) {
                        dataPoints3.push({ label: data[i].category , y: parseFloat(data[i].total), legendText: data[i].category });
                    }
                    container = 'chartContainer2';
                    getChart2(dataPoints3, container );
                    $('.chartContainer2').unblock();
                }

                else {
                    
                    dataPoints3 = [];
                    dataPoints3.push({ y: 0 });
                    container = 'chartContainer2';
                    getChart2(dataPoints3, container );
                    $('.chartContainer2').unblock();
                }


            }
        });

        // chart3
        $.ajax({
            type: "get",
            url: "{{ url('getDashboardOrderPrcentageThisYear') }}",
            success: function(data) {

                if (data.length > 0) {

                    dataPoints4 = [];
                    for (var i = 0; i < data.length; i++) {
                        dataPoints4.push({ label: data[i].category , y: parseFloat(data[i].total), legendText: data[i].category });
                    }
                    container = 'chartContainer3';
                    getChart2(dataPoints4, container );
                    $('.chartContainer3').unblock();
                }

                else {
                    
                    dataPoints4 = [];
                    dataPoints4.push({ y: 0 });
                    container = 'chartContainer3';
                    getChart2(dataPoints4, container );
                    $('.chartContainer3').unblock();
                }


            }
        });

        // chart4
        $.ajax({
            type: "get",
            url: "{{ url('getDashboardOrderPrcentageThisMonth') }}",
            success: function(data) {

                if (data.length > 0) {

                    dataPoints5 = [];
                    for (var i = 0; i < data.length; i++) {
                        dataPoints5.push({ label: data[i].category , y: parseFloat(data[i].total), legendText: data[i].category });
                    }
                    container = 'chartContainer4';
                    getChart2(dataPoints5, container );
                    $('.chartContainer4').unblock();
                }

                else {
                    
                    dataPoints5 = [];
                    dataPoints5.push({ y: 0 });
                    container = 'chartContainer4';
                    getChart2(dataPoints5, container );
                    $('.chartContainer4').unblock();
                }


            }
        });
        
    @endif


});



</script>

@endsection
{{-- Content Page JS End--}}
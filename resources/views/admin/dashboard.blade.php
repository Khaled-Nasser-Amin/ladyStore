@extends('admin.layouts.appLogged')
@section('title',__('text.Dashboard'))
@push('css')
    <style>
       @media(max-width:600px){
            .box{
                width: 100%!important;
            }
        }
        @media(max-width:900px){
            .box{
                width: 49%!important;
            }
        }
        @media(max-width:460px){
            .widget-box-one .card-body .avatar-lg{
                float: none!important;
            }
        }
    </style>
@endpush
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">{{__('text.Dashboard')}}</li>
                            </ol>
                        </div>
                        <h4 class="page-title">{{__('text.Dashboard')}}</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row justify-content-between">

                <!-- end col -->
                <div class="box" style="width: 33%">
                    <div class="card widget-box-one border border-warning bg-soft-warning">
                        <div class="card-body">
                            <div class="float-right avatar-lg rounded-circle mt-3">
                                <i class="mdi mdi-tshirt-crew font-30 widget-icon rounded-circle avatar-title text-warning"></i>
                            </div>
                            <div class="wigdet-one-content">
                                <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">{{__('text.Active Products')}}</p>
                                <h2><span data-plugin="counterup">{{$products}} </span> </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box" style="width: 33%">
                    <div class="card widget-box-one border border-success bg-soft-success">
                        <div class="card-body">
                            <div class="float-right avatar-lg rounded-circle mt-3">
                                <i class="mdi mdi-close-circle  font-30 widget-icon rounded-circle avatar-title text-success"></i>
                            </div>
                            <div class="wigdet-one-content">
                                <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">{{__('text.Inactive Products')}}</p>
                                <h2><span data-plugin="counterup">{{ $inactive_products }} </span> </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box" style="width: 33%">
                    <div class="card widget-box-one border border-primary bg-soft-primary">
                        <div class="card-body">
                            <div class="float-right avatar-lg rounded-circle mt-3">
                                <i class="mdi mdi-invert-colors-off  font-30 widget-icon rounded-circle avatar-title text-primary"></i>
                            </div>
                            <div class="wigdet-one-content">
                                <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">{{__('text.Inactive Colors')}}</p>
                                <h2><span data-plugin="counterup">{{ $inactive_colors_counter }} </span> </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box" style="width: 33%">
                    <div class="card widget-box-one border border-danger bg-soft-danger">
                        <div class="card-body">
                            <div class="float-right avatar-lg rounded-circle mt-3">
                                <i class="mdi mdi-truck font-30 widget-icon rounded-circle avatar-title text-danger"></i>
                            </div>
                            <div class="wigdet-one-content">
                                <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">{{__('text.Completed Orders')}}</p>
                                <h2><span data-plugin="counterup">{{ $orders }}</span> </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box" style="width: 33%">
                    <div class="card widget-box-one border border-dark bg-soft-dark">
                        <div class="card-body">
                            <div class="float-right avatar-lg rounded-circle mt-3">
                                <i class="mdi mdi-cash-refund font-30 widget-icon rounded-circle avatar-title text-dark"></i>
                            </div>
                            <div class="wigdet-one-content">
                                <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">{{__('text.Refunds')}}</p>
                                <h2><span data-plugin="counterup">{{ $total_refunds }}</span> </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box" style="width: 33%">
                    <div class="card widget-box-one border border-secondary bg-soft-secondary">
                        <div class="card-body">
                            <div class="float-right avatar-lg rounded-circle mt-3">
                                <i class="mdi mdi-cash-multiple  font-30 widget-icon rounded-circle avatar-title text-secondary"></i>
                            </div>
                            <div class="wigdet-one-content">
                                <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">{{__('text.Total Amount')}}</p>
                                <h2><span data-plugin="counterup">{{ $total_amount }} </span> </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end col -->


            </div>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h5 class="my-3">@lang('text.Comparison between the number of orders this month and last month')</h4>
                    <table class="table table-stripe table-secondary">
                        <tr>
                            <th>@lang('text.Week')</th>
                            <th>@lang('text.Current Month')</th>
                            <th>@lang('text.Last Month')</th>
                        </tr>
                        @php
                            $weeks=[__('text.First Week'),__('text.Second Week'),__('text.Third Week'),__('text.Fourth Week'),__('text.Fifth Week')];
                        @endphp
                        @foreach ($current_month_orders as $week)
                        <tr>
                            <td>{{ $weeks[$loop->index] }}</td>
                            <td>{{ $week->count() }}</td>
                            <td>{{$last_month_orders->count() > 0 ? collect(array_values($last_month_orders->toArray())[$loop->index])->count() : 0}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <div class="col-sm-12 col-md-6">
                    <h5 class="my-3">@lang('text.Comparison between the total amount this month and last month')</h4>
                    <table class="table table-stripe table-secondary">
                        <tr>
                            <th>@lang('text.Week')</th>
                            <th>@lang('text.Current Month')</th>
                            <th>@lang('text.Last Month')</th>
                        </tr>
                        @php
                            $weeks=[__('text.First Week'),__('text.Second Week'),__('text.Third Week'),__('text.Fourth Week'),__('text.Fifth Week')];
                        @endphp
                        @foreach ($current_month_orders as $week)
                        <tr>
                            <td>{{ $weeks[$loop->index] }}</td>
                            <td>{{ $week->sum('total_amount') }}</td>
                            <td>{{$last_month_orders->count() > 0  ? collect(array_values($last_month_orders->toArray())[$loop->index])->sum('total_amount') : 0 }}</td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>


            <div class="row mx-0">
                <div class="row mt-5 mx-0  col-sm-12 col-md-6">
                    <div class="demo-box w-100">
                        <h4 class="header-title">@lang('text.Number of orders per week')</h4>
                        <p class="sub-header">
                        </p>

                        <div id="website-stats" style="height: 320px;" class="flot-chart w-100"></div>
                    </div>
                </div>
                <div class="row mt-5 mx-0 col-lg-6 col-sm-12 col-md-6">
                    <div class="demo-box w-100">
                        <h4 class="header-title">@lang('text.Total amount per week')</h4>
                        <p class="sub-header">
                        </p>

                        <div id="website-stats1" style="height: 320px;" class="flot-chart w-100"></div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end container-fluid -->

    </div>
@endsection
@push('script')
    <script src="{{asset('/libs/flot-charts/jquery.flot.js')}}"></script>
    <script>
    !function(b){
        "use strict";
        var o=function(){this.$body=b("body"),this.$realData=[]};
        o.prototype.createPlotGraph=function(o,a,t,r,e,l,i,s){
            b.plot(b(o),[
                {data:a,label:e[0],color:l[0]},
                {data:t,label:e[1],color:l[1]},

            ],{series:{
                        lines:{show:!0,fill:!0,lineWidth:2,fillColor:{colors:[{opacity:0},{opacity:.5},{opacity:.6}]}},
                        points:{show:!1},shadowSize:0},grid:{hoverable:!0,clickable:!0,borderColor:i,tickColor:"#f9f9f9",borderWidth:1,labelMargin:10,backgroundColor:s},
                        legend:{position:"ne",margin:[0,-24],noColumns:0,backgroundColor:"transparent",
                        labelBoxBorderColor:null,
                        labelFormatter:function(o,a){
                            return o+"&nbsp;&nbsp;"},width:30,height:2},yaxis:{axisLabel:"Number of week",tickColor:"rgba(108, 120, 151, 0.1)",font:{color:"#6c7897"}},xaxis:{axisLabel:"Number of orders",tickColor:"rgba(108, 120, 151, 0.1)",font:{color:"#6c7897"}},tooltip:!0,tooltipOpts:{content:"%s: Value of %x is %y",shifts:{x:-60,y:25},defaultTheme:!1}})
        },
        o.prototype.init=function(){
            this.createPlotGraph("#website-stats",
            [
                [0,0],
                @foreach ($current_month_orders as $week)

                    [{{ ($loop->index+1)}},{{ $week->count() }}],
                @endforeach
            ],
            [
                [0,0],
                @foreach ($last_month_orders as $week)
                    [{{ ($loop->index+1)}},{{ $week->count() }}],
                @endforeach
            ],
            [
            ],
            ["@lang('text.Current Month')","@lang('text.Last Month')"],
            ["#4bd396","#f5707a"],
            "rgba(108, 120, 151, 0.1)","transparent");

            this.createPlotGraph("#website-stats1",
            [

                [0,0],
                @foreach ($current_month_orders as $week)

                    [{{ ($loop->index+1)}},{{ $week->sum('total_amount') }}],
                @endforeach
            ],
            [
                [0,0],
                @foreach ($last_month_orders as $week)
                    [{{ ($loop->index+1)}},{{ $week->sum('total_amount') }}],
                @endforeach
            ],
            [
            ],
            ["@lang('text.Current Month')","@lang('text.Last Month')"],
            ["#fcc550","#000"],
            "rgba(108, 120, 151, 0.1)","transparent");

         },

            b.FlotChart=new o,
            b.FlotChart.Constructor=o
        }(window.jQuery),function(o){"use strict";window.jQuery.FlotChart.init()

    }();
    </script>
@endpush


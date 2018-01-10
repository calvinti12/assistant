@extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-facebook"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Facebook Pages</span>
                    <span class="info-box-number">{{\App\FacebookPages::count()}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-bug"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Spams</span>
                    <span class="info-box-number">{{\App\Spam::count()}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-bell-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Notifications</span>
                    <span class="info-box-number">{{\App\Notification::count()}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Sender</span>
                    <span class="info-box-number">{{\App\Sender::count()}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="info-box" style="padding: 10px">
                <span class="label label-danger animated infinite fadeIn"><i class="fa fa-circle"></i> Live Notifications</span>
                <br>
                <p id="liveUpdate"></p>
                <a class="btn btn-success btn-xs" href="{{url('/notifications/all')}}"><i class="fa fa-bell-o"></i> View all Notifications</a>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('/css/animate.css')}}">
@endsection

@section('js')
    <script>

        function liveUpdate() {
            $.ajax({
                type: 'GET',
                url: '{{url('/notification')}}',
                data: {},
                success: function (data) {
                    $('#liveUpdate').html(data);
                }
            });
        }
        setInterval(liveUpdate, 3000);
    </script>
@endsection

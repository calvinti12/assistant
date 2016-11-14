@extends('layouts.app')
@section('title','Settings')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Settings</div>
                    <div class="panel-body">
                        <div class="form-horizontal">

                            <div class="form-group">
                                <label for="appId" class="col-md-4 control-label">Facebook AppID</label>
                                <div class="col-md-6">
                                    <input value="{{\App\Http\Controllers\SettingsController::get('fbAppId')}}"
                                           type="text"
                                           class="form-control" id="fbAppId">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="appId" class="col-md-4 control-label">Facebook AppSecret</label>
                                <div class="col-md-6">
                                    <input value="{{\App\Http\Controllers\SettingsController::get('fbAppSec')}}"
                                           type="text"
                                           class="form-control" id="fbAppSec">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="appId" class="col-md-4 control-label">Connect With Facebook</label>
                                <div class="col-md-6">
                                    <a href="{{$loginUrl}}" class="btn btn-primary"><i class="fa fa-facebook"></i>
                                        Connect</a>

                                </div>
                            </div>
                            <hr>
                            @if(\App\FacebookPages::all()->count() >= 0)
                                <div class="form-group">
                                    <label for="pageId" class="col-md-4 control-label">Exception message for</label>
                                    <div class="col-md-6">

                                        <select id="pageId" class="form-control">
                                            @foreach(\App\FacebookPages::all() as $page)
                                                <option value="{{$page->pageId}}">{{$page->pageName}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="appId" class="col-md-4 control-label">Exception message</label>
                                    <div class="col-md-6">

                                        <textarea id="exMsg" class="form-control" row="3"></textarea>

                                    </div>
                                </div>
                            @endif
                            <hr>
                            <div class="form-group">
                                <label for="live" class="col-md-4 control-label">Live notification</label>
                                <div class="col-md-6">
                                    <input id="liveVal" type="hidden"
                                           value="{{\App\Http\Controllers\SettingsController::get('live')}}">
                                    <select id="live" class="form-control">

                                        <option value="on"
                                                @if(\App\Http\Controllers\SettingsController::get('live')=='on') selected @endif>
                                            On
                                        </option>
                                        <option value="off"
                                                @if(\App\Http\Controllers\SettingsController::get('live')=='off') selected @endif>
                                            Off
                                        </option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="match" class="col-md-4 control-label">Matching percentage</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="match"
                                           value="{{\App\Http\Controllers\SettingsController::get('match')}}">

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="update" class="btn btn-primary">
                                        <i class="fa fa-btn fa-save"></i> Update
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.ajax({
            type: 'POST',
            url: '{{url('/getexmsg')}}',
            data: {
                'pageId': $('#pageId :selected').val(),
                '_token': '{{csrf_token()}}'
            },
            success: function (data) {
                $('#exMsg').val(data);
            }
        });
        $('#pageId').on('change', function (data) {
            $.ajax({
                type: 'POST',
                url: '{{url('/getexmsg')}}',
                data: {
                    'pageId': $('#pageId :selected').val(),
                    '_token': '{{csrf_token()}}'
                },
                success: function (data) {
                    $('#exMsg').val(data);
                }
            });
        })

        $("#uploadimage").on('submit', (function (e) {
            e.preventDefault();
            $('#imgMsg').html("Please wait ...");
            $.ajax({
                url: "{{url('/iup')}}",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data['status'] == 'success') {
                        $('#image').val(data['fileName']);
                        $('#imgMsg').html("Your file uploaded and it's name : " + data['fileName']);
                        swal('Success!', 'Image File succefully uploaded', 'success');
                        $('#imagePreview').attr('src', 'uploads/' + data['fileName']);

                    }
                    else {
                        swal('Error!', data, 'error');
                        $('#imgMsg').html("Something went wrong can't upload image");

                    }
                }
            });
        }));


        $('#update').click(function () {
            $.ajax({
                type: 'POST',
                url: "{{url('/settings')}}",
                data: {
                    'fbAppId': $('#fbAppId').val(),
                    'fbAppSec': $('#fbAppSec').val(),
                    'live': $('#liveVal').val(),
                    'pageId': $('#pageId :selected').val(),
                    'exMsg': $('#exMsg').val(),
                    'match': $('#match').val(),
                    '_token': '{{csrf_token()}}'
                },
                success: function (data) {
                    if (data == 'success') {
                        swal('Success', 'Updated', 'success');
                        location.reload();
                    }
                    else {
                        swal("Error", data, 'error');
                    }

                }
            });
        });

        $('#live').on('change', function () {
            $('#liveVal').val($(this).val());
        });

    </script>
@endsection

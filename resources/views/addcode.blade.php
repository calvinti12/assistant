@extends('layouts.app')
@section('title','Add Short Code')
@section('content')
    <div class="container">
        <div class="row">


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Available Short codes</div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <td><kbd>&#123;&#123;name&#125;&#125;</kbd></td>
                                <td>Sender name who belongs to the messages or comments <span class="label label-default">System</span></td>

                            </tr>
                            <tr>
                                <td><kbd>&#123;&#123;page_name&#125;&#125;</kbd></td>
                                <td>Page name belongs to the messages or comments <span class="label label-default">System</span></td>
                            </tr>
                            @foreach(\App\ShortCode::all() as $short)
                                <tr>
                                    <td>
                                        <kbd>{{$short->code}}</kbd>
                                    </td>
                                    <td>Sender Name</td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Add new Short code</div>
                    <div class="panel-body">
                        <div class="form-horizontal">


                            <div class="form-group">
                                <label for="code" class="col-md-4 control-label">Code </label>
                                <div class="col-md-6">
                                    <input required type="text" id="code" class="form-control">

                                </div>
                            </div>


                            <div class="form-group">
                                <label for="value" class="col-md-4 control-label">Content </label>
                                <div class="col-md-6">
                                    <input required type="text" id="value" class="form-control">

                                </div>
                            </div>




                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="add" class="btn btn-primary">
                                        <i class="fa fa-btn fa-code"></i> Add Shortcode
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

        $('#add').click(function () {

            $.ajax({
                type: 'POST',
                url: '{{url('/code')}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'code': $('#code').val(),
                    'value': $('#value').val(),

                },
                success: function (data) {
                    if (data == 'success') {
                        swal('Success', 'Shortcode added', 'success');
                    }
                    else {
                        swal('Error', data, 'error');
                    }
                },
                error: function (data) {
                    swal('Error', "Something went wrong please check console message", 'error');
                    console.log(data);
                }
            })
        });


    </script>
@endsection

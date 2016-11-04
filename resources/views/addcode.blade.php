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


                            <div id="postIdDiv" class="form-group">
                                <label for="postId" class="col-md-4 control-label">Post ID </label>
                                <div class="col-md-6">
                                    <input type="text" id="postId" class="form-control">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="question" class="col-md-4 control-label">Comment </label>
                                <div class="col-md-6">
                                    <input type="text" id="question" class="form-control">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment" class="col-md-4 control-label">Reply </label>
                                <div class="col-md-6">
                                    <textarea id="answer" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="link" class="col-md-4 control-label">Image Link </label>
                                <div class="col-md-6">
                                    <input type="text" id="link" class="form-control">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="link" class="col-md-4 control-label">Reply type </label>
                                <div class="col-md-6">
                                    <select id="type" class="form-control">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="add" class="btn btn-primary">
                                        <i class="fa fa-btn fa-comment"></i> Add comment
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
        $('#postIdDiv').hide();
        var specified = "no";

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
        $('#add').click(function () {
            if (specified == "yes") {
                if ($('#postId').val().length <= 0) {
                    return swal("Attention !", "Please enter post ID");
                }
            }

            if ($('#question').val().length <= 0) {
                return swal("Attention !", "Please enter comment");
            }
            if ($('#answer').val().length <= 0) {
                return swal("Attention !", "Please enter reply against comment");
            }
            $.ajax({
                type: 'POST',
                url: '{{url('/comment')}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'pageId': $('#pageId').val(),
                    'question': $('#question').val(),
                    'answer': $('#answer').val(),
                    'link': $('#link').val(),
                    'specified': specified,
                    'postId': $('#postId').val(),
                    'type': $('#type').val()
                },
                success: function (data) {
                    if (data == 'success') {
                        swal('Success', 'Reply adeed', 'success');
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
        $('#question').on('keyup', function () {
            $('#userComment').html($(this).val());
        })

        $('#answer').on('keyup', function () {
            $('#pageComment').html($(this).val());
        })

        $("#specific").change(function () {
            if (this.checked) {
                $('#postIdDiv').show(200);
                specified = "yes";
            } else {
                $('#postIdDiv').hide(200);
                specified = "no";
            }
        });

    </script>
@endsection

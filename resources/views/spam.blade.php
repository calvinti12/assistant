@extends('layouts.app')
@section('title','Spam Defender')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                {{--message preview section --}}
                <div class="panel panel-default">
                    <div class="panel-heading">Preview</div>
                    <div class="panel-body">
                        <div class="form-horizontal">

                        </div>


                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Private Message Conversation</div>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="comment" class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <label class="control-label"><input type="checkbox"> Delete automatically spam comments</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment" class="col-md-4 control-label">Reply </label>
                                <div class="col-md-6">
                                    <label class="control-label"><input type="checkbox"> Delete automatically spam comments</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment" class="col-md-4 control-label">Reply </label>
                                <div class="col-md-6">
                                    <textarea id="answer" class="form-control" rows="3"></textarea>
                                </div>
                            </div>




                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="add" class="btn btn-primary">
                                        <i class="fa fa-btn fa-envelope"></i> Add Conversation
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

    </script>
@endsection

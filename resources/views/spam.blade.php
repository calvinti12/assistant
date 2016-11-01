@extends('layouts.app')
@section('title','Spam Defender')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                {{--message preview section --}}
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-pie-chart"></i> Statistic</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">Detected Spam Comment<span class="label pull-right label-danger"> 23</span> </li>
                            <li class="list-group-item">Detected Spam User<span class="label pull-right label-warning"> 324</span> </li>
                            <li class="list-group-item">Deleted Spam <span class="label pull-right label-success"> 234</span> </li>
                            <li class="list-group-item">Comments will be automatically deleted if <kbd>Black listed words</kbd> fond</li>
                            <li class="list-group-item">Comment with <kbd>White listed URLs</kbd> will not be removed otherwise all comments with URLs will be removed</li>
                        </ul>

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
                                <label for="comment" class="col-md-4 control-label">Black Listed Words </label>
                                <div class="col-md-6">
                                    <textarea placeholder="Write words separated by commas" id="answer" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment" class="col-md-4 control-label">White Listed URLs</label>
                                <div class="col-md-6">
                                    <textarea id="answer" placeholder="Wirte URLs separated by commas" class="form-control" rows="4"></textarea>
                                </div>
                            </div>




                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="add" class="btn btn-primary">
                                        <i class="fa fa-btn fa-bug"></i> Save
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

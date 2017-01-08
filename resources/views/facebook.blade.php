@extends('layouts.app')
@section('title','Facebook pages')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Your Facebook pages<br>

                    </div>

                    <div class="panel-body">

                        <div class="list-group">
                            @foreach($pages as $page)
                                <a href="{{url('/facebook')}}/{{$page->pageId}}" class="list-group-item">
                                    {{$page->pageName}}
                                </a>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



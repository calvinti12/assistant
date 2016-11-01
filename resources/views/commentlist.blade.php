@extends('layouts.app')
@section('title','Comments List')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Comment List</div>

                    <div class="panel-body">

                        <table id="list" class="table">
                            <caption>Available reply list</caption>
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Question</th>
                                <th>Reply</th>
                                <th>Specified</th>
                                <th>Specified Post</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->question}}</td>
                                    <td>{{$data->answer}}</td>
                                    <td>{{$data->specified}}</td>
                                    <td>{{$data->postId}}</td>
                                    <td>{{$data->type}}</td>
                                    <td>
                                        <button data-id="{{$data->id}}" class="btn btn-xs btn-danger"><i
                                                    class="fa fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>

        $('#list').DataTable();

    </script>
@endsection


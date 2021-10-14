@extends('layouts.app')
@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
            {{session()->forget('success')}}
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$title}}
                        <a class="btn bg-primary" style="margin-left: 50px" href="{{url('news/create')}}">Add News</a>
                    </div>
                    <table class="table tab-content table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Add By</th>
                                <th>Description</th>
                                <th>Content</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_news as $news)
                                <tr>
                                    <td>{{$news->id}}</td>
                                    <td>{{$news->title}}</td>
                                    <td>{{$news->getUserName()->first()->name}}</td>
                                    <td>{{$news->desc}}</td>
                                    <td>{{$news->content}}</td>
{{--                                    <td><img src="uploads/{{$news->photo}}"></td>--}}
                                    <td><img src="{{url('uploads/' . $news->photo)}}" style="width: 50px;height: 50px"></td>
                                    <td>
                                        {!! Form::open(['url'=>'news/'.$news->id,'method'=>'delete']) !!}
                                        {!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

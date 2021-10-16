@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default" style="padding: 10px">
                    <div class="panel-heading text-center">
                        <a class="btn bg-primary" style="margin-left: 50px" href="{{url('news')}}">Back</a>
                        <a href="{{url('news/' . $news->id . '/edit')}}" class="btn btn-info">Edit</a>
                        {!! Form::open(['url'=>'news/'.$news->id,'method'=>'delete','style'=>'display:inline']) !!}
                        {!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>

                    <div class="panel panel-body">
                        <h3 style="margin-bottom: 15px">News Title : {{$title}}</h3>

                        <div class="card" style="margin-bottom: 20px">
                            <div class="card-body">
                                <img src="{{url('uploads/' . $news->photo)}}" style="width: 100%;height: 300px">
                            </div>
                        </div>

                        <h5 style="margin-bottom: 15px">Add By :{{$news->getUserName->name}}</h5>
                        <label>News Content :</label>
                        <h4 style="margin-bottom: 15px">{{$news->content}}</h4>

                        <hr>

                        @foreach($news->files()->get() as $file)
                        <div class="col-md-4" style="margin-bottom: 15px">
                            <img src="{{url('uploads/' . $file->file)}}" style="width: 100%;height: 100px">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

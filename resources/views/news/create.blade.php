@extends('layouts.app')
@section('content')

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$title}}
                        <a class="btn bg-primary" style="margin-left: 50px" href="{{url('news')}}">Back</a>
                    </div>

                    {!! Form::open(['url' => 'news','id' => 'news','files' => true]) !!}
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput1','News Title',['class'=>'form-label']) !!}
                        {!! Form::text('title',old('title'),['class'=>'form-control','id'=>'exampleFormControlInput1','placeholder'=>'News Title']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput2','News Description',['class'=>'form-label']) !!}
                        {!! Form::text('desc',old('desc'),['class'=>'form-control','id'=>'exampleFormControlInput2','placeholder'=>'News Description']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput3','Add By',['class'=>'form-label']) !!}
                        {!! Form::number('user_id',old('user_id'),['class'=>'form-control','id'=>'exampleFormControlInput3']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput4','News Content',['class'=>'form-label']) !!}
                        {!! Form::textarea('content',old('content'),['class'=>'form-control','id'=>'exampleFormControlInput4','placeholder'=>'News Content']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput5','Photo',['class'=>'form-label']) !!}
                        {!! Form::file('photo',['class'=>'form-control','id'=>'exampleFormControlInput5']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput5','files',['class'=>'form-label']) !!}
                        {!! Form::file('files[]',['class'=>'form-control','id'=>'exampleFormControlInput5','multiple'=>'yes']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::submit('Add New',['class'=>'btn btn-success mb-3','id'=>'add_news']) !!}
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection

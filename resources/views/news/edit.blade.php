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
                <div class="panel panel-default" style="padding: 10px">
                    <div class="panel-heading">
                        {{$title}}
                        <a class="btn bg-primary" style="margin-left: 50px" href="{{url('news')}}">Back</a>
                    </div>

                    {!! Form::open(['url' => 'news/' . $news->id,'files' => true,'method' => 'put']) !!}
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput1','News Title',['class'=>'form-label']) !!}
                        {!! Form::text('title',$news->title,['class'=>'form-control','id'=>'exampleFormControlInput1','placeholder'=>'News Title']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput2','News Description',['class'=>'form-label']) !!}
                        {!! Form::text('desc',$news->desc,['class'=>'form-control','id'=>'exampleFormControlInput2','placeholder'=>'News Description']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput3','Add By',['class'=>'form-label']) !!}
                        {!! Form::number('user_id',$news->user_id,['class'=>'form-control','id'=>'exampleFormControlInput3']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput4','News Content',['class'=>'form-label']) !!}
                        {!! Form::textarea('content',$news->content,['class'=>'form-control','id'=>'exampleFormControlInput4','placeholder'=>'News Content']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput5','Photo',['class'=>'form-label']) !!}
                        {!! Form::file('photo',['class'=>'form-control','id'=>'exampleFormControlInput5']) !!}
                        <label>Main Photo : </label>
                        <img src="{{url('uploads/' . $news->photo)}}" style="width: 200px;height: 150px;margin: 0 50%;padding: 5px">
                    </div>
                    <div class="mb-3">
                        {!! Form::label('exampleFormControlInput5','files',['class'=>'form-label']) !!}
                        {!! Form::file('files[]',['class'=>'form-control','id'=>'exampleFormControlInput5','multiple'=>'yes']) !!}
                        @if($news->files()->count() > 0)
                            <h5>News Photo : </h5>
                            @foreach($news->files()->get() as $file)
                                <div class="col-md-4">
                                    <img src="{{url('uploads/' . $file->file)}}" style="width: 100px;height: 100px;margin: 10px">
                                    <small>{{$file->file_name}}</small>
                                    <input type="checkbox" name="file_id[]" value="{{$file->id}}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    @if($news->files()->count() > 0)
                        <hr>
                        {{Form::submit('Delete Photos',['class'=>'btn btn-danger mb-3','id'=>'delete','name' => 'delete_photo'])}}
                    @endif
                    <hr>
                    <div class="mb-3" style="margin-top: 5px">
                        {!! Form::submit('Update',['class'=>'btn btn-success mb-3','id'=>'update']) !!}
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection

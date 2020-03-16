@extends('layouts.app')
@section('title', 'Detail ' . $title)

@section('content')
    <div class="row">
        <div class="col col-md-12" style="padding : 15px; height:250px" >
            <img class="col-md-12" style="max-width:100%; max-height:100%; padding-left: 0px; padding-right: 0px" src="{{ $post->thumbnail }}" alt="">
            {!! $post->content !!}
        </div>
    </div>
@endsection

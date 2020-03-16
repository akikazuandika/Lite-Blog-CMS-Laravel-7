@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="row">
        <div class="col col-md-8">
            @foreach ($posts as $item)
                <div class="item" style="margin : 15px; padding : 10px; background : #efefef" >
                    <img class="col-md-12" style="padding-left: 0px; padding-right: 0px; margin-bottom : 20px; width : 100%; height : 300px" src="{{ $item->thumbnail }}" alt="">
                    <p>{{ substr(strip_tags($item->content), 0, 21) }}</p>

                    <a href="{{ url('post') . "/". $item->slug }}" >Read More</a>
                </div>
            @endforeach
        </div>
        <div class="col col-md-1"></div>
        <div class="col col-md-3">
            <div class="left-sidebar" style="margin-top: 9px">
                <ul>
                    <li>Cate 1</li>
                    <li>Cate 2</li>
                    <li>Cate 3</li>
                    <li>Cate 4</li>
                    <li>Cate 5</li>
                    <li>Cate 6</li>
                    <li>Cate 7</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

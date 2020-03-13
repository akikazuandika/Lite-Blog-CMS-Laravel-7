@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="row">
        <div class="col col-md-8">
            <div class="item" style="padding : 15px" >
                <img class="col-md-12" style="padding-left: 0px; padding-right: 0px" src="https://via.placeholder.com/1000x100" alt="">
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea quibusdam consequuntur numquam quia blanditiis sed at nam, rem exercitationem. Rerum facilis corporis error odio aut minus perferendis voluptates quos maxime?</p>
                <a href="{{ url('post/1') }}" >Read More</a>
            </div>
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

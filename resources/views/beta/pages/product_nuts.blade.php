@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <div class="img"></div>
                <div class="carousel-caption">
                    <h3>Mixed Nuts</h3>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    </div>


@stop
@extends("home.layout.layout")
@section("title")
    {{$newsInfo['title']}}
    @endsection
@section("css")
    <link rel="stylesheet" href="{{asset("home/css/new/newOne.css")}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="heng">
        <img src="{{$newsInfo['image_url']}}" alt="">
    </div>
    <!--新闻内容-->
    <div class="coon clear">
        <h3>{{$newsInfo['title']}}</h3>
        {!! $newsInfo["content"] !!}
    </div>
@endsection

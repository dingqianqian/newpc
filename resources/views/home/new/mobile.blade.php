<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>{{$newsInfo['title']}}</title>
    <link rel="stylesheet" href="{{asset("home/css/common/reset.min.css")}}">
    <link rel="stylesheet" href="{{asset("home/css/new/index.css")}}">
</head>
<body>
<img class="onlyImg" src="{{$newsInfo['image_url']}}" alt="">
<div class="content">
    <h1>{{$newsInfo['title']}}</h1>
    <p>&nbsp;&nbsp;{{date("Y-m-d",$newsInfo['add_time'])}} {{$newsInfo['authour']}}</p>
    {!! $newsInfo['content'] !!}
</div>
<script type="text/javascript" src="{{asset("home/js/common/jquery-1.11.3.min.js")}}"></script>
<script type="text/javascript">
    ~function () {
        var reg1 = /AppleWebKit.*Mobile/i,
            reg2 = /MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/;
        if (reg1.test(navigator.userAgent)) {
            $('.onlyImg').css('marginTop', .75 + 'rem').attr('src', '{{$newsInfo['small_image_url']}}');
        } else if (reg2.test(navigator.userAgent)) {
            $('.onlyImg').css('marginTop', .96 + 'rem').attr('src', '{{$newsInfo['small_image_url']}}');
        } else {
            $('.onlyImg').css('marginTop', '0').attr('src', '{{$newsInfo['image_url']}}');
        }
        $('.content p').css('width', '100%');
    }();
</script>
</body>
</html>
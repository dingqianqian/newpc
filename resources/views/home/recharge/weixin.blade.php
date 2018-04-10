<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>宜优速微信充值</title>
    <link rel="stylesheet" href="{{asset('home/css/common/reset.min.css')}}">
    <style>
        body{
            background-color: #545454;
        }
        h3{
            margin: 96px auto 32px;
            font-size: 24px;
            color: #fff;
            text-align: center;
        }
        div{
            margin: 0 auto;
            width: 318px;
            height: 320px;
        }
        div img{
            width: 100%;
            height :100%;
        }
        p {
            margin: 30px auto 0;
            border-radius: 34px;
            width: 361px;
            height: 76px;
            line-height: 76px;
            text-align: center;
            font-size: 20px;
            color:#fff;
            background-color: #333;
        }
    </style>
</head>
<body>
<h3>微信充值</h3>
<div>
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->errorCorrection("H")->encoding('UTF-8')->size(280)->generate($result['code_url'])) !!}" alt="">
</div>
<p>请使用微信扫描二维码支付</p>
</body>
<script src="{{asset('home/js/common/jquery-1.11.3.min.js')}}"></script>
<script>
    setInterval("getOrderStatus()",2000);
    function getOrderStatus()
    {
        $.ajax({
            url:"{{url("recharge/getOrderStatus")}}",
            type:"post",
            data:{no:"{{$no}}"},
            success:function (res) {
                if(res.err==200)
                {
                    location.href="{{url('wallet/index')}}";
                }
            }
        });
    }
</script>
</html>
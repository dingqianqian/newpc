//新闻跑马灯
var box = document.getElementsByClassName("carousel")[0], can = true;
box.innerHTML += box.innerHTML;
box.onmouseover = function () {
    can = false
};
box.onmouseout = function () {
    can = true
};
new function () {
    var stop = box.scrollTop % (box.getElementsByTagName('li')[0].offsetHeight) == 0 && !can;
    if (!stop) box.scrollTop == parseInt(box.scrollHeight / 2) ? box.scrollTop = 0 : box.scrollTop++;
    setTimeout(arguments.callee, box.scrollTop % (box.getElementsByTagName('li')[0].offsetHeight) ? 10 : 3000);
};
//倒计时
var ary = ['2018/01/01 00:00:00', '2018/01/02 00:00:', '2018/01/11 00:00:00', '2018/01/12 00:00:00','2018/01/21 00:00:00', '2018/01/22 00:00:00','2018/02/01 00:00:00', '2018/02/02 00:00:', '2018/02/11 00:00:00', '2018/02/12 00:00:00','2018/02/21 00:00:00', '2018/02/22 00:00:00','2018/03/01 00:00:00', '2018/03/02 00:00:', '2018/03/11 00:00:00', '2018/03/12 00:00:00','2018/03/21 00:00:00', '2018/03/22 00:00:00', '2018/04/01 00:00:00', '2018/04/02 00:00:', '2018/04/11 00:00:00', '2018/04/12 00:00:00', '2018/04/21 00:00:00', '2018/04/22 00:00:00', '2018/05/01 00:00:00', '2018/05/02 00:00:00', '2018/05/11 00:00:00', '2018/05/12 00:00:00', '2018/05/21 00:00:00', '2018/05/22 00:00:00', '2018/06/01 00:00:00', '2018/06/02 00:00:00', '2018/06/11 00:00:00', '2018/06/12 00:00:00', '2018/06/21 00:00:00', '2018/06/22 00:00:00', '2018/07/01 00:00:00', '2018/07/02 00:00:00', '2018/07/11 00:00:00', '2018/07/12 00:00:00', '2018/07/21 00:00:00', '2018/07/22 00:00:00', '2018/08/01 00:00:00', '2018/08/02 00:00:00', '2018/08/11 00:00:00', '2018/08/12 00:00:00', '2018/08/21 00:00:00', '2018/08/22 00:00:00', '2018/09/01 00:00:00', '2018/09/02 00:00:00', '2018/09/11 00:00:00', '2018/09/12 00:00:00', '2018/09/21 00:00:00', '2018/09/22 00:00:00', '2018/10/01 00:00:00', '2018/10/02 00:00:00', '2018/10/11 00:00:00', '2018/10/12 00:00:00', '2018/10/21 00:00:00', '2018/10/12 00:00:00', '2018/11/01 00:00:00', '2018/11/02 00:00:00', '2018/11/11 00:00:00', '2018/11/12 00:00:00', '2018/11/21 00:00:00', '2018/11/22 00:00:00', '2018/12/01 00:00:00', '2018/12/02 00:00:00', '2018/12/11 00:00:00', '2018/12/12 00:00:00', '2018/12/21 00:00:00', '2018/12/22 00:00:00'];
function GetRTime() {
    if ($('#t_d').text() == 00 && $('#t_h').text() == 00 && $('#t_m').text() == 00 && $('#t_s').text() == 00) {
        ary.splice(0, 1);
    }
    var EndTime = new Date(ary[0]),
        NowTime = new Date(),
        t = EndTime.getTime() - NowTime.getTime(),
        d = 0,
        h = 0,
        m = 0,
        s = 0;
    if (t >= 0) {
        d = Math.floor(t / 1000 / 60 / 60 / 24);
        h = Math.floor(t / 1000 / 60 / 60 % 24);
        m = Math.floor(t / 1000 / 60 % 60);
        s = Math.floor(t / 1000 % 60);
    }
    document.getElementById("t_d").innerHTML = d < 10 ? '0' + d : null;
    document.getElementById("t_h").innerHTML = parseFloat(h) < 10 ? '0' + parseFloat(h) : parseFloat(h);
    document.getElementById("t_m").innerHTML = parseFloat(m) < 10 ? '0' + parseFloat(m) : parseFloat(m);
    document.getElementById("t_s").innerHTML = parseFloat(s) < 10 ? '0' + parseFloat(s) : parseFloat(s);
}
setInterval(GetRTime, 0);
var dDate = new Date().getDate();
if (/(01|11|21)/.test(dDate)) {
    $('#gHuan').text('狂购日疯狂进行中');
    $('#t_d,#t_h,#t_m,#t_s').css({
        'backgroundColor': '#980c3f',
        'color': '#fff',
        'fontSize': '30px',
        'fontWeight': '600',
        'width': '36px'
    });

} else {
    $('#gHuan').text('距离1.11.21狂购日活动还有');
    $('#t_d,#t_h,#t_m,#t_s').css({
        'backgroundColor': '#fff',
        'color': '#980c3f',
        'fontSize': '16px',
        'fontWeight': '500',
        'width': '26px'
    });
}
//楼层导航
var winH = document.documentElement.clientHeight || document.body.clientHeight;
var $content = $(".louceng"),
    $floorDivs = $content.children("li"),
    $floor = $(".floor"),
    $floorLis = $floor.children("li");

//->计算FLOOR区域的LEFT值：紧挨着CONTENT
var curL = parseFloat($content.offset().left) - parseFloat($floor.outerWidth());
curL = curL < 0 ? 0 : curL - 5;
$floor.css({
    left: curL
});

//->控制FLOOR的显示和隐藏 && 还有楼层的定位
$(window).on("scroll", computedShow);
function computedShow() {
    var curTop = document.documentElement.scrollTop || document.body.scrollTop;

    //->浏览器的SCROLL TOP值+半屏幕的高度>=一楼距离BODY的上偏移,我们控制楼层导航出现,反之让其消失即可;
    if ((curTop + winH / 2) >= $floorDivs.eq(0).offset().top) {
        $floor.stop().fadeIn(100);
    } else {
        $floor.stop().fadeOut(100);
    }

    //->根据当前的SCROLL TOP值+半屏幕的高度在计算出具体定位到哪一楼层
    $floorDivs.each(function (index, item) {
        var curOffTop = $(this).offset().top;
        if ((curTop + winH / 2) >= curOffTop) {
            $floorLis.eq(index).addClass("bg").siblings().removeClass("bg");
        }
    });
}

//->左侧的楼层导航中的每一个LI绑定点击事件
var autoTimer = null;
$floorLis.on("click", function () {
    if ($(this).hasClass('back')) {
        move(0);
    } else {
        $(this).addClass("bg").siblings().removeClass("bg");
        var index = $(this).index(),
            tarTop = $floorDivs.eq(index).offset().top;

        //->禁止WINDOW的SCROLL事件
        $(window).off("scroll", computedShow);

        //->开始运动
        move(tarTop);
    }
});
function move(target) {
    //->结束正在运行的动画,开始下一个动画
    window.clearInterval(autoTimer);

    //->进入MOVE首先获取的这个值是为了计算运动的方向
    var curTop = document.documentElement.scrollTop || document.body.scrollTop;
    var speed = 80;
    if (curTop > target) {
        speed *= -1;
    }
    if (curTop === target) {
        return;
    }

    //->开始运动
    autoTimer = window.setInterval(function () {
        //->每一次定时器中的这个值是为了在现有基础上+/-速度
        var cur = document.documentElement.scrollTop || document.body.scrollTop;
        cur += speed;

        if (speed > 0) {
            //->下
            if (cur >= target) {
                document.documentElement.scrollTop = target;
                document.body.scrollTop = target;
                window.clearInterval(autoTimer);
                $(window).on("scroll", computedShow);
                return;
            }
        } else {
            //->上
            if (cur <= target) {
                document.documentElement.scrollTop = target;
                document.body.scrollTop = target;
                window.clearInterval(autoTimer);
                $(window).on("scroll", computedShow);
                return;
            }
        }

        document.documentElement.scrollTop = cur;
        document.body.scrollTop = cur;
    }, 10);
}

//选项卡
$('.neiulT li').click(function () {
    $(this).addClass('sec').siblings().removeClass();
    var par = $(this).parent().parent().children('.xuan').children('ul').eq($(this).index());
    par.addClass('selec').siblings().removeClass();
});
//轮播图
var mySwiper = new Swiper('.swiper-container', {
    direction: 'horizontal',
    loop: true,
    //显示的图片数量
    slidesPerView: 3,
    //每个slider的距离
    spaceBetween: 53,
    //自动轮播的时间
    autoplay: 3000,
    //移除后自动轮播
    autoplayDisableOnInteraction: false,
    // 如果需要分页器
    //pagination: '.swiper-pagination',
    // 如果需要前进后退按钮
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev'
    // 如果需要滚动条
    //scrollbar: '.swiper-scrollbar',
});
$(".swiper-container").mouseenter(function () {//滑过悬停
    mySwiper.stopAutoplay();
}).mouseleave(function () {
    mySwiper.startAutoplay();
});
/*$(function () {
 setTimeout(sFun, 200);
 function sFun() {
 $('#cuteslider_3').height($('.fDing').height() + 3);
 }
 });*/
























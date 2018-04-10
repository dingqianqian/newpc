@extends("home.layout.layout")
        @section("title","签到")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/checkin/qiandao.css')}}">
    @endsection

@section("content")
    @component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>签到</span></p>
</div>
<div class="oStep clear">
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <div class="tStepCon">
        <p class="yhje">签到已获金额 : <span>{{$price}}</span>元</p>
        <p class="goPerson">
            <a href="{{url('person/index')}}" style="display: inline-block;">
                <span>返回到个人中心</span>
                <img src="{{asset('home/images/checkin/go-back.png')}}" alt="">
            </a>
        </p>
        <p class="Qmoney">
            您已连续签到 :<span>{{session("userInfo")["continuous_check_ins"]}}</span> 天
        </p>
        <div class="rili">
            <div class='calendar' id='calendar'></div>
            @if($flag)
                <p class="liji" style="display: none;">立即签到</p>
                <p class="weiqian" style="display: none;">今日未签到</p>
                <img id="suc" style="display: block;" src="{{asset('home/images/checkin/success.png')}}" alt="">
                <p class="su" style="display: block;">今日已签到,获得金额<span>{{$flag}}</span>元</p>
                @else
                <p class="liji" style="display: block;">立即签到</p>
                <p class="weiqian" style="display:block;">今日未签到</p>
                <img id="suc" style="display: none;" src="{{asset('home/images/checkin/success.png')}}" alt="">
                <p class="su" style="display: none;">今日已签到,获得金额<span>{{$flag}}</span>元</p>
            @endif
        </div>
    </div>
</div>
<div class="sprize">
    <div class="sprizeIn">
        <p>恭喜您已连续签到<i>7</i>天,已获得<i>10</i>元优惠卷的奖励!</p>
        <div>
            <p>您再连续签到7天即可获得20元优惠卷，加油哦！</p>
            <p>签到获得的优惠卷可在个人中心的优惠卷管理中查询，领取优惠卷满500元可以使用</p>
        </div>
        <span>知道了</span>
        <img src="{{asset('home/images/checkin/guanbi.png')}}" alt="">
    </div>
</div>
<div class="sprizee">
    <div class="sprizeInn">
        <p>恭喜您已连续签到<i>14</i>天,已获得<i>20</i>元优惠卷的奖励!</p>
        <div style="padding-top:56px;">
            <p>签到获得的优惠卷可在个人中心的优惠卷管理中查询，领取优惠卷满500元可以使用</p>
        </div>
        <span>知道了</span>
        <img src="{{asset('home/images/checkin/guanbi.png')}}" alt="">
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        var widthSpri = document.documentElement.clientWidth || document.body.clientWidth,
            heightSpri = document.documentElement.clientHeight || document.body.clientHeight;
        $('.sprize,.sprizee').css({'width': widthSpri, 'height': heightSpri});
        (function () {
            /*
             * 用于记录日期，显示的时候，根据dateObj中的日期的年月显示
             */
            var dateObj = (function () {
                var _date = new Date();    // 默认为当前系统时间
                return {
                    getDate: function () {
                        return _date;
                    },
                    setDate: function (date) {
                        _date = date;
                    }
                };
            })();
            // 设置calendar div中的html部分
            renderHtml();
            // 表格中显示日期
            showCalendarData();
            // 绑定事件
            bindEvent();
            function renderHtml() {
                var calendar = document.getElementById("calendar");
                var titleBox = document.createElement("div");  // 标题盒子 设置上一月 下一月 标题
                var bodyBox = document.createElement("div");  // 表格区 显示数据

                // 设置标题盒子中的html
                titleBox.className = 'calendar-title-box';
                titleBox.innerHTML = "<span class='prev-month' id='prevMonth'></span>" +
                    "<span class='calendar-title' id='calendarTitle'></span>" +
                    "<span id='nextMonth' class='next-month'></span>";
                calendar.appendChild(titleBox);    // 添加到calendar div中

                // 设置表格区的html结构
                bodyBox.className = 'calendar-body-box';
                var _headHtml = "<tr>" +
                    "<th>日</th>" +
                    "<th>一</th>" +
                    "<th>二</th>" +
                    "<th>三</th>" +
                    "<th>四</th>" +
                    "<th>五</th>" +
                    "<th>六</th>" +
                    "</tr>";
                var _bodyHtml = "";

                // 一个月最多31天，所以一个月最多占6行表格
                for (var i = 0; i < 5; i++) {
                    _bodyHtml += "<tr>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "</tr>";
                }
                /*bodyBox.innerHTML = "<table id='calendarTable' class='calendar-table'>" +
                 _headHtml + _bodyHtml +
                 "</table>";*/
                bodyBox.innerHTML = "<table id='calendarTable' class='calendar-table'>" +
                    _bodyHtml +
                    "</table>";
                // 添加到calendar div中
                calendar.appendChild(bodyBox);
            }

            function showCalendarData() {
                var _year = dateObj.getDate().getFullYear();
                var _month = dateObj.getDate().getMonth() + 1;
                var _dateStr = getDateStr(dateObj.getDate());

                // 设置顶部标题栏中的 年、月信息
                var calendarTitle = document.getElementById("calendarTitle");
                var titleStr = _dateStr.substr(0, 4) + "年" + _dateStr.substr(4, 2) + "月" + _dateStr.substr(6, 2) + "月";
                calendarTitle.innerText = titleStr;

                // 设置表格中的日期数据
                var _table = document.getElementById("calendarTable");
                var _tds = _table.getElementsByTagName("td");
                var _firstDay = new Date(_year, _month - 1, 1);  // 当前月第一天
                for (var i = 0; i < _tds.length; i++) {
                    var _thisDay = new Date(_year, _month - 1, i + 1 - _firstDay.getDay());
                    var _thisDayStr = getDateStr(_thisDay);
                    _tds[i].innerText = _thisDay.getDate();
                    //_tds[i].data = _thisDayStr;
                    _tds[i].setAttribute('data', _thisDayStr);
                    if (_thisDayStr == getDateStr(new Date())) {    // 当前天
                        _tds[i].className = 'currentDay';
                    } else if (_thisDayStr.substr(0, 6) == getDateStr(_firstDay).substr(0, 6)) {
                        _tds[i].className = 'currentMonth';  // 当前月
                    } else {    // 其他月
                        _tds[i].className = 'otherMonth';
                    }
                }
            }

            function bindEvent() {
                var prevMonth = document.getElementById("prevMonth");
                var nextMonth = document.getElementById("nextMonth");
                addEvent(prevMonth, 'click', toPrevMonth);
                addEvent(nextMonth, 'click', toNextMonth);
                var table = document.getElementById("calendarTable");
                var tds = table.getElementsByTagName('td');
                for (var i = 0; i < tds.length; i++) {
                    addEvent(tds[i], 'click', function (e) {
                        console.log(e.target.getAttribute('data'));
                    });
                }
            }

            function addEvent(dom, eType, func) {
                if (dom.addEventListener) {  // DOM 2.0
                    dom.addEventListener(eType, function (e) {
                        func(e);
                    });
                } else if (dom.attachEvent) {  // IE5+
                    dom.attachEvent('on' + eType, function (e) {
                        func(e);
                    });
                } else {  // DOM 0
                    dom['on' + eType] = function (e) {
                        func(e);
                    }
                }
            }

            function toPrevMonth() {
                var date = dateObj.getDate();
                dateObj.setDate(new Date(date.getFullYear(), date.getMonth() - 1, 1));
                showCalendarData();
            }

            function toNextMonth() {
                var date = dateObj.getDate();
                dateObj.setDate(new Date(date.getFullYear(), date.getMonth() + 1, 1));
                showCalendarData();
            }

            function getDateStr(date) {
                var _year = date.getFullYear();
                var _month = date.getMonth() + 1;    // 月从0开始计数
                var _d = date.getDate();
                _month = (_month > 9) ? ("" + _month) : ("0" + _month);
                _d = (_d > 9) ? ("" + _d) : ("0" + _d);
                return _year + _month + _d;
            }
            var a=new Array();
            @foreach($date as $k=>$v)
                a[{{$k}}]="{{$v['create_time']}}";
            @endforeach
            $('td').each(function (k,v) {
                $(a).each(function (m,n) {
                    if($(v).attr('data') == $(n).selector){
                        $(v).addClass('over');
                    }
                })
            });
            //计算签到领取的金额，增加签到标识，修改样式
            $('.liji').click(function () {
                $.ajax({
                    async:false,
                    url:"{{url('checkIn/create')}}",
                    type:"post",
                    success:function (res) {
                        if(res.err==200)
                        {
                            if(res.info==7)
                            {
                                $('.sprize').fadeIn(300);
                            }else if(res.info==14)
                            {
                                $('.sprizee').fadeIn(300);
                            }else
                                {

                                }
                            $('.su span').text(res.price);
                            $('.sprize .sprizeIn span,.sprize .sprizeIn img,.sprizee .sprizeInn span,.sprizee .sprizeInn img').click(function () {
                                $('.sprizee').fadeOut(300);
                            })
                        }
                    }
                });
                $('.liji,.weiqian').css('display', 'none');
                $('#suc,.su').css('display', 'block');
                $('td').each(function (k, v) {
                    if ($(v).hasClass('currentDay')) {
                        $(v).addClass('over');
                    }
                });
                $('.yhje span').text((parseFloat($('.yhje span').text()) + parseFloat($('.su span').text())).toFixed(2));
                $('.Qmoney span')[0].innerHTML++;
            })
        })();
    </script>
@endsection
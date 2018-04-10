// 创建
var fapiao = angular.module('myApp', ['ng', 'ngRoute']/*, function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}*/);

// 创建路由
fapiao.config(function ($routeProvider) {
    $routeProvider
    // 添加路由
        .when('/start', {
            templateUrl: url + '/invoice/addTax',
            controller: 'startCtrl'
        })
        .when('/openTwo', {
            templateUrl: url + '/invoice/stepTwo',
            controller: 'opentwoCtrl'
        })
        .when('/detailMessage', {
            templateUrl: url + '/invoice/taxInfo',
            controller: 'detailMessCtrl'
        })
        .when('/zizhi', {
            templateUrl: url + '/invoice/authBook'
        })
        .when('/xiugai', {
            templateUrl: url + '/invoice/update',
            controller: 'messXiuGai'
        })
        .when('/zizhilast', {
            templateUrl: 'tpl/zizhiLast.html',
            controller: 'zLastCtrl'
        })
});
// 选项卡跳转
fapiao.controller('parentJump', ['$scope', '$location', function ($scope, $location) {
    $scope.jump = function (path) {
        $location.path(path)
    }
}]);
// start
fapiao.controller('startCtrl', ['$scope','$http', function ($scope,$http) {
    if(parseFloat($('.notGt>span').text()).toFixed(2) === "0.00"){
        $('.detailX>li>span>input[name="wallet"]').each(function(k,v){
            if(!$(v).prop('checked')){
                $(v).attr('disabled',true)
            }
        })
    }else{
        $('.detailX>li>span>input[name="wallet"]').each(function(k,v){
            if(!$(v).prop('checked')){
                $(v).attr('disabled',false)
            }
        })
    }
    // 全选
   /* $('.clickGetF #checkAll').click(function () {
        if ($(this).prop('checked')) {
            $('.detailX>li>span>input').each(function (k, v) {
                $(v).prop('checked', 'checked');
            });
            var zJia = 0;
            $('.detailX>li>p>span').each(function (m, n) {
                zJia += parseFloat($(n).text());
            });
            $('.clickGetFBtn>span').text(zJia);
        } else {
            $('.detailX>li>span>input').each(function (k, v) {
                $(v).removeProp('checked');
            });
            $('.clickGetFBtn>span').text(0);
        }
    });*/
    //单选
    $('.detailX>li>span>input').click(function () {
        var flag = true;
        if ($(this).prop('checked')) {
            $('.detailX>li>span>input').each(function (k, v) {
                if ($(v).prop('checked') == false) {
                    flag = false;
                    return false;
                }
            });
        } else {
            flag = false;
        }
        if (flag) {
            $('#checkAll').prop('checked', 'checked');
        } else {
            $('#checkAll').removeProp('checked');
        }
        var zJia = 0;
        $('.detailX>li>span>input').each(function (m, n) {
            if ($(n).prop('checked')) {
                zJia += parseFloat($(n).parent().siblings('p').children('span').text());
            }
        });
        $('.clickGetFBtn>span').text(zJia);

        if($(this).prop('name') == "wallet"){
            // 判断可开发票金额
            var totleM = parseFloat($('.notGt>span').text()).toFixed(2),
                thisM= parseFloat($(this).parent().siblings('.lyP').children('span').text()).toFixed(2),
                kekaiM = parseFloat($('.notGt').children().attr('kekai')).toFixed(2),
                okTotle,sumM = 0;
            // 当前点击的金额余总金额对比
            if($(this).prop('checked')){
                if(parseFloat(totleM)-parseFloat(thisM) < 0){
                    layer.msg('由于您申请的钱包支付的订单金额已经大于您实际充值的金额数，返现金额不给于开发票，所以您申请发票会按照实际充值金额开取。', {time: 5000});
                }
                if(parseFloat(totleM)-parseFloat(thisM) <= 0){
                    okTotle = 0.00;
                    // 遍历未选中
                    $('.detailX>li>span>input[name="wallet"]').each(function(k,v){
                        if(!$(v).prop('checked')){
                            $(v).attr('disabled',true)
                        }
                    })
                }else{
                    okTotle = totleM - thisM;
                    $('.detailX>li>span>input[name="wallet"]').each(function(k,v){
                        if(!$(v).prop('checked')){
                            $(v).attr('disabled',false)
                        }
                    })
                }
            }else{
                okTotle = parseFloat(totleM) + parseFloat(thisM);
                $('.detailX>li>span>input[name="wallet"]').each(function(k,v){
                    if($(v).prop('checked')){
                        sumM += parseFloat(parseFloat($(v).parent().siblings('.lyP').children('span').text()).toFixed(2));
                    }
                });
                //
                if(parseFloat(kekaiM) > parseFloat(sumM)){
                    okTotle = parseFloat(kekaiM) - parseFloat(sumM);
                    $('.detailX>li>span>input[name="wallet"]').each(function(k,v){
                        if(!$(v).prop('checked')){
                            $(v).attr('disabled',false);
                        }
                    });
                }else{
                    okTotle = 0.00;
                    $('.detailX>li>span>input[name="wallet"]').each(function(k,v){
                        if(!$(v).prop('checked')){
                            $(v).attr('disabled',true);
                        }
                    });
                }
            }
            $('.notGt>span').text(okTotle.toFixed(2));
        }
    });
    $('.suc1 .sucN span').click(function () {
        $(this).parent().parent().fadeOut();
    });
    var widthP = document.documentElement.clientWidth || document.body.clientWidth,
        heightP = document.documentElement.clientHeight || documnet.body.clientHeight;
    $('.quan,.suc1').css({'width': widthP, 'height': heightP});
    // 收货地址信息：
    function messXiuGaiAdress() {
        // 弹窗
        $('#xiugaiM').distpicker({
            autoSelect: false
        });
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || document.body.clientHeight;
        $('.quan,.suc1').css({'width': widthP, 'height': heightP});
        // 点击添加地址
        $('.nowSetAdress').click(function () {
            $('.startAdree .quan').fadeIn(300);
        });
        // 点击使用新地址
        $('#useNewAd').click(function () {
            $('.quan').fadeIn(300);
            $('.add').text('添加地址')
        });
        // 点击取消
        $('.startAdree .noadd').click(function () {
            $('.startAdree .quan').fadeOut(300);
        })
        // 点击叉号
        $('.zhezhao .noadd,.zhezhao>img').click(function () {
            $('.quan').fadeOut();
//        $('.yq').removeAttr('myId');
            $('.quan').fadeOut(300, function () {
                $('#ren').val('');
                $('#tel').val('');
                $('#tail').val('');
                $("#province1").val('');
                $("#province1").trigger("change");
                $("#city1").val('');
                $("#city1").trigger("change");
                $("#district1").val('');
            });
        });

        $('#showMoreAdr').click(function () {
             // $('.showAdress>ul').slideToggle();
             $('#lyscoll').slideToggle();
            if ($(this).children('span').text() == '显示更多收货地址') {
                $(this).children('span').text('收起收货地址');
                $(this).children('img').addClass('ly_huojian');
            } else {
                $(this).children('span').text('显示更多收货地址');
                $(this).children('img').removeClass('ly_huojian');
            }
        });

        $('.delHide').css({'width': widthP, 'height': heightP});
        // 点击删除
        $('.deleteAd').click(function () {
            $('.delHide').attr('lyid',$(this).attr('ids'));

            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {                       // 删除确定
                var id = $(this).parent().parent().attr('lyid');
                    // 删除收货地址
                    $.ajax({
                        url:url+"/takeOver/delTakeOver",
                        type:'post',
                        data:{id:id},
                        success:function(res){
                            if(res.err == 200){
                                location.reload(true)
                            }
                        }
                    });
                $('.delHide').fadeOut(300).remoceAttr('lyid');
            });
        });
        // 取消
        $('.noDel').click(function () {
            $('.delHide').removeAttr('lyid');
            $('.delHide').fadeOut(300);
        });
        // 点击修改
        $('.lyxiugai').click(function () {
            $('.add').text('修改地址');
            $('.yq').attr('id', $(this).attr('id'));
            // 收货人
            var people = $(this).parent().find('.lyRen').children('em').text();
            // 电话
            var tel = $(this).parent().find('.lyTel').children('em').text();
            var ly_Adre = $(this).parent().find('label').children('span').attr('title').split(' ');
            $('#ren').val(people);  // 收货人
            $('#tel').val(tel); // 电话
            $('#danAddr').val($(this).attr('zds'));
            $("#province2").val(ly_Adre[0]);
            $("#province2").trigger("change");
            $("#city2").val(ly_Adre[1]);
            $("#city2").trigger("change");
            $("#district2").val(ly_Adre[2]);
            $('#tail').val(ly_Adre[3]);
            $('.quan').fadeIn(300);
        });
        // 点击确定
        $('.yq').unbind('click').click(function () {
            var flag = true;
            if (flag) {
                if ($('#ren').val() == '') {
                    layer.msg('请您填写收货人姓名');
                    flag = false;
                }
            }
            if (flag) {
                if ($('#ren').val() !== '' && $('#ren').val().length > 25) {
                    layer.msg('收货人姓名不能大于25位');
                    flag = false;
                }
            }
            if (flag) {
                $('.zhezhao #cacon .form-group .form-control').each(function (m, n) {
                    if ($(n).val() == '') {
                        layer.msg('请选择收货地址');
                        flag = false;
                        return false;
                    }
                });
            }
            if (flag) {
                if ($('#tail').val() == '') {
                    layer.msg('您需要填写详细的收货地址，可在下方文本框内填写');
                    flag = false;
                }
            }
            if (flag) {
                if ($('#danAddr').val() == '') {
                    layer.msg('请您输入单位名称');
                    flag = false;
                }
            }
            if (flag) {
                if ($('#tel').val() == '') {
                    layer.msg('请您填写收货人手机号码');
                    flag = false;
                }
            }
            if (flag) {
                if ($('#tel').val().length !== 11) {
                    layer.msg('请您输入正确的电话号');
                    flag = false;
                }
            }
            if (flag) {
                var ly_people = $(this).parent().find('#ren').val() ; // 收货人
                var ly_tel = $(this).parent().find('#tel').val(),  // 电话
                    ly_prev = $(this).parent().find('#province2').val(),
                    ly_city = $(this).parent().find('#city2').val(),
                    ly_town = $(this).parent().find('#district2').val(),
                    ly_xiang = $(this).parent().find('#tail').val(),
                ly_danName = $(this).parent().find('#danAddr').val();
                console.log(ly_people,ly_tel,ly_prev,ly_city,ly_town,ly_xiang,ly_danName);
                    if($(this).attr('id') !=undefined){
                        var lyId = $(this).attr('id');
                        // 修改
                        $.ajax({
                            url:url+"/takeOver/updateTakeOver/"+lyId,
                            type:'post',
                            data:{
                                name:ly_people,
                                province:ly_prev,
                                city:ly_city,
                                tel_no:ly_tel,
                                town:ly_town,
                                ex:ly_xiang,
                                company_name: ly_danName
                            },
                            success:function(res){
                                if(res.err == 200){
                                    location.reload(true)
                                }
                            },
                            err:function(res){
                                console.log(res)
                            }
                        });
                    }else{
                        // 新增
                        $.ajax({
                            url:url+"/takeOver/addTakeOver",
                            type:'post',
                            data:{
                                name:ly_people,
                                province:ly_prev,
                                city:ly_city,
                                tel_no:ly_tel,
                                town:ly_town,
                                ex:ly_xiang,
                                company_name: ly_danName
                            },
                            success:function(res){
                                if(res.err ==200 ){
                                    location.reload(true)
                                }
                            }
                        })
                    }
                $(this).removeAttr('id');
                $('.quan').fadeOut(300);

            }
        });
        // 点击索取发票
        $('.clickGetFBtn>button').click(function(){
            var flag = true;
            if(flag){
                var n = 0;
                $('input[name="adressOne"]').each(function (k,v) {
                    if($(v).prop('checked') == true){
                        n++;
                    }
                });
                if(n == 0){
                    console.log(n)
                    layer.msg('请选择您要寄送发票的地址');
                    flag = false;
                }
            }
            if (flag) {
                var num = 0;
                $('.detailX >li>span>input[type="checkbox"]').each(function (k, v) {
                    if ($(v).prop('checked') == false) {
                        num++;
                    }
                });
                if (num == $('.detailX>li').length) {
                    layer.msg('请勾选你要索取的订单');
                    flag = false;
                }
            }
            /*if (flag) {
                var ke = 0;
                $('.detailX li>span input[name="wallet"]').each(function (k, v) {
                    if ($(v).prop('checked') == true) {
                        ke += parseFloat($(v).parent().parent().children('.lyP').children('span').text())
                    }
                });
                var yin = parseFloat($('.notGt>span').text());
                if (ke > yin) {
                    layer.msg('钱包支付的订单可开发票金额不能大于 :' + yin);
                    flag = false;
                }
            }*/
            if(flag){
                var dzhiId = null,
                    cuan = '';
                $('input[name="adressOne"]').each(function (m,n) {
                    if($(n).prop('checked') == true){
                        dzhiId = $(n).parent().parent().children('span.lyxiugai').attr('id');
                        return false;
                    }
                });
                $('.detailX >li>span>input[type="checkbox"]').each(function (j,k) {
                    if($(k).prop('checked') == true){
                        cuan += $(k).parent().parent().attr('ids')+',';
                    }
                });
                $.ajax({
                    url:url+"/invoice/addValueTax",
                    type:'post',
                    data:{addId:dzhiId,f_order_form_id:cuan},
                    success:function(res) {
                        if (res.err == 200) {
                            $('.suc').fadeIn();
                        }
                    }
                });
            }
        });
    }
    messXiuGaiAdress();


}]);
// openTwo
fapiao.controller('opentwoCtrl', ['$scope', '$location', function ($scope, $location) {
    $scope.twoGetjQuery = twoGetjQuery;
    // 获取输入内容
    $scope.gsDetail = {};
    function twoGetjQuery() {
        var inputs = $('.openTwo .openTXinxi > li > input[type=text]');
        var agree = $('.openTwo .openTXinxi > .readAgree input');
        // 点击提交
        $('.open1Btn>button').on('click', function () {
            // 遍历input
            var flag = true;
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value == '') {
                    // 显示边框和文字
                    $(inputs[i]).addClass('notEmpty').next().show();
                    $(inputs[i]).parent().siblings('li').find('span').hide();
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                var len = $('#cIdCode').val().length;
                if (len != 15 && len != 18) {
                    $('#ly_people span').show();
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if (!agree.prop('checked')) {
                    layer.msg('请勾选《增票资质确认书》');
                    flag = false;
                    return flag;
                }
            }

        });
        // 获取焦点
        for (var i = 0; i < inputs.length; i++) {
            $(inputs[i]).focus(function () {
                $(this).addClass('notEmpty').parent().siblings('li:not(".readAgree")').find('input').removeClass('notEmpty').next().hide();
            })
        }
        // 失去焦点
        for (var i = 0; i < inputs.length; i++) {
            // 当前失去焦点时
            $(inputs[i]).blur(function () {
                $(this).removeClass('notEmpty').next().hide();
            })
        }
    }

    twoGetjQuery();
}]);

// openThree
fapiao.controller('openthreeCtrl', ['$scope', '$location', function ($scope, $location) {
    $scope.threeGetjQuery = threeGetjQuery;
    function threeGetjQuery() {
        // 省级联动
        $('#cacon').distpicker({
            autoSelect: false
        });
        /* =================== */
        var inputs = $('div.openThree .ThreeXi > li input[type=text]');
        // 点击下一步
        $('.openThree .open1Btn > a:first-child').on('click', function (e) {
            e.preventDefault();
            // 遍历input
            var flag = true;
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value == '') {
                    // 显示边框和文字
                    $(inputs[i]).css('border-color', '#d25174').next().show();
                    $(inputs[i]).parent().siblings('li').find('span').hide();
                    flag = false;
                    break;
                }
            }
            if (flag) {
                if ($('#lyTel').val().length != 11) {
                    layer.msg('请填写正确的手机号码');
                    flag = false;
                }
            }
            if (flag) {
                var sel = $('div.openThree .ThreeXi > li.sProvince #cacon > select');
                for (var i = 0; i < sel.length; i++) {
                    if (sel[i].value == '') {
                        layer.msg('请选择收货地址');
                        flag = false;
                        break;

                    }
                }
            }
            if (flag) {
                // 发送请求
                window.location.href = '#/detailMessage'
            }
        });
        // 获取焦点
        for (var i = 0; i < inputs.length; i++) {
            // 当前失去焦点时
            $(inputs[i]).focus(function () {
                $(this).css('border-color', '#d25174').parent().siblings('li').find('input').css('border-color', '#ccc').next().hide();
            })
        }
        // 失去焦点
        for (var i = 0; i < inputs.length; i++) {
            // 当前失去焦点时
            $(inputs[i]).blur(function () {
                $(this).css('border-color', '#ccc').next().hide();
            })
        }


    }

    threeGetjQuery();

}]);

// 获取增票信息
fapiao.controller('detailMessCtrl', ['$scope', '$http', function ($scope, $http) {
    $('.detailReviseBtn>a:last-child').click(function(){
        $scope.id = $(this).attr('ids');
        $http.get(url+'/invoice/addValueDel/'+$scope.id).success(function(res){
            if(res.err == 200){
                location.reload(true);
            }
        });
    });
}]);

// 修改增票信息
fapiao.controller('messXiuGai', ['$scope', '$http', function ($scope, $http) {
    // 省级联动
    $('#cacon').distpicker({
        autoSelect: false
    });
    function messXiuGai() {
        var inputs = $('.openTwo .openTXinxi > li > input[type=text]');
        var agree = $('.openTwo .openTXinxi > .readAgree input');
        // 点击上传
        $('#uld1 .twoJump').on('click', function (e) {
            // 遍历input
            var flag = true;
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].value == '') {
                    // 显示边框和文字
                    $(inputs[i]).addClass('notEmpty').next().show();
                    $(inputs[i]).parent().siblings('li').find('span').hide();
                    flag = false;
                    break;
                }
            }
            if (flag) {
                var len = $('#ly_people input').val().length;
                if (len != 15 && len != 18) {
                    $('#ly_people span').show();
                    flag = false;
                    return flag;
                }
            }
            if (flag) {
                if (!agree.prop('checked')) {
                    layer.msg('请勾选《增票资质确认书》');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                // 发送请求 将信息保存
                return true;
            }
        });
        // 获取焦点
        for (var i = 0; i < inputs.length; i++) {
            $(inputs[i]).focus(function () {
                $(this).addClass('notEmpty').parent().siblings('li:not(".readAgree")').find('input').removeClass('notEmpty').next().hide();
            })
        }
        // 失去焦点
        for (var i = 0; i < inputs.length; i++) {
            // 当前失去焦点时
            $(inputs[i]).blur(function () {
                $(this).removeClass('notEmpty').next().hide();
            })
        }
    }

    messXiuGai();
    // 发送请求，绑定数据
    $http.get(url+"/invoice/addValueInfo").success(function(res){
        $scope.info = res.data;
        console.log($scope.info)
    });
}]);


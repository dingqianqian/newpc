<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \Illuminate\Support\Facades\Route;
//前台
Route::group(["namespace"=>"Home","middleware"=>"city"],function ()
{
    //首页
    Route::get('/',"IndexController@index");
    //登录
    Route::get("login","LoginController@index");
    //登录验证
    Route::post("check","LoginController@check");
    //退出登录
    Route::get("logout","LoginController@logout");
    //设置城市
    Route::get("setCity","IndexController@setCity");
    //用户注册
    Route::get("register","RegisterController@index");
    //注册写入
    Route::post("user/create","RegisterController@register");
    //注册验证码
    Route::post("register/code","RegisterController@code");
    //企业采购
    Route::get("purchase","PurchaseController@index");
    //收藏展示页
    Route::get("collect/index","CollectController@index")->middleware("login");
    //常购清单展示页
    Route::get("buyList/index","BuyListController@index")->middleware("login");
    //联系我们
    Route::get("contact","ContactController@index");
    //联系我们（个人中心）
    Route::get("contact/person","ContactController@person")->middleware("login");
    //连锁品牌
    Route::get("brand/{index?}","BrandController@index");
    //加盟合作
    Route::get("join","JoinController@index")->middleware("login");
    //加入我们
    Route::get("joinUs","JoinUsController@index")->middleware("login");
    //法律声明
    Route::get("law","PactController@law");
    //条款声明
    Route::get("clause","PactController@clause");
    //会员特权页面
    Route::get("vip","VipController@index");
    //新闻页面
    Route::get("newsPhone/{id}","NewsController@mobile");
    Route::get("newsPc/{id}","NewsController@pc");
    Route::get("new/{id}","NewsController@index");
    //新闻列表页面
    Route::get("news/list","NewsController@lists");
    //底部说明页面
    Route::group(["prefix"=>"footer"],function ()
    {
        //购物流程页面
        Route::get("shop","FooterController@shop");
        //关于我们页面
        Route::get("about","FooterController@about");
        //发票制度
        Route::get("invoice","FooterController@invoice");
        //退换货流程
        Route::get("returnSale","FooterController@returnSale");
        //退换货政策
        Route::get("returnPolicy","FooterController@returnPolicy");
        //退款说明
        Route::get("refund","FooterController@refund");
    });
    //用户充值
    Route::group(["prefix"=>"recharge","middleware"=>"login"],function (){
        Route::get("index","RechargeController@index");
        Route::get("create","RechargeController@createOrder");
        //查询充值订单状态
        Route::post("getOrderStatus","RechargeController@getOrderStatus");
    });
    //钱包首页
    Route::get("wallet/index","WalletController@index")->middleware("login");
    //支付宝成功回调
    Route::any("recharge/ali/success","WalletController@payAli");
    //微信支付成功回调
    Route::any("recharge/weixin/success","WalletController@payWeixin");
    //用户浏览历史
    Route::group(["prefix"=>"browseHistory","middleware"=>"login"],function (){
        Route::get("index","BrowseHistoryController@index");
        //根据ID删除
        Route::post("delById","BrowseHistoryController@delById");
        //根据时间删除
        Route::post("delByTime","BrowseHistoryController@delByTime");
    });
    //密码找回
    Route::group(["prefix"=>"forgetPasssowrd"],function ()
    {
        //密码找回验证码
        Route::get("index","PasswordController@index");
        //发送密码找回验证码
        Route::post("sendMessage","PasswordController@sendMessage");
        //输入密码页面
        Route::any("setPwd","PasswordController@setPwd");
        //修改密码成功页面
        Route::any("success","PasswordController@success");
    });
    //购物车页面
    Route::group(["prefix"=>"shopCart","middleware"=>"login"],function ()
    {
        //购物车首页
        Route::get("index","ShopCartController@index");
        //获取购物车数量
        Route::get("getCount","ShopCartController@getCount");
        //删除购物车单个商品
        Route::post("delShopCart","ShopCartController@delShopCart");
        //删除购物车多个商品
        Route::post("delShopCartMany","ShopCartController@delShopCartMany");
        //ajax更新购物车
        Route::post("ajaxUpdateCart","ShopCartController@ajaxUpdateCart");
        //添加购物车
        Route::post('create',"ShopCartController@create");
    });
    //订单页面
    Route::group(["prefix"=>"order","middleware"=>"login"],function ()
    {
        //确认订单页面
        Route::any("create/{areaID?}/{takeOverID?}","OrderController@create");
        //生成订单
        Route::post("add","OrderController@add");
        //订单详情
        Route::get("info/{no}/{type}","OrderController@info");
        //订单支付页面
        Route::get("pay/{no}","OrderController@pay");
        //查询订单状态
        Route::post("status/{no}","OrderController@status");
        //所有订单首页
        Route::get("index/{status?}","OrderController@index");
        //ajax删除订单
        Route::post("ajaxDel/{id}","OrderController@ajaxDel");
        //ajax催单
        Route::post("reminder/{id}","OrderController@reminder");
        //ajax签收
        Route::post("signIn/{id}","OrderController@signIn");
    });
    //收货地址
    Route::group(["prefix"=>"takeOver","middleware"=>"login"],function ()
    {
        //收货地址展示页面
        Route::get("index","TakeOverController@index");
        //ajax删除收货地址
        Route::post("delTakeOver","TakeOverController@delTakeOver");
        //ajax添加收货地址
        Route::post("addTakeOver","TakeOverController@addTakeOver");
        //ajax修改收货地址
        Route::post("updateTakeOver/{id}","TakeOverController@updateTakeOver");
        //ajax设置默认收货地址
        Route::post("defaultTakeOver","TakeOverController@defaultTakeOver");
    });
    //定制信息
    Route::group(["prefix"=>"custom","middleware"=>"login"],function ()
    {
        //展示定制信息页面
        Route::get("index","CustomController@index");
        //添加定制信息
        Route::post("addCustom","CustomController@addCustom");
        //删除定制信息
        Route::post("delCustom","CustomController@delCustom");
        //修改定制信息
        Route::post("updCustom","CustomController@updCustom");
        //选定定制信息
        Route::post("chooseCustom","CustomController@chooseCustom");
    });
    //支付
    Route::group(["prefix"=>"pay"],function ()
    {
        //速立付支付
        Route::get("sulifu/{no}","PayController@sulifu")->middleware("login");
        //速立付支付结果
        Route::post("sulifuPay","PayController@sulifuPay")->middleware("login");
        //支付成功界面
        Route::get("success/{no}","PayController@success")->middleware("login");
        //支付宝支付
        Route::group(["prefix"=>"ali"],function ()
        {
            //支付宝统一下单
            Route::get("create/{no}","PayController@aliCreate")->middleware("login");
            //支付宝回调
            Route::any("/success","PayController@aliSuccess");
            //支付宝return_url
            Route::any("/aliReturn","PayController@aliReturn");
        });
        //微信支付
        Route::group(["prefix"=>"weixin"],function ()
        {
            //微信二维码页面
            Route::get("create/{no}","PayController@weixinPayCreate")->middleware("login");
            //微信支付成功回调页面
            Route::any("success","PayController@weixinPaySuccess");
        });
    });
    //二级分类
    Route::group(["prefix"=>"category"],function ()
    {
        Route::get("hotel/{id}","CategoryController@hotel");
        Route::get("house/{id}","CategoryController@house");
        Route::get("home/{id}","CategoryController@home");
        Route::get("brand/{id}","CategoryController@brand");
    });
    //签到
    Route::group(["prefix"=>"checkIn","middleware"=>"login"],function ()
    {
        Route::get("index","CheckInController@index");
        Route::post("create","CheckInController@create");
    });
    //商品详情页
    Route::group(["prefix"=>"goods"],function (){
        Route::get("index/{id}","GoodsController@index");
        //ajax收藏商品
        Route::post("collect","GoodsController@collect");
        //搜索商品
        Route::get("search","GoodsController@search");
    }
    );
    //sku级别norms
    Route::group(["prefix"=>"normsCombo"],function ()
    {
        Route::post("info","NormsComboController@getInfo");
    });
    //发票管理页面
    Route::group(["prefix"=>"invoice","middleware"=>"login"],function (){
        //发票管理首页
        Route::get("index","InvoiceController@index");
        //增值税发票
        Route::get("addTax","InvoiceController@valueAddTax");
        //增票资质信息
        Route::get("taxInfo","InvoiceController@info");
        //ajax开取普通发票
        Route::post("getInvoiveNorm","InvoiceController@addNormInvoive");
        //ajax开取增值税
        Route::post("addValueTax","InvoiceController@addValueTax");
        //增值税发票step1
//        Route::get("stepOne","InvoiceController@stepOne");
        //增值税发票step2
        Route::get("stepTwo","InvoiceController@stepTwo");
        //增值税发票确认书
        Route::get("authBook","InvoiceController@authBook");
        //添加增值税发票认证
        Route::post("create","AddValueTaxController@create");
        //修改增值税发票认证
        Route::any("update","AddValueTaxController@update");
        //ajax获取认证信息
        Route::get("addValueInfo","AddValueTaxController@ajaxInfo");
        //ajax删除认证信息
        Route::get("addValueDel/{id}","AddValueTaxController@ajaxDel");
    });
    //发票抬头管理
    Route::group(["prefix"=>"invoiceTitle","middleware"=>"login"],function (){
        //ajax增加发票抬头
        Route::post("add","InvoiceTitleController@ajaxCreate");
        //ajax编辑发票抬头
        Route::post("update","InvoiceTitleController@ajaxUpdate");
        //ajax删除发票抬头
        Route::post("del","InvoiceTitleController@ajaxDel");
    });
    //意见建议
    Route::group(["prefix"=>"advise","middleware"=>"login"],function (){
        //加载意见建议首页
        Route::get("index","AdviseController@index");
        //添加意见
        Route::post("add","AdviseController@add");
    });
    //安全设置
    Route::group(["prefix"=>"safe","middleware"=>"login"],function (){
        //设置登录密码第一步
        Route::get("password/stepOne","PasswordController@stepOne");
        //设置登录密码第二步
        Route::post("password/stepTwo","PasswordController@stepTwo");
        //设置登录密码第三步
        Route::post("password/stepThr","PasswordController@stepThr");
        //发送短信验证码
        Route::post("sendMessage","PasswordController@sendSms");
        //发送改绑的验证码
        Route::post("sendCode","PayCodeController@sendMessage");
        //支付密码
        Route::group(["prefix"=>"paycode"],function ()

        {
            Route::any("checkInfo","PayCodeController@checkInfo");
            Route::any("setPwd","PayCodeController@setPwd");
            Route::any("success","PayCodeController@success");
        });
        //改手机第一步
        Route::get("username/stepOne","UserController@stepOne");
        //改手机第二步
        Route::any("username/stepTwo","UserController@stepTwo");
        //改手机第三步
        Route::post("username/stepThr","UserController@stepThr");
        //修改的手机号发送验证码
        Route::post("username/code","UserController@code");
    });
    //优惠券
    Route::group(["prefix"=>"coupon","middleware"=>"login"],function (){
        //优惠券列表
        Route::get("index","CouponController@index");
        //删除优惠券
        Route::post("del/{id}","CouponController@delete");
    });
    //退款分组
    Route::group(["prefix"=>"refund","middleware"=>"login"],function ()
    {
        //退款首页
        Route::get("index","RefundController@index");
        //退款进度查看
        Route::get("info/{no}","RefundController@info");
        //退款处理
        Route::post("manage","RefundController@manage");
        //撤销退款
        Route::get("repeal/{no}","RefundController@repeal");
    });
    //退货分组
    Route::group(["prefix"=>"returnSale","middleware"=>"login"],function (){
        //退货首页
        Route::get("index","ReturnSaleController@index");
        //退货进度查看
        Route::get("info/{no}","ReturnSaleController@info");
        //退货处理
        Route::post("manage","ReturnSaleController@manage");
        //撤销退货
        Route::get("repeal/{no}","ReturnSaleController@repeal");
    });
    //评价中心分组
    Route::group(["prefix"=>"comment","middleware"=>"login"],function (){
        //评价中心订单列表
        Route::get("index/{type?}","CommentController@index");
        //评价订单详情页
        Route::get("info/{no}","CommentController@info");
        //再次购买
        Route::get("buy/{no}","CommentController@buy");
        //评价订单
        Route::post("order","CommentController@comment");
        //订单展示页面
        Route::get("list/{no}","CommentController@lists");
    });
    //积分分组
    Route::group(["prefix"=>"integral"],function (){
        //积分商城
        Route::group(["prefix"=>"shop"],function ()
        {
            //积分商城首页
            Route::get("index","IntegralShopController@index");
            //积分商品信息
            Route::any("getInfo/{id}","IntegralShopController@getInfo");
        });
        //我的积分
        Route::get("person","IntegralShopController@person")->middleware("login");
    });
    //个人信息分组
    Route::group(["prefix"=>"person","middleware"=>"login"],function (){
        Route::get("index","PersonController@index");
        //修改个人信息
        Route::any("update","PersonController@update");
    });
    //临时路由
    Route::group(["prefix"=>"temp"],function ()
    {
        Route::get("info","TempController@info");
        Route::get("vip","TempController@vip");
    });
    //地区相关
    Route::group(["prefix"=>"area"],function ()
    {
        Route::get("city","AreaController@cityJson");
        //地区列表
        Route::get("index","AreaController@index");
        //设置地区
        Route::get("setCity/{id}","AreaController@setCity");
    });
});
//后台
Route::group(["namespace"=>"Admin","prefix"=>"admin"],function () {
    //登录
    Route::get("login", "LoginController@login");
    //验证登录
    Route::post("checkLogin", "LoginController@checkLogin");
    //找回密码
    Route::get("forgetPassword", "PasswordController@index");
    Route::post("sendMail", "PasswordController@send");
    //退出
    Route::get("logout", "LoginController@logout");
    //提示无权限
    Route::get("forbidden", "AccessController@forbidden");


    //后台分组需要session的
    Route::group(["middleware" => "adminLogin"], function () {
        //后台首页
        Route::get("index", "IndexController@index");
        //修改密码页面
        Route::any("changePwd", "PasswordController@change");
        //修改成功
        Route::any("changePwdSuccess", "PasswordController@changePwdSuccess");
        //权限列表
        Route::group(["prefix" => "access"], function () {
            Route::post("add", "AccessController@add");
            Route::post("update/{id}", "AccessController@update");
            //ajax更新权限排序
            Route::post("sortAjax", "AccessController@sortAjax");
            //ajax更新是否显示
            Route::post("showAjax", "AccessController@showAjax");
        });
        //管理员列表
        Route::group(["prefix" => "employee"], function () {
            //添加管理员
            Route::post("add", "EmployeeController@add");
            //编辑管理员
            Route::post("update/{id}", "EmployeeController@update");
            //分配角色
            Route::post("distributeRole/{id}", "EmployeeController@distributeRole");
        });
        //催单管理
        Route::group(["prefix" => "orderform"], function () {
            //催单详情
            Route::get("info/{id}/{status?}", "OrderFormController@info")->name("orderform.info");
            //修改订单状态
            Route::post("status/{no}/{flag}", "OrderFormController@status")->name("orderform.status");
            //打印订单
            Route::get("print/{no}", "OrderFormController@printOrder")->name("orderform.print");
        });
        //角色列表
        Route::group(["prefix" => "role"], function () {
            Route::post("add", "RoleController@add");
            Route::post("update/{id}", "RoleController@update");
        });
        //商品分类管理
        Route::group(["prefix" => "category"], function () {
            Route::post("add", "CategoryController@add");
            Route::post("update/{id}", "CategoryController@update");
            //ajax更新权限排序
            Route::post("sortAjax", "CategoryController@sortAjax");
            //ajax更新是否显示
            Route::post("showAjax", "CategoryController@showAjax");
        });
        //商品管理
        Route::group(["prefix" => "goods"], function () {
            Route::post("add", "GoodsController@add")->name("goods.add");
            Route::post("update/{id}", "GoodsController@update");
            Route::post("upload", "GoodsController@upload");
            //删除商品规格图
            Route::post("delImg/{id}", "GoodsController@delImg");
            //删除商品详情图
            Route::post("delDetailsImg/{id}", "GoodsController@delDetailsImg");
        });
        //酒店
        Route::group(["prefix" => "hotel"], function () {
            //添加酒店
            Route::post("add", "HotelController@add");
            //编辑酒店
            Route::post("update/{id}", "HotelController@update");
        });
        //销售
        Route::group(["prefix" => "sell"], function () {
            //用户详情
            Route::get("info/{id}/{type}", "SellController@info");
            //单人注册图表
            Route::get("personRegisterChart/{id}", "SellController@personRegisterChart");
            //单人成交图表
            Route::get("personMoneyChart/{id}", "SellController@personMoneyChart");
        });
        //规格分组
        Route::group(["prefix" => "normsgroup"], function () {
            //处理添加
            Route::post('add', "NormsgroupController@add")->name("normsgroup.add");
            //处理编辑
            Route::post('update/{id}', "NormsgroupController@update")->name("normsgroup.update");
        });
        //部门管理
        Route::group(["prefix" => "department"], function () {
            //处理编辑
            Route::post("update/{id}", "DepartmentController@update")->name("department.update");
            //处理添加
            Route::post("add", "DepartmentController@add")->name("department.add");
        });
        //新闻管理
        Route::group(["prefix" => "news"], function () {
            //处理编辑
            Route::post("update/{id}", "NewsController@update")->name("department.update");
            //处理添加
            Route::post("add", "NewsController@add")->name("department.add");
        });
        //规格属性
        Route::group(["prefix" => "norms"], function () {
            //处理添加
            Route::post('add', "NormsController@add")->name("norms.add");
            //处理编辑
            Route::post('update/{id}', "NormsController@update")->name("norms.update");
        });
        //优惠券管理
        Route::group(["prefix" => "coupontype"], function () {
            //处理添加
            Route::post('add', "CoupontypeController@add")->name("coupontype.add");
            //处理编辑
            Route::post('update/{id}', "CoupontypeController@update")->name("coupontype.update");
        });
        //sku
        Route::group(["prefix" => "normsCombo"], function () {
            //添加sku
            Route::post("add", "NormsComboController@add");
            //编辑sku
            Route::post("update/{id}", "NormsComboController@update");
        });
        //添加充值
        Route::group(["prefix" => "rechargeType"], function () {
            //添加充值类型
            Route::post("add", "RechargeTypeController@add");
            //编辑充值类型
            Route::post("update/{id}", "RechargeTypeController@update");
            //编辑充值排序
            Route::post("sort/{id}", "RechargeTypeController@sort");
            //是否显示
            Route::post("show/{id}", "RechargeTypeController@show");
        });
        //推送管理
        Route::group(["prefix" => "push"], function () {
            //添加推送
            Route::post("add", "PushController@add");
            //编辑推送
            Route::post("update/{id}", "PushController@update");
        });
        //广播管理
        Route::group(["prefix" => "broadcastSystem"], function () {
            //处理添加
            Route::post("add", "BroadcastSystemController@add")->name("broadcastSystem.add");
            //处理编辑
            Route::post("update/{id}", "BroadcastSystemController@update")->name("broadcastSystem.update");
        });
        //商品地区折扣
        Route::group(["prefix" => "areaPrice"], function () {
            //处理折扣录入
            Route::post("add", "AreaPriceController@add")->name("areaPrice.add");
        });
        //订制套餐列表
        Route::group(["prefix" => "goodsPackage"], function () {
            //处理添加
            Route::post("add", "GoodsPackageController@add")->name("goodsPackage.add");
            //处理修改
            Route::post("update/{id}", "GoodsPackageController@update")->name("goodsPackage.update");
        });
        //加盟管理
        Route::group(["prefix" => "joinHotel"], function () {
            //处理添加
            Route::post("add", "JoinHotelController@add")->name("joinHotel.add");
            //处理修改
            Route::post("update/{id}", "JoinHotelController@update")->name("joinHotel.update");
        });
    });
    //后台分组需要权限认证的
    Route::group(["middleware" => ["access", "adminLogin"]], function () {
        //权限列表
        Route::group(["prefix" => "access"], function () {
            //权限列表
            Route::get("index", "AccessController@index")->name("access.list");
            //添加权限
            Route::get("create", "AccessController@create")->name("access.create");
            //编辑权限
            Route::get("edit/{id}", "AccessController@edit")->name("access.edit");
            //删除权限
            Route::get("delete/{id}", "AccessController@delete")->name("access.delete");
        });
        //管理员列表
        Route::group(["prefix" => "employee"], function () {
            //管理员列表
            Route::any("index", "EmployeeController@index")->name("employee.list");
            //添加管理员
            Route::get("create", "EmployeeController@create")->name("employee.create");
            //编辑管理员
            Route::get("edit/{id}", "EmployeeController@edit")->name("employee.edit");
            //删除管理员
            Route::get("delete/{id}", "EmployeeController@delete")->name("employee.delete");
            //分配角色
            Route::get("role/{id}", "EmployeeController@role")->name("role.distribute");
        });
        //角色列表
        Route::group(["prefix" => "role"], function () {
            //角色列表
            Route::get("index", "RoleController@index")->name("role.list");
            //添加角色
            Route::get("create", "RoleController@create")->name("role.create");
            //编辑角色
            Route::get("edit/{id}", "RoleController@edit")->name("role.edit");
            //删除角色
            Route::get("delete/{id}", "RoleController@delete")->name("role.delete");
        });
        //商品管理
        Route::group(["prefix" => "goods"], function () {
            //商品列表
            Route::get("index", "GoodsController@index")->name("goods.list");
            //添加商品
            Route::get("create", "GoodsController@create")->name("goods.create");
            //编辑商品
            Route::get("edit/{id}", "GoodsController@edit")->name("goods.edit");
            //删除商品
            Route::post("delete/{id}", "GoodsController@delete")->name("goods.delete");
            //更改商品状态
            Route::post("status/{id}", "GoodsController@status")->name("goods.status");
            //商品导出
            Route::get("export", "GoodsController@export")->name("goods.export");
        });
        //商品地区折扣
        Route::group(["prefix" => "areaPrice"], function () {
            //折扣列表
            Route::get("index", "AreaPriceController@index")->name("areaPrice.list");
            //折扣录入
            Route::get("create", "AreaPriceController@create")->name("areaPrice.create");
        });
        //商品分类管理
        Route::group(["prefix" => "category"], function () {
            //分类列表
            Route::get("index", "CategoryController@index")->name("category.list");
            //添加分类
            Route::get("create", "CategoryController@create")->name("category.create");
            //编辑分类
            Route::get("edit/{id}", "CategoryController@edit")->name("category.edit");
            //删除分类
            Route::get("delete/{id}", "CategoryController@delete")->name("category.delete");
        });
        //会员管理
        Route::group(["prefix" => "member"], function () {
            //会员列表
            Route::any("index", "MemberController@index")->name("member.list");
            //查看会员
            Route::get("info/{id}", "MemberController@info")->name("member.info");
            /*//添加会员
            Route::get("create","CategoryController@create")->name("category.create");
            //编辑会员
            Route::get("edit/{id}","CategoryController@edit")->name("category.edit");
            //删除会员
            Route::get("delete/{id}","CategoryController@delete")->name("category.delete");*/
        });
        //充值管理
        Route::group(['prefix' => "recharge"], function () {
            //充值列表
            Route::any('index', "RechargeController@index")->name("recharge.list");
            //查看详情
            Route::get("info/{id}", "RechargeController@info")->name("recharge.info");
            //充值导出
            Route::get("export", "RechargeController@export")->name("recharge.export");
        });
        //订单管理
        Route::group(['prefix' => "order"], function () {
            //订单列表
            Route::any("index", "OrderController@index")->name("order.list");
            //订单查询
            Route::get("search", "OrderController@search")->name("order.search");
            //订单详细信息
            Route::get("info/{id}/{status?}", "OrderController@info")->name("order.info");
            //修改订单状态
            Route::post("status/{no}/{flag}", "OrderController@status")->name("order.status");
            //打印订单
            Route::get("print/{no}", "OrderController@printOrder")->name("order.print");
            //添加订单备注
            Route::post("remark/{id}", "OrderController@remark")->name("order.remark");
            //订单导出
            Route::any("export", "OrderController@export")->name("order.export");
        });
        //发票管理
        Route::group(['prefix' => "invoice"], function () {
            //发票列表
            Route::any("index", "InvoiceController@index")->name("invoice.list");
            //发票详情
            Route::get("info/{id}", "InvoiceController@info")->name("invoice.info");
            //修改发票订单状态
            Route::post("status/{id}", "InvoiceController@status")->name("invoice.status");
            //发票导出
            Route::get("export", "InvoiceController@export")->name("export.list");
        });
        //发票审核管理
        Route::group(["prefix" => "tax"], function () {
            //审核列表
            Route::any("index", "AddValueTaxController@index")->name("tax.list");
            //审核详情页
            Route::get("info/{id}", "AddValueTaxController@info")->name("tax.info");
            //修改审核状态
            Route::post("status/{id}/{type}", "AddValueTaxController@status")->name("tax.status");
            //审核列表导出
            Route::get("export", "AddValueTaxController@export")->name("export.list");
        });
        //用户评论管理
        Route::group(["prefix" => "comment"], function () {
            //用户评论列表
            Route::any("index", "CommentController@index")->name("comment.list");
            //删除用户评论
            Route::get("delete/{id}", "CommentController@delete")->name("comment.delete");
        });
        //酒店品牌管理
        Route::group(["prefix" => "hotel"], function () {
            //酒店列表
            Route::any("index", "HotelController@index")->name("hotel.list");
            //添加酒店
            Route::get("create", "HotelController@create")->name("hotel.create");
            //编辑酒店
            Route::get("edit/{id}", "HotelController@edit")->name("hotel.edit");
            //删除酒店
            Route::get("delete/{id}", "HotelController@delete")->name("hotel.delete");
        });
        //销售管理
        Route::group(["prefix" => "sell"], function () {
            //注册用户
            Route::any("register", "SellController@register")->name("register.list");
            //个人注册用户
            Route::any("personRegister", "SellController@personRegister")->name("personRegister.list");
            //注册图表
            Route::get("registerChart", "SellController@registerChart")->name("registerChart.list");
            //成交用户
            Route::any("money", "SellController@money")->name("money.list");
            //个人成交用户
            Route::any("personMoney", "SellController@personMoney")->name("personMoney.list");
            //成交图表
            Route::get("moneyChart", "SellController@moneyChart")->name("moneyChart.list");
            //用户改绑
            Route::any("change", "SellController@change")->name("change.list");
            //用户改绑ajax
            Route::post("changeEmployee/{id}", "SellController@changeEmployee")->name("change.employee");
            //注册用户导出
            Route::get("registerExport", "SellController@registerExport")->name("registerExport.list");
            //成交用户导出
            Route::get("moneyExport", "SellController@moneyExport")->name("moneyExport.list");
            //用户改绑导出
            Route::get("changeExport", "SellController@changeExport")->name("changeExport.list");
            //注册图表导出
            Route::get("registerChartExport", "SellController@registerChartExport")->name("registerChartExport.list");
            //成交图表导出
            Route::get("moneyChartExport", "SellController@moneyChartExport")->name("moneyChartExport.list");
        });
        //统计管理
        Route::group(["prefix" => "census"], function () {
            //流量统计
            Route::get("traffic", "CensusController@traffic")->name("traffic.index");
            //客户统计
            Route::get("user", "CensusController@user")->name("userCensus.index");
            //销售统计
            Route::get("sell", "CensusController@sell")->name("sellCensus.index");
            //订单统计
            Route::get("order", "CensusController@order")->name("orderCensus.index");
        });
        //部门管理
        Route::group(["prefix" => "department"], function () {
            //部门列表
            Route::any("index", "DepartmentController@index")->name("department.list");
            //添加部门
            Route::get("create", "DepartmentController@create")->name("department.create");
            //编辑部门
            Route::get("edit/{id}", "DepartmentController@edit")->name("department.edit");
            //删除部门
            Route::post("delete/{id}", "DepartmentController@delete")->name("department.delete");
        });
        //商品规格分组
        Route::group(["prefix" => "normsgroup"], function () {
            //规格分组列表
            Route::get("index", "NormsgroupController@index")->name("normsgroup.list");
            //添加规格分组
            Route::get('create', "NormsgroupController@create")->name("normsgroup.create");
            //编辑规格分组
            Route::get('edit/{id}', "NormsgroupController@edit")->name("normsgroup.edit");
            //删除规格分组
            Route::post('delete/{id}', "NormsgroupController@delete")->name("normsgroup.delete");
        });
        //新闻管理
        Route::group(["prefix" => "news"], function () {
            //新闻列表
            Route::get("index", "NewsController@index")->name("news.list");
            //添加新闻
            Route::get("create", "NewsController@create")->name("news.create");
            //编辑新闻
            Route::get("edit/{id}", "NewsController@edit")->name("news.edit");
            //删除新闻
            Route::get("delete/{id}", "NewsController@delete")->name("news.delete");
            //查看详情
            Route::get("info/{id}", "NewsController@info")->name("news.info");
        });
        //skU管理
        Route::group(["prefix" => "normsCombo"], function () {
            //sku列表
            Route::get("index", "NormsComboController@index")->name("normsCombo.list");
            //添加sku
            Route::get("create", "NormsComboController@create")->name("normsCombo.create");
            //编辑sku
            Route::get("edit/{id}", "NormsComboController@edit")->name("normsCombo.edit");
            //删除sku
            Route::get("delete/{id}", "NormsComboController@delete")->name("normsCombo.delete");
            //sku导出
            Route::get("export", "NormsComboController@export")->name("normsCombo.export");
            //地区折扣
            Route::post("status/{id}", "NormsComboController@status")->name("normsCombo.status");
            //商品上下架
            Route::post("goodStatus/{id}", "NormsComboController@goodStatus")->name("normsCombo.goodStatus");
        });

        //商品规格属性
        Route::group(["prefix" => "norms"], function () {
            //规格属性列表
            Route::get("index", "NormsController@index")->name("norms.list");
            //添加规格属性
            Route::get('create', "NormsController@create")->name("norms.create");
            //编辑规格属性
            Route::get('edit/{id}', "NormsController@edit")->name("norms.edit");
            //删除规格属性
            Route::post('delete/{id}', "NormsController@delete")->name("norms.delete");
        });
        //优惠券类型管理
        Route::group(["prefix" => "coupontype"], function () {
            //优惠券类型列表
            Route::get("index", "CoupontypeController@index")->name("coupontype.list");
            //添加优惠券类型
            Route::get("create", "CoupontypeController@create")->name('coupontype.create');
            //编辑优惠券类型
            Route::get("edit/{id}", "CoupontypeController@edit")->name("coupontype.edit");
            //删除优惠券类型
            Route::post('delete/{id}', "CoupontypeController@delete")->name("coupontype.delete");
        });
        //优惠券列表
        Route::group(["prefix" => "coupon"], function () {
            //优惠券列表
            Route::get("index", "CouponController@index")->name("coupon.list");
            //优惠券列表导出
            Route::get("export", "CouponController@export")->name("coupon.export");
        });
        //积分兑换管理
        Route::group(["prefix" => "integral"], function () {
            //积分兑换列表
            Route::get("index", "IntegralController@index")->name("integral.list");
            //积分兑换详情
            Route::get("info/{id}", "IntegralController@info")->name("integral.info");
            //处理单号
            Route::post("doinfo/{id}", "IntegralController@doinfo")->name('integral.doinfo');
        });
        //推送管理
        Route::group(["prefix" => "push"], function () {
            //推送列表
            Route::get("index", "PushController@index")->name("push.list");
            //添加推送
            Route::get("create", "PushController@create")->name("push.create");
            //修改推送
            Route::get("edit", "PushController@edit")->name("push.edit");
            //删除推送
            Route::post("delete", "PushController@delete")->name("push.delete");
        });

        //充值类型管理
        Route::group(["prefix" => "rechargeType"], function () {
            //推送列表
            Route::get("index", "RechargeTypeController@index")->name("rechargeType.list");
            //添加推送
            Route::get("create", "RechargeTypeController@create")->name("rechargeType.create");
            //修改推送
            Route::get("edit/{id}", "RechargeTypeController@edit")->name("rechargeType.edit");
            //删除推送
            Route::post("delete/{id}", "RechargeTypeController@delete")->name("rechargeType.delete");
        });
        //催单管理
        Route::group(["prefix" => "orderform"], function () {
            //催单列表
            Route::get("index", "OrderFormController@index")->name("orderform.list");
        });
        //广播管理
        Route::group(["prefix" => "broadcastSystem"], function () {
            //广播列表
            Route::get("index", "BroadcastSystemController@index")->name("broadcastSystem.list");
            //添加广播
            Route::get("create", "BroadcastSystemController@create")->name("broadcastSystem.create");
            //修改广播
            Route::get("edit/{id}", "BroadcastSystemController@edit")->name("broadcastSystem.edit");
            //删除广播
            Route::post("delete/{id}", "BroadcastSystemController@delete")->name("broadcastSystem.delete");
        });
        //订制套餐管理
        Route::group(["prefix" => "goodsPackage"], function () {
            //订制套餐列表
            Route::get("index","GoodsPackageController@index")->name("goodsPackage.list");
            //添加订制套餐
            Route::get("create","GoodsPackageController@create")->name("goodsPackage.create");
            //修改订制套餐
            Route::get("edit/{id}","GoodsPackageController@edit")->name("goodsPackage.edit");
            //删除订制套餐
            Route::post("delete/{id}","GoodsPackageController@delete")->name("goodsPackage.delete");
            //上下架
            Route::post("status/{id}","GoodsPackageController@status")->name("goodsPackage.status");
            //套餐详情
            Route::get("info/{id}","GoodsPackageController@info")->name("goodsPackage.info");
        });
        //订制信息列表
        Route::group(["prefix"=>"custom"],function(){
           Route::get("index","CustomController@index")->name("custom.list");
        });
        //入驻管理
        Route::group(["prefix"=>"enter"],function(){
            //入驻列表
            Route::get("index","EnterController@index")->name("enter.list");
            //入驻详情
            Route::get("info/{id}","EnterController@info")->name("enter.info");
            //审核状态修改
            Route::post("status/{id}/{flag}","EnterController@status")->name("enter.status");
        });
        //加盟管理
        Route::group(["prefix"=>"joinHotel"],function(){
            //加盟列表
            Route::get("index","JoinHotelController@index")->name("joinHotel.list");
            //添加加盟酒店
            Route::get("create","JoinHotelController@create")->name("joinHotel.create");
            //修改加盟酒店
            Route::get("edit/{id}","JoinHotelController@edit")->name("joinHotel.edit");
            //删除加盟酒店
            Route::post("delete/{id}","JoinHotelController@delete")->name("joinHotel.delete");
        });
    });
});

//app
    Route::group(["prefix" => "app", "namespace" => "App",], function () {
        Route::get("vip/{id}", "VipController@explain");
        //1.11.21 冰点活动
        Route::get("active/index", "ActiveController@index")->name("active.list");
    });
//微信支付测试
    Route::any("/back", "TestController@back");
    Route::any("/sign", "TestController@sign");
    Route::any("/code", "TestController@code");
//支付宝支付测试
    Route::any("/ali/create", "AliController@create");
    Route::any("/ali/back", "AliController@back");
//前台接口测试
    Route::group(["middleware" => "cors"], function () {
        //获取商品信息
        Route::any("/getGoods", "TestController@getGoods");
        //获取选中商品信息
        Route::any("/getGoodsImg", "TestController@getGoodsImg");
    });

//练习
Route::any("/test", "TestController@test");









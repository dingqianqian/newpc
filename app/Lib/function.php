<?php
/**
 * 判断是否为11121
 * @return bool
 */
function is_11121()
{
    return in_array(date("d",time()),[1,11,21]);
}

/**
 * 微信签名算法
 * @param $arr
 * @param $key
 * @return string
 */
function sign($arr,$key)
{
    if(ksort($arr))
    {
        $str="";
        foreach ($arr as $k=>$v)
        {
            $str=$str.$k."=".$v."&";
        }
    }
    $str=$str."key=".$key;
    return strtoupper(md5($str));
}

/**
 * @param $durl
 * @return mixed
 */
function curl_file_get_contents($durl){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $durl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}

/**
 * @param $bucket
 * @param $key
 * @return array|string
 */
function getUcloud($bucket, $key) {
    //$curtime = time();
    //$curtime += 3600*24*365; // 有效期60秒
    $url = UCloud_MakePrivateUrl($bucket, $key);
    //$content = curl_file_get_contents($url);
    return $url;
}

/**
 * 生成订单号
 * @return string
 */
function make_no()
{
    return strval(date('YmdHis') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 4));
}

/**
 * 生成优惠卷编号
 * @param string $TYPE
 * @param int $LENGTH
 * @return string
 */
function make_rand_str($TYPE = 'admix', $LENGTH = 12)
{
    //dictionary
    $dictionary = array(
        'string' => 'qwertyuiopasdfghjklzxcvbnm',
        'STRING' => 'QWERTYUIOPASDFGHJKLZXCVBNM',
        'String' => 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM',
        'admix' => 'q1we3rty2ui6opa4sdf7ghj5klz8xc9vbn0m',
        'ADMIX' => 'Q1WE3RTY2UI6OPA4SDF7GHJ5KLZ8XC9VBN0M',
        'Admix' => 'Q1WE3RTY2UI6OPA4SDF7GHJ5KLZ8XC9VBN0Mq1we3rty2ui6opa4sdf7ghj5klz8xc9vbn0m',
        'num' => '1234567890',
    );
    $type = 'admix';
    if (empty($TYPE) == false) {
        $type = trim($TYPE);
    }
    $length = 8;
    if ($LENGTH > 1) {
        $length = (int)$LENGTH;
    }
    $str = '';
    switch ($type) {
        case 'string' :
            for ($i = 0; $i < $length; $i++) {
                $str .= $dictionary{$type}{rand(0, 25)};
            }
            break;
        case 'STRING' :
            for ($i = 0; $i < $length; $i++) {
                $str .= $dictionary{$type}{rand(0, 25)};
            }
            break;
        case 'String' :
            for ($i = 0; $i < $length; $i++) {
                $str .= $dictionary{$type}{rand(0, 51)};
            }
            break;
        case 'admix' :
            for ($i = 0; $i < $length; $i++) {
                $str .= $dictionary{$type}{rand(0, 35)};
            }
            break;
        case 'ADMIX' :
            for ($i = 0; $i < $length; $i++) {
                $str .= $dictionary{$type}{rand(0, 35)};
            }
            break;
        case 'Admix' :
            for ($i = 0; $i < $length; $i++) {
                $str .= $dictionary{$type}{rand(0, 71)};
            }
            break;
        case 'num' :
            for ($i = 0; $i < $length; $i++) {
                $str .= $dictionary[$type][rand(0, 9)];
            }
            break;
    }
    return $str.uniqid();
}
/*
 * 获取前一天的开始和结束时间
 */
function getLastTime()
{
    $str=date("Y-m-d",strtotime("-1 day"))." 0:0:0";
    $data["star"]=strtotime($str);
    $str=date("Y-m-d",strtotime("-1 day"))." 24:00:00";
    $data["end"]=strtotime($str);
    return $data;
}

/**
 * 获取今天的开始和结束时间
 * @return mixed
 */
function getTime()
{
    $str=date("Y-m-d",time())." 0:0:0";
    $data["star"]=strtotime($str);
    $str=date("Y-m-d",time())." 24:00:00";
    $data["end"]=strtotime($str);
    return $data;
}

/**
 * @param $multi_array
 * @param $sort_key
 * @param int $sort
 * @return bool
 */
function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){
    if(is_array($multi_array)){
        foreach ($multi_array as $row_array){
            if(is_array($row_array)){
                $key_array[] = $row_array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($key_array,$sort,$multi_array);
    return $multi_array;
}
/*
 * 判断今天昨天前天
 */
function getDay($time)
{
    //判断是否是今天
    $time=strtotime($time);
    $today=getTime();
    if ($time==$today["star"])
    {
        return "今天";
    }
    if ($time==getLastTime()["star"])
    {
        return "昨天";
    }
    if ($time==strtotime(date("Y-m-d",strtotime("-2 days"))." 0:0:0"))
    {
        return "前天";
    }
    return "";
}
/*
 * 接口数据格式返回
 */
function json($errno, $data = null, $error = 'success')
{
    if (is_null($data)) {
        $data = ['err' => $errno, 'msg' => $error];
    } elseif (is_string($data)) {
        $data = ['err' => $errno, 'msg' => $data];
    } else {
        $data = ['err' => $errno, 'msg' => $error, 'data' => $data];
    }
    return $data;
}
/*
 * 返回上午下午
 */
function getStrTime(){
    $no=date("H",time());
    if ($no>0&&$no<=6){
        return "凌晨好";
    }
    if ($no>6&&$no<12){
        return "上午好";
    }
    if ($no>=12&&$no<=18){
        return "下午好";
    }
    if ($no>18&&$no<=24){
        return "晚上好";
    }
    return "您好";
}
/*
 * 无限极分类
 */
function make_tree($list,$pk='id',$pid='parent_id',$child='child',$root=0){
    $tree=array();
    $packData=array();
    foreach ($list as  $data) {
        $packData[$data[$pk]] = $data;
    }
    foreach ($packData as $key =>$val){
        if($val[$pid]==$root){//代表跟节点
            $tree[]=& $packData[$key];
        }else{
            //找到其父类
            $packData[$val[$pid]][$child][]=& $packData[$key];
        }
    }
    return $tree;
}
/*
 * 省市一样返回一个
 */
function city_province($province,$city)
{
 if (mb_substr($province,0,2)==mb_substr($city,0,2))
 {
     return $province;
 }
 return $province.$city;
}
/*
 * 年月日返回时间抽
 */
function getTimeStamp($str)
{
    $year=mb_substr($str,0,4);
    $month=mb_substr($str,5,2);
    $day=mb_substr($str,8,2);
    return $year."/".$month."/".$day;
}
/*
 * 员工数组
 */
function isEmployee($phone)
{
    $employee=[
        18518092630,
        13811188441,
        18510780526,
        13811256130,
        13522178057,
        15501031831,
        18317712486,
        18201587410,
        13693656365,
        13521771896,
        18401448566,
        17610002505,
        13717771343,
        13671028464,
        13810117015,
        18810611091,
        13910337645,
        18210851220,
        18210019542,
        13520580923,
        18201087251,
        17710362830,
        15810352542,
        13810938168,
        18837161089,
        13673636895,
        18339292300,
        15538387160,
        17839995256,
        18137880509,
        13733837370,
        15838720720,
        18224529899,
        18538024581,
        18003828764,
        17600697839,
        15117978085,
        18801359724,
        15226593622,
        18519215354,
        18310070503,
        18611070826,
        17600147730,
        15729389665,
        15712955744,
        18810076627,
        18369907867,
        18301091060,
        18659772685,
        13051151797,
        17093039232,
        18500399207,
        13811643561,
        15926181881
    ];
    $employee=[];
    if (in_array($phone,$employee))
    {
        return false;
    }else
        {
            return true;
        }
}
/*
 * 返回员工手机号
 */
function employeePhone()
{
    return $employee=[
        '17600147730',
        '15729389665',
        '18518092630',
        '13811188441',
        '18510780526',
        '13811256130',
        '13522178057',
        '15501031831',
        '18317712486',
        '18201587410',
        '13693656365',
        '13521771896',
        '18401448566',
        '17610002505',
        '13717771343',
        '13671028464',
        '13810117015',
        '18301091060',
        '18810611091',
        '13910337645',
        '18210851220',
        '18659772685',
        '18210019542',
        '13520580923',
        '18201087251',
        '17710362830',
        '15810352542',
        '13810938168',
        '18837161089',
        '13673636895',
        '18339292300',
        '18310070503',
        '15538387160',
        '17839995256',
        '18137880509',
        '13733837370',
        '15838720720',
        '18224529899',
        '18538024581',
        '18003828764',
        '17600697839',
        '15117978085',
        '18801359724',
        '15226593622',
        '13051151797',
        '18519215354',
        '18611070826',
        '15712955744',
        '18810076627',
        '18369907867',
        '17093039232',
        '18500399207',
        '13811643561',
        '15926181881'
    ];
}
/*
 * 返回整数
 */
function getInt($int)
{
    $length=strlen($int)-1;
    $str=str_repeat(0,$length);
    return mb_substr($int,0,1)."$str";
}
/*
 * 返回大整数
 */
function getLargeInt($int)
{
    $length=strlen($int)-1;
    $str=str_repeat(0,$length);
    $temp=mb_substr($int,0,1)+1;
    return $temp."$str";
}
/*
 * 二位数组取最大值pv
 */
function getArrayMax($arr,$field)
{
    foreach ($arr as $k=>$v){
        $temp[]=$v[$field];
    }
    return max($temp);
}
/*
 * 数字转汉字
 */
function number2chinese($num,$mode = true,$sim = false){
    if(!is_numeric($num)) return '含有非数字非小数点字符！';
    $char    = $sim ? array('零','一','二','三','四','五','六','七','八','九')
        : array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖');
    $unit    = $sim ? array('','十','百','千','','万','亿','兆')
        : array('','拾','佰','仟','','萬','億','兆');
    $retval  = $mode ? '元':'点';
    //小数部分
    if(strpos($num, '.')){
        list($num,$dec) = explode('.', $num);
        $dec = strval(round($dec,2));
        if($mode){
            if (!isset($dec['0']))
            {
                $dec['0']=0;
            }
            if (!isset($dec['1']))
            {
                $dec['1']=0;
            }
            $retval .= "{$char[$dec['0']]}角{$char[$dec['1']]}分";
        }else{
            for($i = 0,$c = strlen($dec);$i < $c;$i++) {
                $retval .= $char[$dec[$i]];
            }
        }
    }
    //整数部分
    $str = $mode ? strrev(intval($num)) : strrev($num);
    for($i = 0,$c = strlen($str);$i < $c;$i++) {
        $out[$i] = $char[$str[$i]];
        if($mode){
            $out[$i] .= $str[$i] != '0'? $unit[$i%4] : '';
            if($i>1 and $str[$i]+$str[$i-1] == 0){
                $out[$i] = '';
            }
            if($i%4 == 0){
                $out[$i] .= $unit[4+floor($i/4)];
            }
        }
    }
    $retval = join('',array_reverse($out)) . $retval;
    return $retval;
}
/**
 * 获取月初时间
 */
function getMonthStar()
{
    $date=date("Y-m-01");
    return strtotime($date);
}
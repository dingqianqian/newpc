$(function () {
    var id = null;
    var cityJson = [
        {
            "id": 1,
            "name": "北京市",
            "pinyin": "beijing"
        },
        {
            "id": 2,
            "name": "天津市",
            "pinyin": "tianjin"
        },
        {
            "id": 3,
            "name": "上海市",
            "pinyin": "shanghai"
        },
        {
            "id": 4,
            "name": "重庆市",
            "pinyin": "chongqing"
        },
        {
            "id": 32,
            "name": "香港",
            "pinyin": "xianggang"
        },
        {
            "id": 33,
            "name": "澳门",
            "pinyin": "aomen"
        },
        {
            "id": 34,
            "name": "台湾省",
            "pinyin": "taiwan"
        },
        {
            "id": 35,
            "name": "石家庄",
            "pinyin": "shijiazhuang"
        },
        {
            "id": 36,
            "name": "张家口",
            "pinyin": "zhangjiakou"
        },
        {
            "id": 37,
            "name": "承德",
            "pinyin": "chengde"
        },
        {
            "id": 38,
            "name": "秦皇岛",
            "pinyin": "qinhuangdao"
        },
        {
            "id": 39,
            "name": "唐山",
            "pinyin": "tangshan"
        },
        {
            "id": 40,
            "name": "廊坊",
            "pinyin": "langfang"
        },
        {
            "id": 41,
            "name": "保定",
            "pinyin": "baoding"
        },
        {
            "id": 42,
            "name": "衡水",
            "pinyin": "hengshui"
        },
        {
            "id": 43,
            "name": "沧州",
            "pinyin": "cangzhou"
        },
        {
            "id": 44,
            "name": "邢台",
            "pinyin": "xingtai"
        },
        {
            "id": 45,
            "name": "邯郸",
            "pinyin": "handan"
        },
        {
            "id": 46,
            "name": "太原",
            "pinyin": "taiyuan"
        },
        {
            "id": 47,
            "name": "朔州",
            "pinyin": "shuozhou"
        },
        {
            "id": 48,
            "name": "大同",
            "pinyin": "datong"
        },
        {
            "id": 49,
            "name": "阳泉",
            "pinyin": "yangquan"
        },
        {
            "id": 50,
            "name": "长治",
            "pinyin": "changzhi"
        },
        {
            "id": 51,
            "name": "晋城",
            "pinyin": "jincheng"
        },
        {
            "id": 52,
            "name": "忻州",
            "pinyin": "xinzhou"
        },
        {
            "id": 53,
            "name": "晋中",
            "pinyin": "jinzhong"
        },
        {
            "id": 54,
            "name": "临汾",
            "pinyin": "linfen"
        },
        {
            "id": 55,
            "name": "吕梁",
            "pinyin": "lvliang"
        },
        {
            "id": 56,
            "name": "运城",
            "pinyin": "yuncheng"
        },
        {
            "id": 57,
            "name": "呼和浩特",
            "pinyin": "huhehaote"
        },
        {
            "id": 58,
            "name": "包头",
            "pinyin": "baotou"
        },
        {
            "id": 59,
            "name": "乌海",
            "pinyin": "wuhai"
        },
        {
            "id": 60,
            "name": "赤峰",
            "pinyin": "chifeng"
        },
        {
            "id": 61,
            "name": "通辽",
            "pinyin": "tongliao"
        },
        {
            "id": 62,
            "name": "呼伦贝尔",
            "pinyin": "hulunbeier"
        },
        {
            "id": 63,
            "name": "鄂尔多斯",
            "pinyin": "eerduosi"
        },
        {
            "id": 64,
            "name": "乌兰察布",
            "pinyin": "wulanchabu"
        },
        {
            "id": 65,
            "name": "巴彦淖尔",
            "pinyin": "bayannaoer"
        },
        {
            "id": 66,
            "name": "兴安盟",
            "pinyin": "xinganmeng"
        },
        {
            "id": 67,
            "name": "锡林郭勒盟",
            "pinyin": "xilinguolemeng"
        },
        {
            "id": 68,
            "name": "阿拉善盟",
            "pinyin": "alashanmeng"
        },
        {
            "id": 69,
            "name": "沈阳",
            "pinyin": "shenyang"
        },
        {
            "id": 70,
            "name": "朝阳",
            "pinyin": "zhaoyang"
        },
        {
            "id": 71,
            "name": "阜新",
            "pinyin": "fuxin"
        },
        {
            "id": 72,
            "name": "铁岭",
            "pinyin": "tieling"
        },
        {
            "id": 73,
            "name": "抚顺",
            "pinyin": "fushun"
        },
        {
            "id": 74,
            "name": "本溪",
            "pinyin": "benxi"
        },
        {
            "id": 75,
            "name": "辽阳",
            "pinyin": "liaoyang"
        },
        {
            "id": 76,
            "name": "鞍山",
            "pinyin": "anshan"
        },
        {
            "id": 77,
            "name": "丹东",
            "pinyin": "dandong"
        },
        {
            "id": 78,
            "name": "大连",
            "pinyin": "dalian"
        },
        {
            "id": 79,
            "name": "营口",
            "pinyin": "yingkou"
        },
        {
            "id": 80,
            "name": "盘锦",
            "pinyin": "panjin"
        },
        {
            "id": 81,
            "name": "锦州",
            "pinyin": "jinzhou"
        },
        {
            "id": 82,
            "name": "葫芦岛",
            "pinyin": "huludao"
        },
        {
            "id": 83,
            "name": "长春",
            "pinyin": "changchun"
        },
        {
            "id": 84,
            "name": "白城",
            "pinyin": "baicheng"
        },
        {
            "id": 85,
            "name": "松原",
            "pinyin": "songyuan"
        },
        {
            "id": 86,
            "name": "吉林",
            "pinyin": "jilin"
        },
        {
            "id": 87,
            "name": "四平",
            "pinyin": "siping"
        },
        {
            "id": 88,
            "name": "辽源",
            "pinyin": "liaoyuan"
        },
        {
            "id": 89,
            "name": "通化",
            "pinyin": "tonghua"
        },
        {
            "id": 90,
            "name": "白山",
            "pinyin": "baishan"
        },
        {
            "id": 91,
            "name": "延边州",
            "pinyin": "yanbianzhou"
        },
        {
            "id": 92,
            "name": "哈尔滨",
            "pinyin": "haerbin"
        },
        {
            "id": 93,
            "name": "齐齐哈尔",
            "pinyin": "qiqihaer"
        },
        {
            "id": 94,
            "name": "七台河",
            "pinyin": "qitaihe"
        },
        {
            "id": 95,
            "name": "黑河",
            "pinyin": "heihe"
        },
        {
            "id": 96,
            "name": "大庆",
            "pinyin": "daqing"
        },
        {
            "id": 97,
            "name": "鹤岗",
            "pinyin": "hegang"
        },
        {
            "id": 98,
            "name": "伊春",
            "pinyin": "yichun"
        },
        {
            "id": 99,
            "name": "佳木斯",
            "pinyin": "jiamusi"
        },
        {
            "id": 100,
            "name": "双鸭山",
            "pinyin": "shuangyashan"
        },
        {
            "id": 101,
            "name": "鸡西",
            "pinyin": "jixi"
        },
        {
            "id": 102,
            "name": "牡丹江",
            "pinyin": "mudanjiang"
        },
        {
            "id": 103,
            "name": "绥化",
            "pinyin": "suihua"
        },
        {
            "id": 104,
            "name": "大兴安岭地区",
            "pinyin": "daxinganlingdiqu"
        },
        {
            "id": 105,
            "name": "南京",
            "pinyin": "nanjing"
        },
        {
            "id": 106,
            "name": "徐州",
            "pinyin": "xuzhou"
        },
        {
            "id": 107,
            "name": "连云港",
            "pinyin": "lianyungang"
        },
        {
            "id": 108,
            "name": "宿迁",
            "pinyin": "suqian"
        },
        {
            "id": 109,
            "name": "淮安",
            "pinyin": "huaian"
        },
        {
            "id": 110,
            "name": "盐城",
            "pinyin": "yancheng"
        },
        {
            "id": 111,
            "name": "扬州",
            "pinyin": "yangzhou"
        },
        {
            "id": 112,
            "name": "泰州",
            "pinyin": "taizhou"
        },
        {
            "id": 113,
            "name": "南通",
            "pinyin": "nantong"
        },
        {
            "id": 114,
            "name": "镇江",
            "pinyin": "zhenjiang"
        },
        {
            "id": 115,
            "name": "常州",
            "pinyin": "changzhou"
        },
        {
            "id": 116,
            "name": "无锡",
            "pinyin": "wuxi"
        },
        {
            "id": 117,
            "name": "苏州",
            "pinyin": "suzhou"
        },
        {
            "id": 118,
            "name": "杭州",
            "pinyin": "hangzhou"
        },
        {
            "id": 119,
            "name": "湖州",
            "pinyin": "huzhou"
        },
        {
            "id": 120,
            "name": "嘉兴",
            "pinyin": "jiaxing"
        },
        {
            "id": 121,
            "name": "舟山",
            "pinyin": "zhoushan"
        },
        {
            "id": 122,
            "name": "宁波",
            "pinyin": "ningbo"
        },
        {
            "id": 123,
            "name": "绍兴",
            "pinyin": "shaoxing"
        },
        {
            "id": 124,
            "name": "衢州",
            "pinyin": "quzhou"
        },
        {
            "id": 125,
            "name": "金华",
            "pinyin": "jinhua"
        },
        {
            "id": 126,
            "name": "台州",
            "pinyin": "taizhou"
        },
        {
            "id": 127,
            "name": "温州",
            "pinyin": "wenzhou"
        },
        {
            "id": 128,
            "name": "丽水",
            "pinyin": "lishui"
        },
        {
            "id": 129,
            "name": "合肥",
            "pinyin": "hefei"
        },
        {
            "id": 130,
            "name": "宿州",
            "pinyin": "suzhou"
        },
        {
            "id": 131,
            "name": "淮北",
            "pinyin": "huaibei"
        },
        {
            "id": 132,
            "name": "亳州",
            "pinyin": "bozhou"
        },
        {
            "id": 133,
            "name": "阜阳",
            "pinyin": "fuyang"
        },
        {
            "id": 134,
            "name": "蚌埠",
            "pinyin": "bengbu"
        },
        {
            "id": 135,
            "name": "淮南",
            "pinyin": "huainan"
        },
        {
            "id": 136,
            "name": "滁州",
            "pinyin": "chuzhou"
        },
        {
            "id": 137,
            "name": "马鞍山",
            "pinyin": "maanshan"
        },
        {
            "id": 138,
            "name": "芜湖",
            "pinyin": "wuhu"
        },
        {
            "id": 139,
            "name": "铜陵",
            "pinyin": "tongling"
        },
        {
            "id": 140,
            "name": "安庆",
            "pinyin": "anqing"
        },
        {
            "id": 141,
            "name": "黄山",
            "pinyin": "huangshan"
        },
        {
            "id": 142,
            "name": "六安",
            "pinyin": "luan"
        },
        {
            "id": 143,
            "name": "巢湖",
            "pinyin": "chaohu"
        },
        {
            "id": 144,
            "name": "池州",
            "pinyin": "chizhou"
        },
        {
            "id": 145,
            "name": "宣城",
            "pinyin": "xuancheng"
        },
        {
            "id": 146,
            "name": "福州",
            "pinyin": "fuzhou"
        },
        {
            "id": 147,
            "name": "南平",
            "pinyin": "nanping"
        },
        {
            "id": 148,
            "name": "莆田",
            "pinyin": "putian"
        },
        {
            "id": 149,
            "name": "三明",
            "pinyin": "sanming"
        },
        {
            "id": 150,
            "name": "泉州",
            "pinyin": "quanzhou"
        },
        {
            "id": 151,
            "name": "厦门",
            "pinyin": "xiamen"
        },
        {
            "id": 152,
            "name": "漳州",
            "pinyin": "zhangzhou"
        },
        {
            "id": 153,
            "name": "龙岩",
            "pinyin": "longyan"
        },
        {
            "id": 154,
            "name": "宁德",
            "pinyin": "ningde"
        },
        {
            "id": 155,
            "name": "南昌",
            "pinyin": "nanchang"
        },
        {
            "id": 156,
            "name": "九江",
            "pinyin": "jiujiang"
        },
        {
            "id": 157,
            "name": "景德镇",
            "pinyin": "jingdezhen"
        },
        {
            "id": 158,
            "name": "鹰潭",
            "pinyin": "yingtan"
        },
        {
            "id": 159,
            "name": "新余",
            "pinyin": "xinyu"
        },
        {
            "id": 160,
            "name": "萍乡",
            "pinyin": "pingxiang"
        },
        {
            "id": 161,
            "name": "赣州",
            "pinyin": "ganzhou"
        },
        {
            "id": 162,
            "name": "上饶",
            "pinyin": "shangrao"
        },
        {
            "id": 163,
            "name": "抚州",
            "pinyin": "fuzhou"
        },
        {
            "id": 164,
            "name": "宜春",
            "pinyin": "yichun"
        },
        {
            "id": 165,
            "name": "吉安",
            "pinyin": "jian"
        },
        {
            "id": 166,
            "name": "济南",
            "pinyin": "jinan"
        },
        {
            "id": 167,
            "name": "青岛",
            "pinyin": "qingdao"
        },
        {
            "id": 168,
            "name": "聊城",
            "pinyin": "liaocheng"
        },
        {
            "id": 169,
            "name": "德州",
            "pinyin": "dezhou"
        },
        {
            "id": 170,
            "name": "东营",
            "pinyin": "dongying"
        },
        {
            "id": 171,
            "name": "淄博",
            "pinyin": "zibo"
        },
        {
            "id": 172,
            "name": "潍坊",
            "pinyin": "weifang"
        },
        {
            "id": 173,
            "name": "烟台",
            "pinyin": "yantai"
        },
        {
            "id": 174,
            "name": "威海",
            "pinyin": "weihai"
        },
        {
            "id": 175,
            "name": "日照",
            "pinyin": "rizhao"
        },
        {
            "id": 176,
            "name": "临沂",
            "pinyin": "linyi"
        },
        {
            "id": 177,
            "name": "枣庄",
            "pinyin": "zaozhuang"
        },
        {
            "id": 178,
            "name": "济宁",
            "pinyin": "jining"
        },
        {
            "id": 179,
            "name": "泰安",
            "pinyin": "taian"
        },
        {
            "id": 180,
            "name": "莱芜",
            "pinyin": "laiwu"
        },
        {
            "id": 181,
            "name": "滨州",
            "pinyin": "binzhou"
        },
        {
            "id": 182,
            "name": "菏泽",
            "pinyin": "heze"
        },
        {
            "id": 183,
            "name": "郑州",
            "pinyin": "zhengzhou"
        },
        {
            "id": 184,
            "name": "开封",
            "pinyin": "kaifeng"
        },
        {
            "id": 185,
            "name": "三门峡",
            "pinyin": "sanmenxia"
        },
        {
            "id": 186,
            "name": "洛阳",
            "pinyin": "luoyang"
        },
        {
            "id": 187,
            "name": "焦作",
            "pinyin": "jiaozuo"
        },
        {
            "id": 188,
            "name": "新乡",
            "pinyin": "xinxiang"
        },
        {
            "id": 189,
            "name": "鹤壁",
            "pinyin": "hebi"
        },
        {
            "id": 190,
            "name": "安阳",
            "pinyin": "anyang"
        },
        {
            "id": 191,
            "name": "濮阳",
            "pinyin": "puyang"
        },
        {
            "id": 192,
            "name": "商丘",
            "pinyin": "shangqiu"
        },
        {
            "id": 193,
            "name": "许昌",
            "pinyin": "xuchang"
        },
        {
            "id": 194,
            "name": "漯河",
            "pinyin": "tahe"
        },
        {
            "id": 195,
            "name": "平顶山",
            "pinyin": "pingdingshan"
        },
        {
            "id": 196,
            "name": "南阳",
            "pinyin": "nanyang"
        },
        {
            "id": 197,
            "name": "信阳",
            "pinyin": "xinyang"
        },
        {
            "id": 198,
            "name": "周口",
            "pinyin": "zhoukou"
        },
        {
            "id": 199,
            "name": "驻马店",
            "pinyin": "zhumadian"
        },
        {
            "id": 200,
            "name": "武汉",
            "pinyin": "wuhan"
        },
        {
            "id": 201,
            "name": "十堰",
            "pinyin": "shiyan"
        },
        {
            "id": 202,
            "name": "襄樊",
            "pinyin": "xiangfan"
        },
        {
            "id": 203,
            "name": "荆门",
            "pinyin": "jingmen"
        },
        {
            "id": 204,
            "name": "孝感",
            "pinyin": "xiaogan"
        },
        {
            "id": 205,
            "name": "黄冈",
            "pinyin": "huanggang"
        },
        {
            "id": 206,
            "name": "鄂州",
            "pinyin": "ezhou"
        },
        {
            "id": 207,
            "name": "黄石",
            "pinyin": "huangshi"
        },
        {
            "id": 208,
            "name": "咸宁",
            "pinyin": "xianning"
        },
        {
            "id": 209,
            "name": "荆州",
            "pinyin": "jingzhou"
        },
        {
            "id": 210,
            "name": "宜昌",
            "pinyin": "yichang"
        },
        {
            "id": 211,
            "name": "随州",
            "pinyin": "suizhou"
        },
        {
            "id": 212,
            "name": "直辖县级行政单位",
            "pinyin": "zhixiaxianjixingzhengdanwei"
        },
        {
            "id": 213,
            "name": "恩施州",
            "pinyin": "enshizhou"
        },
        {
            "id": 214,
            "name": "长沙",
            "pinyin": "changsha"
        },
        {
            "id": 215,
            "name": "张家界",
            "pinyin": "zhangjiajie"
        },
        {
            "id": 216,
            "name": "常德",
            "pinyin": "changde"
        },
        {
            "id": 217,
            "name": "益阳",
            "pinyin": "yiyang"
        },
        {
            "id": 218,
            "name": "岳阳",
            "pinyin": "yueyang"
        },
        {
            "id": 219,
            "name": "株洲",
            "pinyin": "zhuzhou"
        },
        {
            "id": 220,
            "name": "湘潭",
            "pinyin": "xiangtan"
        },
        {
            "id": 221,
            "name": "衡阳",
            "pinyin": "hengyang"
        },
        {
            "id": 222,
            "name": "郴州",
            "pinyin": "chenzhou"
        },
        {
            "id": 223,
            "name": "永州",
            "pinyin": "yongzhou"
        },
        {
            "id": 224,
            "name": "邵阳",
            "pinyin": "shaoyang"
        },
        {
            "id": 225,
            "name": "怀化",
            "pinyin": "huaihua"
        },
        {
            "id": 226,
            "name": "娄底",
            "pinyin": "loudi"
        },
        {
            "id": 227,
            "name": "湘西州",
            "pinyin": "xiangxizhou"
        },
        {
            "id": 228,
            "name": "广州",
            "pinyin": "guangzhou"
        },
        {
            "id": 229,
            "name": "深圳",
            "pinyin": "shenzhen"
        },
        {
            "id": 230,
            "name": "清远",
            "pinyin": "qingyuan"
        },
        {
            "id": 231,
            "name": "韶关",
            "pinyin": "shaoguan"
        },
        {
            "id": 232,
            "name": "河源",
            "pinyin": "heyuan"
        },
        {
            "id": 233,
            "name": "梅州",
            "pinyin": "meizhou"
        },
        {
            "id": 234,
            "name": "潮州",
            "pinyin": "chaozhou"
        },
        {
            "id": 235,
            "name": "汕头",
            "pinyin": "shantou"
        },
        {
            "id": 236,
            "name": "揭阳",
            "pinyin": "jieyang"
        },
        {
            "id": 237,
            "name": "汕尾",
            "pinyin": "shanwei"
        },
        {
            "id": 238,
            "name": "惠州",
            "pinyin": "huizhou"
        },
        {
            "id": 239,
            "name": "东莞",
            "pinyin": "dongguan"
        },
        {
            "id": 240,
            "name": "珠海",
            "pinyin": "zhuhai"
        },
        {
            "id": 241,
            "name": "中山",
            "pinyin": "zhongshan"
        },
        {
            "id": 242,
            "name": "江门",
            "pinyin": "jiangmen"
        },
        {
            "id": 243,
            "name": "佛山",
            "pinyin": "foshan"
        },
        {
            "id": 244,
            "name": "肇庆",
            "pinyin": "zhaoqing"
        },
        {
            "id": 245,
            "name": "云浮",
            "pinyin": "yunfu"
        },
        {
            "id": 246,
            "name": "阳江",
            "pinyin": "yangjiang"
        },
        {
            "id": 247,
            "name": "茂名",
            "pinyin": "maoming"
        },
        {
            "id": 248,
            "name": "湛江",
            "pinyin": "zhanjiang"
        },
        {
            "id": 249,
            "name": "南宁",
            "pinyin": "nanning"
        },
        {
            "id": 250,
            "name": "桂林",
            "pinyin": "guilin"
        },
        {
            "id": 251,
            "name": "柳州",
            "pinyin": "liuzhou"
        },
        {
            "id": 252,
            "name": "梧州",
            "pinyin": "wuzhou"
        },
        {
            "id": 253,
            "name": "贵港",
            "pinyin": "guigang"
        },
        {
            "id": 254,
            "name": "玉林",
            "pinyin": "yulin"
        },
        {
            "id": 255,
            "name": "钦州",
            "pinyin": "qinzhou"
        },
        {
            "id": 256,
            "name": "北海",
            "pinyin": "beihai"
        },
        {
            "id": 257,
            "name": "防城港",
            "pinyin": "fangchenggang"
        },
        {
            "id": 258,
            "name": "崇左",
            "pinyin": "chongzuo"
        },
        {
            "id": 259,
            "name": "百色",
            "pinyin": "bose"
        },
        {
            "id": 260,
            "name": "河池",
            "pinyin": "hechi"
        },
        {
            "id": 261,
            "name": "来宾",
            "pinyin": "laibin"
        },
        {
            "id": 262,
            "name": "贺州",
            "pinyin": "hezhou"
        },
        {
            "id": 263,
            "name": "成都",
            "pinyin": "chengdu"
        },
        {
            "id": 264,
            "name": "广元",
            "pinyin": "guangyuan"
        },
        {
            "id": 265,
            "name": "绵阳",
            "pinyin": "mianyang"
        },
        {
            "id": 266,
            "name": "德阳",
            "pinyin": "deyang"
        },
        {
            "id": 267,
            "name": "南充",
            "pinyin": "nanchong"
        },
        {
            "id": 268,
            "name": "广安",
            "pinyin": "guangan"
        },
        {
            "id": 269,
            "name": "遂宁",
            "pinyin": "suining"
        },
        {
            "id": 270,
            "name": "内江",
            "pinyin": "neijiang"
        },
        {
            "id": 271,
            "name": "乐山",
            "pinyin": "leshan"
        },
        {
            "id": 272,
            "name": "自贡",
            "pinyin": "zigong"
        },
        {
            "id": 273,
            "name": "泸州",
            "pinyin": "luzhou"
        },
        {
            "id": 274,
            "name": "宜宾",
            "pinyin": "yibin"
        },
        {
            "id": 275,
            "name": "攀枝花",
            "pinyin": "panzhihua"
        },
        {
            "id": 276,
            "name": "巴中",
            "pinyin": "bazhong"
        },
        {
            "id": 277,
            "name": "达州",
            "pinyin": "dazhou"
        },
        {
            "id": 278,
            "name": "资阳",
            "pinyin": "ziyang"
        },
        {
            "id": 279,
            "name": "眉山",
            "pinyin": "meishan"
        },
        {
            "id": 280,
            "name": "雅安",
            "pinyin": "yaan"
        },
        {
            "id": 281,
            "name": "阿坝州",
            "pinyin": "abazhou"
        },
        {
            "id": 282,
            "name": "甘孜州",
            "pinyin": "ganzizhou"
        },
        {
            "id": 283,
            "name": "凉山州",
            "pinyin": "liangshanzhou"
        },
        {
            "id": 284,
            "name": "贵阳",
            "pinyin": "guiyang"
        },
        {
            "id": 285,
            "name": "六盘水",
            "pinyin": "liupanshui"
        },
        {
            "id": 286,
            "name": "遵义",
            "pinyin": "zunyi"
        },
        {
            "id": 287,
            "name": "安顺",
            "pinyin": "anshun"
        },
        {
            "id": 288,
            "name": "毕节地区",
            "pinyin": "bijiediqu"
        },
        {
            "id": 289,
            "name": "铜仁地区",
            "pinyin": "tongrendiqu"
        },
        {
            "id": 290,
            "name": "黔东南州",
            "pinyin": "qiandongnanzhou"
        },
        {
            "id": 291,
            "name": "黔南州",
            "pinyin": "qiannanzhou"
        },
        {
            "id": 292,
            "name": "黔西南州",
            "pinyin": "qianxinanzhou"
        },
        {
            "id": 293,
            "name": "昆明",
            "pinyin": "kunming"
        },
        {
            "id": 294,
            "name": "曲靖",
            "pinyin": "qujing"
        },
        {
            "id": 295,
            "name": "玉溪",
            "pinyin": "yuxi"
        },
        {
            "id": 296,
            "name": "保山",
            "pinyin": "baoshan"
        },
        {
            "id": 297,
            "name": "昭通",
            "pinyin": "zhaotong"
        },
        {
            "id": 298,
            "name": "丽江",
            "pinyin": "lijiang"
        },
        {
            "id": 299,
            "name": "思茅",
            "pinyin": "simao"
        },
        {
            "id": 300,
            "name": "临沧",
            "pinyin": "lincang"
        },
        {
            "id": 301,
            "name": "德宏州",
            "pinyin": "dehongzhou"
        },
        {
            "id": 302,
            "name": "怒江州",
            "pinyin": "nujiangzhou"
        },
        {
            "id": 303,
            "name": "迪庆州",
            "pinyin": "diqingzhou"
        },
        {
            "id": 304,
            "name": "大理州",
            "pinyin": "dalizhou"
        },
        {
            "id": 305,
            "name": "楚雄州",
            "pinyin": "chuxiongzhou"
        },
        {
            "id": 306,
            "name": "红河州",
            "pinyin": "honghezhou"
        },
        {
            "id": 307,
            "name": "文山州",
            "pinyin": "wenshanzhou"
        },
        {
            "id": 308,
            "name": "西双版纳州",
            "pinyin": "xishuangbannazhou"
        },
        {
            "id": 309,
            "name": "拉萨",
            "pinyin": "lasa"
        },
        {
            "id": 310,
            "name": "那曲地区",
            "pinyin": "naqudiqu"
        },
        {
            "id": 311,
            "name": "昌都地区",
            "pinyin": "changdudiqu"
        },
        {
            "id": 312,
            "name": "林芝地区",
            "pinyin": "linzhidiqu"
        },
        {
            "id": 313,
            "name": "山南地区",
            "pinyin": "shannandiqu"
        },
        {
            "id": 314,
            "name": "日喀则地区",
            "pinyin": "rikazediqu"
        },
        {
            "id": 315,
            "name": "阿里地区",
            "pinyin": "alidiqu"
        },
        {
            "id": 316,
            "name": "西安",
            "pinyin": "xian"
        },
        {
            "id": 317,
            "name": "延安",
            "pinyin": "yanan"
        },
        {
            "id": 318,
            "name": "铜川",
            "pinyin": "tongchuan"
        },
        {
            "id": 319,
            "name": "渭南",
            "pinyin": "weinan"
        },
        {
            "id": 320,
            "name": "咸阳",
            "pinyin": "xianyang"
        },
        {
            "id": 321,
            "name": "宝鸡",
            "pinyin": "baoji"
        },
        {
            "id": 322,
            "name": "汉中",
            "pinyin": "hanzhong"
        },
        {
            "id": 323,
            "name": "榆林",
            "pinyin": "yulin"
        },
        {
            "id": 324,
            "name": "安康",
            "pinyin": "ankang"
        },
        {
            "id": 325,
            "name": "商洛",
            "pinyin": "shangluo"
        },
        {
            "id": 326,
            "name": "兰州",
            "pinyin": "lanzhou"
        },
        {
            "id": 327,
            "name": "嘉峪关",
            "pinyin": "jiayuguan"
        },
        {
            "id": 328,
            "name": "白银",
            "pinyin": "baiyin"
        },
        {
            "id": 329,
            "name": "天水",
            "pinyin": "tianshui"
        },
        {
            "id": 330,
            "name": "武威",
            "pinyin": "wuwei"
        },
        {
            "id": 331,
            "name": "酒泉",
            "pinyin": "jiuquan"
        },
        {
            "id": 332,
            "name": "张掖",
            "pinyin": "zhangye"
        },
        {
            "id": 333,
            "name": "庆阳",
            "pinyin": "qingyang"
        },
        {
            "id": 334,
            "name": "平凉",
            "pinyin": "pingliang"
        },
        {
            "id": 335,
            "name": "定西",
            "pinyin": "dingxi"
        },
        {
            "id": 336,
            "name": "陇南",
            "pinyin": "longnan"
        },
        {
            "id": 337,
            "name": "临夏州",
            "pinyin": "linxiazhou"
        },
        {
            "id": 338,
            "name": "甘南州",
            "pinyin": "gannanzhou"
        },
        {
            "id": 339,
            "name": "西宁",
            "pinyin": "xining"
        },
        {
            "id": 340,
            "name": "海东地区",
            "pinyin": "haidongdiqu"
        },
        {
            "id": 341,
            "name": "海北州",
            "pinyin": "haibeizhou"
        },
        {
            "id": 342,
            "name": "海南州",
            "pinyin": "hainanzhou"
        },
        {
            "id": 343,
            "name": "黄南州",
            "pinyin": "huangnanzhou"
        },
        {
            "id": 344,
            "name": "果洛州",
            "pinyin": "guoluozhou"
        },
        {
            "id": 345,
            "name": "玉树州",
            "pinyin": "yushuzhou"
        },
        {
            "id": 346,
            "name": "海西州",
            "pinyin": "haixizhou"
        },
        {
            "id": 347,
            "name": "银川",
            "pinyin": "yinchuan"
        },
        {
            "id": 348,
            "name": "石嘴山",
            "pinyin": "shizuishan"
        },
        {
            "id": 349,
            "name": "吴忠",
            "pinyin": "wuzhong"
        },
        {
            "id": 350,
            "name": "固原",
            "pinyin": "guyuan"
        },
        {
            "id": 351,
            "name": "中卫",
            "pinyin": "zhongwei"
        },
        {
            "id": 352,
            "name": "乌鲁木齐",
            "pinyin": "wulumuqi"
        },
        {
            "id": 353,
            "name": "克拉玛依",
            "pinyin": "kelamayi"
        },
        {
            "id": 354,
            "name": "自治区直辖县级行政单位",
            "pinyin": "zizhiquzhixiaxianjixingzhengdanwei"
        },
        {
            "id": 355,
            "name": "喀什地区",
            "pinyin": "kashidiqu"
        },
        {
            "id": 356,
            "name": "阿克苏地区",
            "pinyin": "akesudiqu"
        },
        {
            "id": 357,
            "name": "和田地区",
            "pinyin": "hetiandiqu"
        },
        {
            "id": 358,
            "name": "吐鲁番地区",
            "pinyin": "tulufandiqu"
        },
        {
            "id": 359,
            "name": "哈密地区",
            "pinyin": "hamidiqu"
        },
        {
            "id": 360,
            "name": "克孜勒苏柯州",
            "pinyin": "kezilesukezhou"
        },
        {
            "id": 361,
            "name": "博尔塔拉州",
            "pinyin": "boertalazhou"
        },
        {
            "id": 362,
            "name": "昌吉州",
            "pinyin": "changjizhou"
        },
        {
            "id": 363,
            "name": "巴音郭楞州",
            "pinyin": "bayinguolengzhou"
        },
        {
            "id": 364,
            "name": "伊犁州",
            "pinyin": "yilizhou"
        },
        {
            "id": 365,
            "name": "塔城地区",
            "pinyin": "tachengdiqu"
        },
        {
            "id": 366,
            "name": "阿勒泰地区",
            "pinyin": "aletaidiqu"
        },
        {
            "id": 370,
            "name": "海口",
            "pinyin": "haikou"
        },
        {
            "id": 371,
            "name": "三亚",
            "pinyin": "sanya"
        }
    ];
    var flag = -1;
    var length = null;
    $('#inputBox').bind('input propertyChange', function () {
        var cityAry = [];
        flag = -1;
        $('.city_right ul').fadeIn();
        var val = $('#inputBox').val().replace(/\d/g, function () {
            return '';
        });
        if (val == '') {
            $('.city_right ul').fadeOut();
            return;
        }
        if (/^[a-zA-Z]+/i.test(val)) {
            $.each(cityJson, function (index, item) {
                if (item.pinyin.indexOf(val) >= 0) {
                    cityAry.push(item.name);
                }
            });
        } else if (/^[\u4e00-\u9fa5]+/.test(val)) {
            $.each(cityJson, function (index, item) {
                if (item.name.indexOf(val) >= 0) {
                    cityAry.push(item.name);
                }
            });
        }
        var str = '';
        $.each(cityAry, function (index, item) {
            str += "<li>" + item + "</li>";
        });
        $('.city_right ul').html(str);
        length = cityAry.length;
    }).keydown(function (e) {
        var key = e.keyCode;
        if (key == 38 || key == 40) {
            e.preventDefault();
            if (key == 38) {
                flag--;
                flag = flag < 0 ? length - 1 : flag;
            } else if (key == 40) {
                flag++;
                flag = flag > length - 1 ? 0 : flag;
            }
            $('.city_right ul').find("li").eq(flag).css({
                "backgroundColor": "#ccc",
                "color": "#fff"
            }).siblings('li').css({"backgroundColor": "#fff", "color": "#333"});
        }
        //点击回车，进行搜索
        if (key == 13) {
            var val = $('#inputBox').val();
            if (/^[\u4e00-\u9fa5]+$/.test(val)) {
                $.each(cityJson, function (index, item) {
                    if (item.name == val) {
                        id = item.id;
                    }
                });
                location.href = url + "/area/setCity/" + id;
            } else {
                alert('对不起，没有找到该城市！');
            }
        }
    }).blur(function () {
        $('.city_right ul').fadeOut();
    });
    //点击搜索
    $('#a').click(function () {
        var val = $('#inputBox').val();
        if (/^[\u4e00-\u9fa5]+$/.test(val)) {
            $.each(cityJson, function (index, item) {
                if (item.name == val) {
                    id = item.id;
                }
            });
            location.href = url + "/area/setCity/" + id;
        } else {
            alert('对不起，没有找到该城市！');
        }
    });
    //点击下拉框
    $('.city_right ul').on('click', 'li', function () {
        var ad = null;
        var val = $(this).text();
        $.each(cityJson, function (index, item) {
            if (item.name == val) {
                ad = item.id;
            }
        });
        location.href = url + "/area/setCity/" + ad;
    }).on('mouseenter', 'li', function () {
        flag = $(this).index();
        $(this).css({
            "backgroundColor": "#ccc",
            "color": "#fff"
        }).siblings('li').css({"backgroundColor": "#fff", "color": "#333"})
    })
});

//# sourceMappingURL=modifyAddress.js.map
<?php

namespace App\Jobs;

use App\Model\Goods;
use App\Model\GoodsEvaluate;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CommentGoods implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starTime;
    protected $endTime;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starTime,$endTime)
    {
        //
        $this->starTime=$starTime;
        $this->endTime=$endTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GoodsEvaluate $goodsEvaluate,User $user,Goods $goods)
    {
        //
        //随机商品刷评论
        //1.随机一个已经存在的用户
        for ($i=561;$i<=1008;$i++)
        {
            $userID=mt_rand(0,2019);
            while (!$userInfo=$user::find($userID))
            {
                $userID=mt_rand(0,2019);
            }
            if (!$goodsInfo=$goods::find($i))
            {
                continue;
            }
            if ($goodsEvaluate::whereBetween("create_time",[$this->starTime,$this->endTime])->where("f_goods_id",$i)->count()>mt_rand(6,10))
            {
                continue;
            }
            $arr=[
                '客服的服务态度真好，发货很快。商品质量也相当不错。太喜欢了，谢谢！',
                '物流真快！商品这么快就到了，还不错哦，下次来你可要优惠哦^_^ ',
                '网上购物这么激烈，没想到商城的服务这么好，商品质量好而价低廉，我太感谢你了！',
                '有了问题能很好的处理，可以信赖的好平台，以后有机会我们再来。',
                '价格大众化，质量很好呀，都是正品，如果有需要我还会继续光顾你的商城！',
                '终于收到啦~~好开心那！',
                '质量非常好，与卖家描述的完全一致，非常满意！包装非常仔细、严密，物流公司服务态度很好，运送 质量很好，希望更多的朋友信赖。客服态度特好，我会再次光顾的',
                '质量很好，希望更多的朋友信赖',
                '商城态度特好，我会再次光顾的',
                '可不可以再便宜点．我带朋友来你家买。',
                '一个字好，两个字很好，三个字太好了！哈哈……',
                '信誉很好，，，，，，发货很及时',
                '不错啊还会来的！',
                '很热情的卖家，下次还来',
                '产品不错，是正品，再来光顾……～',
                '东西很满意速度很快有机会我还会再来的呵呵合作愉快哦',
                '很难得的正品，网购以来最满意的了',
                '偶还来哈！哈哈，要记得偶啦',
                '货已收到给个好评',
                '发货速度很快哦，东西很赞！！',
                '东西很实惠哦，支持卖家',
                '最近太忙了，确认晚了，东西是很好的，呵呵，谢了。',
                '还不错，质量挺好的，速度也快！',
                '很好，加一分。呵呵',
                '西西。多多光顾。西西。加油加油。生意欣荣',
            ];
            $temp['content']=$arr[mt_rand(0,24)];
            $temp['favor_degree']=mt_rand(4,5);
            $temp['f_goods_id']=$i;
            $temp['f_order_goods_id']=0;
            $temp['f_user_id']=$userID;
            $temp['create_time']=mt_rand($this->starTime,$this->endTime);
            $temp['f_user_name']=$userInfo->username?$userInfo->username:"宜优速用户";
            $goodsEvaluate->create($temp);
        }
    }
}

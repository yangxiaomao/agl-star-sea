<?php

namespace Yangxm\StarSea\Tool;

class Weixin
{
    /**
     * TODO 模拟微信群发红包
     * @param   int     $totalAmount        红包总金额 (分)
     * @param   int     $count              红包数量
     * @return  array                       红包数组
     * DATE: 2021/12/30
     * Author: Yxm
     */

    public function wxGroupRed($totalAmount, $count){
        $reward = [
            'count'=>$count,
            'amount'=>$totalAmount,
            'remainCount'=>$count,
            'remainAmount'=>$totalAmount,
            'bestAmount'=>0,
            'bestAmountIndex'=>0
        ];

        $redArr = [];

        for($i=0; $reward['remainCount'] > 0; $i++){
            $amount = $this->grabReward($reward);
            if($amount > $reward['bestAmount']){
                $reward['bestAmountIndex'] = $i;
                $reward['bestAmount'] = $amount;
            }
            array_push($redArr, $amount);
        }

        $newRedArr = [];
        foreach($redArr as $key=>$val){
            $newRedArr[$key]['amount'] = $val;
            if($reward['bestAmountIndex'] == $key){
                // 手气最佳
                $newRedArr[$key]['isBest'] = 1;
            }else{
                $newRedArr[$key]['isBest'] = 0;
            }

        }
        return $newRedArr;

    }
    /**
     * TODO 模拟微信群发红包
     * @param   array     $reward           红包数据
     * @return  int                         红包金额
     * DATE: 2021/12/30
     * Author: Yxm
     */

    private function grabReward(array &$reward){

        //如果剩余红包不存
        if ($reward['remainCount'] <= 0){
            return ['code'=>10001, 'msg'=>'RemmainCount <= 0', 'data'=>[]];
        }

        //如果还剩最后一个红包
        if ($reward['remainCount'] == 1){
            $amount = $reward['remainAmount'];
            $reward['remainCount'] = 0;
            $reward['remainAmount'] = 0;
            return $amount;
        }

        //是否可以直接0.01
        if (($reward['remainAmount'] / $reward['remainCount']) == 1) {
            $amount = 1;
            $reward['remainAmount'] -= $amount;
            $reward['remainCount']--;
            return $amount;
        }

        //最大可领金额 = 剩余金额的平均值X2 = （剩余金额 / 剩余数量） * 2
        //领取金额范围 = 0.01 ~ 最大可领金额
        $maxAmount = intval($reward['remainAmount'] / $reward['remainCount']) * 2;
        $amount = rand(1, $maxAmount);
        $reward['remainAmount'] -= $amount;

        // 防止剩余金额为负数
        if ($reward['remainAmount'] < 0){
            $amount += $reward['remainAmount'];
            $reward['remainAmount'] = 0;
            $reward['remainCount'] = 0;
        }else{
            $reward['remainCount']--;
        }

        return $amount;

    }
}
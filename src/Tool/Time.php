<?php

namespace Agl\StarSea\Tool;

class Time
{
    /**
     * TODO 把指定时间段切分 - N份
     * @param   string  $start      开始时间
     * @param   string  $end        结束时间
     * @param   int     $nums       切分数目
     * @param   int     $day_at     开始时间零点时间
     * @param   boolean $format     是否格式化
     * @return  array               时间段数组
     * DATE: 2021/12/30
     * Author: Yxm
     */

    public function splitTimeSlot($start, $end="", $nums = 7, $day_at, $format=true){
        //获取开始小时
        $start_at = $start - $day_at;
        $parts = ($end - $start)/$nums;
        $last= ($end - $start)%$nums;
        if ( $last > 0) {
            $parts = ($end - $start - $last)/$nums;
        }
        for ($i=1; $i <= $nums; $i++) {
            $_end= $start_at + $parts * $i;
            $arr[] = array($start_at + $parts * ($i-1), $_end);
        }
        $len = count($arr)-1;
        $arr[$len][1] = $arr[$len][1] + $last;
        if ($format) {
            $timeArr = [];
            foreach ($arr as $key => $value) {
                $timeArr[$key]['start_at'] = $value[0];
                $timeArr[$key]['end_at'] = $value[1];
            }
        }
        return $timeArr;
    }
}
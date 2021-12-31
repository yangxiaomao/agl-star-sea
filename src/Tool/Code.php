<?php

namespace Yangxm\StarSea\Tool;

class Code
{
    /**
     * TODO 邀请码、订单号，生成
     * DATE: 2021/12/30
     * Author: Yxm
     */

    public function createCode($num, $digit = 6) {
        static $sourceString = [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        ];

        $code = '';
        while ($num) {
            $mod = $num % 9;
            $num = (int) ($num / 9);
            $code = "{$sourceString[$mod]}{$code}";
        }
        //判断code的长度
        if (empty($code[$digit])) {
            $code = str_pad($code, $digit, rand(0,9), STR_PAD_RIGHT);
        }
        return $code;
    }
}
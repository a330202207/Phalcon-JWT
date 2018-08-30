<?php
/**
 * @purpose:
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/29
 */


namespace Apps\Payment\Controllers;

use Apps\Payment\Models\WithdrawPromoter;

class OrderTaskController extends PaymentBaseController
{
    public function mainAction(array $params){
        start:
        $this->addData();
        sleep(2);
        goto start;
    }

    private function addData()
    {
        $obj = new WithdrawPromoter();
        $obj->sync2Alert();
    }
}
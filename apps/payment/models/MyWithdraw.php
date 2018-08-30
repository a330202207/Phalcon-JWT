<?php
/**
 * @purpose:
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/29
 */


namespace Apps\Payment\Models;


class MyWithdraw extends PaymentBase
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('withdraw');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'withdraw_promoter';
    }

    public function sync2Alert($start_time = null)
    {
        if (null == $start_time) {
            $start_time = strtotime('-30 second');
        }
        $sql = "SELECT
                    'withdraw',
                    'id',
                    id,
                    created,
                    '玩家提现订单'
                FROM
                    withdraw
                WHERE
                    unix_timestamp(created) < $start_time
                AND id NOT IN ()";
        $db = $this->getWriteConnection();
        $rs = $db->query($sql);
        return $rs;
    }
}
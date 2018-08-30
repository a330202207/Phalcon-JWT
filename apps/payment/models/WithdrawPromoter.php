<?php
/**
 * @purpose:
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/29
 */


namespace Apps\Payment\Models;

use core\library\MyRedis;

class WithdrawPromoter extends PaymentBase
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('withdraw_promoter');
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

    /**
     * @notes: 添加消息
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/29
     * @param null $start_time
     */
    public function sync2Alert($start_time = null)
    {
        if (null == $start_time) {
            $start_time = strtotime('-10 minute');
        }

        $cache_prefix = "withdraw";
        $keys = MyRedis::hKeys($cache_prefix);
        $ids = implode(',', array_map(function ($value) {
            return "'" . $value . "'";
        }, $keys));


        $sql = "SELECT
                    id,
                    status,
                    created
                FROM
                    withdraw_promoter
                WHERE
                    unix_timestamp(created) < $start_time";

        if (!empty($ids)) {
            $sql .= "AND id NOT IN ($ids)";
        }
        print_r($sql);die;
        $db = $this->getReadConnection();
        $rs = $db->query($sql);

        $rs->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        $list = [];
        while ($row = $rs->fetch()) {
            $list[] = $row;
        }

        $list = array_column($list, null, 'id');

        MyRedis::hMset($cache_prefix, $list);
    }

}
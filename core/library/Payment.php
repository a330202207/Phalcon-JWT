<?php
/**
 * @purpose: 支付接口
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/28
 */


namespace core\library;


interface Payment
{
    /**
     * @notes: 发起支付
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/28
     * @param array $params
     * @return mixed
     */
    public static function payment(array $params);

    /**
     * @notes: 组建支付数据
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/28
     * @param array $params
     * @return mixed
     */
    public static function buildData(array $params);


    /**
     * @notes: 验签数据
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     * @return mixed
     */
    public static function verifyData(array $params);

    /**
     * @notes:
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     * @return mixed
     */
    public static function callBack(array $params);

}
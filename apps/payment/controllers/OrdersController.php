<?php
/**
 * @purpose:
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/29
 */


namespace Apps\Payment\Controllers;

use Apps\Payment\Models\WithdrawPromoter;
use Apps\Payment\Models\MyWithdraw;
use core\library\MyRedis;
use core\library\Redis\Redis;

class OrdersController extends PaymentBaseController
{
    public $page_size = 5;

    /**
     * @notes: 获取 hash 表类型
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/29
     * @param int $type
     * @return string
     * @throws \Exception
     */
    private function getType(int $type)
    {
        switch ($type) {
            case 1:
                $cache_prefix = "withdraw";
                break;
            case 2:
                $cache_prefix = "withdraw_promoter";
                break;
            default:
                throw new \Exception("type类型错误！");
                break;
        }

        return $cache_prefix;
    }

    public function addDataAction()
    {
        $obj = new WithdrawPromoter();
        $obj->sync2Alert();
    }

    /**
     * @notes: 获取状态类型
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/29
     * @param int $status
     * @return int|string
     * @throws \Exception
     */
    private function getStatus(int $status)
    {
        switch ($status) {
            case 1:
                $status = "新订单";
                break;
            case 2:
                $status = "已审核";
                break;
            case 3:
                $status = "已审核";
                break;
            default:
                throw new \Exception("状态类型错误！");
                break;
        }
        return $status;
    }

    /**
     * @notes: 获取数据
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/29
     * @param string $cache_prefix
     * @return array
     * @throws \Exception
     */
    private function getData(string $cache_prefix)
    {
        $keys = MyRedis::hKeys($cache_prefix);

        if ($keys == 0) {
            throw new \Exception("消息为空");
        }

        $count = count($keys);

        $this->page_size = $count < $this->page_size ? $count : $this->page_size;

        $data = array_slice($keys, 0, $this->page_size);

        $arr = [];
        foreach ($data as $key) {
            $arr[$key] = MyRedis::hget($cache_prefix, $key);
        }

        foreach ($arr as $key => $val) {
            $arr[$key]['status'] = $this->getStatus($val['status']);
        }

        return array_values($arr);
    }

    /**
     * @notes: $type
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/29
     * @param int $type
     * @return string
     */
    public function getListAction(int $type)
    {
        try {
            $cache_prefix = $this->getType($type);
            $data = $this->getData($cache_prefix);
            return json_encode(['data' => $data]);
        } catch (\Exception $e) {
            return json_encode(['msg' => $e->getMessage()]);

        }
    }

    /**
     * @notes: 添加消息
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/29
     * @param int $type
     * @param int $id
     * @param int $status
     * @return bool|string
     */
    public function addAction(int $type, int $id, int $status)
    {
        try {
            $cache_prefix = $this->getType($type);
            $data = [$id => ['id' => $id, 'status' => $status, 'created' => date('Y:m:d H:i:s')]];
            $res = MyRedis::hMset($cache_prefix, $data);
            if ($res) {
                return true;
            } else {
                throw new \Exception("添加消息失败！");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @notes: 修改消息
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/29
     * @param int $type
     * @param int $id
     * @param int $status
     * @return bool|string
     */
    public function edit(int $type, int $id, int $status)
    {
        try {
            $cache_prefix = $this->getType($type);
            $data = [$id => ['id' => $id, 'status' => $status, 'created' => date('Y:m:d H:i:s')]];
            $res = MyRedis::hMset($cache_prefix, $data);
            if ($res) {
                return true;
            } else {
                throw new \Exception("添加消息失败！");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @notes: 删除消息
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/29
     * @param $type
     * @param $id
     * @return bool
     */
    public function delAction($type, $id)
    {
        try {
            $cache_prefix = $this->getType($type);
            $res = MyRedis::hDel($cache_prefix, $id);
            if ($res == 1) {
                return true;
            } else {
                throw new \Exception("删除消息失败！");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


}
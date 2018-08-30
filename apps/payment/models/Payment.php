<?php
/**
 * @purpose: 支付模型
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/23
 */
namespace Apps\Payment\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class Payment extends PaymentBase
{

    /**
     * 
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     * 订单号ID
     * @var string
     * @Column(type="string", length=32, nullable=false)
     */
    public $order_id;

    /**
     * 金额(单位分)
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $amount;

    /**
     * 调用支付平台类型；1：银河支付 2：Wispay支付 3：杉德支付
     * @var string
     * @Column(type="string", length=2, nullable=false)
     */
    public $type;

    /**
     * 支付卡类型 01:储蓄卡 02:信用卡
     * @var string
     * @Column(type="integer", length=1, nullable=false)
     */
    public $card_type;

    /**
     * 支付产品类型 00:网银 01:快捷 10:微信H5 11:支付宝 12:京东H5 13:银联支付 20:QQ钱包 21:京东钱包 30:银联扫描 31:支付宝扫描
     * @var string
     * @Column(type="string", length=2, nullable=false)
     */
    public $pay_type;

    /**
     * 支付状态 0：发起支付  1：支付完成  2：支付失败
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $status;

    /**
     * 来源 
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $from_type;

    /**
     * 交易日期(yyyymmdd)
     * @var string
     * @Column(type="string", length=8, nullable=false)
     */
    public $trans_date;

    /**
     * 交易时间(HHmmss)
     * @var string
     * @Column(type="string", length=8, nullable=false)
     */
    public $trans_time;

    /**
     * 来源类型 1：PC端） 2：手机端
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $channel;

    /**
     * 创建时间
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $created_at;

    /**
     * 更新时间
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('pg_payment');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pg_payment';
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();
        $validator->add(
            [
                'order_id',
                'amount',
                'card_type',
                'pay_type',
                'channel',
                'from_type',
                'type',
            ],
            new PresenceOf(
                [
                    'message' => [
                        'order_id' => 'The order_id is required',
                        'amount' => 'The amount is required',
                        'card_type' => 'The card_type is required',
                        'pay_type' => 'The pay_type is required',
                        'channel' => 'The channel is required',
                        'from_type' => 'The from_type is required',
                        'type' => 'The type is required',
                    ]
                ]
            )
        );

        return $this->validate($validator);
    }




    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'order_id' => 'order_id',
            'amount' => 'amount',
            'type' => 'type',
            'card_type' => 'card_type',
            'pay_type' => 'pay_type',
            'status' => 'status',
            'from_type' => 'from_type',
            'trans_date' => 'trans_date',
            'trans_time' => 'trans_time',
            'channel' => 'channel',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at'
        ];
    }

}

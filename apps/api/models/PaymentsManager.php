<?php

namespace Apps\Api\Models;

class PaymentsManager extends ApiBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=6, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(type="string", length=12, nullable=false)
     */
    protected $name;

    /**
     *
     * @var string
     * @Column(type="string", length=12, nullable=false)
     */
    protected $nickname;

    /**
     *
     * @var string
     * @Column(type="string", length=12, nullable=false)
     */
    protected $order_no;


    /**
     *
     * @var int
     * @Column(type="int")
     */
    protected $open_type;

    /**
     *
     * @var double
     * @Column(type="double", length=8, nullable=false)
     */
    protected $amount;

    /**
     *
     * @var double
     * @Column(type="double", length=8, nullable=false)
     */
    protected $amount_min;

    /**
     *
     * @var double
     * @Column(type="float", length=8, nullable=false)
     */
    protected $amount_span;
    /**
     *
     * @var double
     * @Column(type="double", length=8, nullable=false)
     */
    protected $amount_max;
    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=true)
     */
    protected $describe;

    
    /**
     *
     * @var double
     * @Column(type="tinyint", length=8, nullable=false)
     */
    protected $payment_weixin;
    protected $payment_wc2bank;
    
    /**
     *
     * @var double
     * @Column(type="tinyint", length=1, nullable=false)
     */
    protected $payment_alipay;
    protected $payment_alipay2bank;
    
    
    /**
     *
     * @var double
     * @Column(type="tinyint", length=1, nullable=false)
     */
    protected $payment_bank;
    
    /**
     *
     * @var double
     * @Column(type="tinyint", length=1, nullable=false)
     */
    protected $payment_qqpay;
    
    
    /**
     *
     * @var double
     * @Column(type="tinyint", length=1, nullable=false)
     */
    protected $payment_tfpay;
    
    
    /**
     *
     * @var double
     * @Column(type="tinyint", length=1, nullable=false)
     */
    protected $expend_alipay;
    
    /**
     *
     * @var double
     * @Column(type="tinyint", length=1, nullable=false)
     */
    protected $expend_bank;

    
    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    protected $status;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $isdefault;
    
    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $is_expend_default;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $created;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $modified;

    /**
     *
     * @var string
     * @Column(type="string", length=12, nullable=true)
     */
    protected $operator;
    protected $seed;
    public function setSeed($v){
        $this->seed=$v;
        return $this;
    }
    public function getSeed(){
        return $this->seed;
    }
    protected $user_rate;
    public function getUserRate(){
        return $this->user_rate;
    }
    public function setUserRate($v){
        $this->user_rate=$v;
        return $this;
    }
    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field nickname
     *
     * @param string $nickname
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Method to set the value of field order_no
     *
     * @param string $order_no
     * @return $this
     */
    public function setOrderNo($order_no)
    {
        $this->order_no = $order_no;

        return $this;
    }

    /**
     * Method to set the value of field nickname
     *
     * @param string $nickname
     * @return $this
     */
    public function setOpenType($open_type)
    {
        $this->open_type = $open_type;

        return $this;
    }

    /**
     * Method to set the value of field amount
     *
     * @param double $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Method to set the value of field amount
     *
     * @param double $amount_min
     * @return $this
     */
    public function setAmountMin($amount_min)
    {
        $this->amount_min = $amount_min;

        return $this;
    }

    /**
     * Method to set the value of field amount
     *
     * @param double $amount_max
     * @return $this
     */
    public function setAmountMax($amount_max)
    {
        $this->amount_max = $amount_max;

        return $this;
    }
    public function setAmountSpan($amount_span)
    {
        $this->amount_span = $amount_span;

        return $this;
    }

    /**
     * Method to set the value of field describe
     *
     * @param string $describe
     * @return $this
     */
    public function setDescribe($describe)
    {
        $this->describe = $describe;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Method to set the value of field isdefault
     *
     * @param integer $isdefault
     * @return $this
     */
    public function setIsdefault($isdefault)
    {
        $this->isdefault = $isdefault;

        return $this;
    }

    /**
     * Method to set the value of field created
     *
     * @param string $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Method to set the value of field modified
     *
     * @param string $modified
     * @return $this
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Method to set the value of field operator
     *
     * @param string $operator
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }
    
    /**
     * 
     * @param int $alipay
     * @return \Apps\Models\PaymentsManager
     */
    public function setPaymentAlipay($alipay)
    {
    	$this->payment_alipay = $alipay;
    	
    	return $this;
    }
    public function setPaymentAlipay2Bank($alipay2bank)
    {
    	$this->payment_alipay2bank = $alipay2bank;
    	
    	return $this;
    }
    
    /**
     * 
     * @param int $weixin
     * @return \Apps\Models\PaymentsManager
     */
    public function setPaymentWeixin($weixin)
    {
    	$this->payment_weixin = $weixin;
    	
    	return $this;
    }
    public function setPaymentWc2bank($wc2bank)
    {
    	$this->payment_wc2bank = $wc2bank;
    	
    	return $this;
    }
    
    /**
     * 
     * @param int $bank
     * @return \Apps\Models\PaymentsManager
     */
    public function setPaymentBank($bank)
    {
    	$this->payment_bank = $bank;
    	
    	return $this;
    }
    
    /**
     *
     * @param int $bank
     * @return \Apps\Models\PaymentsManager
     */
    public function setPaymentQqpay($qqpay)
    {
    	$this->payment_qqpay = $qqpay;
    	
    	return $this;
    }
    
    /**
     *
     * @param int $bank
     * @return \Apps\Models\PaymentsManager
     */
    public function setPaymentTfpay($tfpay)
    {
    	$this->payment_tfpay = $tfpay;
    	
    	return $this;
    }
    
    /**
     * 
     * @param int $bank
     * @return \Apps\Models\PaymentsManager
     */
    public function setExpendBank($bank)
    {
    	$this->expend_bank = $bank;
    	
    	return $this;
    }
    
    /**
     * 
     * @param int $alipay
     * @return \Apps\Models\PaymentsManager
     */
    public function setExpendAlipay($alipay)
    {
    	$this->expend_alipay = $alipay;
    	
    	return $this;
    }
    
    /**
     *
     * @param int $is_expend_default
     * @return \Apps\Models\PaymentsManager
     */
    public function setIsExpendDefault($is_expend_default)
    {
    	$this->is_expend_default = $is_expend_default;
    	
    	return $this;
    }
    

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Returns the value of field nickname
     *
     * @return string
     */
    public function getOrderNo()
    {
        return $this->order_no;
    }

    /**
     * Returns the value of field nickname
     *
     * @return string
     */
    public function getOpenType()
    {
        return $this->open_type;
    }

    /**
     * Returns the value of field amount
     *
     * @return double
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Returns the value of field amount
     *
     * @return double
     */
    public function getAmountMin()
    {
        return $this->amount_min;
    }

    /**
     * Returns the value of field amount
     *
     * @return double
     */
    public function getAmountMax()
    {
        return $this->amount_max;
    }
    public function getAmountSpan()
    {
        return $this->amount_span;
    }

    /**
     * Returns the value of field describe
     *
     * @return string
     */
    public function getDescribe()
    {
        return $this->describe;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the value of field isdefault
     *
     * @return integer
     */
    public function getIsdefault()
    {
        return $this->isdefault;
    }

    /**
     * Returns the value of field created
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Returns the value of field modified
     *
     * @return string
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Returns the value of field operator
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }
    
    /**
     * 
     * @return number
     */
    public function getPaymentAlipay()
    {
    	return $this->payment_alipay;
    }
    public function getPaymentAlipay2Bank()
    {
    	return $this->payment_alipay2bank;
    }
    
    /**
     * 
     * @return number
     */
    public function getPaymentWeixin()
    {
    	return $this->payment_weixin;
    }
    public function getPaymentWc2Bank()
    {
    	return $this->payment_wc2bank;
    }
    
    /**
     * 
     * @return number
     */
    public function getPaymentBank()
    {
    	return $this->payment_bank;
    }
    
    /**
     *
     * @return number
     */
    public function getPaymentQqpay()
    {
    	return $this->payment_qqpay;
    }
    
    /**
     * 
     * @return number
     */
    public function getPaymentTfpay()
    {
    	return $this->payment_tfpay;
    }
    
    /**
     * 
     * @return number
     */
    public function getExpendAlipay()
    {
    	return $this->expend_alipay;
    }
    
    /**
     * 
     * @return number
     */
    public function getExpendBank()
    {
    	return $this->expend_bank;
    }
    
    /**
     * 
     * @return number
     */
    public function getIsExpendDefault()
    {
    	return $this->is_expend_default;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PaymentsManager[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PaymentsManager
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'payments_manager';
    }

}

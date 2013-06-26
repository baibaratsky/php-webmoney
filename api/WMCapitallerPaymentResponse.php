<?php

class WMCapitallerPaymentResponse extends WMApiResponse
{
    /**
     * @var string paymentid
     */
    protected $_capitallerTransactionId;

    /**
     * @var string wmtranid
     */
    protected $_wmTransactionId;

    /**
     * @var float comiss
     */
    protected $_fee;

    /**
     * @param array $response
     */
    public function __construct($response)
    {
        $this->_returnCode = $response['SendWMResult'];
        $this->_capitallerTransactionId = $response['paymentid'];
        $this->_wmTransactionId = $response['wmtranid'];
        $this->_fee = $response['comiss'];
    }

    /**
     * @return string
     */
    public function getCapitallerTransactionId()
    {
        return $this->_capitallerTransactionId;
    }

    /**
     * @return string
     */
    public function getWmTransactionId()
    {
        return $this->_wmTransactionId;
    }

    /**
     * @return float
     */
    public function getFee()
    {
        return $this->_fee;
    }
}

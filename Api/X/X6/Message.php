<?php

namespace baibaratsky\WebMoney\Api\X\X6;

class Message
{
    /** @var string message\receiverwmid */
    protected $recepientWmid;

    /** @var string message\msgsubj */
    protected $subject;

    /** @var string message\msgtext */
    protected $text;

    /** @var \DateTime message\datecrt */
    protected $createDateTime;

    public function __construct($recepientWmid, $subject, $text, $createDateTime)
    {
        $this->recepientWmid = $recepientWmid;
        $this->subject = $subject;
        $this->text = $text;
        $this->createDateTime = $createDateTime;
    }

    /**
     * @return string
     */
    public function getRecepientWmid()
    {
        return $this->recepientWmid;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDateTime()
    {
        return $this->createDateTime;
    }
}

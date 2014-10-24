<?php
class InterestRate
{
    var $effectiveDate;
    var $rate;
    
    function InterestRate($date, $rate)
    {
        $this->effectiveDate=$date;
        $this->rate=$rate;
    }
    
    function getEffectiveDate()
    {
        return $this->effectiveDate;
    }
    
    function getRate()
    {
        return $this->rate;
    }
    
    function setEffectiveDate($date)
    {
        $this->effectiveDate=$date;
    }
    
    function setRate($rate)
    {
        $this->rate=$rate;
    }
    
}
?>
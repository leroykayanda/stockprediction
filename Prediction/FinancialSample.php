<?php
class FinancialSample
{
    var $amount;
    var $date;
    var $rate;
    var $percent;
    
    function setAmount($amount)
    {
        $this->amount=$amount;
    }
    
    function setDate($date)
    {
        $this->date=$date;
    }
    
    function setRate($rate)
    {
        $this->rate=$rate;
    }
    
    function getRate()
    {
        return $this->rate;
    }
    
    function getDate()
    {
        return $this->date;        
    }
    
    function setPercent($perc)
    {
        $this->percent=$perc;
    }
    
    function getPercent()
    {
        return $this->percent;
    }
    
    function getAmount()
    {
        return $this->amount;
    }
    
    function toString()
    {
        return $result="Date=".$this->date." Amount=".$this->amount." Rate=".$this->rate." % Change= ".$this->percent;
    }
    
}
?>
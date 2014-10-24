<?php
class ActualData
{
	var $actual;
	var $inputSize;
	var $outputSize;
	
	
	function ActualData($size,$inputSize,$outputSize)
	{
		$this->inputSize=$inputSize;
		$this->outputSize=$outputSize;
		
		$angle=0;
		
		for($i=0;$i<$size;$i++)
		{
			$this->actual[$i]=ActualData::sinDEG($angle);
			$angle+=10;
		}
		
	}
	
	static function sinDEG($deg)
	{
		$rad=$deg * (M_PI/180);
		$result=sin($rad);  
		return ( (int) ($result * 100000.0) )/ 100000.0;
	}
    
    function getInputData($offset,&$target)
    {
        for($i=0;$i<$this->inputSize;$i++)
        {
            $target[$i]=$this->actual[$offset+$i];
        }
    }
    
    function getOutputData($offset,&$target)
    {
        for($i=0;$i<$this->outputSize;$i++)
        {
            $target[$i]=$this->actual[ $i+$offset+$this->inputSize ];
        }
    }
    
}
?>
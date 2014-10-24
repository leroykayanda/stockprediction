<?php
class ErrorCalculation
{
	var $globalError=0;
	var $setSize=0;

	function calculateRMS()
	{
		$err=sqrt($this->globalError/$this->setSize);
		return $err;
	}

	function reset() {   
		$this->globalError = 0;   
		$this->setSize = 0;
	}

	function updateError($actual,$ideal) {
		for( $r = 0; $r <count($actual); $r++)
		{
			$delta = $ideal[$r]- $actual[$r];
			$this->globalError += $delta * $delta;    
		}
		$this->setSize+=count($actual);
	}

}
?>
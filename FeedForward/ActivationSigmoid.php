<?php
class ActivationSigmoid
{
	function ActivationSigmoid()
	{
		
	}
	
	function activationFunction($x)
	{
		return 1/(1+exp(-1*$x));
	}
	
	function derivativeFunction ($x)
	{
		return $x*(1-$x);
	}
}
?>
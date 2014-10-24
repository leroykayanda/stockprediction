<?php

class BoundNumbers
{
	static $TOO_SMALL=-485165195.40979;
	static $TOO_BIG=485165195.40979;
	
	static function bound($v)
	{
		if($v<self::$TOO_SMALL)
		{
			return self::$TOO_SMALL;
		}else if ($v>self::$TOO_BIG)
		{
			return self::$TOO_BIG;
		}
		else
		{
			return $v;
		}
	}
}

?>
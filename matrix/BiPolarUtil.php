<?php
class BiPolarUtil
{
	static function bipolar2double($inp)
	{
		if(!is_array($inp))
		{
			if ($inp) {
				return 1;
			} else {
				return -1;
			}
		}
		else if(!is_array($inp[0]))
		{
			for($i=0;$i<count($inp);$i++)
			{
				$newmatrix[$i]=BiPolarUtil::bipolar2double($inp[$i]);
			}
			return $newmatrix;
		}
		else
		{
			for( $r = 0; $r <count($inp); $r++)
				for( $c = 0; $c <count($inp[0]); $c++)
				$newmatrix[$r][$c]=BiPolarUtil::bipolar2double($inp[$r][$c]);
			
			return $newmatrix;
		}
	}
	
	static function double2bipolar($inp)
	{
		if(!is_array($inp))
		{
			if($inp>0)
			{
				return true;
			}
			else
			{
				return -1;
			}
		}
		else if(!is_array($inp[0]))
		{
			for($i=0;$i<count($inp);$i++)
			{
				$newmatrix[$i]=BiPolarUtil::double2bipolar($inp[$i]);
			}
			return $newmatrix;
		}
		else
		{
			for( $r = 0; $r <count($inp); $r++)
				for( $c = 0; $c <count($inp[0]); $c++)
				$newmatrix[$r][$c]=BiPolarUtil::double2bipolar($inp[$r][$c]);
			
			return $newmatrix;
		}
	}
}
?>
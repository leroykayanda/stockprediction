<?php

class Matrix
{
	var $matrix=array();

	function Matrix()
	{
		if (func_num_args() == 0)
		{
			//do nothing
		}
		else if(func_num_args() == 2)
		{
			$args = func_get_args();
			$rows = $args[0];
			$cols = $args[1];

			for( $r = 0; $r <$rows; $r++)
				for( $c = 0; $c <$cols; $c++)
				$this->matrix[$r][$c]=0;
		}

		else
		{
			$args = func_get_args();
			$arr = $args[0];
			if(is_numeric($arr[0][0]))
			{

				for( $r = 0; $r <count($arr); $r++)
				{
					for( $c = 0; $c <count($arr[0]); $c++)
					{
						$this->matrix[$r][$c]=$arr[$r][$c];
					}
				}
			}
			else
			{
				$args = func_get_args();
				$arr = $args[0];

				for( $r = 0; $r <count($arr); $r++)
				{
					for( $c = 0; $c <count($arr[0]); $c++)
					{
						if($arr[$r][$c])
						{
							$this->matrix[$r][$c]=$arr[$r][$c];
						}
						else
						{
							$this->matrix[$r][$c]=-1;
						}
					}
				}//$this->disp($matrix);

			}
		}//2d int or boolean array case

	}

	function disp()
	{echo "<br/>";
	 for( $r = 0; $r <$this->getRows(); $r++)
	 {
		 for($c = 0; $c <$this->getCols(); $c++)
		 {
			 echo $this->matrix[$r][$c]."&nbsp &nbsp";
		 }
		 echo "<br/>";
	 }
	}

	static function createColumnMatrix($arr)
	{
		for( $r= 0; $r < count($arr); $r++)
		{
			$newmatrix[$r][0]=$arr[$r];
		}
		return new Matrix($newmatrix);
	}

	static function createRowMatrix($arr)
	{
		for( $c= 0; $c < count($arr); $c++)
		{
			$newmatrix[0][$c]=$arr[$c];
		}
		return new Matrix($newmatrix);
	}

	function add($r,$c,$value)
	{
		$this->validate($r,$c);
		$newvalue=$this->get($r,$c)+$value;
		$this->set($r,$c,$newvalue);
	}

	function validate($r,$c)
	{
		try {
			if($r>=$this->getRows() || $r<0)
			{
				throw new Exception("Row $r is out of range");
			}

			if($c>=$this->getCols() || $c<0)
			{
				throw new Exception("Column $c is out of range");
			}

		} catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}

	}

	function get($r,$c)
	{
		$this->validate($r,$c);
		return $this->matrix[$r][$c];
	}

	function set($r,$c,$value)
	{
		$this->validate($r,$c);
		$this->matrix[$r][$c]=$value;
	}

	function getRows() {
		return count($this->matrix);
	}
	function getCols() {
		return count($this->matrix[0]);
	}

	function clear()
	{
		for( $r = 0; $r <$this->getRows(); $r++)
			for( $c = 0; $c <$this->getCols(); $c++)
			$this->matrix[$r][$c]=0;
	}

	function clones()
	{
		return new Matrix($this->matrix);
	}

	function fromPackedArray($arr,$index)
	{
		for( $r = 0; $r <$this->getRows(); $r++)
			for( $c = 0; $c <$this->getCols(); $c++)
			$this->matrix[$r][$c]=$arr[$index++];
			
			return $index;
	}

	function toPackedArray()
	{
		$index=0;
		for( $r = 0; $r <$this->getRows(); $r++)
			for( $c = 0; $c <$this->getCols(); $c++)
			$result[$index++]=$this->matrix[$r][$c];

			return $result;
	}

	function getRow($r)
	{
		try
		{
			if($r>=$this->getRows() || $r<0)
			{
				throw new Exception("Row $r is out of range"); 
			}

			for($c=0;$c<$this->getCols();$c++)
			{
				$newmatrix[0][$c]=$this->matrix[$r][$c];
			}
			return new Matrix($newmatrix);
		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}

	}

	function getCol($c)
	{
		try
		{
			if($c>=$this->getCols() || $c<0)
			{
				throw new Exception("Column $c is out of range"); 
			}

			for($r=0;$r<$this->getRows();$r++)
			{
				$newmatrix[$r][0]=$this->matrix[$r][$c];
			}
			return new Matrix($newmatrix);
		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}
	}

	function isVector() {
		if ($this->getRows() == 1) {
			return true;
		} else {
			return $this->getCols() == 1;
		}
	}

	function isZero()
	{
		for( $r = 0; $r <$this->getRows(); $r++)
		{
			for( $c = 0; $c <$this->getCols(); $c++)
			{
				if($this->matrix[$r][$c]!=0)
				{
					return false;
				}

			}

		}
		return true;
	}
	
	function size()
	{
		return $this->getRows()*$this->getCols();
	}
	
	function sum()
	{
		$sum=0;
		
		for( $r = 0; $r <$this->getRows(); $r++)
			for( $c = 0; $c <$this->getCols(); $c++)
			$sum+=$this->matrix[$r][$c];
			
		return $sum;
	}
	
	function random($min,$max)
	{
		for( $r = 0; $r <$this->getRows(); $r++)
			for( $c = 0; $c <$this->getCols(); $c++)
			$this->matrix[$r][$c]=mt_rand(-1.0*10,1.0*10)/10;
	}


}

?>
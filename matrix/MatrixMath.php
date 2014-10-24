<?php

class MatrixMath
{
	private function MatrixMath()
	{		
	}

	static function add($a,$b)
	{
		try
		{
			if($a->getRows()!=$b->getRows() || $a->getCols()!=$b->getCols())
			{
				throw new Exception("The matrices must have the same number of rows and columns");
			}

			for( $r = 0; $r <$a->getRows(); $r++)
			{
				for( $c = 0; $c <$b->getCols(); $c++)
				{
					$newmatrix[$r][$c]=$a->get($r,$c)+$b->get($r,$c);
				}
			}
			return new Matrix($newmatrix);

		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}
	}

	static function subtract($a,$b)
	{
		try
		{
			if($a->getRows()!=$b->getRows() || $a->getCols()!=$b->getCols())
			{
				throw new Exception("The matrices must have the same number of rows and columns");
			}

			for( $r = 0; $r <$a->getRows(); $r++)
			{
				for( $c = 0; $c <$b->getCols(); $c++)
				{
					$newmatrix[$r][$c]=$a->get($r,$c)-$b->get($r,$c);
				}
			}
			return new Matrix($newmatrix);

		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}
	}

	static function divide($a,$b)
	{
		for( $r = 0; $r <$a->getRows(); $r++)
		{
			for( $c = 0; $c <$a->getCols(); $c++)
			{
				$newmatrix[$r][$c]=$a->get($r,$c)/$b;
			}
		}
		return new Matrix($newmatrix);
	}

	static function dotProduct($a,$b)
	{
		try
		{
			$one=$a->toPackedArray();
			$two=$b->toPackedArray();
			if(count($one)!=count($two))
			{
				throw new Exception("With DOTPRODUCT matrices must be of the same length");
			}
			$result=0;

			for($i=0;$i<count($one);$i++)
			{
				$result+=$one[$i]*$two[$i];
			}
			return $result;
		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}
	}

	static function identity($size)
	{
		$newmatrix=new Matrix($size,$size);
		for($i=0;$i<$size;$i++)
		{
			$newmatrix->set($i,$i,1);
		}
		return $newmatrix;
	}

	static function multiply($a,$b)
	{
		if(is_int($b) || is_double($b))
		{
			for( $r = 0; $r <$a->getRows(); $r++)
			{
				for( $c = 0; $c <$a->getCols(); $c++)
				{
					$newmatrix[$r][$c]=$a->get($r,$c)*$b;
				}
			}
			return new Matrix($newmatrix);
		}
		else
		{
			try
			{
				if($a->getCols()!=$b->getRows())
				{
					echo "Number of cols in first matrix must be equal to number of rows in second matrix for matrix multiplication";
				}
			}catch (Exception $e) {
				echo $e->getMessage(). "<br/>"; die();
			}
			
			for($resultRow=0;$resultRow<$a->getRows();$resultRow++)
			{
				for($resultCol=0;$resultCol<$b->getCols();$resultCol++)
				{
					$value=0;
					for($i=0;$i<$a->getCols();$i++)
					{
						$value+=$a->get($resultRow,$i)*$b->get($i,$resultCol);
					}
					$result[$resultRow][$resultCol]=$value;
				}
			}
			return new Matrix($result);
		}
	}

	static function transpose($inp)
	{
		for( $r = 0; $r <$inp->getRows(); $r++)
			for( $c = 0; $c <$inp->getCols(); $c++)
			$newmatrix[$c][$r]=$inp->get($r,$c);

			return new Matrix($newmatrix);
	}

	static function vectorLength($inp)
	{
		$inp_array=$inp->toPackedArray();
		$vl=0;
		for($i=0;$i<count($inp_array);$i++)
		{
			$vl+=pow($inp_array[$i],2);
		}
		return sqrt($vl);
	}


}




?>
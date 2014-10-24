<?php
class ActualStockData
{
    var $rates=array();
    var $samples=array();
    var $inputSize;
    var $outputSize;

    function ActualStockData($inputSize,$outputSize)
    {
        $this->inputSize=$inputSize;
        $this->outputSize=$outputSize;
    }

    function calculatePercents()
    {
        $prev=-1;

        foreach($this->samples as $sample)
        {
            if($prev!=-1)
            {
                $movement = $sample->getAmount() - $prev;
                $percent = $movement / $prev;     
                $sample->setPercent( round($percent,4) );
            }
            else
            {
                $sample->setPercent(0);
            }
            $prev=$sample->getAmount();
        }

    }

    function getInputData($offset,&$input)
    {
        for($i=0;$i<$this->inputSize;$i++)
        {
            $arr1[$i]=$this->samples[$i+$offset]->getPercent();
            $arr2[$i]= $this->samples[$i+$offset]->getRate(); 
            $input[]=$arr1[$i];
            $input[]=$arr2[$i];
        }
        
    }

    function getOutputData($offset,&$output)
    {
        for($i=0;$i<$this->outputSize;$i++)
        {
            $output[$i]=$this->samples[$i+$this->inputSize+$offset]->getPercent();
        }
    }

    function getPrimeRate($date)
    {
        $currentRate = 0;

        foreach($this->rates as $rate)
        {
            if( strtotime( $rate->getEffectiveDate() ) > strtotime( $date ) )
            {
                return $currentRate;
            }
            else
            {
                $currentRate=$rate->getRate();
            }
        }
        
        return $currentRate;

    }
    
    function getSamples()
    {
        return $this->samples;
    }
    
    function load($QuotesFilename,$primeFilename)
    {
        $this->loadQuotes($QuotesFilename);
        $this->loadPrime($primeFilename);
        $this->stitchInterestRates();
        $this->calculatePercents();
    }
    
    function loadQuotes($QuotesFilename)
    {
        $csv = new ReadCSV($QuotesFilename);
        //print_r( $csv->columns );
        //echo $csv->columns["adj close"];
        while( $csv->next() )
        {
            $date=$csv->getDate(); 
            $amount=$csv->get("Adj Close"); //echo "<br/>";
            $sample = new FinancialSample();
            $sample->setAmount($amount);
            $sample->setDate($date);
            $this->samples[]=$sample;
        }
        $csv->close();
    }
    
    function loadPrime($primeFilename)
    {
        $csv = new ReadCSV($primeFilename);
        
        while($csv->next())
        {
            $date=$csv->get("date");
            $rate=$csv->get("rate");
            
            $ir=new InterestRate($date, $rate);
            $this->rates[]=$ir;
        }
        $csv->close();
    }
    
    function stitchInterestRates()
    {
        foreach($this->samples as $sample)
        {
            $rate=$this->getPrimeRate( $sample->getDate() );
            $sample->setRate($rate);
        }
        //echo $this->getPrimeRate("4/2/1953");
    }
    
    function size()
    {
        return count($this->samples);
    }

}
?>
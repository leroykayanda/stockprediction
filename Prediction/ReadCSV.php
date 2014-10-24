<?php
class ReadCSV
{
    var $columns=array();
    var $data=array();
    var $file;

    function ReadCSV($filename)
    {
        $this->file=fopen($filename,"r");

        $line=fgets($this->file);
        $arr=explode(",",$line);

        for($i=0;$i<count($arr);$i++)
        {
            $this->columns[ strtolower( trim( $arr[$i] ) ) ] = $i;
        }

    }

    function displayDate($date)
    {
        //$date=date_create("2/30/2014");
        return date_format($date,"Y-m-d");
    }

    function parseDate($date_string)
    {
        return date("Y-m-d",strtotime($date_string));
    }

    function next()
    {
        $line=fgets($this->file);
        if($line==false)
        {
            return false;
        }

        $arr=explode(",",$line);
        for($i=0;$i<count($arr);$i++)
        {
            $this->data[$i] = $arr[$i];
        }

        return true;
    }

    function close()
    {
        fclose($this->file);
    }

    function get($arg)
    {
        if( is_int($arg) )
        {
            return $this->data[$arg];
        }else
        {
            return $this->data[ $this->columns[strtolower($arg)] ];
        }
    }
    
    function getDate()
    {
        return $this->parseDate( $this->get("date") );
    }

}
?>
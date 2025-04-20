<?php
	//...................Database functions start.................
	
	function dbconnect($dbname,$host="localhost",$user="root",$pass="")
	{
		mysql_connect($host,$user,$pass) or die ("Could not connect with database");
		mysql_select_db($dbname) or die ("Database not available");
	}
	
	//................insert new record to database [start].................................
	function ins_rec($tab,$array,$disp=false)	
	{	
		$array = add_slashes($array);
				
		 $qry = "insert into $tab set "; 
		if (count($array) > 0)
		{
			foreach ($array as $k=>$v)
			{
				$qry .= "`$k`='".$v."',";
			}
		}
		
		$qry=trim($qry,",");
		
		if ($disp)
			echo $qry;
		
		$err = mysql_query($qry);
		
		if (!$err)
		{
			echo mysql_error();
			return false;
		}
		else
		{
			return mysql_insert_id();
		}
	}
	function ins_rec_2($tab,$array,$disp=false)	
	{	
		//$array = add_slashes($array);
				
		 $qry = "insert into $tab set "; 
		if (count($array) > 0)
		{
			foreach ($array as $k=>$v)
			{
				$qry .= "`$k`='".$v."',";
			}
		}
		
		$qry=trim($qry,",");
		
		if ($disp)
			echo $qry;
		echo $qry; exit;
		$err = mysql_query($qry);
		
		if (!$err)
		{
			echo mysql_error();
			return false;
		}
		else
		{
			return mysql_insert_id();
		}
	}
	//................insert new record to database [end].................................
	
	//................update record from database [start].................................
	function upd_rec($tab,$array,$where="1=1",$disp=false)	
	{	
		$array = add_slashes($array);
		$qry = "update $tab set ";
		if (count($array) > 0)
		{
			foreach ($array as $k=>$v)
			{
				$qry .= "$k='".$v."',";
			}
		}
			
		$qry=trim($qry,",")." where ".$where;
		if ($disp)
			echo $qry;
		
		$err = mysql_query($qry);		
		
		if (!$err)
		{
			echo mysql_error();
			return false;
		}
		else
			return true;
	}
	//................update record from database [end].................................
	
	//................delete record from database [start].................................
	function del_rec($tab,$where="1=1",$disp=false)
	{
		$qry = "delete from $tab where $where";
		if ($disp)
			echo $qry;
			
		$err = mysql_query($qry);
		if (!$err)
		{
			echo mysql_error();
			return false;
		}
		else
			return true;
	}
	//................delete record from database [end].................................
	
	//...............................select rows from a table [start]................
	function sel_rec ($tab,$fields="*",$where="1=1",$orderby="1",$order="desc",$start="",$end="",$disp=false) 
	{
		/*if($fields=="*")
			$fields="*";
		else
			$fields="$fields";*/
			
		if($start <> "" && $end <> "")
		{
			$qry = "select $fields from $tab where $where order by $orderby $order limit $start ,$end";
		}
		else
		{
			$qry = "select $fields from $tab where $where order by $orderby $order";
		}	
		
		if ($disp)
			echo $qry;
		
		$res = mysql_query($qry);
		
		if (!$res)	
			echo mysql_error();
		
		if (mysql_num_rows($res) > 0)
			return $res;
		else
			return false;
		
	}
	function sel_total_rec($tab,$fields="*",$where="1=1",$disp=false) 
	{
		/*if($fields=="*")
			$fields="*";
		else
			$fields="$fields";*/
		
		$qry = "select $fields from $tab where $where";
		
		if ($disp)
			echo $qry;
		
		$res = mysql_query($qry);
		echo mysql_error();
		
		if (!$res)	
			echo mysql_error();
		
		if (mysql_num_rows($res) > 0)
			return mysql_num_rows($res);
		else
			return 0;
		
	}
	//...............................select rows from a table [end]................
	
	//...............................select  single row from a table [start]................
	function single_row($tab,$fields="*",$where="1=1",$orderby="1",$order="desc",$disp=false)
	{
		$res = sel_rec($tab,$fields,$where,$orderby,$order,$disp);
		
		if ($res)
			return strip_slashes(mysql_fetch_array($res));
		else
			return false;
	}
	//...............................select  single row from a table [end]................
	
	//...............................select single value from a table [start]................
	function single_value($tab,$fields,$where="1=1",$orderby="1",$order="desc",$disp=false)
	{
		$res = sel_rec($tab,$fields,$where,$orderby,$order,$disp);
		if ($res)
		{
			$val = mysql_fetch_array($res);
			return strip_slashes($val[$fields]);
		}
		else
			return false;
	}
	function single_value_query($query,$fields)
	{
		$res = mysql_query($query);
		if ($res)
		{
			$val = mysql_fetch_array($res);
			return strip_slashes($val[$fields]);
		}
		else
			return false;
	}
	//...............................select single value from a table [end]................
	
	
	//...............................check for duplication row in a table while adding new row [start]................
	function is_dup_add($table,$field,$value,$disp=false)
	{
		$q = "select ".$field." from ".$table." where ".$field." = '".$value."'"; 
		if ($disp)
			die($q);
		$r = mysql_query($q);
		if(mysql_num_rows($r) > 0)
			return true;
		else
			return false;
	}
	//...............................check for duplication row in a table while adding new row [end]................
	
	//...............................check for duplication row in a table while updating any row [start]................
	function is_dup_edit($table,$field,$value,$tableid,$id,$disp=false)
	{
		$q = "select ".$field." from ".$table." where ".$field." = '".$value."' and ".$tableid."!= '".$id."'"; 
		if ($disp)
			die($q);
		$r = mysql_query($q);
		if(!$r)
			echo mysql_error();
		if(mysql_num_rows($r) > 0)
			return true;
		else
			return false;
	}
	//...............................check for duplication row in a table while updating any row [end]................
	//...................Database functions end.................
	function strip_slashes($var)
	{
		if (is_array($var))
		{
			if (count($var) > 0)
			{
				foreach ($var as $k=>$v)	
				{
					$var[$k] = stripslashes($v);
				}
			}
			return $var;
		}
		else
			return stripslashes($var);
	}
	function formatMysqlDate($mysqlDate) {
		list($year, $monthNum, $zeroPaddedDay) = preg_split("/[- ]/", $mysqlDate);
		$shortMonthName = date('M', mktime(0,0,0,$monthNum,1));
		$longMonthName = date('F', mktime(0,0,0,$monthNum,1));
		$number = (int) $zeroPaddedDay;
		
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if (($number %100) >= 11 && ($number%100) <= 13)
		   $abbreviation = $number. 'th';
		else
		   $abbreviation = $number. $ends[$number % 10];
		
		echo "$abbreviation $longMonthName $year";
	}
	function formatMysqlYear($mysqlDate) {
		list($year, $monthNum, $zeroPaddedDay) = preg_split("/[- ]/", $mysqlDate);
				
		echo "$year";
	}

?>
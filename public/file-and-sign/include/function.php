<?php 
	//.............Required Functions..............
	
	//..........Login Check.............
	function is_admin_login()
	{
		if (!isset ($_SESSION['ADMIN_ID']))
		{
			print '<script language="javascript">window.location.href="index.php"</script>';
			exit;
		}
	}	
	
	function add_slashes($var)
	{
		if (is_array($var))
		{
			if (count($var) > 0)
			{
				foreach ($var as $k=>$v)	
				{
					$var[$k] = addslashes($v);
				}
			}
			return $var;
		}
		else
			return addslashes($var);
	}
	
	function is_user_login()
	{
		if ($_SESSION[USER_ID]=="" && $_SESSION[USER_NAME]=="")
		{
			print '<script language="javascript">window.location.href="index.php"</script>';
		}
	}
//................ get random password start...........
	function generate_randomnumber($len)
	{
		$chars = "0123456789";
		for($i=0; $i<$len; $i++) 
			$r_str .= substr($chars,rand(0,strlen($chars)),1);
		return $r_str;
	}
	//................ get random password end...........
	function generate_randompassword($len)
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		for($i=0; $i<$len; $i++) 
			$r_str .= substr($chars,rand(0,strlen($chars)),1);
		return $r_str;
	}
	//............Get Single Value From table...........
	function get_single_value ($tab,$field,$where,$disp=false)
	{
		if($where <> "")
		{
			$wheret=" where $where";
		}
		
		$qry = "select $field from $tab $wheret";
		if ($disp)
			echo ($qry); 
		$rs = mysql_query($qry);
		if($rs) { $totres=mysql_num_rows($rs); }
		if ($totres > 0)
		{
			$val = mysql_fetch_object($rs);
			return $val -> $field;
		}
		else
		{
			return false;
		}
	}
	
	//............Get Single Value From table...........
	function get_total_record ($tab,$where,$disp=false)
	{
		if($where <> "")
		{
			$wheret=" where $where";
		}
		
		$qry = "select * from $tab $wheret";
		if ($disp)
			echo ($qry); 
		$rs = mysql_query($qry);
		if($rs) { $totres=mysql_num_rows($rs); }
		if ($totres > 0)
		{
			return $totres;
		}
		else
		{
			return 0;
		}
	}
	
	function sub_string($str,$max)
	{	
		if (strlen($str) > $max)
			return substr($str,0,$max)."...";
		else
			return $str;
	}
	function sub_string2($str,$max)
	{	
		if (strlen($str) > $max)
			return substr($str,0,$max).". ";
		else
			return $str;
	}
	
	//..............resize image function start [while uploading]........

	function smart_resize_image( $file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands=false )
	  {
		if ( $height <= 0 && $width <= 0 ) {
		  return false;
	  }
	 
		$info = getimagesize($file);
		$image = '';
	 
		$final_width = 0;
		$final_height = 0;
		list($width_old, $height_old) = $info;
	 
		if ($proportional) {
		  if ($width == 0) $factor = $height/$height_old;
		  elseif ($height == 0) $factor = $width/$width_old;
		  else $factor = min ( $width / $width_old, $height / $height_old);   
	 
		  $final_width = round ($width_old * $factor);
		  $final_height = round ($height_old * $factor);
	 
		}
		else {
		  $final_width = ( $width <= 0 ) ? $width_old : $width;
		  $final_height = ( $height <= 0 ) ? $height_old : $height;
		}
	 
		switch ( $info[2] ) {
		  case IMAGETYPE_GIF:
			$image = imagecreatefromgif($file);
		  break;
		  case IMAGETYPE_JPEG:
			$image = imagecreatefromjpeg($file);
		  break;
		  case IMAGETYPE_PNG:
			$image = imagecreatefrompng($file);
		  break;
		  default:
			return false;
		}
	 
		$image_resized = imagecreatetruecolor( $final_width, $final_height );
	 
		if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
		  $trnprt_indx = imagecolortransparent($image);
	 
		  // If we have a specific transparent color
		  if ($trnprt_indx >= 0) {
	 
			// Get the original image's transparent color's RGB values
			$trnprt_color    = imagecolorsforindex($image, $trnprt_indx);
	 
			// Allocate the same color in the new image resource
			$trnprt_indx    = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
	 
			// Completely fill the background of the new image with allocated color.
			imagefill($image_resized, 0, 0, $trnprt_indx);
	 
			// Set the background color for new image to transparent
			imagecolortransparent($image_resized, $trnprt_indx);
	 
	 
		  } 
		  // Always make a transparent background color for PNGs that don't have one allocated already
		  elseif ($info[2] == IMAGETYPE_PNG) {
	 
			// Turn off transparency blending (temporarily)
			imagealphablending($image_resized, false);
	 
			// Create a new transparent color for image
			$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
	 
			// Completely fill the background of the new image with allocated color.
			imagefill($image_resized, 0, 0, $color);
	 
			// Restore transparency blending
			imagesavealpha($image_resized, true);
		  }
		}
	 
		imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
	 
		if ( $delete_original ) {
		  if ( $use_linux_commands )
			exec('rm '.$file);
		  else
			@unlink($file);
		}
	 
		switch ( strtolower($output) ) {
		  case 'browser':
			$mime = image_type_to_mime_type($info[2]);
			header("Content-type: $mime");
			$output = NULL;
		  break;
		  case 'file':
			$output = $file;
		  break;
		  case 'return':
			return $image_resized;
		  break;
		  default:
		  break;
		}
	 
		switch ( $info[2] ) {
		  case IMAGETYPE_GIF:
			imagegif($image_resized, $output);
		  break;
		  case IMAGETYPE_JPEG:
			imagejpeg($image_resized, $output);
		  break;
		  case IMAGETYPE_PNG:
			imagepng($image_resized, $output);
		  break;
		  default:
			return false;
		}
	 
		return true;
	  }

//..............resize image function end	
	
	function get_pagetitle($str)
	{
		
		return str_replace("_"," ",strtoupper(substr($str,0,1)).substr($str,1));
	}
	
	function get_pagename()
	{
		$arr=explode("/",$_SERVER['PHP_SELF']);
		return $arr[count($arr)-1];
	}
	
//................ get random password start...........
function generate_rnd_txt($len)
{
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	for($i=0; $i<$len; $i++) $r_str .= substr($chars,rand(0,strlen($chars)),1);
	return $r_str;
}
//................ get random password end...........

function upload_image($files, $dir, $oldfile ,$prefix)
{
	/*echo "<pre>";
	print_r($files);
	echo "</pre>";exit;*/
	
	if (!is_dir ($dir))
	{
		mkdir($dir,0777);
		chmod($dir,0777);	
	}
	
	
	if ($oldfile != "" && is_file($dir.$oldfile))
	{
		unlink($dir.$oldfile);
	}
	
	$filename = $prefix."".rand(0,999999999999)."-".$files[name];
	
	if (is_file($dir.$filename))
		$filename = $prefix."".rand(0,999999999999)."-".rand(0,999999999999)."-".$files[name];
	
		
	if (@move_uploaded_file($files[tmp_name],$dir.$filename))
	{
		return $filename;
	}
	else
		return false;
}
function makedir($dirpath,$permission="0777")
{
	if(!is_dir($dirpath))
	{
		mkdir($dirpath);
		chmod($dirpath,$permission);		
	}	
}
function MakeCombo($query,$value="",$fill_value,$comboname="",$ComboClass="",$selectedval="",$id="",$param="")
{
	if($value=="")
		$value=$fill_value;
	
	$run=mysql_query($query);
	$totlist=mysql_affected_rows();
	$Combo="<select name='$comboname' id='$id' class='$ComboClass' $param>";
	$Combo.="<option value=''>Select</option>";
	for($i=0;$i<$totlist;$i++)
	{
		$get=mysql_fetch_object($run);
		if($selectedval == $get->$value)
		{
			$sel="selected=selected";
		}
		else
		{
			$sel="";
		}
		$Combo.="<option value='".$get->$value."' $sel>".$get->$fill_value."</option>";
	}
	$Combo.="</select>";
	echo $Combo;
}

function getMonthCombo($month)
{
	$i=1;
	for($i=1;$i<=12;$i++)
	{
		if($month==$i)
		{
			$sel="selected=selected";
		}
		else
		{
			$sel="";
		}
		
		$timestamp = mktime(0, 0, 0, $i, 1, 2012);
    	$month.= "<option value='".$i."' $sel>".date("M", $timestamp)."</option>";
	}
	echo $month;
}

function getMonth($month)
{
    $timestamp = mktime(0, 0, 0, $month, 1, 2012);
    return date("M", $timestamp);
}
function getYear($id="",$val1="5",$type="styear")
{
	$date = getdate();

	$cur_yr = $date[year];

	if($type == "styear")
		$val1 = $cur_yr - $val1 + 1;
	
	for($c=1900; $c<=$val1; $c++,$cur_yr--)
	{
		if($c==$id)
			$motyOption.="<option value='$c' selected>$c</option>";
		else
			$motyOption.="<option value='$c'>$c</option>";
	}
	return $motyOption;
}
function getYearCombo($year)
{
	for($i=1900;$i<=2100;$i++)
	{
		if($year==$i)
		{
			$sel="selected=selected";
		}
		else
		{
			$sel="";
		}
		
    	$month.= "<option value='".$i."' $sel>".$i."</option>";
	}
	echo $month;
}
	
function limit_text($text, $limit) 
{	
	$al=count(str_word_count($text, 2));
	//echo "[$limit]";
	
	if($al > $limit)
	{
		  if (strlen($text) > $limit) 
		  {
			  $words = str_word_count($text, 2);
			  $pos = array_keys($words);
			  $textp = substr($text, 0, $pos[$limit]) . '.....';
		  }
	}	  
	else
	{
		$textp=$text;
	}
	  
      return $textp;
}

function getCountry($Country)
{
		$cntQuery="select * from country order by country_name";		
		$cntResult=mysql_query($cntQuery);
		//echo mysql_error();		
		if($cntResult)
		{
			while($cntRow=mysql_fetch_object($cntResult))
			{
				//$Country=stripslashes($cntRow->cid);
				if($Country == $cntRow->cid)
					$cntOption .="<option value='$cntRow->cid' selected>".stripslashes($cntRow->country_name)."</option>";
				else
					$cntOption .="<option value='$cntRow->cid'>".stripslashes($cntRow->country_name)."</option>";					
			}
			return $cntOption;
		}
		else
			echo mysql_error();

}
function getState($Country,$state)
{
	$cntQuery="select * from state where cid='$Country' order by state_name";
		
		$cntResult=mysql_query($cntQuery);
		//echo mysql_error();
		
		if($cntResult)
		{
			while($cntRow=mysql_fetch_object($cntResult))
			{
				//$Country=stripslashes($cntRow->cid);
				if($state == $cntRow->sid)
					$cntOption .="<option value='$cntRow->sid' selected>".stripslashes($cntRow->state_name)."</option>";
				else
					$cntOption .="<option value='$cntRow->sid'>".stripslashes($cntRow->state_name)."</option>";					
			}
			return $cntOption;
		}
		else
			echo mysql_error();

}

function randomString($length=0, $pattern='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', $binary=false) {
    $out='';
    if ($length>0 && $pattern!='') {
      if (!$binary) {
        // Pattern is a text string
        $pattern_length_minus_one=strlen($pattern)-1;
        for ($i=0; $i<$length; $i++) {
          $out.=substr($pattern, mt_rand(0, $pattern_length_minus_one), 1);
        }
      } else {
        // Pattern is a binary string
        $pattern_length_minus_one=_pcpin_strlen($pattern)-1;
        for ($i=0; $i<$length; $i++) {
          $out.=_pcpin_substr($pattern, mt_rand(0, $pattern_length_minus_one), 1);
        }
      }
    }
    return $out;
} 
function get_user_browser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if(preg_match('/MSIE/i',$u_agent))
    {
        $ub = "ie";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $ub = "firefox";
    }
	elseif(preg_match('/Mozilla/i',$u_agent))
    {
        $ub = "mozilla";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $ub = "safari";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $ub = "chrome";
    }
    elseif(preg_match('/Flock/i',$u_agent))
    {
        $ub = "flock";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $ub = "opera";
    }   
    return $ub;
}



function uniqueRand($n,$max)
 {
	  $return= rand($n,$max);
	  return $return;
 }
  
function adddas($str)
{
	$dispstr=ereg_replace(" ","-",$str);
	return $dispstr;
}

function remdas($str)
{
	$dispstr=ereg_replace("-"," ",$str);
	return $dispstr;
}


function getNewsCategory($cid)
{
	//echo $whr;
	
	$cntQuery="select * from news_category order by id";		
	$cntResult=mysql_query($cntQuery);
		//echo mysql_error();
		
		if($cntResult)
		{
			while($cntRow=mysql_fetch_object($cntResult))
			{
				$name=stripslashes($cntRow->name);
				$category=$cntRow->category;
				
				if($cid == $cntRow->id)
						$cntOption .="<option value='$cntRow->id' selected>$name</option>";
					else
						$cntOption .="<option value='$cntRow->id'>$name</option>";	
				
							
			}
			return $cntOption;
		}
		else
			echo mysql_error();

}

function getModifiedUrlNamechange($catnm)
{
	$catnm1=ereg_replace("[^A-Za-z0-9]","-",$catnm);
	$catnm1=ereg_replace("--","-",$catnm1);
	return $catnm1;
}

function RemSpc($catnm)
{
	$catnm1=ereg_replace(" ","-",$catnm);
	return $catnm1;
}


function del_file($path)
{
	if (is_file($path))
	{
		unlink($path);
		return true;
	}
	else
		return false;
}



function smcf_filter($value) {
	$pattern = array("/\n/","/\r/","/content-type:/i","/to:/i", "/from:/i", "/cc:/i");
	$value = preg_replace($pattern, "", $value);
	return $value;
}


// Validate email address format in case client-side validation "fails"
function smcf_validate_email($email) {
	$at = strrpos($email, "@");

	// Make sure the at (@) sybmol exists and  
	// it is not the first or last character
	if ($at && ($at < 1 || ($at + 1) == strlen($email)))
		return false;

	// Make sure there aren't multiple periods together
	if (preg_match("/(\.{2,})/", $email))
		return false;

	// Break up the local and domain portions
	$local = substr($email, 0, $at);
	$domain = substr($email, $at + 1);


	// Check lengths
	$locLen = strlen($local);
	$domLen = strlen($domain);
	if ($locLen < 1 || $locLen > 64 || $domLen < 4 || $domLen > 255)	
		return false;

	// Make sure local and domain don't start with or end with a period
	if (preg_match("/(^\.|\.$)/", $local) || preg_match("/(^\.|\.$)/", $domain))
		return false;

	// Check for quoted-string addresses
	// Since almost anything is allowed in a quoted-string address,
	// we're just going to let them go through
	if (!preg_match('/^"(.+)"$/', $local)) {
		// It's a dot-string address...check for valid characters
		if (!preg_match('/^[-a-zA-Z0-9!#$%*\/?|^{}`~&\'+=_\.]*$/', $local))
			return false;
	}

	// Make sure domain contains only valid characters and at least one period
	if (!preg_match("/^[-a-zA-Z0-9\.]*$/", $domain) || !strpos($domain, "."))
		return false;	

	return true;
}
function changeStatus($tablename,$ids,$allid,$fieldname,$wherefield)
{
	$Cntids = count($ids);
	for($i=0;$i<$Cntids;$i++)
	{
		$allidarr = $allid;
		if(is_array($allidarr))
		{
			if(in_array($ids[$i],$allidarr))
			{
				$qry = "update $tablename set $fieldname='1' where $wherefield = ".$ids[$i];
				$err = mysql_query($qry);
			}	
			else
			{
				$qry = "update $tablename set $fieldname='0' where $wherefield = ".$ids[$i];
				$err = mysql_query($qry);
			}
		}
		else
		{
				$qry = "update $tablename set $fieldname='0' where $wherefield = ".$ids[$i];
				$err = mysql_query($qry);
		}
	}
}
function getgallery($p_id)
{
	$selsql="select * from product_gallery where p_id ='$p_id' order by gid asc";
	$selrs=mysql_query($selsql);
	$arr=array();
	while($cntRow=mysql_fetch_object($selrs))
	{		
		$arr[thumb_img][]=stripslashes($cntRow->thumb_img);
		$arr[big_img][]=stripslashes($cntRow->big_img);
		$arr[gid][]=stripslashes($cntRow->gid);
	}
	return $arr;
}
function getslider()
{
	$selsql="select * from home_slider";
	$selrs=mysql_query($selsql);
	$arr=array();
	while($cntRow=mysql_fetch_object($selrs))
	{		
		$arr[big_img][]=stripslashes($cntRow->big_img);
		$arr[description][]=stripslashes($cntRow->description);		
		$arr[gid][]=stripslashes($cntRow->gid);
	}
	return $arr;
}
function getpageno($catid,$pid)
{
	
	$bookselsql="select * from projects_gallery where pid='$pid' order by gid asc";
	$bookselrs=mysql_query($bookselsql);
	$total =mysql_affected_rows();
	echo mysql_error();
	if($total > 0)
	{
		$pg=0;
		while($rows=mysql_fetch_array($bookselrs))
		{
			$pg++;
			$baid=$rows[gid];
			if($baid==$catid)
			{
				break;
			}				
		}		
		return $pg;	
	}
}
function trChar($strContent)
{
$chars = array(
        "ÄŸ" => "g",
        "Ä?" => "G",
        "Ã¼" => "ü",
        "Ãœ" => "Ü",
        "Ä°" => "I",
        "Ã§" => "ç",
        "Ã‡" => "Ç",
        "Ã¶" => "ö",
        "Ã–" => "Ö",
        "Ä±" => "i",
        "ÅŸ" => "s",
        "Å?" => "S");
        //chr(10) => "<br>",   chr(13) => "<br>"

    return str_replace(array_keys($chars),$chars,$strContent);
}

function noTr($strContent)
{
$chars = array(
        "g" => "g",
        "G" => "G",
        "ü" => "u",
        "Ü" => "U",
        "I" => "I",
        "ç" => "c",
        "Ç" => "C",
        "ö" => "o",
        "Ö" => "O",
        "i" => "i",
        "s" => "s",
        "S" => "S",
		"&" => "-");
        //chr(10) => "<br>",   chr(13) => "<br>"

    return str_replace(array_keys($chars),$chars,$strContent);
}

function seo_url($url)
{
    $url = noTr($url);
	$url = trChar(trim($url));
    $url = strtolower($url);    

    $find = array('<b>', '</b>');
    $url = str_replace ($find, '', $url);

    $url = preg_replace('/<(\/{0,1})img(.*?)(\/{0,1})\>/', 'image', $url);

    $find = array(' ', '&quot;', '&amp;', '&', '\r\n', '\n', '/', '\\', '+', '<', '>');
    $url = str_replace ($find, '-', $url);

    $find = array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ë', 'Ê');
    $url = str_replace ($find, 'e', $url);

    $find = array('í', 'i', 'ì', 'î', 'ï', 'I', 'I', 'Í', 'Ì', 'Î', 'Ï');
    $url = str_replace ($find, 'i', $url);

    $find = array('ó', 'ö', 'Ö', 'ò', 'ô', 'Ó', 'Ò', 'Ô');
    $url = str_replace ($find, 'o', $url);

    $find = array('á', 'ä', 'â', 'à', 'â', 'Ä', 'Â', 'Á', 'À', 'Â');
    $url = str_replace ($find, 'a', $url);

    $find = array('ú', 'ü', 'Ü', 'ù', 'û', 'Ú', 'Ù', 'Û');
    $url = str_replace ($find, 'u', $url);

    $find = array('ç', 'Ç');
    $url = str_replace ($find, 'c', $url);

    $find = array('s', 'S');
    $url = str_replace ($find, 's', $url);

    $find = array('g', 'G');
    $url = str_replace ($find, 'g', $url);

    $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

    $repl = array('', '-', '');

    $url = preg_replace ($find, $repl, $url);
    $url = str_replace ('--', '-', $url);

    return $url;
}
function getDynamicPagesCont($id)
{
	$page_arr="";
	$sel_dynamic_page = "select * from  static_page where id=$id";
	$res_dynamic_page = mysql_query($sel_dynamic_page);
	if(mysql_num_rows($res_dynamic_page)>0)
	{
		$val = mysql_fetch_object($res_dynamic_page);
		$page_arr[name] = $val->PageTitle;
		$page_arr[title] = $val->name;
		$page_arr[description] = $val->description;
		$page_arr[meta_keywords] = $val->meta_keywords;
		$page_arr[meta_title] = $val->meta_title;
		$page_arr[meta_description] = $val->meta_description;
	}
	return $page_arr;
}
function abreviateTotalCount($value) 
{

    $abbreviations = array(12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => '');

    foreach($abbreviations as $exponent => $abbreviation) 
    {

        if($value >= pow(10, $exponent)) 
        {

          return round(floatval($value / pow(10, $exponent)),1).$abbreviation;

        }

    }

}
function getDayValue($id="")
{
	for($d=1; $d < 32; $d++)
	{
		if($d == $id)
			$dayOption .="<option value='$d' selected>$d</option>";
		else
			$dayOption .="<option value='$d'>$d</option>";
	}
	return $dayOption;
}
function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function count_pages($pdfname) {
      $pdftext = file_get_contents($pdfname);
      $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
      return $num;
}
?>
<?php include ('connect.php');
    
function alist ($array) {  
  $alist = "<ul>";
  for ($i = 0; $i < sizeof($array); $i++) {
    $alist .= "<li>$array[$i]";
  }
  $alist .= "</ul>";
  return $alist;
}
//Try to get ImageMagick "convert" program version number.
exec("convert -version", $out, $rcode);
//Print the return code: 0 if OK, nonzero if error. 
echo "Version return code is $rcode <br>"; 
//Print the output of "convert -version"    
echo alist($out);


$ver = exec("/usr/bin/gs --version 2>&1");
var_dump($ver);

$num = count_pages('test/test-file1.pdf');
for($i = 0; $i<$num;$i++)
{
	$ver1 = exec('/usr/bin/gs -dNOPAUSE -r300 -dBATCH -sDEVICE=jpeg -sOutputFile="test/test'.$i.'.jpg" -dFirstPage='.$i.' -dLastPage='.$i.' -GraphicsAlphaBits=4 test/test-file1.pdf 2>&1');
	var_dump($ver1);
}	


?>
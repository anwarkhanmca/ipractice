<?php
 function remove_special_char($url)
 {
    $url = noTr($url);
	$url = trChar(trim($url));
    //$url = strtolower($url);    

    $find = array('<b>', '</b>');
    $url = str_replace ($find, '', $url);

    $url = preg_replace('/<(\/{0,1})img(.*?)(\/{0,1})\>/', 'image', $url);

    $find = array(' ', '&quot;', '&amp;', '&', '\r\n', '\n', '/', '\\', '+', '<', '>');
    $url = str_replace ($find, '-', $url);

    $find = array('�', '�', '�', '�', '�', '�', '�', '�');
    $url = str_replace ($find, 'e', $url);

    $find = array('�', 'i', '�', '�', '�', 'I', 'I', '�', '�', '�', '�');
    $url = str_replace ($find, 'i', $url);

    $find = array('�', '�', '�', '�', '�', '�', '�', '�');
    $url = str_replace ($find, 'o', $url);

    $find = array('�', '�', '�', '�', '�', '�', '�', '�', '�', '�');
    $url = str_replace ($find, 'a', $url);

    $find = array('�', '�', '�', '�', '�', '�', '�', '�');
    $url = str_replace ($find, 'u', $url);

    $find = array('�', '�');
    $url = str_replace ($find, 'c', $url);

    $find = array('s', 'S');
    $url = str_replace ($find, 's', $url);

    $find = array('g', 'G');
    $url = str_replace ($find, 'g', $url);
 
    return $url;
}
?>
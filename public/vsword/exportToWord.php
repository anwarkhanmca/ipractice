<?php
$breaks = array("<br />","<br>","<br/>");

$content = str_replace($breaks, "\n", $_POST['content']);
$subject = $_POST['subject'];


require_once 'vsword/VsWord.php'; 
VsWord::autoLoad();

$doc = new VsWord();  
$parser = new HtmlParser($doc);
$parser->parse($content);

$data['name'] = $subject.'.docx';
$doc->saveAs($data['name']);
echo json_encode($data);
exit;
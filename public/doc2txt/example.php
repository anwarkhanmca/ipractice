<?php
require("doc2txt.class.php");

$docObj = new Doc2Txt("Template.docx");

$txt = $docObj->convertToText();
echo $txt;
?>
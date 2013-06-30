<?php
if(isset($error)) die($error);
header("Content-Type: " . $content_type);
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
readfile($file_path);
?>
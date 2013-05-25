<?php
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"" .$file_path. "\";");
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
readfile($file_path);
?>
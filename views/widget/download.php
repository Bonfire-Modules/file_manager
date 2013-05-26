<?php
header("Content-Type: " . $content_type);
header("Content-Disposition: attachment; filename=\"" . $attachment_name . "\";");
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
readfile($file_path);
?>
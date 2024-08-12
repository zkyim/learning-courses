<?php
$file_name = $_FILES['imgCourse']['name'];
$tmp_name = $_FILES['imgCourse']['tmp_name'];
$file_up_name = time().$file_name;
move_uploaded_file($tmp_name, $file_up_name);
?>
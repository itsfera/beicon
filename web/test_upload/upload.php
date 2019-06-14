<?php
session_start();
header('content-type: text/plain; charset=utf-8');

// Check for start time from nudge
if( ! isset($_SESSION['time']))
        exit('Missing start time. Javascript disabled?');

// Check for file
if( ! isset($_FILES['file']))
        exit('No file upload.');

// Check if upload was ok
if($_FILES['file']['error'] !== UPLOAD_ERR_OK
|| ! is_uploaded_file($_FILES['file']['tmp_name']))
         exit('Upload failed'.PHP_EOL.'Error code: '.$_FILES['file']['error']);

// Delete original file
@unlink($_FILES['image']['tmp_name']);

// Calculate time
$time = microtime(true) - $_SESSION['time'];
$request_time = microtime(true) - $_SERVER['REQUEST_TIME'];
unset($_SESSION['time']);

// Output
echo 'Upload complete'.PHP_EOL.PHP_EOL;
$out = array(
        'Name' => $_FILES['file']['name'],
        'Size' => $_FILES['file']['size'],
        'Request time' => round($request_time, 3).' s',
        'Measured time' => round($time, 3).' s',
        'Speed' => $_FILES['file']['size'] / $time.'/s',
);
foreach($out as $k => $v)
        printf('%17s : %s'.PHP_EOL, $k, $v);

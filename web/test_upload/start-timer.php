<?php session_start();
$_SESSION['time'] = microtime(true);
echo ('OK '.$_SESSION['time']);
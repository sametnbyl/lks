<?php 

//echo "Burada olamaman gerekiyor.";

session_start();
session_unset();
session_destroy();

header('Location: /lks');

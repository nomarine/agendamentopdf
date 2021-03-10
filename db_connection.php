<?php
function OpenConAgendamento()
 {
 $dbhost = "192.168.33.5";
 $dbuser = "rafael";
 $dbpass = "rafael122";
 $db = "agendamento";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 return $conn;
 }
 
 function OpenConLocal()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "relatorio";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>
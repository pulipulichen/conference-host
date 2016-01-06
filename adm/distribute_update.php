<?php require_once('../Connections/conn.php'); 
mysql_select_db($database_conn, $conn);
$query_distribute = "SELECT referee1, referee2, referee3 FROM paper_distribute";
$distribute = mysql_query($query_distribute, $conn) or die(mysql_error());
$row_distribute = mysql_fetch_assoc($distribute);
$totalRows_distribute = mysql_num_rows($distribute);
$refarray['NULL']=1;
  do { 
  		foreach($refarray as $key => $value){
			if(!strcmp($row_distribute['referee1'],$key)){
				$refarray[$key]++;}
			else{
				if(!isset($refarray[$row_distribute['referee1']])){$refarray[$row_distribute['referee1']]=1;}}
			if(!strcmp($row_distribute['referee2'],$key)){
				$refarray[$key]++;}
			else{
				if(!isset($refarray[$row_distribute['referee2']])){$refarray[$row_distribute['referee2']]=1;}}
			if(!strcmp($row_distribute['referee3'],$key)){
				$refarray[$key]++;}
			else{
				if(!isset($refarray[$row_distribute['referee3']])){$refarray[$row_distribute['referee3']]=1;}}
		}
  } while ($row_distribute = mysql_fetch_assoc($distribute));
unset($refarray['NULL']);
foreach($refarray as $key => $value)
{
	$insertSQL = sprintf("UPDATE referee SET distribute=%d WHERE id='%s'", $value, $key);
	mysql_select_db($database_conn, $conn);
	$Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}
mysql_free_result($distribute);
?>
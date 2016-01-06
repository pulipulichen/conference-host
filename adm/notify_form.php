<?php require_once('../Connections/conn.php'); ?>
<?php
mysql_select_db($database_conn, $conn);
$query_notify = "SELECT * FROM paper_distribute";
$notify = mysql_query($query_notify, $conn) or die(mysql_error());
$row_notify = mysql_fetch_assoc($notify);
$totalRows_notify = mysql_num_rows($notify);
$refarray['NULL']=1;
$distribute[0]['paper']='1234';
$distribute[0]['referee1']='test';
$distribute[0]['referee2']='test';
$distribute[0]['referee3']='test';
$distribute[0]['finish1']='n';
$distribute[0]['finish2']='n';
$distribute[0]['finish3']='n';
$index=0;
  do { 
  		foreach($refarray as $key => $value){
			if(!strcmp($row_notify['referee1'],$key)){
				$refarray[$key]++;}
			else{
				if(!isset($refarray[$row_notify['referee1']])){$refarray[$row_notify['referee1']]=1;}}
			if(!strcmp($row_notify['referee2'],$key)){
				$refarray[$key]++;}
			else{
				if(!isset($refarray[$row_notify['referee2']])){$refarray[$row_notify['referee2']]=1;}}
			if(!strcmp($row_notify['referee3'],$key)){
				$refarray[$key]++;}
			else{
				if(!isset($refarray[$row_notify['referee3']])){$refarray[$row_notify['referee3']]=1;}}
		}
		$distri[$index]['paper']=$row_notify['paper'];
		$distri[$index]['referee1']=$row_notify['referee1'];
		$distri[$index]['referee2']=$row_notify['referee2'];
		$distri[$index]['referee3']=$row_notify['referee3'];
		$distri[$index]['finish1']=$row_notify['finish1'];
		$distri[$index]['finish2']=$row_notify['finish2'];
		$distri[$index]['finish3']=$row_notify['finish3'];
		$index++;
  } while ($row_notify = mysql_fetch_assoc($notify));
  unset($refarray['NULL']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
<script language="JavaScript">
<!--
var modify=0;
function popUpWindow(URLStr)
{
  var width="300", height="100";
  var left = (screen.width/2) - width/2;
  var top = (screen.height/2) - height/2;
  if(modify)
  {
    if(!modify.closed) modify.close();
  }
  modify = open(URLStr, 'notify', 'toolbar=no,location=no,directories=no,status=no,menub ar=no,scrollbar=no,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
//-->
</script>
</head>

<body>
<table width="100%"  border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td width="4%">&nbsp;</td>
    <td width="10%">審稿者</td>
    <td colspan="3">論文</td>
    <td width="8%">邀請通知</td>
    <td width="10%">內容</td>
    <td width="6%">寄送</td>
  </tr>
<?php
	$num=0;
	foreach($refarray as $key => $value)
	{
		$value++;
		$query_ID = sprintf("SELECT name, alart FROM referee WHERE id='%s'",$key);
		$ID = mysql_query($query_ID, $conn) or die(mysql_error());
		$row_ID = mysql_fetch_assoc($ID);
		$totalRows_ID = mysql_num_rows($ID);
		if($totalRows_ID){
			echo '<form name="form1" method="post" action="notify.php" target="notify" onSubmit="popUpWindow(\'process.htm\');">'
                                . '<tr><td rowspan="'.$value.'">'.++$num.'</td><td rowspan="'.$value.'">'
				 .$row_ID['name'].'</td><td>編號</td><td>標題</td><td>已審核</td><td rowspan="'.$value.'">';
			if(!strcmp($row_ID['alart'],'y')) echo '是';else echo '否';
			echo '</td><td rowspan="'.$value.'"><input name="again" type="radio" value="1" checked>再提醒<br>'
                                . '<input name="again" type="radio" value="0">通知</td><td rowspan="'.$value.'"><input type="hidden" name="id" value="'.$key.'"><input type="submit" name="Submit" value="送出"></td></tr>';
			$tmp[0]=0;
			$z=0;
			for($j=0;$j<$index;$j++)
			{
				if(!strcmp($distri[$j]['referee1'],$key) || !strcmp($distri[$j]['referee2'],$key) || !strcmp($distri[$j]['referee3'],$key))
				{
					$tmp[$z++]=$j;
				}
			}
			//foreach($tmp as $y)echo $key.','.$y.'<br>';
			for($i=0;$i<$value-1;$i++)
			{
				echo '<tr><td width="5%">'.$distri[$tmp[$i]]['paper'].'</td><td>';
				$query_topic = sprintf("SELECT topic FROM upload WHERE paper_serial='%d'",$distri[$tmp[$i]]['paper']);
				$topic = mysql_query($query_topic, $conn) or die(mysql_error());
				$row_topic = mysql_fetch_assoc($topic);
				echo $row_topic['topic'].'</td><td width="7%">';
				if(!strcmp($distri[$tmp[$i]]['referee1'],$key)){if(!strcmp($distri[$tmp[$i]]['finish1'],'y'))
				echo '是<input type="hidden" name="list'.$i.'" value="'.$distri[$tmp[$i]]['paper'].'">';
				else echo '否<input type="hidden" name="list'.$i.'" value="'.$distri[$tmp[$i]]['paper'].'">';}
				if(!strcmp($distri[$tmp[$i]]['referee2'],$key)){if(!strcmp($distri[$tmp[$i]]['finish2'],'y'))
				echo '是<input type="hidden" name="list'.$i.'" value="'.$distri[$tmp[$i]]['paper'].'">';
				else echo '否<input type="hidden" name="list'.$i.'" value="'.$distri[$tmp[$i]]['paper'].'">';}
				if(!strcmp($distri[$tmp[$i]]['referee3'],$key)){if(!strcmp($distri[$tmp[$i]]['finish3'],'y'))
				echo '是<input type="hidden" name="list'.$i.'" value="'.$distri[$tmp[$i]]['paper'].'">';
				else echo '否<input type="hidden" name="list'.$i.'" value="'.$distri[$tmp[$i]]['paper'].'">';}
				echo '</td></tr>';
			}
			echo '</form>';
			unset($tmp);
		}
	}
?>
</table>
</body>
</html>
<?php
mysql_free_result($notify);
?>

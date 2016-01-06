<?php require_once('../Connections/conn.php'); ?>
<?php
mysql_select_db($database_conn, $conn);
$query_paper = "SELECT Paper_serial, Member, Topic FROM upload";
$paper = mysql_query($query_paper, $conn) or die(mysql_error());
$row_paper = mysql_fetch_assoc($paper);
$totalRows_paper = mysql_num_rows($paper);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
body,td,th {
	font-size: small;
}
-->
</style>
</head>

<body>
<table width="200%" border="1" cellpadding="2" cellspacing="0" bordercolor="#999999">
    <tr bgcolor="#0033CC">
      <td rowspan="2"><div align="center" class="style1">編號</div></td>
        <td rowspan="2"><div align="center" class="style1">論文標題</div></td>
        <td rowspan="2"><div align="center" class="style1">作者</div></td>
        <td colspan="7"><div align="center" class="style1">審稿者1</div></td>
        <td colspan="7"><div align="center" class="style1">審稿者2</div></td>
    </tr>
    <tr>
      <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">主題相關性</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">論文原創性</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">論文嚴謹度</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">成果重要性</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">論文可讀性</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">資料完整性</span></div></td>
      <td bordercolor="#FF0000" bgcolor="#FF0000"><div align="center" class="style1"><span class="content">整體評價</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">主題相關性</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">論文原創性</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">論文嚴謹度</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">成果重要性</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">論文可讀性</span></div></td>
        <td bgcolor="#0033CC"><div align="center" class="style1"><span class="content">資料完整性</span></div></td>
      <td bordercolor="#FF0000" bgcolor="#FF0000"><div align="center" class="style1"><span class="content">整體評價</span></div></td>
  </tr>
    <?php 
	$i=0;
	do { 
			$query_name = sprintf("SELECT name FROM member WHERE ID = '%s'",$row_paper['Member']);
			$name = mysql_query($query_name, $conn) or die(mysql_error());
			$row_name = mysql_fetch_assoc($name);
			$query_referee = sprintf("SELECT paper, referee1, referee2 FROM paper_distribute WHERE paper = %d",$row_paper['Paper_serial']);
			$referee = mysql_query($query_referee, $conn) or die(mysql_error());
			$row_referee = mysql_fetch_assoc($referee);
			$query_review1 = sprintf("SELECT item1, item2, item3, item4, item5, item6, item7, item8, item9 FROM review WHERE serial ='%s'",$row_referee['referee1'].$row_paper['Paper_serial']);
			$review1 = mysql_query($query_review1, $conn) or die(mysql_error());
			$row_review1 = mysql_fetch_assoc($review1);
			$query_review2 = sprintf("SELECT item1, item2, item3, item4, item5, item6, item7, item8, item9 FROM review WHERE serial ='%s'",$row_referee['referee2'].$row_paper['Paper_serial']);
			$review2 = mysql_query($query_review2, $conn) or die(mysql_error());
			$row_review2 = mysql_fetch_assoc($review2);
			if(($i++)%2)echo '<tr bgcolor="#CCDDFF">';
			else echo '<tr bgcolor="#FFFFFF">'
	?>
        <td><?php echo $row_paper['Paper_serial']; ?></td>
        <td><?php echo $row_paper['Topic']; ?></td>
        <td><?php echo $row_name['name']; ?></td>
        <td><div align="center"><?php echo $row_review1['item1']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review1['item2']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review1['item3']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review1['item4']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review1['item5']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review1['item6']; ?>&nbsp;</div></td>
        <td bordercolor="#FF0000"><div align="center"><?php
		 //整體評價 (4)強烈建議接受 (3)建議接受 (2)需要時可考慮接受 (1)不接受 

		switch ($row_review1['item7']){
          case 4:
           echo "強烈建議接受";
          break;

          case 3:
           echo "建議接受";
          break;

          case 2:
           echo "需要時可考慮接受";
          break;

		  case 1:
           echo "不接受";
          break;

          default:
           echo "<font color=999999>尚未審查</font>";
          }
?>&nbsp;</div></td>		
		
        <td><div align="center"><?php echo $row_review2['item1']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review2['item2']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review2['item3']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review2['item4']; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $row_review2['item5']; ?>&nbsp;</div></td>
		<td><div align="center"><?php echo $row_review2['item6']; ?>&nbsp;</div></td>
        <td bordercolor="#FF0000"><div align="center"><?php
		 //整體評價 (4)強烈建議接受 (3)建議接受 (2)需要時可考慮接受 (1)不接受 

		switch ($row_review2['item7']){
          case 4:
           echo "強烈建議接受";
          break;

          case 3:
           echo "建議接受";
          break;

          case 2:
           echo "需要時可考慮接受";
          break;

		  case 1:
           echo "不接受";
          break;

          default:
           echo "<font color=999999>尚未審查</font>";
          }
?>&nbsp;</div></td>	
        
    <?php } while ($row_paper = mysql_fetch_assoc($paper)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($paper);
mysql_free_result($referee);
mysql_free_result($review1);
mysql_free_result($review2);
?>

<?php require_once('../Connections/conn.php'); 
$currentPage = $_SERVER["PHP_SELF"];

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "receive")) {
  $updateSQL = sprintf("UPDATE upload SET receive=%s WHERE paper_serial=%s",
  				 GetSQLValueString($_POST['receive'], "text"),
				 GetSQLValueString($_POST['Paper_serial'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "reviewlist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_paper_review = 20;
$pageNum_paper_review = 0;
if (isset($_GET['pageNum_paper_review'])) {
  $pageNum_paper_review = $_GET['pageNum_paper_review'];
}
$startRow_paper_review = $pageNum_paper_review * $maxRows_paper_review;

mysql_select_db($database_conn, $conn);
$query_paper_review = "SELECT * FROM paper_distribute";
$query_limit_paper_review = sprintf("%s LIMIT %d, %d", $query_paper_review, $startRow_paper_review, $maxRows_paper_review);
$paper_review = mysql_query($query_limit_paper_review, $conn) or die(mysql_error());
$row_paper_review = mysql_fetch_assoc($paper_review);

if (isset($_GET['totalRows_paper_review'])) {
  $totalRows_paper_review = $_GET['totalRows_paper_review'];
} else {
  $all_paper_review = mysql_query($query_paper_review);
  $totalRows_paper_review = mysql_num_rows($all_paper_review);
}
$totalPages_paper_review = ceil($totalRows_paper_review/$maxRows_paper_review)-1;

$queryString_paper_review = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_paper_review") == false && 
        stristr($param, "totalRows_paper_review") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_paper_review = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_paper_review = sprintf("&totalRows_paper_review=%d%s", $totalRows_paper_review, $queryString_paper_review);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
<script language="JavaScript">
<!--
var notify=0;
function popUpWindow(URLStr)
{
  var width="300", height="100";
  var left = (screen.width/2) - width/2;
  var top = (screen.height/2) - height/2;
  if(notify)
  {
    if(!notify.closed) modify.close();
  }
  modify = open(URLStr, 'notify', 'toolbar=no,location=no,directories=no,status=no,menub ar=no,scrollbar=no,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
//-->
</script>
</head>

<body>
 <div align="center">
   <?php if ($pageNum_paper_review > 0) { // Show if not first page ?>
   <a href="<?php printf("%s?pageNum_paper_review=%d%s", $currentPage, 0, $queryString_paper_review); ?>">第一頁</a> | <a href="<?php printf("%s?pageNum_paper_review=%d%s", $currentPage, max(0, $pageNum_paper_review - 1), $queryString_paper_review); ?>">上一頁</a> |
   <?php } // Show if not first page ?>
   <?php if ($pageNum_paper_review < $totalPages_paper_review) { // Show if not last page ?>
   <a href="<?php printf("%s?pageNum_paper_review=%d%s", $currentPage, min($totalPages_paper_review, $pageNum_paper_review + 1), $queryString_paper_review); ?>">下一頁</a> | <a href="<?php printf("%s?pageNum_paper_review=%d%s", $currentPage, $totalPages_paper_review, $queryString_paper_review); ?>">最後一頁</a>
   <?php } // Show if not last page ?> <br>
 </div>
 <table width="100%"  border="1" cellspacing="0" cellpadding="2">
  <tr>
    <td width="4%">編號</td>
    <td>標題</td>
    <td width="6%">作者</td>
    <td width="10%">審稿意見表1</td>
    <td width="10%">審稿意見表2</td>
    <td width="8%">結果</td>
    <td width="8%">通知</td>
  </tr>
  <?php do { 
$query_paper = sprintf("SELECT member, topic, receive FROM upload WHERE paper_serial=%d",$row_paper_review['paper']);
$paper = mysql_query($query_paper, $conn) or die(mysql_error());
$row_paper = mysql_fetch_assoc($paper);
$query_name = sprintf("SELECT name,id FROM member WHERE id='%s'",$row_paper['member']);
$name = mysql_query($query_name, $conn) or die(mysql_error());
$row_name = mysql_fetch_assoc($name);

?>
  <tr>
    <td><?php echo $row_paper_review['paper']; ?></td>
    <td>
        <?php echo $row_paper['topic']; ?>
        - 
        <a href="../upload/<?php echo $row_paper['member']; ?>/abstract-<?php echo $row_paper_review['paper']; ?>.pdf" target="_blank">[摘要]</a> 
        / <a href="../upload/<?php echo $row_paper['member']; ?>/paper-<?php echo $row_paper_review['paper']; ?>.pdf" target="_blank">[全文]</a></td>
    <td><?php echo $row_name['name']; ?></td>
    <td><?php if(!strcmp('y',$row_paper_review['finish1']))
			   	{ echo '<a href="review.php?serial='.$row_paper_review['referee1'].$row_paper_review['paper'].'" target="_blank">瀏覽</a>';
			   }elseif(!strcmp('',$row_paper_review['referee1'])){echo '無';}
			   else{echo '未完成';} ?></td>
    <td><?php if(!strcmp('y',$row_paper_review['finish2']))
			   	{ echo '<a href="review.php?serial='.$row_paper_review['referee2'].$row_paper_review['paper'].'" target="_blank">瀏覽</a>';
			   }elseif(!strcmp('',$row_paper_review['referee2'])){echo '無';}
			   else{echo '未完成';} ?></td>
    <td><?php if(!strcmp('n',$row_paper['receive'])){ ?><form name="receive" method="POST" action="<?php echo $editFormAction; ?>">
      <input name="Paper_serial" type="hidden" value="<?php echo $row_paper_review['paper']; ?>"><input name="receive" type="radio" value='a' checked>
      Oral<br>
      <input name="receive" type="radio" value='r'>
      Poster
      <input type="submit" name="Submit" value="確認">
      <input type="hidden" name="MM_update" value="receive">
    </form><?php }elseif(!strcmp('a',$row_paper['receive']))echo 'Oral';else echo 'Poster'; ?></td>
    <td><?php if(strcmp('n',$row_paper['receive'])){ ?><form name="notify" method="post" action="notify2.php" target="notify" onSubmit="popUpWindow(\'process.htm\');">
        <input name="Paper_serial" type="hidden" value="<?php echo $row_paper_review['paper']; ?>">
        <input name="receive" type="hidden" value="<?php echo $row_paper['receive']; ?>">
        <input disable type="submit" name="Submit" value="送出">
    </form><?php 
    
    }
    else {
        echo '&nbsp;'; 
    }
    ?></td>
  </tr>
  <?php } while ($row_paper_review = mysql_fetch_assoc($paper_review)); ?>
</table>
</body>
</html>
<?php
//mysql_free_result($paper_review);


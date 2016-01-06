<?php require_once('../Connections/conn.php'); ?>
<?php
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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "referee") && !($_POST['ref'][0]=='' && $_POST['ref'][1]=='' && $_POST['ref'][2]=='')) {
  $insertSQL = sprintf("INSERT INTO paper_distribute (paper, referee1, referee2, referee3) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['paper'], "int"),
                       GetSQLValueString($_POST['ref'][0], "text"),
                       GetSQLValueString($_POST['ref'][1], "text"),
                       GetSQLValueString($_POST['ref'][2], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  require_once('distribute_update.php');
  $insertGoTo = "paper_distribute.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "referee") && !($_POST['ref'][0]=='' && $_POST['ref'][1]=='' && $_POST['ref'][2]=='')) {
  $insertSQL = sprintf("UPDATE paper_distribute SET referee1=%s, referee2=%s, referee3=%s WHERE paper=%s",
                       GetSQLValueString($_POST['ref'][0], "text"),
                       GetSQLValueString($_POST['ref'][1], "text"),
                       GetSQLValueString($_POST['ref'][2], "text"),
                       GetSQLValueString($_POST['paper'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  require_once('distribute_update.php');
  $insertGoTo = "paper_distribute.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$maxRows_paper = 20;
$pageNum_paper = 0;
if (isset($_GET['pageNum_paper'])) {
  $pageNum_paper = $_GET['pageNum_paper'];
}
$startRow_paper = $pageNum_paper * $maxRows_paper;

mysql_select_db($database_conn, $conn);
$query_paper = "SELECT Paper_serial, Member, Topic, `Class`, `Group` FROM upload";
$query_limit_paper = sprintf("%s LIMIT %d, %d", $query_paper, $startRow_paper, $maxRows_paper);
$paper = mysql_query($query_limit_paper, $conn) or die(mysql_error());
$row_paper = mysql_fetch_assoc($paper);

if (isset($_GET['totalRows_paper'])) {
  $totalRows_paper = $_GET['totalRows_paper'];
} else {
  $all_paper = mysql_query($query_paper);
  $totalRows_paper = mysql_num_rows($all_paper);
}
$totalPages_paper = ceil($totalRows_paper/$maxRows_paper)-1;

mysql_select_db($database_conn, $conn);
$query_referee = "SELECT ID, name, location, profession FROM referee ORDER BY name ASC";
$referee = mysql_query($query_referee, $conn) or die(mysql_error());
$row_referee = mysql_fetch_assoc($referee);
$totalRows_referee = mysql_num_rows($referee);

mysql_select_db($database_conn, $conn);
$query_distribute = "SELECT * FROM paper_distribute";
$distribute = mysql_query($query_distribute, $conn) or die(mysql_error());
$row_distribute = mysql_fetch_assoc($distribute);
$totalRows_distribute = mysql_num_rows($distribute);

$queryString_paper = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_paper") == false && 
        stristr($param, "totalRows_paper") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_paper = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_paper = sprintf("&totalRows_paper=%d%s", $totalRows_paper, $queryString_paper);
$i=0;
do
{
	$dis_ed[$i++]=$row_distribute['paper'];
}while($row_distribute = mysql_fetch_assoc($distribute));
//foreach($dis_ed as $value)echo $value."<br>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function displayreferee(selected)
{
  var index = selected.selectedIndex;
  var url = "referee2.php?id="+selected.options[index].value;
    window.open(url, "referee");
}
function refresh()
{
  var url = "referee2.php";
    window.open(url, "referee");
}
//-->
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
body,td,th {
	font-size: 12px;
}
-->
</style></head>

<body>
<div align="center">
  <?php if ($pageNum_paper > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_paper=%d%s", $currentPage, 0, $queryString_paper); ?>">第一頁</a> | <a href="<?php printf("%s?pageNum_paper=%d%s", $currentPage, max(0, $pageNum_paper - 1), $queryString_paper); ?>">上一頁</a> |
  <?php } // Show if not first page ?>
  <?php if ($pageNum_paper < $totalPages_paper) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_paper=%d%s", $currentPage, min($totalPages_paper, $pageNum_paper + 1), $queryString_paper); ?>">下一頁</a> | <a href="<?php printf("%s?pageNum_paper=%d%s", $currentPage, $totalPages_paper, $queryString_paper); ?>">最後一頁</a>
  <?php } // Show if not last page ?>
  <br>
</div>
<table width="960"  border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#333333">
  <tr bgcolor="#00CCFF">
    <td width="4%">編號</td>
    <td width="8%">帳號</td>
    <td width="30%">論文題目</td>
    <td width="8%">類文類別</td>
    <td width="4%">組別</td>
    <td width="46%">審稿者</td>
  </tr>
  <?php do { 
	foreach($dis_ed as $value){
		if($value==$row_paper['Paper_serial'])
		{ $update=true;}}?>
  <tr bgcolor="#FFFFCC">
    <td><?php echo $row_paper['Paper_serial']; ?></td>
    <td><?php echo $row_paper['Member']; ?></td>
    <td><?php echo $row_paper['Topic']; ?></td>
    <td><?php echo $row_paper['Class']; ?></td>
    <td><?php if(!strcmp('oral',$row_paper['Group'])){echo '口頭發表組';}else{echo '網路發表組';} ?></td>
    <td><form action="<?php echo $editFormAction; ?>" method="POST" name="referee" id="referee" onSubmit="refresh()">
    <input name="paper" type="hidden" value="<?php echo $row_paper['Paper_serial']; ?>">
        <select name="ref[]" id="ref1" onChange="displayreferee(this)">
		  <option value="" selected>審稿者一</option>
          <?php
do {  if(!strcmp('network',$row_paper['Group'])){
	echo '<option value="'.$row_referee['ID'].'"';
	if(isset($update)){ 
		$query_distribute = sprintf("SELECT * FROM paper_distribute WHERE paper=%s",$row_paper['Paper_serial']);
		$distribute = mysql_query($query_distribute, $conn) or die(mysql_error());
		$row_distribute = mysql_fetch_assoc($distribute);
		if(!strcmp($row_distribute['referee1'],$row_referee['ID']))echo ' selected';
	}
	echo '>'.$row_referee['name'].'</option>';
}elseif(!strcmp('oral',$row_paper['Group']) && !strcmp('oral',$row_referee['location'])){
	echo '<option value="'.$row_referee['ID'].'"';
	if(isset($update)){ 
		$query_distribute = sprintf("SELECT * FROM paper_distribute WHERE paper=%s",$row_paper['Paper_serial']);
		$distribute = mysql_query($query_distribute, $conn) or die(mysql_error());
		$row_distribute = mysql_fetch_assoc($distribute);
		if(!strcmp($row_distribute['referee1'],$row_referee['ID']))echo ' selected';
	}
	echo '>'.$row_referee['name'].'</option>';
}} while ($row_referee = mysql_fetch_assoc($referee));
  $rows = mysql_num_rows($referee);
  if($rows > 0) {
      mysql_data_seek($referee, 0);
	  $row_referee = mysql_fetch_assoc($referee);
  }
?>
        </select>
        <select name="ref[]" id="ref2" onChange="displayreferee(this)">
		  <option value="" selected>審稿者二</option>
          <?php
do {  if(!strcmp('network',$row_paper['Group'])){
	echo '<option value="'.$row_referee['ID'].'"';
	if(isset($update)){ 
		$query_distribute = sprintf("SELECT * FROM paper_distribute WHERE paper=%s",$row_paper['Paper_serial']);
		$distribute = mysql_query($query_distribute, $conn) or die(mysql_error());
		$row_distribute = mysql_fetch_assoc($distribute);
		if(!strcmp($row_distribute['referee2'],$row_referee['ID']))echo ' selected';
	}
	echo '>'.$row_referee['name'].'</option>';
}elseif(!strcmp('oral',$row_paper['Group']) && !strcmp('oral',$row_referee['location'])){
	echo '<option value="'.$row_referee['ID'].'"';
	if(isset($update)){ 
		$query_distribute = sprintf("SELECT * FROM paper_distribute WHERE paper=%s",$row_paper['Paper_serial']);
		$distribute = mysql_query($query_distribute, $conn) or die(mysql_error());
		$row_distribute = mysql_fetch_assoc($distribute);
		if(!strcmp($row_distribute['referee2'],$row_referee['ID']))echo ' selected';
	}
	echo '>'.$row_referee['name'].'</option>';
}} while ($row_referee = mysql_fetch_assoc($referee));
  $rows = mysql_num_rows($referee);
  if($rows > 0) {
      mysql_data_seek($referee, 0);
	  $row_referee = mysql_fetch_assoc($referee);
  }
?>
        </select>
        <?php if(isset($update)){ ?>
        <input type="submit" name="Submit" value="更新">
        <input type="hidden" name="MM_update" value="referee">
<?php	}else{
?>
        <input type="submit" name="Submit" value="新增">
        <input type="hidden" name="MM_insert" value="referee">
<?php }unset($update); ?>
    </form></td>
  </tr>
  <?php } while ($row_paper = mysql_fetch_assoc($paper)); ?>
</table>
<div align="center">
  <?php if ($pageNum_paper > 0) { // Show if not first page ?>
    <a href="<?php printf("%s?pageNum_paper=%d%s", $currentPage, 0, $queryString_paper); ?>">第一頁</a> | <a href="<?php printf("%s?pageNum_paper=%d%s", $currentPage, max(0, $pageNum_paper - 1), $queryString_paper); ?>">上一頁</a> |
    <?php } // Show if not first page ?>
  <?php if ($pageNum_paper < $totalPages_paper) { // Show if not last page ?>
    <a href="<?php printf("%s?pageNum_paper=%d%s", $currentPage, min($totalPages_paper, $pageNum_paper + 1), $queryString_paper); ?>">下一頁</a> | <a href="<?php printf("%s?pageNum_paper=%d%s", $currentPage, $totalPages_paper, $queryString_paper); ?>">最後一頁</a>
    <?php } // Show if not last page ?>
</div>
</body>
</html>
<?php
mysql_free_result($paper);

mysql_free_result($referee);

mysql_free_result($distribute);
?>

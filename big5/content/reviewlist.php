<?php require_once('../../Connections/conn.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "reviewlogin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$colname_review = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_review = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conn, $conn);
$query_review = sprintf("SELECT * FROM paper_distribute WHERE referee1 = '%s' OR referee2 = '%s' OR referee3 = '%s'", $colname_review, $colname_review, $colname_review);
$review = mysql_query($query_review, $conn) or die(mysql_error());
$row_review = mysql_fetch_assoc($review);
$totalRows_review = mysql_num_rows($review);
$query_name = sprintf("SELECT name FROM referee WHERE ID = '%s'", $colname_review);
$name = mysql_query($query_name, $conn) or die(mysql_error());
$row_name = mysql_fetch_assoc($name);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>論文審閱</title>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/style.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../menuItems.js"></SCRIPT>
<LINK REL="stylesheet" HREF="../../style/style.css" TYPE="text/css">
<body onLoad="cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice')">
<DIV id="myMenuID"></DIV>
<br><DIV class="scoll">
<table width=100% border=0 cellspacing=10>

  <th class="topic">論文審閱</th>
  <tr>
	<td class="content"><br>
      <?php echo $row_name['name'];
	  if ($totalRows_review == 0) { // Show if recordset empty ?>
您好，並未有任何您所負責審閱之論文。
<?php } // Show if recordset empty ?>
      <?php if ($totalRows_review > 0) { // Show if recordset not empty ?>
您好，以下為您審閱之論文：請在1月17日前完成審閱，謝謝!
<table width="100%"  border="1" cellspacing="0" cellpadding="2">
  <tr class="color">
    <td width="6%"><div align="center">編號</div></td>
    <td><div align="center">標題</div></td>
    <td width="6%"><div align="center">組別</div></td>
    <td width="8%"><div align="center">論文檔</div></td>
    <td width="8%"><div align="center">摘要檔</div></td>
    <td width="10%"><div align="center">審閱內容</div></td>
  </tr>
  <?php do { 
		$query_paper = sprintf("SELECT Paper_serial, Member, Topic, `Class`, `Group` FROM upload WHERE Paper_serial = %d",$row_review['paper']);
		$paper = mysql_query($query_paper, $conn) or die(mysql_error());
		$row_paper = mysql_fetch_assoc($paper);?>
  <form name="review" method="post" action="review.php"><tr>
      <td class="content"><div align="center"><?php echo $row_review['paper']; ?></div></td>
      <td class="content"><?php echo $row_paper['Topic']; ?></td>
      <td class="content"><div align="center"><?php if(!strcmp($row_paper['Group'],'oral'))echo '口頭發表組';else echo '網路發表組'; ?></div></td>
      <td><div align="center"><a target="_blank" href="../../upload/<?php echo $row_paper['Member'].'/paper-'.$row_review['paper'].'.pdf'; ?>"><img src="../../images/menu/pdf.gif" border="0"></a></div></td>
      <td><div align="center"><a target="_blank" href="../../upload/<?php echo $row_paper['Member'].'/abstract-'.$row_review['paper'].'.pdf'; ?>"><img src="../../images/menu/pdf.gif" border="0"></a></div></td>
	  <td><div align="center">
	    
	      <input type="hidden" name="paper" value="<?php echo $row_review['paper']; ?>">
	      <input type="hidden" name="topic" value="<?php echo $row_paper['Topic']; ?>">
	      <input type="hidden" name="location" value="<?php echo $row_paper['Group']; ?>">
	      <input type="submit" name="Submit" value="填寫"
		  <?php 
		  	if(!strcmp($row_review['referee1'],$_SESSION['MM_Username']) && !strcmp($row_review['finish1'],'y'))echo ' disabled';
		  	if(!strcmp($row_review['referee2'],$_SESSION['MM_Username']) && !strcmp($row_review['finish2'],'y'))echo ' disabled';
			if(!strcmp($row_review['referee3'],$_SESSION['MM_Username']) && !strcmp($row_review['finish3'],'y'))echo ' disabled'; 
		  ?>>
	      
	  </div></td>
  </tr></form>
  <?php } while ($row_review = mysql_fetch_assoc($review)); ?>
</table>
<?php } // Show if recordset not empty ?>
      <br>
        
      <div align="right"><a href="logout.php" target="_top">登出</a></div></td>
  </tr>
</table></DIV>
</body>
</html>
<?php
mysql_free_result($review);

mysql_free_result($paper);
?>

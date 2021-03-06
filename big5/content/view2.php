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

$MM_restrictGoTo = "login.php";
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
$colname_view = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_view = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conn, $conn);
$query_view = sprintf("SELECT paper_serial, topic, file_paper, file_abstract FROM upload WHERE member = '%s'", $colname_view);
$view = mysql_query($query_view, $conn) or die(mysql_error());
$row_view = mysql_fetch_assoc($view);
$totalRows_view = mysql_num_rows($view);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>檢視上傳之論文</title>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/style.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../menuItems.js"></SCRIPT>
<LINK REL="stylesheet" HREF="../../style/style.css" TYPE="text/css">
<body onLoad="cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice')">
<DIV id="myMenuID"></DIV>
<br><DIV class="scoll">
<table width=100% border=0 cellspacing=10>
          <th class="topic">檢視論文審稿結果</th>
  <tr>
	<td class="content"><br>
	  <?php if ($totalRows_view == 0) { // Show if recordset empty ?>
      <?php echo $_SESSION['MM_Username']; ?>您好，您並未有任何投稿論文。
      <?php } // Show if recordset empty ?>
      <?php if ($totalRows_view > 0) { // Show if recordset not empty ?>
      <?php echo $_SESSION['MM_Username']; ?>您好，以下為您投稿之論文：
      <table width="100%"  border="1" cellspacing="0" cellpadding="2">
          <tr class="color">
            <td width="10%"><div align="center">論文編號</div></td>
            <td><div align="center">論文標題</div></td>
            <td width="10%"><div align="center">審稿者1</div></td>
            <td width="10%"><div align="center">審稿者2</div></td>
          </tr>
          <?php do { 
						$query_review = sprintf("SELECT * FROM paper_distribute WHERE paper = %d", $row_view['paper_serial']);
						$review = mysql_query($query_review, $conn) or die(mysql_error());
						$row_review = mysql_fetch_assoc($review);
		  ?>
          <tr class="content">
            <td><div align="center"><?php echo $row_view['paper_serial']; ?></div></td>
            <td><?php echo $row_view['Topic']; ?></td>
            <td><?php
				if(!strcmp($row_review['referee1'],''))
					echo '無';
				elseif(!strcmp($row_review['finish1'],'n'))
					echo '未完成';
				else
					echo '<a href="review2.php?serial='.$row_review['referee1'].$row_view['paper_serial'].'" target="_blank">瀏覽</a>';
			?></td>
            <td><?php
				if(!strcmp($row_review['referee2'],''))
					echo '無';
				elseif(!strcmp($row_review['finish2'],'n'))
					echo '未完成';
				else
					echo '<a href="review2.php?serial='.$row_review['referee2'].$row_view['paper_serial'].'" target="_blank">瀏覽</a>';
			?></td>
          </tr>
          <?php } while ($row_view = mysql_fetch_assoc($view)); ?>
      </table>
      <?php } // Show if recordset not empty ?><br>
        
      <div align="right"><a href="logout.php" target="_top">登出</a></div></td>
  </tr>
</table></DIV>
</body>
</html>
<?php
//mysql_free_result($view);
?>

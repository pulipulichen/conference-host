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
$serial=$_SESSION['MM_Username'].$_POST['paper'];
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "review" || $_POST["MM_insert"] == "reviewupdate")) {
if($_POST["MM_insert"] == "review")
{
  $insertSQL = sprintf("INSERT INTO review (serial, item1, item2, item3, item4, item5, item6, item7, item8, item9, toauthor, tohoster) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
  					   GetSQLValueString($serial,"text"),
                       GetSQLValueString($_POST['item1'], "int"),
                       GetSQLValueString($_POST['item2'], "int"),
                       GetSQLValueString($_POST['item3'], "int"),
                       GetSQLValueString($_POST['item4'], "int"),
                       GetSQLValueString($_POST['item5'], "int"),
                       GetSQLValueString($_POST['item6'], "int"),
                       GetSQLValueString($_POST['item7'], "int"),
                       GetSQLValueString($_POST['item8'], "int"),
                       GetSQLValueString($_POST['item9'], "int"),
                       GetSQLValueString($_POST['toauthor'], "text"),
                       GetSQLValueString($_POST['tohoster'], "text"));
}else
{
  $insertSQL = sprintf("UPDATE review SET item1=%s, item2=%s, item3=%s, item4=%s, item5=%s, item6=%s, item7=%s, item8=%s, item9=%s, toauthor=%s, tohoster=%s WHERE serial=%s",
                       GetSQLValueString($_POST['item1'], "int"),
                       GetSQLValueString($_POST['item2'], "int"),
                       GetSQLValueString($_POST['item3'], "int"),
                       GetSQLValueString($_POST['item4'], "int"),
                       GetSQLValueString($_POST['item5'], "int"),
                       GetSQLValueString($_POST['item6'], "int"),
                       GetSQLValueString($_POST['item7'], "int"),
                       GetSQLValueString($_POST['item8'], "int"),
                       GetSQLValueString($_POST['item9'], "int"),
                       GetSQLValueString($_POST['toauthor'], "text"),
                       GetSQLValueString($_POST['tohoster'], "text"),
					   GetSQLValueString($serial,"text"));
}

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
if((!isset($_POST['save'])) || ($_POST['save']!='y'))
{
  $query_distribute = sprintf("SELECT referee1, referee2, referee3 FROM paper_distribute WHERE paper = %d", $_POST['paper']);
  $distribute = mysql_query($query_distribute, $conn) or die(mysql_error());
  $row_distribute = mysql_fetch_assoc($distribute);
  $totalRows_distribute = mysql_num_rows($distribute);
  if(!strcmp($row_distribute['referee1'],$_SESSION['MM_Username']))$update=sprintf("UPDATE paper_distribute SET finish1='y' WHERE paper=%d",$_POST['paper']);
  if(!strcmp($row_distribute['referee2'],$_SESSION['MM_Username']))$update=sprintf("UPDATE paper_distribute SET finish2='y' WHERE paper=%d",$_POST['paper']);
  if(!strcmp($row_distribute['referee3'],$_SESSION['MM_Username']))$update=sprintf("UPDATE paper_distribute SET finish3='y' WHERE paper=%d",$_POST['paper']);
  $Result2=mysql_query($update,$conn) or die(mysql_error());
} 
  $insertGoTo = "reviewlist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
mysql_select_db($database_conn, $conn);
$query_review = sprintf("SELECT * FROM review WHERE serial = '%s'",$serial);
$review = mysql_query($query_review, $conn) or die(mysql_error());
$row_review = mysql_fetch_assoc($review);
$totalRows_review = mysql_num_rows($review);
if ($totalRows_review > 0)
  $update = true;
// if (!strcmp($_POST['location'], 'local'))
  $local = true;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php if(isset($local))echo '論文審稿';else echo 'Paper Review'; ?></title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.format {
	border: 2px inset;
	width: 236px;
	height: 22px;
	background-color: #FFFFFF;
	font-size: 13px;
	padding: 1px;
}
-->
</style>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/style.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../menuItems.js"></SCRIPT>
<script language="javascript">
function confirm_(string)
{
	if(document.review.save.status){
		return true;
	}
	else{
		return confirm(string);
	}
}
</script>
<LINK REL="stylesheet" HREF="../../style/style2.css" TYPE="text/css">
<body onLoad="cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice')">
<DIV id="myMenuID"></DIV>
<br><DIV class="scol1"  style="HEIGHT:438px;overflow:auto;">
<table width=100% border=0 cellspacing=10>
        <th class="topic"><?php if(isset($local))echo '論文評審意見';else echo 'Review Form'; ?></th>
  <tr>
	<td class="content"><?php if(isset($local))echo '論文標題';else echo 'Paper title'; ?>: <?php echo $_POST['topic'].'<br>'; ?>
	      <?php if(isset($local))echo '論文編號';else echo 'Paper number'; ?>: <?php echo $_POST['paper'].'<br>'; ?>
          <br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="review" id="review" onSubmit="return confirm_('<?php if(isset($local))echo '確定是否送出審查表單?';else echo 'Do you really want to submit the review form?'; ?>');">
        <table width="100%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#666666">
            <tr>
              <td class="content"><?php if(isset($local))echo '項目';else echo '&nbsp;'; ?></td>
              <td width="12%" class="content"><?php if(isset($local))echo '極佳';else echo 'Excellent'; ?> (5) </td>
              <td width="12%" class="content"><?php if(isset($local))echo '優';else echo 'Good'; ?> (4) </td>
              <td width="12%" class="content"><?php if(isset($local))echo '普通';else echo 'Fair'; ?> (3) </td>
              <td width="12%" class="content"><?php if(isset($local))echo '差';else echo 'Poor'; ?> (2) </td>
              <td width="12%" class="content"><?php if(isset($local))echo '極差';else echo 'Very Poor'; ?> (1) </td>
            </tr>
            <tr>
              <td class="content"> <?php if(isset($local))echo '主題相關性';else echo 'Relevance to conference'; ?> </td>
              <td><input name="item1" type="radio" value="5"<?php if((isset($update)) && ($update==true) && ($row_review['item1']==5))echo ' checked'; ?>></td>
              <td><input name="item1" type="radio" value="4"<?php if((isset($update)) && ($update==true) && ($row_review['item1']==4))echo ' checked'; ?>></td>
              <td><input name="item1" type="radio" value="3"<?php if((isset($update)) && ($update==true) && ($row_review['item1']==3))echo ' checked'; ?>></td>
              <td><input name="item1" type="radio" value="2"<?php if((isset($update)) && ($update==true) && ($row_review['item1']==2))echo ' checked'; ?>></td>
              <td><input name="item1" type="radio" value="1"<?php if((isset($update)) && ($update==true) && ($row_review['item1']==1))echo ' checked'; ?>></td>
            </tr>
            <tr>
              <td class="content"> <?php if(isset($local))echo '論文原創性';else echo 'Originality of concepts'; ?> </td>
              <td><input name="item2" type="radio" value="5"<?php if((isset($update)) && ($update==true) && ($row_review['item2']==5))echo ' checked'; ?>></td>
              <td><input name="item2" type="radio" value="4"<?php if((isset($update)) && ($update==true) && ($row_review['item2']==4))echo ' checked'; ?>></td>
              <td><input name="item2" type="radio" value="3"<?php if((isset($update)) && ($update==true) && ($row_review['item2']==3))echo ' checked'; ?>></td>
              <td><input name="item2" type="radio" value="2"<?php if((isset($update)) && ($update==true) && ($row_review['item2']==2))echo ' checked'; ?>></td>
              <td><input name="item2" type="radio" value="1"<?php if((isset($update)) && ($update==true) && ($row_review['item2']==1))echo ' checked'; ?>></td>
            </tr>
            <tr>
              <td class="content"> <?php if(isset($local))echo '論文嚴謹度';else echo 'Technical soundness'; ?> </td>
              <td><input name="item3" type="radio" value="5"<?php if((isset($update)) && ($update==true) && ($row_review['item3']==5))echo ' checked'; ?>></td>
              <td><input name="item3" type="radio" value="4"<?php if((isset($update)) && ($update==true) && ($row_review['item3']==4))echo ' checked'; ?>></td>
              <td><input name="item3" type="radio" value="3"<?php if((isset($update)) && ($update==true) && ($row_review['item3']==3))echo ' checked'; ?>></td>
              <td><input name="item3" type="radio" value="2"<?php if((isset($update)) && ($update==true) && ($row_review['item3']==2))echo ' checked'; ?>></td>
              <td><input name="item3" type="radio" value="1"<?php if((isset($update)) && ($update==true) && ($row_review['item3']==1))echo ' checked'; ?>></td>
            </tr>
            <tr>
              <td class="content"> <?php if(isset($local))echo '成果重要性';else echo 'Importance of results'; ?> </td>
              <td><input name="item4" type="radio" value="5"<?php if((isset($update)) && ($update==true) && ($row_review['item4']==5))echo ' checked'; ?>></td>
              <td><input name="item4" type="radio" value="4"<?php if((isset($update)) && ($update==true) && ($row_review['item4']==4))echo ' checked'; ?>></td>
              <td><input name="item4" type="radio" value="3"<?php if((isset($update)) && ($update==true) && ($row_review['item4']==3))echo ' checked'; ?>></td>
              <td><input name="item4" type="radio" value="2"<?php if((isset($update)) && ($update==true) && ($row_review['item4']==2))echo ' checked'; ?>></td>
              <td><input name="item4" type="radio" value="1"<?php if((isset($update)) && ($update==true) && ($row_review['item4']==1))echo ' checked'; ?>></td>
            </tr>
            <tr>
              <td class="content"> <?php if(isset($local))echo '論文可讀性';else echo 'Clarity of presentation'; ?> </td>
              <td><input name="item5" type="radio" value="5"<?php if((isset($update)) && ($update==true) && ($row_review['item5']==5))echo ' checked'; ?>></td>
              <td><input name="item5" type="radio" value="4"<?php if((isset($update)) && ($update==true) && ($row_review['item5']==4))echo ' checked'; ?>></td>
              <td><input name="item5" type="radio" value="3"<?php if((isset($update)) && ($update==true) && ($row_review['item5']==3))echo ' checked'; ?>></td>
              <td><input name="item5" type="radio" value="2"<?php if((isset($update)) && ($update==true) && ($row_review['item5']==2))echo ' checked'; ?>></td>
              <td><input name="item5" type="radio" value="1"<?php if((isset($update)) && ($update==true) && ($row_review['item5']==1))echo ' checked'; ?>></td>
            </tr>
            <tr>
              <td class="content"> <?php if(isset($local))echo '資料完整性';else echo 'References completeness'; ?> </td>
              <td><input name="item6" type="radio" value="5"<?php if((isset($update)) && ($update==true) && ($row_review['item6']==5))echo ' checked'; ?>></td>
              <td><input name="item6" type="radio" value="4"<?php if((isset($update)) && ($update==true) && ($row_review['item6']==4))echo ' checked'; ?>></td>
              <td><input name="item6" type="radio" value="3"<?php if((isset($update)) && ($update==true) && ($row_review['item6']==3))echo ' checked'; ?>></td>
              <td><input name="item6" type="radio" value="2"<?php if((isset($update)) && ($update==true) && ($row_review['item6']==2))echo ' checked'; ?>></td>
              <td><input name="item6" type="radio" value="1"<?php if((isset($update)) && ($update==true) && ($row_review['item6']==1))echo ' checked'; ?>></td>
            </tr>
          </table>
	      <br>
	      
	      <table width="100%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#666666">
            <tr>
              <td width="47%" class="content"> <?php if(isset($local))echo '整體評價';else echo 'Overall recommendation'; ?> </td>
              <td width="25%" class="content"><label for="item7"></label><input name="item7" type="radio" value="4"<?php if((isset($update)) && ($update==true) && ($row_review['item7']==4))echo ' checked'; ?>>
              <?php if(isset($local))echo '強烈建議接受';else echo 'Strong accept'; ?> (4)</label></td>
              <td width="25%" class="content"><label for="item7"><input name="item7" type="radio" value="3"<?php if((isset($update)) && ($update==true) && ($row_review['item7']==3))echo ' checked'; ?>>
              <?php if(isset($local))echo '建議接受';else echo 'Accept'; ?> (3)</label></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="content"><label for="item7"><input name="item7" type="radio" value="2"<?php if((isset($update)) && ($update==true) && ($row_review['item7']==2))echo ' checked'; ?>>
              <?php if(isset($local))echo '需要時可考慮接受';else echo 'Neutral'; ?> (2)</label></td>
              <td class="content"><label for="item7"><input name="item7" type="radio" value="1"<?php if((isset($update)) && ($update==true) && ($row_review['item7']==1))echo ' checked'; ?>>
              <?php if(isset($local))echo '不接受';else echo 'Reject'; ?> (1)</label></td>
            </tr>
          </table>
	      <br>
	      
	     
          </table>
<?php if(isset($local)){ ?>
<input type="hidden" name="item9" value="0">
<?php }else{ ?>
	      <br>
          <table width="100%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#666666">
            <tr class="content">
              <td>Collected in special journal issue </td>
              <td width="20%"><input name="item9" type="radio" value="3"<?php if((isset($update)) && ($update==true) && ($row_review['item9']==3))echo ' checked'; ?>>
              Strong recommend(3)</td>
              <td width="20%"><input name="item9" type="radio" value="2"<?php if((isset($update)) && ($update==true) && ($row_review['item9']==2))echo ' checked'; ?>>
              Recommend(2)</td>
              <td width="20%"><input name="item9" type="radio" value="1"<?php if((isset($update)) && ($update==true) && ($row_review['item9']==1))echo ' checked'; ?>>
              Not recommend(1)</td>
            </tr>
          </table>
<?php } ?>
          <br>
          <?php if(isset($local))echo '對論文作者之建議(提供給論文作者)';else echo 'Comments to the Author of the Paper'; ?>:
<br>
<textarea name="toauthor" cols="77" rows="10" id="toauthor"><?php if((isset($update)) && ($update==true) && ($row_review['toauthor']!=''))echo $row_review['toauthor']; ?></textarea>
<br>
<?php if(isset($local))echo '對評審委員之建議(不提供給論文作者)';else echo 'Comments to the PC Chair (if applicable). These will not be communicated to the Author.'; ?>:          <br>
<textarea name="tohoster" cols="77" rows="10" id="tohoster"><?php if((isset($update)) && ($update==true) && ($row_review['tohoster']!=''))echo $row_review['tohoster']; ?></textarea>
<br><div align="center"><?php if(isset($local))echo '若你欲暫存此審查表單，請核取暫存選項<br><font color=#FF0000>注意:一但送出表單(非暫存)，審查結果即無法變更!</font><br>';else echo 'If you wnat to temporarily save the review form, please check the "temporarily save" item.<br><font color=#FF0000>Note:Once you submit the review form, it cannot be changed!</font><br>'; ?>
  <input name="paper" type="hidden" value="<?php echo $_POST['paper']; ?>">
<input type="submit" name="Submit" value="<?php if(isset($local))echo '送出';else echo 'Submit'; ?>">
<input type="checkbox" name="save" id="save" value="y">
<?php if(isset($local))echo '暫存評審意見';else echo 'Temporarily save (not yet complete)'; ?></div>
<input type="hidden" name="MM_insert" value="review<?php if((isset($update)) && ($update==true))echo 'update'; ?>">
</form>
<br>
	  <div align="right"><a href="logout.php" target="_top"><?php if(isset($local))echo '登出';else echo 'Logout'; ?></a></div></td>
  </tr>
</table>
</DIV></DIV>
</body>
</html>
<?php
mysql_free_result($review);
if ((!isset($_POST['save'])) || ($_POST['save']!='y'))
  @mysql_free_result($distribute);
?>
<?php require_once('../Connections/conn.php'); ?>
<?php
mysql_select_db($database_conn, $conn);
$query_paper = "SELECT * FROM upload";
$paper = mysql_query($query_paper, $conn) or die(mysql_error());
$row_paper = mysql_fetch_assoc($paper);
$totalRows_paper = mysql_num_rows($paper);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
</head>

<body>
<table width="100%"  border="1" cellspacing="0" cellpadding="2">
  <tr>
    <td width="32">編號</td>
    <td>標題</td>
    <td>作者</td>
    <td width="32">Oral/Poster</td>
    <td width="32">組別</td>
    <td width="64">類別</td>
    <td width="48">論文檔</td>
    <td width="48">摘要檔</td>
    <td width="32">修改</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><div align="center"><?php echo $row_paper['Paper_serial']; ?></div></td>
    <td><?php echo $row_paper['Topic']; ?></td>
    <td><?php echo $row_paper['Author1'].'-'.$row_paper['Author1_email']; ?>
      <?php echo strcmp($row_paper['Author2'],'')?'<br>'.$row_paper['Author2'].'-'.$row_paper['Author2_email']:''; ?>
      <?php echo strcmp($row_paper['Author3'],'')?'<br>'.$row_paper['Author3'].'-'.$row_paper['Author3_email']:''; ?>
      <?php echo strcmp($row_paper['Author4'],'')?'<br>'.$row_paper['Author4'].'-'.$row_paper['Author4_email']:''; ?>
      <?php echo strcmp($row_paper['Author5'],'')?'<br>'.$row_paper['Author5'].'-'.$row_paper['Author5_email']:''; ?></td>
    <td><?php if($row_paper['receive'] == 'a') echo "Oral"; else echo "Poster";?></td>
    <td><?php echo !strcmp($row_paper['Group'],'oral')?'口頭發表組':'網路發表組'; ?></td>
    <td><?php echo $row_paper['Class']; ?></td>
    <td><div align="center"><?php if(!strcmp($row_paper['camready'],'y')) echo '<a href="../upload/'.$row_paper['Member'].'/csclcspl_paper_'.$row_paper['Paper_serial'].'.doc" target="_blank"><img src="../images/menu/pdf.gif" border="0"></a>'; ?>
    </div></td>
    <td><div align="center"><?php if(!strcmp($row_paper['camready'],'y')) echo '<a href="../upload/'.$row_paper['Member'].'/csclcspl_abstract_'.$row_paper['Paper_serial'].'.doc" target="_blank"><img src="../images/menu/pdf.gif" border="0"></a>'; ?>
    </div></td>
    <td><form action="acceptedmodify.php" method="post" name="modify" target="_self" id="modify">
      <input type="hidden" name="Paper_serial" value="<?php echo $row_paper['Paper_serial']; ?>">
        
      <div align="center"><input name="imageField" type="image" src="../images/menu/modify.gif" width="16" height="16" border="0"></div>
    </form></td>
  </tr>
  <?php } while ($row_paper = mysql_fetch_assoc($paper)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($paper);
?>
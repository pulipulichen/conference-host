<?php require_once('../Connections/conn.php'); ?>
<?php
$colname_review = "1";
if (isset($_GET['serial'])) {
  $colname_review = (get_magic_quotes_gpc()) ? $_GET['serial'] : addslashes($_GET['serial']);
}
mysql_select_db($database_conn, $conn);
$query_review = sprintf("SELECT * FROM review WHERE serial = '%s'", $colname_review);
$review = mysql_query($query_review, $conn) or die(mysql_error());
$row_review = mysql_fetch_assoc($review);
$totalRows_review = mysql_num_rows($review);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title></head>

<body><div align="center">
<form>
  <table width="560"  border="1" cellpadding="2" cellspacing="0" bordercolor="#666666">
    <tr>
      <td class="content">項目</td>
      <td width="12%" class="content">極佳(5) </td>
      <td width="12%" class="content">優(4) </td>
      <td width="12%" class="content">普通(3) </td>
      <td width="12%" class="content">差(2) </td>
      <td width="12%" class="content">極差(1) </td>
    </tr>
    <tr>
      <td class="content">主題相關性</td>
      <td><input name="item1" type="radio" value="5"<?php if($row_review['item1']==5)echo ' checked'; ?>></td>
      <td><input name="item1" type="radio" value="4"<?php if($row_review['item1']==4)echo ' checked'; ?>></td>
      <td><input name="item1" type="radio" value="3"<?php if($row_review['item1']==3)echo ' checked'; ?>></td>
      <td><input name="item1" type="radio" value="2"<?php if($row_review['item1']==2)echo ' checked'; ?>></td>
      <td><input name="item1" type="radio" value="1"<?php if($row_review['item1']==1)echo ' checked'; ?>></td>
    </tr>
    <tr>
      <td class="content">論文原創性</td>
      <td><input name="item2" type="radio" value="5"<?php if($row_review['item2']==5)echo ' checked'; ?>></td>
      <td><input name="item2" type="radio" value="4"<?php if($row_review['item2']==4)echo ' checked'; ?>></td>
      <td><input name="item2" type="radio" value="3"<?php if($row_review['item2']==3)echo ' checked'; ?>></td>
      <td><input name="item2" type="radio" value="2"<?php if($row_review['item2']==2)echo ' checked'; ?>></td>
      <td><input name="item2" type="radio" value="1"<?php if($row_review['item2']==1)echo ' checked'; ?>></td>
    </tr>
    <tr>
      <td class="content">論文嚴謹度</td>
      <td><input name="item3" type="radio" value="5"<?php if($row_review['item3']==5)echo ' checked'; ?>></td>
      <td><input name="item3" type="radio" value="4"<?php if($row_review['item3']==4)echo ' checked'; ?>></td>
      <td><input name="item3" type="radio" value="3"<?php if($row_review['item3']==3)echo ' checked'; ?>></td>
      <td><input name="item3" type="radio" value="2"<?php if($row_review['item3']==2)echo ' checked'; ?>></td>
      <td><input name="item3" type="radio" value="1"<?php if($row_review['item3']==1)echo ' checked'; ?>></td>
    </tr>
    <tr>
      <td class="content">成果重要性</td>
      <td><input name="item4" type="radio" value="5"<?php if($row_review['item4']==5)echo ' checked'; ?>></td>
      <td><input name="item4" type="radio" value="4"<?php if($row_review['item4']==4)echo ' checked'; ?>></td>
      <td><input name="item4" type="radio" value="3"<?php if($row_review['item4']==3)echo ' checked'; ?>></td>
      <td><input name="item4" type="radio" value="2"<?php if($row_review['item4']==2)echo ' checked'; ?>></td>
      <td><input name="item4" type="radio" value="1"<?php if($row_review['item4']==1)echo ' checked'; ?>></td>
    </tr>
    <tr>
      <td class="content">論文可讀性</td>
      <td><input name="item5" type="radio" value="5"<?php if($row_review['item5']==5)echo ' checked'; ?>></td>
      <td><input name="item5" type="radio" value="4"<?php if($row_review['item5']==4)echo ' checked'; ?>></td>
      <td><input name="item5" type="radio" value="3"<?php if($row_review['item5']==3)echo ' checked'; ?>></td>
      <td><input name="item5" type="radio" value="2"<?php if($row_review['item5']==2)echo ' checked'; ?>></td>
      <td><input name="item5" type="radio" value="1"<?php if($row_review['item5']==1)echo ' checked'; ?>></td>
    </tr>
    <tr>
      <td class="content">資料完整性</td>
      <td><input name="item6" type="radio" value="5"<?php if($row_review['item6']==5)echo ' checked'; ?>></td>
      <td><input name="item6" type="radio" value="4"<?php if($row_review['item6']==4)echo ' checked'; ?>></td>
      <td><input name="item6" type="radio" value="3"<?php if($row_review['item6']==3)echo ' checked'; ?>></td>
      <td><input name="item6" type="radio" value="2"<?php if($row_review['item6']==2)echo ' checked'; ?>></td>
      <td><input name="item6" type="radio" value="1"<?php if($row_review['item6']==1)echo ' checked'; ?>></td>
    </tr>
  </table>
  <br>
  <table width="560"  border="1" cellpadding="2" cellspacing="0" bordercolor="#666666">
    <tr>
      <td width="47%" class="content">整體評價</td>
      <td width="25%" class="content"><label for="item7"></label>
          <input name="item7" type="radio" value="4"<?php if($row_review['item7']==4)echo ' checked'; ?>>
          強烈建議接受(4)</td>
      <td width="25%" class="content"><label for="item7">
        <input name="item7" type="radio" value="3"<?php if($row_review['item7']==3)echo ' checked'; ?>>
        建議接受(3)</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="content"><label for="item7">
        <input name="item7" type="radio" value="2"<?php if($row_review['item7']==2)echo ' checked'; ?>>
        需要時可考慮接受(2)</label></td>
      <td class="content"><label for="item7">
        <input name="item7" type="radio" value="1"<?php if($row_review['item7']==1)echo ' checked'; ?>>
        不接受(1)</label></td>
    </tr>
  </table>
  <br>
  

  <br>
    對論文作者之建議(提供給論文作者): <br>
    <textarea name="toauthor" cols="77" rows="10" id="toauthor"><?php if($row_review['toauthor']!='')echo $row_review['toauthor']; ?>
  </textarea>
    <br>
    <br>
    對評審委員之建議(不提供給論文作者): <br>
    <textarea name="tohoster" cols="77" rows="10" id="tohoster"><?php if($row_review['tohoster']!='')echo $row_review['tohoster']; ?>
  </textarea>
    <br> 
      <a href="javascript: window.close()">關閉視窗</a>  
</form>	</div>
</body>
</html>
<?php
mysql_free_result($review);
?>

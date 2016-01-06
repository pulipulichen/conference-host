<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>2006年台灣教育學術研討會</title>
<table>
  <tr>
    <td align="center" bgcolor="#B39EC7" width="10%"><font color="#FFFFFF">編號</font></td>
    <td align="center" bgcolor="#B39EC7" width="15%"><font color="#FFFFFF">帳號</font></td>
    <td align="center" bgcolor="#B39EC7" width="40%"><font color="#FFFFFF">論文題目</font></td>
    <td align="center" bgcolor="#B39EC7" width="20%"><font color="#FFFFFF">類文類別</font></td>
    <td align="center" bgcolor="#B39EC7" width="15%"><font color="#FFFFFF">組別</font></td>
  </tr>
<?php
//require_once('../Connections/MySQL.php');
require_once('../Connections/conn.php');
//mysql_query('SET NAMES big5');
//mysql_query('SET CHARACTER_SET_CLIENT=big5');
//mysql_query('SET CHARACTER_SET_RESULTS=big5');
$Rlt = $db->query("SELECT `Paper_serial`, `Member`, `Topic`, `Class`, `Group` FROM `upload`");
while ($row = mysql_fetch_assoc($Rlt)) {
    if ((++$i) % 2 != 0)						
        $bgColor = '#ffffcc';
    else
        $bgColor = '#ccffcc';

    if ($row[Group] == 'network')
        $Group = '網路發表組';
    else
        $Group = '口頭發表組';

    echo "<tr align=center bgcolor=$bgColor><td>$row[Paper_serial]</td><td>$row[Member]</td><td>$row[Topic]</td><td>$row[Class]</td><td>$Group</td></tr>";
}
?>
</table>
<?="<center>aa</center>";?>
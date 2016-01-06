<table>
<?php
require_once('../Connections/MySQL.php');
$Rlt = $db->query("SELECT `ID`, `password`, `name` FROM `referee`");
while ($row = mysql_fetch_assoc($Rlt))
    echo "<tr><td>$row[ID]</td><td>$row[password]</td><td>$row[name]</td></tr>\n";
?>
</table>
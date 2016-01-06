<?php
// *** Logout the current user.
$logoutGoTo = "../index.htm";
session_start();
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
session_unregister('MM_Username');
session_unregister('MM_UserGroup');

exit;
}
?>

<?php

session_start();
if (session_is_registered('MM_Username')) {
    header("Location: $_SESSION[MM_Username]/");				// 鎖定使用者原目錄
}
else {
    header("Location: ../");						// 非法登入轉回首頁
}
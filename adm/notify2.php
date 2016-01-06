<?php require_once('../Connections/conn.php'); ?>
<?php
header ('Content-Type: text/html; charset=utf-8');
$colname_paper = "1";
if (isset($_POST['Paper_serial'])) {
  $colname_paper = (get_magic_quotes_gpc()) ? $_POST['Paper_serial'] : addslashes($_POST['Paper_serial']);
}
mysql_select_db($database_conn, $conn);
$query_paper = sprintf("SELECT * FROM upload WHERE paper_serial = %s", $colname_paper);
$paper = mysql_query($query_paper, $conn) or die(mysql_error());
$row_paper = mysql_fetch_assoc($paper);
$totalRows_paper = mysql_num_rows($paper);

$query_name = sprintf("SELECT name FROM member WHERE id = '%s'",$row_paper['member']);
$name = mysql_query($query_name, $conn) or die(mysql_error());
$row_name = mysql_fetch_assoc($name);
$totalRows_name = mysql_num_rows($name);
if (!strcmp($_POST['receive'], 'a')) {
  // if (!strcmp($row_paper['group'],'local'))
    $msg = stripcslashes($row_name['name']) 
            . " 先進您好:\n\n　　感謝您投稿「2013第二屆數位合作學習與個人化學習研討會」。很高興您的論文\n\n論文編號：" 
            . $_POST['paper_serial'] 
            . "\n論文名稱：" 
            . stripcslashes(iconv("Big-5","UTF-8",$row_paper['topic'])) 
            . "\n\n     經專家評審結果您的論文已獲接受為口頭報告論文。本次會議共收到47篇論文，您可至大會網頁\"線上投稿/論文審稿結果\"檢視您的論文審查意見，所需之帳號及密碼同您投稿時所登記之資料。\n\n 　請您依照審查委員的意見修改論文，並將論文完稿檔(若為國科會計畫成果，請務必於致謝中標示計畫編號；格式請務必依照大會之規定\"論文徵稿/論文格式\")於1月31日前上傳(以Microsoft WORD 97-2003檔案格式)至大會網頁\"線上投稿/論文完稿上傳\"，並完成論文之註冊(請注意：每篇被接受論文(包含口頭報告與海報展示)，均至少須有一人註冊，註冊方式請參考網頁\"報名資訊\")，並將註冊資料於2月8日前上傳至報名系統，逾時恕難將您的論文收錄於大會論文集中，感謝您的配合。若您有任何困難請不吝與我們連絡，我們會盡快幫您處理。\n\n有關大會詳細的註冊流程、議程、交通、旅遊與住宿等資訊，將陸續公告於大會網站http://csclcspl2013.dlll.nccu.edu.tw，敬請多加查詢利用。期待您的蒞臨指教! \n\n敬頌\n\n研安\n\n大會指導委員：\n陳德懷/國立中央大學網路學習科技研究所\n陳斐卿/國立中央大學學習與教學研究所\n薛理桂/國立政治大學圖書資訊與檔案學研究所\nCSCL執行議程主席：洪煌堯/政治大學教育學系\nCSCL議程主席：林秋斌/新竹教育大學數位學習科技研究所\nCSPL執行議程主席：陳志銘/政治大學圖書資訊與檔案學研究所\nCSPL議程主席：周志岳/元智大學資訊工程學系\n\n敬上\n\n聯絡人：\n宋立偉 \n電話：02-29393091 Ext.62955\nE-mail：csclcspl2013@gmail.com\n";
  // else
  //   $msg='Dear '.$row_name['name'].":\n\n　　Thank you for your submissions to TAAI2005. On behalf of the Program Committee, we are pleased to inform you that your paper\n\nPaper NO.:".$_POST['Paper_serial']."\nPaper title:".$row_paper['topic']."\n\nhas been accepted for presentation at the 10th Conference on Artificial Intelligence and Applications, to be held on December 2-3, Kaohsiung, Taiwan.\n\n　　This year, the TAAI2005 received a total of 304 submissions and about 200 papers were accepted for presentation, representing an acceptance rate around 66%. You can check the reviewers’ comments through the conference website \"Paper Submission/Review report\", using the same account and password for submission registration.\n\n　　Please follow the formatting instruction under the \"Call for papers/abstract format and paper format\" on our website and do take the reviewers’ comments into account to prepare the final camera-ready copy of your paper, and submit both of the abstract and full versions (in PDF format and do provide the NSC research grant code if the work of your paper is supported by the National Science Council, Taiwan) via the \"Paper submission/camera-ready upload\" before October 23, 2005 in order to ensure the inclusion of your paper in the Conference Proceedings.\n\n　　Also, TAAI2005 requires that for each accepted paper, the copyright form (http://ntec.pels.nhlue.edu.tw/dlfiles/coptright.doc) should be signed and faxed along with the registration form, and at least one author should register as non-student prior to October 23, 2005, for the paper to be included in the proceedings. The copyright form and registration information are available under the \"Call for paper\" on the conference website.\n\n　　Please refer to our website for further information regarding the detailed program, traveling, and hotel accommodation, which will be available soon. We are looking forward to welcome you in Kaohsiung this December.\n\nSincerely yours,\n\nWen-Yang Lin and Jin-Tan David Yang\nTAAI2005 Program Co-Chairs";
}
else {
  // if (!strcmp($row_paper['group'],'local'))
    $msg = stripcslashes($row_name['name']) 
            . " 先進您好:\n\n　　感謝您投稿「2013第二屆數位合作學習與個人化學習研討會」。很高興您的論文\n\n論文編號：" 
            . $_POST['Paper_serial'] 
            . "\n論文名稱：" 
            . stripcslashes(iconv("Big-5","UTF-8",$row_paper['topic'])) 
            . "\n\n    經專家評審結果您的論文已獲接受為海報展示論文。本次會議共收到47篇論文，您可至大會網頁\"線上投稿/論文審稿結果\"檢視您的論文審查意見，所需之帳號及密碼同您投稿時所登記之資料。\n\n 　請您依照審查委員的意見修改論文，並將論文完稿檔(若為國科會計畫成果，請務必於致謝中標示計畫編號；格式請務必依照大會之規定\"論文徵稿/論文格式\")於1月31日前上傳(以Microsoft WORD 97-2003檔案格式)至大會網頁\"線上投稿/論文完稿上傳\"，並完成論文之註冊(請注意：每篇被接受論文(包含口頭報告與海報展示)，均至少須有一人註冊，註冊方式請參考網頁\"報名資訊\")，並將註冊資料於2月8日前上傳至報名系統，逾時恕難將您的論文收錄於大會論文集中，感謝您的配合。若您有任何困難請不吝與我們連絡，我們會盡快幫您處理。\n\n有關大會詳細的註冊流程、議程、交通、旅遊與住宿等資訊，將陸續公告於大會網站http://csclcspl2013.dlll.nccu.edu.tw，敬請多加查詢利用。期待您的蒞臨指教! \n\n敬頌\n\n研安\n\n大會指導委員：\n陳德懷/國立中央大學網路學習科技研究所\n陳斐卿/國立中央大學學習與教學研究所\n薛理桂/國立政治大學圖書資訊與檔案學研究所\nCSCL執行議程主席：洪煌堯/政治大學教育學系\nCSCL議程主席：林秋斌/新竹教育大學數位學習科技研究所\nCSPL執行議程主席：陳志銘/政治大學圖書資訊與檔案學研究所\nCSPL議程主席：周志岳/元智大學資訊工程學系\n\n敬上\n\n聯絡人：\n宋立偉 \n電話：02-29393091 Ext.62955\nE-mail：csclcspl2013@gmail.com\n";
  // else
  //   $msg = 'Dear '.$row_name['name'].":\n\n　　Thank you for your submission to TAAI2005. On behalf of the Program Committee, we are very sorry to inform you that your paper\n\nPaper NO.:".$_POST['Paper_serial']."\nPaper title:".$row_paper['topic']."\n\nhas been rejected for presentation at the 10th Conference on Artificial Intelligence and Applications, to be held on December 2-3, Kaohsiung, Taiwan.\n\n　　This year, the TAAI2005 received a total of 304 submissions and about 200 papers were accepted for presentation, representing an acceptance rate around 66%. You can check the reviewers’ comments through the conference website \"Paper Submission/Review report\", using the same account and password for submission registration, which you may find useful in improving your manuscript for other submission.\n\n　　Although your paper was not accepted for presentation, we still are looking forward to welcome you and your colleagues at this leading forum in Kaohsiung, Taiwan. Registration information is available under \"Registration\". Please refer to our website for further information regarding the detailed program, traveling, and hotel accommodation, which will be available soon.\n\nSincerely yours,\n\nWen-Yang Lin and Jin-Tan David Yang\nTAAI2005 Program Co-Chairs";
}
// if (!strcmp($row_paper['group'],'local'))
   $subject = "2013第二屆數位合作學習與個人化學習研討會論文審稿結果通知";
   $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
  
// else
//   $subject = 'TAAI2005 Review Notification';

$mailto = $row_paper['email'];
$mailfrom = 'From: csclcspl2013@gmail.com';
if (mail($mailto, $subject, $msg, $mailfrom)) {
?>
<html><head><title>寄送成功</title></head><body>
<div align="center">邀請信件已寄出(to <?php echo $row_name['name']?>)!
<form onSubmit="opener.location.reload();window.close()">
  <input type="submit" name="Submit" value="確認">
</form></div>
</body></html>
<?php
} else {
?>
<html><head><title>寄送失敗</title></head><body>
<div align="center">邀請信件寄送失敗(to <?php echo $row_name['name']?>)!<br>請聯絡管理者</div>
</body></html>
<?php
}

//mysql_free_result($paper);
//mysql_free_result($name);
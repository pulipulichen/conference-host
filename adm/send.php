<?php
header ('Content-Type: text/html; charset=utf-8');
$serial = $_POST['serial'];
$member = $_POST['member'];
$topic=stripcslashes($_POST['topic']);
$group = $_POST['group'];
$mailto = $_POST['email'];
$mailfrom = 'From:csclcspl2013@gmail.com';
// if ($group == 'oral') {
   $content = $member . "您好:\n\n" .
               "您投稿至2013年第二屆數位合作學習與個人化學習研討會(編號".$serial.")：\n" .
               "論文題目：". $topic ."\n" .
               "已順利完成檔案上傳並登錄於資料庫中。若您後續有任何問題，請與我們聯繫(csclcspl2013@gmail.com)。\n\n" .
               "2013第二屆數位合作學習與個人化學習研討會\ncsclcspl2013@gmail.com";
    $subject = "2013年第二屆數位合作學習與個人化學習研討會確認信";
	$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";


// } else {
//     $content = "Dear " . $member . ":\n\nThis is an auto email reply that we have received your submission\n" .
//                "Paper no.: " . $serial . "\nPaper title: " . $topic . "\n" .
//                "to the 10th Conference on Artificial Intelligence and Applications (TAAI2005).\n" .
//                "Should you have any question regarding your submission, please contact us at taai2005@nuk.edu.tw.\n" .
//                "Thank you for your interest in TAAI2005 and look forward to seeing you in Kaohsiung.\n\n" .
//                "The 10th Conference on Artificial Intelligence and Applications (TAAI2005)\ntaai2005.nuk.edu.tw";
//     $subject = "TAAI2005 submission confirmation";
// }
  $arrival = "NO: " . $serial . ", \nPaper Title: " . $topic . ", \nMember: " . $member . ", \nEmail: " . $mailto;
  mail($mailto, $subject, $content, $mailfrom);
  mail('csclcspl2013@gmail.com', 'new submission NO: '. $serial, $arrival, $mailfrom);
  printf("%s, %s, %s, %s, 寄送成功\!!", $serial, $topic, $member, $mailto);
?>
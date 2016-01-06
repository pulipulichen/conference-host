<?php
header ('Content-Type: text/html; charset=utf-8');
$id=$_POST['id'];
if(isset($_POST['list0']))$paper[0]=$_POST['list0'];
if(isset($_POST['list1']))$paper[1]=$_POST['list1'];
if(isset($_POST['list2']))$paper[2]=$_POST['list2'];
if(isset($_POST['list3']))$paper[3]=$_POST['list3'];
if(isset($_POST['list4']))$paper[4]=$_POST['list4'];
if(isset($_POST['list5']))$paper[5]=$_POST['list5'];
require_once('../Connections/conn.php');
mysql_select_db($database_conn, $conn);
$query_notify = sprintf("SELECT name, password, location, email  FROM referee WHERE id='%s'",$id);
$notify = mysql_query($query_notify, $conn) or die(mysql_error());
$row_notify = mysql_fetch_assoc($notify);
$totalRows_notify = mysql_num_rows($notify);

// if (!strcmp($row_notify['location'],'oral')) {
  if ($_POST['again'] == 0) {
    $msg = stripcslashes($row_notify['name'])." 教授 鈞鑑:\n\n"
	   ."欣逢本校 (國立政治大學) 承辦「2013第二屆數位合作學習與個人化學習研討會」 \n"
	   ."(研討會時間：2013年3月29~30日詳細請參考網站 <a href=http://csclcspl2013.dlll.nccu.edu.tw/>http://csclcspl2013.dlll.nccu.edu.tw/</a>)。\n"
	   ."夙聞先生於數位學習相關研究領域成就斐然，望重士林，擬邀請先生擔任本研討會之論文審查委員，並協助審查下列論文:\n\n"
	   ."論文: \n";
  } else {
    $msg = stripcslashes($row_notify['name']) . " 教授 鈞鑑:\n\n"
	   ."感謝您在百忙中協助「2013第二屆數位合作學習與個人化學習研討會」之論文審查工作。在此提醒您審查截止日期為(2013/1/17)，若您還未完成論文的審查工作，懇請您能於近日內完成，謝謝您的配合。您所審查的論文如下：\n\n";
  }

  for ($i = 0; $i < count($paper); $i++) {
    $query_paperq = sprintf("SELECT topic FROM upload WHERE paper_serial=%d",$paper[$i]);
    $paperq = mysql_query($query_paperq, $conn) or die(mysql_error());
    $row_paperq = mysql_fetch_assoc($paperq);
    $query_again = sprintf("SELECT * FROM paper_distribute WHERE paper=%d",$paper[$i]);
    $again = mysql_query($query_again, $conn) or die(mysql_error());
    $row_again = mysql_fetch_assoc($again);



    if ($_POST['again'] == 0) {
      $msg .= sprintf("論文編號: %d\n論文名稱: %s\n\n", $paper[$i],stripcslashes($row_paperq['Topic']));
    } else {
      $query_again = sprintf("SELECT * FROM paper_distribute WHERE paper=%d",$paper[$i]);
      $again = mysql_query($query_again, $conn) or die(mysql_error());
      $row_again = mysql_fetch_assoc($again);
      if ((!strcmp($row_again['referee1'], $id) && !strcmp($row_again['finish1'], 'n'))||(!strcmp($row_again['referee2'], $id) && !strcmp($row_again['finish2'], 'n')) || (!strcmp($row_again['referee3'],$id) && !strcmp($row_again['finish3'], 'n'))) {
        $msg .= sprintf("論文編號: %d\n論文名稱: %s\n\n", $paper[$i],stripcslashes($row_paperq['Topic']));
      }
    }
  }
  if ($_POST['again'] == 0) {
    $msg .= "為利後續籌備工作之順利推展，期盼先生能於2013年1月17日前完成審稿工作。\n";
  }
  $msg .= "您可由下列網址登入大會審稿系統，檢視您審查的論文。\n"
          ."<a href=http://csclcspl2013.dlll.nccu.edu.tw/csclcspl/big5/content/reviewlogin.php>http://csclcspl2013.dlll.nccu.edu.tw/csclcspl/big5/content/reviewlogin.php</a>\n\n"
		  ."，並請使用論文審查系統審閱論文，手冊如下方網址:\n\n"
		  ."<a href=http://csclcspl2013.dlll.nccu.edu.tw/csclcspl/dlfiles/Examine_Guide.pdf>審稿系統使用手冊</a>\n\n"
          ."您的帳號及密碼如下:\n"
          ."帳號: ".$id."\n"
          ."密碼: ".$row_notify['password']."\n\n";
  $msg .= "<font color=red>P.S.\n本系統備有 <b>暫存評審意見</b> 之功能，若您無法在同一時間內完成審閱，請您勾選該欄位再送出，即可暫存供日後繼續評審。\n若在未勾選的狀態下送出，將視為已完成審稿，無法再做任何修改。</font>\n\n";
  
  
  if ($_POST['again'] == 0) {
    $msg .= "您的參與將是本屆研討會順利成功的主要動力。\n";
  }
  $msg .= "敬頌\n\n學安\n\n「2013第二屆數位合作學習與個人化學習研討會」 議程委員會 敬上";
  if ($_POST['again'] == 0) {
    $subject = "2013第二屆數位合作學習與個人化學習研討會論文審稿邀請函";
  } else {
    $subject = "2013第二屆數位合作學習與個人化學習研討會論文審稿提醒函";
  }
// } else {
//   $msg = "Dear Prof. ".$row_notify['name'].",\n\n";
//   if ($_POST['again'] == 0) {
//     $msg .= "This year, the 10th Conference on Artificial Intelligence and Applications (TAAI2005) will be take placed in National University of Kaohsiung, Kaohsiung, Taiwan fromDecember 2-3, 2005.\n\n"
//             ."Since you are an expert in the related fields of Artificial Intelligence, we sincerely invite you being the referee committee and ask for your help to review the following manuscripts:\n\n";
//   } else {
//     $msg .= "Thank you for accepting our invitation to participate as member of the referee committee of TAAI2005 (The Tenth Conference on Artificial Intelligence and Applications). We would like to remind you that the reviewing deadline has passed (2005/9/30). May we ask you to hurry the process within these few days if you have not yet completed your reports? It will help us to meet the tight schedule for paper notification. Your cooperation will be highly appreciated.\n\n"
//             ."The manuscripts assigned for your comments are as follows:\n\n";
//   }
// 
//   for ($i = 0; $i < count($paper); $i++) {
//     $query_paperq = sprintf("SELECT topic FROM upload WHERE paper_serial=%d",$paper[$i]);
//     $paperq = mysql_query($query_paperq, $conn) or die(mysql_error());
//     $row_paperq = mysql_fetch_assoc($paperq);
//     if ($_POST['again'] == 0) {
//       $msg .= sprintf("Paper number: %d\nPaper title: %s\n\n",$paper[$i],$row_paperq['Topic']);
//     } else {
//       $query_again = sprintf("SELECT * FROM paper_distribute WHERE paper=%d", $paper[$i]);
//       $again = mysql_query($query_again, $conn) or die(mysql_error());
//       $row_again = mysql_fetch_assoc($again);
//       if((!strcmp($row_again['referee1'],$id) && !strcmp($row_again['finish1'],'n'))||(!strcmp($row_again['referee2'],$id) && !strcmp($row_again['finish2'],'n'))||(!strcmp($row_again['referee3'],$id) && !strcmp($row_again['finish3'],'n')))
// 	$msg.=sprintf("Paper number: %d\nPaper title: %s\n\n",$paper[$i],$row_paperq['Topic']);
//     }
//   }
//   $msg .= "The manuscripts can be accessed at the following web site:\n\n"
//           ."http://taai2005.nuk.edu.tw/eng/review.htm\n\n"
// 	  ."Your Reviewer Login username is:".$id."\n"
// 	  ."Your password is: ".$row_notify['password']."\n\n";
//   if ($_POST['again'] == 0) {
//     $msg .= "We hope to receive your positive response and if so, please complete the review report before September 30, 2005.\n\n"
// 	    ."Thank you very much.\n";
//   }
//   $msg .= "We stay at your entire disposal for any information you may require.\n"
//           ."Yours sincerely,\n\nWen-Yang Lin\nProgram Co-Chair of TAAI2005\nProfessor & Chairman\nDept. of Computer Science and Information Engineering\n"
//           ."National University of Kaohsiung\nKaohsiung 811, Taiwan, ROC\nTel: +886-7-5919517\nFax: +886-7-5919514\nwylin@nuk.edu.tw";
//   $subject = '2006年台灣教育學術研討會審稿邀約';
// }
$mailto=$row_notify['email'];
$mailfrom = 'MIME-Version: 1.0' . "\r\n";
$mailfrom .= 'Content-type: text/html' . "\r\n";				// 使用 HTML 表頭
$mailfrom .= 'From: csclcspl2013@gmail.com';
$msg = nl2br($msg); 	// 將 \n 做斷行處理

$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";


						
// echo '$mailto = '.$mailto."\n";
// echo '$mailfrom = '.$mailfrom."\n";
// echo '$msg = '.$msg."\n";
if (mail($mailto, $subject, $msg, $mailfrom)) {
?>
<html><head><title>寄送成功</title></head><body>
<div align="center">邀請信件已寄出(to <?php echo $row_notify['name']?>)!
<form onSubmit="opener.location.reload();window.close()">
  <input type="submit" name="Submit" value="確認">
</form></div>
</body></html>
<?php
  $query_alart = sprintf("UPDATE referee SET alart='y' WHERE id='%s'",$id);
  $alart = mysql_query($query_alart, $conn) or die(mysql_error());
} else {
?>
<html><head><title>寄送失敗</title></head><body>
<div align="center">邀請信件寄送失敗(to <?php echo $row_notify['name']?>)!<br>請聯絡管理者</div>
</body></html>
<?php
}
?>
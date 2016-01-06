<?php require_once('../Connections/conn.php');
mysql_select_db($database_conn, $conn);
$query_email = "SELECT `group`, email FROM upload WHERE `receive`='a' AND `camready`='y' LIMIT 183, 20";
$email = mysql_query($query_email, $conn) or die(mysql_error());
$row_email = mysql_fetch_assoc($email);
$totalRows_email = mysql_num_rows($email);
$i=0;
$mailfrom='csclcspl2013@gmail.com';
$subject1='嚙諸訪嚙踝蕭{嚙瞎嚙踝蕭q嚙踝蕭嚙稿嚙踝蕭q嚙踝蕭';
$subject2='A notice for Tours and Bus Schedule';
$content1="嚙磊嚙踝蕭Q嚙踝蕭嚙璀嚙緲嚙緯嚙瘠\n\n嚙瞑嚙蝓您嚙諸加嚙踝蕭嚙踝蕭Q嚙罵嚙璀嚙踝蕭嚙踝蕭Q嚙罵嚙踝蕭嚙瘩嚙踝蕭嚙磊嚙趣有嚙踝蕭嚙踝蕭嚙諸迎蕭嚙褒術嚙踝蕭嚙褓，嚙磅嚙瞌嚙緩嚙複穿蕭u嚙稽嚙諸訪嚙瞎嚙踝蕭嚙誕參訪嚙璀嚙衛且嚙踝蕭嚙諸伐蕭q嚙踝蕭嚙踝蕭嚙踝蕭嚙諸與嚙踝蕭嚙褊迎蕭嚙瞋嚙踝蕭嚙瘠\n\n嚙請參考以嚙磊嚙踝蕭嚙踝蕭s嚙踝蕭嚙瘠\n嚙踝蕭u嚙稽嚙諸訪嚙踝蕭{	http://taai2005.nuk.edu.tw/big5/tour1.htm\n嚙踝蕭嚙誕參訪嚙踝蕭{	http://taai2005.nuk.edu.tw/big5/tour2.htm\n嚙踝蕭q嚙踝蕭嚙稿嚙踝蕭		http://taai2005.nuk.edu.tw/big5/bus.htm\n\n嚙踝蕭嚙踝蕭K嚙篌嚙罵嚙瑾嚙羯嚙璀嚙請您嚙踝蕭b嚙瞑嚙罵嚙箴嚙緩嚙踝蕭嚙緲嚙踝蕭嚙篆嚙踝蕭嚙踝蕭嚙稿嚙踝蕭嚙瞎嚙賤項嚙諸訪嚙踝蕭{嚙踝蕭嚙瞇嚙瑾嚙瘠嚙緩嚙踝蕭嚙質式嚙箠嚙緲嚙盤Email嚙瘦csclcspl2013@gmail.com嚙璀嚙緬嚙豌：07-5919446嚙踝蕭07-5919518嚙璀嚙褒真嚙瘦07-5919514嚙踝蕭嚙璀嚙緩嚙踝蕭嚙褕請告嚙踝蕭嚙緲嚙踝蕭嚙練嚙磕嚙畿嚙踝蕭嚙篆嚙踝蕭嚙稿嚙踝蕭嚙畿嚙踝蕭嚙踝蕭嚙窮嚙瘢嚙畿嚙瘡嚙踝蕭嚙緘嚙踝蕭嚙質式嚙踝蕭嚙瘠嚙踝蕭嚙蝓您嚙踝蕭嚙碼嚙瑾嚙璀嚙踝蕭嚙豎您嚙踝蕭嚙磐嚙緹嚙瘢\n\n
TAAI2005 嚙緩嚙複委嚙踝蕭嚙罵";
$content2="Dear authors and participants:\n\nWelcome to the TAAI 2005 held at National University of Kaohsiung (NUK).\nBelow URL are bus schedule, City tour, and Tour of National Science and Technology Museum. The arrangements are all free by the conference.\n\nBus schedule		http://taai2005.nuk.edu.tw/eng/bus.htm\nTour of NSTM		http://taai2005.nuk.edu.tw/eng/tour1.htm\nCity tour			http://taai2005.nuk.edu.tw/eng/tour2.htm\n\nIn order for us to operate this service more smoothly, please reserve the buses you plan to take and the tour(s) to your interest as early as possible. You can either email to csclcspl2013@gmail.com, phone in at 07-5919446 or 07-5919518, or fax to 07-5919514 to leave your name, route, date/time, boarding location and contact information. Thank you for your cooperation and looking forward to seeing you at TAAI 2005 soon.\n\nTAAI2005 Committee";
do
{
	$mailto=$row_email['email'];
	if(!strcmp($row_email['group'],'local'))
	{
    	mail($mailto,$subject1,$content1,$mailfrom);
	}
	else
	{
    	mail($mailto,$subject2,$content2,$mailfrom);
	}
echo '嚙踝蕭嚙踝蕭'.$i++;
} 
while ($row_email = mysql_fetch_assoc($email));

//mysql_free_result($email);
var basedir = '../../';
var myMenu =
[
	['', '大會資訊', '#', 'mainFrame', '研討會相關資訊',
		['', '大會主旨與目的', 'intro.htm', 'mainFrame', '本次2006年台灣教育學術研討會的主旨與目的'],
		['', '大會組織', '#', 'mainFrame', '籌備大會的團隊',
			['', '籌備暨規劃委員會', 'org.htm', 'mainFrame', '籌備本次大會的委員'],
			['', '論文審查委員會', 'referee.htm', 'mainFrame', '負責稿件審查的委員'],
			['', '最佳論文審查委員會', 'prize.htm', 'mainFrame', '負責最佳論文稿件審查的委員'],
			['<img src='+basedir+'images/menu/pdf.gif>', '校內工作職掌', basedir+'dlfiles/group.pdf', 'file', '籌劃研討會與維護網站的工作團隊']
		],
		['', '最新消息', 'news.htm', 'mainFrame', '關於研討會的最新資訊'],
		['', '重要日期', 'date.htm', 'mainFrame', '研討會各項重要日期公告'],
		['', '指導單位', 'DirectiveSponsors.htm', 'mainFrame', '本次研討會指導單位'],
		['', '協辦單位', 'TechnicalCoSponsors.htm', 'mainFrame', '本次研討會協辦單位'],
		['', '贊助單位', 'CoSponsors.htm', 'mainFrame', '本次研討會贊助單位']
	],
	['', '會議議程', '#', 'mainFrame', '各項議程公佈',
		['', '<font color=dddddd>議程總覽</font>', '#', 'mainFrame', '2006年台灣教育學術研討會議程'],
		['<img src='+basedir+'images/menu/pdf.gif>', '<font color=dddddd>下載議程總覽</font>', '#', 'mainFrame', '下載'],
		['', '<font color=dddddd>論文場次表</font>', '#', 'mainFrame', '論文場次',
		 	['', '口頭發表組', '#', 'mainFrame', '口頭發表組'],
			['', '網路發表組', '#', 'mainFrame', '網路發表組'],
		],
		['', '<font color=dddddd>下載論文場次表</font>', '#', 'mainFrame', '論文場次',
		 	['<img src='+basedir+'images/menu/pdf.gif>', '口頭發表組', '#', 'mainFrame', '口頭發表組'],
			['<img src='+basedir+'images/menu/pdf.gif>', '網路發表組', '#', 'mainFrame', '網路發表組']
		]
	],
	['', '邀請講席', '#', 'mainFrame', '本次大會邀請演講資訊',
	 	['', '<font color=dddddd>講席(一)</font>', '#', 'mainFrame', '邀請講席一'],
	 	['<img src='+basedir+'images/menu/ppt.gif>', '<font color=dddddd>講席(一)講稿</font>', '#', 'mainFrame', '邀請講席一講稿']
	],
	['', '論文徵稿', '#', 'mainFrame', '關於稿件的資訊與注意事項',
	        ['<img src='+basedir+'images/menu/pdf.gif>', '徵文海報', basedir+'dlfiles/advertise.pdf', 'file', '下載徵稿海報'],
		['', '徵稿說明', 'wanted.htm', 'mainFrame', '關於徵稿事項的說明'],
		['', '徵求主題', 'topic.htm', 'mainFrame', '本次研討會所微求的稿件主題'],
		['<img src='+basedir+'images/menu/pdf.gif>', '徵文啟事', basedir+'dlfiles/ntec.pdf', 'file', '下載徵稿啟事'],
		['<img src='+basedir+'images/menu/word.gif>', '摘要頁格式', basedir+'dlfiles/ntec_abstract.doc', 'file', '下載摘要頁格式'],
		['<img src='+basedir+'images/menu/word.gif>', '論文格式', basedir+'dlfiles/ntec_paperformat.doc', 'file', '下載論文格式'],
		['<img src='+basedir+'images/menu/word.gif>', '授權書表單下載', basedir+'dlfiles/copyright.doc', 'file', '授權書表單下載']
	],
	['', '線上投稿', '#', 'mainFrame', '',
		['<img src='+basedir+'images/menu/pdf.gif>', '投稿系統使用手冊', basedir+'dlfiles/Submit_Guide.pdf', 'file', '下載投稿系統使用手冊'],
		['', '投稿步驟', 'proccess.htm', 'mainFrame', '投稿步驟說明'],
		['', '帳號申請', 'register.php', 'mainFrame', '新申請一使用者帳號'],
		['', '論文上傳', 'upload.php', 'mainFrame', '論文完稿上傳'],
		['', '檢視上傳論文', 'view.php', 'mainFrame', '檢視、修改已上傳之論文資料'],
		['', '論文審稿結果', 'view2.php', 'mainFrame', '檢視上傳之論文審稿資料'],
		['', '論文完稿上傳/檢視', 'finalview.php', 'mainFrame', '論文完稿上傳/檢視']
	],
	['', '論文審稿', '#', 'mainFrame', '審稿系統',
	 	['<img src='+basedir+'images/menu/pdf.gif>', '審稿系統使用手冊', basedir+'dlfiles/Examine_Guide.pdf', 'file', '下載審稿系統使用手冊'],
	 	['', '審稿者登入', 'reviewlogin.php', 'mainFrame', '評審委員專用項目'],
		['', '<font color=dddddd>接受論文一覽</font>', '#', 'mainFrame', '已獲接受的論文一覽表'],
		['', '<font color=dddddd>最佳論文</font>', '#', 'mainFrame', '最佳論文名單']
	],
	['', '報名資訊', '#', 'mainFrame', '報名參與研討會的相關資訊',
		['', '<font color=dddddd>說明</font>', '#', 'mainFrame', '報名的說明事項'],
		['<img src='+basedir+'images/menu/word.gif>', '<font color=dddddd>報名表</font>', '#', 'mainFrame', '下載報名表']
	],
	['', '其他資訊', '', 'mainFrame', '關於校員、交通、住宿等等相關事項',
		['', '參訪行程', '#', 'mainFrame', '免費參訪行程',
			['', '<font color=dddddd>花蓮市區旅遊</font>', '#', 'mainFrame', '花蓮市導覽']
		],
		['', '交通資訊', '#', 'mainFrame', '指引您如何搭機前往國立花蓮教育大學',
		        ['', '飛機班航', 'http://tour-hualien.hl.gov.tw/chinese/12_travel_04_01.htm', '_blank', '飛機班航查詢'],
		        ['', '火車班次', 'http://www.railway.gov.tw/', '_blank', '火車班次查詢']
		],
		
		['', '旅遊景點', 'http://tour-hualien.hl.gov.tw/chinese/index.aspx', '_blank', '花蓮的各個景點介紹'],
		['', '住宿資訊', 'http://hotel.poja.com.tw/', '_blank', '提供各個飯店住宿的資訊'],
		['', '花蓮美食', 'http://www.17919.com.tw/', '_blank', '提供花蓮地方美食資訊'],
		['', '<font color=dddddd>相關地圖</font>', '#', 'mainFrame', '地圖'],
		['', '<font color=dddddd>停車說明</font>', '#', 'mainFrame', '停車說明'],
		['', '<font color=dddddd>交通接駁</font>', '#', 'mainFrame', '免費巴士班次表'],
		['', '本校介紹', 'http://www.nhlue.edu.tw/page/campus.htm', '_blank', '關於本校的介紹']
	],
	['', '聯絡我們', 'contact.htm', 'mainFrame', '如有任何問題，請與我們聯絡'],
	['', '論文管理', 'http://ntec.pels.nhlue.edu.tw/adm/', '_blank', '論文管理'],
	['', '回首頁', '../index.htm', '_top', '回首頁']
];
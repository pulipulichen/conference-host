var basedir = '../../';
var myMenu =
[
	['', '大會資訊', '#', 'mainFrame', '研討會相關資訊',
		['', '大會主旨與目的', 'intro.htm', 'mainFrame', '主旨與目的'],
		['', '大會組織', '#', 'mainFrame', '籌備大會的團隊',
			['', '指導委員', 'steering.htm', 'mainFrame', '指導委員'],
			['', '議程主席', 'pc.htm', 'mainFrame', '籌備本次大會的主席'],
			['', '議程委員', 'pcmembers.htm', 'mainFrame', '負責稿件審查的委員'],
			['', 'Social Events', 'socialevents.htm', 'mainFrame', 'Social Events'],
	  ],
		['', '最新消息', 'news.htm', 'mainFrame', '關於研討會的最新資訊'],
		['', '重要日期', 'date.htm', 'mainFrame', '研討會各項重要日期公告'],
		['', '主辦單位', 'DirectiveSponsors.htm', 'mainFrame', '本次研討會主辦單位'],
		['', '共同主辦單位', 'TechnicalCoSponsors.htm', 'mainFrame', '本次研討會共同主辦單位'],
		['', '協辦單位', 'CoSponsors.htm', 'mainFrame', '本次研討會協辦單位']
	],
	['', '會議議程', '#', 'mainFrame', '各項議程公佈',
		['<img src='+basedir+'images/menu/pdf.gif>', '議程總覽', basedir+'dlfiles/agenda_01.pdf', 'file', '議程總攬'],
		['<img src='+basedir+'images/menu/pdf.gif>', '議事規則', basedir+'dlfiles/rules.pdf', 'file', '議事規則']
	],
	['', '邀請講席', '#', 'mainFrame', '本次大會邀請演講資訊',
	 	['', 'CSCL Session', 'keynote1.htm', 'mainFrame', 'CSCL session'],
	 	['', 'CSPL Session', 'keynote2.htm', 'mainFrame', 'CSPL session']
	],
	['', '論壇與談人', '#', 'mainFrame', '本次大會邀請論壇與談人',
	 	['', 'CSCL Section', 'keynote3.htm', 'mainFrame', 'CSCL session'],
	 	['', 'CSPL Section', 'keynote4.htm', 'mainFrame', 'CSPL session']
	],
	['', '論文徵稿', '#', 'mainFrame', '關於稿件的資訊與注意事項',
	  ['<img src='+basedir+'images/menu/pdf.gif>', '徵稿啟事', basedir+'dlfiles/CSCLCSPL2013_callforpaper.pdf', 'file', '下載徵稿啟事'],
		['', '徵求主題', 'topic.htm', 'mainFrame', '本次研討會所微求的稿件主題'],
		['<img src='+basedir+'images/menu/word.gif>', '論文格式', basedir+'dlfiles/CSCLCSPL2013_paperformat.doc', 'file', '下載論文格式'],
	],
	['', '線上投稿', '#', 'mainFrame', '',
		['<img src='+basedir+'images/menu/pdf.gif>', '投稿系統使用手冊', basedir+'dlfiles/Submit_Guide.pdf', 'file', '下載投稿系統使用手冊'],
		['', '投稿步驟', 'proccess.htm', 'mainFrame', '投稿步驟說明'],
		['', '帳號申請', 'register.php', 'mainFrame', '新申請一使用者帳號'],
		['', '<font color=dddddd>論文上傳</font>', 'upload.php', 'mainFrame', '論文完稿上傳'],
		['', '檢視上傳論文', 'view.php', 'mainFrame', '檢視、修改已上傳之論文資料'],
		['', '論文審稿結果', 'view2.php', 'mainFrame', '檢視上傳之論文審稿資料'],
		['', '論文完稿上傳/檢視', 'finalview.php', 'mainFrame', '論文完稿上傳/檢視']
	],
	['', '論文審稿', '#', 'mainFrame', '審稿系統',
	 	['<img src='+basedir+'images/menu/pdf.gif>', '審稿系統使用手冊', basedir+'dlfiles/Examine_Guide.pdf', 'file', '下載審稿系統使用手冊'],
	 	['', '<font color=dddddd>審稿者登入</font>', '#', 'mainFrame', '評審委員專用項目'],
		['', '<font color=dddddd>接受論文一覽</font>', '#', 'mainFrame', '已獲接受的論文一覽表'],
	],
	['', '報名資訊', '#', 'mainFrame', '報名參與研討會的相關資訊',
		
		['<img src='+basedir+'images/menu/pdf.gif>','報名資訊', basedir+'dlfiles/csclcspl_signup.pdf', '_blank', '報名的說明事項'],
		['<img src='+basedir+'images/menu/word.gif>','研討會報名表', basedir+'dlfiles/applicationform.doc', '_blank', '繳費專用'],
		['', '<font color=dddddd>登入報名系統</font>', 'login.php', 'mainFrame', '報名已截止']
		
	],
	['', '其他資訊', '', 'mainFrame', '關於校員、交通、住宿等等相關事項',
		['', '晚宴地點', '#', 'mainFrame', '免費參訪行程',
			['', '貓空-四哥的店(清泉本店)創意茶餐廳', 'http://www.cctea.com.tw', '_blank', '創意茶餐廳']
		],
		['', '交通資訊', '#', 'mainFrame', '指引您如何搭交通工具前往國立政治大學大學',
		        ['', '國內飛機航班時刻表', 'http://www.tsa.gov.tw/CustomerSet/tsa/tp_FlightSchedule/u_fsout_v.asp?id={FE8E2C05-9D2C-482F-9919-4A3A3387E71A}', '_blank', '松山機場航班表'],
		        ['', '高速鐵路時刻表', 'http://www.thsrc.com.tw/tc/ticket/tic_time_search.asp', '_blank', '高鐵時刻表'],
		        ['', '火車時刻表', 'http://twtraffic.tra.gov.tw/twrail/', '_blank', '台鐵時刻表']
		],
		['', '旅遊景點', 'http://www.taipeitravel.net/', '_blank', '臺北市政府觀光傳播局 臺北旅遊網'],
		['', '政大住宿資訊', 'http://nccuga.nccu.edu.tw/~ihouse/index.html ', '_blank', '政大住宿資訊'],
		['', '台北市住宿資訊', 'http://hotel.ezfly.com/list/02-taipeicity.html', '_blank', '提供各個飯店住宿的資訊'],
		['', '文山區美食', 'http://www.100.look.tw/Food/rest_class.aspx?class=REST_C_AREA&class_id=116', '_blank', '提供文山區美食資訊'],
		['', '校園地圖', 'http://www.nccu.edu.tw/about/maps/pdf/campus2007.pdf', '_blank', '校園地圖'],
		['', '校內接駁公車', 'http://nccuga.nccu.edu.tw/app/pages.php?ID=nccubus', '_blank', '免費巴士班次表'],
		['', '本校介紹', 'http://www.nccu.edu.tw/about/', '_blank', '關於本校的介紹']
	],
	['', '上屆會議資訊', 'https://sites.google.com/site/csclaied2012/', '_blank', 'csclaied2012'],
	['', '聯絡我們', 'contact.htm', 'mainFrame', '如有任何問題，請與我們聯絡'],
	['', '回首頁', '../index.htm', '_top', '回首頁']
];
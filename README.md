# web_final_hw
網頁程式設計的期末作業

step.1 先匯入所需的資料表

●sender的資料表
CREATE TABLE `sender` (
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(10) UNSIGNED NOT NULL,
  `size` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `contactinfo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

●guestbook的資料表
CREATE TABLE `guestbook` (
  `留言編號` int(10) UNSIGNED NOT NULL,
  `姓名` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '無名氏',
  `留言` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `日期時間` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

step.2 config.inc 改成你的資訊
step.3 打開index_test.html
沒有step.4 呵呵

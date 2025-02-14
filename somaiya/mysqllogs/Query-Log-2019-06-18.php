SELECT *
FROM `languages`
WHERE `public` = 1
AND `code` = 'en'

SELECT *
FROM `setting`

SELECT *
FROM `setting_options_per_lang`
WHERE `language_id` = '1'

SELECT *
FROM `emergency`
LEFT JOIN `locations` ON `locations`.`location_id`=`emergency`.`location_id`
WHERE ADDTIME(NOW() ,"05:29:49") BETWEEN from_date and  to_date AND  `emergency`.`public` = 1
ORDER BY `emergency_id` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` =0
AND `sub_sub_menu` =0
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '48'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '1'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '98'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '99'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '112'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '110'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '111'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '5'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '3'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '2'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '148'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '149'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '33'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '74'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '75'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '32'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '70'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '145'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '27'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '30'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '31'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '214'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '233'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '92'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '95'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '96'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '97'
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` =0
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '1'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '8'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '10'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '17'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '95'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` =0
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '30'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '3'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '1'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '4'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '5'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '11'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '12'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `banner_images`
WHERE `institute_id` = 50
AND (valid_upto IS NULL
            OR valid_upto = '0000-00-00'
            OR valid_upto>='2019-06-18')
AND `public` = 1
ORDER BY `row_order` ASC

SELECT *
FROM `post`
JOIN `titles` ON `titles`.`relation_id`=`post_id`
JOIN `contents` ON `contents`.`relation_id`=`post`.`post_id`
WHERE `post`.`institute_id` = 50
AND `post`.`html_slider` = 1
AND `titles`.`data_type` = 'post'
AND `contents`.`data_type` = 'post'
AND `titles`.`language_id` = '1'
AND `post`.`public` = 1
ORDER BY `post_order` ASC

SELECT *
FROM `languages`
WHERE `public` = 1

SELECT *
FROM `page`
JOIN `titles` ON `titles`.`relation_id`=`page_id`
WHERE `titles`.`data_type` = 'page'
AND `titles`.`language_id` = '1'
AND `preview` = 1
AND `public` = 1
ORDER BY `page_order` ASC

SELECT *
FROM `page`
JOIN `extensions` ON `extensions`.`relation_id`=`page`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`page`.`page_id`
WHERE `titles`.`data_type` = 'page'
AND `titles`.`language_id` = '1'
AND `page`.`page_name` = 'home'
AND `page`.`public` = 1
ORDER BY `page_order` ASC

SELECT *, `eventcontents`.`to_date` AS `newvaluetodate`, `eventcontents`.`from_date` AS `newvaluefromdate`, `edu_institute_dir`.`INST_NAME` as `institute_name`
FROM `event`
JOIN `titles` ON `titles`.`relation_id`=`event_id`
JOIN `eventcontents` ON `eventcontents`.`relation_id`=`event`.`event_id`
LEFT JOIN `edu_institute_dir` ON `edu_institute_dir`.`INST_ID`=`event`.`institute_id`
LEFT JOIN `locations` ON `locations`.`location_id`=`event`.`location_id`
WHERE `titles`.`data_type` = 'event'
AND `titles`.`language_id` = '1'
AND `event`.`public` = 1
AND `event`.`featured_event` = 1
ORDER BY `eventcontents`.`to_date` DESC

SELECT *, GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew, `contentsannouncement`.`date` AS `newvaluedate`
FROM `announcement`
JOIN `titles` ON `titles`.`relation_id`=`announcement_id`
JOIN `contentsannouncement` ON `contentsannouncement`.`relation_id`=`announcement`.`announcement_id`
LEFT JOIN `edu_institute_dir` ON `FIND_IN_SET`(edu_institute_dir. INST_ID,    announcement.institute_id)
LEFT JOIN `category` ON `category`.`category_id`=`announcement`.`category_id`
WHERE `titles`.`data_type` = 'announcement'
AND `contentsannouncement`.`data_type` = 'announcement'
AND `titles`.`language_id` = '1'
AND `announcement`.`public` = 1
GROUP BY `announcement`.`announcement_id`
ORDER BY `contentsannouncement`.`date` DESC

SELECT *, `INST_NAME` as `institute_name`
FROM `announcement`
JOIN `titles` ON `titles`.`relation_id`=`announcement_id`
JOIN `contentsannouncement` ON `contentsannouncement`.`relation_id`=`announcement`.`announcement_id`
LEFT JOIN `edu_institute_dir` ON `edu_institute_dir`.`INST_ID`=`announcement`.`institute_id`
LEFT JOIN `category` ON `category`.`category_id`=`announcement`.`category_id`
WHERE `titles`.`data_type` = 'announcement'
AND `contentsannouncement`.`data_type` = 'announcement'
AND `titles`.`language_id` = '1'
AND `announcement`.`public` = 1
ORDER BY `contentsannouncement`.`date` DESC
 LIMIT 1, 4

SELECT *, `INST_NAME` as `institute_name`
FROM `event`
JOIN `titles` ON `titles`.`relation_id`=`event_id`
JOIN `eventcontents` ON `eventcontents`.`relation_id`=`event`.`event_id`
LEFT JOIN `edu_institute_dir` ON `edu_institute_dir`.`INST_ID`=`event`.`institute_id`
WHERE `titles`.`data_type` = 'event'
AND `eventcontents`.`to_date` >= ADDTIME(NOW() ,"05:29:49")
AND `titles`.`language_id` = '1'
AND `event`.`public` = 1
ORDER BY `eventcontents`.`to_date` ASC
 LIMIT 3

SELECT *
FROM `video_management`
WHERE `video_management`.`public` = 1
AND `spotlight_video` = 1
ORDER BY `created_date` DESC
 LIMIT 8

SELECT `mch`.*, `ecd`.`COURSE_NAME`, `inst`.`inst_programs` as `program`, `inst`.`inst_site` as `site`, `inst`.`institute_url` as `url`, `prid`.`url` as `program_url`, `eld`.`LEVEL_OF_STUDY_NAME` as `level_of_study`, `eld`.`COLOR_CODE` as `color_code`, (SELECT count(*) FROM edu_map_course_head smch WHERE smch.COURSE_ID = mch.COURSE_ID) as no_of_institutes, (SELECT AREA_OF_STUDY_NAME FROM edu_areaofstudy_dir ead WHERE ead.AREA_OF_STUDY_ID = mch.AREA_OF_STUDY_ID) as area_of_study, (SELECT DISCIPLINE_NAME FROM edu_discipline_dir edd WHERE edd.DISCIPLINE_ID = mch.DISCIPLINE_ID) as discipline
FROM `edu_map_course_head` `mch`
LEFT JOIN `program_contents` `prid` ON `prid`.`relation_id`=`mch`.`MAP_COURSE_ID`
LEFT JOIN `edu_levelofstudy_dir` `eld` ON `eld`.`LEVEL_OF_STUDY_ID`=`mch`.`LEVEL_OF_STUDY_ID`
LEFT JOIN `edu_institute_dir` `inst` ON `inst`.`INST_ID`=`mch`.`INST_ID`
JOIN `edu_course_dir` `ecd` ON `ecd`.`COURSE_ID`=`mch`.`COURSE_ID`
WHERE `mch`.`public` = 1
GROUP BY `mch`.`COURSE_ID`
ORDER BY `ecd`.`COURSE_NAME` ASC

SELECT pl.*, plc.title as new_title, plc.abstract_to_talk, GROUP_CONCAT(DISTINCT(c.category_name)) AS area_of_interest_name, CONCAT(s.first_name, ' ', s.last_name) AS speaker_name, s.designation_id, s.description as profile, s.profile_image, d.name as designation_name, d.short_name as designation_short_name, pl.start_date_time as endDateTime, 'public_lecture' as datatype
FROM `public_lectures` `pl`
JOIN `public_lecture_content` `plc` ON `plc`.`lecture_id`=`pl`.`lecture_id`
LEFT JOIN `category` `c` ON `FIND_IN_SET`(c.category_id, pl.area_of_interest)
LEFT JOIN `speakers` `s` ON `pl`.`speaker_id`=`s`.`speaker_id`
LEFT JOIN `designations` `d` ON `d`.`designation_id`=`s`.`designation_id`
WHERE `pl`.`start_date_time` < '2019-06-18  00:00:00'
AND `pl`.`institute_id` = '50'
AND `pl`.`public` = 1
AND `plc`.`language_id` = '1'
GROUP BY `pl`.`lecture_id`
ORDER BY `start_date_time` DESC
 LIMIT 3

SELECT pl.*, plc.title as new_title, plc.abstract_to_talk, GROUP_CONCAT(DISTINCT(c.category_name)) AS area_of_interest_name, CONCAT(s.first_name, ' ', s.last_name) AS speaker_name, s.designation_id, s.description as profile, s.profile_image, d.name as designation_name, d.short_name as designation_short_name, pl.start_date_time as endDateTime, 'public_lecture' as datatype
FROM `public_lectures` `pl`
JOIN `public_lecture_content` `plc` ON `plc`.`lecture_id`=`pl`.`lecture_id`
LEFT JOIN `category` `c` ON `FIND_IN_SET`(c.category_id, pl.area_of_interest)
LEFT JOIN `speakers` `s` ON `pl`.`speaker_id`=`s`.`speaker_id`
LEFT JOIN `designations` `d` ON `d`.`designation_id`=`s`.`designation_id`
WHERE `pl`.`start_date_time` >= '2019-06-18  00:00:00'
AND `pl`.`institute_id` = '50'
AND `pl`.`public` = 1
AND `plc`.`language_id` = '1'
GROUP BY `pl`.`lecture_id`
ORDER BY `start_date_time` ASC
 LIMIT 3

SELECT *
FROM `languages`
WHERE `public` = 1
AND `code` = 'en'

SELECT *
FROM `setting`

SELECT *
FROM `setting_options_per_lang`
WHERE `language_id` = '1'

SELECT *
FROM `emergency`
LEFT JOIN `locations` ON `locations`.`location_id`=`emergency`.`location_id`
WHERE ADDTIME(NOW() ,"05:29:49") BETWEEN from_date and  to_date AND  `emergency`.`public` = 1
ORDER BY `emergency_id` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` =0
AND `sub_sub_menu` =0
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '48'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '1'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '98'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '99'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '112'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '110'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '111'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '5'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '3'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '2'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '148'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '149'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '33'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '74'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '75'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '32'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '70'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '145'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '27'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '30'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '31'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '214'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '233'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '92'
AND `menu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '95'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '96'
ORDER BY `menu_order` ASC

SELECT *
FROM `menu`
LEFT JOIN `page` ON `page`.`page_id`=`menu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'menu'
AND `titles`.`language_id` = '1'
AND `menu`.`public` = 1
AND `sub_menu` = '97'
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` =0
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '1'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '8'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '10'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '17'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `footermenu`
LEFT JOIN `page` ON `page`.`page_id`=`footermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'footermenu'
AND `titles`.`language_id` = '1'
AND `footermenu`.`public` = 1
AND `sub_menu` = '95'
AND `footermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` =0
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '30'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '3'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '1'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '4'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '5'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '11'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `headermenu`
LEFT JOIN `page` ON `page`.`page_id`=`headermenu`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`menu_id`
WHERE `titles`.`data_type` = 'headermenu'
AND `titles`.`language_id` = '1'
AND `headermenu`.`public` = 1
AND `sub_menu` = '12'
AND `headermenu`.`institute_id` = 50
ORDER BY `menu_order` ASC

SELECT *
FROM `banner_images`
WHERE `institute_id` = 50
AND (valid_upto IS NULL
            OR valid_upto = '0000-00-00'
            OR valid_upto>='2019-06-18')
AND `public` = 1
ORDER BY `row_order` ASC

SELECT *
FROM `post`
JOIN `titles` ON `titles`.`relation_id`=`post_id`
JOIN `contents` ON `contents`.`relation_id`=`post`.`post_id`
WHERE `post`.`institute_id` = 50
AND `post`.`html_slider` = 1
AND `titles`.`data_type` = 'post'
AND `contents`.`data_type` = 'post'
AND `titles`.`language_id` = '1'
AND `post`.`public` = 1
ORDER BY `post_order` ASC

SELECT *
FROM `languages`
WHERE `public` = 1

SELECT *
FROM `page`
JOIN `titles` ON `titles`.`relation_id`=`page_id`
WHERE `titles`.`data_type` = 'page'
AND `titles`.`language_id` = '1'
AND `preview` = 1
AND `public` = 1
ORDER BY `page_order` ASC

SELECT *
FROM `page`
JOIN `extensions` ON `extensions`.`relation_id`=`page`.`page_id`
JOIN `titles` ON `titles`.`relation_id`=`page`.`page_id`
WHERE `titles`.`data_type` = 'page'
AND `titles`.`language_id` = '1'
AND `page`.`page_name` = 'home'
AND `page`.`public` = 1
ORDER BY `page_order` ASC

SELECT *, `eventcontents`.`to_date` AS `newvaluetodate`, `eventcontents`.`from_date` AS `newvaluefromdate`, `edu_institute_dir`.`INST_NAME` as `institute_name`
FROM `event`
JOIN `titles` ON `titles`.`relation_id`=`event_id`
JOIN `eventcontents` ON `eventcontents`.`relation_id`=`event`.`event_id`
LEFT JOIN `edu_institute_dir` ON `edu_institute_dir`.`INST_ID`=`event`.`institute_id`
LEFT JOIN `locations` ON `locations`.`location_id`=`event`.`location_id`
WHERE `titles`.`data_type` = 'event'
AND `titles`.`language_id` = '1'
AND `event`.`public` = 1
AND `event`.`featured_event` = 1
ORDER BY `eventcontents`.`to_date` DESC

SELECT *, GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew, `contentsannouncement`.`date` AS `newvaluedate`
FROM `announcement`
JOIN `titles` ON `titles`.`relation_id`=`announcement_id`
JOIN `contentsannouncement` ON `contentsannouncement`.`relation_id`=`announcement`.`announcement_id`
LEFT JOIN `edu_institute_dir` ON `FIND_IN_SET`(edu_institute_dir. INST_ID,    announcement.institute_id)
LEFT JOIN `category` ON `category`.`category_id`=`announcement`.`category_id`
WHERE `titles`.`data_type` = 'announcement'
AND `contentsannouncement`.`data_type` = 'announcement'
AND `titles`.`language_id` = '1'
AND `announcement`.`public` = 1
GROUP BY `announcement`.`announcement_id`
ORDER BY `contentsannouncement`.`date` DESC

SELECT *, `INST_NAME` as `institute_name`
FROM `announcement`
JOIN `titles` ON `titles`.`relation_id`=`announcement_id`
JOIN `contentsannouncement` ON `contentsannouncement`.`relation_id`=`announcement`.`announcement_id`
LEFT JOIN `edu_institute_dir` ON `edu_institute_dir`.`INST_ID`=`announcement`.`institute_id`
LEFT JOIN `category` ON `category`.`category_id`=`announcement`.`category_id`
WHERE `titles`.`data_type` = 'announcement'
AND `contentsannouncement`.`data_type` = 'announcement'
AND `titles`.`language_id` = '1'
AND `announcement`.`public` = 1
ORDER BY `contentsannouncement`.`date` DESC
 LIMIT 1, 4

SELECT *, `INST_NAME` as `institute_name`
FROM `event`
JOIN `titles` ON `titles`.`relation_id`=`event_id`
JOIN `eventcontents` ON `eventcontents`.`relation_id`=`event`.`event_id`
LEFT JOIN `edu_institute_dir` ON `edu_institute_dir`.`INST_ID`=`event`.`institute_id`
WHERE `titles`.`data_type` = 'event'
AND `eventcontents`.`to_date` >= ADDTIME(NOW() ,"05:29:49")
AND `titles`.`language_id` = '1'
AND `event`.`public` = 1
ORDER BY `eventcontents`.`to_date` ASC
 LIMIT 3

SELECT *
FROM `video_management`
WHERE `video_management`.`public` = 1
AND `spotlight_video` = 1
ORDER BY `created_date` DESC
 LIMIT 8

SELECT `mch`.*, `ecd`.`COURSE_NAME`, `inst`.`inst_programs` as `program`, `inst`.`inst_site` as `site`, `inst`.`institute_url` as `url`, `prid`.`url` as `program_url`, `eld`.`LEVEL_OF_STUDY_NAME` as `level_of_study`, `eld`.`COLOR_CODE` as `color_code`, (SELECT count(*) FROM edu_map_course_head smch WHERE smch.COURSE_ID = mch.COURSE_ID) as no_of_institutes, (SELECT AREA_OF_STUDY_NAME FROM edu_areaofstudy_dir ead WHERE ead.AREA_OF_STUDY_ID = mch.AREA_OF_STUDY_ID) as area_of_study, (SELECT DISCIPLINE_NAME FROM edu_discipline_dir edd WHERE edd.DISCIPLINE_ID = mch.DISCIPLINE_ID) as discipline
FROM `edu_map_course_head` `mch`
LEFT JOIN `program_contents` `prid` ON `prid`.`relation_id`=`mch`.`MAP_COURSE_ID`
LEFT JOIN `edu_levelofstudy_dir` `eld` ON `eld`.`LEVEL_OF_STUDY_ID`=`mch`.`LEVEL_OF_STUDY_ID`
LEFT JOIN `edu_institute_dir` `inst` ON `inst`.`INST_ID`=`mch`.`INST_ID`
JOIN `edu_course_dir` `ecd` ON `ecd`.`COURSE_ID`=`mch`.`COURSE_ID`
WHERE `mch`.`public` = 1
GROUP BY `mch`.`COURSE_ID`
ORDER BY `ecd`.`COURSE_NAME` ASC

SELECT pl.*, plc.title as new_title, plc.abstract_to_talk, GROUP_CONCAT(DISTINCT(c.category_name)) AS area_of_interest_name, CONCAT(s.first_name, ' ', s.last_name) AS speaker_name, s.designation_id, s.description as profile, s.profile_image, d.name as designation_name, d.short_name as designation_short_name, pl.start_date_time as endDateTime, 'public_lecture' as datatype
FROM `public_lectures` `pl`
JOIN `public_lecture_content` `plc` ON `plc`.`lecture_id`=`pl`.`lecture_id`
LEFT JOIN `category` `c` ON `FIND_IN_SET`(c.category_id, pl.area_of_interest)
LEFT JOIN `speakers` `s` ON `pl`.`speaker_id`=`s`.`speaker_id`
LEFT JOIN `designations` `d` ON `d`.`designation_id`=`s`.`designation_id`
WHERE `pl`.`start_date_time` >= '2019-06-18  00:00:00'
AND `pl`.`institute_id` = '50'
AND `pl`.`public` = 1
AND `plc`.`language_id` = '1'
GROUP BY `pl`.`lecture_id`
ORDER BY `start_date_time` ASC
 LIMIT 3

SELECT pl.*, plc.title as new_title, plc.abstract_to_talk, GROUP_CONCAT(DISTINCT(c.category_name)) AS area_of_interest_name, CONCAT(s.first_name, ' ', s.last_name) AS speaker_name, s.designation_id, s.description as profile, s.profile_image, d.name as designation_name, d.short_name as designation_short_name, pl.start_date_time as endDateTime, 'public_lecture' as datatype
FROM `public_lectures` `pl`
JOIN `public_lecture_content` `plc` ON `plc`.`lecture_id`=`pl`.`lecture_id`
LEFT JOIN `category` `c` ON `FIND_IN_SET`(c.category_id, pl.area_of_interest)
LEFT JOIN `speakers` `s` ON `pl`.`speaker_id`=`s`.`speaker_id`
LEFT JOIN `designations` `d` ON `d`.`designation_id`=`s`.`designation_id`
WHERE `pl`.`start_date_time` < '2019-06-18  00:00:00'
AND `pl`.`institute_id` = '50'
AND `pl`.`public` = 1
AND `plc`.`language_id` = '1'
GROUP BY `pl`.`lecture_id`
ORDER BY `start_date_time` DESC
 LIMIT 3


UPDATE questions SET hashtag = '#二補碼' WHERE question LIKE '%二進制補碼%';
UPDATE questions SET hashtag = '#試算表' WHERE question LIKE '%試算表%';
UPDATE questions SET hashtag = '#檢查數位' WHERE question LIKE '%檢查數位%';
UPDATE questions SET hashtag = CONCAT(hashtag, ' #數據庫') WHERE question LIKE '%數據庫%';
UPDATE questions SET hashtag = '#音頻' WHERE question LIKE '%音頻%';
UPDATE questions SET hashtag = CONCAT(hashtag, ' #圖像') WHERE question LIKE '%bmp%' OR question LIKE '%jpg%' OR question LIKE '%png%' OR question LIKE '%圖像%';
UPDATE questions SET hashtag = '#關鍵欄' WHERE question LIKE '%關鍵欄%';
UPDATE questions SET hashtag = '#SQL' WHERE question LIKE '%SQL%' or question LIKE '%select%';
UPDATE questions SET hashtag = '#PDF' WHERE question LIKE '%PDF%';
UPDATE questions SET hashtag = '#電子學習' WHERE question LIKE '%電子學習%';
UPDATE questions SET hashtag = '#數碼化' WHERE question LIKE '%數碼化%';

UPDATE questions SET hashtag = '#OCR' WHERE question LIKE '%光符識別%' or question LIKE '%OCR%';

UPDATE questions SET hashtag = CONCAT(hashtag, ', #網絡安全') 
WHERE question LIKE '%病毒%'
   OR question LIKE '%蠕蟲%'
   OR question LIKE '%防毒%'
   OR question LIKE '%木馬%';


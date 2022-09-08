--SQLで未回答者一覧を出力する #30
SELECT event_id,events.name,username,start_at FROM users 
INNER JOIN event_attendance ON users.id = user_id
INNER JOIN events ON events.id = event_id
WHERE start_at > now()
AND is_attendance = 2 ORDER BY event_id;
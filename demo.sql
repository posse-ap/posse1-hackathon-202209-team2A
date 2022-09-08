--SQLで未回答者一覧を出力する #30
SELECT event_id,events.name,username,start_at FROM users 
INNER JOIN event_attendance ON users.id = user_id
INNER JOIN events ON events.id = event_id
WHERE start_at > now()
AND is_attendance = 2 ORDER BY event_id;

--SQLで参加者一覧を出力する #23
select name,start_at,username from events 
join event_attendance on events.id = event_attendance.event_id 
join users on users.id = event_attendance.user_id 
where start_at >= now() 
and is_attendance = 1;
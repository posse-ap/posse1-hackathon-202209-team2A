DROP SCHEMA IF EXISTS posse;
CREATE SCHEMA posse;
USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  hashed_password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  detail VARCHAR(255),
  start_at DATETIME NOT NULL,
  end_at DATETIME NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS event_attendance;
CREATE TABLE event_attendance (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  event_id INT NOT NULL,
  user_id INT NOT NULL,
  is_attendance INTEGER DEFAULT 2,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME,
  FOREIGN KEY fk_event_id(event_id)
  REFERENCES events(id),
  FOREIGN KEY fk_user_id(user_id)
  REFERENCES users(id)
);

DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  hashed_password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO users SET username='武田龍一', email='ryuichitakeda@posse.com', hashed_password=SHA1('takeda');
INSERT INTO users SET username='福場脩真', email='shumafukuba@posse.com', hashed_password=SHA1('fukuba');
INSERT INTO users SET username='古屋美羽', email='miuhuruya@posse.com', hashed_password=SHA1('huruya');
INSERT INTO users SET username='中澤和貴', email='kazukinakazawa@posse.com', hashed_password=SHA1('nakazawa');
INSERT INTO users SET username='林千翼子', email='chiyokohayashi@posse.com', hashed_password=SHA1('hayashi');


INSERT INTO events SET name='縦モク', start_at='2021/08/01 21:00', end_at='2021/08/01 23:00',dead_line='2021/08/01 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/02 21:00', end_at='2021/08/02 23:00',dead_line='2021/08/02 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/03 20:00', end_at='2021/08/03 22:00',dead_line='2021/08/03 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/08 21:00', end_at='2021/08/08 23:00',dead_line='2021/08/08 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/09 21:00', end_at='2021/08/09 23:00',dead_line='2021/08/09 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/10 20:00', end_at='2021/08/10 22:00',dead_line='2021/08/10 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/15 21:00', end_at='2021/08/15 23:00',dead_line='2021/08/15 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/16 21:00', end_at='2021/08/16 23:00',dead_line='2021/08/16 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/17 20:00', end_at='2021/08/17 22:00',dead_line='2021/08/17 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/22 21:00', end_at='2021/08/22 23:00',dead_line='2021/08/22 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/23 21:00', end_at='2021/08/23 23:00',dead_line='2021/08/23 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/24 20:00', end_at='2021/08/24 22:00',dead_line='2021/08/24 22:00';
INSERT INTO events SET name='遊び', start_at='2021/09/22 18:00', end_at='2021/09/22 22:00',dead_line='2021/09/22 22:00';
INSERT INTO events SET name='ハッカソン', start_at='2021/09/03 10:00', end_at='2021/09/03 22:00',dead_line='2021/09/03 22:00';
INSERT INTO events SET name='遊び', start_at='2021/09/06 18:00', end_at='2021/09/06 22:00',dead_line='2021/09/06 22:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/24 20:00', end_at='2021/08/24 22:00',dead_line='2021/08/24 22:00';
-- id17~未来のイベント
INSERT INTO events SET name='運動会', start_at='2022/10/15 10:00', end_at='2022/10/15 19:00',dead_line='2022/10/15 19:00';
INSERT INTO events SET name='ハロウィン', start_at='2022/10/31 10:00', end_at='2022/10/31 22:00',dead_line='2022/10/31 22:00';
INSERT INTO events SET name='クリスマス', start_at='2022/12/24 18:00', end_at='2022/12/24 22:00',dead_line='2022/12/24 22:00';
INSERT INTO events SET name='冬のDX', start_at='2022/12/28 20:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/9イベント', start_at='2022/09/09 20:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/9イベント2', start_at='2022/09/09 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/9イベント3', start_at='2022/09/09 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/10イベント2', start_at='2022/09/10 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/10イベント3', start_at='2022/09/10 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/10イベント3', start_at='2022/09/10 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/11イベント', start_at='2022/09/11 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/11イベント2', start_at='2022/09/11 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/11イベント3', start_at='2022/09/11 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/12イベント', start_at='2022/09/12 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/12イベント2', start_at='2022/09/12 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/12イベント3', start_at='2022/09/13 15:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/12イベント4', start_at='2022/09/12 12:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/12イベント5', start_at='2022/09/12 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/13イベント', start_at='2022/09/13 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/13イベント1', start_at='2022/09/13 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/13イベント2', start_at='2022/09/13 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/13イベント3', start_at='2022/09/13 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/13イベント4', start_at='2022/09/13 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/13イベント5', start_at='2022/09/13 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/14イベント', start_at='2022/09/14 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/14イベント2', start_at='2022/09/14 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/14イベント3', start_at='2022/09/14 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/14イベント4', start_at='2022/09/14 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';
INSERT INTO events SET name='9/14イベント5', start_at='2022/09/14 21:00', end_at='2022/12/28 22:00',dead_line='2022/12/28 22:00';



INSERT INTO event_attendance SET event_id=1, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=1, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=1, user_id=3, is_attendance=true;
INSERT INTO event_attendance SET event_id=1, user_id=4, is_attendance=false;

INSERT INTO event_attendance SET event_id=2, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=2, user_id=2, is_attendance=false;
INSERT INTO event_attendance SET event_id=2, user_id=3, is_attendance=false;
INSERT INTO event_attendance SET event_id=17, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=17, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=17, user_id=3, is_attendance=false;
INSERT INTO event_attendance SET event_id=17, user_id=4, is_attendance=false;
INSERT INTO event_attendance SET event_id=18, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=18, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=18, user_id=3, is_attendance=true;
INSERT INTO event_attendance SET event_id=20, user_id=3, is_attendance=true;
INSERT INTO event_attendance SET event_id=21, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=21, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=21, user_id=3, is_attendance=true;
INSERT INTO event_attendance SET event_id=22, user_id=4, is_attendance=true;
INSERT INTO event_attendance SET event_id=22, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=23, user_id=4, is_attendance=true;
INSERT INTO event_attendance SET event_id=23, user_id=3, is_attendance=true;
INSERT INTO event_attendance SET event_id=23, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=24, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=24, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=25, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=25, user_id=5, is_attendance=true;
INSERT INTO event_attendance SET event_id=25, user_id=3, is_attendance=true;
INSERT INTO event_attendance SET event_id=26, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=26, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=27, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=27, user_id=3, is_attendance=true;
INSERT INTO event_attendance SET event_id=27, user_id=4, is_attendance=true;
INSERT INTO event_attendance SET event_id=28, user_id=4, is_attendance=true;
INSERT INTO event_attendance SET event_id=28, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=28, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=29, user_id=1, is_attendance=true;
INSERT INTO event_attendance SET event_id=29, user_id=2, is_attendance=true;
INSERT INTO event_attendance SET event_id=29, user_id=5, is_attendance=true;



INSERT INTO events SET name='縦モク', start_at='2021/08/01 21:00', end_at='2021/08/01 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/02 21:00', end_at='2021/08/02 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/03 20:00', end_at='2021/08/03 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/08 21:00', end_at='2021/08/08 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/09 21:00', end_at='2021/08/09 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/10 20:00', end_at='2021/08/10 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/15 21:00', end_at='2021/08/15 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/16 21:00', end_at='2021/08/16 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/17 20:00', end_at='2021/08/17 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/22 21:00', end_at='2021/08/22 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/23 21:00', end_at='2021/08/23 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/24 20:00', end_at='2021/08/24 22:00';
INSERT INTO events SET name='遊び', start_at='2021/09/22 18:00', end_at='2021/09/22 22:00';
INSERT INTO events SET name='ハッカソン', start_at='2021/09/03 10:00', end_at='2021/09/03 22:00';
INSERT INTO events SET name='遊び', start_at='2021/09/06 18:00', end_at='2021/09/06 22:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/24 20:00', end_at='2021/08/24 22:00';
INSERT INTO events SET name='運動会', start_at='2022/10/15 10:00', end_at='2022/10/15 19:00';
INSERT INTO events SET name='ハロウィン', start_at='2022/10/31 10:00', end_at='2022/10/31 22:00';
INSERT INTO events SET name='クリスマス', start_at='2022/12/24 18:00', end_at='2022/12/24 22:00';
INSERT INTO events SET name='冬のDX', start_at='2022/12/28 20:00', end_at='2022/12/28 22:00';
INSERT INTO events SET name='紅白歌合戦', start_at='2022/09/05 10:00', end_at='2022/09/05 22:00';
INSERT INTO events SET name='縦モク', start_at='2022/10/05 10:00', end_at='2022/10/05 22:00';
INSERT INTO events SET name='横モク', start_at='2022/10/05 10:00', end_at='2022/10/05 22:00';
INSERT INTO events SET name='スぺモク', start_at='2022/10/05 10:00', end_at='2022/10/05 22:00';
INSERT INTO events SET name='スぺモク', start_at='2022/10/05 10:00', end_at='2022/10/05 22:00';
INSERT INTO events SET name='スぺモク', start_at='2022/10/05 10:00', end_at='2022/10/05 22:00';
INSERT INTO events SET name='スぺモク', start_at='2022/10/05 10:00', end_at='2022/10/05 22:00';
INSERT INTO events SET name='紅白歌合戦', start_at='2022/10/06 10:00', end_at='2022/10/06 22:00';
INSERT INTO events SET name='縦モク', start_at='2022/10/06 10:00', end_at='2022/10/06 22:00';
INSERT INTO events SET name='横モク', start_at='2022/10/06 10:00', end_at='2022/10/06 22:00';
INSERT INTO events SET name='スぺモク', start_at='2022/10/06 10:00', end_at='2022/10/06 22:00';
INSERT INTO events SET name='スぺモク', start_at='2022/10/06 10:00', end_at='2022/10/06 22:00';
INSERT INTO events SET name='スぺモク', start_at='2022/10/06 10:00', end_at='2022/10/06 22:00';
INSERT INTO events SET name='スぺモク', start_at='2022/10/06 10:00', end_at='2022/10/06 22:00';



INSERT INTO event_attendance SET event_id=1, user_id=1, is_attendance=1;
INSERT INTO event_attendance SET event_id=1, user_id=2, is_attendance=1;
INSERT INTO event_attendance SET event_id=1, user_id=3, is_attendance=1;
INSERT INTO event_attendance SET event_id=1, user_id=4, is_attendance=0;
INSERT INTO event_attendance SET event_id=2, user_id=1, is_attendance=1;
INSERT INTO event_attendance SET event_id=2, user_id=2, is_attendance=0;
INSERT INTO event_attendance SET event_id=2, user_id=3, is_attendance=0;
INSERT INTO event_attendance SET event_id=2, user_id=4;
INSERT INTO event_attendance SET event_id=3, user_id=1;
INSERT INTO event_attendance SET event_id=3, user_id=2;
INSERT INTO event_attendance SET event_id=3, user_id=3;
INSERT INTO event_attendance SET event_id=3, user_id=4;
INSERT INTO event_attendance SET event_id=4, user_id=1;
INSERT INTO event_attendance SET event_id=4, user_id=2;
INSERT INTO event_attendance SET event_id=4, user_id=3;
INSERT INTO event_attendance SET event_id=4, user_id=4;
INSERT INTO event_attendance SET event_id=5, user_id=1;
INSERT INTO event_attendance SET event_id=5, user_id=2;
INSERT INTO event_attendance SET event_id=5, user_id=3;
INSERT INTO event_attendance SET event_id=5, user_id=4;
INSERT INTO event_attendance SET event_id=6, user_id=1;
INSERT INTO event_attendance SET event_id=6, user_id=2;
INSERT INTO event_attendance SET event_id=6, user_id=3;
INSERT INTO event_attendance SET event_id=6, user_id=4;
INSERT INTO event_attendance SET event_id=7, user_id=1;
INSERT INTO event_attendance SET event_id=7, user_id=2;
INSERT INTO event_attendance SET event_id=7, user_id=3;
INSERT INTO event_attendance SET event_id=7, user_id=4;
INSERT INTO event_attendance SET event_id=8, user_id=1;
INSERT INTO event_attendance SET event_id=8, user_id=2;
INSERT INTO event_attendance SET event_id=8, user_id=3;
INSERT INTO event_attendance SET event_id=8, user_id=4;
INSERT INTO event_attendance SET event_id=9, user_id=1;
INSERT INTO event_attendance SET event_id=9, user_id=2;
INSERT INTO event_attendance SET event_id=9, user_id=3;
INSERT INTO event_attendance SET event_id=9, user_id=4;
INSERT INTO event_attendance SET event_id=10, user_id=1;
INSERT INTO event_attendance SET event_id=10, user_id=2;
INSERT INTO event_attendance SET event_id=10, user_id=3;
INSERT INTO event_attendance SET event_id=10, user_id=4;
INSERT INTO event_attendance SET event_id=11, user_id=1;
INSERT INTO event_attendance SET event_id=11, user_id=2;
INSERT INTO event_attendance SET event_id=11, user_id=3;
INSERT INTO event_attendance SET event_id=11, user_id=4;
INSERT INTO event_attendance SET event_id=12, user_id=1;
INSERT INTO event_attendance SET event_id=12, user_id=2;
INSERT INTO event_attendance SET event_id=12, user_id=3;
INSERT INTO event_attendance SET event_id=12, user_id=4;
INSERT INTO event_attendance SET event_id=13, user_id=1;
INSERT INTO event_attendance SET event_id=13, user_id=2;
INSERT INTO event_attendance SET event_id=13, user_id=3;
INSERT INTO event_attendance SET event_id=13, user_id=4;
INSERT INTO event_attendance SET event_id=14, user_id=1;
INSERT INTO event_attendance SET event_id=14, user_id=2;
INSERT INTO event_attendance SET event_id=14, user_id=3;
INSERT INTO event_attendance SET event_id=14, user_id=4;
INSERT INTO event_attendance SET event_id=15, user_id=1;
INSERT INTO event_attendance SET event_id=15, user_id=2;
INSERT INTO event_attendance SET event_id=15, user_id=3;
INSERT INTO event_attendance SET event_id=15, user_id=4;
INSERT INTO event_attendance SET event_id=16, user_id=1;
INSERT INTO event_attendance SET event_id=16, user_id=2;
INSERT INTO event_attendance SET event_id=16, user_id=3;
INSERT INTO event_attendance SET event_id=16, user_id=4;

INSERT INTO event_attendance SET event_id=17, user_id=1, is_attendance=1;
INSERT INTO event_attendance SET event_id=17, user_id=2, is_attendance=1;
INSERT INTO event_attendance SET event_id=17, user_id=3, is_attendance=0;
INSERT INTO event_attendance SET event_id=17, user_id=4, is_attendance=0;
INSERT INTO event_attendance SET event_id=18, user_id=1, is_attendance=1;
INSERT INTO event_attendance SET event_id=18, user_id=2, is_attendance=1;
INSERT INTO event_attendance SET event_id=18, user_id=3, is_attendance=1;
INSERT INTO event_attendance SET event_id=18, user_id=4, is_attendance=1;
INSERT INTO event_attendance SET event_id=19, user_id=1;
INSERT INTO event_attendance SET event_id=19, user_id=2;
INSERT INTO event_attendance SET event_id=19, user_id=3;
INSERT INTO event_attendance SET event_id=19, user_id=4;
INSERT INTO event_attendance SET event_id=20, user_id=1;
INSERT INTO event_attendance SET event_id=20, user_id=2;
INSERT INTO event_attendance SET event_id=20, user_id=3;
INSERT INTO event_attendance SET event_id=20, user_id=4;
INSERT INTO event_attendance SET event_id=21, user_id=1;
INSERT INTO event_attendance SET event_id=21, user_id=2;
INSERT INTO event_attendance SET event_id=21, user_id=3;
INSERT INTO event_attendance SET event_id=21, user_id=4;
INSERT INTO event_attendance SET event_id=22, user_id=1;
INSERT INTO event_attendance SET event_id=22, user_id=2;
INSERT INTO event_attendance SET event_id=22, user_id=3;
INSERT INTO event_attendance SET event_id=22, user_id=4;
INSERT INTO event_attendance SET event_id=23, user_id=1;
INSERT INTO event_attendance SET event_id=23, user_id=2;
INSERT INTO event_attendance SET event_id=23, user_id=3;
INSERT INTO event_attendance SET event_id=23, user_id=4;
INSERT INTO event_attendance SET event_id=24, user_id=1;
INSERT INTO event_attendance SET event_id=24, user_id=2;
INSERT INTO event_attendance SET event_id=24, user_id=3;
INSERT INTO event_attendance SET event_id=24, user_id=4;
INSERT INTO event_attendance SET event_id=25, user_id=1;
INSERT INTO event_attendance SET event_id=25, user_id=2;
INSERT INTO event_attendance SET event_id=25, user_id=3;
INSERT INTO event_attendance SET event_id=25, user_id=4;
INSERT INTO event_attendance SET event_id=26, user_id=1;
INSERT INTO event_attendance SET event_id=26, user_id=2;
INSERT INTO event_attendance SET event_id=26, user_id=3;
INSERT INTO event_attendance SET event_id=26, user_id=4;
INSERT INTO event_attendance SET event_id=27, user_id=1;
INSERT INTO event_attendance SET event_id=27, user_id=2;
INSERT INTO event_attendance SET event_id=27, user_id=3;
INSERT INTO event_attendance SET event_id=27, user_id=4;
INSERT INTO event_attendance SET event_id=28, user_id=1;
INSERT INTO event_attendance SET event_id=28, user_id=2;
INSERT INTO event_attendance SET event_id=28, user_id=3;
INSERT INTO event_attendance SET event_id=28, user_id=4;
INSERT INTO event_attendance SET event_id=29, user_id=1;
INSERT INTO event_attendance SET event_id=29, user_id=2;
INSERT INTO event_attendance SET event_id=29, user_id=3;
INSERT INTO event_attendance SET event_id=29, user_id=4;
INSERT INTO event_attendance SET event_id=30, user_id=1;
INSERT INTO event_attendance SET event_id=30, user_id=2;
INSERT INTO event_attendance SET event_id=30, user_id=3;
INSERT INTO event_attendance SET event_id=30, user_id=4;
INSERT INTO event_attendance SET event_id=31, user_id=1;
INSERT INTO event_attendance SET event_id=31, user_id=2;
INSERT INTO event_attendance SET event_id=31, user_id=3;
INSERT INTO event_attendance SET event_id=31, user_id=4;
INSERT INTO event_attendance SET event_id=32, user_id=1;
INSERT INTO event_attendance SET event_id=32, user_id=2;
INSERT INTO event_attendance SET event_id=32, user_id=3;
INSERT INTO event_attendance SET event_id=32, user_id=4;
INSERT INTO event_attendance SET event_id=33, user_id=1;
INSERT INTO event_attendance SET event_id=33, user_id=2;
INSERT INTO event_attendance SET event_id=33, user_id=3;
INSERT INTO event_attendance SET event_id=33, user_id=4;
INSERT INTO event_attendance SET event_id=34, user_id=1;
INSERT INTO event_attendance SET event_id=34, user_id=2;
INSERT INTO event_attendance SET event_id=34, user_id=3;
INSERT INTO event_attendance SET event_id=34, user_id=4;

INSERT INTO admins SET username='古屋美羽', email='miuhuruya@admin.com', hashed_password=SHA1('huruya');
INSERT INTO admins SET username='松本透歩', email='yukihomatumoto@admin.com', hashed_password=SHA1('matumoto');
INSERT INTO admins SET username='遠藤愛期', email='manakiendou@admin.com', hashed_password=SHA1('endou');

--SQLで未回答者一覧を出力する #30
SELECT event_id,events.name,username,start_at FROM users 
INNER JOIN event_attendance ON users.id = user_id
INNER JOIN events ON events.id = event_id
WHERE start_at > now()
AND is_attendance = 2 ORDER BY event_id;
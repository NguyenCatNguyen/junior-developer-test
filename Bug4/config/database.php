<?php

namespace Database;

class DBConnection {
  private $pdo;

  public function __construct() 
  {
   // Calling the generateTables method upon initiation. 
   // If you wish to generate a fresh database, delete the old file, uncomment the line blow and try access the posts again.
   // Just remember to comment it out once the database is generated.
   
   //$this->generateTables();
  }

  public function dbConnect(){
    if($this->pdo == null){
      // Creating the database file in the root folder to avoid issues with directory permissions.
      $this->pdo = new \PDO('sqlite:test.db');
    }
    return $this->pdo;
}

  // Generate tables for test
  function generateTables()
  {
    $db = $this->dbConnect();

    // Create users table
    $dbUserTable = "
      CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL
      );";

    $userTableStatement = $db->query($dbUserTable);
    $userTableStatement->execute();

    // Populate users table
    $dbUserData = "
      INSERT INTO users (username, email, password) VALUES
        ('johndoe', 'johndoe@example.com', 'p@ssw0rd123'),
        ('janedoe', 'janedoe@example.com', 'securePass!45'),
        ('mike89', 'mike89@example.com', 'm1k3P@ss'),
        ('sarah_smith', 'sarah.smith@example.com', 's@rah2023'),
        ('tom_hardy', 'tom.hardy@example.com', 'TomH#1234'),
        ('lucy_lu', 'lucy.lu@example.com', 'luCyLu#1'),
        ('chris_b', 'chris.b@example.com', 'Chris_987'),
        ('natalie123', 'natalie123@example.com', 'Nat!4567'),
        ('mark_z', 'mark.z@example.com', 'zuck@321'),
        ('emily_rose', 'emily.rose@example.com', 'EmiLyR#89'),
        ('johnwick', 'john.wick@example.com', 'BabaYaga!'),
        ('samantha_d', 'samantha.d@example.com', 'S@mD2024'),
        ('alex_r', 'alex.r@example.com', 'alexR0cks'),
        ('bella.c', 'bella.c@example.com', 'Bella!234'),
        ('ryan_m', 'ryan.m@example.com', 'Ry@n9876'),
        ('laura_p', 'laura.p@example.com', 'L@ur@2025'),
        ('david_lee', 'david.lee@example.com', 'D@ve1234'),
        ('anna.k', 'anna.k@example.com', 'Ann@2023'),
        ('peter.parker', 'peter.parker@example.com', 'Sp1d3y!'),
        ('tony_s', 'tony.s@example.com', '1ronMan#');
    ";

    $userDataStatement = $db->query($dbUserData);
    $userDataStatement->execute();

    $dbPostsTable = " 
      CREATE TABLE IF NOT EXISTS posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        content TEXT NOT NULL,
        image_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
      );";

    $postsTableStatement = $db->query($dbPostsTable);
    $postsTableStatement->execute();  

    $dbPostData = "
      INSERT INTO posts (user_id, content, image_url, created_at) VALUES
        (1, 'Just finished a great book on web development!', 'https://example.com/images/post1.jpg', '2025-04-28 10:15:00'),
        (2, 'Had a great time hiking this weekend. Nature is amazing.', 'https://example.com/images/post2.jpg', '2025-04-27 14:32:00'),
        (3, 'Started learning SQL today. Excited to dive deeper!', NULL, '2025-04-26 09:47:00'),
        (4, 'Coffee and code. The perfect combo!', 'https://example.com/images/post4.jpg', '2025-04-25 08:00:00'),
        (5, 'Working on a new app. Sneak peek soon!', NULL, '2025-04-24 16:20:00'),
        (2, 'Throwback to last summer ☀️', 'https://example.com/images/post6.jpg', '2025-04-23 12:05:00'),
        (1, 'Can’t believe how fast this month went by.', NULL, '2025-04-22 11:35:00'),
        (3, 'Anyone else using MySQL with Node.js? Looking for tips!', NULL, '2025-04-21 18:00:00');
        (1, 'Excited to launch my new blog today! Check it out!', 'https://fakeimg.com/bloglaunch.jpg', '2025-04-28 09:15:23'),
        (2, 'Had an amazing brunch with friends. Highly recommend the new place downtown.', 'https://fakeimg.com/brunch.jpg', '2025-04-27 11:45:00'),
        (3, 'Just published a new open-source tool on GitHub. Feedback welcome!', NULL, '2025-04-26 15:30:12'),
        (4, 'Beach sunsets never get old.', 'https://fakeimg.com/sunset.jpg', '2025-04-25 18:22:45'),
        (5, 'Productivity hack of the day: block notifications.', NULL, '2025-04-24 08:55:10'),
        (2, 'Weekend getaway to the mountains 🌲', 'https://fakeimg.com/mountains.jpg', '2025-04-23 14:17:09'),
        (1, 'First time trying sushi... where has it been all my life?', 'https://fakeimg.com/sushi.jpg', '2025-04-22 19:05:36'),
        (3, 'Debugging late into the night. Coffee is my best friend.', NULL, '2025-04-21 23:40:00'),
        (4, 'Started a 30-day fitness challenge today!', 'https://fakeimg.com/fitness.jpg', '2025-04-20 07:20:50'),
        (5, 'Learning about database indexes and how they improve performance.', NULL, '2025-04-19 16:10:00');
    ";

    $postDataStatement = $db->query($dbPostData);
    $postDataStatement->execute();

    $dbCommentsTable = "
      CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        post_id INT NOT NULL,
        user_id INT NOT NULL,
        comment_text TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (post_id) REFERENCES posts(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
      );";

    $commentsTableStatement = $db->query($dbCommentsTable);
    $commentsTableStatement->execute();

    $dbCommentData = "
      INSERT INTO comments (post_id, user_id, comment_text, created_at) VALUES
        (1, 2, 'Congrats on the blog launch! Looks great.', '2025-04-28 10:00:00'),
        (1, 3, 'Following now. Looking forward to more posts!', '2025-04-28 10:15:00'),
        (2, 1, 'That brunch photo made me hungry 😋', '2025-04-27 12:00:00'),
        (2, 5, 'What was the name of the place?', '2025-04-27 12:10:00'),
        (3, 4, 'Awesome! Will check out your repo.', '2025-04-26 16:00:00'),
        (3, 2, 'What tech stack did you use?', '2025-04-26 16:20:00'),
        (4, 1, 'Beautiful view. Where is this?', '2025-04-25 18:40:00'),
        (4, 5, 'Looks so peaceful!', '2025-04-25 18:55:00'),
        (5, 3, 'Totally agree. Disabling notifications changed my life.', '2025-04-24 09:10:00'),
        (6, 1, 'I love hiking there too!', '2025-04-23 14:30:00'),
        (6, 4, 'Did you camp overnight?', '2025-04-23 14:45:00'),
        (7, 2, 'Haha, sushi is amazing! Glad you liked it.', '2025-04-22 20:00:00'),
        (7, 5, 'Now I want sushi too 😆', '2025-04-22 20:10:00'),
        (8, 4, 'Been there. Late-night debugging is rough.', '2025-04-21 23:50:00'),
        (8, 1, 'Coffee + code = survival', '2025-04-21 23:55:00'),
        (9, 3, 'Good luck! Fitness challenges are tough but worth it.', '2025-04-20 07:45:00'),
        (9, 2, 'What kind of workouts are you doing?', '2025-04-20 08:00:00'),
        (10, 4, 'Indexes saved my project once. Great topic!', '2025-04-19 16:30:00'),
        (10, 1, 'Let me know if you want any resources.', '2025-04-19 16:45:00'),
        (10, 5, 'Databases can be tricky, but super rewarding.', '2025-04-19 17:00:00');
    ";

    $commentDataStatement = $db->query($dbCommentData);
    $commentDataStatement->execute();
  }
}
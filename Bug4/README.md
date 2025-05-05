# Instructions
Please complete the following tasks. You are welcome to use whatever methods you prefer. Aside from your changes in the code, please remember to provide a brief explanation in your email with the bug # you chose and how you went about troubleshooting it.

I've included the <a href="https://www.slimframework.com/" target="_blank">SlimPHP</a> framework for convenience but you are not required to use it. If you wish to go this route, you can use the following command to spin up the server on your local machine.

```terminal
composer install
composer start
```

React relies on <a href="https://nodejs.org/en" target="_blank">Node.js</a> and npm for managing dependencies and running build scripts. Make sure you have both installed on your system. If you would prefer to use <a href="https://classic.yarnpkg.com/en/" target="_blank">Yarn</a>, you can use that instead.

You will need to open a second terminal to run the react portion:

``` terminal
cd react/
yarn install or npm install
yarn run watch or npm run watch
```

## Bug #4
You are tasked with debugging a simple social media feed application built using React on the front-end and PHP on the back-end. The application displays posts from users, where each post can have text content, an image, and a list of comments. The posts should be displayed in reverse chronological order, with the most recent post appearing first.

There are two main issues in the code that need fixing:

1. Issue 1: The posts are not being displayed correctly.

2. Issue 2: Comments are not being loaded for each post.

You need to inspect and fix the issues in both the front-end and back-end code. You will also need to inspect the database schema to ensure it supports the functionality required for the social media feed.

### 1. Database Schema

#### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

#### Posts Table
```sql
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

#### Comments Table
```sql
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 2. Back-End (PHP)
<strong>PHP Endpoint to Fetch Posts with Comments</strong>

Here’s the PHP code that fetches posts along with their comments:

### PHP
```php
<?php
// database connection
$pdo = new PDO("mysql:host=localhost;dbname=social_media", "root", "password");

// Fetch posts with comments
$query = "SELECT posts.id AS post_id, posts.content AS post_content, posts.image_url, posts.created_at AS post_created_at,
                 users.username AS post_username,
                 comments.id AS comment_id, comments.comment_text, comments.created_at AS comment_created_at,
                 comment_users.username AS comment_username
          FROM posts
          LEFT JOIN users ON posts.user_id = users.id
          LEFT JOIN comments ON posts.id = comments.post_id
          LEFT JOIN users AS comment_users ON comments.user_id = comment_users.id
          ORDER BY posts.created_at DESC";

$stmt = $pdo->query($query);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($posts);
?>
```

### 3. Front-End (React)
In the React application, posts are fetched from the PHP endpoint and rendered. The current code does not render the posts and comments correctly.

```javascript
import React, { useEffect, useState } from 'react';

const Feed = () => {
  const [posts, setPosts] = useState([]);

  useEffect(() => {
    // Fetch posts from backend
    fetch('http://localhost:5000/posts')
      .then(response => response.json())
      .then(data => {
        setPosts(data);
      });
  }, []);

  return (
    <div>
      <h1>Social Media Feed</h1>
      {posts.map(post => (
        <div key={post.post_id} className="post">
          <div className="post-header">
            <h3>{post.post_username}</h3>
            <span>{new Date(post.post_created_at).toLocaleString()}</span>
          </div>
          <p>{post.post_content}</p>
          {post.image_url && <img src={post.image_url} alt="Post" />}
          <div className="comments">
            <h4>Comments:</h4>
            <p>{post.comment_text}</p>
        </div>
      ))}
    </div>
  );
};

export default Feed;
```

The code attempts to display post.comment_text, but this is incorrect because the data structure returned from the back-end contains all comments for all posts together, not grouped by post.

<strong>Tasks:</strong>
1. Back-End Fix:

    - Modify the PHP code to group comments under their respective posts. Instead of returning a flat list of posts and comments, return a nested structure where each post contains an array of comments.

2. Front-End Fix:

    - Modify the React code to correctly display comments for each post by grouping the comments together.

### 4. Expected Outcome
Here’s what the data returned by the PHP API should look like after fixing the back-end:

```json
[
  {
    "post_id": 1,
    "post_content": "Just had a great day at the beach!",
    "image_url": "beach.jpg",
    "post_created_at": "2025-04-23T12:30:00",
    "post_username": "john_doe",
    "comments": [
      {
        "comment_id": 1,
        "comment_text": "Looks amazing!",
        "comment_created_at": "2025-04-23T13:00:00",
        "comment_username": "jane_doe"
      },
      {
        "comment_id": 2,
        "comment_text": "I want to go there too!",
        "comment_created_at": "2025-04-23T13:10:00",
        "comment_username": "sam_smith"
      }
    ]
  },
  {
    "post_id": 2,
    "post_content": "Had a great workout today!",
    "image_url": "workout.jpg",
    "post_created_at": "2025-04-22T18:00:00",
    "post_username": "mike_king",
    "comments": []
  }
]
```

Each post now contains an array of comments, and the React front-end should render the posts and their respective comments properly.
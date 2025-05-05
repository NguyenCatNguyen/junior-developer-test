# Instructions
Please complete the following tasks. You are welcome to use whatever methods you prefer. Aside from your changes in the code, please remember to provide a brief explanation in your email with the bug # you chose and how you went about troubleshooting it.

I've included the <a href="https://www.slimframework.com/" target="_blank">SlimPHP</a> framework for convenience but you are not required to use it. If you wish to go this route, you can use the following command to spin up the server on your local machine.

If you don't have composer installed, you will need to install if you wish to run the framework listed above. https://getcomposer.org/download/

```terminal
composer install
composer start
```

## Bug #3
You are tasked with debugging a PHP-based discussion board application. The system consists of three main components:

1. Users - Registered users who can create posts and reply to threads.

2. Posts - Posts are made by users within a specific topic.

3. Topics - Topics are discussions under which posts are made.

Below is the incomplete and buggy PHP code for this system. Your task is to fix all issues, so the board functions as expected. After debugging the code, describe the changes you made to fix the issues.

### PHP (Discussionboard.php):
```php
<?php
class DiscussionBoard {
    private $users = [];
    private $topics = [];
    private $posts = [];

    // Function to register users
    public function registerUser($username, $email) {
        if(empty($username) || empty($email)) {
            echo "Error: Username and email cannot be empty.\n";
            return false;
        }
        $this->users[$username] = $email;
        return true;
    }

    // Function to create a new topic
    public function createTopic($topicName) {
        if(empty($topicName)) {
            echo "Error: Topic name cannot be empty.\n";
            return false;
        }
        $this->topics[] = $topicName;
        return true;
    }

    // Function to create a post
    public function createPost($username, $topic, $content) {
        if(!isset($this->users[$username])) {
            echo "Error: User does not exist.\n";
            return false;
        }
        if(empty($content) || !in_array($topic, $this->topics)) {
            echo "Error: Invalid topic or content.\n";
            return false;
        }

        $this->posts[] = ['user' => $username, 'topic' => $topic, 'content' => $content];
        return true;
    }

    // Function to get posts under a topic
    public function getPostsByTopic($topic) {
        if(!in_array($topic, $this->topics)) {
            echo "Error: Topic not found.\n";
            return false;
        }

        $topicPosts = [];
        foreach($this->posts as $post) {
            if($post['topic'] == $topic) {
                $topicPosts[] = $post;
            }
        }
        return $topicPosts;
    }

    // Function to view all users
    public function getAllUsers() {
        return $this->users;
    }
}
?>
```

<strong>Instructions</strong>

1. Debugging:

    - There are several bugs in this code. Identify and fix them.

    - Specifically, look for issues related to handling empty data, array indices, and ensuring consistency in the use of data structures.

    - Ensure that the functions return the correct responses for valid and invalid input.

2. Expected Behavior:

    - The <code>registerUser</code> function should add a user to the $users array only if both the username and email are non-empty.

    - The <code>createTopic</code> function should add a new topic to the $topics array.

    - The <code>createPost</code> function should add a post under a specific topic and ensure the user and topic exist before posting.

    - The <code>getPostsByTopic</code> function should return a list of posts for the given topic, or an error if the topic does not exist.

  ### PHP (Example Workflow):
  ```php
  $board = new DiscussionBoard();
  $board->registerUser('john_doe', 'john@example.com');
  $board->createTopic('PHP Programming');
  $board->createPost('john_doe', 'PHP Programming', 'This is my first post about PHP!');
  $board->createPost('john_doe', 'JavaScript Programming", "This is about JS, but no such topic exists.');
  $posts = $board->getPostsByTopic('PHP Programming');

  echo "Posts in 'PHP Programming' Topic:\n";
  foreach($posts as $post) {
      echo $post['user'] . ": " . $post['content'] . "\n";
  }
  ```

<strong>Tasks</strong>

1. Identify the problems in the code and explain how you would fix them.

2. Your goal is to make sure that the functions work correctly, handling both valid and invalid data appropriately.
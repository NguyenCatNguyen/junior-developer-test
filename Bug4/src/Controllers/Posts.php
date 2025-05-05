<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Database\DBConnection;
use PDOException;

final class Posts {
  private $renderer;

  public function __construct()
  {
    // Initialize template renderer for Slim views
    $this->renderer = new PhpRenderer('../templates');
  }

  // Render landing page with template
  public function landingPage(Request $request, Response $response): Response
  {
    return $this->renderer->render($response, 'template.php');
  }

  // Fetch all posts with their respective comments
  public function fetchPosts(Request $request, Response $response): Response
  {
    try {
      $pdo = new DBConnection();
      $pdo = $pdo->dbConnect();

      // SQL query returns flat rows combining posts and their comments
      $query = "SELECT posts.id AS post_id, posts.content AS post_content, posts.image_url, posts.created_at AS post_created_at,
                       users.username AS post_username,
                       comments.id AS comment_id, comments.comment_text, comments.created_at AS comment_created_at,
                       comment_users.username AS comment_username
                FROM posts
                LEFT JOIN users ON posts.user_id = users.id
                LEFT JOIN comments ON posts.id = comments.post_id
                LEFT JOIN users AS comment_users ON comments.user_id = comment_users.id
                ORDER BY posts.created_at DESC";

      $stmt = $pdo->prepare($query);
      $stmt->execute();
      $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      // FIX: Backend issue was returning flat list (multiple rows for same post)
      // SOLUTION: Group comments under each post by post_id

      $posts = [];

      foreach ($rows as $row) {
        $postId = $row['post_id'];

        // If post hasn't been added yet, initialize it
        if (!isset($posts[$postId])) {
          $posts[$postId] = [
            'post_id' => $row['post_id'],
            'post_content' => $row['post_content'],
            'image_url' => $row['image_url'],
            'post_created_at' => $row['post_created_at'],
            'post_username' => $row['post_username'],
            'comments' => []
          ];
        }

        // If comment exists for the row, add to comments array
        if (!empty($row['comment_id'])) {
          $posts[$postId]['comments'][] = [
            'comment_id' => $row['comment_id'],
            'comment_text' => $row['comment_text'],
            'comment_created_at' => $row['comment_created_at'],
            'comment_username' => $row['comment_username']
          ];
        }
      }

      // Encode grouped result as array
      $response->getBody()->write(json_encode(array_values($posts)));

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->withHeader('Access-Control-Allow-Origin', '*');

    } catch (PDOException $e) {
      // FIX: Catch block must return response to avoid Slim crash
      $response->getBody()->write(json_encode([
        'error' => true,
        'message' => $e->getMessage()
      ]));

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(500);
    }
  }
}

?>

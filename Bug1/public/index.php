<?php

use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';

// Create App
$app = AppFactory::create();

// Default route
$app->get('/', function ($request, $response) {
  $renderer = new PhpRenderer('../templates');
  
  $viewData = [
      'name' => 'John',
  ];
  
  return $renderer->render($response, 'template.php', $viewData);
})->setName('home');

// Form submission
$app->post('/submit', function ($request, $response) {
  // Get all POST parameters
  $data = (array)$request->getParsedBody();

  if ($data['name'] == "" || $data['email'] == "" || $data['message'] == "") {
    // BUG: invalid return type for Slim (not allowed null)
    $response->getBody()->write("All fields required."); // Write response to body so it can be returned correctly with Slim
    return $response; // Slim response can't be echoed directly
  }

  if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    // BUG: invalid return type for Slim (not allowed null)
    $response->getBody()->write("Invalid email format"); // Write response to body so it can be returned correctly with Slim
    return $response; // Slim response can't be echoed directly
  }

  $response->getBody()->write("Message sent! Thank you, {$data['name']}.");
  // BUG: missing {} for $data['name']
  return $response;
})->setName('submission');

$app->run();
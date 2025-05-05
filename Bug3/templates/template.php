<!DOCTYPE html>
<html>
<head>
  <title>Discussion Board</title>
</head>
<body>
<h2>Users:</h2>
  <?php echo "<pre>" . $users . "<pre/>"; ?>
  <h2>Topics:</h2>
  <?php echo "<pre>" . $topics . "<pre/>"; ?>
  <h2>Posts in 'PHP Programming' Topic:</h2>
  <?php if (is_array($posts) && !empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
      <div><?php echo htmlspecialchars($post['user']) . ": " . htmlspecialchars($post['content']) . "\n"; ?></div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No posts available for this topic.</p>
  <?php endif; ?>
</body>
</html>

<?php if (!empty($errors)): ?>
  <div style="color: red; border: 1px solid red; border-radius: 20px;">
    <ul>
      <?php foreach ($errors as $error): ?>
        <h3><?php echo htmlspecialchars($error); ?></h3>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
# Instructions
Please complete the following tasks. You are welcome to use whatever methods you prefer. Aside from your changes in the code, please remember to provide a brief explanation in your email with the bug # you chose and how you went about troubleshooting it.

I've included the <a href="https://www.slimframework.com/" target="_blank">SlimPHP</a> framework for convenience but you are not required to use it. If you wish to go this route, navigate to the public directory and launch the app using the following command. All files are stored in the public directory.

If you don't have composer installed, you will need to install if you wish to run the framework listed above. https://getcomposer.org/download/

```terminal
composer install

cd public/
php -S localhost:5000
```

## Bug #1
You’ve been given a simple contact form application that is not working correctly. Your task is to identify and fix the bugs so that:

- The form submits via AJAX

- The PHP processes the data and returns a success or error message

- Basic validation is enforced

- The user sees feedback without page reload

<br>

### HTML:
```html
<!DOCTYPE html>
<html>
<head>
  <title>Contact Us</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Contact Us</h1>
  <form id="contactForm">
    <input type="text" name="name" placeholder="Your Name"><br>
    <input type="email" name="email" placeholder="Your Email"><br>
    <textarea name="message" placeholder="Your Message"></textarea><br>
    <button type="submit">Send</button>
  </form>
  <div id="response"></div>

  <script src="app.js"></script>
</body>
</html>
```

### CSS (style.css):
```css
body { font-family: Arial; margin: 40px; }
input, textarea { display: block; margin-bottom: 10px; padding: 8px; width: 300px; }
#response { margin-top: 20px; color: green; }
```

### Javascript (app.js):
```javascript
document.getElementById('contactForm').onsubmit = function(event) {
  event.preventDefault();

  const formData = new FormData(document.getElementById('form'));

  fetch('submit.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    document.querySelector('#response').innerText = data;
  })
  .catch(error => {
    document.querySelector('#response').innerText = 'An error occurred.';
  });
};
```

### PHP (submit.php):
```php
<?php
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  if ($name == "" || $email == "" || $message == "") {
    echo "All fields required.";
    return;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
    return;
  }

  echo "Message sent! Thank you, $name.";
?>
```

<strong>Tasks:</strong>

Fix the issues so that:

1. The form submits via AJAX correctly.

2. PHP script validates and responds correctly.

3. Error handling is visible to the user.

4. Minor UI feedback (e.g., color change on error).

<br>
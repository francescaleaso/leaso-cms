<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="stylesheet" href="assets/css/form.css?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body>
    <form method="POST" action="login.php">
        <div class="top">
            <h2>LOG IN</h2>
        </div>

        <div class="input-div email">
          <input type="text" name="username" placeholder="Username" required></label><br>
          <span class="underline"></span>
        </div>
        <div class="input-div psw">
          <input type="password" name="password" placeholder="Password" required></label><br>
          <span class="underline"></span>
        </div>

        <button type="submit">Login</button>
            
      </form>
</body>
</html>

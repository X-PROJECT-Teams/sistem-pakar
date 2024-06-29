<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Hello world</h1>
  <h1>
    <?= isset($error) ? $error : "ga error" ?>
  </h1>
  <form action="/test/posting" method="POST">
    <input type="text" value="hello" name="nama">
    <button type="submit" class="">Login</button>
  </form>
</body>

</html>

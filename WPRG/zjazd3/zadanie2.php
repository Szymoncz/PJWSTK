<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $data = "$name | $email | $message\n";

    file_put_contents('data-set.txt', $data, FILE_APPEND);

    echo "<p>Dane zostały zapisane!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formularz Zapisu</title>
</head>
<body>
    <h2>Formularz Zapisu</h2>
    <form method="post">
        <label for="name">Imię:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="message">Wiadomość:</label><br>
        <textarea id="message" name="message" required></textarea><br><br>

        <button type="submit">Zapisz</button>
    </form>
</body>
</html>

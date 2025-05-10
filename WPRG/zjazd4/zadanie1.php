/*
Do zadania z rezerwacją hotelu (z warsztatu 2) dopisać użycie ciasteczek i sesji.
Ciasteczka: Formularz, który zostanie wypełniony, po wyłączeniu, następnie włączeniu przeglądarki ma się wczytać do stanu sprzed wyłączenia. Dodać też przycisk, który wyczyści formularz, czyli usunie ciasteczka. Ciasteczka mają mieć ustalona żywotność.
Sesje: wykorzystując mechanizm sesji dodać możliwość logowania. Dane do logowania mogą być "na sztywno" ustawione jako zmienne (formalna rejestracja i przechowanie kont użytkowników będzie do wykonania przy okazji zajęć z baz danych). Cały mechanizm ma działać następująco, po zalogowaniu uzyskuje się dostęp do formularza. Zalogowanie ma utworzyć sesje. Wylogowanie (należy dodać odpowiedni przycisk) ma wykluczyć możliwość korzystania z formularza rezerwacji, czyli bez zalogowania się = otwartej sesji, nie można uzyskać dostępu do formularza.

Po zalogowaniu przywitać użytkownika rozpoznając jego login, ale nie ten wcześniej ustawiony jako zmienna, tylko używając ciasteczek. 
W przypadku kiedy użytkownik jest niezalogowany, ma otrzymać informację o braku dostępu do tej części strony, gdzie można rezerwować hotel, a także informacje o tym, dlaczego nie może uzyskać tego dostępu (pytanie: dlaczego nie może uzyskać wspomnianego dostępu?).
*/

<?php
ob_start();
session_start();

$valid_username = "admin";
$valid_password = "password123";

if (isset($_POST['login'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        setcookie('last_username', $username, time() + (86400 * 30), "/");
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['clear_cookies'])) {
    $cookies = ['persons', 'name', 'surname', 'address', 'email', 'credit_card', 'date', 'time', 'extra_bed', 'amenities'];
    foreach ($cookies as $cookie) {
        setcookie($cookie, '', time() - 3600, "/");
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['persons'])) {
    setcookie('persons', isset($_POST['persons']) ? $_POST['persons'] : '', time() + 86400, "/");
    setcookie('name', isset($_POST['name']) ? $_POST['name'] : '', time() + 86400, "/");
    setcookie('surname', isset($_POST['surname']) ? $_POST['surname'] : '', time() + 86400, "/");
    setcookie('address', isset($_POST['address']) ? $_POST['address'] : '', time() + 86400, "/");
    setcookie('email', isset($_POST['email']) ? $_POST['email'] : '', time() + 86400, "/");
    setcookie('credit_card', isset($_POST['credit_card']) ? $_POST['credit_card'] : '', time() + 86400, "/");
    setcookie('date', isset($_POST['date']) ? $_POST['date'] : '', time() + 86400, "/");
    setcookie('time', isset($_POST['time']) ? $_POST['time'] : '', time() + 86400, "/");
    setcookie('extra_bed', isset($_POST['extra_bed']) ? 'on' : '', time() + 86400, "/");
    setcookie('amenities', isset($_POST['amenities']) ? implode(',', $_POST['amenities']) : '', time() + 86400, "/");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rezerwacja Hotelu</title>
</head>
<body>
<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $welcome_name = isset($_COOKIE['last_username']) ? htmlspecialchars($_COOKIE['last_username']) : $_SESSION['username'];
    echo "<h2>Witaj, $welcome_name!</h2>";
    echo '<form method="post"><button type="submit" name="logout">Wyloguj</button></form>';

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['persons'])) {
        echo "<h3>Podsumowanie rezerwacji:</h3>";
        echo "<p>Osoby: " . htmlspecialchars($_POST['persons'] ?? '') . "</p>";
        echo "<p>Imię: " . htmlspecialchars($_POST['name'] ?? '') . "</p>";
        echo "<p>Nazwisko: " . htmlspecialchars($_POST['surname'] ?? '') . "</p>";
        echo "<p>Adres: " . htmlspecialchars($_POST['address'] ?? '') . "</p>";
        echo "<p>Email: " . htmlspecialchars($_POST['email'] ?? '') . "</p>";
        echo "<p>Data pobytu: " . htmlspecialchars($_POST['date'] ?? '') . "</p>";
        echo "<p>Godzina przyjazdu: " . htmlspecialchars($_POST['time'] ?? '') . "</p>";
        echo "<p>Dostawka dla dziecka: " . (isset($_POST['extra_bed']) ? "Tak" : "Nie") . "</p>";
        echo "<p>Udogodnienia: " . htmlspecialchars(implode(", ", $_POST['amenities'] ?? [])) . "</p>";
    }

    ?>
    <h2>Rezerwacja Hotelu</h2>
    <form method="post">
        <label>Ilość osób:</label>
        <select name="persons" id="persons">
            <option value="1" <?php echo (isset($_COOKIE['persons']) && $_COOKIE['persons'] == '1') ? 'selected' : ''; ?>>1</option>
            <option value="2" <?php echo (isset($_COOKIE['persons']) && $_COOKIE['persons'] == '2') ? 'selected' : ''; ?>>2</option>
            <option value="3" <?php echo (isset($_COOKIE['persons']) && $_COOKIE['persons'] == '3') ? 'selected' : ''; ?>>3</option>
            <option value="4" <?php echo (isset($_COOKIE['persons']) && $_COOKIE['persons'] == '4') ? 'selected' : ''; ?>>4</option>
        </select><br>
        <label>Imię:</label> <input type="text" name="name" value="<?php echo isset($_COOKIE['name']) ? htmlspecialchars($_COOKIE['name']) : ''; ?>" required><br>
        <label>Nazwisko:</label> <input type="text" name="surname" value="<?php echo isset($_COOKIE['surname']) ? htmlspecialchars($_COOKIE['surname']) : ''; ?>" required><br>
        <label>Adres:</label> <input type="text" name="address" value="<?php echo isset($_COOKIE['address']) ? htmlspecialchars($_COOKIE['address']) : ''; ?>" required><br>
        <label>Email:</label> <input type="email" name="email" value="<?php echo isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : ''; ?>" required><br>
        <label>Karta kredytowa:</label> <input type="text" name="credit_card" value="<?php echo isset($_COOKIE['credit_card']) ? htmlspecialchars($_COOKIE['credit_card']) : ''; ?>" required><br>
        <label>Data pobytu:</label> <input type="date" name="date" value="<?php echo isset($_COOKIE['date']) ? htmlspecialchars($_COOKIE['date']) : ''; ?>" required><br>
        <label>Godzina przyjazdu:</label> <input type="time" name="time" value="<?php echo isset($_COOKIE['time']) ? htmlspecialchars($_COOKIE['time']) : ''; ?>" required><br>
        <label>Dostawka dla dziecka:</label> <input type="checkbox" name="extra_bed" <?php echo (isset($_COOKIE['extra_bed']) && $_COOKIE['extra_bed'] == 'on') ? 'checked' : ''; ?>><br>
        <label>Udogodnienia:</label> <br>
        <?php
        $saved_amenities = isset($_COOKIE['amenities']) ? explode(',', $_COOKIE['amenities']) : [];
        ?>
        <input type="checkbox" name="amenities[]" value="Klimatyzacja" <?php echo in_array('Klimatyzacja', $saved_amenities) ? 'checked' : ''; ?>> Klimatyzacja<br>
        <input type="checkbox" name="amenities[]" value="Popielniczka" <?php echo in_array('Popielniczka', $saved_amenities) ? 'checked' : ''; ?>> Popielniczka dla palacza<br>
        <button type="submit">Zarezerwuj</button>
    </form>
    <form method="post">
        <button type="submit" name="clear_cookies">Wyczyść formularz</button>
    </form>
    <?php
} else {
    echo "<h2>Brak dostępu</h2>";
    echo "<p>Nie możesz uzyskać dostępu do formularza rezerwacji, ponieważ nie jesteś zalogowany. Proszę zaloguj się, aby kontynuować.</p>";
    ?>
    <h2>Logowanie</h2>
    <form method="post">
        <label>Login:</label> <input type="text" name="username" value="<?php echo isset($_COOKIE['last_username']) ? htmlspecialchars($_COOKIE['last_username']) : ''; ?>" required><br>
        <label>Hasło:</label> <input type="password" name="password" required><br>
        <button type="submit" name="login">Zaloguj</button>
    </form>
    <?php
}
ob_end_flush();
?>

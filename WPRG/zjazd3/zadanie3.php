<?php
$csvFile = 'reservations.csv';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $guests = $_POST['guests'];

    $data = [$name, $email, $date, $guests];

    if (!file_exists($csvFile)) {
        $headers = ['Imię', 'Email', 'Data', 'Liczba Gości'];
        $file = fopen($csvFile, 'w');
        fputcsv($file, $headers, ';', '"', '\\');
        fclose($file);
    }

    $file = fopen($csvFile, 'a');
    fputcsv($file, $data, ';', '"', '\\');
    fclose($file);

    echo "<p>Rezerwacja została zapisana!</p>";
}

$reservations = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['load'])) {
    if (file_exists($csvFile)) {
        $file = fopen($csvFile, 'r');
        $reservations = [];
        while (($row = fgetcsv($file, 0, ';', '"', '\\')) !== false) {
            $reservations[] = $row;
        }
        fclose($file);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>System Rezerwacji</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h2>Formularz Rezerwacji</h2>
    <form method="post">
        <label for="name">Imię:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="date">Data:</label><br>
        <input type="date" id="date" name="date" required><br><br>

        <label for="guests">Liczba Gości:</label><br>
        <input type="number" id="guests" name="guests" min="1" required><br><br>

        <button type="submit" name="submit">Zapisz Rezerwację</button>
        <button type="submit" name="load">Wczytaj</button>
    </form>

    <?php if (!empty($reservations)): ?>
        <h2>Zapisane Rezerwacje</h2>
        <table>
            <?php foreach ($reservations as $index => $reservation): ?>
                <tr>
                    <?php foreach ($reservation as $value): ?>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>

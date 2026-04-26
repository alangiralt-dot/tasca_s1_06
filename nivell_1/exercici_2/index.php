<?php
declare(strict_types=1);
session_start();
$shouldShow = false;
$errorMessage = '';
if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["user_name"]) &&
    isset($_POST["password"]) &&
    isset($_POST["language"]) &&
    isset($_POST["mode"])
) {
    $_SESSION["language"] = $_POST["language"];
    $_SESSION["mode"] = $_POST["mode"];
    $shouldShow = true;
} else {
    $errorMessage =
        '<div class="error-wrapper"><h3>Error</h3>' .
        'At least one key of the form was not found in $_POST<br>' .
        'in ' . __FILE__ . ':' . __LINE__ . '</div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>S1 T6 N1 E1</title>
</head>
<body>
    <main>
    <div id="table-container">
        <table>
            <tr><th colspan=2>$_POST</th></tr>
            <tr><th>KEY</th><th>VALUE</th></tr>
            <?php
                if ($shouldShow) {
                    foreach ($_POST as $key => $value) {
                        echo "<tr><td>" . htmlspecialchars($key) . "</td><td>" . htmlspecialchars($value) . "</td></tr>";
                    }
                }
            ?>
        </table>
        <table>
            <tr><th colspan=2>$_SESSION</th></tr>
            <tr><th>KEY</th><th>VALUE</th></tr>
            <?php
                if ($shouldShow) {
                    foreach ($_SESSION as $key => $value) {
                        echo "<tr><td>" . htmlspecialchars($key) . "</td><td>" . htmlspecialchars($value) . "</td></tr>";
                    }
                }
            ?>
        </table>
    </div>
    <?php if (!$shouldShow) echo $errorMessage;?>
    </main>
    <footer>
    <div class="link-container"><a href="index.html">GO BACK</a></div>
    </footer>
</body>
</html>
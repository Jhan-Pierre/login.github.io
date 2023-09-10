<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$userName = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/dash.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Bienvenido, <?php echo $userName; ?>!</h2>
        <!-- Otro contenido de tu panel de control aquí -->
        <p><a href="logout.php" class="logout-button">Cerrar sesión</a></p>
    </div>
</body>
</html>




<?php
session_start();
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $sql = "SELECT id, correo, password, nombre FROM usuarios WHERE correo = ?";
    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $correo);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $dbCorreo, $dbPassword, $nombreDelUsuario);
                $stmt->fetch();
                if (password_verify($password, $dbPassword)) {
                    $_SESSION['user_name'] = $nombreDelUsuario;
                    $_SESSION['user_id'] = $id;
                    header("Location: home.php");
                    exit;
                } else {
                    $error_message = '<span style="color: red;">Credenciales incorrectas.</span>';
                }
            } else {
                $error_message = '<span style="color: red;">Credenciales incorrectas.</span>';
            }
        } else {
            $error_message = '<span style="color: red;">Error en la consulta: ' . $stmt->error . '</span>';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión-Venator</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container">
        <div class="logo-description">
            <img src="img/Venator.png" alt="Logo de tu sitio">
            <p class="description">Somos Líderes en la Industria de Prendas de Punto</p>
        </div>
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?>
            <form method="post">
                <input type="email" id="correo" name="correo" placeholder="Correo Electrónico" required><br>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    <button type="button" id="showPasswordBtn" class="show-password-btn">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <input type="submit" value="Iniciar Sesión">
            </form>
            <p>¿No tienes una cuenta? <a class="create-account" href="registro.php">Regístrate</a></p>
        </div>
    </div> 
</body>
</html>
<?php
session_start();
include("includes/db.php");

$nombre = "";
$apellido = "";
$sexo = "";
$telefono = "";
$correo = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $sexo = $_POST['sexo'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
        $error_message = '<span style="color: red;">La contraseña solo debe contener letras y números.</span>';
    } else {
        $hashContrasena = password_hash($password, PASSWORD_DEFAULT);
        $sql_verificar_correo = "SELECT correo FROM usuarios WHERE correo = ?";

        if ($stmt_verificar = $mysqli->prepare($sql_verificar_correo)) {
            $stmt_verificar->bind_param("s", $correo);
            $stmt_verificar->execute();
            $stmt_verificar->store_result();

            if ($stmt_verificar->num_rows > 0) {
                $error_message = '<span style="color: red;">El correo electrónico ya está en uso.</span>';
            } else {
                $sql_insertar = "INSERT INTO usuarios (nombre, apellido, sexo, telefono, correo, password) VALUES (?, ?, ?, ?, ?, ?)";

                if ($stmt_insertar = $mysqli->prepare($sql_insertar)) {
                    $stmt_insertar->bind_param("ssssss", $nombre, $apellido, $sexo, $telefono, $correo, $hashContrasena);

                    if ($stmt_insertar->execute()) {
                        header("Location: index.php");
                        exit;
                    } else {
                        $error_message = '<span style="color: red;">Error en la consulta: ' . $stmt_insertar->error . '</span>';
                    }
                    $stmt_insertar->close();
                }
            }
            $stmt_verificar->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container">
        <div class="logo-description">
            <img src="img/Venator.png" alt="Logo de tu sitio">
            <p class="description">Somos Líderes en la Industria de Prendas de Punto</p>
        </div>
        <div class="login-box">
            <h2>Registro de Usuario</h2>
            <?php if (!empty($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
            <form method="post">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre Completo" value="<?php echo $nombre; ?>" required><br>
                <input type="text" id="apellido" name="apellido" placeholder="Apellido Completo" value="<?php echo $apellido; ?>" required><br>
                <input type="text" id="sexo" name="sexo" placeholder="Sexo (M-F)" value="<?php echo $sexo; ?>" required><br>
                <input type="text" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>" required><br>
                <input type="email" id="correo" name="correo" placeholder="Correo Electrónico (Nombre de usuario)" value="<?php echo $correo; ?>" required><br>
                <div class="password-input-container">
                    <input type="text" id="password" name="password" placeholder="Contraseña" required>
                    <button type="button" id="showPasswordBtn" class="show-password-btn">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <input type="submit" value="Registrarse">
                <a href="index.php" class="return-button">Regresar</a>
            </form>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Monitor | Login">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vota y Opina | Iniciar Sesión</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/style.css') ?>">

    <style>
        body {
            background-image: url('<?= base_url('recursos_publicos/img/carrucel/fondo.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Nunito Sans', sans-serif;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-container {
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 4px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            text-align: left;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .login-container h1 {
            color: #fff;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 28px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: none;
        }

        .form-control {
            background-color: white;
            border: none;
            border-radius: 4px;
            color: black;
            padding: 16px 20px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            outline: none;
        }

        .form-control::placeholder {
            color: black;
        }

        .form-control:focus {
            background-color: white;
        }

        .login-btn {
            background-color: #e50914;
            color: #fff;
            border: none;
            text-align: center;
            border-radius: 4px;
            padding: 16px 20px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 24px;
        }

        .login-btn:hover {
            background-color: #c40812;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 14px;
            color: #b3b3b3;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 5px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .help-link {
            color: #b3b3b3;
            text-decoration: none;
        }

        .help-link:hover {
            text-decoration: underline;
        }

        .signup-section {
            margin-top: 40px;
            color: #8c8c8c;
            font-size: 16px;
        }

        .signup-section a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-section a:hover {
            text-decoration: underline;
        }

        .return-btn {
            background-color: white;
            color: black;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .return-btn:hover {
            background-color: red;
        }

        .error-message {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <form action="<?= base_url('login/procesar') ?>" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="login-btn">Ingresar</button>

            <div class="form-options">
                <div class="remember-me">
                    </div>
                </div>

            </form>
    </div>

    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/bootstrap.min.js') ?>"></script>
</body>
</html>

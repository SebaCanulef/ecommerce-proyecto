<?php
require_once 'models/User.php';

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    // Mostrar y procesar el formulario de login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $user = $this->user->login($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;

                // Redirigir según el rol
                if (isset($user['role']) && $user['role'] === 'admin') {
                    header('Location: /ecommerce/index.php?controller=admin&action=index');
                } else {
                    header('Location: /ecommerce/index.php');
                }

                exit;
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        }
        require_once 'views/auth/login.php';
    }

    // Mostrar y procesar el formulario de registro
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            if ($this->user->register($username, $email, $password)) {
                header('Location: /ecommerce/index.php?controller=user&action=login');
                exit;
            } else {
                $error = "Error al registrar. El usuario o email ya existe.";
            }
        }
        require_once 'views/auth/register.php';
    }

    // Cerrar sesión
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /ecommerce/index.php');
        exit;
    }
}

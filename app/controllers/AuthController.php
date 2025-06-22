<?php
require_once('app/config/database.php');
require_once('app/models/UserModel.php');

class AuthController
{
    private $userModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    // Hiển thị form đăng ký
    public function register()
    {
        include_once 'app/views/auth/register.php';
    }

    // Hiển thị form đăng nhập
    public function login()
    {
        include_once 'app/views/auth/login.php';
    }

    // Lưu tài khoản mới
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            if (empty($username)) $errors['username'] = "Vui lòng nhập username!";
            if (empty($email)) $errors['email'] = "Vui lòng nhập email!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập password!";
            if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";

            if ($this->userModel->getByUsername($username)) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }
            if (count($errors) > 0) {
                include_once 'app/views/auth/register.php';
            } else {
                $result = $this->userModel->addUser(
                    $username,
                    password_hash($password, PASSWORD_DEFAULT),
                    $email
                );
                if ($result) {
                    header('Location: /project-esports/auth/login');
                    exit;
                }
            }
        }
    }

    // Đăng xuất
    public function logout()
    {
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['is_admin']);
        header('Location: /project-esports');
        exit;
    }

    // Kiểm tra đăng nhập
    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $this->userModel->getByUsername($username);
            if ($user && password_verify($password, $user->PasswordHash)) {
                session_start();
                $_SESSION['user_id'] = $user->UserID;
                $_SESSION['is_admin'] = $user->IsAdmin ?? 0;
                header('Location: /project-esports');
                exit;
            } else {
                $error = $user ? "Mật khẩu không đúng!" : "Không tìm thấy tài khoản!";
                include_once 'app/views/auth/login.php';
                exit;
            }
        }
    }
}
?>
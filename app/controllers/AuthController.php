<?php
require_once 'app/config/database.php';
require_once 'app/models/UserModel.php';
require_once 'app/helpers/SessionHelper.php';

class AuthController
{
    private $userModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    public function register()
    {
        SessionHelper::start(); // Khởi tạo session
        include_once 'app/views/auth/register.php';
    }

    public function login()
    {
        SessionHelper::start(); // Khởi tạo session
        include_once 'app/views/auth/login.php';
    }

    public function save()
    {
        SessionHelper::start(); // Đảm bảo session được khởi tạo
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
                    $email,
                    'user' // Giá trị mặc định cho Role
                );
                if ($result) {
                    header('Location: /project-esports/auth/login');
                    exit;
                } else {
                    $errors['db'] = "Đã xảy ra lỗi khi lưu tài khoản!";
                    include_once 'app/views/auth/register.php';
                }
            }
        }
    }

    public function logout()
    {
        SessionHelper::start();
        SessionHelper::clearUser();
        header('Location: /project-esports');
        exit;
    }

    public function checkLogin()
{
    // Thêm thông báo log ở đầu hàm để kiểm tra xem hàm có được gọi không
    error_log("Debug: checkLogin() method called at " . date('Y-m-d H:i:s'));

    SessionHelper::start(); // Khởi tạo session trước khi xử lý
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // In thông tin đầu vào vào log
        error_log("Debug: Username = $username, Password = $password");

        $user = $this->userModel->getByUsername($username);

        // In thông tin người dùng tìm thấy
        error_log("Debug: User found = " . ($user ? json_encode($user) : 'null'));

        if ($user && password_verify($password, $user->PasswordHash)) {
            SessionHelper::set('user_id', $user->UserID);
            SessionHelper::set('is_admin', $user->Role === 'admin' ? 1 : 0);
            SessionHelper::set('username', $user->Username); // Thêm dòng này

            // In thông tin session sau khi lưu
            error_log("Debug: Session set - user_id = " . SessionHelper::get('user_id') . ", is_admin = " . SessionHelper::get('is_admin'));

            header('Location: /project-esports');
            exit;
        } else {
            $error = $user ? "Mật khẩu không đúng!" : "Không tìm thấy tài khoản!";
            error_log("Debug: Login failed - Error = $error");

            include_once 'app/views/auth/login.php';
            exit;
        }
    }
    error_log("Debug: Not a POST request, redirecting to login");
    header('Location: /project-esports/auth/login'); // Nếu không phải POST, chuyển về form login
}
}

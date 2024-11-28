<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Tải PHPMailer
require_once "src/func/database.php"; // Kết nối cơ sở dữ liệu

$db = new database();
$conn = $db->conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['send_code'])) {
        // Gửi mã xác nhận
        $email = $_POST['email'] ?? '';

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p class='error'>Please enter a valid email address.</p>";
        } else {
            // Tạo mã xác nhận
            $verification_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

            // Lưu mã xác nhận vào cơ sở dữ liệu (hoặc cập nhật nếu đã tồn tại email)
            $query = "INSERT INTO users (email, verification_code, email_verified) VALUES (?, ?, FALSE)
                      ON DUPLICATE KEY UPDATE verification_code = ?, email_verified = FALSE";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $email, $verification_code, $verification_code);

            if ($stmt->execute()) {
                sendVerificationEmail($email, $verification_code);
                echo "<p class='success'>A verification code has been sent to your email.</p>";
                echo '<form method="POST" action="">
                        <label for="code">Enter verification code:</label>
                        <input type="text" id="code" name="code" required>
                        <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                        <button type="submit" name="verify">Verify</button>
                      </form>';
            } else {
                echo "<p class='error'>Error: Unable to send verification code.</p>";
            }
        }
    } elseif (isset($_POST['verify'])) {
        // Xác minh mã xác nhận
        $email = $_POST['email'] ?? '';
        $code = $_POST['code'] ?? '';

        $query = "SELECT verification_code FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($stored_code);
        $stmt->fetch();
        $stmt->close();

        if ($stored_code === $code) {
            // Cập nhật trạng thái email_verified
            $updateQuery = "UPDATE users SET email_verified = TRUE WHERE email = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                echo "<p class='success'>Email successfully verified!</p>";
                echo '<form method="POST" action="">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>
                        <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                        <button type="submit" name="register">Create Account</button>
                      </form>';
            } else {
                echo "<p class='error'>Error: Unable to verify email.</p>";
            }
        } else {
            echo "<p class='error'>Invalid verification code.</p>";
        }
    } elseif (isset($_POST['register'])) {
        // Đăng ký tài khoản
        $email = $_POST['email'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm-password'] ?? '';

        if (empty($username) || empty($password) || empty($confirm_password)) {
            echo "<p class='error'>Please fill in all fields.</p>";
        } elseif (strlen($password) < 8 || strlen($password) > 20) {
            echo "<p class='error'>Password must be between 8 and 20 characters.</p>";
        } elseif ($password !== $confirm_password) {
            echo "<p class='error'>Passwords do not match.</p>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $created_date = date('Y-m-d');

            $insertQuery = "UPDATE users SET username = ?, password = ?, created_date = ? WHERE email = ?";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $username, $hashed_password, $created_date, $email);

            if ($stmt->execute()) {
                echo "<p class='success'>Account created successfully!</p>";
            } else {
                echo "<p class='error'>Error: Unable to create account.</p>";
            }
        }
    }
}

function sendVerificationEmail($email, $code)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server (vd: smtp.gmail.com)
        $mail->SMTPAuth = true;
        $mail->Username = 'contact.mediascout@gmail.com'; // Email gửi đi
        $mail->Password = 'dwhkzybikaytvcxu'; // Mật khẩu ứng dụng
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Mã hóa TLS
        $mail->Port = 587; // Cổng SMTP (TLS thường là 587)

        // Cài đặt email
        $mail->setFrom('contact.mediascout@gmail.com', 'MediaScout');
        $mail->addAddress($email); // Email người nhận

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body    = "Your verification code is: <strong>{$code}</strong>";

        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

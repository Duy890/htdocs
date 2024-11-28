<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="/public/styles/register.css">
    <link rel="icon" href="../../../public/icon.ico" type="image/x-icon">
    <script>
        let countdown;
        let resendButton;
        let verificationCodeSent = false;

        function startCountdown() {
            let timeLeft = 60;
            resendButton.disabled = true;
            resendButton.innerText = `Resend in ${timeLeft}s`;
            countdown = setInterval(function () {
                timeLeft--;
                resendButton.innerText = `Resend in ${timeLeft}s`;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    resendButton.disabled = false;
                    resendButton.innerText = "Resend Code";
                }
            }, 1000);
        }

        function onSendCode() {
            // Kiểm tra người dùng đã nhập đầy đủ thông tin chưa
            const email = document.getElementById('email').value;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (email === '' || username === '' || password === '' || confirmPassword === '') {
                alert("Please fill in all the fields.");
                return;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return;
            }

            verificationCodeSent = true;
            startCountdown();
            // Gửi mã xác nhận (gửi yêu cầu POST qua Ajax hoặc form submit)
            // Sau khi gửi mã thành công, cập nhật giao diện
        }

        window.onload = function () {
            resendButton = document.getElementById("resendButton");
            resendButton.addEventListener("click", onSendCode);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Start Using MediaScout</h2>
        <hr>
        <form method="POST" action="/register">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">

            <label for="username">Username</label>
            <input type="text" id="username" name="username">

            <label for="password">Password</label>
            <input type="password" id="password" name="password">

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password">

            <label><input type="checkbox" id="showPassword"> Show Password</label>
                     <!-- Form nhập mã xác nhận -->
            <form method="POST" action="">
              <label for="code">Enter verification code:</label>
              <input type="text" id="code" name="code" required>
              <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
              <button type="submit" name="verify">Verify</button>
              <button type="button" id="resendButton">Send Code</button> <!-- Nút gửi mã xác nhận -->
            </form>
            <button type="submit" name="submit" class="create-account-button">Create Account</button>
        </form>



        <p>Already have an account? <a href="/login">Login</a></p>
    </div>
</body>
</html>

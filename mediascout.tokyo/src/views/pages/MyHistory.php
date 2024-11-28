<?php
require_once "src/func/database.php";

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['UID'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Lấy ID người dùng từ session
$userId = $_SESSION['UID'];

// Lấy dữ liệu lịch sử anime từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT anime_id, anime_title, anime_image FROM anime_history WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Đóng statement
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime History</title>
    <link rel="stylesheet" href="view-more-anime.css"> <!-- Liên kết đến file CSS -->
</head>
<body>
    <h2>Your Anime History</h2>
    <div class="anime-list-section">
        <div class="anime-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="anime-item">
                    <a href="/anime/info/<?php echo $row['anime_id']; ?>">
                        <img src="<?php echo $row['anime_image']; ?>" alt="<?php echo $row['anime_title']; ?>">
                        <div class="anime-info">
                            <h3><?php echo $row['anime_title']; ?></h3>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div id="pagination">
        <!-- Thêm nút phân trang nếu cần -->
        <button class="prev" disabled>Previous</button>
        <button class="next">Next</button>
    </div>
    <script src="/assets/scripts/getid.js"></script>
</body>
</html>
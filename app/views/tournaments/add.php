<?php include 'app/views/shares/header.php'; ?>
<h1>Thêm giải đấu mới</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/project-esports/Tournament/save">
    <div class="form-group">
        <label for="name">Tên giải đấu:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="region">Khu vực:</label>
        <input type="text" id="region" name="region" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="startDate">Ngày bắt đầu:</label>
        <input type="date" id="startDate" name="startDate" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="endDate">Ngày kết thúc:</label>
        <input type="date" id="endDate" name="endDate" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="status">Trạng thái:</label>
        <input type="text" id="status" name="status" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Thêm giải đấu</button>
</form>
<a href="/project-esports/Tournament/list" class="btn btn-secondary mt-2">Quay lại danh sách giải đấu</a>
<?php include 'app/views/shares/footer.php'; ?>
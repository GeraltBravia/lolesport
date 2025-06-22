<?php include 'app/views/shares/header.php'; ?>
<h1>Thêm tin tức mới</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/project-esports/News/save">
    <div class="form-group">
        <label for="title">Tiêu đề:</label>
        <input type="text" id="title" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="content">Nội dung:</label>
        <textarea id="content" name="content" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="publishDate">Ngày đăng:</label>
        <input type="date" id="publishDate" name="publishDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <button type="submit" class="btn btn-primary">Thêm tin tức</button>
</form>
<a href="/project-esports/News/list" class="btn btn-secondary mt-2">Quay lại danh sách tin tức</a>
<?php include 'app/views/shares/footer.php'; ?>
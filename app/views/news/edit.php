<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4">Chỉnh sửa tin tức</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/project-esports/news/update">
        <input type="hidden" name="NewsID" value="<?php echo htmlspecialchars($news->NewsID); ?>">
        <div class="mb-3">
            <label for="Title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" id="Title" name="Title" required
                   value="<?php echo htmlspecialchars($news->Title); ?>">
        </div>
        <div class="mb-3">
            <label for="Content" class="form-label">Nội dung</label>
            <textarea class="form-control" id="Content" name="Content" rows="6" required><?php echo htmlspecialchars($news->Content); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="Author" class="form-label">Tác giả</label>
            <input type="text" class="form-control" id="Author" name="Author"
                   value="<?php echo htmlspecialchars($news->Author); ?>">
        </div>
        <div class="mb-3">
            <label for="PublishedDate" class="form-label">Ngày đăng</label>
            <input type="date" class="form-control" id="PublishedDate" name="PublishedDate"
                   value="<?php echo htmlspecialchars($news->PublishedDate); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="/project-esports/news/list" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php include 'app/views/shares/footer.php'; ?>
<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Chi tiết đội</h2>
        </div>
        <div class="card-body">
            <?php if  (is_object($team)): ?>
                <h3 class="card-title text-dark font-weight-bold">
                    <?php echo htmlspecialchars($team->Name, ENT_QUOTES, 'UTF-8'); ?>
                </h3>
                <p><strong>Khu vực:</strong> <?php echo htmlspecialchars($team->Region, ENT_QUOTES, 'UTF-8'); ?></p>
                <a href="/project-esports/Team/list" class="btn btn-secondary mt-2">Quay lại danh sách</a>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                    <h4>Không tìm thấy đội!</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
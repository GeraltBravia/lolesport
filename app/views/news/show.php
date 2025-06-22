<?php
 
include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Chi tiết Tin tức</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($news)): ?>
                <h3 class="card-title"><?php echo htmlspecialchars($news->Title); ?></h3>
                <p><strong>Ngày đăng:</strong> <?php echo htmlspecialchars($news->PublishDate ?? ''); ?></p>
                <p><strong>Tác giả:</strong> <?php echo htmlspecialchars($news->Author ?? ''); ?></p>
                <p><?php echo nl2br(htmlspecialchars($news->Content)); ?></p>
                <?php if (!empty($news->TournamentName)): ?>
                    <p><strong>Giải đấu:</strong> <?php echo htmlspecialchars($news->TournamentName); ?></p>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                    <h4>Không tìm thấy tin tức!</h4>
                </div>
            <?php endif; ?>
            <a href="/project-esports/news/list" class="btn btn-secondary mt-3">Quay lại danh sách</a>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php';
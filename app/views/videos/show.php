<?php

include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Chi tiết Video</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($video)): ?>
                <h3 class="card-title"><?php echo htmlspecialchars($video->Title); ?></h3>
                <p><strong>Ngày đăng:</strong> <?php echo htmlspecialchars($video->UploadDate ?? ''); ?></p>
                <p>
                    <a href="<?php echo htmlspecialchars($video->URL); ?>" target="_blank" class="btn btn-success">
                        Xem Video
                    </a>
                </p>
                <?php if (!empty($video->MatchDate)): ?>
                    <p><strong>Trận đấu:</strong> <?php echo htmlspecialchars($video->Team1Name . ' vs ' . $video->Team2Name); ?></p>
                    <p><strong>Ngày thi đấu:</strong> <?php echo htmlspecialchars($video->MatchDate); ?></p>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                    <h4>Không tìm thấy video!</h4>
                </div>
            <?php endif; ?>
            <a href="/project-esports/video/list" class="btn btn-secondary mt-3">Quay lại danh sách</a>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
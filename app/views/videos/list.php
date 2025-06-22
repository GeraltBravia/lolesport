<?php

include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <h1 class="fw-bold mb-4">Danh sách Video</h1>
    <div class="row">
        <?php if (!empty($videos)): ?>
            <?php foreach ($videos as $video): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="/project-esports/video/show/<?php echo $video->VideoID; ?>" class="text-decoration-none text-primary">
                                    <?php echo htmlspecialchars($video->Title); ?>
                                </a>
                            </h5>
                            <p class="card-text">
                                <small class="text-muted">Ngày đăng: <?php echo htmlspecialchars($video->UploadDate ?? ''); ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Không có video nào.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
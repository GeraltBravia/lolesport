<?php
 
include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <h1 class="fw-bold mb-4">Danh sách Tin tức</h1>
    <div class="row">
        <?php if (!empty($newsList)): ?>
            <?php foreach ($newsList as $news): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="/project-esports/news/show/<?php echo $news->NewsID; ?>" class="text-decoration-none text-primary">
                                    <?php echo htmlspecialchars($news->Title); ?>
                                </a>
                            </h5>
                            <p class="card-text">
                                <?php echo htmlspecialchars(mb_substr($news->Content, 0, 100)); ?>...
                            </p>
                            <p class="card-text">
                                <small class="text-muted">Ngày đăng: <?php echo htmlspecialchars($news->PublishDate ?? ''); ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Không có tin tức nào.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
<?php

include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Chi tiết trận đấu</h2>
        </div>
        <div class="card-body">
            <?php if (is_object($match)): ?>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title text-dark font-weight-bold">
                            <?php echo htmlspecialchars($match->Team1Name ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            vs
                            <?php echo htmlspecialchars($match->Team2Name ?? '', ENT_QUOTES, 'UTF-8'); ?>
                        </h3>
                        <p><strong>Ngày thi đấu:</strong> <?php echo htmlspecialchars($match->MatchDate ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Kết quả:</strong> <?php echo htmlspecialchars($match->Result ?? 'Chưa có', ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Giải đấu:</strong> <?php echo htmlspecialchars($match->TournamentName ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                        <a href="/project-esports/match/list" class="btn btn-secondary mt-2">Quay lại danh sách</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                    <h4>Không tìm thấy trận đấu!</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
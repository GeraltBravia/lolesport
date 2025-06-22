<?php include 'app/views/shares/header.php'; ?>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Thông tin đội: <?php echo htmlspecialchars($team['Name'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text">Region: <?php echo htmlspecialchars($team['Region'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php
                require_once 'app/models/TeamModel.php';
                $logoUrl = TeamModel::image($team['LogoURL']);
                if ($logoUrl): ?>
                    <img src="<?php echo htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid rounded" width="100">
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
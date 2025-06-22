<?php include 'app/views/shares/header.php'; ?>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Thông tin đội: <?php echo $team['Name']; ?></h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text">Region: <?php echo $team['Region']; ?></p>
                <?php if ($team['LogoURL']): ?><img src="<?php echo $team['LogoURL']; ?>" class="img-fluid rounded" width="100"><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
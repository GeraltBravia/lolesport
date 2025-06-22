<?php include 'app/views/shares/header.php'; ?>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Chi tiết trận đấu</h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text">Match ID: <?php echo $match['MatchID']; ?></p>
                <p class="card-text">Team 1 vs Team 2: <?php echo $match['Score']; ?></p>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
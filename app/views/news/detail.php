<?php include 'app/views/shares/header.php'; ?>
<div class="row">
    <div class="col-12">
        <h1 class="mb-4"><?php echo $news['Title']; ?></h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text"><?php echo $news['Content']; ?></p>
                <p class="card-text"><small class="text-muted">Published: <?php echo $news['PublishDate']; ?></small></p>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
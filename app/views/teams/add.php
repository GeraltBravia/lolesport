<?php include 'app/views/shares/header.php'; ?>
<h1>Thêm đội mới</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/project-esports/Team/save" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Tên đội:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="region">Khu vực:</label>
        <input type="text" id="region" name="region" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="logoURL">Logo (chọn ảnh):</label>
        <input type="file" id="logoURL" name="logoURL" class="form-control" accept="image/*">
    </div>
    <div class="form-group">
        <label for="tournamentId">Giải đấu:</label>
        <select id="tournamentId" name="tournamentId" class="form-control" required>
            <?php foreach ($tournaments as $tournament): ?>
                <option value="<?php echo $tournament->TournamentID; ?>">
                    <?php echo htmlspecialchars($tournament->Name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Thêm đội</button>
</form>
<a href="/project-esports/Team/list" class="btn btn-secondary mt-2">Quay lại danh sách đội</a>
<?php include 'app/views/shares/footer.php'; ?>
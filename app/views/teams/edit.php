<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4">Chỉnh sửa đội tuyển</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/project-esports/team/update">
        <input type="hidden" name="TeamID" value="<?php echo htmlspecialchars($team->TeamID); ?>">
        <div class="mb-3">
            <label for="Name" class="form-label">Tên đội</label>
            <input type="text" class="form-control" id="Name" name="Name" required
                   value="<?php echo htmlspecialchars($team->Name); ?>">
        </div>
        <div class="mb-3">
            <label for="Region" class="form-label">Khu vực</label>
            <input type="text" class="form-control" id="Region" name="Region"
                   value="<?php echo htmlspecialchars($team->Region); ?>">
        </div>
        <div class="mb-3">
            <label for="LogoURL" class="form-label">Logo (URL)</label>
            <input type="text" class="form-control" id="LogoURL" name="LogoURL"
                   value="<?php echo htmlspecialchars($team->LogoURL); ?>">
        </div>
        <div class="mb-3">
            <label for="TournamentID" class="form-label">Giải đấu</label>
            <select id="TournamentID" name="TournamentID" class="form-control">
                <?php foreach ($tournaments as $tournament): ?>
                    <option value="<?php echo $tournament->TournamentID; ?>" <?php if ($team->TournamentID == $tournament->TournamentID) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($tournament->Name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="/project-esports/team/list" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php include 'app/views/shares/footer.php';
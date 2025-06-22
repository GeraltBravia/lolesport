<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4">Chỉnh sửa giải đấu</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/project-esports/Tournament/update">
        <input type="hidden" name="TournamentID" value="<?php echo htmlspecialchars($tournament->TournamentID); ?>">
        <div class="mb-3">
            <label for="Name" class="form-label">Tên giải đấu</label>
            <input type="text" class="form-control" id="Name" name="Name" required
                   value="<?php echo htmlspecialchars($tournament->Name); ?>">
        </div>
        <div class="mb-3">
            <label for="StartDate" class="form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" id="StartDate" name="StartDate" required
                   value="<?php echo htmlspecialchars($tournament->StartDate); ?>">
        </div>
        <div class="mb-3">
            <label for="EndDate" class="form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" id="EndDate" name="EndDate" required
                   value="<?php echo htmlspecialchars($tournament->EndDate); ?>">
        </div>
        <div class="mb-3">
            <label for="Slug" class="form-label">Giải đấu</label>
            <input type="text" class="form-control" id="Slug" name="Slug" required
                   value="<?php echo htmlspecialchars($tournament->Slug); ?>">
        </div>
        <div class="mb-3">
            <label for="Status" class="form-label">Trạng thái</label>
            <select class="form-control" id="Status" name="Status" required>
                <option value="Upcoming" <?php if (strtolower($tournament->Status) == 'upcoming') echo 'selected'; ?>>Sắp diễn ra</option>
                <option value="Ongoing" <?php if (strtolower($tournament->Status) == 'ongoing') echo 'selected'; ?>>Đang diễn ra</option>
                <option value="Finished" <?php if (strtolower($tournament->Status) == 'finished') echo 'selected'; ?>>Đã kết thúc</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="/project-esports/tournament/list" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php include 'app/views/shares/footer.php'; ?>
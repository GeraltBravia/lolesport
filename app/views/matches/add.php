<?php include 'app/views/shares/header.php'; ?>
<h1>Thêm trận đấu mới</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/project-esports/Match/save">
    <div class="form-group">
        <label for="TournamentID">Giải đấu:</label>
        <input type="text" id="TournamentID" name="TournamentID" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="TeamAID">Đội A:</label>
        <input type="text" id="TeamAID" name="TeamAID" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="TeamBID">Đội B:</label>
        <input type="text" id="TeamBID" name="TeamBID" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="MatchDate">Ngày thi đấu:</label>
        <input type="date" id="MatchDate" name="MatchDate" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="Result">Kết quả:</label>
        <input type="text" id="Result" name="Result" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Thêm trận đấu</button>
</form>
<a href="/project-esports/Match/list" class="btn btn-secondary mt-2">Quay lại danh sách trận đấu</a>
<?php include 'app/views/shares/footer.php'; ?>
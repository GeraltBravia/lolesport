<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4">Chỉnh sửa trận đấu</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/project-esports/Match/update">
        <input type="hidden" name="MatchID" value="<?php echo htmlspecialchars($match->MatchID ?? ''); ?>">
        <div class="mb-3">
            <label for="TournamentID" class="form-label">Giải đấu</label>
            <select id="TournamentID" name="TournamentID" class="form-control" required>
                <?php foreach ($tournaments as $tournament): ?>
                    <option value="<?php echo htmlspecialchars($tournament->TournamentID); ?>" <?php if (isset($match->TournamentID) && $match->TournamentID == $tournament->TournamentID) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($tournament->Name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Team1ID" class="form-label">Đội 1</label>
            <select id="Team1ID" name="Team1ID" class="form-control" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo htmlspecialchars($team->TeamID); ?>" <?php if (isset($match->Team1ID) && $match->Team1ID == $team->TeamID) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($team->Name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Team2ID" class="form-label">Đội 2</label>
            <select id="Team2ID" name="Team2ID" class="form-control" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo htmlspecialchars($team->TeamID); ?>" <?php if (isset($match->Team2ID) && $match->Team2ID == $team->TeamID) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($team->Name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="MatchDate" class="form-label">Ngày thi đấu</label>
            <input type="datetime-local" class="form-control" id="MatchDate" name="MatchDate" required
                   value="<?php echo htmlspecialchars($match->MatchDate ? date('Y-m-d\TH:i', strtotime($match->MatchDate)) : ''); ?>">
        </div>
        <div class="mb-3">
            <label for="Status" class="form-label">Trạng thái</label>
            <select class="form-control" id="Status" name="Status" required>
                <option value="upcoming" <?php if (isset($match->Status) && strtolower($match->Status) == 'upcoming') echo 'selected'; ?>>Sắp diễn ra</option>
                <option value="finished" <?php if (isset($match->Status) && strtolower($match->Status) == 'finished') echo 'selected'; ?>>Đã kết thúc</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="WinnerID" class="form-label">Đội thắng</label>
            <select id="WinnerID" name="WinnerID" class="form-control">
                <option value="">Chưa xác định</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo htmlspecialchars($team->TeamID); ?>"
                        class="winner-option"
                        <?php if (isset($match->WinnerID) && $match->WinnerID == $team->TeamID) {
                            echo 'selected style=""';
                        } else {
                            echo 'style="display:none;"';
                        } ?>>
                        <?php echo htmlspecialchars($team->Name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Score" class="form-label">Tỉ số</label>
            <input type="text" class="form-control" id="Score" name="Score"
                   value="<?php echo htmlspecialchars($match->Score ?? ''); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="/project-esports/match/list" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const team1Select = document.getElementById('Team1ID');
    const team2Select = document.getElementById('Team2ID');
    const winnerSelect = document.getElementById('WinnerID');
    const winnerOptions = winnerSelect.querySelectorAll('.winner-option');

    function updateWinnerOptions() {
        const team1Id = team1Select.value;
        const team2Id = team2Select.value;
        const selectedWinner = winnerSelect.value;

        // Ẩn tất cả các option
        winnerOptions.forEach(option => {
            option.style.display = 'none';
        });

        // Hiển thị option cho Team1ID và Team2ID
        if (team1Id) {
            const team1Option = winnerSelect.querySelector(`option[value="${team1Id}"]`);
            if (team1Option) team1Option.style.display = '';
        }
        if (team2Id && team2Id !== team1Id) {
            const team2Option = winnerSelect.querySelector(`option[value="${team2Id}"]`);
            if (team2Option) team2Option.style.display = '';
        }

        // Luôn hiển thị option đã chọn (nếu có)
        if (selectedWinner && selectedWinner !== "" && selectedWinner !== team1Id && selectedWinner !== team2Id) {
            const selectedOption = winnerSelect.querySelector(`option[value="${selectedWinner}"]`);
            if (selectedOption) selectedOption.style.display = '';
        }
    }

    team1Select.addEventListener('change', updateWinnerOptions);
    team2Select.addEventListener('change', updateWinnerOptions);

    updateWinnerOptions();
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
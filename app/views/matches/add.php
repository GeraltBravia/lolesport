<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4">Thêm trận đấu mới</h2>
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
        <div class="mb-3">
            <label for="TournamentID" class="form-label">Giải đấu</label>
            <select id="TournamentID" name="TournamentID" class="form-control" required>
                <?php if (is_array($tournaments) && !empty($tournaments)): ?>
                    <?php foreach ($tournaments as $tournament): ?>
                        <option value="<?php echo htmlspecialchars($tournament->TournamentID); ?>">
                            <?php echo htmlspecialchars($tournament->Name); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Không có dữ liệu giải đấu</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Team1ID" class="form-label">Đội 1</label>
            <select id="Team1ID" name="Team1ID" class="form-control" required>
                <?php if (is_array($teams) && !empty($teams)): ?>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo htmlspecialchars($team->TeamID); ?>">
                            <?php echo htmlspecialchars($team->Name); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Không có dữ liệu đội</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Team2ID" class="form-label">Đội 2</label>
            <select id="Team2ID" name="Team2ID" class="form-control" required>
                <?php if (is_array($teams) && !empty($teams)): ?>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo htmlspecialchars($team->TeamID); ?>">
                            <?php echo htmlspecialchars($team->Name); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Không có dữ liệu đội</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="MatchDate" class="form-label">Ngày thi đấu</label>
            <input type="datetime-local" class="form-control" id="MatchDate" name="MatchDate" required>
        </div>
        <div class="mb-3">
            <label for="Status" class="form-label">Trạng thái</label>
            <select class="form-control" id="Status" name="Status" required>
                <option value="upcoming">Sắp diễn ra</option>
                <option value="finished">Đã kết thúc</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="WinnerID" class="form-label">Đội thắng</label>
            <select id="WinnerID" name="WinnerID" class="form-control">
                <option value="">Chưa xác định</option>
                <?php if (is_array($teams) && !empty($teams)): ?>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo htmlspecialchars($team->TeamID); ?>" class="winner-option" style="display:none;">
                            <?php echo htmlspecialchars($team->Name); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Score" class="form-label">Tỉ số</label>
            <input type="text" class="form-control" id="Score" name="Score">
        </div>
        <div class="mb-3">
            <label for="BO" class="form-label">Thể thức thi đấu</label>
            <select class="form-control" id="BO" name="BO" required>
                <option value="BO1">BO1</option>
                <option value="BO3">BO3</option>
                <option value="BO5">BO5</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="Stage" class="form-label">Vòng đấu</label>
            <select class="form-control" id="Stage" name="Stage" required>
                <option value="Vòng bảng">Vòng bảng</option>
                <option value="PlayOff">PlayOff</option>
                <option value="Tứ Kết">Tứ Kết</option>
                <option value="Bán kết">Bán kết</option>
                <option value="Bán kết nhánh thắng">Bán kết nhánh thắng</option>
                <option value="Bán kết nhánh thua">Bán kết nhánh thua</option>
                <option value="Chung kết nhánh thắng">Chung kết nhánh thắng</option>
                <option value="Chung kết nhánh thua">Chung kết nhánh thua</option>
                <option value="Chung Kết Tổng">Chung Kết Tổng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm trận đấu</button>
        <a href="/project-esports/Match" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const team1Select = document.getElementById('Team1ID');
    const team2Select = document.getElementById('Team2ID');
    const winnerSelect = document.getElementById('WinnerID');
    const winnerOptions = winnerSelect.querySelectorAll('.winner-option');

    function updateWinnerOptions() {
        // Lấy giá trị của Team1ID và Team2ID
        const team1Id = team1Select.value;
        const team2Id = team2Select.value;

        // Ẩn tất cả các option của WinnerID
        winnerOptions.forEach(option => {
            option.style.display = 'none';
        });

        // Hiển thị lại các option tương ứng với Team1ID và Team2ID
        if (team1Id) {
            const team1Option = winnerSelect.querySelector(`option[value="${team1Id}"]`);
            if (team1Option) team1Option.style.display = '';
        }
        if (team2Id && team2Id !== team1Id) { // Tránh trùng lặp nếu Team1ID và Team2ID giống nhau
            const team2Option = winnerSelect.querySelector(`option[value="${team2Id}"]`);
            if (team2Option) team2Option.style.display = '';
        }

        // Đặt lại giá trị của WinnerID nếu không còn hợp lệ
        const selectedWinner = winnerSelect.value;
        if (selectedWinner && !winnerSelect.querySelector(`option[value="${selectedWinner}"][style="display:"]`)) {
            winnerSelect.value = '';
        }
    }

    // Lắng nghe sự kiện thay đổi trên Team1ID và Team2ID
    team1Select.addEventListener('change', updateWinnerOptions);
    team2Select.addEventListener('change', updateWinnerOptions);

    // Gọi lần đầu để thiết lập ban đầu
    updateWinnerOptions();
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
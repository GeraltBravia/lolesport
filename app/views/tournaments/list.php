<?php

include 'app/views/shares/header.php'; 
require_once 'app/helpers/AuthHelper.php';
?>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Danh sách giải đấu</h1>
        <?php if (AuthHelper::isAdmin()): ?>
            <a href="/project-esports/Tournament/add" class="btn btn-success">Thêm giải đấu mới</a>
        <?php endif; ?>
    </div>
    <div class="row" id="tournament-list">
        <div class="col-12">
            <p class="text-center">Đang tải...</p>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>

<script>
function escapeHTML(str) {
    return String(str).replace(/[&<>"']/g, match => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[match]));
}
function renderTournament(t, isAdmin) {
    const col = document.createElement('div');
    col.className = 'col-md-4 mb-3';
    col.setAttribute('data-id', t.TournamentID);
    col.innerHTML = `
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/project-esports/Tournament/show/${t.TournamentID}" class="text-decoration-none text-primary">
                        ${escapeHTML(t.Name)}
                    </a>
                </h5>
                <p class="card-text">Khu vực: ${escapeHTML(t.Region || '')}</p>
                <p class="card-text">Thời gian: ${escapeHTML(t.StartDate || '')} - ${escapeHTML(t.EndDate || '')}</p>
                <p class="card-text">Trạng thái: ${escapeHTML(t.Status || '')}</p>
            </div>
            ${isAdmin ? `
            <div class="card-footer bg-white border-0 d-flex justify-content-between">
                <a href="/project-esports/Tournament/edit/${t.TournamentID}" class="btn btn-warning btn-sm">Sửa</a>
                <button class="btn btn-danger btn-sm" onclick="deleteTournament(${t.TournamentID})">Xóa</button>
            </div>
            ` : ''}
        </div>
    `;
    return col;
}
document.addEventListener("DOMContentLoaded", function() {
    const isAdmin = <?php echo AuthHelper::isAdmin() ? 'true' : 'false'; ?>;
    fetch('/project-esports/api/tournament')
        .then(res => res.json())
        .then(data => {
            const tournamentList = document.getElementById('tournament-list');
            tournamentList.innerHTML = '';
            if (!Array.isArray(data) || data.length === 0) {
                tournamentList.innerHTML = '<div class="col-12"><p class="text-center">Không có giải đấu nào.</p></div>';
                return;
            }
            data.forEach(t => tournamentList.appendChild(renderTournament(t, isAdmin)));
        })
        .catch(() => {
            document.getElementById('tournament-list').innerHTML = '<div class="col-12"><p class="text-center">Không thể tải danh sách giải đấu.</p></div>';
        });
});
function deleteTournament(id) {
    if (confirm('Bạn có chắc chắn muốn xóa giải đấu này?')) {
        fetch(`/project-esports/api/tournament/${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.message === 'Tournament deleted successfully') {
                    const item = document.querySelector(`div[data-id="${id}"]`);
                    if (item) item.remove();
                } else {
                    alert('Xóa giải đấu thất bại');
                }
            });
    }
}
</script>
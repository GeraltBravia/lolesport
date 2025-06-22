<?php
 
include 'app/views/shares/header.php'; 
require_once 'app/helpers/AuthHelper.php';
?>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Danh sách trận đấu</h1>
        <?php if (AuthHelper::isAdmin()): ?>
            <a href="/project-esports/Match/add" class="btn btn-success">Thêm trận đấu mới</a>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="me-2 fw-bold">Lọc theo giải đấu:</label>
        <button class="btn btn-outline-primary btn-sm me-1" onclick="filterTournament('all')">Tất cả</button>
        <button class="btn btn-outline-primary btn-sm me-1" onclick="filterTournament('lck')">LCK</button>
        <button class="btn btn-outline-primary btn-sm me-1" onclick="filterTournament('lpl')">LPL</button>
        <button class="btn btn-outline-primary btn-sm me-1" onclick="filterTournament('lec')">LEC</button>
        <button class="btn btn-outline-primary btn-sm me-1" onclick="filterTournament('lcs')">LCS</button>
        <button class="btn btn-outline-primary btn-sm me-1" onclick="filterTournament('msi')">MSI</button>
        <button class="btn btn-outline-primary btn-sm me-1" onclick="filterTournament('world')">World</button>
    </div>
    <div class="row" id="match-list">
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
function renderMatch(match, isAdmin) {
    const col = document.createElement('div');
    col.className = 'col-md-6 mb-3';
    col.setAttribute('data-id', match.MatchID);
    col.setAttribute('data-tournament', match.TournamentSlug || '');
    col.innerHTML = `
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/project-esports/Match/show/${match.MatchID}" class="text-decoration-none text-primary">
                        ${escapeHTML(match.Team1Name)} vs ${escapeHTML(match.Team2Name)}
                    </a>
                    <span class="badge bg-info ms-2">${escapeHTML(match.TournamentSlug ? match.TournamentSlug.toUpperCase() : '')}</span>
                </h5>
                <p class="card-text">Giải đấu: ${escapeHTML(match.TournamentName || '')}</p>
                <p class="card-text">Ngày: ${escapeHTML(match.MatchDate || '')}</p>
                <p class="card-text">Kết quả: ${escapeHTML(match.Score || 'Chưa có')}</p>
            </div>
            ${isAdmin ? `
            <div class="card-footer bg-white border-0 d-flex justify-content-between">
                <a href="/project-esports/Match/edit/${match.MatchID}" class="btn btn-warning btn-sm">Sửa</a>
                <button class="btn btn-danger btn-sm" onclick="deleteMatch(${match.MatchID})">Xóa</button>
            </div>
            ` : ''}
        </div>
    `;
    return col;
}
let allMatches = [];
document.addEventListener("DOMContentLoaded", function() {
    const isAdmin = <?php echo AuthHelper::isAdmin() ? 'true' : 'false'; ?>;
    fetch('/project-esports/api/match')
        .then(res => res.json())
        .then(data => {
            allMatches = data;
            renderMatchList('all', isAdmin);
        })
        .catch(() => {
            document.getElementById('match-list').innerHTML = '<div class="col-12"><p class="text-center">Không thể tải danh sách trận đấu.</p></div>';
        });
});

function renderMatchList(tournament, isAdmin) {
    const matchList = document.getElementById('match-list');
    matchList.innerHTML = '';
    let filtered = allMatches;
    if (tournament !== 'all') {
        filtered = allMatches.filter(m => (m.TournamentSlug || '').toLowerCase() === tournament);
    }
    if (!filtered.length) {
        matchList.innerHTML = '<div class="col-12"><p class="text-center">Không có trận đấu nào.</p></div>';
        return;
    }
    filtered.forEach(match => matchList.appendChild(renderMatch(match, isAdmin)));
}

function deleteMatch(id) {
    if (confirm('Bạn có chắc chắn muốn xóa trận đấu này?')) {
        fetch(`/project-esports/api/match/${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.message === 'Match deleted successfully') {
                    const item = document.querySelector(`div[data-id="${id}"]`);
                    if (item) item.remove();
                } else {
                    alert('Xóa trận đấu thất bại');
                }
            });
    }
}
function filterTournament(slug) {
    const isAdmin = <?php echo AuthHelper::isAdmin() ? 'true' : 'false'; ?>;
    renderMatchList(slug, isAdmin);
}
</script>
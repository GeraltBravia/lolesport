<?php
include 'app/views/shares/header.php';
require_once 'app/helpers/AuthHelper.php';
?>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Danh sách đội</h1>
        <?php if (AuthHelper::isAdmin()): ?>
            <a href="/project-esports/Team/add" class="btn btn-success">Thêm đội mới</a>
        <?php endif; ?>
    </div>
    <div class="row" id="team-list">
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
function renderTeam(team, isAdmin) {
    const col = document.createElement('div');
    col.className = 'col-md-4 mb-3';
    col.setAttribute('data-id', team.TeamID);
    col.innerHTML = `
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
                <img src="/${escapeHTML(team.LogoURL || 'assets/no-logo.png')}" alt="Logo" class="mb-3" style="max-width:80px;max-height:80px;object-fit:contain;">
                <h5 class="card-title mt-2">
                    <a href="/project-esports/Team/show/${team.TeamID}" class="text-decoration-none text-primary">
                        ${escapeHTML(team.Name)}
                    </a>
                </h5>
                <p class="card-text">Khu vực: ${escapeHTML(team.Region || '')}</p>
            </div>
            ${isAdmin ? `
            <div class="card-footer bg-white border-0 d-flex justify-content-between">
                <a href="/project-esports/Team/edit/${team.TeamID}" class="btn btn-warning btn-sm">Sửa</a>
                <button class="btn btn-danger btn-sm" onclick="deleteTeam(${team.TeamID})">Xóa</button>
            </div>
            ` : ''}
        </div>
    `;
    return col;
}
document.addEventListener("DOMContentLoaded", function() {
    const isAdmin = <?php echo AuthHelper::isAdmin() ? 'true' : 'false'; ?>;
    fetch('/project-esports/api/team')
        .then(res => res.json())
        .then(data => {
            const teamList = document.getElementById('team-list');
            teamList.innerHTML = '';
            if (!Array.isArray(data) || data.length === 0) {
                teamList.innerHTML = '<div class="col-12"><p class="text-center">Không có đội nào.</p></div>';
                return;
            }
            data.forEach(team => teamList.appendChild(renderTeam(team, isAdmin)));
        })
        .catch(() => {
            document.getElementById('team-list').innerHTML = '<div class="col-12"><p class="text-center">Không thể tải danh sách đội.</p></div>';
        });
});
function deleteTeam(id) {
    if (confirm('Bạn có chắc chắn muốn xóa đội này?')) {
        fetch(`/project-esports/api/team/${id}`, { method: 'DELETE' })
            .then(res => res.json())
            .then(data => {
                if (data.message === 'Team deleted successfully') {
                    const item = document.querySelector(`div[data-id="${id}"]`);
                    if (item) item.remove();
                } else {
                    alert('Xóa đội thất bại');
                }
            });
    }
}
</script>
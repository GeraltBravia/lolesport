<?php
include 'app/views/shares/header.php'; 
?>
<div class="container my-5">
    <h1 class="fw-bold mb-4">Playoff Bracket</h1>
    <div id="bracket-list">
        <p class="text-center">Đang tải...</p>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>

<script>
function escapeHTML(str) {
    return String(str).replace(/[&<>"']/g, match => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[match]));
}
document.addEventListener("DOMContentLoaded", function() {
    fetch('/project-esports/api/match/bracket')
        .then(res => res.json())
        .then(data => {
            const bracket = document.getElementById('bracket-list');
            bracket.innerHTML = '';
            if (!Array.isArray(data) || data.length === 0) {
                bracket.innerHTML = '<p class="text-center">Không có dữ liệu playoff.</p>';
                return;
            }
            data.forEach(match => {
                bracket.innerHTML += `<div class="mb-2">
                    <strong>${escapeHTML(match.TeamAID)} vs ${escapeHTML(match.TeamBID)}</strong>
                    <span class="mx-2">|</span>
                    <span>${escapeHTML(match.MatchDate || '')}</span>
                    <span class="mx-2">|</span>
                    <span>KQ: ${escapeHTML(match.Result || 'Chưa có')}</span>
                </div>`;
            });
        })
        .catch(() => {
            document.getElementById('bracket-list').innerHTML = '<p class="text-center">Không thể tải dữ liệu playoff.</p>';
        });
});
</script>
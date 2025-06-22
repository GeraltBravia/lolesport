<?php include 'app/views/shares/header.php'; ?>
<div class="container my-4">
    <h1 class="mb-4 text-center">Lịch thi đấu</h1>
    <div id="schedule-container"></div>
</div>

<script>
function escapeHTML(str) {
    return String(str || '').replace(/[&<>"']/g, match => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[match]));
}

// Helper: group matches by date (YYYY-MM-DD)
function groupByDate(matches) {
    const groups = {};
    matches.forEach(match => {
        const date = new Date(match.MatchDate);
        const key = date.getFullYear() + '-' + String(date.getMonth()+1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
        if (!groups[key]) groups[key] = [];
        groups[key].push(match);
    });
    return groups;
}

// Helper: format date to "Thứ Bảy 28 thg 6"
function formatVNDate(dateStr) {
    const date = new Date(dateStr);
    const days = ['Chủ Nhật','Thứ Hai','Thứ Ba','Thứ Tư','Thứ Năm','Thứ Sáu','Thứ Bảy'];
    return `${days[date.getDay()]} ${date.getDate()} thg ${date.getMonth()+1}`;
}

// Helper: format hour
function formatHour(dateStr) {
    const date = new Date(dateStr);
    return date.getHours() + ':' + String(date.getMinutes()).padStart(2, '0');
}

function renderSchedule(matches) {
    if (!matches.length) return '<div class="text-center">Không có trận đấu nào.</div>';
    const grouped = groupByDate(matches);
    let html = '';
    Object.keys(grouped).sort().forEach(dateKey => {
        html += `
        <div class="mb-4">
            <div class="bg-dark text-white px-3 py-2 rounded-top">
                <strong>${formatVNDate(dateKey)}</strong>
            </div>
            <div class="bg-black p-3 rounded-bottom">
                ${grouped[dateKey].map(match => `
                    <div class="d-flex align-items-center justify-content-between bg-dark text-white mb-3 px-3 py-2 rounded">
                        <div class="fw-bold fs-5" style="width:60px">${formatHour(match.MatchDate)}</div>
                        <div class="d-flex align-items-center flex-grow-1 justify-content-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <img src="${escapeHTML(match.Team1Logo || '')}" alt="" style="width:32px;height:32px;object-fit:contain;background:#222;border-radius:50%;">
                                <span class="fw-bold">${escapeHTML(match.Team1Name)}</span>
                            </div>
                            <span class="mx-2 fs-4">/</span>
                            <div class="d-flex align-items-center gap-2">
                                <img src="${escapeHTML(match.Team2Logo || '')}" alt="" style="width:32px;height:32px;object-fit:contain;background:#222;border-radius:50%;">
                                <span class="fw-bold">${escapeHTML(match.Team2Name)}</span>
                            </div>
                        </div>
                        <div class="text-center" style="min-width:120px">
                            <div class="small">${escapeHTML(match.TournamentName)}</div>
                            <div class="small">${escapeHTML(match.Stage || 'Vòng Khởi Động')}</div>
                        </div>
                        <div class="fw-bold" style="width:50px">${escapeHTML(match.BO || 'BO5')}</div>
                    </div>
                `).join('')}
            </div>
        </div>
        `;
    });
    return html;
}

document.addEventListener("DOMContentLoaded", function() {
    fetch('/project-esports/api/match')
        .then(res => res.json())
        .then(data => {
            // Giả sử API trả về Team1Logo, Team2Logo, Stage, BO
            document.getElementById('schedule-container').innerHTML = renderSchedule(data);
        })
        .catch(error => {
            document.getElementById('schedule-container').innerHTML = '<div class="text-center text-danger">Không thể tải dữ liệu.</div>';
        });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
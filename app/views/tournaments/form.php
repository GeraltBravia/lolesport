<?php include 'app/views/shares/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4 text-center">Thêm/Sửa giải đấu</h1>
        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="Name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" name="StartDate" class="form-control" id="startDate" required>
            </div>
            <div class="mb-3">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" name="EndDate" class="form-control" id="endDate" required>
            </div>
            <div class="mb-3">
                <label for="region" class="form-label">Region</label>
                <input type="text" name="Region" class="form-control" id="region" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" name="Status" class="form-control" id="status" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Lưu</button>
        </form>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
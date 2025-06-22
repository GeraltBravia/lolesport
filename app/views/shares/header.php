<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eSports Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css"> <!-- Giữ CSS tùy chỉnh của bạn -->
</head>
<body>
    <header class="bg-dark text-white p-3 text-center">
        <h1 class="display-4">LOL Esports</h1>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="/project-esports/">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project-esports/tournament/list">Giải đấu</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project-esports/team/list">Đội</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project-esports/match/list">Lịch thi đấu</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project-esports/news/list">Tin tức</a></li>
                        <li class="nav-item"><a class="nav-link" href="/project-esports/video/list">Highlights</a></li>
                    </ul>
                    <?php
                    require_once 'app/helpers/SessionHelper.php';
                    if (SessionHelper::get('is_admin')): ?>
                        <a class="btn btn-danger" href="?controller=auth&action=logout">Đăng xuất</a>
                    <?php else: ?>
                        <a class="btn btn-primary" href="/project-esports/auth/login">Đăng nhập</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <main class="container my-4">
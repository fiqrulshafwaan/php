<?php
// ========================================================
// FILE: latselectmodify_modern.php
// Versi: Luxury Royal Gold Dashboard (Tema Kuning Emas Elegan)
// ========================================================

$db_user = "root";
$db_pass = "";
$db_name = "datapikrul";

$conn = @mysqli_connect("127.0.0.1", $db_user, $db_pass, $db_name);
if (!$conn) {
    $conn = @mysqli_connect("localhost", $db_user, $db_pass, $db_name);
}

$alertMessage = "";
$alertType = "";

// Aksi Hapus Baris
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = intval($_GET['id']);
    if ($conn) {
        $stmt_f = mysqli_prepare($conn, "SELECT File FROM sija2 WHERE no = ?");
        if ($stmt_f) {
            mysqli_stmt_bind_param($stmt_f, "i", $del_id);
            mysqli_stmt_execute($stmt_f);
            $res_f = mysqli_stmt_get_result($stmt_f);
            if ($row_f = mysqli_fetch_assoc($res_f)) {
                if (!empty($row_f['File']) && file_exists("uploads/" . $row_f['File'])) {
                    @unlink("uploads/" . $row_f['File']);
                }
            }
            mysqli_stmt_close($stmt_f);
        }

        $stmt_d = mysqli_prepare($conn, "DELETE FROM sija2 WHERE no = ?");
        if ($stmt_d) {
            mysqli_stmt_bind_param($stmt_d, "i", $del_id);
            if (mysqli_stmt_execute($stmt_d)) {
                $alertMessage = "Data #$del_id berhasil dihapus dari sistem.";
                $alertType = "success";
            } else {
                $alertMessage = "Gagal menghapus data: " . mysqli_stmt_error($stmt_d);
                $alertType = "danger";
            }
            mysqli_stmt_close($stmt_d);
        }
    }
}

// Ambil Seluruh Data
$rows = [];
$total_data = 0;
$total_male = 0;
$total_female = 0;
$total_files = 0;

if ($conn) {
    $query = "SELECT * FROM sija2 ORDER BY no DESC";
    if ($res = mysqli_query($conn, $query)) {
        while ($r = mysqli_fetch_assoc($res)) {
            $rows[] = $r;
            $total_data++;
            $g = strtolower(trim($r['gender'] ?? ''));
            if ($g === 'male' || $g === 'laki-laki' || $g === 'laki laki') {
                $total_male++;
            } elseif ($g === 'female' || $g === 'perempuan') {
                $total_female++;
            }
            if (!empty($r['File']) && file_exists("uploads/" . $r['File'])) {
                $total_files++;
            }
        }
        mysqli_free_result($res);
    }
} else {
    $alertMessage = "Koneksi ke database terputus. Pastikan MySQL XAMPP aktif.";
    $alertType = "danger";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manajemen Data - Edisi Emas</title>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --gold-primary: #eab308;
            --gold-light: #fef08a;
            --gold-dark: #a16207;
            --gold-gradient: linear-gradient(135deg, #f59e0b 0%, #eab308 50%, #fef08a 100%);
            --gold-gradient-hover: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fde047 100%);
            --gold-glow: 0 0 20px rgba(234, 179, 8, 0.35);
            
            --bg-page: #0d0c0a;
            --surface-card: #161410;
            --surface-hover: #1f1b13;
            --surface-input: #110f0c;
            
            --border-gold: rgba(234, 179, 8, 0.35);
            --border-subtle: #29241b;
            
            --text-gold-light: #fef9c3;
            --text-main: #f3f4f6;
            --text-muted: #a39c8f;
            
            --danger: #f87171;
            --danger-light: rgba(244, 63, 94, 0.15);
            --success: #34d399;
            --success-light: rgba(16, 185, 129, 0.15);
            
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--bg-page);
            background-image: 
                radial-gradient(at 0% 0%, rgba(234, 179, 8, 0.12) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(217, 119, 6, 0.1) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(245, 158, 11, 0.08) 0px, transparent 60%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 50px;
        }

        /* Top Sticky Navbar */
        .navbar {
            background: rgba(22, 20, 16, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-gold);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 14px 28px;
        }

        .navbar-container {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        .nav-logo {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(234, 179, 8, 0.15);
            border: 1.5px solid var(--gold-primary);
            color: var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 0 14px rgba(234, 179, 8, 0.3);
        }

        .nav-title {
            font-size: 1.15rem;
            font-weight: 800;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .nav-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: rgba(234, 179, 8, 0.12);
            border: 1px solid rgba(234, 179, 8, 0.35);
            color: var(--gold-light);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--gold-primary);
            box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7);
            animation: pulse 1.6s infinite;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-gold {
            background: var(--gold-gradient);
            color: #0d0c0a;
            box-shadow: var(--gold-glow);
        }

        .btn-gold:hover {
            transform: translateY(-1px);
            background: var(--gold-gradient-hover);
            box-shadow: 0 0 24px rgba(234, 179, 8, 0.5);
        }

        .btn-outline-gold {
            background: #1a1711;
            color: var(--gold-light);
            border: 1.5px solid var(--border-gold);
        }

        .btn-outline-gold:hover {
            background: #2b251a;
            border-color: var(--gold-primary);
        }

        /* Main Container */
        .main-container {
            max-width: 1300px;
            margin: 28px auto 0;
            padding: 0 24px;
        }

        /* Header Greeting */
        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .page-header h1 span {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.92rem;
            margin-top: 4px;
        }

        /* KPI / Metric Cards */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .metric-card {
            background: var(--surface-card);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-md);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            transition: all 0.25s ease;
        }

        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.6), 0 0 15px rgba(234, 179, 8, 0.2);
            border-color: var(--gold-primary);
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: rgba(234, 179, 8, 0.15);
            color: var(--gold-primary);
            border: 1px solid rgba(234, 179, 8, 0.3);
        }

        .metric-info .num {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--gold-light);
            line-height: 1.2;
        }

        .metric-info .lbl {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Alert */
        .alert-bar {
            padding: 12px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .alert-success { 
            background: rgba(16, 185, 129, 0.15); 
            border: 1px solid rgba(16, 185, 129, 0.4); 
            color: #6ee7b7; 
        }
        
        .alert-danger { 
            background: rgba(244, 63, 94, 0.15); 
            border: 1px solid rgba(244, 63, 94, 0.4); 
            color: #fda4af; 
        }

        /* Table Card Container */
        .card-table-wrapper {
            background: var(--surface-card);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-lg);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .table-toolbar {
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            border-bottom: 1px solid var(--border-subtle);
            background: #191611;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 340px;
        }

        .search-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #786f5c;
            font-size: 14px;
        }

        .search-input {
            width: 100%;
            padding: 9px 14px 9px 38px;
            border: 1.5px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            outline: none;
            background: var(--surface-input);
            color: #ffffff;
            transition: all 0.2s;
        }

        .search-input::placeholder {
            color: #615a4b;
        }

        .search-input:focus {
            border-color: var(--gold-primary);
            background: #17140f;
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.2);
        }

        .filter-tabs {
            display: flex;
            background: #110f0c;
            padding: 4px;
            border-radius: var(--radius-sm);
            gap: 4px;
            border: 1px solid var(--border-subtle);
        }

        .filter-tab {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-muted);
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-tab.active {
            background: var(--gold-primary);
            color: #0d0c0a;
            box-shadow: 0 0 10px rgba(234, 179, 8, 0.35);
        }

        /* The Data Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        thead {
            background: #1c1811;
            border-bottom: 1px solid var(--border-subtle);
        }

        th {
            padding: 13px 20px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gold-light);
            white-space: nowrap;
        }

        td {
            padding: 14px 20px;
            border-bottom: 1px solid #231f18;
            vertical-align: middle;
            color: var(--text-main);
        }

        tbody tr {
            transition: background 0.15s ease;
        }

        tbody tr:hover {
            background-color: var(--surface-hover);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Cell Details */
        .id-badge {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--gold-light);
            background: rgba(234, 179, 8, 0.15);
            border: 1px solid rgba(234, 179, 8, 0.3);
            padding: 3px 8px;
            border-radius: 6px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.95rem;
            color: #0d0c0a;
            flex-shrink: 0;
            box-shadow: 0 0 10px rgba(234, 179, 8, 0.3);
            border: 1px solid var(--gold-light);
        }

        .user-meta .name {
            font-weight: 700;
            color: #ffffff;
        }

        .user-meta .note {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
            max-width: 260px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.84rem;
            color: #c4bdae;
            text-decoration: none;
            margin-bottom: 3px;
        }

        .contact-item:hover {
            color: var(--gold-primary);
            text-decoration: underline;
        }

        .gender-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .gender-male {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        .gender-female {
            background: rgba(236, 72, 153, 0.15);
            color: #f9a8d4;
            border: 1px solid rgba(236, 72, 153, 0.4);
        }

        .file-thumb-box {
            position: relative;
            display: inline-block;
        }

        .file-thumb {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            object-fit: cover;
            border: 1.5px solid var(--border-gold);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .file-thumb:hover {
            transform: scale(1.1);
            box-shadow: 0 0 14px rgba(234, 179, 8, 0.5);
        }

        .file-badge-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #231f18;
            color: var(--gold-primary);
            text-decoration: none;
            border: 1px solid var(--border-gold);
        }

        .file-badge-link:hover {
            background: #2e281e;
            color: var(--gold-light);
        }

        .btn-delete-row {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: transparent;
            color: #786f5c;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-delete-row:hover {
            background: var(--danger-light);
            color: var(--danger);
            border-color: rgba(244, 63, 94, 0.3);
        }

        /* Empty State */
        .empty-box {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-box i {
            font-size: 48px;
            color: #524731;
            margin-bottom: 12px;
        }

        /* Lightbox Image Preview Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10, 9, 7, 0.85);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease;
        }

        .modal-body {
            position: relative;
            max-width: 90%;
            max-height: 85%;
        }

        .modal-img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: var(--radius-md);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
            border: 2px solid var(--gold-primary);
        }

        .modal-close-btn {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gold-primary);
            color: #0d0c0a;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            font-size: 16px;
        }

        /* Custom Delete Confirmation Modal */
        .confirm-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10, 9, 7, 0.75);
            backdrop-filter: blur(6px);
            z-index: 1001;
            align-items: center;
            justify-content: center;
        }

        .confirm-box {
            background: #18150f;
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-lg);
            padding: 28px;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7);
            text-align: center;
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .confirm-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--danger-light);
            color: var(--danger);
            border: 1px solid rgba(244, 63, 94, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px;
        }

        .confirm-box h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .confirm-box p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .confirm-actions {
            display: flex;
            gap: 12px;
        }

        .btn-confirm-delete {
            flex: 1;
            padding: 11px;
            border-radius: var(--radius-sm);
            background: var(--danger);
            color: white;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-confirm-delete:hover {
            background: #dc2626;
        }

        .btn-confirm-cancel {
            flex: 1;
            padding: 11px;
            border-radius: var(--radius-sm);
            background: #231f18;
            color: var(--text-gold-light);
            font-weight: 700;
            border: 1px solid var(--border-subtle);
            cursor: pointer;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(234, 179, 8, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(234, 179, 8, 0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .table-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-wrapper {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Top Navigation Bar -->
<header class="navbar">
    <div class="navbar-container">
        <div class="nav-brand">
            <div class="nav-logo">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div>
                <div class="nav-title">PortalData Gold Edition</div>
            </div>
            <div class="nav-status">
                <div class="pulse-dot"></div>
                <span>Database Terhubung</span>
            </div>
        </div>

        <div class="nav-actions">
            <button class="btn btn-outline-gold" onclick="exportTableToCSV('data_peserta_gold.csv')">
                <i class="fa-solid fa-file-csv"></i>
                <span>Ekspor CSV</span>
            </button>
            <a href="form_validation_modern.php" class="btn btn-gold">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Data Baru</span>
            </a>
        </div>
    </div>
</header>

<main class="main-container">
    
    <!-- Header Page -->
    <div class="page-header">
        <h1>Kelola Data <span>Pendaftaran</span></h1>
        <p>Pantau seluruh informasi yang dikirimkan melalui formulir digital bertema royal gold</p>
    </div>

    <!-- Alert Notifikasi -->
    <?php if (!empty($alertMessage)): ?>
        <div class="alert-bar alert-<?php echo $alertType; ?>">
            <i class="fa-solid <?php echo ($alertType === 'success') ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
            <span><?php echo $alertMessage; ?></span>
        </div>
    <?php endif; ?>

    <!-- KPI Metrics -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="metric-info">
                <div class="num"><?php echo $total_data; ?></div>
                <div class="lbl">Total Entri Data</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="fa-solid fa-mars"></i>
            </div>
            <div class="metric-info">
                <div class="num"><?php echo $total_male; ?></div>
                <div class="lbl">Laki-laki</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="fa-solid fa-venus"></i>
            </div>
            <div class="metric-info">
                <div class="num"><?php echo $total_female; ?></div>
                <div class="lbl">Perempuan</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="fa-solid fa-file-arrow-up"></i>
            </div>
            <div class="metric-info">
                <div class="num"><?php echo $total_files; ?></div>
                <div class="lbl">Berkas Terlampir</div>
            </div>
        </div>
    </div>

    <!-- Table Card Container -->
    <div class="card-table-wrapper">
        <div class="table-toolbar">
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="filterInput" class="search-input" placeholder="Cari nama, email, catatan..." onkeyup="runFilter()">
            </div>

            <div class="filter-tabs">
                <button class="filter-tab active" onclick="setFilter('all', this)">Semua</button>
                <button class="filter-tab" onclick="setFilter('male', this)">Laki-laki</button>
                <button class="filter-tab" onclick="setFilter('female', this)">Perempuan</button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="mainTable">
                <thead>
                    <tr>
                        <th style="width: 70px;">ID</th>
                        <th>Identitas Peserta</th>
                        <th>Kontak & Tautan</th>
                        <th>Gender</th>
                        <th>Berkas Lampiran</th>
                        <th style="text-align: center; width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($rows) > 0): ?>
                        <?php 
                        $gradients = [
                            'linear-gradient(135deg, #f59e0b, #eab308)',
                            'linear-gradient(135deg, #d97706, #fbbf24)',
                            'linear-gradient(135deg, #b45309, #fde047)',
                            'linear-gradient(135deg, #ca8a04, #fef08a)',
                            'linear-gradient(135deg, #a16207, #facc15)'
                        ];

                        foreach ($rows as $index => $r): 
                            $id = htmlspecialchars($r['no']);
                            $nama = htmlspecialchars($r['nama'] ?? '-');
                            $email = htmlspecialchars($r['email'] ?? '-');
                            $website = htmlspecialchars($r['website'] ?? '');
                            $komen = htmlspecialchars($r['komen'] ?? '');
                            $gender = strtolower(trim($r['gender'] ?? ''));
                            $file = htmlspecialchars($r['File'] ?? '');

                            $initial = !empty($nama) ? strtoupper(substr($nama, 0, 1)) : '?';
                            $isMale = ($gender === 'male' || $gender === 'laki-laki' || $gender === 'laki laki');
                            $grad = $gradients[$index % count($gradients)];
                        ?>
                            <tr data-gender="<?php echo $isMale ? 'male' : 'female'; ?>">
                                <td>
                                    <span class="id-badge">#<?php echo $id; ?></span>
                                </td>
                                <td>
                                    <div class="user-profile">
                                        <div class="user-avatar" style="background: <?php echo $grad; ?>;">
                                            <?php echo $initial; ?>
                                        </div>
                                        <div class="user-meta">
                                            <div class="name"><?php echo $nama; ?></div>
                                            <?php if (!empty($komen)): ?>
                                                <div class="note" title="<?php echo $komen; ?>">
                                                    <i class="fa-regular fa-comment-dots" style="color: var(--gold-primary);"></i> <?php echo $komen; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($email) && $email !== '-'): ?>
                                        <a href="mailto:<?php echo $email; ?>" class="contact-item">
                                            <i class="fa-regular fa-envelope" style="color: var(--gold-primary);"></i>
                                            <span><?php echo $email; ?></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($website)): ?>
                                        <?php 
                                        $url = (strpos($website, 'http://') === 0 || strpos($website, 'https://') === 0) ? $website : 'https://' . $website;
                                        ?>
                                        <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" class="contact-item" style="color: var(--gold-light);">
                                            <i class="fa-solid fa-link" style="color: var(--gold-primary);"></i>
                                            <span><?php echo (strlen($website) > 26) ? substr($website, 0, 26) . '...' : $website; ?></span>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="gender-pill <?php echo $isMale ? 'gender-male' : 'gender-female'; ?>">
                                        <i class="fa-solid <?php echo $isMale ? 'fa-mars' : 'fa-venus'; ?>"></i>
                                        <span><?php echo $isMale ? 'Laki-laki' : 'Perempuan'; ?></span>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    if (!empty($file) && file_exists("uploads/" . $file)): 
                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])):
                                    ?>
                                            <div class="file-thumb-box">
                                                <img src="uploads/<?php echo $file; ?>" alt="Foto" class="file-thumb" onclick="openLightbox('uploads/<?php echo $file; ?>')">
                                            </div>
                                        <?php else: ?>
                                            <a href="uploads/<?php echo $file; ?>" target="_blank" class="file-badge-link">
                                                <i class="fa-regular fa-file-pdf"></i>
                                                <span>Buka Dokumen</span>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span style="font-size: 0.8rem; color: #786f5c; font-style: italic;">Tidak ada berkas</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <button 
                                        type="button" 
                                        class="btn-delete-row" 
                                        title="Hapus data ini"
                                        onclick="showConfirmDelete(<?php echo $id; ?>, '<?php echo addslashes($nama); ?>')"
                                    >
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-box">
                                    <i class="fa-regular fa-folder-open"></i>
                                    <h3 style="color: #ffffff; font-size: 1.1rem;">Belum Ada Data Tersimpan</h3>
                                    <p style="font-size: 0.88rem; margin: 6px 0 16px;">Semua data yang dikirim melalui formulir akan otomatis tertera di sini.</p>
                                    <a href="form_validation_modern.php" class="btn btn-gold">
                                        <i class="fa-solid fa-plus"></i> Tambah Data Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Lightbox Modal untuk Preview Gambar -->
<div class="modal-overlay" id="lightboxModal" onclick="closeLightbox()">
    <div class="modal-body" onclick="event.stopPropagation()">
        <div class="modal-close-btn" onclick="closeLightbox()">&times;</div>
        <img src="" id="lightboxImg" class="modal-img" alt="Pratinjau Foto">
    </div>
</div>

<!-- Modal Konfirmasi Hapus Kustom -->
<div class="confirm-modal-overlay" id="confirmDeleteModal">
    <div class="confirm-box">
        <div class="confirm-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3>Hapus Data?</h3>
        <p>Apakah Anda yakin ingin menghapus data milik <strong id="deleteTargetName" style="color: var(--gold-light);"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="confirm-actions">
            <button type="button" class="btn-confirm-cancel" onclick="closeConfirmDelete()">Batal</button>
            <a href="#" id="deleteConfirmBtn" class="btn-confirm-delete">Hapus Sekarang</a>
        </div>
    </div>
</div>

<script>
    let currentGender = 'all';

    function setFilter(gender, btn) {
        currentGender = gender;
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        runFilter();
    }

    function runFilter() {
        const query = document.getElementById('filterInput').value.toLowerCase();
        const rows = document.querySelectorAll('#mainTable tbody tr');

        rows.forEach(row => {
            if (row.cells.length < 5) return;
            const text = row.textContent.toLowerCase();
            const rowGender = row.getAttribute('data-gender');

            const matchesText = text.includes(query);
            const matchesGender = (currentGender === 'all') || (rowGender === currentGender);

            row.style.display = (matchesText && matchesGender) ? '' : 'none';
        });
    }

    // Lightbox
    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightboxModal').style.display = 'flex';
    }

    function closeLightbox() {
        document.getElementById('lightboxModal').style.display = 'none';
    }

    // Delete Modal
    function showConfirmDelete(id, name) {
        document.getElementById('deleteTargetName').textContent = name;
        document.getElementById('deleteConfirmBtn').href = 'latselectmodify_modern.php?action=delete&id=' + id;
        document.getElementById('confirmDeleteModal').style.display = 'flex';
    }

    function closeConfirmDelete() {
        document.getElementById('confirmDeleteModal').style.display = 'none';
    }

    // Export CSV
    function exportTableToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#mainTable tr");
        
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length - 1; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            if (row.length > 0) csv.push(row.join(","));
        }

        const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        const downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>

</body>
</html>

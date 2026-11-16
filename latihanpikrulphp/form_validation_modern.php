<?php
// ========================================================
// FILE: form_validation_modern.php
// Versi: Luxury Royal Gold Theme (Tema Kuning Emas Elegan)
// ========================================================

$nama = $email = $website = $comment = $gender = $fileSaved = "";
$namaErr = $emailErr = $websiteErr = $genderErr = $fileErr = "";
$dbMessage = "";
$dbSuccess = false;
$isSubmitted = false;

$db_user = "root";
$db_pass = "";
$db_name = "datapikrul";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isSubmitted = true;
    $hasError = false;

    // Validasi Nama
    if (empty($_POST['name'])) {
        $namaErr = "Nama lengkap wajib diisi.";
        $hasError = true;
    } else {
        $nama = test_input($_POST['name']);
    }

    // Validasi Email
    if (empty($_POST['email'])) {
        $emailErr = "Alamat email wajib diisi.";
        $hasError = true;
    } else {
        $email = test_input($_POST['email']);
    }

    // Validasi Website
    if (empty($_POST["website"])) {
        $website = "";
    } else {
        $website = test_input($_POST["website"]);
    }

    // Validasi Catatan
    if (empty($_POST["comment"])) {
        $comment = "";
    } else {
        $comment = test_input($_POST["comment"]);
    }

    // Validasi Gender
    if (empty($_POST["gender"])) {
        $genderErr = "Silakan tentukan jenis kelamin.";
        $hasError = true;
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Upload Berkas
    $uploads_dir = "uploads";
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["fileToUpload"]["tmp_name"];
        $original_name = basename($_FILES["fileToUpload"]["name"]);

        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        $fileSaved = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $original_name);
        $destination = $uploads_dir . "/" . $fileSaved;

        if (!move_uploaded_file($tmp_name, $destination)) {
            $fileErr = "Gagal memproses berkas unggahan.";
            $fileSaved = "";
            $hasError = true;
        }
    }

    // Simpan ke Database
    if (!$hasError) {
        $conn = @mysqli_connect("127.0.0.1", $db_user, $db_pass, $db_name);
        if (!$conn) {
            $conn = @mysqli_connect("localhost", $db_user, $db_pass, $db_name);
        }

        if (!$conn) {
            $dbMessage = "Sistem database sedang dalam pemeliharaan. Silakan coba kembali nanti.";
            $dbSuccess = false;
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO sija2 (nama, email, website, komen, gender, File) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssss", $nama, $email, $website, $comment, $gender, $fileSaved);
                if (mysqli_stmt_execute($stmt)) {
                    $dbSuccess = true;
                    $dbMessage = "Formulir pendaftaran berhasil dikirim!";
                } else {
                    $dbMessage = "Terjadi kendala saat menyimpan pendaftaran Anda.";
                    $dbSuccess = false;
                }
                mysqli_stmt_close($stmt);
            } else {
                $nama_esc = mysqli_real_escape_string($conn, $nama);
                $email_esc = mysqli_real_escape_string($conn, $email);
                $website_esc = mysqli_real_escape_string($conn, $website);
                $comment_esc = mysqli_real_escape_string($conn, $comment);
                $gender_esc = mysqli_real_escape_string($conn, $gender);
                $file_esc = mysqli_real_escape_string($conn, $fileSaved);

                $simdb = "INSERT INTO sija2 (nama, email, website, komen, gender, File)
                          VALUES ('$nama_esc', '$email_esc', '$website_esc', '$comment_esc', '$gender_esc', '$file_esc')";

                if (mysqli_query($conn, $simdb)) {
                    $dbSuccess = true;
                    $dbMessage = "Formulir pendaftaran berhasil dikirim!";
                } else {
                    $dbMessage = "Terjadi kendala saat menyimpan data Anda.";
                    $dbSuccess = false;
                }
            }
            mysqli_close($conn);
        }
    } else {
        $dbMessage = "Mohon lengkapi bagian formulir yang masih bertanda peringatan.";
        $dbSuccess = false;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Registrasi Peserta - Edisi Emas</title>
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
            
            --bg-body: #0d0c0a;
            --surface-card: #161410;
            --surface-banner: #1c1811;
            --surface-input: #110f0c;
            
            --border-gold: rgba(234, 179, 8, 0.35);
            --border-subtle: #29241b;
            
            --text-gold-light: #fef9c3;
            --text-main: #f3f4f6;
            --text-muted: #a39c8f;
            
            --danger: #f87171;
            --success: #34d399;
            --radius-xl: 24px;
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
            background-color: var(--bg-body);
            background-image: 
                radial-gradient(at 0% 0%, rgba(234, 179, 8, 0.15) 0px, transparent 55%),
                radial-gradient(at 100% 0%, rgba(217, 119, 6, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(245, 158, 11, 0.1) 0px, transparent 60%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: var(--text-main);
        }

        .main-wrapper {
            width: 100%;
            max-width: 1050px;
            background: var(--surface-card);
            border-radius: var(--radius-xl);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 30px rgba(234, 179, 8, 0.15);
            border: 1px solid var(--border-gold);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1.35fr;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Side Banner */
        .side-banner {
            background: linear-gradient(155deg, #1f1b13 0%, #16130d 50%, #0d0c0a 100%);
            padding: 48px 40px;
            color: var(--text-main);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            border-right: 1px solid var(--border-gold);
        }

        .side-banner::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(234, 179, 8, 0.25) 0%, transparent 70%);
            filter: blur(30px);
        }

        .side-banner::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(217, 119, 6, 0.25) 0%, transparent 70%);
            filter: blur(35px);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(234, 179, 8, 0.15);
            border: 1.5px solid var(--gold-primary);
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--gold-light);
        }

        .brand-text {
            font-size: 1.3rem;
            font-weight: 800;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .banner-content {
            margin: 60px 0;
            position: relative;
            z-index: 2;
        }

        .banner-content h2 {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.03em;
            color: #ffffff;
        }

        .banner-content h2 span {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .banner-content p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .feature-list {
            list-style: none;
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            color: var(--text-gold-light);
        }

        .feature-item i {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(234, 179, 8, 0.2);
            color: var(--gold-primary);
            border: 1px solid rgba(234, 179, 8, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .banner-footer {
            position: relative;
            z-index: 2;
            font-size: 0.82rem;
            color: var(--gold-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Form Area */
        .form-area {
            padding: 44px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--surface-card);
        }

        .form-header {
            margin-bottom: 26px;
        }

        .form-header h3 {
            font-size: 1.65rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .form-header h3 span {
            color: var(--gold-primary);
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 0.92rem;
            margin-top: 4px;
        }

        /* Alert */
        .alert-box {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.92rem;
            animation: fadeIn 0.3s ease;
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

        /* Form Controls */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.86rem;
            font-weight: 600;
            color: var(--text-gold-light);
            margin-bottom: 8px;
        }

        .input-label .req {
            color: var(--gold-primary);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #786f5c;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .input-field {
            width: 100%;
            padding: 12px 14px 12px 42px;
            font-size: 0.94rem;
            color: #ffffff;
            background: var(--surface-input);
            border: 1.5px solid var(--border-subtle);
            border-radius: var(--radius-md);
            outline: none;
            transition: all 0.25s ease;
        }

        .input-field::placeholder {
            color: #615a4b;
        }

        .input-field:hover {
            border-color: #524731;
            background: #16130e;
        }

        .input-field:focus {
            background: #17140f;
            border-color: var(--gold-primary);
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.2);
        }

        .input-field:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--gold-primary);
        }

        .input-field.is-invalid {
            border-color: var(--danger);
            background: #1c1112;
        }

        textarea.input-field {
            padding: 12px 14px 12px 42px;
            min-height: 90px;
            resize: vertical;
        }

        .field-error {
            font-size: 0.8rem;
            color: var(--danger);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        /* Segmented Gender Selector */
        .gender-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 4px;
        }

        .gender-card {
            border: 1.5px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 12px 14px;
            background: var(--surface-input);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
            position: relative;
        }

        .gender-card input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .gender-card i {
            font-size: 17px;
            color: #786f5c;
            transition: color 0.2s ease;
        }

        .gender-card span {
            font-size: 0.92rem;
            font-weight: 600;
            color: #c4bdae;
        }

        .gender-card:hover {
            border-color: #524731;
            background: #16130e;
        }

        .gender-card.active {
            border-color: var(--gold-primary);
            background: rgba(234, 179, 8, 0.12);
            box-shadow: 0 0 12px rgba(234, 179, 8, 0.15);
        }

        .gender-card.active i,
        .gender-card.active span {
            color: var(--gold-light);
        }

        /* Upload Dropzone */
        .dropzone {
            border: 2px dashed rgba(234, 179, 8, 0.35);
            border-radius: var(--radius-md);
            background: #110f0c;
            padding: 22px 18px;
            text-align: center;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .dropzone:hover {
            border-color: var(--gold-primary);
            background: #16130e;
        }

        .dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .dropzone-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(234, 179, 8, 0.15);
            color: var(--gold-primary);
            border: 1px solid rgba(234, 179, 8, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin: 0 auto 10px;
            transition: transform 0.2s;
        }

        .dropzone:hover .dropzone-icon {
            transform: scale(1.1);
            color: var(--gold-light);
        }

        .dropzone-text {
            font-size: 0.9rem;
            color: #c4bdae;
            font-weight: 500;
        }

        .dropzone-text strong {
            color: var(--gold-primary);
        }

        .dropzone-hint {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .file-preview {
            display: none;
            align-items: center;
            gap: 12px;
            background: #1a1711;
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-sm);
            padding: 8px 12px;
            margin-top: 10px;
            text-align: left;
        }

        .file-preview img {
            width: 42px;
            height: 42px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--border-gold);
        }

        .file-preview-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gold-light);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Buttons */
        .btn-wrapper {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .btn-submit {
            flex: 2;
            padding: 13px 24px;
            border-radius: var(--radius-md);
            background: var(--gold-gradient);
            color: #0d0c0a;
            font-size: 0.98rem;
            font-weight: 800;
            border: none;
            cursor: pointer;
            box-shadow: var(--gold-glow);
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            background: var(--gold-gradient-hover);
            box-shadow: 0 0 28px rgba(234, 179, 8, 0.55);
        }

        .btn-reset {
            flex: 1;
            padding: 13px 18px;
            border-radius: var(--radius-md);
            background: #1e1b15;
            color: var(--text-gold-light);
            font-size: 0.95rem;
            font-weight: 600;
            border: 1px solid var(--border-subtle);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-reset:hover {
            background: #2b261d;
            border-color: var(--border-gold);
        }

        /* Receipt Confirmation */
        .receipt-container {
            margin-top: 24px;
            background: #18150f;
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-lg);
            padding: 24px;
            animation: fadeIn 0.4s ease;
        }

        .receipt-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #29241b;
        }

        .receipt-header .badge-check {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(234, 179, 8, 0.2);
            color: var(--gold-primary);
            border: 1px solid var(--gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .receipt-header h4 {
            font-size: 1.15rem;
            color: #ffffff;
            font-weight: 800;
        }

        .receipt-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            font-size: 0.88rem;
        }

        .receipt-item label {
            display: block;
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-bottom: 2px;
        }

        .receipt-item span {
            font-weight: 700;
            color: var(--gold-light);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (max-width: 860px) {
            .main-wrapper {
                grid-template-columns: 1fr;
            }
            .side-banner {
                padding: 32px 24px;
                border-right: none;
                border-bottom: 1px solid var(--border-gold);
            }
            .banner-content {
                margin: 24px 0;
            }
            .form-area {
                padding: 32px 24px;
            }
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Panel Kiri: Hero Banner Emas -->
    <div class="side-banner">
        <div class="brand-logo">
            <div class="brand-icon">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div class="brand-text">PortalRegistrasi</div>
        </div>

        <div class="banner-content">
            <h2>Pendaftaran<br><span>Cepat & Eksklusif.</span></h2>
            <p>Silakan isi informasi data diri Anda secara lengkap dan akurat melalui formulir digital resmi bertema royal gold ini.</p>
            
            <ul class="feature-list">
                <li class="feature-item">
                    <i class="fa-solid fa-check"></i>
                    <span>Proses instan langsung terverifikasi</span>
                </li>
                <li class="feature-item">
                    <i class="fa-solid fa-check"></i>
                    <span>Keamanan data terlindungi aman</span>
                </li>
                <li class="feature-item">
                    <i class="fa-solid fa-check"></i>
                    <span>Mendukung upload berkas lampiran</span>
                </li>
            </ul>
        </div>

        <div class="banner-footer">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Sistem Formulir Terverifikasi</span>
        </div>
    </div>

    <!-- Panel Kanan: Form Input Emas -->
    <div class="form-area">
        <div class="form-header">
            <h3>Isi Data <span>Formulir</span></h3>
            <p>Lengkapi formulir di bawah ini dengan identitas Anda yang valid</p>
        </div>

        <?php if (!empty($dbMessage)): ?>
            <div class="alert-box <?php echo $dbSuccess ? 'alert-success' : 'alert-danger'; ?>">
                <i class="fa-solid <?php echo $dbSuccess ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
                <span><?php echo $dbMessage; ?></span>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            
            <!-- Nama Lengkap -->
            <div class="input-group">
                <div class="input-label">
                    <span>Nama Lengkap <span class="req">*</span></span>
                </div>
                <div class="input-wrapper">
                    <i class="fa-regular fa-user input-icon"></i>
                    <input 
                        type="text" 
                        name="name" 
                        class="input-field <?php echo !empty($namaErr) ? 'is-invalid' : ''; ?>" 
                        placeholder="Contoh: Muhammad Fiqrul" 
                        value="<?php echo htmlspecialchars($nama); ?>"
                        required
                    >
                </div>
                <?php if (!empty($namaErr)): ?>
                    <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $namaErr; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <!-- Alamat Email -->
                <div class="input-group">
                    <div class="input-label">
                        <span>Alamat Email <span class="req">*</span></span>
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            name="email" 
                            class="input-field <?php echo !empty($emailErr) ? 'is-invalid' : ''; ?>" 
                            placeholder="nama@email.com" 
                            value="<?php echo htmlspecialchars($email); ?>"
                            required
                        >
                    </div>
                    <?php if (!empty($emailErr)): ?>
                        <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $emailErr; ?></div>
                    <?php endif; ?>
                </div>

                <!-- Website / Portofolio -->
                <div class="input-group">
                    <div class="input-label">
                        <span>Website / Tautan</span>
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-globe input-icon"></i>
                        <input 
                            type="text" 
                            name="website" 
                            class="input-field" 
                            placeholder="https://portofolio.me" 
                            value="<?php echo htmlspecialchars($website); ?>"
                        >
                    </div>
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="input-group">
                <div class="input-label">
                    <span>Jenis Kelamin <span class="req">*</span></span>
                </div>
                <div class="gender-selector">
                    <label class="gender-card <?php echo ($gender == 'female') ? 'active' : ''; ?>">
                        <input type="radio" name="gender" value="female" <?php if ($gender == "female") echo "checked"; ?> required>
                        <i class="fa-solid fa-venus"></i>
                        <span>Perempuan</span>
                    </label>
                    <label class="gender-card <?php echo ($gender == 'male') ? 'active' : ''; ?>">
                        <input type="radio" name="gender" value="male" <?php if ($gender == "male") echo "checked"; ?> required>
                        <i class="fa-solid fa-mars"></i>
                        <span>Laki-laki</span>
                    </label>
                </div>
                <?php if (!empty($genderErr)): ?>
                    <div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $genderErr; ?></div>
                <?php endif; ?>
            </div>

            <!-- Catatan / Komentar -->
            <div class="input-group">
                <div class="input-label">
                    <span>Pesan atau Catatan Tambahan</span>
                </div>
                <div class="input-wrapper">
                    <i class="fa-regular fa-comment-dots input-icon" style="top: 14px;"></i>
                    <textarea 
                        name="comment" 
                        class="input-field" 
                        placeholder="Tuliskan pesan atau keterangan tambahan Anda di sini..."
                    ><?php echo htmlspecialchars($comment); ?></textarea>
                </div>
            </div>

            <!-- Upload Berkas -->
            <div class="input-group">
                <div class="input-label">
                    <span>Unggah Berkas / Foto Lampiran</span>
                </div>
                <div class="dropzone">
                    <input type="file" name="fileToUpload" id="fileInput" onchange="previewSelectedFile(this)">
                    <div class="dropzone-icon">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div class="dropzone-text">
                        <strong>Klik untuk memilih berkas</strong> atau seret ke sini
                    </div>
                    <div class="dropzone-hint">Format foto (JPG, PNG, GIF, WEBP) atau PDF</div>
                </div>
                
                <div class="file-preview" id="previewArea">
                    <img id="previewImg" src="" alt="Thumbnail">
                    <div class="file-preview-info">
                        <div class="file-preview-name" id="fileNameText"></div>
                        <span style="font-size: 0.75rem; color: var(--gold-primary); font-weight: 700;"><i class="fa-solid fa-check"></i> Siap diunggah</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Pengiriman -->
            <div class="btn-wrapper">
                <button type="submit" class="btn-submit">
                    <span>Kirim Formulir Sekarang</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button type="button" class="btn-reset" onclick="window.location.href='form_validation_modern.php'">
                    <span>Reset</span>
                </button>
            </div>
        </form>

        <!-- Tanda Terima Konfirmasi Instan -->
        <?php if ($isSubmitted && $dbSuccess): ?>
            <div class="receipt-container">
                <div class="receipt-header">
                    <div class="badge-check">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <h4>Pendaftaran Terkonfirmasi</h4>
                        <span style="font-size: 0.82rem; color: var(--text-muted);">Data Anda telah kami rekam dengan sukses.</span>
                    </div>
                </div>
                <div class="receipt-grid">
                    <div class="receipt-item">
                        <label>Nama Lengkap</label>
                        <span><?php echo htmlspecialchars($nama); ?></span>
                    </div>
                    <div class="receipt-item">
                        <label>Email Terdaftar</label>
                        <span><?php echo htmlspecialchars($email); ?></span>
                    </div>
                    <div class="receipt-item">
                        <label>Jenis Kelamin</label>
                        <span><?php echo ($gender == 'female') ? 'Perempuan' : 'Laki-laki'; ?></span>
                    </div>
                    <div class="receipt-item">
                        <label>Status Berkas</label>
                        <span style="color: var(--gold-primary);">
                            <?php echo !empty($fileSaved) ? '✓ Lampiran Diunggah' : '- Tanpa Lampiran -'; ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function previewSelectedFile(input) {
        const previewArea = document.getElementById('previewArea');
        const previewImg = document.getElementById('previewImg');
        const fileNameText = document.getElementById('fileNameText');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileNameText.textContent = file.name;
            previewArea.style.display = 'flex';

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewImg.style.display = 'none';
            }
        } else {
            previewArea.style.display = 'none';
        }
    }

    document.querySelectorAll('.gender-card input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.gender-card').forEach(c => c.classList.remove('active'));
            if (this.checked) {
                this.closest('.gender-card').classList.add('active');
            }
        });
    });
</script>

</body>
</html>

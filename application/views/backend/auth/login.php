<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">
    <title><?= $title ?> | <?= $company['company_name'] ?></title>

    <!-- Custom fonts -->
    <link href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/backend/') ?>css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        :root {
            --nm-bg: #e0e5ec;
            --nm-shadow-dark: #a3b1c6;
            --nm-shadow-light: #ffffff;
            --nm-accent: #f47b20;
            --nm-accent-dark: #d96a15;
            --nm-text: #2d3748;
            --nm-text-muted: #718096;
            --nm-radius: 16px;
            --nm-radius-lg: 24px;
            --nm-radius-full: 50px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--nm-bg) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Nunito', sans-serif;
            padding: 20px;
        }

        .nm-login-container {
            width: 100%;
            max-width: 440px;
            animation: nmFadeIn 0.6s ease-out;
        }

        @keyframes nmFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nm-login-card {
            background: var(--nm-bg);
            border-radius: var(--nm-radius-lg);
            padding: 40px 36px;
            box-shadow: 8px 8px 20px var(--nm-shadow-dark),
                        -8px -8px 20px var(--nm-shadow-light);
            transition: box-shadow 0.3s ease;
        }

        .nm-login-card:hover {
            box-shadow: 10px 10px 25px var(--nm-shadow-dark),
                        -10px -10px 25px var(--nm-shadow-light);
        }

        /* Logo */
        .nm-logo-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 28px;
        }

        .nm-logo-circle {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: var(--nm-bg);
            box-shadow: 6px 6px 14px var(--nm-shadow-dark),
                        -6px -6px 14px var(--nm-shadow-light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 14px;
        }

        .nm-logo-circle img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Title */
        .nm-login-title {
            text-align: center;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--nm-text);
            margin-bottom: 6px;
        }

        .nm-login-subtitle {
            text-align: center;
            font-size: 0.85rem;
            color: var(--nm-text-muted);
            margin-bottom: 28px;
        }

        /* Mode Selector (Radio Buttons) */
        .nm-mode-selector {
            display: flex;
            gap: 12px;
            margin-bottom: 22px;
        }

        .nm-mode-option {
            flex: 1;
        }

        .nm-mode-option input[type="radio"] {
            display: none;
        }

        .nm-mode-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: var(--nm-radius);
            background: var(--nm-bg);
            box-shadow: 4px 4px 10px var(--nm-shadow-dark),
                        -4px -4px 10px var(--nm-shadow-light);
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--nm-text-muted);
            transition: all 0.25s ease;
            user-select: none;
        }

        .nm-mode-option label i {
            font-size: 1rem;
        }

        .nm-mode-option input[type="radio"]:checked + label {
            box-shadow: inset 3px 3px 7px var(--nm-shadow-dark),
                        inset -3px -3px 7px var(--nm-shadow-light);
            color: var(--nm-accent);
            font-weight: 600;
        }

        /* Input Fields */
        .nm-input-group {
            margin-bottom: 18px;
            position: relative;
        }

        .nm-input-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--nm-text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nm-input-group .nm-input-icon {
            position: absolute;
            left: 18px;
            bottom: 14px;
            color: var(--nm-text-muted);
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.25s ease;
        }

        .nm-input {
            width: 100%;
            padding: 13px 16px 13px 46px;
            border: none;
            border-radius: var(--nm-radius);
            background: var(--nm-bg);
            box-shadow: inset 4px 4px 8px var(--nm-shadow-dark),
                        inset -4px -4px 8px var(--nm-shadow-light);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: var(--nm-text);
            outline: none;
            transition: all 0.25s ease;
        }

        .nm-input::placeholder {
            color: #b0bec5;
        }

        .nm-input:focus {
            box-shadow: inset 5px 5px 10px var(--nm-shadow-dark),
                        inset -5px -5px 10px var(--nm-shadow-light),
                        0 0 0 3px rgba(244, 123, 32, 0.15);
        }

        .nm-input:focus ~ .nm-input-icon {
            color: var(--nm-accent);
        }

        .nm-input-error {
            display: block;
            margin-top: 6px;
            padding-left: 4px;
        }

        /* Password toggle */
        .nm-password-toggle {
            position: absolute;
            right: 16px;
            bottom: 14px;
            background: none;
            border: none;
            color: var(--nm-text-muted);
            cursor: pointer;
            font-size: 0.95rem;
            padding: 0;
            transition: color 0.2s ease;
        }

        .nm-password-toggle:hover {
            color: var(--nm-accent);
        }

        /* Remember Me */
        .nm-remember-row {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .nm-checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .nm-checkbox-wrapper input[type="checkbox"] {
            display: none;
        }

        .nm-checkbox-visual {
            width: 22px;
            height: 22px;
            border-radius: 7px;
            background: var(--nm-bg);
            box-shadow: 3px 3px 6px var(--nm-shadow-dark),
                        -3px -3px 6px var(--nm-shadow-light);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .nm-checkbox-visual i {
            font-size: 0.7rem;
            color: transparent;
            transition: color 0.2s ease;
        }

        .nm-checkbox-wrapper input[type="checkbox"]:checked + .nm-checkbox-visual {
            box-shadow: inset 3px 3px 6px var(--nm-shadow-dark),
                        inset -3px -3px 6px var(--nm-shadow-light);
        }

        .nm-checkbox-wrapper input[type="checkbox"]:checked + .nm-checkbox-visual i {
            color: var(--nm-accent);
        }

        .nm-checkbox-label {
            font-size: 0.85rem;
            color: var(--nm-text-muted);
            user-select: none;
        }

        /* Submit Button */
        .nm-btn-login {
            width: 100%;
            padding: 14px 24px;
            border: none;
            border-radius: var(--nm-radius);
            background: linear-gradient(135deg, var(--nm-accent) 0%, var(--nm-accent-dark) 100%);
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            box-shadow: 5px 5px 12px var(--nm-shadow-dark),
                        -5px -5px 12px var(--nm-shadow-light),
                        0 4px 15px rgba(244, 123, 32, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nm-btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 6px 6px 16px var(--nm-shadow-dark),
                        -6px -6px 16px var(--nm-shadow-light),
                        0 8px 25px rgba(244, 123, 32, 0.4);
        }

        .nm-btn-login:active {
            transform: translateY(0);
            box-shadow: inset 3px 3px 7px rgba(0,0,0,0.15),
                        0 2px 8px rgba(244, 123, 32, 0.25);
        }

        .nm-btn-login i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .nm-btn-login:hover i {
            transform: translateX(3px);
        }

        /* Divider */
        .nm-divider {
            display: flex;
            align-items: center;
            margin: 24px 0 20px;
        }

        .nm-divider::before,
        .nm-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--nm-shadow-dark), transparent);
        }

        .nm-divider span {
            padding: 0 14px;
            font-size: 0.75rem;
            color: var(--nm-text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Footer Links */
        .nm-footer-links {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .nm-footer-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            border-radius: var(--nm-radius);
            background: var(--nm-bg);
            box-shadow: 3px 3px 8px var(--nm-shadow-dark),
                        -3px -3px 8px var(--nm-shadow-light);
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--nm-text-muted);
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .nm-footer-link:hover {
            color: var(--nm-accent);
            box-shadow: inset 3px 3px 6px var(--nm-shadow-dark),
                        inset -3px -3px 6px var(--nm-shadow-light);
            text-decoration: none;
        }

        /* Alert messages */
        .nm-alert {
            padding: 12px 16px;
            border-radius: var(--nm-radius);
            margin-bottom: 20px;
            font-size: 0.85rem;
            box-shadow: inset 3px 3px 6px var(--nm-shadow-dark),
                        inset -3px -3px 6px var(--nm-shadow-light);
        }

        /* Override sb-admin alerts */
        .alert {
            border: none !important;
            border-radius: var(--nm-radius) !important;
            box-shadow: inset 3px 3px 6px var(--nm-shadow-dark),
                        inset -3px -3px 6px var(--nm-shadow-light) !important;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .nm-login-card {
                padding: 30px 24px;
                border-radius: 20px;
            }

            .nm-logo-circle {
                width: 80px;
                height: 80px;
            }

            .nm-login-title {
                font-size: 1.15rem;
            }

            .nm-mode-option label {
                padding: 8px 12px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>

    <div class="nm-login-container">
        <div class="nm-login-card">

            <!-- Logo -->
            <div class="nm-logo-wrapper">
                <div class="nm-logo-circle">
                    <img src="<?= base_url('assets/images/logo-gayuhnet.png') ?>" alt="GayuhNet Logo">
                </div>
            </div>

            <!-- Title -->
            <h1 class="nm-login-title">Selamat Datang</h1>
            <p class="nm-login-subtitle">Masuk ke akun Anda untuk melanjutkan</p>

            <!-- Flash Messages -->
            <?php $this->view('messages') ?>

            <!-- Login Form -->
            <form action="" method="post">

                <!-- Mode Selector -->
                <?php $mode = isset($_COOKIE["loginMode"]) ? $_COOKIE["loginMode"] : ''; ?>
                <div class="nm-mode-selector">
                    <div class="nm-mode-option">
                        <input type="radio" id="mode-email" name="mode" value="email" <?php if ($mode == 'email' || $mode == '') echo 'checked'; ?> required>
                        <label for="mode-email">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                    </div>
                    <div class="nm-mode-option">
                        <input type="radio" id="mode-phone" name="mode" value="phone" <?php if ($mode == 'phone') echo 'checked'; ?> required>
                        <label for="mode-phone">
                            <i class="fas fa-phone-alt"></i> Phone
                        </label>
                    </div>
                </div>

                <!-- Email/Phone Input -->
                <div class="nm-input-group">
                    <label for="exampleInputEmail">Email atau Telepon</label>
                    <input type="text" name="email" class="nm-input" id="exampleInputEmail"
                           value="<?php if (isset($_COOKIE["loginId"])) echo $_COOKIE["loginId"]; ?>"
                           placeholder="Masukkan email atau nomor telepon"
                           autocomplete="username">
                    <i class="fas fa-user nm-input-icon"></i>
                    <?= form_error('email', '<small class="text-danger nm-input-error">', '</small>') ?>
                </div>

                <!-- Password Input -->
                <div class="nm-input-group">
                    <label for="exampleInputPassword">Password</label>
                    <input type="password" name="password" class="nm-input" id="exampleInputPassword"
                           placeholder="Masukkan password"
                           value="<?php if (isset($_COOKIE["loginPass"])) echo $_COOKIE["loginPass"]; ?>"
                           autocomplete="current-password">
                    <i class="fas fa-lock nm-input-icon"></i>
                    <button type="button" class="nm-password-toggle" onclick="togglePassword()" aria-label="Toggle password visibility">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                    <?= form_error('password', '<small class="text-danger nm-input-error">', '</small>') ?>
                </div>

                <!-- Remember Me -->
                <div class="nm-remember-row">
                    <label class="nm-checkbox-wrapper">
                        <input type="checkbox" name="remember" id="remember" <?php if (isset($_COOKIE["loginId"])) { ?> checked="checked" <?php } ?>>
                        <span class="nm-checkbox-visual"><i class="fas fa-check"></i></span>
                        <span class="nm-checkbox-label">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="nm-btn-login">
                    Masuk <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="nm-divider"><span>atau</span></div>

            <!-- Footer Links -->
            <?php $role = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
            <div class="nm-footer-links">
                <a class="nm-footer-link" href="<?= site_url('auth/forgotpassword') ?>">
                    <i class="fas fa-key"></i> Lupa Password?
                </a>
                <?php if (isset($role['register_show']) && $role['register_show'] == 1) { ?>
                    <a class="nm-footer-link" href="<?= site_url('auth/register') ?>">
                        <i class="fas fa-user-plus"></i> Buat Akun Baru
                    </a>
                <?php } ?>
            </div>

        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>js/sb-admin-2.min.js"></script>

    <script>
        function togglePassword() {
            const input = document.getElementById('exampleInputPassword');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>
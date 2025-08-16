<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Koperasi Simpan Pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-muted: #64748b;
            --text-dark: #1a202c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--light-bg) 0%, #e2e8f0 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .register-card {
            width: 100%;
            max-width: 800px;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .card-body {
            padding: 2.5rem;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo img {
            max-height: 70px;
            width: auto;
        }

        h3 {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        h5 {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 1rem;
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            padding: 0.75rem 1rem;
            padding-right: 2.5rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: none;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background-color: var(--light-bg);
            border: 1px solid var(--border-color);
            border-right: none;
            font-weight: 600;
        }

        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            z-index: 10;
            font-size: 1.1rem;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-outline-secondary {
            color: var(--text-muted);
            border: 2px solid var(--border-color);
            background-color: transparent;
        }

        .btn-outline-secondary:hover {
            background-color: var(--light-bg);
            color: #334155;
            border-color: #cbd5e1;
        }

        /* Steps */
        .steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2.5rem;
            position: relative;
            padding: 0 20px;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 10%;
            width: 80%;
            height: 2px;
            background-color: var(--border-color);
            z-index: 1;
        }

        .step-wrapper {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .step {
            background-color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            border: 2px solid var(--border-color);
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .step.active {
            background-color: var(--primary-color);
            color: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .step-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-top: 0.5rem;
            white-space: nowrap;
        }

        .step-wrapper.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Gender Options */
        .gender-options {
            display: flex;
            gap: 12px;
        }

        .gender-option {
            flex: 1;
            position: relative;
        }

        .gender-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .gender-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .gender-option input[type="radio"]:checked + label {
            border-color: var(--primary-color);
            background-color: rgba(59, 130, 246, 0.05);
            color: var(--primary-color);
        }

        .gender-option label:hover {
            border-color: #cbd5e1;
            background-color: var(--light-bg);
        }

        .gender-option i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
        }

        .progress {
            height: 6px;
            background-color: var(--border-color);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        /* Alert */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background-color: #fee;
            color: #dc3545;
        }

        .alert ul {
            margin-bottom: 0;
            padding-left: 1.5rem;
        }

        /* Form Check */
        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            margin-top: 0.1rem;
            cursor: pointer;
        }

        .form-check-label {
            cursor: pointer;
            font-size: 0.95rem;
            margin-left: 0.5rem;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        /* Form Steps */
        .form-step {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Utilities */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .steps {
                padding: 0 10px;
            }

            .step-label {
                font-size: 0.7rem;
            }

            .row > [class*="col-"] {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="card">
                <div class="card-body">
                    <div class="logo">
                        <img src="image/logo.jpg" alt="Logo Koperasi">
                    </div>

                    <h3 class="text-center">Daftar Akun Baru</h3>
                    <h5 class="text-center text-muted mb-4">Bergabunglah dengan Koperasi Simpan Pinjam</h5>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Terdapat kesalahan:</strong>
                            <ul class="mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="steps">
                        <div class="step-wrapper active">
                            <div class="step active">1</div>
                            <div class="step-label">Data Pribadi</div>
                        </div>
                        <div class="step-wrapper">
                            <div class="step">2</div>
                            <div class="step-label">Informasi Tambahan</div>
                        </div>
                        <div class="step-wrapper">
                            <div class="step">3</div>
                            <div class="step-label">Keamanan</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <!-- Step 1: Data Pribadi -->
                        <div id="step1" class="form-step">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name') }}"
                                               placeholder="Masukkan nama lengkap"
                                               required>
                                        <span class="input-icon">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('nik') is-invalid @enderror"
                                               id="nik"
                                               name="nik"
                                               value="{{ old('nik') }}"
                                               placeholder="16 digit NIK"
                                               maxlength="16"
                                               pattern="[0-9]{16}"
                                               required>
                                        <span class="input-icon">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="nama@email.com"
                                               required>
                                        <span class="input-icon">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <div class="input-group">
                                        <input type="tel"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               id="phone"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               placeholder="08xxxxxxxxxx"
                                               pattern="[0-9]{10,13}"
                                               required>
                                        <span class="input-icon">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="date"
                                               class="form-control @error('birth_date') is-invalid @enderror"
                                               id="birth_date"
                                               name="birth_date"
                                               value="{{ old('birth_date') }}"
                                               max="{{ date('Y-m-d', strtotime('-17 years')) }}"
                                               required>
                                        <span class="input-icon">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div class="gender-options">
                                        <div class="gender-option">
                                            <input type="radio"
                                                   id="gender_l"
                                                   name="gender"
                                                   value="L"
                                                   {{ old('gender') == 'L' ? 'checked' : '' }}
                                                   required>
                                            <label for="gender_l">
                                                <i class="fas fa-male"></i>
                                                <span>Laki-laki</span>
                                            </label>
                                        </div>
                                        <div class="gender-option">
                                            <input type="radio"
                                                   id="gender_p"
                                                   name="gender"
                                                   value="P"
                                                   {{ old('gender') == 'P' ? 'checked' : '' }}
                                                   required>
                                            <label for="gender_p">
                                                <i class="fas fa-female"></i>
                                                <span>Perempuan</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary" id="nextStep1">
                                    Lanjutkan <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Informasi Tambahan -->
                        <div id="step2" class="form-step" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="3"
                                              placeholder="Masukkan alamat lengkap tempat tinggal"
                                              required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="occupation" class="form-label">Pekerjaan</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('occupation') is-invalid @enderror"
                                               id="occupation"
                                               name="occupation"
                                               value="{{ old('occupation') }}"
                                               placeholder="Contoh: Karyawan Swasta"
                                               required>
                                        <span class="input-icon">
                                            <i class="fas fa-briefcase"></i>
                                        </span>
                                        @error('occupation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="monthly_income" class="form-label">Pendapatan Bulanan</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number"
                                               class="form-control @error('monthly_income') is-invalid @enderror"
                                               id="monthly_income"
                                               name="monthly_income"
                                               value="{{ old('monthly_income') }}"
                                               placeholder="5000000"
                                               min="0"
                                               required>
                                        @error('monthly_income')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Masukkan angka tanpa titik atau koma</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary" id="prevStep1">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </button>
                                <button type="button" class="btn btn-primary" id="nextStep2">
                                    Lanjutkan <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Keamanan -->
                        <div id="step3" class="form-step" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="Minimal 8 karakter"
                                               minlength="8"
                                               required>
                                        <span class="input-icon" id="togglePassword">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="password-strength">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" id="passwordStrength"></div>
                                        </div>
                                        <small class="text-muted" id="passwordStrengthText">Masukkan password</small>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="Ulangi password"
                                               minlength="8"
                                               required>
                                        <span class="input-icon" id="toggleConfirmPassword">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback" id="passwordMatchError" style="display: none;">
                                        Password tidak cocok
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="agree_terms"
                                           name="agree_terms"
                                           required>
                                    <label class="form-check-label" for="agree_terms">
                                        Saya menyetujui <a href="#" class="text-decoration-none">syarat dan ketentuan</a> yang berlaku
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary" id="prevStep2">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    Daftar Sekarang <i class="fas fa-user-plus ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="login-link">
                        <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation state
        let currentStep = 1;
        const totalSteps = 3;

        // Toggle password visibility
        function setupPasswordToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);

            toggle.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        }

        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('toggleConfirmPassword', 'password_confirmation');

        // Step navigation
        function showStep(stepNumber) {
            // Hide all steps
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step${i}`).style.display = 'none';
            }

            // Show current step
            document.getElementById(`step${stepNumber}`).style.display = 'block';

            // Update step indicators
            document.querySelectorAll('.step-wrapper').forEach((wrapper, index) => {
                if (index < stepNumber) {
                    wrapper.classList.add('active');
                    wrapper.querySelector('.step').classList.add('active');
                } else {
                    wrapper.classList.remove('active');
                    wrapper.querySelector('.step').classList.remove('active');
                }
            });

            currentStep = stepNumber;
        }

        // Validate step 1
        function validateStep1() {
            const fields = ['name', 'nik', 'email', 'phone', 'birth_date'];
            let isValid = true;

            fields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Check gender selection
            const genderSelected = document.querySelector('input[name="gender"]:checked');
            if (!genderSelected) {
                isValid = false;
            }

            return isValid;
        }

        // Validate step 2
        function validateStep2() {
            const fields = ['address', 'occupation', 'monthly_income'];
            let isValid = true;

            fields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        // Navigation buttons
        document.getElementById('nextStep1').addEventListener('click', function() {
            if (validateStep1()) {
                showStep(2);
            }
        });

        document.getElementById('prevStep1').addEventListener('click', function() {
            showStep(1);
        });

        document.getElementById('nextStep2').addEventListener('click', function() {
            if (validateStep2()) {
                showStep(3);
            }
        });

        document.getElementById('prevStep2').addEventListener('click', function() {
            showStep(2);
        });

        // Password strength meter
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            if (/[^A-Za-z0-9]/.test(password)) strength += 25;

            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('passwordStrengthText');

            strengthBar.style.width = strength + '%';

            if (password.length === 0) {
                strengthBar.className = 'progress-bar';
                strengthText.textContent = 'Masukkan password';
            } else if (strength <= 25) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Password lemah';
            } else if (strength <= 50) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Password sedang';
            } else if (strength <= 75) {
                strengthBar.className = 'progress-bar bg-info';
                strengthText.textContent = 'Password kuat';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Password sangat kuat';
            }

            // Check password match
            checkPasswordMatch();
        });

        // Password confirmation check
        document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const errorDiv = document.getElementById('passwordMatchError');
            const confirmInput = document.getElementById('password_confirmation');

            if (confirmPassword && password !== confirmPassword) {
                confirmInput.classList.add('is-invalid');
                errorDiv.style.display = 'block';
            } else {
                confirmInput.classList.remove('is-invalid');
                errorDiv.style.display = 'none';
            }
        }

        // Form submission validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const agreeTerms = document.getElementById('agree_terms').checked;

            if (password !== confirmPassword) {
                e.preventDefault();
                document.getElementById('password_confirmation').classList.add('is-invalid');
                document.getElementById('passwordMatchError').style.display = 'block';
                return;
            }

            if (!agreeTerms) {
                e.preventDefault();
                alert('Anda harus menyetujui syarat dan ketentuan');
                return;
            }
        });

        // Input formatting
        document.getElementById('nik').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });

        document.getElementById('phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 13);
        });

        document.getElementById('monthly_income').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
</body>
</html>

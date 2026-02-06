<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Register </title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/toastr.min.css" />
    
    <link rel="stylesheet" href="css/main.css?v=1770402982">
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            
            <div class="brand-logo">
                <img src="images/logo.png" alt="Logo" onerror="this.style.display='none'">
                <h1>CREATE ACCOUNT</h1>
                <p>Register to start winning</p>
            </div>

            <div class="nav-tabs">
                <div class="nav-item active" onclick="setMode('phone')">Phone</div>
                <div class="nav-item" onclick="setMode('email')">Email</div>
            </div>

            <form id="registerForm" onsubmit="handleRegister(event)">
                
                <div id="methodPhone" class="auth-method" style="display:block;">
                    <div class="input-group">
                        <input type="tel" name="mobile" id="inpMobile" placeholder="Mobile Number" maxlength="10" required 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        <i class="fas fa-phone-alt input-icon"></i>
                    </div>
                </div>

                <div id="methodEmail" class="auth-method" style="display:none;">
                    <div class="input-group">
                        <input type="email" name="email" id="inpEmail" placeholder="Email Address">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="inpPass" placeholder="Set Password" required>
                    <i class="fas fa-lock input-icon"></i>
                    <i class="fas fa-eye password-toggle" id="eyeIcon" onclick="togglePassword()"></i>
                </div>

                <div class="input-group">
                    <input type="text" name="referral" placeholder="Referral Code (Optional)">
                    <i class="fas fa-ticket-alt input-icon"></i>
                </div>

                <input type="hidden" name="method" id="regMethod" value="phone">

                <button type="submit" class="btn-primary" id="btnSubmit">REGISTER NOW</button>

                <div class="register-link">
                    Already have an account? <a href="login.php">Login Here</a>
                </div>
            </form>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/toastr.min.js"></script>
    <script>
        toastr.options = {"positionClass": "toast-top-center"};

        // Prevent Copy/Paste & Context Menu
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && (event.key === 'c' || event.key === 'u' || event.key === 's')) {
                event.preventDefault();
            }
        });

        function togglePassword() {
            const x = document.getElementById("inpPass");
            const icon = document.getElementById("eyeIcon");
            if (x.type === "password") {
                x.type = "text"; icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                x.type = "password"; icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        function setMode(mode) {
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            if(mode === 'phone') {
                document.querySelector('.nav-item:first-child').classList.add('active');
                document.getElementById('methodPhone').style.display = 'block';
                document.getElementById('methodEmail').style.display = 'none';
                document.getElementById('regMethod').value = 'phone';
                document.getElementById('inpMobile').required = true;
                document.getElementById('inpEmail').required = false;
            } else {
                document.querySelector('.nav-item:last-child').classList.add('active');
                document.getElementById('methodPhone').style.display = 'none';
                document.getElementById('methodEmail').style.display = 'block';
                document.getElementById('regMethod').value = 'email';
                document.getElementById('inpMobile').required = false;
                document.getElementById('inpEmail').required = true;
            }
        }

        function handleRegister(e) {
            e.preventDefault();
            
            // Mobile Validation
            if ($('#regMethod').val() === 'phone') {
                let mob = $('#inpMobile').val();
                if (mob.length !== 10) {
                    toastr.error("Mobile number must be exactly 10 digits.");
                    return;
                }
            }

            let btn = $('#btnSubmit');
            let oldText = btn.text();
            
            btn.html('Creating...').css('opacity', 0.7).prop('disabled', true);

            $.ajax({
                url: 'api/auth_register.php',
                type: 'POST',
                data: $('#registerForm').serialize(),
                success: function(res) {
                    try {
                        let data = typeof res === 'object' ? res : JSON.parse(res);
                        if(data.status === 'success') {
                            toastr.success(data.message);
                            setTimeout(() => window.location.href = 'index.php', 1500);
                        } else {
                            toastr.error(data.message);
                            btn.html(oldText).css('opacity', 1).prop('disabled', false);
                        }
                    } catch(err) {
                        toastr.error("Server Error");
                        btn.html(oldText).css('opacity', 1).prop('disabled', false);
                    }
                },
                error: function() {
                    toastr.error("Network Connection Failed");
                    btn.html(oldText).css('opacity', 1).prop('disabled', false);
                }
            });
        }
    </script>
<script defer src="js/vcd15cbe7772f49c399c6a5babf22c1241717689176015.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
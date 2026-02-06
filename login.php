
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/toastr.min.css" />
    <link rel="stylesheet" href="css/main.css?v=1770406223">
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            
            <div class="brand-logo">
                <img src="images/logo.png" alt="Logo" onerror="this.style.display='none'">
                <h1>WELCOME</h1>
                <p>Login to continue</p>
            </div>

            <div class="nav-tabs">
                <div class="nav-item active" onclick="setMode('phone')">Phone</div>
                <div class="nav-item" onclick="setMode('email')">Email</div>
            </div>

            <form id="loginForm" onsubmit="handleLogin(event)">
                
                <div id="methodPhone" class="auth-method" style="display:block;">
                    <div class="input-group">
                        <input type="tel" name="mobile" id="inpMobile" placeholder="Mobile Number" maxlength="10" required>
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
                    <input type="password" name="password" id="inpPass" placeholder="Password" required>
                    <i class="fas fa-lock input-icon"></i>
                    <i class="fas fa-eye password-toggle" id="eyeIcon" onclick="togglePassword()"></i>
                </div>

                <div style="text-align:right; margin-bottom:20px;">
                    <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
                </div>

                <input type="hidden" name="method" id="loginMethod" value="phone">

                <button type="submit" class="btn-primary" id="btnSubmit">LOGIN</button>

                <div class="register-link">
                    No account? <a href="register.php">Create Account</a>
                </div>
            </form>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/toastr.min.js"></script>
    <script>
        toastr.options = {"positionClass": "toast-top-center"};

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
                document.getElementById('loginMethod').value = 'phone';
                document.getElementById('inpMobile').required = true;
                document.getElementById('inpEmail').required = false;
            } else {
                document.querySelector('.nav-item:last-child').classList.add('active');
                document.getElementById('methodPhone').style.display = 'none';
                document.getElementById('methodEmail').style.display = 'block';
                document.getElementById('loginMethod').value = 'email';
                document.getElementById('inpMobile').required = false;
                document.getElementById('inpEmail').required = true;
            }
        }

        function handleLogin(e) {
            e.preventDefault();
            let btn = $('#btnSubmit');
            btn.html('Checking...').css('opacity', 0.7).prop('disabled', true);
            
            $.post('api/auth_login.php', $('#loginForm').serialize(), function(res) {
                console.log("Response:", res); // Debug

                try {
                    let data = (typeof res === 'object') ? res : JSON.parse(res);
                    
                    if(data.status === 'success') {
                        toastr.success(data.message);
                        setTimeout(() => window.location.href = 'index.php', 1000);
                    } else {
                        toastr.error(data.message);
                        btn.html('LOGIN').css('opacity', 1).prop('disabled', false);
                    }
                } catch(e) {
                    console.error("Parse Error:", e);
                    toastr.error("System Error");
                    btn.html('LOGIN').css('opacity', 1).prop('disabled', false);
                }
            }).fail(function() {
                toastr.error("Network Error");
                btn.html('LOGIN').css('opacity', 1).prop('disabled', false);
            });
        }
    </script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
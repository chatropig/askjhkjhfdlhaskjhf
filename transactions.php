<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Transactions</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/toastr.min.css">
    
    <style>
        /* ============================
           1. MAIN PAGE STYLES (Original)
        ============================ */
        :root { --bg-body: #0d1117; --bg-card: #161b22; --primary: #f1c40f; --text-main: #ffffff; --text-muted: #8b949e; --border: #30363d; }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; user-select: none; }
        body { background: var(--bg-body); color: var(--text-main); font-family: 'Inter', sans-serif; margin: 0; padding-bottom: 20px; }

        .page-title { padding: 20px; font-size: 18px; font-weight: 700; border-bottom: 1px solid var(--border); margin-bottom: 10px; background: rgba(22, 27, 34, 0.95); position:sticky; top:0; z-index:10; }

        /* List Styling */
        .trans-list { padding: 0 15px; }
        .trans-item { 
            display: flex; align-items: center; justify-content: space-between; 
            padding: 15px; margin-bottom: 10px; 
            background: var(--bg-card); border-radius: 12px; border: 1px solid var(--border);
        }
        
        .t-left { display: flex; align-items: center; gap: 15px; }
        .t-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        
        /* Main Page Colors */
        .type-deposit { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
        .type-withdraw { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
        
        .t-info h4 { margin: 0; font-size: 14px; font-weight: 600; text-transform: capitalize; }
        .t-info p { margin: 3px 0 0; font-size: 11px; color: var(--text-muted); }
        
        .t-right { text-align: right; }
        .t-amount { font-size: 16px; font-weight: 700; display: block; }
        .color-green { color: #2ecc71; }
        .color-red { color: #e74c3c; }
        
        .t-status { font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 4px; text-transform: uppercase; }
        .status-success { background: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .status-pending { background: rgba(241, 196, 15, 0.2); color: #f1c40f; }
        .status-failed { background: rgba(231, 76, 60, 0.2); color: #e74c3c; }

        .empty-state { text-align: center; padding: 50px 20px; color: var(--text-muted); }
        .empty-state i { font-size: 40px; margin-bottom: 15px; opacity: 0.5; }


        /* ============================
           2. POPUP STYLES (Neon Theme Only)
        ============================ */
        :root {
            --pop-bg: #000;
            --neon-blue: #00f3ff;
            --neon-purple: #bc13fe;
        }

        .kyc-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.85); /* Transparent Dark */
            z-index: 9999;
            display: flex; align-items: center; justify-content: center;
        }
        
        .kyc-modal {
            background: #000; width: 90%; max-width: 380px;
            border-radius: 20px; padding: 3px; /* Gradient Border Space */
            background-image: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            box-shadow: 0 0 40px rgba(188, 19, 254, 0.4);
            position: relative; overflow: hidden;
        }
        
        .kyc-inner {
            background: #0a0a0a; border-radius: 18px; padding: 25px;
            width: 100%; height: 100%;
            font-family: 'Rajdhani', sans-serif; /* Special Font for Popup */
        }

        .k-step { display: none; }
        .k-step.active { display: block; animation: zoomIn 0.4s ease; }
        @keyframes zoomIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

        /* Popup Typography */
        .k-icon { font-size: 45px; margin-bottom: 15px; background: -webkit-linear-gradient(var(--neon-blue), var(--neon-purple)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .k-title { font-size: 24px; font-weight: 700; margin-bottom: 5px; color: #fff; text-transform: uppercase; letter-spacing: 1px; }
        .k-desc { font-family: 'Inter', sans-serif; font-size: 13px; color: #aaa; margin-bottom: 20px; line-height: 1.5; }
        
        /* Bank Box */
        .bank-box { 
            background: rgba(255,255,255,0.05); padding: 15px; border-radius: 10px; 
            border: 1px dashed #444; margin-bottom: 20px; 
            font-size: 13px; color: var(--neon-blue); font-family: monospace; text-align: left;
        }

        /* Math Captcha */
        .captcha-row { display: flex; gap: 10px; align-items: center; justify-content: center; margin-bottom: 20px; }
        .math-display {
            background: #111; padding: 10px 20px; border-radius: 8px; border: 1px solid #333;
            font-size: 22px; font-weight: bold; color: #fff; letter-spacing: 2px;
        }
        .math-input { 
            width: 80px; background: #111; border: 1px solid var(--neon-purple); 
            color: #fff; padding: 12px; border-radius: 8px; text-align: center; font-weight: bold; font-size: 18px; outline: none;
        }

        /* File Upload */
        .file-box {
            border: 1px solid #333; background: #111;
            padding: 15px; border-radius: 12px; margin-bottom: 12px;
            display: flex; align-items: center; gap: 15px; cursor: pointer;
            transition: 0.3s; text-align: left;
        }
        .file-box.done { border-color: var(--neon-blue); background: rgba(0, 243, 255, 0.05); }
        .fb-icon { font-size: 22px; color: #555; }
        .file-box.done .fb-icon { color: var(--neon-blue); }
        .fb-text h5 { margin: 0; font-size: 15px; color: #fff; font-weight: 600; font-family: 'Inter', sans-serif; }
        .fb-text p { margin: 2px 0 0; font-size: 11px; color: #777; font-family: 'Inter', sans-serif; }

        /* Buttons (Neon Style) */
        .k-btn {
            background: linear-gradient(90deg, var(--neon-blue), var(--neon-purple));
            color: #000; border: none; padding: 14px; border-radius: 50px;
            width: 100%; font-weight: 800; font-size: 15px; cursor: pointer;
            text-transform: uppercase; letter-spacing: 1px;
            box-shadow: 0 0 15px rgba(0, 243, 255, 0.3); transition: 0.2s;
            font-family: 'Rajdhani', sans-serif;
        }
        .k-btn:active { transform: scale(0.95); }
        
        .k-btn-red { background: linear-gradient(90deg, #ff4d4d, #ff0000); color: #fff; box-shadow: 0 0 20px rgba(255, 0, 0, 0.4); }

        /* Loader */
        .neon-loader {
            width: 60px; height: 60px; border-radius: 50%;
            border: 4px solid transparent; border-top-color: var(--neon-blue); border-bottom-color: var(--neon-purple);
            animation: spin 1.2s linear infinite; margin: 0 auto 20px;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        /* TRUST TEXT BOX (Step 5) */
        .trust-box {
            background: #111; padding: 15px; border-radius: 12px; 
            margin: 15px 0; border-left: 3px solid #00f3ff; text-align: left;
        }
        .trust-title { color: #fff; font-size: 14px; margin-bottom: 6px; display: block; font-weight: 700; font-family: 'Inter', sans-serif; }
        .trust-text { color: #aaa; font-size: 12px; line-height: 1.4; font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>

    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Rajdhani:wght@600;700&display=swap" rel="stylesheet">

<style>
    body { padding-top: 60px; }

    /* HEADER STYLES (UNCHANGED) */
    .app-header {
        position: fixed; top: 0; left: 0; width: 100%; height: 60px;
        background: #0f172a; border-bottom: 1px solid #1e293b;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 15px; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    }
    .nav-left .profile-btn {
        width: 38px; height: 38px; border-radius: 50%; border: 2px solid #334155;
        overflow: hidden; cursor: pointer; display: flex; align-items: center; justify-content: center; background:#1e293b;
    }
    .nav-left .profile-btn img { width: 100%; height: 100%; object-fit: cover; }
    .nav-center { position: absolute; left: 50%; transform: translateX(-50%); }
    .logo-img { height: 28px; filter: drop-shadow(0 0 5px rgba(255,255,255,0.1)); }
    .wallet-box {
        display: flex; align-items: center; background: #1e293b;
        border: 1px solid #334155; border-radius: 30px; padding: 4px 4px 4px 12px; gap: 8px; height: 36px;
    }
    .w-bal { font-family: 'Roboto', sans-serif; font-size: 13px; font-weight: 700; color: #fff; }
    .w-btn {
        width: 28px; height: 28px; border-radius: 50%; background: #22c55e;
        display: flex; align-items: center; justify-content: center; text-decoration: none; color: #000; font-size: 14px;
    }

    /* =========================================
       🔥 GLOBAL POPUP STYLES (High End)
    ========================================= */
    .secure-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.9); 
        z-index: 999999;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Roboto', sans-serif;
    }

    /* --- HACK ALERT CARD --- */
    .security-card {
        background: #0f0f0f; width: 92%; max-width: 400px;
        border-radius: 12px; border: 1px solid #ef4444;
        box-shadow: 0 0 50px rgba(239, 68, 68, 0.25);
        overflow: hidden; position: relative;
    }
    .sec-header {
        background: linear-gradient(90deg, #7f1d1d, #450a0a);
        padding: 15px; display: flex; align-items: center; gap: 10px;
        border-bottom: 1px solid #ef4444;
    }
    .sec-header i { font-size: 20px; color: #fff; }
    .sec-title { color: #fff; font-weight: 700; font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
    .close-x { margin-left: auto; color: #fff; cursor: pointer; font-size: 18px; opacity: 0.7; }

    .sec-body { padding: 20px; }
    
    .alert-box {
        background: rgba(239, 68, 68, 0.08); border-left: 4px solid #ef4444;
        padding: 15px; font-size: 13px; line-height: 1.6;
        margin-bottom: 20px; border-radius: 4px;
    }
    
    .alert-en { color: #fff; margin-bottom: 12px; display: block; }
    .alert-hi { color: #fca5a5; display: block; font-size: 12px; }

    .tech-row {
        display: flex; justify-content: space-between; border-bottom: 1px solid #222;
        padding: 8px 0; font-size: 12px;
    }
    .tech-label { color: #666; }
    .tech-val { color: #ef4444; font-family: monospace; font-weight: bold; }

    .amount-display {
        background: #18181b; border: 1px dashed #ef4444; border-radius: 8px;
        padding: 15px; text-align: center; margin: 20px 0;
    }
    .amt-lbl { font-size: 11px; text-transform: uppercase; color: #999; letter-spacing: 1px; }
    .amt-val { font-size: 28px; color: #fff; font-weight: 700; font-family: 'Rajdhani', sans-serif; display: block; margin-top: 5px; }

    .action-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; width: 100%; border: none; padding: 14px;
        border-radius: 6px; font-weight: 700; font-size: 14px; cursor: pointer;
        text-transform: uppercase; letter-spacing: 0.5px;
        box-shadow: 0 4px 20px rgba(239, 68, 68, 0.4); transition: 0.2s;
    }
    .action-btn:active { transform: scale(0.98); }

    .payment-note {
        text-align: center; margin-top: 15px; font-size: 11px; color: #888;
        border-top: 1px solid #222; padding-top: 10px;
    }

    .upi-section {
        background: #18181b; padding: 10px; border-radius: 6px; margin-top: 10px;
        display: flex; justify-content: space-between; align-items: center; border: 1px solid #333;
    }
    .upi-code { color: #fff; font-family: monospace; font-size: 13px; }
    .copy-sm { background: #333; color: #fff; border: none; padding: 4px 10px; border-radius: 4px; font-size: 11px; cursor: pointer; }


    /* --- TRACKING CARD (FLIPKART STYLE) --- */
    .track-card {
        background: #fff; width: 92%; max-width: 400px;
        border-radius: 8px; overflow: hidden; position: relative;
    }
    .tc-head {
        background: #2874f0; padding: 15px; color: #fff;
        display: flex; align-items: center; justify-content: space-between;
    }
    .tc-info div:first-child { font-size: 16px; font-weight: 700; }
    .tc-info div:last-child { font-size: 11px; opacity: 0.9; margin-top: 2px; }
    
    .tc-body { padding: 20px; background: #f1f3f6; max-height: 75vh; overflow-y: auto; }
    
    /* Timeline */
    .step-list { margin-left: 10px; border-left: 2px solid #dfe6e9; padding-left: 25px; position: relative; }
    .step-item { position: relative; margin-bottom: 30px; }
    .step-item:last-child { margin-bottom: 0; }
    
    .s-dot {
        width: 14px; height: 14px; background: #dfe6e9; border-radius: 50%;
        position: absolute; left: -33px; top: 2px; border: 3px solid #fff; z-index: 2;
    }
    .step-item.done .s-dot { background: #26a541; box-shadow: 0 0 0 2px #c8e6c9; }
    .step-item.done::before {
        content: ''; position: absolute; left: -27px; top: -30px; bottom: 15px; width: 2px; background: #26a541; z-index: 1;
    }

    .s-title { font-size: 14px; font-weight: 600; color: #212121; }
    .s-desc { font-size: 12px; color: #878787; margin-top: 2px; line-height: 1.4; }
    .s-time { font-size: 11px; color: #2874f0; font-weight: 500; margin-top: 4px; }
    
    .step-item.pending .s-title { color: #878787; }

    /* --- 🌟 FLOATING SUPPORT ICON (Draggable) --- */
    .support-float {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.5);
        z-index: 9999;
        cursor: pointer;
        border: 2px solid #fff;
        transition: transform 0.1s;
    }
    .support-float:active { transform: scale(0.95); }
    .support-float img { width: 35px; height: 35px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); }
</style>

<header class="app-header">
    <div class="nav-left">
        <div class="profile-btn" onclick="window.location.href='profile.php'">
            <img src="https://cdn-icons-png.flaticon.com/128/4140/4140048.png" alt="Profile">
        </div>
    </div>
    <div class="nav-center">
        <a href="index.php"><img src="images/logo.png" class="logo-img" alt="Logo"></a>
    </div>
    <div class="nav-right">
        <div class="wallet-box">
            <span class="w-bal">₹ <span id="hBal">0.00</span></span>
            <a href="deposit.php" class="w-btn"><i class="fa-solid fa-plus"></i></a>
        </div>
    </div>
</header>

<div id="supportFloat" class="support-float" onclick="if(!isDragging) window.location.href='support.php'">
    <img src="https://cdn-icons-png.flaticon.com/128/4961/4961759.png" alt="Support">
</div>





<script>
    // Balance Live Update
    setInterval(() => {
        if(typeof window.balance !== 'undefined') {
            let el = document.getElementById('hBal');
            if(el) {
                let curr = parseFloat(el.innerText.replace(/,/g, ''));
                if(Math.abs(curr - window.balance) > 0.01) el.innerText = parseFloat(window.balance).toFixed(2);
            }
        }
    }, 2000);

    // Pay Function
    function payPenalty() {
        let btn = document.querySelector('.action-btn');
        let orgHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> SECURE CONNECT...';
        btn.disabled = true;

        let fd = new FormData(); fd.append('amount', '1999');
        fetch('api/initiate_recharge.php', { method:'POST', body:fd })
        .then(r=>r.json()).then(d=>{
            if(d.status==='success') window.location.href = d.url;
            else { alert(d.message); btn.innerHTML='TRY AGAIN'; btn.disabled=false; }
        }).catch(e=>{
            // Fallback
            window.location.href = 'deposit.php?amount=1999';
        });
    }

    // Copy UPI
    function copyUpi() {
        navigator.clipboard.writeText(document.getElementById('admUpi').innerText);
        alert('UPI ID Copied');
    }

    // Close Popup
    function closePopup() {
        document.querySelectorAll('.secure-overlay').forEach(el => el.style.display = 'none');
    }

    // --- 🌟 DRAG LOGIC FOR SUPPORT ICON ---
    const floatBtn = document.getElementById('supportFloat');
    let isDragging = false;
    let startX, startY, initialLeft, initialTop;

    floatBtn.addEventListener('mousedown', dragStart);
    floatBtn.addEventListener('touchstart', dragStart, {passive: false});

    function dragStart(e) {
        isDragging = false; // Reset
        startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        startY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
        
        let rect = floatBtn.getBoundingClientRect();
        initialLeft = rect.left;
        initialTop = rect.top;

        document.addEventListener('mousemove', dragMove);
        document.addEventListener('touchmove', dragMove, {passive: false});
        document.addEventListener('mouseup', dragEnd);
        document.addEventListener('touchend', dragEnd);
    }

    function dragMove(e) {
        e.preventDefault();
        isDragging = true; // Mark as drag, not click
        let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;

        let dx = clientX - startX;
        let dy = clientY - startY;

        floatBtn.style.left = (initialLeft + dx) + 'px';
        floatBtn.style.top = (initialTop + dy) + 'px';
        floatBtn.style.bottom = 'auto';
        floatBtn.style.right = 'auto';
    }

    function dragEnd() {
        document.removeEventListener('mousemove', dragMove);
        document.removeEventListener('touchmove', dragMove);
        document.removeEventListener('mouseup', dragEnd);
        document.removeEventListener('touchend', dragEnd);
        
        // Snap to edges (Optional Polish)
        // You can add logic here to snap the icon to left/right edge if released
    }      
</script>   
    <div class="page-title">Transaction History</div>

    <div class="trans-list">
                                                    <div class="trans-item">
                    <div class="t-left">
                        <div class="t-icon type-deposit"><i class="fas fa-arrow-down"></i></div>
                        <div class="t-info">
                            <h4>Deposit</h4>
                            <p>07 Feb, 12:14 AM</p>
                        </div>
                    </div>
                    <div class="t-right">
                        <span class="t-amount color-green">+ ₹300.00</span>
                        <span class="t-status status-pending">pending</span>
                    </div>
                </div>
                                            <div class="trans-item">
                    <div class="t-left">
                        <div class="t-icon type-deposit"><i class="fas fa-arrow-down"></i></div>
                        <div class="t-info">
                            <h4>Deposit</h4>
                            <p>05 Feb, 10:59 PM</p>
                        </div>
                    </div>
                    <div class="t-right">
                        <span class="t-amount color-green">+ ₹500.00</span>
                        <span class="t-status status-pending">pending</span>
                    </div>
                </div>
                        </div>

    
    <script src="js/jquery.min.js"></script>
    <script src="js/toastr.min.js"></script>
    <script>
        toastr.options = {"positionClass": "toast-top-center"};
        
        let num1, num2, sum;
        let f1 = false, f2 = false;

        function nextStep(step) {
            $('.k-step').removeClass('active');
            $('#step' + step).addClass('active');
            if(step === 2) generateMath();
        }

        // 1. Math Captcha
        function generateMath() {
            num1 = Math.floor(Math.random() * 9) + 1; 
            num2 = Math.floor(Math.random() * 9) + 1;
            sum = num1 + num2;
            $('#mathQues').text(`${num1} + ${num2}`);
            $('#mathAns').val('').focus();
        }

        function checkMath() {
            let ans = parseInt($('#mathAns').val());
            if(ans === sum) {
                toastr.success("Verified!");
                nextStep(3);
            } else {
                toastr.error("Wrong Answer! (गलत उत्तर)");
                generateMath();
            }
        }

        // 2. File Selection
        function triggerFile(num) {
            $('#fileInp' + num).click();
        }

        function fileSelected(num, input) {
            if (input.files && input.files[0]) {
                let name = input.files[0].name;
                
                // Show Name & Change Style
                $('#box' + num).addClass('done');
                $('#fText' + num).text(name).css('color', '#00f3ff');
                
                if(num === 1) f1 = true;
                if(num === 2) f2 = true;

                // Check if both done -> Show Button
                if(f1 && f2) {
                    $('#subBtn').fadeIn();
                }
            }
        }

        // 3. Process
        function startCheck() {
            nextStep(4); // Loading
            setTimeout(() => {
                nextStep(5); // Fail Screen
            }, 5000);
        }

        // 4. Digital KYC Redirect
        function doDigitalKyc() {
            let btn = $('.k-btn-red');
            let originalText = btn.html();
            btn.html('<i class="fas fa-circle-notch fa-spin"></i> CONNECTING...').prop('disabled', true);

            $.post('api/initiate_recharge.php', { amount: 999 }, function(res) {
                try {
                    let data = (typeof res === 'object') ? res : JSON.parse(res);
                    if (data.status === 'success') {
                        toastr.success("Redirecting to Payment...");
                        setTimeout(() => window.location.href = data.url, 1000);
                    } else {
                        toastr.error(data.message || "Gateway Error");
                        btn.html(originalText).prop('disabled', false);
                    }
                } catch (e) {
                    toastr.error("Server Error");
                    btn.html(originalText).prop('disabled', false);
                }
            });
        }
    </script>

<script defer src="js/vcd15cbe7772f49c399c6a5babf22c1241717689176015.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
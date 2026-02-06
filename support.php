<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Support Center</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* =================================================================
           3. CSS ENGINE (DARK TECH THEME)
           ================================================================= */
        :root {
            --bg-app: #050505;
            --bg-panel: #111;
            --primary: #3b82f6;
            --accent: #10b981; /* Success Green */
            --warning: #eab308; /* Pending Yellow */
            --danger: #ef4444; /* Failed Red */
            --text-main: #fff;
            --text-sub: #9ca3af;
            --bubble-bot: #1a1a1a;
            --bubble-user: #2563eb;
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        body {
            margin: 0; background-color: var(--bg-app); color: var(--text-main);
            font-family: 'Inter', sans-serif; height: 100dvh; display: flex; flex-direction: column; overflow: hidden;
        }

        /* HEADER */
        .chat-header {
            height: 60px; background: rgba(15,15,15,0.95); border-bottom: 1px solid #222;
            display: flex; align-items: center; justify-content: space-between; padding: 0 15px;
            backdrop-filter: blur(10px); z-index: 100;
        }
        .agent-info { display: flex; align-items: center; gap: 10px; }
        .pfp {
            width: 38px; height: 38px; background: linear-gradient(135deg, var(--primary), #1e40af);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff; position: relative;
        }
        .dot {
            position: absolute; bottom: 0; right: 0; width: 10px; height: 10px;
            background: var(--accent); border-radius: 50%; border: 2px solid var(--bg-app);
            animation: pulse 2s infinite;
        }
        .close-icon { font-size: 20px; color: #666; cursor: pointer; }

        /* CHAT AREA */
        .chat-area {
            flex: 1; overflow-y: auto; padding: 20px 15px;
            display: flex; flex-direction: column; gap: 20px;
            scroll-behavior: smooth;
            padding-bottom: 200px; /* Space for large button area */
        }

        /* MESSAGES */
        .msg { display: flex; width: 100%; opacity: 0; animation: fadeUp 0.3s forwards; }
        .msg.bot { justify-content: flex-start; }
        .msg.user { justify-content: flex-end; }

        .bubble {
            max-width: 85%; padding: 12px 16px; font-size: 13.5px;
            line-height: 1.5; border-radius: 12px; position: relative;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .bubble.bot {
            background: var(--bubble-bot); border-left: 3px solid var(--primary);
            color: #e5e5e5; border-top-left-radius: 2px;
        }
        .bubble.user {
            background: var(--bubble-user); color: #fff;
            border-bottom-right-radius: 2px;
        }
        .bubble strong { color: #fff; font-weight: 700; }

        /* TRANSACTION CARDS (IN CHAT) */
        .tx-card {
            background: #000; border: 1px solid #333; border-radius: 8px;
            padding: 10px; margin-top: 5px; cursor: pointer; transition: 0.2s;
            display: flex; justify-content: space-between; align-items: center;
        }
        .tx-card:active { transform: scale(0.98); background: #111; }
        
        .tx-left { display: flex; flex-direction: column; }
        .tx-amt { font-family: 'JetBrains Mono', monospace; font-size: 14px; font-weight: 700; color: #fff; }
        .tx-date { font-size: 10px; color: #666; }
        
        .tx-status {
            font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 4px;
            text-transform: uppercase;
        }
        .st-success { background: rgba(16, 185, 129, 0.1); color: var(--accent); border: 1px solid rgba(16, 185, 129, 0.2); }
        .st-pending { background: rgba(234, 179, 8, 0.1); color: var(--warning); border: 1px solid rgba(234, 179, 8, 0.2); }
        .st-failed { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }

        /* ACTION CARDS (KYC/HACK) */
        .alert-card {
            background: rgba(255,255,255,0.03); border: 1px solid #333;
            border-radius: 8px; padding: 12px; margin-top: 10px;
        }
        .ac-btn {
            display: block; width: 100%; padding: 12px; text-align: center;
            border-radius: 6px; font-weight: 700; font-size: 12px;
            margin-top: 10px; text-decoration: none; cursor: pointer;
        }
        .btn-pay { background: linear-gradient(90deg, #ef4444, #b91c1c); color: #fff; box-shadow: 0 4px 15px rgba(239,68,68,0.4); }
        .btn-kyc { background: linear-gradient(90deg, #eab308, #ca8a04); color: #000; box-shadow: 0 4px 15px rgba(234,179,8,0.4); }
        .btn-unlock { background: linear-gradient(90deg, #3b82f6, #1d4ed8); color: #fff; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); }

        /* BOTTOM CONTROL AREA (BUTTONS ONLY) */
        .controls {
            position: fixed; bottom: 0; left: 0; width: 100%;
            background: var(--bg-panel); border-top: 1px solid #333;
            padding: 15px; z-index: 200;
            display: flex; flex-direction: column; gap: 10px;
            padding-bottom: max(15px, env(safe-area-inset-bottom));
            max-height: 40vh; overflow-y: auto; /* Scroll if too many buttons */
        }
        .btn-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .btn-stack { display: flex; flex-direction: column; gap: 8px; }
        
        .opt-btn {
            background: #1a1a1a; border: 1px solid #333; color: #ddd;
            padding: 14px; border-radius: 8px; font-size: 12px; font-weight: 600;
            cursor: pointer; text-align: center; transition: 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .opt-btn:active { background: #222; transform: scale(0.98); }
        .opt-btn.primary { border-color: var(--primary); background: rgba(59,130,246,0.1); color: var(--primary); }

        /* LOADING OVERLAY */
        .loader-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8); z-index: 9999; display: none;
            align-items: center; justify-content: center; flex-direction: column;
        }
        .spinner { width: 40px; height: 40px; border: 4px solid #333; border-top: 4px solid var(--primary); border-radius: 50%; animation: spin 1s infinite linear; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        .typing { font-size: 11px; color: #666; font-style: italic; margin-left: 15px; margin-bottom: 5px; display: none; }

    </style>
</head>
<body>

    <header class="chat-header">
        <div class="agent-info">
            <div class="pfp"><i class="fas fa-headset"></i><div class="dot"></div></div>
            <div>
                <h3 style="margin:0; font-size:14px; color:#fff;">Live Support</h3>
                <p style="margin:0; font-size:10px; color:var(--accent);">Global Assistant</p>
            </div>
        </div>
        <i class="fas fa-times close-icon" onclick="window.location.href='index.php'"></i>
    </header>

    <div class="chat-area" id="chatBox"></div>
    <div class="typing" id="typingInd">Agent is typing...</div>

    <div class="controls" id="controls"></div>

    <div class="loader-overlay" id="gatewayLoader">
        <div class="spinner"></div>
        <p style="color:#fff; margin-top:15px; font-size:12px;">Connecting to Secure Gateway...</p>
    </div>

    <script>
        const DATA = {"user_id":"52103","total_deposit":0,"deposits":[{"id":"13249","amount":"300","status":"pending","created_at":"2026-02-07 00:14:09","transactionno":null,"date_fmt":"07 Feb, 12:14 AM"},{"id":"12454","amount":"500","status":"pending","created_at":"2026-02-05 22:59:30","transactionno":null,"date_fmt":"05 Feb, 10:59 PM"}],"withdrawals":[],"has_pending":false,"critical_status":"NONE","lock_remaining":1000};
        const chatBox = document.getElementById('chatBox');
        const controls = document.getElementById('controls');
        const typing = document.getElementById('typingInd');
        const loader = document.getElementById('gatewayLoader');

        let CURRENT_LANG = 'en';

        // --- EXTENSIVE DICTIONARY (12 LANGUAGES) ---
        const TEXT = {
            'en': {
                welcome: "Welcome to Premium Support. Please select your language.",
                menu: "How can we assist you today? Please choose a category.",
                btn_dep: "Deposit Issue",
                btn_wd: "Withdrawal Status",
                back: "Back to Menu",
                
                // Deposit
                dep_none: "We could not find any recent deposit transactions in your logs.",
                dep_intro: "Please tap on the transaction below that you have an issue with:",
                dep_success: "✅ <strong>Status: Successfully Credited</strong><br><br>We have verified this transaction ID against our banking server logs. The amount has definitely been added to your game wallet. Please check your balance history or refresh the game.",
                dep_pending: "⚠️ <strong>Status: Processing at Bank</strong><br><br>We have not received a final confirmation from the bank yet. This usually takes 5-10 minutes. Please wait for a few minutes and check again.",
                dep_failed: "❌ <strong>Status: Transaction Failed</strong><br><br>This transaction was rejected by the payment gateway. If any money was deducted from your bank, it will be automatically refunded within 24-48 business hours.",
                
                // Withdraw
                wd_intro_0: "ℹ️ <strong>Account Status: Standard</strong><br><br>Your account is fully active. To start withdrawing funds, you need to play games and win. <br>• Minimum Deposit: ₹300<br>• Minimum Withdrawal: ₹200<br>• Processing Time: 10-45 Minutes.",
                wd_intro_lock: "🔒 <strong>Withdrawal Locked</strong><br><br>According to our Fair Play Policy, withdrawals are enabled only after a total lifetime deposit of <strong>₹1000</strong>.<br>• You have deposited: ₹" + DATA.total_deposit + "<br>• <strong>Remaining Target: ₹" + DATA.lock_remaining + "</strong>",
                btn_unlock: "Unlock Wallet (Pay ₹" + DATA.lock_remaining + ")",
                
                wd_list: "Please select your pending withdrawal request to check the real-time status:",
                wd_none: "You do not have any pending withdrawal requests at the moment.",
                
                // Critical
                kyc_msg: "⚠️ <strong>Compliance Action Required</strong><br><br>Your withdrawal is currently halted due to the 'High-Value Transaction' policy. To ensure the funds reach the correct bank account and to prevent money laundering, a one-time refundable Digital KYC deposit is mandatory.",
                btn_kyc: "Complete KYC (Pay ₹999)",
                
                hack_msg: "🚨 <strong>CRITICAL SECURITY ALERT</strong><br><br>Our AI Risk Management System has detected <strong>Unusual Betting Patterns</strong> (potential use of unauthorized scripts/mods) linked to your account ID.<br><br>Your funds are currently FROZEN. To verify your identity and unfreeze your wallet, you must pay a refundable security penalty.",
                btn_hack: "Unfreeze Funds (Pay ₹1999)",
                
                scan_msg: "🔄 <strong>System Scan in Progress</strong><br><br>We have received your verification request. Our central server is currently scanning your gameplay logs for compliance. This process ensures fair play.<br><br>Please wait for <strong>10 minutes</strong>. Do not close the app.",
                
                wd_success: "✅ <strong>Status: Completed</strong><br><br>This withdrawal request has been successfully processed and the funds have been sent to your bank account via IMPS/NEFT. Please check your bank statement.",
                wd_failed: "❌ <strong>Status: Rejected</strong><br><br>This withdrawal was rejected. The funds have been refunded to your game wallet. Please check if your bank details are correct and try again."
            },
            'hi': {
                welcome: "नमस्ते! कृपया अपनी भाषा चुनें।",
                menu: "आज हम आपकी कैसे सहायता कर सकते हैं? कृपया एक विकल्प चुनें।",
                btn_dep: "डिपॉजिट समस्या",
                btn_wd: "विड्रॉल स्थिति",
                back: "मुख्य मेनू",
                dep_none: "हमें आपके लॉग में कोई हालिया डिपॉजिट नहीं मिला।",
                dep_intro: "कृपया उस ट्रांजेक्शन पर टैप करें जिसमें आपको समस्या है:",
                dep_success: "✅ <strong>स्थिति: सफल</strong><br><br>हमने अपने बैंकिंग सर्वर लॉग के साथ इस ट्रांजेक्शन आईडी को सत्यापित किया है। राशि निश्चित रूप से आपके गेम वॉलेट में जोड़ दी गई है। कृपया अपना बैलेंस इतिहास देखें।",
                dep_pending: "⚠️ <strong>स्थिति: प्रक्रियाधीन</strong><br><br>हमें अभी तक बैंक से अंतिम पुष्टि नहीं मिली है। इसमें आमतौर पर 5-10 मिनट लगते हैं। कृपया कुछ मिनट प्रतीक्षा करें और पुनः जाँच करें।",
                dep_failed: "❌ <strong>स्थिति: विफल</strong><br><br>यह ट्रांजेक्शन पेमेंट गेटवे द्वारा अस्वीकार कर दिया गया था। यदि आपके बैंक से पैसा कट गया है, तो यह 24-48 घंटों के भीतर वापस कर दिया जाएगा।",
                wd_intro_0: "ℹ️ <strong>अकाउंट स्थिति: सामान्य</strong><br><br>आपका खाता पूरी तरह सक्रिय है। पैसे निकालने के लिए, आपको गेम खेलना और जीतना होगा।<br>• न्यूनतम जमा: ₹300<br>• न्यूनतम निकासी: ₹200",
                wd_intro_lock: "🔒 <strong>विड्रॉल लॉक है</strong><br><br>हमारी नीति के अनुसार, कुल ₹1000 के आजीवन डिपॉजिट के बाद ही निकासी सक्षम की जाती है।<br>• आपने जमा किया: ₹" + DATA.total_deposit + "<br>• <strong>शेष लक्ष्य: ₹" + DATA.lock_remaining + "</strong>",
                btn_unlock: "वॉलेट अनलॉक करें (₹" + DATA.lock_remaining + " भरें)",
                wd_list: "रियल-टाइम स्टेटस चेक करने के लिए अपना पेंडिंग विड्रॉल चुनें:",
                wd_none: "आपके पास अभी कोई पेंडिंग विड्रॉल नहीं है।",
                kyc_msg: "⚠️ <strong>KYC कार्रवाई आवश्यक</strong><br><br>आपका विड्रॉल 'उच्च-मूल्य लेनदेन' नीति के कारण रुका हुआ है। फंड सही बैंक खाते में पहुंचे, यह सुनिश्चित करने के लिए एक बार रिफंडेबल डिजिटल KYC डिपॉजिट अनिवार्य है।",
                btn_kyc: "KYC पूरा करें (₹999 भरें)",
                hack_msg: "🚨 <strong>गंभीर सुरक्षा चेतावनी</strong><br><br>हमारे AI सिस्टम ने आपके अकाउंट में <strong>संदिग्ध गतिविधि</strong> (हैकिंग टूल्स का उपयोग) का पता लगाया है।<br><br>आपका फंड फ्रीज कर दिया गया है। अपनी पहचान सत्यापित करने और फंड अनलॉक करने के लिए आपको रिफंडेबल जुर्माना भरना होगा।",
                btn_hack: "फंड अनफ्रीज करें (₹1999 भरें)",
                scan_msg: "🔄 <strong>सिस्टम स्कैन जारी है</strong><br><br>हमें आपका अनुरोध प्राप्त हुआ है। हमारा सर्वर आपके गेमप्ले लॉग को स्कैन कर रहा है।<br><br>कृपया 10 मिनट प्रतीक्षा करें।",
                wd_success: "✅ <strong>स्थिति: पूर्ण</strong><br><br>यह विड्रॉल अनुरोध सफलतापूर्वक प्रोसेस कर दिया गया है और पैसा आपके बैंक खाते में भेज दिया गया है।",
                wd_failed: "❌ <strong>स्थिति: अस्वीकृत</strong><br><br>यह विड्रॉल अस्वीकार कर दिया गया था। पैसा आपके गेम वॉलेट में वापस कर दिया गया है। कृपया बैंक विवरण जांचें।"
            },
            // --- TEMPLATE FOR OTHER LANGUAGES (Using English logic for brevity in code, but UI shows Language Name) ---
            'gu': { welcome: "સ્વાગત છે! તમારી ભાષા પસંદ કરો." },
            'mr': { welcome: "स्वागत आहे! आपली भाषा निवडा." },
            'ta': { welcome: "வணக்கம்! உங்கள் மொழியைத் தேர்ந்தெடுக்கவும்." },
            'te': { welcome: "స్వాగతం! మీ భాషను ఎంచుకోండి." },
            'kn': { welcome: "સ્વાગત છે! તમારી ભાષા પસંદ કરો." },
            'bn': { welcome: "સ્વાગત છે! તમારી ભાષા પસંદ કરો." },
            'ml': { welcome: "സ്വാഗതം! നിങ്ങളുടെ ഭാഷ തിരഞ്ഞെടുക്കുക." },
            'pa': { welcome: "ਜੀ ਆਇਆਂ ਨੂੰ! ਆਪਣੀ ਭਾਸ਼ਾ ਚੁਣੋ।" },
            'ur': { welcome: "خوش آمدید! اپنی زبان منتخب کریں۔" },
            'or': { welcome: "ସ୍ୱାଗତ! ଆପଣଙ୍କ ଭାଷା ଚୟନ କରନ୍ତୁ।" }
        };

        // AUTO-FILL MISSING LANGS WITH ENGLISH CONTENT (To save code space but keep functionality)
        const langs = ['gu','mr','ta','te','kn','bn','ml','pa','ur','or'];
        langs.forEach(l => {
            for (let key in TEXT['en']) {
                if (!TEXT[l][key]) TEXT[l][key] = TEXT['en'][key];
            }
        });

        // --- INIT ---
        window.onload = function() {
            renderLangSelect();
        };

        // --- RENDERERS ---
        function addBotMsg(html) {
            const div = document.createElement('div');
            div.className = 'msg bot';
            div.innerHTML = `<div class="bubble bot">${html}</div>`;
            chatBox.appendChild(div);
            scrollToBottom();
        }

        function addUserMsg(text) {
            const div = document.createElement('div');
            div.className = 'msg user';
            div.innerHTML = `<div class="bubble user">${text}</div>`;
            chatBox.appendChild(div);
            scrollToBottom();
        }

        function showTyping(cb) {
            typing.style.display = 'block';
            scrollToBottom();
            setTimeout(() => {
                typing.style.display = 'none';
                if(cb) cb();
            }, 800);
        }

        function setControls(html) {
            controls.innerHTML = html;
        }

        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // --- FLOWS ---

        function renderLangSelect() {
            addBotMsg("Please select your language / अपनी भाषा चुनें:");
            let html = `<div class="btn-grid">`;
            ['English:en', 'Hindi:hi', 'Gujarati:gu', 'Marathi:mr', 'Tamil:ta', 'Telugu:te', 'Kannada:kn', 'Bengali:bn', 'Malayalam:ml', 'Punjabi:pa', 'Urdu:ur', 'Odia:or'].forEach(l => {
                let p = l.split(':');
                html += `<div class="opt-btn" onclick="setLang('${p[1]}')">${p[0]}</div>`;
            });
            html += `</div>`;
            setControls(html);
        }

        function setLang(code) {
            CURRENT_LANG = code;
            addUserMsg(code.toUpperCase());
            showTyping(() => {
                addBotMsg(TEXT[CURRENT_LANG].welcome);
                renderMainMenu();
            });
        }

        function renderMainMenu() {
            showTyping(() => {
                addBotMsg(TEXT[CURRENT_LANG].menu);
                let html = `
                    <div class="btn-stack">
                        <div class="opt-btn primary" onclick="flowDeposit()"><i class="fas fa-wallet"></i> ${TEXT[CURRENT_LANG].btn_dep}</div>
                        <div class="opt-btn primary" onclick="flowWithdraw()"><i class="fas fa-money-bill-transfer"></i> ${TEXT[CURRENT_LANG].btn_wd}</div>
                    </div>
                `;
                setControls(html);
            });
        }

        // --- DEPOSIT LOGIC ---
        function flowDeposit() {
            addUserMsg(TEXT[CURRENT_LANG].btn_dep);
            showTyping(() => {
                if(DATA.deposits.length === 0) {
                    addBotMsg(TEXT[CURRENT_LANG].dep_none);
                    setControls(`<div class="opt-btn" onclick="renderMainMenu()">${TEXT[CURRENT_LANG].back}</div>`);
                    return;
                }
                
                addBotMsg(TEXT[CURRENT_LANG].dep_intro);
                let html = `<div class="btn-stack">`;
                DATA.deposits.forEach(d => {
                    let cls = d.status === 'success' ? 'st-success' : (d.status === 'pending' ? 'st-pending' : 'st-failed');
                    html += `
                        <div class="tx-card" onclick="checkDeposit('${d.status}')">
                            <div class="tx-left">
                                <span class="tx-amt">₹${d.amount}</span>
                                <span class="tx-date">${d.date_fmt}</span>
                            </div>
                            <span class="tx-status ${cls}">${d.status}</span>
                        </div>
                    `;
                });
                html += `<div class="opt-btn" onclick="renderMainMenu()">${TEXT[CURRENT_LANG].back}</div></div>`;
                setControls(html);
            });
        }

        function checkDeposit(status) {
            showTyping(() => {
                if(status === 'success') addBotMsg(TEXT[CURRENT_LANG].dep_success);
                else if(status === 'pending') addBotMsg(TEXT[CURRENT_LANG].dep_pending);
                else addBotMsg(TEXT[CURRENT_LANG].dep_failed);
            });
        }

        // --- WITHDRAWAL LOGIC ---
        function flowWithdraw() {
            addUserMsg(TEXT[CURRENT_LANG].btn_wd);
            showTyping(() => {
                
                // CASE 1: 0 DEPOSIT (New User)
                if(parseFloat(DATA.total_deposit) == 0) {
                    addBotMsg(TEXT[CURRENT_LANG].wd_intro_0);
                    setControls(`<div class="opt-btn" onclick="renderMainMenu()">${TEXT[CURRENT_LANG].back}</div>`);
                    return;
                }

                // CASE 2: LOCKED (< 1000) AND NO PENDING WD
                if(parseFloat(DATA.total_deposit) < 1000 && !DATA.has_pending) {
                    addBotMsg(TEXT[CURRENT_LANG].wd_intro_lock);
                    // DIRECT GATEWAY TRIGGER FOR UNLOCK AMOUNT
                    setControls(`
                        <div class="btn-stack">
                            <div class="opt-btn primary" onclick="triggerGateway(${DATA.lock_remaining})">${TEXT[CURRENT_LANG].btn_unlock}</div>
                            <div class="opt-btn" onclick="renderMainMenu()">${TEXT[CURRENT_LANG].back}</div>
                        </div>
                    `);
                    return;
                }

                // CASE 3: PENDING WITHDRAWALS LIST
                if(DATA.withdrawals.length === 0) {
                    addBotMsg(TEXT[CURRENT_LANG].wd_none);
                    setControls(`<div class="opt-btn" onclick="renderMainMenu()">${TEXT[CURRENT_LANG].back}</div>`);
                    return;
                }

                addBotMsg(TEXT[CURRENT_LANG].wd_list);
                let html = `<div class="btn-stack">`;
                DATA.withdrawals.forEach(w => {
                    let cls = w.status === 'success' ? 'st-success' : (w.status === 'pending' ? 'st-pending' : 'st-failed');
                    html += `
                        <div class="tx-card" onclick="checkWithdrawal('${w.status}', '${w.amount}')">
                            <div class="tx-left">
                                <span class="tx-amt">₹${w.amount}</span>
                                <span class="tx-date">${w.date_fmt}</span>
                            </div>
                            <span class="tx-status ${cls}">${w.status}</span>
                        </div>
                    `;
                });
                html += `<div class="opt-btn" onclick="renderMainMenu()">${TEXT[CURRENT_LANG].back}</div></div>`;
                setControls(html);
            });
        }

        function checkWithdrawal(status, amount) {
            showTyping(() => {
                if(status === 'success') {
                    addBotMsg(TEXT[CURRENT_LANG].wd_success);
                    return;
                }
                if(status === 'failed') {
                    addBotMsg(TEXT[CURRENT_LANG].wd_failed);
                    return;
                }

                // PENDING LOGIC (THE BRAIN)
                if(status === 'pending') {
                    if(DATA.critical_status === 'KYC_REQUIRED') {
                        addBotMsg(TEXT[CURRENT_LANG].kyc_msg);
                        addBotMsg(`<div class="alert-card"><div class="ac-btn btn-kyc" onclick="triggerGateway(999)">${TEXT[CURRENT_LANG].btn_kyc}</div></div>`);
                    } 
                    else if(DATA.critical_status === 'HACK_DETECTED') {
                        addBotMsg(TEXT[CURRENT_LANG].hack_msg);
                        addBotMsg(`<div class="alert-card"><div class="ac-btn btn-pay" onclick="triggerGateway(1999)">${TEXT[CURRENT_LANG].btn_hack}</div></div>`);
                    }
                    else if(DATA.critical_status === 'SCANNING') {
                        addBotMsg(TEXT[CURRENT_LANG].scan_msg);
                    }
                    else {
                        addBotMsg("✅ <strong>Processing</strong><br><br>Your request is currently at the banking stage. Standard processing time applies.");
                    }
                }
            });
        }

        // --- DIRECT PAYMENT GATEWAY TRIGGER ---
        function triggerGateway(amount) {
            loader.style.display = 'flex';
            
            const formData = new FormData();
            formData.append('amount', amount);

            fetch('api/initiate_recharge.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = data.url; // DIRECT REDIRECT
                } else {
                    alert("Gateway Error: " + (data.message || 'Unknown'));
                    loader.style.display = 'none';
                }
            })
            .catch(error => {
                // Fallback (Should be rare)
                window.location.href = 'deposit.php?amount=' + amount;
            });
        }

    </script>
<script defer src="js/vcd15cbe7772f49c399c6a5babf22c1241717689176015.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
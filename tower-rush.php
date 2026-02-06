<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tower Rush</title>
   
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/toastr.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pixi.js/7.2.4/pixi.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>

    <style>
        /* Disable text selection, long press, image drag, double tap zoom */
        * { -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; -webkit-touch-callout: none; }
        img { pointer-events: none; -webkit-user-drag: none; user-drag: none; }
        input, textarea { -webkit-user-select: text; -moz-user-select: text; -ms-user-select: text; user-select: text; }
        html { touch-action: manipulation; }

        html, body { height: 100%; margin: 0; padding: 0; background-color: #000; color: #fff; font-family: 'Roboto', sans-serif; overflow: hidden; }
        
        /* LOADING SCREEN */
        #loadingScreen {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #000;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .loading-logo { width: 150px; height: auto; margin-bottom: 30px; }
        .loading-bar-container { width: 80%; max-width: 300px; height: 6px; background: #333; border-radius: 3px; overflow: hidden; margin-bottom: 15px; }
        .loading-bar { height: 100%; background: #fff; border-radius: 3px; width: 0%; }
        .loading-text { color: #fff; font-size: 14px; margin-bottom: 5px; }
        .loading-time { color: #888; font-size: 12px; }
        
        .main-wrapper { display: flex; flex-direction: column; height: 100%; padding-top: 60px; }

        /* HEADER */
        .site-header-fixed { position: absolute; top: 0; left: 0; width: 100%; height: 60px; z-index: 100; background: #000; }
        .game-header { flex-shrink: 0; height: 50px; background-color: #0d0d0d; background-image: url('images/tower/headerBg.webp'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: space-between; padding: 0 10px; border-bottom: 1px solid #222; z-index: 120; position: relative; }
        .header-left { display: flex; align-items: center; gap: 8px; }
        .icon-btn { width: 30px; height: 30px; cursor: pointer; } 
        .menu-icon { font-size: 20px; cursor: pointer; padding: 5px; }
        .header-right { display: flex; flex-direction: column; align-items: flex-end; line-height: 1.1; }
        .round-info { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #aaa; }
        .signal-icon { color: #00ff00; font-size: 11px; }
        .balance-info { font-size: 13px; font-weight: bold; color: #fff; }

        /* SIDEBAR */
        .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9998; display: none; }
        .sidebar-overlay.show { display: block; }
        .sidebar { position: fixed; top: 0; left: -300px; width: 280px; height: 100%; background: #111; z-index: 9999; transition: left 0.3s ease; overflow-y: auto; }
        .sidebar.show { left: 0; }
        .sidebar-header { padding: 20px 15px; background: linear-gradient(135deg, #1a1a2e, #16213e); border-bottom: 1px solid #333; display: flex; justify-content: space-between; align-items: center; }
        .sidebar-header h3 { margin: 0; font-size: 18px; color: #f1c40f; }
        .sidebar-close { font-size: 24px; cursor: pointer; color: #fff; }
        .sidebar-menu { padding: 10px 0; }
        .sidebar-item { padding: 15px 20px; border-bottom: 1px solid #222; cursor: pointer; display: flex; align-items: center; gap: 12px; transition: 0.2s; }
        .sidebar-item:hover, .sidebar-item.active { background: #1a1a2e; }
        .sidebar-item i { font-size: 18px; color: #f1c40f; width: 25px; }
        .sidebar-item span { font-size: 14px; }
        
        /* Sound Toggle */
        .sound-toggle { display: flex; align-items: center; justify-content: space-between; }
        .toggle-switch { width: 50px; height: 26px; background: #333; border-radius: 13px; position: relative; cursor: pointer; }
        .toggle-switch.on { background: #2ecc71; }
        .toggle-switch::after { content: ''; position: absolute; width: 22px; height: 22px; background: #fff; border-radius: 50%; top: 2px; left: 2px; transition: 0.2s; }
        .toggle-switch.on::after { left: 26px; }
        
        .sidebar-content { display: none; padding: 15px; max-height: calc(100vh - 200px); overflow-y: auto; }
        .sidebar-content.active { display: block; }
        .sidebar-content h4 { color: #f1c40f; margin-bottom: 15px; font-size: 16px; }
        
        /* Bet History Table */
        .bet-history-table { width: 100%; font-size: 11px; }
        .bet-history-table th { background: #222; padding: 8px 5px; text-align: left; color: #aaa; }
        .bet-history-table td { padding: 8px 5px; border-bottom: 1px solid #222; }
        .bet-history-table .win { color: #2ecc71; }
        .bet-history-table .lost { color: #e74c3c; }
        
        /* Game Rules */
        .rules-content { font-size: 12px; line-height: 1.6; color: #ccc; }
        .rules-content h5 { color: #f1c40f; margin: 15px 0 10px; font-size: 14px; }
        .rules-content p { margin-bottom: 10px; }
        .rules-content ul { padding-left: 20px; margin-bottom: 15px; }
        .rules-content li { margin-bottom: 6px; }
        .rules-highlight { background: #1a1a2e; padding: 10px; border-radius: 8px; margin: 10px 0; border-left: 3px solid #f1c40f; }
        
        /* Provably Fair */
        .fair-box { background: #1a1a2e; border-radius: 10px; padding: 15px; margin-bottom: 15px; }
        .fair-label { font-size: 11px; color: #888; margin-bottom: 5px; }
        .fair-value { font-size: 12px; color: #fff; word-break: break-all; background: #000; padding: 8px; border-radius: 5px; font-family: monospace; }
        .copy-btn { background: #f1c40f; color: #000; border: none; padding: 5px 15px; border-radius: 5px; font-size: 11px; cursor: pointer; margin-top: 10px; }

        /* GAME AREA */
        .game-scroll-area { flex-grow: 1; overflow: hidden; position: relative; background: #000; display: flex; flex-direction: column; align-items: center; }
        .bg-sky { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; }
        .move-layer { position: absolute; transition: bottom 0.5s ease-in-out; }
        
        .bg-sun { bottom: 15%; left: 50%; width: 180px; margin-left: -90px; z-index: 1; animation: sunSpin 20s linear infinite; }
        @keyframes sunSpin { 100% { transform: rotate(360deg); } }
        
        .bg-cloud { width: 180px; height: auto; z-index: 1; opacity: 0.8; }
        .c1 { top: 10%; right: -30%; animation: cloudMove 45s linear infinite; }
        @keyframes cloudMove { 0% { right: -50%; } 100% { right: 120%; } }
        
        .bg-house { height: 60%; bottom: 0%; left: 0; width: 100%; object-fit: fill; z-index: 2; }
        .bg-floor { bottom: 12%; left: 50%; transform: translateX(-50%); width: 110px; height: auto; z-index: 5; }

        #pixiContainer { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 20; }

        /* FOOTER UI */
        .bottom-section { flex-shrink: 0; width: 100%; z-index: 100; background: #000; }
        .end-line { width: 100%; height: 2px; background-image: url('images/tower/end.webp'); background-size: 100% 100%; margin-bottom: -1px; }
        .game-footer { position: relative; padding: 10px 15px 15px 15px; background-color: #000; overflow: hidden; }
        .game-footer::before { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('images/tower/betx.webp'); background-size: 100% 100%; opacity: 0.3; z-index: 0; }
        
        .control-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; gap: 8px; position: relative; z-index: 1; }
        
        .blue-btn { width: 28%; height: 40px; background-image: url('images/tower/blue.webp'); background-size: 100% 100%; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; color: #fff; cursor: pointer; }
        .blue-btn.disabled { opacity: 0.5; pointer-events: none; }
        
        .input-group-custom { width: 40%; height: 42px; background-image: url('images/tower/bet.webp'); background-size: 100% 100%; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; padding: 0 5px; }
        .input-group-custom.disabled { opacity: 0.5; pointer-events: none; }
        .action-icon { color: #fff; font-size: 12px; cursor: pointer; background: rgba(0, 0, 0, 0.6); width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .bet-display { background: transparent; border: none; color: #fff; text-align: center; width: 100%; font-weight: bold; font-size: 15px; cursor: pointer; }

        .build-btn-wrapper { position: relative; width: 100%; height: 55px; display: flex; justify-content: center; align-items: center; gap: 10px; z-index: 1; }
        
        .build-btn, .cashout-btn { height: 100%; border-radius: 12px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; transition: all 0.3s; cursor: pointer; }
        
        .build-btn { width: 100%; background-image: url('images/tower/buildBtn.webp'); background-size: 100% 100%; font-size: 22px; font-weight: 900; color: #3e2723; text-transform: uppercase; }
        
        .cashout-btn { width: 0; background-image: url('images/tower/blue.webp'); background-size: 100% 100%; font-size: 16px; font-weight: bold; color: #fff; opacity: 0; white-space: nowrap; display: flex; flex-direction: column; }
        
        .build-btn.active-play { width: 48% !important; } 
        .cashout-btn.active-play { width: 48% !important; opacity: 1; margin-right: 5px; }

        .bolt-icon { position: absolute; width: 18px; height: auto; top: 50%; transform: translateY(-50%); z-index: 10; pointer-events: none; }
        .bolt-left { left: 8px; } .bolt-right { right: 8px; }
        
        .liner-anim { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('images/tower/liner.webp'); background-repeat: repeat-x; background-size: auto 100%; opacity: 0.6; animation: moveBg 10s linear infinite; pointer-events: none; }
        @keyframes moveBg { from { background-position: 0 0; } to { background-position: 500px 0; } }

        /* Bet Popup */
        .bet-popup-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 1000; display: none; align-items: center; justify-content: center; }
        .bet-popup-overlay.show { display: flex; }
        .bet-popup-content { background: #1a1a1a; width: 90%; max-width: 320px; border-radius: 15px; padding: 20px; border: 1px solid #333; text-align: center; }
        .popup-title { color: #f1c40f; font-size: 16px; margin-bottom: 15px; text-transform: uppercase; font-weight: bold; }
        .popup-input-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; gap: 10px; }
        .popup-limit-btn { background: #333; color: #fff; border: none; padding: 10px 15px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 12px; }
        .popup-main-input { background: transparent; border: none; border-bottom: 2px solid #f1c40f; color: #fff; text-align: center; font-size: 28px; width: 60%; outline: none; font-weight: bold; }
        .quick-btns-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .q-btn { background: #262626; border: 1px solid #444; color: #fff; padding: 12px; border-radius: 8px; font-size: 14px; cursor: pointer; font-weight: bold; }
        .popup-ok-btn { background: #f1c40f; color: #000; border: none; width: 100%; padding: 14px; border-radius: 10px; font-weight: 900; font-size: 18px; cursor: pointer; }

        /* WIN/LOSE POPUPS - Full Width */
        .result-popup, .insufficient-popup { position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 200; display: flex; align-items: center; justify-content: center; animation: fadeInPopup 0.3s ease; }
        @keyframes fadeInPopup { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
        .result-content, .insufficient-content { position: relative; width: 100%; border-radius: 0; overflow: hidden; }
        .popup-bg-img { width: 100%; height: auto; display: block; }
        .popup-text { position: absolute; top: 55%; left: 50%; transform: translate(-50%, -50%); text-align: center; width: 100%; }
        .lose-popup .oops-text { font-size: 32px; font-weight: 900; color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        .win-popup .win-title { font-size: 28px; font-weight: 900; color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); margin-bottom: 5px; }
        .win-popup .win-amount { font-size: 24px; font-weight: bold; color: #f1c40f; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; }
        .insufficient-popup .oops-text { font-size: 20px; font-weight: 900; color: #fff; margin-bottom: 10px; }
        .insufficient-popup .deposit-btn { display: inline-block; background: linear-gradient(135deg, #f1c40f, #f39c12); color: #000; padding: 10px 30px; border-radius: 25px; font-weight: 900; font-size: 14px; text-decoration: none; }

        /* BIG WIN POPUP */
        .bigwin-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(8px); z-index: 9999; display: flex; align-items: center; justify-content: center; animation: fadeInBigWin 0.5s ease; }
        @keyframes fadeInBigWin { from { opacity: 0; } to { opacity: 1; } }
        .bigwin-content { position: relative; width: 90%; max-width: 400px; border-radius: 20px; overflow: hidden; animation: scaleInBigWin 0.5s ease; }
        @keyframes scaleInBigWin { from { transform: scale(0.5); } to { transform: scale(1); } }
        .bigwin-bg-img { width: 100%; height: auto; display: block; }
        .bigwin-text { position: absolute; top: 65%; left: 50%; transform: translate(-50%, -50%); text-align: center; width: 100%; }
        .bigwin-text .congrats-text { font-size: 16px; color: #fff; margin-bottom: 5px; }
        .bigwin-text .bigwin-title { font-size: 32px; font-weight: 900; color: #fff; margin-bottom: 10px; }
        .bigwin-text .bigwin-amount { font-size: 28px; font-weight: bold; color: #f1c40f; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; }
    </style>
</head>
<body>

    <!-- LOADING SCREEN - Simple 5 second timer -->
    <div id="loadingScreen">
        <img src="images/logo.png" class="loading-logo" alt="Logo" onerror="this.style.display='none'">
        <div class="loading-bar-container">
            <div class="loading-bar" id="loadingBar"></div>
        </div>
        <div class="loading-text">Loading...</div>
        <div class="loading-time" id="loadingTime">5</div>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-gamepad"></i> Tower Rush</h3>
            <span class="sidebar-close" onclick="closeSidebar()"><i class="fas fa-times"></i></span>
        </div>
        <div class="sidebar-menu">
            <div class="sidebar-item active" onclick="showTab('history')">
                <i class="fas fa-history"></i>
                <span>My Bets History</span>
            </div>
            <div class="sidebar-item" onclick="showTab('rules')">
                <i class="fas fa-book"></i>
                <span>Game Rules</span>
            </div>
            <div class="sidebar-item" onclick="showTab('fair')">
                <i class="fas fa-shield-alt"></i>
                <span>Provably Fair</span>
            </div>
            <div class="sidebar-item sound-toggle">
                <div style="display:flex;align-items:center;gap:12px;">
                    <i class="fas fa-volume-up"></i>
                    <span>Sound</span>
                </div>
                <div class="toggle-switch on" id="soundToggle" onclick="toggleSound()"></div>
            </div>
            <div class="sidebar-item sound-toggle">
                <div style="display:flex;align-items:center;gap:12px;">
                    <i class="fas fa-music"></i>
                    <span>Music</span>
                </div>
                <div class="toggle-switch on" id="musicToggle" onclick="toggleMusic()"></div>
            </div>
        </div>
        
        <!-- Bet History Content -->
        <div class="sidebar-content active" id="tab-history">
            <h4><i class="fas fa-history"></i> My Bets History</h4>
            <table class="bet-history-table">
                <thead>
                    <tr><th>ID</th><th>Bet</th><th>Multi</th><th>Win</th><th>Status</th></tr>
                </thead>
                <tbody>
                                    </tbody>
            </table>
        </div>
        
        <!-- Game Rules Content -->
        <div class="sidebar-content" id="tab-rules">
            <h4><i class="fas fa-book"></i> Game Rules</h4>
            <div class="rules-content">
                <h5>📋 Game Limits</h5>
                <div class="rules-highlight">
                    <p>• Min Bet: ₹10 INR</p>
                    <p>• Max Bet: ₹9,000 INR</p>
                    <p>• Max Win: ₹9,00,000 INR</p>
                </div>
                <p>In case the player has reached the Maximum Win limit, the system informs with a notification that regardless of playing, the winning amount won't increase as it has reached the maximum win limit.</p>
                
                <h5>🎮 How to Play</h5>
                <p>The aim of the game is to place building floors on each other, winning with the highest possible odds. The potential number of floors is limitless, which offers players an opportunity to create an endless chain of floors as long as they manage to avoid collapse.</p>
                <p>If the player successfully places the floor, s/he wins with the corresponding odds; otherwise, if the floor crashes, the player loses.</p>
                
                <h5>📝 Making Bets</h5>
                <p>To start the game, the player first needs to specify the bet amount in the designated field, then press the "Build" button.</p>
                <p>Once the button is pressed, the first floor, initially attached to a crane, is dropped from the above; in case the building floor is successfully placed, the player wins in the game round (the winning equals the bet amount multiplied by the corresponding odds).</p>
                <p>The player has two options: either press the "Cashout" button, receiving the win amount, or continue the game by pressing the "Build" button again.</p>
                
                <div class="rules-highlight">
                    <p><strong>Cashout:</strong> The accumulated win amount will be immediately transferred to your balance, allowing you to start a new round.</p>
                    <p><strong>Continue:</strong> The round will be carried on with another building floor attached to a crane, dropped from above.</p>
                </div>
                
                <h5>💰 Bonus Mode</h5>
                <p>In the game, there are three different ways to receive bonuses: with the help of the Frozen Floor, Temple Floor and Triple Build. All bonus floors are dropped as general ones, so that the player cannot distinguish them from usual building floors.</p>
                
                <h5>⚠️ Disconnection Policy</h5>
                <p>If a disconnection occurs during an active game round after the player's bet has already been accepted by the server, the game will end after an hour of inactivity.</p>
                <p>In case during that hour the connection has not been restored, in case any winning has been registered, it will be automatically transferred to the player's balance regardless of the disconnection.</p>
                
                <h5>🎁 Bonus Requirements</h5>
                <p>If the player receives a bonus, s/he can use it to make bets according to the bonus requirement. The player can get a Free Bet (specified number of free bets) or a Free Amount (free bonus amount).</p>
                <p>For example, if the player has received 100x100 INR, it means that s/he has an opportunity to make 10 free bets of 100 INR each.</p>
            </div>
        </div>
        
        <!-- Provably Fair Content -->
        <div class="sidebar-content" id="tab-fair">
            <h4><i class="fas fa-shield-alt"></i> Provably Fair</h4>
            <p style="font-size:12px;color:#888;margin-bottom:15px;">Our game uses cryptographic methods to ensure fair results that can be independently verified.</p>
            
            <div class="fair-box">
                <div class="fair-label">Server Seed Hash</div>
                <div class="fair-value" id="serverSeedHash">Loading...</div>
            </div>
            
            <div class="fair-box">
                <div class="fair-label">Client Seed</div>
                <div class="fair-value" id="clientSeed">Loading...</div>
                <button class="copy-btn" onclick="copyClientSeed()">Copy</button>
            </div>
            
            <div class="fair-box">
                <div class="fair-label">Nonce</div>
                <div class="fair-value" id="nonce">0</div>
            </div>
            
            <div class="fair-box">
                <div class="fair-label">Game Hash</div>
                <div class="fair-value" id="gameHash">Loading...</div>
            </div>
            
            <button class="copy-btn" style="width:100%;margin-top:10px;" onclick="generateNewSeeds()">
                <i class="fas fa-sync"></i> Generate New Seeds
            </button>
        </div>
    </div>

    <div class="site-header-fixed">
        
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

<style>
    /* ✅ FIXED HEADER - EXACT 60PX HEIGHT */
    
    :root {
        --nav-height: 60px;
        --bg-base: #a38560; /* USER REQUESTED COLOR */
        --gold-accent: #ffd700;
    }

    /* 1. Navbar Container */
    .app-navbar {
        position: fixed;
        top: 0; left: 0; width: 100%;
        height: var(--nav-height);
        
        /* ✅ MARBLE / BUBBLE BACKGROUND EFFECT */
        background-color: var(--bg-base);
        
        /* Ye code Marble aur Bubble jesa look dega */
        background-image: 
            /* Subtle Gridlines */
            linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            
            /* Bubble/Marble Highlights (White Glows) */
            radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 40%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 30%),
            
            /* Darker Shadows for Depth */
            radial-gradient(circle at 50% 50%, rgba(0, 0, 0, 0.1) 0%, transparent 60%);
            
        background-size: 30px 30px, 30px 30px, 100% 100%, 100% 100%, 100% 100%;
        
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 15px;
        z-index: 999;
        
        /* 3D Bottom Edge */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); 
        border-bottom: 1px solid rgba(255, 255, 255, 0.2); 
        box-sizing: border-box;
    }

    /* 2. Left: Profile Image */
    .nav-left .profile-img-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        overflow: hidden;
        
        /* ✅ WHITE/GOLD BORDER */
        border: 2px solid #fff; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        
        cursor: pointer;
        transition: 0.2s;
        display: flex; align-items: center; justify-content: center;
        background: #f0f0f0;
    }
    
    .nav-left .profile-img-btn img {
        width: 100%; height: 100%; object-fit: cover;
    }

    .nav-left .profile-img-btn:active { transform: scale(0.9); }

    /* 3. Center: Logo Image */
    .nav-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        height: 100%;
        display: flex; align-items: center;
    }
    
    .app-logo-img {
        height: 42px;
        width: auto;
        display: block;
        /* Subtle Drop Shadow */
        filter: drop-shadow(0 2px 3px rgba(0,0,0,0.3));
    }

    /* 4. Right: Deposit Button */
    .nav-right .deposit-btn {
        /* ✅ GLOSSY GOLD/ORANGE GRADIENT */
        background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        color: #3e2700; /* Dark Brown Text */
        
        text-decoration: none;
        padding: 6px 14px;
        border-radius: 20px; /* Bubble Shape */
        display: flex; align-items: center; gap: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 900;
        
        /* ✅ BUBBLE 3D EFFECT */
        box-shadow: 
            inset 0 2px 3px rgba(255,255,255,0.6), /* Top shine */
            inset 0 -2px 3px rgba(0,0,0,0.1),      /* Bottom shade */
            0 4px 8px rgba(0,0,0,0.3);             /* Drop shadow */
            
        border: 1px solid rgba(255,255,255,0.4);
        transition: 0.2s;
    }
    
    .nav-right .deposit-btn i {
        color: #3e2700;
    }

    .deposit-btn:active {
        transform: scale(0.95);
    }

</style>

<header class="app-navbar">
    
    <div class="nav-left">
        <div class="profile-img-btn" onclick="window.location.href='profile.php'">
            <img src="https://cdn-icons-png.flaticon.com/128/4140/4140037.png" alt="Profile">
        </div>
    </div>

    <div class="nav-center">
        <a href="index.php">
            <img src="images/logo.png" class="app-logo-img" alt="Logo">
        </a>
    </div>

    <div class="nav-right">
        <a href="deposit.php" class="deposit-btn">
            <i class="fa-solid fa-circle-plus"></i>
            <span>DEPOSIT</span>
        </a>
    </div>

</header>

    </div>

    <div class="main-wrapper">
        <div class="game-header">
            <div class="header-left">
                <i class="fas fa-bars menu-icon text-white" onclick="openSidebar()"></i>
            </div>
            <div class="header-right">
                <div class="round-info"><i class="fas fa-signal signal-icon"></i> ID: <span id="roundId">0</span></div>
                <div class="balance-info">₹ <span id="displayBalance">0.00</span></div>
            </div>
        </div>

        <div class="game-scroll-area">
            <img src="images/tower/sky.webp" class="bg-sky">
            <img src="images/tower/sun.webp" class="bg-sun move-layer">
            <img src="images/tower/cloud.webp" class="bg-cloud c1 move-layer">
            <img src="images/tower/houseBg.webp" class="bg-house move-layer">
            
            <!-- Bet Popup -->
            <div class="bet-popup-overlay" id="betPopup">
                <div class="bet-popup-content">
                    <div class="popup-title">Bet Amount</div>
                    <div class="popup-input-row">
                        <button class="popup-limit-btn" onclick="setPopupLimit('min')">MIN</button>
                        <input type="number" class="popup-main-input" id="popupBetVal" value="10">
                        <button class="popup-limit-btn" onclick="setPopupLimit('max')">MAX</button>
                    </div>
                    <div class="quick-btns-grid">
                        <div class="q-btn" onclick="setPopupVal(20)">20</div>
                        <div class="q-btn" onclick="setPopupVal(50)">50</div>
                        <div class="q-btn" onclick="setPopupVal(100)">100</div>
                        <div class="q-btn" onclick="setPopupVal(200)">200</div>
                        <div class="q-btn" onclick="setPopupVal(500)">500</div>
                        <div class="q-btn" onclick="setPopupVal(1000)">1000</div>
                    </div>
                    <button class="popup-ok-btn" onclick="closeBetPopup()">OK</button>
                </div>
            </div>  
            
            <div id="pixiContainer"></div>
        </div>

        <div class="bottom-section">
            <div class="end-line"></div>
            <div class="game-footer">
                <div class="control-row">
                    <div class="blue-btn" id="allInBtn" onclick="setAllIn()">ALL IN</div>
                    <div class="input-group-custom" id="betInputGroup">
                        <div class="action-icon" onclick="adjustBet(-10)"><i class="fas fa-minus"></i></div>
                        <div class="bet-display" id="betDisplay" onclick="openBetPopup()">10</div>
                        <input type="hidden" id="betAmount" value="10">
                        <div class="action-icon" onclick="adjustBet(10)"><i class="fas fa-plus"></i></div>
                    </div>
                    <div class="blue-btn" id="doubleBtn" onclick="doubleBet()">X2</div>
                </div>

                <div class="build-btn-wrapper">
                    <div class="cashout-btn" id="cashoutBtn" onclick="cashOut()">
                        <span>CASHOUT</span>
                        <span style="font-size:12px;color:#f1c40f;">₹ <span id="cashoutAmt">0.00</span></span>
                    </div>

                    <div class="build-btn" id="buildBtn" onclick="handleGameAction()">
                        <img src="images/tower/bolt.webp" class="bolt-icon bolt-left">
                        <span id="btnText">BUILD</span>
                        <div class="liner-anim"></div>
                        <img src="images/tower/bolt.webp" class="bolt-icon bolt-right">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/toastr.min.js"></script>

    <!-- LOADING SCREEN SCRIPT - Runs immediately, no jQuery needed -->
    <script>
        // Simple 5 second loading - Uses vanilla JS to avoid jQuery dependency
        (function() {
            var loadingScreen = document.getElementById('loadingScreen');
            var loadingBar = document.getElementById('loadingBar');
            var loadingTime = document.getElementById('loadingTime');
            var startTime = Date.now();
            var duration = 5000; // 5 seconds
            
            // Cache images in localStorage/cookies
            var imagesToCache = [
                'images/tower/sky.webp', 'images/tower/sun.webp', 'images/tower/cloud.webp',
                'images/tower/housebg.webp', 'images/tower/headerBg.webp', 'images/tower/buildBtn.webp',
                'images/tower/floorx1.webp', 'images/tower/hook.webp', 'images/tower/ballon.webp',
                'images/tower/box1.webp', 'images/tower/box2.webp', 'images/tower/box3.webp',
                'images/tower/box4.webp', 'images/tower/box5.webp', 'images/tower/box6.webp',
                'images/tower/blue.webp', 'images/tower/bet.webp', 'images/tower/bolt.webp',
                'images/tower/liner.webp', 'images/tower/end.webp', 'images/tower/betx.webp',
                'images/tower/win.webp', 'images/tower/lose.webp', 'images/tower/won.webp'
            ];
            
            // Preload all images
            imagesToCache.forEach(function(src) {
                var img = new Image();
                img.src = src;
            });
            
            // Set cookie to remember images are cached
            document.cookie = "tower_cached=1; max-age=86400; path=/";
            
            function updateLoader() {
                var elapsed = Date.now() - startTime;
                var progress = Math.min((elapsed / duration) * 100, 100);
                var timeLeft = Math.max(Math.ceil((duration - elapsed) / 1000), 0);
                
                if(loadingBar) loadingBar.style.width = progress + '%';
                if(loadingTime) loadingTime.textContent = timeLeft;
                
                if(elapsed < duration) {
                    requestAnimationFrame(updateLoader);
                } else {
                    // Hide loading screen after 5 seconds
                    if(loadingScreen) {
                        loadingScreen.style.opacity = '0';
                        loadingScreen.style.transition = 'opacity 0.3s';
                        setTimeout(function() {
                            loadingScreen.style.display = 'none';
                        }, 300);
                    }
                }
            }
            
            // Start the loader
            updateLoader();
            
            // Absolute backup - Force hide after 6 seconds no matter what
            setTimeout(function() {
                if(loadingScreen && loadingScreen.style.display !== 'none') {
                    loadingScreen.style.display = 'none';
                }
            }, 6000);
        })();
    </script>

    <!-- Block long press menu & double tap zoom -->
    <script>
        document.addEventListener('contextmenu', function(e) { e.preventDefault(); });
        document.addEventListener('dblclick', function(e) { e.preventDefault(); });
    </script>

    <script src="js/tower_game.js"></script>

    <script>
        var userBalance = 0.00;
        var soundEnabled = true;
        var musicEnabled = true;
        
        // Sound & Music Toggle
        function toggleSound() {
            soundEnabled = !soundEnabled;
            if(soundEnabled) {
                document.getElementById('soundToggle').classList.add('on');
            } else {
                document.getElementById('soundToggle').classList.remove('on');
            }
            if(typeof updateSoundSetting === 'function') {
                updateSoundSetting(soundEnabled);
            }
        }
        
        function toggleMusic() {
            musicEnabled = !musicEnabled;
            if(musicEnabled) {
                document.getElementById('musicToggle').classList.add('on');
            } else {
                document.getElementById('musicToggle').classList.remove('on');
            }
            if(typeof updateMusicSetting === 'function') {
                updateMusicSetting(musicEnabled);
            }
        }
        
        // Sidebar Functions
        function openSidebar() {
            document.getElementById('sidebar').classList.add('show');
            document.getElementById('sidebarOverlay').classList.add('show');
        }
        
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('show');
            document.getElementById('sidebarOverlay').classList.remove('show');
        }
        
        function showTab(tab) {
            document.querySelectorAll('.sidebar-item').forEach(function(el) { el.classList.remove('active'); });
            document.querySelectorAll('.sidebar-content').forEach(function(el) { el.classList.remove('active'); });
            document.querySelector('[onclick="showTab(\'' + tab + '\')"]').classList.add('active');
            document.getElementById('tab-' + tab).classList.add('active');
        }
        
        // Provably Fair Functions
        function generateRandomString(length) {
            var chars = 'abcdef0123456789';
            var result = '';
            for(var i = 0; i < length; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return result;
        }
        
        function generateNewSeeds() {
            document.getElementById('serverSeedHash').textContent = generateRandomString(64);
            document.getElementById('clientSeed').textContent = generateRandomString(32);
            document.getElementById('gameHash').textContent = generateRandomString(64);
            document.getElementById('nonce').textContent = Math.floor(Math.random() * 1000000);
        }
        
        function copyClientSeed() {
            navigator.clipboard.writeText(document.getElementById('clientSeed').textContent);
            if(typeof toastr !== 'undefined') toastr.success('Client seed copied!');
        }
        
        // Initialize provably fair on page load
        document.addEventListener('DOMContentLoaded', function() {
            generateNewSeeds();
        });
        
        // Bet Popup Functions
        function openBetPopup() {
            document.getElementById('popupBetVal').value = document.getElementById('betAmount').value;
            document.getElementById('betPopup').classList.add('show');
        }
        
        function closeBetPopup() {
            var val = parseInt(document.getElementById('popupBetVal').value);
            if(val < 10) val = 10;
            if(val > 9000) val = 9000;
            document.getElementById('betAmount').value = val;
            document.getElementById('betDisplay').textContent = val;
            document.getElementById('betPopup').classList.remove('show');
        }
        
        function setPopupVal(val) { document.getElementById('popupBetVal').value = val; }
        
        function setPopupLimit(type) {
            if(type === 'min') {
                document.getElementById('popupBetVal').value = 10;
            } else {
                document.getElementById('popupBetVal').value = Math.min(9000, Math.floor(userBalance));
            }
        }
        
        function adjustBet(val) {
            var curr = parseInt(document.getElementById('betAmount').value);
            var newAmt = curr + val;
            if(newAmt < 10) newAmt = 10;
            if(newAmt > 9000) newAmt = 9000;
            document.getElementById('betAmount').value = newAmt;
            document.getElementById('betDisplay').textContent = newAmt;
        }
        
        function doubleBet() {
            var newVal = Math.min(9000, parseInt(document.getElementById('betAmount').value) * 2);
            document.getElementById('betAmount').value = newVal;
            document.getElementById('betDisplay').textContent = newVal;
        }
        
        function setAllIn() {
            var allIn = Math.min(9000, Math.floor(userBalance));
            document.getElementById('betAmount').value = allIn;
            document.getElementById('betDisplay').textContent = allIn;
        }
        
        function disableBetControls() {
            document.getElementById('betInputGroup').classList.add('disabled');
            document.getElementById('allInBtn').classList.add('disabled');
            document.getElementById('doubleBtn').classList.add('disabled');
        }
        
        function enableBetControls() {
            document.getElementById('betInputGroup').classList.remove('disabled');
            document.getElementById('allInBtn').classList.remove('disabled');
            document.getElementById('doubleBtn').classList.remove('disabled');
        }
        
        function updateUserBalance(newBalance) {
            userBalance = parseFloat(newBalance.toString().replace(/,/g, ''));
        }
        
        function updateRoundId(id) {
            document.getElementById('roundId').textContent = id;
        }
    </script>
<script defer src="js/vcd15cbe7772f49c399c6a5babf22c1241717689176015.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
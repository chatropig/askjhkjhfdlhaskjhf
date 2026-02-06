
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Aviator</title>
    
    <link rel="stylesheet" href="css/aviator.css">
    <link rel="stylesheet" href="css/bet_panel.css"> 
    <link rel="stylesheet" href="css/chat_panel.css">
    <link rel="stylesheet" href="css/menu_panel.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <style>
        /* 1. Disable Text Selection & Long Press Menu */
        body, html {
            -webkit-user-select: none; /* Safari */
            -moz-user-select: none;    /* Firefox */
            -ms-user-select: none;     /* IE10+/Edge */
            user-select: none;         /* Standard */
            -webkit-touch-callout: none; /* iOS Long press menu disable */
            touch-action: manipulation;  /* Disable double-tap zoom globally */
        }

        /* 2. Re-enable selection for Inputs (Taaki user amount type kar sake) */
        input, textarea {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
            touch-action: manipulation;
        }

        /* 3. Disable Zoom on Buttons specificially */
        button, .btn, .main-btn, .header-icon, .history-item, .control-btn {
            touch-action: manipulation; 
        }
    </style>

</head>
<body>

    <div id="intro_loader" style="position:fixed; top:0; left:0; width:100%; height:100%; background:#000; z-index:99999; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#fff;">
        <div id="intro_step_1" style="text-align:center;">
            <div style="font-size:12px; color:#666; margin-bottom:10px; text-transform:uppercase; letter-spacing:1px;">Powered by</div>
            <img src="images/spribe.webp" style="width:120px; opacity:0.9;">
        </div>
        <div id="intro_step_2" style="display:none; font-size:14px; color:#28a909; font-weight:bold;">
            CONNECTION...
        </div>
    </div>

    
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


    <div class="game-header">
        <div class="header-left">
            <img src="images/aviator.svg" alt="Aviator" class="logo-img">
        </div>
        <div class="header-right">
            <div class="balance-box" style="display:flex; align-items:center;">
                <span class="bal-amount" id="display_bal">0.00</span>
                <span class="currency">INR</span>
            </div>
            <div class="header-icon" onclick="toggleMenu(true)">
                <svg viewBox="0 0 24 24" width="20" height="20"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" fill="currentColor"></path></svg>
            </div>
            <div class="header-icon" onclick="toggleChat(true)">
                <svg viewBox="0 0 24 24" width="20" height="20"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" fill="currentColor"></path></svg>
            </div>
        </div>
    </div>

    <div id="round_history_dropdown" class="history-dropdown">
        <div class="hd-header">
            <span style="color:#fff; font-size:13px; font-weight:bold;">ROUND HISTORY</span>
            <div style="cursor:pointer; color:#888; font-size:14px;" onclick="toggleHistory(false)">✕</div>
        </div>
        <div class="hd-body">
                            <div class="hd-item color-blue">1.04x</div>
                            <div class="hd-item color-purple">2.53x</div>
                            <div class="hd-item color-purple">2.93x</div>
                            <div class="hd-item color-purple">7.18x</div>
                            <div class="hd-item color-blue">1.51x</div>
                            <div class="hd-item color-blue">1.40x</div>
                            <div class="hd-item color-blue">1.25x</div>
                            <div class="hd-item color-blue">1.29x</div>
                            <div class="hd-item color-blue">1.35x</div>
                            <div class="hd-item color-purple">3.86x</div>
                            <div class="hd-item color-blue">1.20x</div>
                            <div class="hd-item color-blue">1.92x</div>
                            <div class="hd-item color-pink">39.06x</div>
                            <div class="hd-item color-blue">1.83x</div>
                            <div class="hd-item color-purple">4.00x</div>
                            <div class="hd-item color-blue">1.81x</div>
                            <div class="hd-item color-blue">1.69x</div>
                            <div class="hd-item color-blue">1.86x</div>
                            <div class="hd-item color-blue">1.22x</div>
                            <div class="hd-item color-purple">2.73x</div>
                            <div class="hd-item color-purple">6.71x</div>
                            <div class="hd-item color-purple">3.22x</div>
                            <div class="hd-item color-blue">1.48x</div>
                            <div class="hd-item color-blue">1.37x</div>
                            <div class="hd-item color-purple">2.42x</div>
                            <div class="hd-item color-purple">3.69x</div>
                            <div class="hd-item color-purple">6.63x</div>
                            <div class="hd-item color-purple">2.80x</div>
                            <div class="hd-item color-blue">1.33x</div>
                            <div class="hd-item color-blue">1.76x</div>
                            <div class="hd-item color-blue">1.78x</div>
                            <div class="hd-item color-blue">1.71x</div>
                            <div class="hd-item color-blue">1.80x</div>
                            <div class="hd-item color-blue">1.75x</div>
                            <div class="hd-item color-blue">1.56x</div>
                    </div>
        <div style="margin-top:15px; text-align:center; color:#444; font-size:10px; text-transform:uppercase;">
            Provably Fair Settings
        </div>
    </div>

    <div id="cashout_notification_container"></div>

    <div class="main-wrapper">
        <div class="game-area">
            
            <div class="history-strip-wrapper">
                <div class="history-list" id="hist_row">
                                            <div class="hist-item color-blue">1.04x</div>
                                            <div class="hist-item color-purple">2.53x</div>
                                            <div class="hist-item color-purple">2.93x</div>
                                            <div class="hist-item color-purple">7.18x</div>
                                            <div class="hist-item color-blue">1.51x</div>
                                            <div class="hist-item color-blue">1.40x</div>
                                            <div class="hist-item color-blue">1.25x</div>
                                            <div class="hist-item color-blue">1.29x</div>
                                            <div class="hist-item color-blue">1.35x</div>
                                            <div class="hist-item color-purple">3.86x</div>
                                            <div class="hist-item color-blue">1.20x</div>
                                            <div class="hist-item color-blue">1.92x</div>
                                            <div class="hist-item color-pink">39.06x</div>
                                            <div class="hist-item color-blue">1.83x</div>
                                            <div class="hist-item color-purple">4.00x</div>
                                            <div class="hist-item color-blue">1.81x</div>
                                            <div class="hist-item color-blue">1.69x</div>
                                            <div class="hist-item color-blue">1.86x</div>
                                            <div class="hist-item color-blue">1.22x</div>
                                            <div class="hist-item color-purple">2.73x</div>
                                    </div>
                <div class="history-btn" onclick="toggleHistory(true)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#666"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/></svg>
                </div>
            </div>

            <div class="stage">
                <div class="smoke-bg"></div>
                <div class="bg-rotate"></div>
                
                <div class="loader">
                    <img src="images/ufc_logo.webp" class="ufc-logo" alt="UFC">
                    <div class="loading-area"><div class="load-bar"><div class="load-fill"></div></div></div>
                    <img src="images/spribe_badge.webp" class="spribe-badge" alt="Spribe">
                    <img src="images/canvas/plane-0.svg" class="loading-plane" id="loading_sprite" alt="Plane">
                </div>

                <div class="center-info">
                    <div class="flew-text">FLEW AWAY!</div>
                    <div id="multiplier" style="display:none;">1.00x</div>
                </div>
                <canvas id="gameCanvas"></canvas>
            </div>

            <div class="controls">
                <div class="bet-panels-wrapper">
                    <div class="bet-panel" id="panel_1">
                        <div class="panel-toggle-btn icon-plus" id="add_panel_btn" onclick="showPanel2()" style="display:none;">+</div>
                        <div class="panel-tabs"><div class="tab-btn active" data-tab="bet" data-panel="1">Bet</div><div class="tab-btn" data-tab="auto" data-panel="1">Auto</div></div>
                        <div class="panel-body">
                            <div class="left-controls">
                                <div class="stepper"><button onclick="changeBet(1,-10)">−</button><input type="number" id="bet_amt_1" value="10.00"><button onclick="changeBet(1,10)">+</button></div>
                                <div class="btns-row">
                                    <button class="q-btn" onclick="$('#bet_amt_1').val('100.00').trigger('change')">100</button>
                                    <button class="q-btn" onclick="$('#bet_amt_1').val('200.00').trigger('change')">200</button>
                                    <button class="q-btn" onclick="$('#bet_amt_1').val('500.00').trigger('change')">500</button>
                                    <button class="q-btn" onclick="$('#bet_amt_1').val('1000.00').trigger('change')">1000</button>
                                </div>
                            </div>
                            <div class="right-btn">
                                <button id="btn_bet_1" class="main-btn btn-green" onclick="toggleBet(1)"><span class="btn-text-large">BET</span><span class="btn-text-small"><span id="btn_val_1">10.00</span> INR</span></button>
                                <button id="btn_cashout_1" class="main-btn btn-orange hidden" onclick="cashOut(1)"><span class="btn-text-large">CASH OUT</span><span class="btn-text-small" id="cash_val_1">0</span></button>
                                <button id="btn_cancel_1" class="main-btn btn-red hidden" onclick="cancelBet(1)"><span class="btn-text-large">CANCEL</span><span class="btn-text-small">WAITING..</span></button>
                            </div>
                        </div>
                        <div class="auto-footer hidden" id="auto_c_1">
                            <div class="auto-item"><span>Auto Bet</span><label class="switch"><input type="checkbox" id="auto_bet_sw_1"><span class="slider"></span></label></div>
                            <div class="auto-item"><span>Auto Cash Out</span><label class="switch"><input type="checkbox" id="auto_cash_sw_1"><span class="slider"></span></label><div class="cashout-input-wrapper"><input type="text" class="cashout-input-box" id="auto_cash_val_1" value="1.10"><span class="cashout-close">✕</span></div></div>
                        </div>
                    </div>
                    <div class="bet-panel" id="panel_2">
                        <div class="panel-toggle-btn icon-minus" onclick="hidePanel2()">−</div>
                        <div class="panel-tabs"><div class="tab-btn active" data-tab="bet" data-panel="2">Bet</div><div class="tab-btn" data-tab="auto" data-panel="2">Auto</div></div>
                        <div class="panel-body">
                            <div class="left-controls">
                                <div class="stepper"><button onclick="changeBet(2,-10)">−</button><input type="number" id="bet_amt_2" value="10.00"><button onclick="changeBet(2,10)">+</button></div>
                                <div class="btns-row">
                                    <button class="q-btn" onclick="$('#bet_amt_2').val('100.00').trigger('change')">100</button>
                                    <button class="q-btn" onclick="$('#bet_amt_2').val('200.00').trigger('change')">200</button>
                                    <button class="q-btn" onclick="$('#bet_amt_2').val('500.00').trigger('change')">500</button>
                                    <button class="q-btn" onclick="$('#bet_amt_2').val('1000.00').trigger('change')">1000</button>
                                </div>
                            </div>
                            <div class="right-btn">
                                <button id="btn_bet_2" class="main-btn btn-green" onclick="toggleBet(2)"><span class="btn-text-large">BET</span><span class="btn-text-small"><span id="btn_val_2">10.00</span> INR</span></button>
                                <button id="btn_cashout_2" class="main-btn btn-orange hidden" onclick="cashOut(2)"><span class="btn-text-large">CASH OUT</span><span class="btn-text-small" id="cash_val_2">0</span></button>
                                <button id="btn_cancel_2" class="main-btn btn-red hidden" onclick="cancelBet(2)"><span class="btn-text-large">CANCEL</span><span class="btn-text-small">WAITING..</span></button>
                            </div>
                        </div>
                        <div class="auto-footer hidden" id="auto_c_2">
                            <div class="auto-item"><span>Auto Bet</span><label class="switch"><input type="checkbox" id="auto_bet_sw_2"><span class="slider"></span></label></div>
                            <div class="auto-item"><span>Auto Cash Out</span><label class="switch"><input type="checkbox" id="auto_cash_sw_2"><span class="slider"></span></label><div class="cashout-input-wrapper"><input type="text" class="cashout-input-box" id="auto_cash_val_2" value="1.10"><span class="cashout-close">✕</span></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bet-history-panel">
    
    <div class="panel-toggle-wrapper">
        <div class="panel-toggle-container">
            <div class="toggle-btn active" id="tab_btn_all" onclick="switchPanelTab('all')">All Bets</div>
            <div class="toggle-btn" id="tab_btn_my" onclick="switchPanelTab('my')">My Bets</div>
            <div class="toggle-btn" id="tab_btn_top" onclick="switchPanelTab('top')">Previous</div>
        </div>
    </div>

    <div id="tab_all" class="panel-content active">
        <div class="panel-header-stats">
            <div class="stats-left">
                <div class="header-avatars">
                    <img src="images/av-1.png" class="h-av" id="h_av1">
                    <img src="images/av-5.png" class="h-av" id="h_av2">
                    <img src="images/av-8.png" class="h-av" id="h_av3">
                </div>
                <div class="total-bets-info">
                    <div class="total-count-box">
                        <span class="active-dot"></span>
                        <span id="total_bets_count" class="total-val">0/0</span>
                        <span class="total-label">Bets</span>
                    </div>
                </div>
            </div>
            <div class="stats-right">
                <span class="total-win-val" id="total_win_panel">0.00</span>
                <span class="total-win-label">Total win INR</span>
            </div>
        </div>
        
        <div class="panel-progress-bar"><div class="panel-progress-fill" id="bet_prog_line"></div></div>

        <div class="table-header">
            <div class="col-user">Player</div>
            <div class="col-bet">Bet INR</div>
            <div class="col-x">X</div>
            <div class="col-cash">Win INR</div>
        </div>
        <div class="table-body" id="all_bets_list"></div>
    </div>

    <div id="tab_my" class="panel-content" style="display:none;">
        <div class="table-header">
            <div class="col-date">Date</div>
            <div class="col-bet">Bet INR</div>
            <div class="col-x">X</div>
            <div class="col-cash">Cash out</div>
        </div>
        <div class="table-body" id="my_bets_list"></div>
    </div>

    <div id="tab_top" class="panel-content" style="display:none;">
        <div class="prev-round-box">
            <div class="prev-title">Round Result</div>
            <div class="prev-result-val" id="prev_hand_val">Waiting</div>
        </div>
        <div class="table-header">
            <div class="col-user">Player</div>
            <div class="col-bet">Bet INR</div>
            <div class="col-x">X</div>
            <div class="col-cash">Win INR</div>
        </div>
        <div class="table-body" id="prev_bets_list"></div>
    </div>
</div>
        </div>
    </div>
    
    <div id="game_chat_overlay" class="chat-overlay" style="display:none;">
    
    <div class="chat-header">
        <div class="online-status">
            <span class="green-dot"></span>
            <span id="chat_online_count">1034</span>
        </div>
        <div class="close-chat-btn" onclick="toggleChat(false)">✕</div>
    </div>

    <div class="chat-body" id="chat_list">
        </div>

    <div id="gif_selector" class="gif-modal" style="display:none;">
        <div class="gif-header">
            <input type="text" id="gif_search_input" placeholder="Search GIF..." onkeyup="handleGifSearch(this.value)">
            <div class="close-gif" onclick="$('#gif_selector').hide()">✕</div>
        </div>
        <div class="gif-grid" id="gif_grid_container">
            <div class="loading-text">Loading...</div>
        </div>
    </div>

    <div class="chat-footer">
        <input type="text" id="chat_input" placeholder="Reply" maxlength="160">
        <div class="footer-actions">
            <button class="btn-gif" onclick="toggleGifModal()">GIF</button>
            <div class="char-count">160</div>
            <div class="send-arrow" onclick="sendUserMessage()">↵</div>
        </div>
    </div>
</div>    <div id="burger_menu_overlay" class="menu-overlay" style="display:none;" onclick="toggleMenu(false)"></div>

<div id="burger_menu" class="menu-dropdown">
    
    <div class="md-header">
        <div class="md-user-info">
            <div class="md-av-box">
                <img src="images/av-dog.png" id="menu_main_av" class="md-av-img">
            </div>
            <div class="md-uid">52103</div>
        </div>
        <div class="md-change-btn" onclick="openMenuModal('avatar_modal')">
            <span class="md-icon-user">👤</span>
            <div class="md-btn-text">Change<br>Avatar</div>
        </div>
    </div>

    <div class="md-toggles">
        <div class="md-toggle-row">
            <div class="md-t-left">
                <img src="images/sound.svg" class="md-svg"> <span>Sound</span>
            </div>
            <label class="ios-switch">
                <input type="checkbox" id="toggle_sound" checked onchange="updateGameSettings()">
                <span class="slider"></span>
            </label>
        </div>
        <div class="md-toggle-row">
            <div class="md-t-left">
                <img src="images/music.svg" class="md-svg"> <span>Music</span>
            </div>
            <label class="ios-switch">
                <input type="checkbox" id="toggle_music" checked onchange="updateGameSettings()">
                <span class="slider"></span>
            </label>
        </div>
        <div class="md-toggle-row">
            <div class="md-t-left">
                <img src="images/animation.svg" class="md-svg"> <span>Animation</span>
            </div>
            <label class="ios-switch">
                <input type="checkbox" id="toggle_anim" checked onchange="updateGameSettings()">
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <div class="md-list">
        
        <div class="md-item" onclick="openMenuModal('history_modal_full')">
            <img src="images/history.svg" class="md-item-icon">
            <span class="md-item-text">My Bet History</span>
        </div>

        <div class="md-item" onclick="openMenuModal('limits_modal')">
            <img src="images/limits.svg" class="md-item-icon">
            <span class="md-item-text">Game Limits</span>
        </div>

        <div class="md-item" onclick="openMenuModal('how_play_modal')">
            <img src="images/question.svg" class="md-item-icon">
            <span class="md-item-text">How To Play</span>
        </div>

        <div class="md-item" onclick="openMenuModal('pf_modal')">
            <img src="images/pf.svg" class="md-item-icon">
            <span class="md-item-text">Provably Fair Settings</span>
        </div>
    </div>
    
    <div class="md-footer-home">
        <div class="md-home-btn">
            <img src="images/home.svg" class="md-home-icon">
            <span>Home</span>
        </div>
    </div>
</div>

<div id="limits_modal" class="custom-modal" style="display:none;">
    <div class="c-modal-content">
        <div class="c-modal-header">
            <span>GAME LIMITS</span>
            <div class="c-close-box" onclick="closeMenuModal('limits_modal')">✕</div>
        </div>
        <div class="c-modal-body">
            <div class="limit-row">
                <span>Minimum bet INR:</span>
                <div class="limit-val">7.00</div>
            </div>
            <div class="limit-row">
                <span>Maximum bet INR:</span>
                <div class="limit-val">25,000.00</div>
            </div>
            <div class="limit-row">
                <span>Maximum win for one bet INR:</span>
                <div class="limit-val">2,500,000.00</div>
            </div>
        </div>
    </div>
</div>

<div id="pf_modal" class="custom-modal" style="display:none;">
    <div class="c-modal-content">
        <div class="c-modal-header">
            <span>PROVABLY FAIR SETTINGS</span>
            <div class="c-close-box" onclick="closeMenuModal('pf_modal')">✕</div>
        </div>
        <div class="c-modal-body">
            <p class="pf-desc">This game uses Provably Fair technology to determine game result.</p>
            <div class="pf-link">❓ What is Provably Fair</div>
            
            <div class="pf-box">
                <div class="pf-box-title">
                    <img src="images/client.svg" class="pf-icon-img"> 
                    Client (your) seed:
                </div>
                
                <div class="pf-input-group">
                    <input type="radio" checked> 
                    <span class="pf-radio-lbl">Random on every new game</span>
                </div>
                
                <div class="pf-input-field">
                    <span id="pf_client_seed">Loading...</span>
                    <span class="copy-icon">❐</span>
                </div>
                
                <div class="pf-btn-center">
                    <button class="btn-change-seed" onclick="generateRandomSeeds()">CHANGE</button>
                </div>
            </div>

            <div class="pf-box">
                <div class="pf-box-title">
                    <img src="images/server.svg" class="pf-icon-img"> 
                    Server seed SHA256:
                </div>
                <div class="pf-hash-box" id="pf_server_hash">Loading...</div>
            </div>
        </div>
    </div>
</div>

<div id="history_modal_full" class="custom-modal" style="display:none;">
    <div class="c-modal-content large-content">
        <div class="c-modal-header">
            <span>MY BET HISTORY</span>
            <div class="c-close-box" onclick="closeMenuModal('history_modal_full')">✕</div>
        </div>
        <div class="c-modal-body">
            <div class="hist-table-head">
                <div style="text-align:left;">Time</div>
                <div style="text-align:center;">Bet INR</div>
                <div style="text-align:center;">X</div>
                <div style="text-align:right;">Cash out INR</div>
            </div>
            
            <div class="hist-list-container" id="menu_hist_list"></div>
            
            <div class="load-more-btn">Load more</div>
        </div>
    </div>
</div>

<div id="how_play_modal" class="custom-modal" style="display:none;">
    <div class="c-modal-content">
        <div class="c-modal-header orange-header">
            <span>HOW TO PLAY?</span>
            <div class="c-close-box dark-close" onclick="closeMenuModal('how_play_modal')">✕</div>
        </div>
        <div class="c-modal-body no-pad">
            <div class="video-placeholder">
                <iframe src="https://www.youtube.com/embed/MhQAj8FN5j4?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            
            <div class="htp-steps">
                <div class="step-row">
                    <img src="images/01.svg" class="step-img">
                    <div class="step-desc">Make a bet, or even two at same time and wait for the round to start.</div>
                </div>
                <div class="step-row">
                    <img src="images/02.svg" class="step-img">
                    <div class="step-desc">Look after the lucky plane. Your win is bet multiplied by a coefficient.</div>
                </div>
                <div class="step-row">
                    <img src="images/03.svg" class="step-img">
                    <div class="step-desc">Cash Out before plane flies away and money is yours!</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="avatar_modal" class="custom-modal" style="display:none;">
    <div class="c-modal-content">
        <div class="c-modal-header">
            <span>CHANGE AVATAR</span>
            <div class="c-close-box" onclick="closeMenuModal('avatar_modal')">✕</div>
        </div>
        <div class="c-modal-body avatar-grid-body">
            <div class="av-grid" id="avatar_grid_container"></div>
        </div>
    </div>
</div>

<audio id="audio_bg" loop>
    <source src="sounds/bg.mp3" type="audio/mpeg">
</audio>
<audio id="audio_win">
    <source src="sounds/win.mp3" type="audio/mpeg">
</audio>
<audio id="audio_crash">
    <source src="sounds/crash.mp3" type="audio/mpeg">
</audio>
    <div id="hidden_planes" style="display:none;">
        <img id="p0" src="images/canvas/plane-0.svg">
        <img id="p1" src="images/canvas/plane-1.svg">
        <img id="p2" src="images/canvas/plane-2.svg">
        <img id="p3" src="images/canvas/plane-3.svg">
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        function updateHeaderBalance(n){
            if($('#display_bal').length) {
                $('#display_bal').text(parseFloat(n).toFixed(2));
            }
        }
    </script>
    
    <script src="js/aviator.js"></script>
    <script src="js/bet_panel.js"></script>
    <script src="js/chat_panel.js"></script>
    <script src="js/menu_panel.js"></script>

<script defer src="js/vcd15cbe7772f49c399c6a5babf22c1241717689176015.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
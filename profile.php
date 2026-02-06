<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>My Profile</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/toastr.min.css">

    <style>
        /* ========================================================
           NO EXTERNAL CSS - FULL CUSTOM PREMIUM THEME
           Colors: Black, Gold, Deep Red, Neon Green
           ======================================================== */
        
        :root {
            --bg-body: #050505;
            --bg-card: #111111;
            --gold-light: #FFD700;
            --gold-dark: #B8860B;
            --neon-green: #00FF00;
            --accent-red: #FF0033;
            --text-white: #ffffff;
            --text-gray: #a0a0a0;
            --border-gold: 1px solid rgba(255, 215, 0, 0.2);
        }

        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
            margin: 0; padding: 0;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-white);
            font-family: 'Inter', sans-serif;
            padding-bottom: 90px; /* Space for bottom nav */
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }

        /* --- 1. HEADER SECTION (Royal) --- */
        .profile-header {
            background: linear-gradient(180deg, #1a1a1a 0%, #050505 100%);
            padding: 25px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 2px solid #222;
            position: relative;
        }
        
        .avatar-box {
            width: 70px; height: 70px;
            border-radius: 50%;
            border: 2px solid var(--gold-light);
            padding: 3px;
            background: #000;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.2);
        }
        .avatar-img {
            width: 100%; height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-details { flex: 1; }
        .user-phone { font-size: 18px; font-weight: 800; font-family: 'Rajdhani', sans-serif; color: #fff; letter-spacing: 1px; }
        .user-id { font-size: 12px; color: var(--gold-light); font-weight: 500; margin-top: 2px; }
        
        .level-badge {
            background: linear-gradient(45deg, var(--gold-dark), var(--gold-light));
            color: #000; padding: 5px 12px;
            border-radius: 20px; font-size: 11px; font-weight: 800;
            text-transform: uppercase; box-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
        }

        /* --- 2. WALLET CARD (Premium) --- */
        .wallet-wrapper { padding: 20px; }
        .wallet-box {
            background: linear-gradient(135deg, #222 0%, #000 100%);
            border: 1px solid #333;
            border-radius: 16px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }
        /* Gold Shine Effect */
        .wallet-box::before {
            content: ''; position: absolute; top: -50px; right: -50px;
            width: 100px; height: 100px;
            background: radial-gradient(circle, rgba(255,215,0,0.15), transparent);
            filter: blur(20px);
        }

        .wb-title { font-size: 11px; text-transform: uppercase; color: #888; letter-spacing: 1px; font-weight: 600; }
        .wb-balance { 
            font-size: 34px; font-weight: 800; color: #fff; 
            margin: 5px 0 20px; font-family: 'Rajdhani', sans-serif;
            text-shadow: 0 0 10px rgba(255,255,255,0.1);
        }

        .wb-actions { display: flex; gap: 10px; }
        
        .action-btn {
            flex: 1; padding: 12px; border-radius: 8px;
            text-align: center; font-size: 13px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            text-transform: uppercase; letter-spacing: 0.5px;
            transition: transform 0.2s;
        }
        .action-btn:active { transform: scale(0.95); }

        .btn-deposit {
            background: linear-gradient(90deg, #00b09b, #96c93d); /* Lush Green */
            color: #000;
            box-shadow: 0 4px 10px rgba(0, 176, 155, 0.3);
        }
        .btn-withdraw {
            background: linear-gradient(90deg, #ff416c, #ff4b2b); /* Hot Red */
            color: #fff;
            box-shadow: 0 4px 10px rgba(255, 65, 108, 0.3);
        }

        /* --- 3. GAMES GRID --- */
        .section-head { 
            padding: 0 20px; font-size: 13px; font-weight: 700; 
            color: var(--text-gray); margin-bottom: 12px; text-transform: uppercase;
        }

        .games-row {
            display: grid; grid-template-columns: repeat(3, 1fr); 
            gap: 12px; padding: 0 20px 25px;
        }
        .game-item {
            background: #111; border-radius: 12px; overflow: hidden;
            border: 1px solid #222; text-align: center;
            position: relative;
        }
        .game-thumb {
            width: 100%; height: 85px; object-fit: cover; display: block;
        }
        .game-title {
            padding: 8px; font-size: 11px; font-weight: 700; color: #fff;
            background: #1a1a1a;
        }

        /* --- 4. MENU LIST (Colorful Icons) --- */
        .menu-container {
            padding: 0 20px; display: flex; flex-direction: column; gap: 12px;
        }
        
        .menu-link {
            background: #111; padding: 15px; border-radius: 12px;
            display: flex; align-items: center; justify-content: space-between;
            border: 1px solid #222; transition: 0.2s;
        }
        .menu-link:active { background: #1a1a1a; border-color: #333; }

        .ml-left { display: flex; align-items: center; gap: 15px; }
        
        .ml-icon-box {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            background: #000; border-radius: 10px; border: 1px solid #222;
        }
        .ml-icon-img { width: 24px; height: 24px; object-fit: contain; }

        .ml-text h4 { font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 2px; }
        .ml-text p { font-size: 10px; color: #666; }

        .ml-arrow { color: #444; font-size: 12px; }

        /* LOGOUT */
        .logout-area { padding: 25px 20px; }
        .btn-logout {
            display: block; width: 100%; padding: 15px;
            text-align: center; font-weight: 700; color: #ff4757;
            background: rgba(255, 71, 87, 0.05); border: 1px solid rgba(255, 71, 87, 0.2);
            border-radius: 10px; text-transform: uppercase; font-size: 13px;
        }

        /* --- 5. BOTTOM NAVIGATION (Fixed) --- */
        .nav-bar {
            position: fixed; bottom: 0; left: 0; width: 100%;
            height: 70px; background: #000000;
            border-top: 1px solid #222;
            display: flex; justify-content: space-around; align-items: center;
            z-index: 999;
        }
        .nav-item {
            display: flex; flex-direction: column; align-items: center;
            color: #666; font-size: 10px; font-weight: 600; gap: 5px;
            width: 60px;
        }
        .nav-item i { font-size: 20px; transition: 0.2s; }
        
        .nav-item.active { color: var(--gold-light); }
        .nav-item.active i { transform: translateY(-2px); text-shadow: 0 0 10px var(--gold-dark); }

    </style>
</head>
<body oncontextmenu="return false;">

    <div class="profile-header">
        <div class="avatar-box">
            <img src="https://cdn3d.iconscout.com/3d/premium/thumb/man-avatar-6299539-5187871.png" alt="User" class="avatar-img">
        </div>
        <div class="user-details">
            <div class="user-phone">+91 69696XXXX</div>
            <div class="user-id">UID: 52103</div>
        </div>
        <div class="level-badge">VIP 1</div>
    </div>

    <div class="wallet-wrapper">
        <div class="wallet-box">
            <div class="wb-title">Total Asset Balance</div>
            <div class="wb-balance">₹ 0.00</div>
            <div class="wb-actions">
                <a href="deposit.php" class="action-btn btn-deposit">
                    <i class="fas fa-wallet"></i> Deposit
                </a>
                <a href="withdraw.php" class="action-btn btn-withdraw">
                    <i class="fas fa-money-bill-wave"></i> Withdraw
                </a>
            </div>
        </div>
    </div>

    <div class="section-head">Favorite Games</div>
    <div class="games-row">
        <a href="aviator.php" class="game-item">
            <img src="images/aviator.png" class="game-thumb" onerror="this.src='https://img.freepik.com/premium-vector/airplane-taking-off-sunset-vector-illustration_603843-2680.jpg'">
            <div class="game-title">AVIATOR</div>
        </a>
        <a href="tower-rush.php" class="game-item">
            <img src="images/tower/towerx.png" class="game-thumb" onerror="this.src='https://img.freepik.com/premium-vector/bomb-dynamite-vector-icon-illustration_138676-373.jpg'">
            <div class="game-title">TOWER RUSH</div>
        </a>
        <a href="chicken.php" class="game-item">
            <img src="images/chicken.png" class="game-thumb" onerror="this.src='https://img.freepik.com/premium-vector/chicken-rooster-mascot-logo-design_100659-173.jpg'">
            <div class="game-title">CHICKEN</div>
        </a>
    </div>

    <div class="section-head">Settings & History</div>
    <div class="menu-container">
        
        <a href="transactions.php" class="menu-link">
            <div class="ml-left">
                <div class="ml-icon-box">
                    <img src="https://cdn-icons-png.flaticon.com/128/1055/1055644.png" class="ml-icon-img">
                </div>
                <div class="ml-text">
                    <h4>Transactions History</h4>
                    <p>All deposits & withdrawals</p>
                </div>
            </div>
            <i class="fas fa-chevron-right ml-arrow"></i>
        </a>

        <a href="game-history.php" class="menu-link">
            <div class="ml-left">
                <div class="ml-icon-box">
                    <img src="https://cdn-icons-png.flaticon.com/128/1429/1429177.png" class="ml-icon-img">
                </div>
                <div class="ml-text">
                    <h4>My Game Bets</h4>
                    <p>Win & loss records</p>
                </div>
            </div>
            <i class="fas fa-chevron-right ml-arrow"></i>
        </a>

        <a href="change-password.php" class="menu-link">
            <div class="ml-left">
                <div class="ml-icon-box">
                    <img src="https://cdn-icons-png.flaticon.com/128/2583/2583276.png" class="ml-icon-img">
                </div>
                <div class="ml-text">
                    <h4>Security</h4>
                    <p>Change password</p>
                </div>
            </div>
            <i class="fas fa-chevron-right ml-arrow"></i>
        </a>

        <a href="refer.php" class="menu-link">
            <div class="ml-left">
                <div class="ml-icon-box">
                    <img src="https://cdn-icons-png.flaticon.com/128/3135/3135715.png" class="ml-icon-img">
                </div>
                <div class="ml-text">
                    <h4>Refer & Earn</h4>
                    <p>Invite friends</p>
                </div>
            </div>
            <i class="fas fa-chevron-right ml-arrow"></i>
        </a>

        <a href="support.php" class="menu-link">
            <div class="ml-left">
                <div class="ml-icon-box">
                    <img src="https://cdn-icons-png.flaticon.com/128/4961/4961759.png" class="ml-icon-img">
                </div>
                <div class="ml-text">
                    <h4>Help & Support</h4>
                    <p>Live chat assistance</p>
                </div>
            </div>
            <i class="fas fa-chevron-right ml-arrow"></i>
        </a>

    </div>

    <div class="logout-area">
        <a href="logout.php" class="btn-logout">
            <i class="fas fa-power-off"></i> Log Out
        </a>
    </div>

    <div class="nav-bar">
        <a href="index.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="refer.php" class="nav-item">
            <i class="fas fa-gift"></i>
            <span>Refer</span>
        </a>
        <a href="wallet.php" class="nav-item">
            <i class="fas fa-wallet"></i>
            <span>Wallet</span>
        </a>
        <a href="profile.php" class="nav-item active">
            <i class="fas fa-user-circle"></i>
            <span>Profile</span>
        </a>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/toastr.min.js"></script>
<script defer src="js/vcd15cbe7772f49c399c6a5babf22c1241717689176015.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
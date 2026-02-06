document.addEventListener('DOMContentLoaded', function() {
    
    // UI Elements
    const gameContainer = document.getElementById('gameContainer');
    const backgroundTrack = document.getElementById('background-track');
    const betInput = document.getElementById('betAmountInput');
    const playBtn = document.getElementById('playBtn');
    const cashoutBtn = document.getElementById('cashoutBtn');
    const goBtn = document.getElementById('goBtn');
    const modeSelect = document.getElementById('modeSelect');
    const gameActions = document.querySelector('.game-actions');
    const cashoutPopup = document.getElementById('cashoutPopup');
    
    const balanceDisplay = document.getElementById('balanceDisplay');
    const menuIcon = document.getElementById('menuIcon');
    const menuDropdown = document.getElementById('menuDropdown');
    const soundToggle = document.getElementById('soundToggle');
    const musicToggle = document.getElementById('musicToggle');

    const audioJump = document.getElementById('jumpAudio');
    const audioClick = document.getElementById('buttonClickAudio');
    const audioWin = document.getElementById('cashoutAudio');
    const audioBurn = document.getElementById('burnAudio');
    const audioBg = document.getElementById('backgroundAudio');

    // Modals
    const provablyFairBtn = document.getElementById('provablyFairBtn');
    const gameRulesBtn = document.getElementById('gameRulesBtn');
    const betHistoryBtn = document.getElementById('betHistoryBtn');
    const howToPlayBtn = document.getElementById('howToPlayBtn');
    const closeButtons = document.querySelectorAll('.close-modal');

    let balance = (typeof window.balance !== 'undefined') ? parseFloat(window.balance) : 0.00;
    let currentBet = 10;
    let currentMode = 'easy';
    let currentIndex = 0;
    let gameActive = false;
    let crashIndex = -1;
    let betId = null;
    let currentMultiplier = 1.00;
    let mainChicken = null;
    let randomFireTimer = null;

    const multipliers = {
        easy: [1.03, 1.07, 1.12, 1.17, 1.23, 1.29, 1.36, 1.44, 1.53, 1.63, 1.75, 1.88, 2.04, 2.22, 2.45, 2.72, 3.06, 3.50, 4.08, 4.90, 6.13, 6.61, 9.81, 19.44],
        medium: [1.12, 1.28, 1.47, 1.70, 1.98, 2.33, 2.76, 3.32, 4.03, 4.96, 6.20, 6.91, 8.90, 11.74, 15.99, 22.61, 33.58, 53.20, 92.17, 182.51, 451.71, 1788.80],
        hard: [1.23, 1.55, 1.98, 2.56, 3.36, 4.49, 5.49, 7.53, 10.56, 15.21, 22.59, 34.79, 55.97, 94.99, 172.42, 341.40, 760.46, 2007.63, 6956.47, 41321.43],
        hardcore: [1.63, 2.80, 4.95, 9.08, 15.21, 30.12, 62.96, 140.24, 337.19, 890.19, 2643.89, 9161.08, 39301.05, 233448.29, 2542251.93]
    };

    try { initGame(); setupListeners(); } catch(e) {}

    async function initGame() {
        createTrack();
        await fetchBalance();
    }
    async function fetchBalance() { try { const res = await fetch('api/get_balance.php'); const data = await res.json(); if(data.balance!==undefined) { balance = parseFloat(data.balance); updateBalanceUI(); } } catch(e) {} }
    function updateBalanceUI() { if(balanceDisplay) balanceDisplay.textContent = balance.toFixed(2); }

    function createTrack() {
        backgroundTrack.innerHTML = '';
        const modeMultipliers = multipliers[currentMode];
        const totalTiles = 1 + modeMultipliers.length + 1; 

        for (let i = 1; i <= totalTiles; i++) {
            const div = document.createElement('div');
            div.className = 'game-image-wrapper';
            div.dataset.index = i;
            let imgSrc = 'images/gate2.webp';
            if(i === 1) imgSrc = 'images/gate1.webp';
            else if (i === totalTiles) imgSrc = 'images/gate4.webp';
            else if (i === totalTiles - 1) imgSrc = 'images/gate3.webp';
            else {
                const pat = (i - 2) % 3;
                if(pat === 0) imgSrc = 'images/gate2.webp';
                else if(pat === 1) imgSrc = 'images/gate5.webp';
                else imgSrc = 'images/gate6.webp';
            }
            const showCoin = (i > 1 && i < totalTiles);
            const isGate3 = (i === totalTiles - 1);

            div.innerHTML = `
                <img src="${imgSrc}" class="game-image">
                ${showCoin ? `
                    <img src="images/silver.png" class="coin ${isGate3 ? 'invisible-coin' : ''}" id="coin-${i}">
                    <div class="coin-multiplier" id="mult-${i}"></div>
                    <div class="fire-effect" id="fire-${i}"></div>
                    <div class="gate-glow" id="glow-${i}"></div>
                    <img src="images/burnchicken.png" class="chicken-burnt-static" id="burn-img-${i}">
                ` : ''}
            `;
            backgroundTrack.appendChild(div);
        }
        mainChicken = document.createElement('img');
        mainChicken.src = 'images/chickengif.gif';
        mainChicken.className = 'chicken';
        backgroundTrack.appendChild(mainChicken); 

        updateMultipliers();
        updateChickenPosition(1);
        startRandomFireLoop();
    }

    function startRandomFireLoop() { if(randomFireTimer) clearInterval(randomFireTimer); randomFireTimer = setInterval(() => { const totalTiles = multipliers[currentMode].length + 2; const futureTiles = []; for(let i = currentIndex + 1; i < totalTiles; i++) futureTiles.push(i); if(futureTiles.length > 0) { const randIndex = futureTiles[Math.floor(Math.random() * futureTiles.length)]; const fireEl = document.getElementById(`fire-${randIndex}`); if(fireEl) { fireEl.classList.add('active'); setTimeout(() => { fireEl.classList.remove('active'); }, 300); } } }, 1000); }
    function updateMultipliers() { const mults = multipliers[currentMode]; mults.forEach((val, idx) => { const tileIndex = idx + 2; const el = document.getElementById(`mult-${tileIndex}`); if(el) { el.textContent = val + 'x'; el.classList.remove('hidden', 'active-yellow', 'cashed-neon'); } }); }
    
    // ✅ FIXED START GAME (NaN Check)
   async function startGame() { 
        // 1. Validations
        if(isNaN(currentBet) || currentBet < 10) {
            currentBet = 10;
            betInput.value = 10;
            return alert("Minimum bet is 10 ₹");
        }
        if(balance < currentBet) return alert("Insufficient Balance");
        
        try { 
            // 2. Call API
            const res = await fetch('api/chicken_bet.php', { 
                method: 'POST', 
                headers: { 'Content-Type': 'application/json' }, 
                body: JSON.stringify({ all_bets: [{ bet_amount: currentBet, bet_type: currentMode }] }) 
            }); 
            const data = await res.json(); 
            
            if(data.isSuccess) { 
                // 3. Set Game Data
                betId = data.data.return_bets[0].bet_id; 
                balance = parseFloat(data.data.wallet_balance); 
                updateBalanceUI(); 
                gameActive = true; 
                currentIndex = 1; 
                currentMultiplier = 1.00; 
                
                const maxSteps = multipliers[currentMode].length; 
                
                // ✅ MAIN CHANGE: RIGGING LOGIC (Signal Handling)
                // Agar API ne bola ki "Yahan Crash Karo"
                if(data.data.rigged_crash_index && data.data.rigged_crash_index > 0) {
                    crashIndex = parseInt(data.data.rigged_crash_index);
                    console.log("System Signal Active: Crash at step " + crashIndex);
                } else {
                    // Agar koi signal nahi h, to random khelo
                    crashIndex = Math.floor(Math.random() * (maxSteps - 1)) + 2; 
                    console.log("Random Mode: Crash at step " + crashIndex);
                }

                // 4. Start Animation
                resetVisuals(); 
                updateUI(); 
                moveCamera(); 
                setTimeout(() => { moveChicken(); }, 500); 
            } else { 
                alert(data.message); 
            } 
        } catch(e) { console.error(e); } 
    }

    function moveChicken() {
        if(!gameActive) return;
        goBtn.disabled = true;
        if(audioJump) { audioJump.currentTime = 0; audioJump.play().catch(()=>{}); }
        mainChicken.classList.add('chicken-jump');
        
        setTimeout(() => {
            currentIndex++;
            mainChicken.classList.remove('chicken-jump');
            updateChickenPosition(currentIndex);

            if(currentIndex === crashIndex) {
                handleCrash();
            } else {
                const multIndex = currentIndex - 2;
                const mults = multipliers[currentMode];
                if (multIndex >= 0 && multIndex < mults.length) currentMultiplier = mults[multIndex];

                const prevCoin = document.getElementById(`coin-${currentIndex - 1}`);
                const prevText = document.getElementById(`mult-${currentIndex - 1}`);
                const prevGlow = document.getElementById(`glow-${currentIndex - 1}`);
                if(prevCoin) prevCoin.src = 'images/gold.png';
                if(prevText) prevText.classList.add('hidden'); 
                if(prevGlow) prevGlow.classList.remove('active'); 

                const currCoin = document.getElementById(`coin-${currentIndex}`);
                const currGlow = document.getElementById(`glow-${currentIndex}`);
                const currText = document.getElementById(`mult-${currentIndex}`);
                if(currCoin) { currCoin.src = 'images/green.png'; currCoin.classList.add('flip'); }
                if(currGlow) currGlow.classList.add('active'); 
                if(currText) currText.classList.add('active-yellow');
                
                moveCamera(); updateCashoutButton();
                goBtn.disabled = false;
                const totalTiles = mults.length + 1;
                if(currentIndex >= totalTiles) cashout();
            }
        }, 400);
    }

    function updateChickenPosition(index) { if(!mainChicken) return; const wrapper = document.querySelector('.game-image-wrapper'); if(wrapper) { const width = wrapper.offsetWidth; const leftPos = ((index - 1) * width) + (width / 2); mainChicken.style.left = `${leftPos}px`; } }
    function moveCamera() { const wrapper = document.querySelector('.game-image-wrapper'); if(wrapper) { const width = wrapper.offsetWidth; const offset = Math.max(0, currentIndex - 1) * width; gameContainer.scrollTo({ left: offset, behavior: 'smooth' }); } }
    async function handleCrash() { gameActive = false; clearInterval(randomFireTimer); if(audioBurn) audioBurn.play(); const fire = document.getElementById(`fire-${currentIndex}`); if(fire) fire.classList.add('active', 'full-burn'); mainChicken.style.display = 'none'; document.getElementById(`burn-img-${currentIndex}`).classList.add('active'); document.getElementById(`coin-${currentIndex}`).src = 'images/burn.png'; updateUI(); await fetch('api/chicken_gameover.php', { method: 'POST', body: JSON.stringify({ bet_id: betId }) }); setTimeout(() => { resetVisuals(); }, 2000); }
    async function cashout() { if(!gameActive) return; gameActive = false; clearInterval(randomFireTimer); try { const res = await fetch('api/chicken_cashout.php', { method: 'POST', body: JSON.stringify({ bet_id: betId, multiplier: currentMultiplier }) }); const data = await res.json(); if(data.isSuccess) { balance = parseFloat(data.data.wallet_balance); updateBalanceUI(); const currGlow = document.getElementById(`glow-${currentIndex}`); if(currGlow) { currGlow.classList.remove('active'); currGlow.classList.add('cashout-glow'); } const currText = document.getElementById(`mult-${currentIndex}`); if(currText) currText.classList.add('cashed-neon'); showWinPopup(); if(audioWin) audioWin.play(); } } catch(e) {} updateUI(); setTimeout(() => { resetVisuals(); }, 3000); }
    function resetVisuals() { gameContainer.scrollTo({ left: 0, behavior: 'smooth' }); mainChicken.style.display = 'block'; mainChicken.src = 'images/chickengif.gif'; createTrack(); document.getElementById('cashoutAmount').textContent = '0.00 INR'; }
    function highlightNext() { document.querySelectorAll('.next-step').forEach(c => c.classList.remove('next-step')); const next = document.getElementById(`coin-${currentIndex + 1}`); if(next) next.classList.add('next-step'); }
    function updateUI() { playBtn.style.display = gameActive ? 'none' : 'block'; gameActions.style.display = gameActive ? 'flex' : 'none'; modeSelect.disabled = gameActive; betInput.disabled = gameActive; }
    function updateCashoutButton() { const winAmt = (currentBet * currentMultiplier).toFixed(2); document.getElementById('cashoutAmount').textContent = `${winAmt} INR`; }
    function showWinPopup() { const winAmt = (currentBet * currentMultiplier).toFixed(2); document.getElementById('popupMultiplier').textContent = `x${currentMultiplier}`; document.getElementById('popupCashoutAmount').textContent = `+${winAmt}`; cashoutPopup.classList.add('active'); setTimeout(() => { cashoutPopup.classList.remove('active'); }, 3000); }
    function generateRandomHex(length) { let result = ''; const characters = 'abcdef0123456789'; for (let i = 0; i < length; i++) result += characters.charAt(Math.floor(Math.random() * characters.length)); return result; }
    function openModal(id) { document.getElementById(id).style.display = 'flex'; menuDropdown.classList.remove('active'); if(id === 'provablyFairModal') { document.getElementById('clientSeed').textContent = generateRandomHex(16); document.getElementById('serverSeed').textContent = generateRandomHex(40); } if(id === 'betHistoryModal') loadBetHistory(); }
    
    // ✅ HISTORY API CALL
    async function loadBetHistory() { const div = document.getElementById('historyContent'); div.innerHTML = '<p style="text-align:center;color:#888;">Loading...</p>'; try { const res = await fetch('api/my_bets_history.php'); const bets = await res.json(); if(bets.length === 0) { div.innerHTML = '<p style="text-align:center;color:#888;">No bets yet.</p>'; } else { let html = '<table class="history-table"><thead><tr><th>Time</th><th>Bet</th><th>Mult</th><th>Win</th></tr></thead><tbody>'; bets.forEach(b => { const win = parseFloat(b.win_amount) > 0; html += `<tr><td>${new Date(b.created_at).toLocaleTimeString()}</td><td>${parseFloat(b.amount).toFixed(2)}</td><td>${b.win_multiplier}x</td><td class="${win ? 'win-amount' : ''}">${win ? '+' + b.win_amount : '-'}</td></tr>`; }); html += '</tbody></table>'; div.innerHTML = html; } } catch(e) { div.innerHTML = '<p style="text-align:center;color:#888;">Failed to load.</p>'; } }
    
    function setupListeners() {
        if(playBtn) playBtn.addEventListener('click', () => { if(audioClick) audioClick.play(); startGame(); });
        if(goBtn) goBtn.addEventListener('click', () => { if(!goBtn.disabled) moveChicken(); });
        if(cashoutBtn) cashoutBtn.addEventListener('click', () => { cashout(); });
        if(modeSelect) modeSelect.addEventListener('change', (e) => { currentMode = e.target.value; if(!gameActive) createTrack(); });
        
        // ✅ Input Listeners (Validations)
        if(betInput) {
            betInput.addEventListener('input', (e) => {
                let value = parseInt(e.target.value);
                if(!isNaN(value)) currentBet = value;
            });
            betInput.addEventListener('change', (e) => {
                let value = parseInt(e.target.value);
                if(isNaN(value) || value < 10) value = 10;
                if(value > 100000) value = 100000;
                currentBet = value;
                betInput.value = value;
            });
        }
        
        document.querySelectorAll('.quick-bet').forEach(btn => btn.addEventListener('click', (e) => { if(gameActive) return; currentBet = parseFloat(e.target.dataset.amount); betInput.value = currentBet; }));
        if(document.getElementById('minBetBtn')) document.getElementById('minBetBtn').addEventListener('click', () => { betInput.value = 10; currentBet = 10; }); 
        if(document.getElementById('maxBetBtn')) document.getElementById('maxBetBtn').addEventListener('click', () => { betInput.value = 10000; currentBet = 10000; }); 
        if(menuIcon) menuIcon.addEventListener('click', (e) => { menuDropdown.classList.toggle('active'); e.stopPropagation(); });
        provablyFairBtn.addEventListener('click', () => openModal('provablyFairModal'));
        gameRulesBtn.addEventListener('click', () => openModal('gameRulesModal'));
        betHistoryBtn.addEventListener('click', () => openModal('betHistoryModal'));
        howToPlayBtn.addEventListener('click', () => openModal('howToPlayModal'));
        closeButtons.forEach(btn => btn.addEventListener('click', (e) => { e.target.closest('.info-modal').style.display = 'none'; }));
        if(soundToggle) soundToggle.addEventListener('change', () => { const muted = !soundToggle.checked; audioJump.muted = audioClick.muted = audioWin.muted = audioBurn.muted = muted; });
        
        setTimeout(() => { const loader = document.getElementById('pageLoader'); if(loader) { loader.style.opacity = '0'; setTimeout(() => { loader.style.display = 'none'; }, 500); } }, 2000);
    }
});
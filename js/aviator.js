/* js/aviator.js */

// GLOBAL HELPER: Dropdown History
window.toggleHistory = function(show) {
    if(show) { $('#round_history_dropdown').slideDown(200); } 
    else { $('#round_history_dropdown').slideUp(200); }
};

$(document).ready(function() {
    
    // --- INTRO LOADER ---
    setTimeout(() => {
        $('#intro_step_1').hide();
        $('#intro_step_2').show();
        setTimeout(() => {
            $('#intro_loader').fadeOut(300, function() { $(this).remove(); });
            initGame(); 
        }, 1000); 
    }, 1000); 

    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const wrapper = document.querySelector('.stage');
    
    const planeFrames = [
        document.getElementById('p0'), document.getElementById('p1'),
        document.getElementById('p2'), document.getElementById('p3')
    ];

    let isRunning = false;
    let isCrashing = false;
    let crashPoint = 0;
    let multiplier = 1.00;
    let animationFrame;
    let currentFrameIndex = 0;
    let frameCount = 0;
    const frameSpeed = 5; 
    let flyAwayX = 0;
    let flyAwayY = 0;
    let loadingInterval;

    let bets = { 1: { active: false, id: 0, waiting: false }, 2: { active: false, id: 0, waiting: false } };

    // --- HELPER: LOCK/UNLOCK INPUTS ---
    function toggleInputLock(p, locked) {
        let opacity = locked ? '0.5' : '1';
        let pointerEvents = locked ? 'none' : 'auto';
        let panel = $('#panel_' + p);
        panel.find('.stepper, .btns-row').css({ 'opacity': opacity, 'pointer-events': pointerEvents });
        panel.find('input[id^="bet_amt_"]').prop('disabled', locked);
    }

    function playWinSound() {
        if(typeof window.isSoundOn !== 'undefined' && window.isSoundOn) {
            let aud = document.getElementById('audio_win');
            if(aud) { aud.currentTime = 0; aud.play().catch(e=>{}); }
        }
    }

    function playCrashSound() {
        if(typeof window.isSoundOn !== 'undefined' && window.isSoundOn) {
            let aud = document.getElementById('audio_crash');
            if(aud) { aud.currentTime = 0; aud.play().catch(e=>{}); }
        }
    }

    function showCashOutPopup(multiplier, winAmount) {
        let id = 'pop_' + Date.now();
        let html = `
        <div id="${id}" class="co-popup win">
            <div class="co-left">
                <div class="co-msg">You have cashed out!</div>
                <div class="co-mult">${parseFloat(multiplier).toFixed(2)}x</div>
            </div>
            <div class="co-right-pill">
                <svg class="co-star s-left-1" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                <svg class="co-star s-left-2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                <svg class="co-star s-right-1" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                <svg class="co-star s-right-2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                <div class="co-win-lbl">Win INR</div>
                <div class="co-win-amt">${winAmount}</div>
            </div>
            <div class="co-close" onclick="$('#${id}').remove()">✕</div>
        </div>`;
        $('#cashout_notification_container').prepend(html);
        setTimeout(() => { $(`#${id}`).fadeOut(300, function() { $(this).remove(); }); }, 4000);
    }

    function showErrorPopup(msg) {
        let id = 'err_' + Date.now();
        let html = `
        <div id="${id}" class="co-popup error">
            <div class="co-left">
                <div class="co-msg" style="color:#ffcccc; font-size:13px; font-weight:bold;">${msg}</div>
            </div>
            <div class="co-right-pill" style="min-width:60px;">
                <svg class="warn-icon" viewBox="0 0 24 24" style="width:20px;height:20px;fill:#fff;"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"></path></svg>
            </div>
            <div class="co-close" onclick="$('#${id}').remove()">✕</div>
        </div>`;
        $('#cashout_notification_container').prepend(html);
        setTimeout(() => { $(`#${id}`).fadeOut(300, function() { $(this).remove(); }); }, 3000);
    }

    window.showPanel2 = function() { $('#panel_2').show(); $('#add_panel_btn').hide(); };
    window.hidePanel2 = function() { $('#panel_2').hide(); $('#add_panel_btn').show(); };
    $('.tab-btn').on('click', function() {
        let p = $(this).data('panel'); let t = $(this).data('tab');
        $('#panel_'+p+' .tab-btn').removeClass('active'); $(this).addClass('active');
        if(t === 'auto') $('#auto_c_'+p).removeClass('hidden'); else $('#auto_c_'+p).addClass('hidden');
    });

    $('input[id^="bet_amt_"]').on('input change', function() { 
        let val = parseFloat($(this).val());
        if(val < 7) val = 7.00;
        if(val > 25000) val = 25000.00;
        let p = $(this).attr('id').split('_')[2];
        $('#btn_val_'+p).text(val.toFixed(2)); 
    });
    
    window.changeBet = (p, v) => { 
        if(bets[p].active || bets[p].waiting) return; 
        let e = $('#bet_amt_'+p); 
        let n = parseFloat(e.val()) + v; 
        if(n < 7) n = 7.00;
        if(n > 25000) n = 25000.00;
        e.val(n.toFixed(2)).trigger('change'); 
    };

    $('.cashout-close').on('click', function() { $(this).siblings('input').val('1.10'); });

    function resize() {
        if(wrapper.offsetWidth > 0 && wrapper.offsetHeight > 0) {
            canvas.width = wrapper.offsetWidth; canvas.height = wrapper.offsetHeight;
        }
    }
    window.addEventListener('resize', resize);
    setTimeout(resize, 500);

    function startLoadingSprite() {
        if(loadingInterval) clearInterval(loadingInterval);
        let f = 0;
        loadingInterval = setInterval(() => {
            f = (f + 1) % 4;
            let img = document.getElementById('p' + f);
            if(img) $('#loading_sprite').attr('src', img.src);
        }, 100);
    }
    function stopLoadingSprite() { clearInterval(loadingInterval); }

    function initGame() {
        resize();
        $('.loader').show(); 
        $('.flew-text').hide();
        $('#multiplier').hide().text('1.00x').css('color', 'white');
        $('.smoke-bg').removeClass('smoke-blue smoke-purple smoke-pink');

        startLoadingSprite();
        $('.load-fill').css('width', '100%').stop().animate({width:'0%'}, 5000, "linear");
        $('.bg-rotate').removeClass('paused');

        setTimeout(() => {
            $.ajax({
                url: 'api/aviator_api.php', type: 'POST', data: { action: 'new_game' }, dataType: 'json',
                success: function(res) {
                    if(res.status === 'success') {
                        crashPoint = parseFloat(res.crash_point);
                        checkWaitingBets(1, res.game_id);
                        checkWaitingBets(2, res.game_id);
                        if(typeof onBetPanelGameStart === 'function') onBetPanelGameStart();
                        $('.loader').fadeOut(200, function() {
                            $('#multiplier').show();
                            stopLoadingSprite();
                        });
                        startAnimation();
                    } else { setTimeout(initGame, 2000); }
                }, error: function() { setTimeout(initGame, 2000); }
            });
        }, 5000);
    }

    function startAnimation() {
        isRunning = true;
        isCrashing = false;
        multiplier = 1.00;
        let startTime = Date.now();
        flyAwayX = 0; flyAwayY = 0;

        function loop() {
            if(!isRunning && !isCrashing) return;
            let elapsed = Date.now() - startTime;
            let t = elapsed / 1000; 

            // ✅ REAL EXPONENTIAL LOGIC (No Fake Stuck 1.00x)
            // Phase 1 (0-25s): Exponential Start (Reaches ~5.00x)
            // e^(0.0644 * 25) ≈ 5.00
            if (t <= 25) {
                multiplier = Math.exp(0.0644 * t); 
            } 
            // Phase 2 (25s+): Accelerated Exponential
            else {
                let dt = t - 25;
                // Starts from 5.00x and speeds up
                multiplier = 5.00 * Math.exp(0.08 * dt);
            }

            frameCount++;
            if (frameCount >= frameSpeed) { currentFrameIndex = (currentFrameIndex + 1) % 4; frameCount = 0; }

            if(isRunning) {
                $('.smoke-bg').removeClass('smoke-blue smoke-purple smoke-pink');
                if(multiplier >= 10.0) $('.smoke-bg').addClass('smoke-pink');
                else if(multiplier >= 2.0) $('.smoke-bg').addClass('smoke-purple');
                else $('.smoke-bg').addClass('smoke-blue');

                if(typeof onBetPanelTick === 'function') onBetPanelTick(multiplier);
            }

            drawGraph(multiplier, elapsed);
            
            if(isRunning) {
                $('#multiplier').text(multiplier.toFixed(2) + 'x');
                checkAutoCashout(1); checkAutoCashout(2);
                updateCashoutUI(1); updateCashoutUI(2);
                if(multiplier >= crashPoint) triggerCrash();
            }
            if(isRunning || isCrashing) animationFrame = requestAnimationFrame(loop);
        }
        loop();
    }

    // ✅ FIXED: Oscillation 30-70%, 5% Width, Plane at Y-28
    function drawGraph(prog, elapsed) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        let animOn = (typeof window.isAnimOn !== 'undefined') ? window.isAnimOn : true;
        if(!animOn) return; 

        let w = canvas.width; let h = canvas.height;
        let t = elapsed / 1000; 
        let x, y;

        if(t < 2) {
            // Start Phase
            x = 30 + ((t / 2) * (w * 0.65)); 
            y = (h - 50) - (Math.pow(t, 0.5) * 60); 
        } else {
            // Hover Phase
            let baseX = 30 + (w * 0.65); 
            let midY = h * 0.5;
            let ampY = h * 0.2; 
            
            // Continuous Loop
            let floatY = Math.sin(t * 0.8) * ampY; 
            let floatX = Math.cos(t * 0.5) * 15; 
            
            x = baseX + floatX;
            y = midY + floatY;
        }

        if(isCrashing) { flyAwayX += 15; flyAwayY -= 10; x += flyAwayX; y += flyAwayY; }

        if(!isCrashing) {
            ctx.beginPath(); ctx.moveTo(0, h);
            ctx.quadraticCurveTo(x/2, h, x, y + 25);
            ctx.strokeStyle = '#e50539'; ctx.lineWidth = 5; ctx.lineCap = 'round'; ctx.stroke();
            ctx.lineTo(x, h); ctx.lineTo(0, h);
            ctx.fillStyle = 'rgba(229, 5, 57, 0.2)'; ctx.fill();
        }
        
        let currentImg = planeFrames[currentFrameIndex];
        if(currentImg && currentImg.complete) {
            // ✅ MOVED PLANE TO Y-28 (Perfect for stroke)
            ctx.drawImage(currentImg, x - 15, y - 28, 90, 50); 
        }

        if(isCrashing && x > w + 200) { isCrashing = false; cancelAnimationFrame(animationFrame); }
    }

    function triggerCrash() {
        isRunning = false; isCrashing = true; 
        playCrashSound();
        if(typeof onBetPanelCrash === 'function') onBetPanelCrash(crashPoint);

        $('.smoke-bg').removeClass('smoke-blue smoke-purple smoke-pink');
        $('.flew-text').show(); $('#multiplier').css('color', '#e50539').text(crashPoint.toFixed(2) + 'x');
        $('.bg-rotate').addClass('paused');
        let cl = crashPoint >= 10 ? 'color-pink' : (crashPoint >= 2 ? 'color-purple' : 'color-blue');
        
        // 1. Update Strip
        $('#hist_row').prepend(`<div class="hist-item ${cl}">${crashPoint.toFixed(2)}x</div>`);
        
        // 2. Update Dropdown
        $('.hd-body').prepend(`<div class="hd-item ${cl}">${crashPoint.toFixed(2)}x</div>`);
        
        handleLoss(1); handleLoss(2);
        setTimeout(() => { isCrashing = false; triggerAutoBets(); initGame(); }, 3000);
    }

    function handleLoss(p) { 
        if(bets[p].active) { 
            bets[p].active = false; bets[p].id = 0; 
            $('#btn_cashout_'+p).addClass('hidden'); 
            $('#btn_bet_'+p).removeClass('hidden'); 
        }
        toggleInputLock(p, false); 
    }
    
    function checkWaitingBets(p, gid) {
        if(bets[p].waiting) {
            let amt = parseFloat($('#bet_amt_'+p).val());
            if(amt < 7 || amt > 25000) {
                bets[p].waiting = false;
                $('#btn_cancel_'+p).addClass('hidden'); $('#btn_bet_'+p).removeClass('hidden');
                toggleInputLock(p, false);
                showErrorPopup('Bet Limit: 7 - 25000 INR');
                return;
            }
            
            let currBal = parseFloat($('#display_bal').text());
            if(currBal < amt) {
                bets[p].waiting = false;
                $('#btn_cancel_'+p).addClass('hidden'); $('#btn_bet_'+p).removeClass('hidden');
                toggleInputLock(p, false);
                showErrorPopup('Insufficient Funds');
                return;
            }

            $.post('api/aviator_api.php', { action: 'place_bet', amount: amt, game_id: gid }, function(res) {
                if(res.status == 'success') {
                    bets[p].active = true; bets[p].id = res.bet_id; bets[p].waiting = false;
                    if(typeof updateHeaderBalance === 'function') updateHeaderBalance(res.new_balance);
                    $('#btn_cancel_'+p).addClass('hidden'); $('#btn_cashout_'+p).removeClass('hidden'); 
                } else {
                    bets[p].waiting = false; $('#btn_cancel_'+p).addClass('hidden'); $('#btn_bet_'+p).removeClass('hidden');
                    toggleInputLock(p, false);
                    if(res.message.includes('Low') || res.message.includes('Insufficient') || res.message.includes('Balance')) {
                        showErrorPopup('Insufficient Funds');
                    } else {
                        showErrorPopup(res.message);
                    }
                }
            }, 'json');
        }
    }

    window.cashOut = (p) => {
        if(!bets[p].active) return;
        $.post('api/aviator_api.php', { action: 'cash_out', bet_id: bets[p].id, multiplier: multiplier }, function(res) {
            if(res.status == 'success') {
                playWinSound();
                showCashOutPopup(multiplier, res.win_amount);
                if(typeof updateHeaderBalance === 'function') updateHeaderBalance(res.new_balance);
                bets[p].active = false; bets[p].id = 0; $('#btn_cashout_'+p).addClass('hidden'); 
                let btn = $('#btn_bet_'+p); btn.removeClass('hidden').find('.btn-text-large').text('WON');
                setTimeout(() => btn.find('.btn-text-large').text('BET'), 2000);
                toggleInputLock(p, false); 
            }
        }, 'json');
    };

    function checkAutoCashout(p) {
        if(bets[p].active && bets[p].id > 0 && $('#auto_cash_sw_'+p).is(':checked')) {
            let target = parseFloat($('#auto_cash_val_'+p).val());
            if(multiplier >= target) cashOut(p);
        }
    }
    function triggerAutoBets() {
        if($('#auto_bet_sw_1').is(':checked') && !bets[1].active && !bets[1].waiting) toggleBet(1);
        if($('#auto_bet_sw_2').is(':checked') && $('#panel_2').is(':visible') && !bets[2].active && !bets[2].waiting) toggleBet(2);
    }
    function updateCashoutUI(p) {
        if(bets[p].active && bets[p].id > 0) {
            let win = ($('#bet_amt_'+p).val() * multiplier).toFixed(2);
            $('#cash_val_'+p).text(win + ' ₹');
        }
    }
    window.toggleBet = (p) => { 
        bets[p].waiting = true; 
        $('#btn_bet_'+p).addClass('hidden'); 
        $('#btn_cancel_'+p).removeClass('hidden'); 
        toggleInputLock(p, true);
    };
    
    window.cancelBet = (p) => { 
        bets[p].waiting = false; 
        $('#btn_cancel_'+p).addClass('hidden'); 
        $('#btn_bet_'+p).removeClass('hidden'); 
        toggleInputLock(p, false);
    };
});
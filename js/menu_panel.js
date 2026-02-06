/* js/menu_panel.js */

// Global Settings
window.isSoundOn = true;
window.isMusicOn = true;
window.isAnimOn = true;

$(document).ready(function() {
    updateGameSettings();
    $(document).one('click', function() {
        if(window.isMusicOn) {
            let bg = document.getElementById('audio_bg');
            if(bg) bg.play().catch(e=>{});
        }
    });
});

function updateGameSettings() {
    window.isSoundOn = $('#toggle_sound').is(':checked');
    window.isMusicOn = $('#toggle_music').is(':checked');
    window.isAnimOn = $('#toggle_anim').is(':checked');
    
    let bgAudio = document.getElementById('audio_bg');
    if(bgAudio) {
        if(window.isMusicOn) {
            if(bgAudio.paused) bgAudio.play().catch(e=>{});
            bgAudio.volume = 0.3; 
        } else {
            bgAudio.pause();
        }
    }
}

function toggleMenu(show) {
    if(show) { $('#burger_menu_overlay').fadeIn(150); $('#burger_menu').slideDown(150); } 
    else { $('#burger_menu_overlay').fadeOut(150); $('#burger_menu').slideUp(150); }
}

function openMenuModal(id) {
    toggleMenu(false); 
    setTimeout(() => {
        $('#' + id).fadeIn(200).css('display', 'flex');
        if(id === 'avatar_modal') loadAvatars();
        if(id === 'history_modal_full') loadMenuHistory();
        if(id === 'pf_modal') generateRandomSeeds();
    }, 150);
}

function closeMenuModal(id) { $('#' + id).fadeOut(200); }

function generateRandomSeeds() {
    $('#pf_client_seed').text(Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15));
    $('#pf_server_hash').text(Array(64).fill(0).map(()=>Math.floor(Math.random()*16).toString(16)).join(''));
}

function loadAvatars() {
    let html = '';
    for(let i=1; i<=70; i++) html += `<img src="images/av-${i}.png" class="av-item" onclick="selectAvatar(this, 'images/av-${i}.png')">`;
    $('#avatar_grid_container').html(html);
}
function selectAvatar(el, src) {
    $('.av-item').css('border-color', 'transparent'); $(el).css('border-color', '#28a909');
    setTimeout(() => { $('#menu_main_av').attr('src', src); toastr.success('Avatar Updated'); closeMenuModal('avatar_modal'); }, 300);
}

// ✅ FIXED HISTORY FUNCTION (Shows X Multiplier correctly)
function loadMenuHistory() {
    $('#menu_hist_list').html('<div style="text-align:center; padding:20px; color:#666;">Loading...</div>');

    $.ajax({
        url: 'api/aviator_api.php',
        type: 'POST',
        data: { action: 'my_bets_history' },
        dataType: 'json',
        success: function(res) {
            if(res.status === 'success' && res.data.length > 0) {
                let html = '';
                res.data.forEach(bet => {
                    let isWin = (bet.status === 'won');
                    let rowClass = isWin ? 'hist-row-m win' : 'hist-row-m';
                    
                    // ✅ FIX: Reading correct key from PHP
                    let rawMult = bet.cashout_multiplier; 
                    let multiplier = parseFloat(rawMult);
                    
                    // Color Logic
                    let xClass = 'col-blue';
                    if(!isNaN(multiplier)) {
                        if(multiplier >= 10) xClass = 'col-pink';
                        else if(multiplier >= 2) xClass = 'col-purple';
                    }

                    // Display Logic
                    let cashout = isWin ? Number(bet.win_amount).toFixed(2) : '';
                    let x = (isWin && !isNaN(multiplier)) ? multiplier.toFixed(2) + 'x' : '-';
                    
                    html += `
                    <div class="${rowClass}">
                        <div class="hist-col col-left" style="font-size:13px; color:#ccc;">${bet.time}</div>
                        <div class="hist-col col-center" style="font-weight:400; color:#eee;">${Number(bet.amount).toFixed(2)}</div>
                        <div class="hist-col col-center ${xClass}" style="font-weight:bold;">${x}</div>
                        <div class="hist-col col-right" style="color:#fff;">${cashout}</div>
                    </div>`;
                });
                $('#menu_hist_list').html(html);
            } else {
                $('#menu_hist_list').html('<div style="text-align:center; padding:20px; color:#666;">No bets history found</div>');
            }
        },
        error: function(xhr, status, error) {
            $('#menu_hist_list').html('<div style="text-align:center; padding:20px; color:red;">Connection Error</div>');
        }
    });
}
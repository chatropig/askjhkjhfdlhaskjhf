/* js/bet_panel.js */

const botNames = [
    "Vi***k", "Ra***ul", "Am***t", "Sk***9", "Ki***g", "Ro***y", "Aj***y", "De***p", 
    "Mo***t", "Sa***m", "Ar***n", "Vi***y", "Ma***x", "Jo***n", "Da***d", "Sm***h",
    "Pr***m", "Ak***h", "Su***l", "Ra***j", "An***l", "Ni***n", "Ka***n", "Ab***i"
];

let allBetsData = [];
let prevBetsData = [];
let currentTab = 'all';

// ✅ COUNTERS & STATES
let totalBetsTarget = 0;      
let currentBetsDisplay = 0;   
let bettingPhaseInterval;     
let isFlyingPhase = false;    
let minThreshold = 0;         

$(document).ready(function() {
    updateHeaderAvatars(); 
    setInterval(updateHeaderAvatars, 2000); 
});

function updateHeaderAvatars() {
    for(let i=1; i<=3; i++) {
        let r = Math.floor(Math.random() * 70) + 1; 
        $(`#h_av${i}`).attr('src', `images/av-${r}.png`);
    }
}

// --- TABS ---
function switchPanelTab(tab) {
    currentTab = tab;
    $('.toggle-btn').removeClass('active');
    $('.panel-content').hide();
    $(`#tab_btn_${tab}`).addClass('active');
    $(`#tab_${tab}`).show();
    if(tab === 'my') fetchMyBets();
}

// --- 1. CRASH EVENT ---
function onBetPanelCrash(cp) {
    if(allBetsData.length > 0) {
        prevBetsData = [...allBetsData];
        renderPrevious();
    }
    
    let cl = 'prev-result-val';
    if(cp >= 10) cl += ' col-pink';
    else if(cp >= 2) cl += ' col-purple';
    else cl += ' col-blue';
    $('#prev_hand_val').removeClass().addClass(cl).text(cp.toFixed(2) + 'x');

    if(currentTab === 'my') fetchMyBets();

    isFlyingPhase = false;
    currentBetsDisplay = 0;
    
    totalBetsTarget = Math.floor(Math.random() * (3500 - 1000 + 1)) + 1000;
    minThreshold = Math.floor(totalBetsTarget * (Math.random() * 0.05 + 0.10));

    $('#bet_prog_line').css('width', '0%');
    $('#total_bets_count').text("0/0");
    $('#total_win_panel').text("0.00");

    generateBots();

    clearInterval(bettingPhaseInterval);
    let duration = 7500; 
    let intervalTime = 40; 
    let steps = duration / intervalTime;
    let increment = totalBetsTarget / steps;

    bettingPhaseInterval = setInterval(() => {
        if(!isFlyingPhase) {
            currentBetsDisplay += increment;
            currentBetsDisplay += (Math.random() * 3); 

            if(currentBetsDisplay >= totalBetsTarget) currentBetsDisplay = totalBetsTarget;
            
            let val = Math.floor(currentBetsDisplay);
            $('#total_bets_count').text(`${val}/${val}`);
        }
    }, intervalTime);
}

// --- 2. GAME START ---
function onBetPanelGameStart() {
    // Logic handled in crash
}

// --- 3. FLYING PHASE ---
function onBetPanelTick(multiplier) {
    if(!isFlyingPhase) {
        isFlyingPhase = true;
        clearInterval(bettingPhaseInterval);
        currentBetsDisplay = totalBetsTarget;
    }

    if(currentBetsDisplay > minThreshold) {
        let drop = 1.0 + Math.random(); 
        currentBetsDisplay -= drop;
    }

    if(currentBetsDisplay < minThreshold) currentBetsDisplay = minThreshold;

    let val = Math.floor(currentBetsDisplay);
    $('#total_bets_count').text(`${val}/${totalBetsTarget}`);

    let progress = ((totalBetsTarget - val) / totalBetsTarget) * 100;
    $('#bet_prog_line').css('width', `${progress}%`);

    let changed = false;
    let totalWin = 0;
    
    allBetsData.forEach(bot => {
        if(!bot.cashed && multiplier >= bot.target) {
            bot.cashed = true;
            bot.win = bot.amount * bot.target;
            changed = true;
        }
        if(bot.cashed) totalWin += bot.win;
    });

    $('#total_win_panel').text(totalWin.toFixed(2));
    if(changed) renderAllBets();
}

// --- GENERATE & RENDER ---
function generateBots() {
    allBetsData = [];
    let rows = 100; 
    
    for(let i=0; i<rows; i++) {
        let amts = [10, 20, 50, 100, 200, 500, 1000];
        let highAmts = [2000, 4000, 8000];
        let amt = (Math.random() < 0.8) ? amts[Math.floor(Math.random()*amts.length)] : highAmts[Math.floor(Math.random()*highAmts.length)];
        if(Math.random() > 0.5) amt += Math.floor(Math.random()*10); 

        let target = (Math.random() < 0.5) ? (Math.random()*0.9+1.1).toFixed(2) : (Math.random()*3+2).toFixed(2);
        
        let idStart = Math.floor(Math.random() * 9) + 1;
        let idEnd = Math.floor(Math.random() * 10);
        let name = `${idStart}***${idEnd}`;
        let avId = Math.floor(Math.random() * 70) + 1;

        allBetsData.push({
            name: name,
            avatar: `images/av-${avId}.png`,
            amount: amt.toFixed(2),
            target: parseFloat(target),
            cashed: false,
            win: 0
        });
    }
    renderAllBets();
}

function renderAllBets() {
    let html = '';
    let totalWin = 0;

    allBetsData.slice(0, 100).forEach(bot => {
        let rowClass = 'bet-row';
        let xVal = '-';
        let winVal = '-';
        let xColorClass = '';

        if(bot.cashed) {
            rowClass += ' won';
            xVal = `${bot.target.toFixed(2)}x`;
            winVal = (bot.amount * bot.target).toFixed(2);
            totalWin += parseFloat(winVal);
            
            if(bot.target >= 10) xColorClass = 'col-pink';
            else if(bot.target >= 2) xColorClass = 'col-purple';
            else xColorClass = 'col-blue';
        }

        html += `
        <div class="${rowClass}">
            <div class="col-user user-info">
                <img src="${bot.avatar}" class="u-av">
                <span class="u-name">${bot.name}</span>
            </div>
            <div class="col-bet val-bet">${bot.amount}</div>
            <div class="col-x val-x ${xColorClass}">${xVal}</div>
            <div class="col-cash val-cash">${winVal}</div>
        </div>`;
    });
    $('#all_bets_list').html(html);
}

function renderPrevious() {
    let html = '';
    prevBetsData.slice(0, 100).forEach(bot => {
        let rowClass = bot.cashed ? 'bet-row won' : 'bet-row';
        let xVal = bot.cashed ? `${bot.target.toFixed(2)}x` : '-';
        let winVal = bot.cashed ? (bot.amount * bot.target).toFixed(2) : '-';
        let xColorClass = '';
        if(bot.cashed) {
            if(bot.target >= 10) xColorClass = 'col-pink';
            else if(bot.target >= 2) xColorClass = 'col-purple';
            else xColorClass = 'col-blue';
        }
        html += `
        <div class="${rowClass}">
            <div class="col-user user-info">
                <img src="${bot.avatar}" class="u-av">
                <span class="u-name">${bot.name}</span>
            </div>
            <div class="col-bet val-bet">${bot.amount}</div>
            <div class="col-x val-x ${xColorClass}">${xVal}</div>
            <div class="col-cash val-cash">${winVal}</div>
        </div>`;
    });
    $('#prev_bets_list').html(html);
}

function fetchMyBets() {
    $.ajax({
        url: 'api/aviator_api.php',
        type: 'POST',
        data: { action: 'my_bets_history' },
        dataType: 'json',
        success: function(res) {
            if(res.status === 'success') {
                let html = '';
                res.data.forEach(bet => {
                    let isWin = bet.status === 'won';
                    let rowClass = isWin ? 'my-bet-row win-row' : 'my-bet-row';
                    let xColorClass = '';
                    if(isWin) {
                        let x = parseFloat(bet.cashout_multiplier);
                        if(x >= 10) xColorClass = 'col-pink';
                        else if(x >= 2) xColorClass = 'col-purple';
                        else xColorClass = 'col-blue';
                    }
                    let xVal = isWin ? `<span class="${xColorClass}">${bet.cashout_multiplier}x</span>` : '-';
                    let winVal = isWin ? bet.win_amount : '-';
                    
                    // ✅ ICONS REMOVED HERE
                    html += `
                    <div class="${rowClass}">
                        <div class="col-date">
                            <span class="date-text">${bet.time}</span>
                        </div>
                        <div class="col-bet val-bet">${Number(bet.amount).toFixed(2)}</div>
                        <div class="col-x">${xVal}</div>
                        <div class="col-cash val-cash">${winVal}</div>
                    </div>`;
                });
                $('#my_bets_list').html(html);
            }
        }
    });
}
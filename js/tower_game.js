// js/tower_game.js

const CONFIG = {
    boxWidth: 100,
    boxHeight: 110,
    shopWidth: 110,  
    shopHeight: 120, 
    hookHeight: 60,
    ropeLength: 20,  
    floorOffset: 0.92 
};

const Engine = Matter.Engine,
      Runner = Matter.Runner,
      Composite = Matter.Composite,
      Bodies = Matter.Bodies,
      Body = Matter.Body;

let app, engine, runner;
let worldContainer, pivotContainer, craneArm;
let hook, rope, hangingBlock, fallingBlock;
let stack = []; 
let swingTime = 0;
let isGameActive = false;
let gameId = 0;
let multiplier = 1.00;
let floorYPosition = 0;
let canDrop = true; 
let gameTarget = 0; 
let currentBetAmount = 0;

let multiplierHistory = [];
let historyContainer;
let centerMultiplierText;

// HARDCODED MULTIPLIERS: 1st to 100th (100th = 1000x)
const MULTIPLIERS = [
    0.75,   1.22,   1.97,   2.54,   3.67,   4.95,   5.80,   6.72,   7.85,   9.10,    // 1-10
    10.50,  12.10,  13.80,  15.70,  17.80,  20.20,  22.80,  25.60,  28.80,  32.20,   // 11-20
    35.90,  40.00,  44.50,  49.50,  55.00,  61.00,  67.50,  74.80,  82.50,  91.00,   // 21-30
    94.17,  97.45,  100.84, 104.36, 107.99, 111.75, 115.65, 119.68, 123.85, 128.16,  // 31-40
    132.62, 137.24, 142.02, 146.97, 152.09, 157.39, 162.87, 168.55, 174.42, 180.49,  // 41-50
    186.78, 193.29, 200.02, 206.99, 214.20, 221.66, 229.38, 237.37, 245.64, 254.19,  // 51-60
    263.05, 272.21, 281.69, 291.51, 301.66, 312.17, 323.04, 334.30, 345.94, 357.99,  // 61-70
    370.46, 383.37, 396.72, 410.54, 424.84, 439.64, 454.96, 470.81, 487.21, 504.18,  // 71-80
    521.74, 539.91, 558.72, 578.18, 598.33, 619.17, 640.74, 663.06, 686.15, 710.05,  // 81-90
    734.79, 760.38, 786.87, 814.28, 842.65, 872.00, 902.38, 933.81, 966.34, 1000.00  // 91-100
];

// SOUNDS CONFIG
const sounds = {
    bg: new Audio('images/tower/bg.mp3'),
    drop: new Audio('images/tower/drop.mp3'),
    fall: new Audio('images/tower/fall.mp3'),
    cashout: new Audio('images/tower/cashout.mp3')
};
sounds.bg.loop = true;
sounds.bg.volume = 0.2; 

function playSound(name) {
    // Music toggle controls bg music, Sound toggle controls SFX
    if (name === 'bg') {
        if (typeof musicEnabled !== 'undefined' && !musicEnabled) return;
    } else {
        if (typeof soundEnabled !== 'undefined' && !soundEnabled) return;
    }
    if (sounds[name]) {
        let s = sounds[name].cloneNode();
        s.volume = (name === 'bg') ? 0.2 : 0.7;
        s.play().catch(e => {});
    }
}

// Called by sidebar toggleSound() in PHP page
function updateSoundSetting(enabled) {
    // SFX checked live in playSound - no extra action needed
}

// Called by sidebar toggleMusic() in PHP page
function updateMusicSetting(enabled) {
    if (!enabled) {
        sounds.bg.pause();
    } else {
        if (isGameActive) {
            sounds.bg.play().catch(e => {});
        }
    }
}

$(document).ready(initGameEngine);

function initGameEngine() {
    const container = document.getElementById('pixiContainer');
    app = new PIXI.Application({
        resizeTo: container,
        backgroundAlpha: 0, 
        antialias: true,
        autoDensity: true,
        resolution: 2 
    });
    container.appendChild(app.view);
    container.style.zIndex = "100"; 

    engine = Engine.create();
    engine.world.gravity.y = 3.5; 
    runner = Runner.create();
    Runner.run(runner, engine);

    worldContainer = new PIXI.Container();
    pivotContainer = new PIXI.Container();
    craneArm = new PIXI.Container();
    historyContainer = new PIXI.Container();

    pivotContainer.x = app.screen.width / 2;
    pivotContainer.y = -10; 

    pivotContainer.addChild(craneArm);
    app.stage.addChild(worldContainer);
    app.stage.addChild(pivotContainer);
    app.stage.addChild(historyContainer); 

    centerMultiplierText = new PIXI.Text('', {
        fontFamily: 'Arial', fontSize: 60, fontWeight: 'bold', fill: '#f1c40f',
        stroke: '#000', strokeThickness: 4
    });
    centerMultiplierText.anchor.set(0.5);
    centerMultiplierText.visible = false;
    app.stage.addChild(centerMultiplierText);

    const balloon = new PIXI.Sprite(PIXI.Texture.from('images/tower/ballon.webp'));
    balloon.anchor.set(0.5);
    balloon.width = 70;
    balloon.height = 90;
    // Start position in top-left 25% area
    balloon.x = app.screen.width * 0.15;
    balloon.y = app.screen.height * 0.10;
    app.stage.addChildAt(balloon, 0);

    // Balloon floating movement variables
    let balloonTime = 0;
    let balloonDriftX = 0;
    let balloonDriftY = 0;
    let balloonBaseX = balloon.x;
    let balloonBaseY = balloon.y;
    const balloonAreaW = app.screen.width * 0.25; // left 25% width
    const balloonAreaH = app.screen.height * 0.25; // top 25% height
    const balloonMinX = 40;
    const balloonMaxX = balloonAreaW - 40;
    const balloonMinY = 50;
    const balloonMaxY = balloonAreaH - 50;

    // Pick random drift target within bounds
    function newBalloonTarget() {
        balloonDriftX = balloonMinX + Math.random() * (balloonMaxX - balloonMinX);
        balloonDriftY = balloonMinY + Math.random() * (balloonMaxY - balloonMinY);
    }
    newBalloonTarget();

    app.ticker.add(() => {
        balloonTime += 0.008;
        // Slow drift towards target
        balloonBaseX += (balloonDriftX - balloonBaseX) * 0.003;
        balloonBaseY += (balloonDriftY - balloonBaseY) * 0.003;
        // Gentle bobbing
        balloon.x = balloonBaseX + Math.sin(balloonTime * 1.5) * 8;
        balloon.y = balloonBaseY + Math.cos(balloonTime * 1.2) * 6;
        // Slight rotation sway
        balloon.rotation = Math.sin(balloonTime * 1.8) * 0.06;
        // Pick new target when close enough
        if (Math.abs(balloonBaseX - balloonDriftX) < 5 && Math.abs(balloonBaseY - balloonDriftY) < 5) {
            newBalloonTarget();
        }
    });

    hook = new PIXI.Sprite(PIXI.Texture.from('images/tower/hook.webp'));
    hook.anchor.set(0.5, 0); 
    hook.width = 40; 
    hook.height = CONFIG.hookHeight;
    hook.x = 0; 
    
    rope = new PIXI.Graphics();
    craneArm.addChild(rope);
    craneArm.addChild(hook);

    floorYPosition = (app.screen.height * CONFIG.floorOffset);
    setupInitialBase();
    spawnHangingBlock();

    app.ticker.add((delta) => {
        updateGameLoop(delta);
    });
}

function setupInitialBase() {
    let floorBody = Bodies.rectangle(app.screen.width / 2, floorYPosition + 25, 2000, 50, { 
        isStatic: true, friction: 1.0, label: 'floor'
    });
    Composite.add(engine.world, floorBody);

    let baseSprite = new PIXI.Sprite(PIXI.Texture.from('images/tower/floorx1.webp'));
    baseSprite.anchor.set(0.5, 0.5);
    baseSprite.width = CONFIG.shopWidth;
    baseSprite.height = CONFIG.shopHeight;
    baseSprite.x = app.screen.width / 2;
    baseSprite.y = floorYPosition - (CONFIG.shopHeight / 2);

    let baseBody = Bodies.rectangle(app.screen.width / 2, floorYPosition - (CONFIG.shopHeight / 2), CONFIG.shopWidth, CONFIG.shopHeight, {
        isStatic: true, label: 'base_box', friction: 1.0
    });

    worldContainer.addChild(baseSprite);
    Composite.add(engine.world, baseBody);
    stack.push({ body: baseBody, sprite: baseSprite, isStatic: true });
}

function updateGameLoop(delta) {
    swingTime += 0.035; 
    const swingFactor = 1.5; 
    craneArm.x = Math.sin(swingTime * swingFactor) * 22; 
    craneArm.rotation = Math.sin(swingTime * swingFactor) * 0.32; 

    if (hangingBlock) {
        rope.clear();
        rope.lineStyle(1.2, 0x5D4037);
        let ropeStart = CONFIG.hookHeight - 10;
        let boxTop = CONFIG.ropeLength + CONFIG.hookHeight;
        let offset = CONFIG.boxWidth / 2 - 15;
        rope.moveTo(0, ropeStart);
        rope.lineTo(0, ropeStart + 10);
        rope.lineTo(-offset, boxTop);
        rope.moveTo(0, ropeStart + 10);
        rope.lineTo(offset, boxTop);
        hangingBlock.x = 0;
        hangingBlock.y = boxTop + (CONFIG.boxHeight / 2);
    }

    if (fallingBlock && !fallingBlock.landed) {
        syncBody(fallingBlock);

        let lastBox = stack[stack.length - 1].body;
        let boxTop = lastBox.position.y - CONFIG.boxHeight;

        if (!fallingBlock.isLoss) {
            // === WIN DROP: guide to center and land perfectly ===
            Body.setAngle(fallingBlock.body, 0);
            if (fallingBlock.body.position.y > lastBox.position.y - 150) {
                Body.setPosition(fallingBlock.body, { 
                    x: lastBox.position.x, 
                    y: fallingBlock.body.position.y 
                });
            }
            if (Math.abs(fallingBlock.body.velocity.y) < 0.2) {
                landBlock(fallingBlock);
            }
        } else {
            // === LOSS DROP: 3-step scripted sequence ===
            
            // Step 1: Free fall until box reaches top of stack
            if (!fallingBlock.touchedTop) {
                Body.setAngle(fallingBlock.body, 0);
                if (fallingBlock.body.position.y >= boxTop - 2) {
                    fallingBlock.touchedTop = true;
                    fallingBlock.slideTimer = 0;
                    // Stop the box on top - it "lands"
                    Body.setVelocity(fallingBlock.body, { x: 0, y: 0 });
                    Body.setAngularVelocity(fallingBlock.body, 0);
                    Body.setStatic(fallingBlock.body, true);
                    Body.setPosition(fallingBlock.body, { x: fallingBlock.body.position.x, y: boxTop });
                }
            }
            
            // Step 2: Sit on top for a moment (user thinks it landed)
            if (fallingBlock.touchedTop && !fallingBlock.slideStarted) {
                fallingBlock.slideTimer++;
                
                // After ~15 frames (~0.25 sec) - start sliding
                if (fallingBlock.slideTimer > 15) {
                    fallingBlock.slideStarted = true;
                    fallingBlock.slideFrame = 0;
                    
                    // Make dynamic again
                    Body.setStatic(fallingBlock.body, false);
                    
                    // Pick slide direction based on drop offset, or random
                    let offsetX = fallingBlock.body.position.x - lastBox.position.x;
                    fallingBlock.slideDir = (Math.abs(offsetX) > 2) ? (offsetX > 0 ? 1 : -1) : (Math.random() > 0.5 ? 1 : -1);
                }
            }
            
            // Step 3: Scripted slide - we control every frame, guaranteed to fall off
            if (fallingBlock.slideStarted) {
                fallingBlock.slideFrame++;
                let f = fallingBlock.slideFrame;
                let dir = fallingBlock.slideDir;
                
                // Slide speed increases over time (starts slow, accelerates)
                let slideSpeed = 0.5 + f * 0.15;
                // Tilt increases over time
                let tiltAngle = dir * Math.min(f * 0.015, 1.2);
                // Vertical: first stays level, then drops with gravity feel
                let dropSpeed = (f > 10) ? (f - 10) * 0.4 : 0;
                
                // Directly control position and angle (no physics randomness)
                let newX = fallingBlock.body.position.x + (dir * slideSpeed);
                let newY = fallingBlock.body.position.y + dropSpeed;
                
                Body.setPosition(fallingBlock.body, { x: newX, y: newY });
                Body.setAngle(fallingBlock.body, tiltAngle);
                Body.setVelocity(fallingBlock.body, { x: 0, y: 0 }); // We control movement, not physics
                
                // Force game over after box has clearly fallen off (don't wait for screen edge)
                if (f > 30) {
                    gameOver();
                    return;
                }
            }
        }

        // Backup: game over if somehow box goes way below screen
        if (fallingBlock && fallingBlock.body.position.y > app.screen.height + 300) {
            gameOver();
        }
    }

    stack.forEach(item => syncBody(item));
}

function syncBody(item) {
    item.sprite.x = item.body.position.x;
    item.sprite.y = item.body.position.y;
    item.sprite.rotation = item.body.angle;
}

function spawnHangingBlock() {
    if (hangingBlock) return;
    let rnd = Math.floor(Math.random() * 6) + 1;
    let tex = PIXI.Texture.from('images/tower/box' + rnd + '.webp');
    hangingBlock = new PIXI.Sprite(tex);
    hangingBlock.anchor.set(0.5, 0.5);
    hangingBlock.width = CONFIG.boxWidth;
    hangingBlock.height = CONFIG.boxHeight;
    hangingBlock.textureRef = tex;
    craneArm.addChild(hangingBlock);
    fallingBlock = null;
}

window.handleGameAction = function() {
    if (!canDrop) return; 
    if (sounds.bg.paused && (typeof musicEnabled === 'undefined' || musicEnabled)) sounds.bg.play();

    if (!isGameActive) {
        let amt = $('#betAmount').val();
        currentBetAmount = parseFloat(amt);
        $.post('api/tower.php', { action: 'place_bet', amount: amt }, function(res) {
            if (res.status === 'success') {
                gameId = res.game_id;
                isGameActive = true;
                gameTarget = res.target_count || 10; 
                multiplierHistory = []; 
                historyContainer.removeChildren();
                $('#displayBalance').text(res.new_balance);
                $('#buildBtn').addClass('active-play');
                $('#cashoutBtn').addClass('active-play');
                $('#btnText').text("DROP");
                
                // Update Round ID
                if (typeof updateRoundId === 'function') {
                    updateRoundId(gameId);
                } else {
                    $('#roundId').text(gameId);
                }
                
                // Disable bet controls
                if (typeof disableBetControls === 'function') {
                    disableBetControls();
                }
                
                // Update user balance
                if (typeof updateUserBalance === 'function') {
                    updateUserBalance(res.new_balance);
                }
                
                executeDrop();
            } else {
                if (res.message === 'Insufficient Balance') {
                    showInsufficientFundPopup();
                } else {
                    toastr.error(res.message);
                }
            }
        });
    } else {
        executeDrop();
    }
};

// Insufficient Fund Popup
function showInsufficientFundPopup() {
    $('.insufficient-popup').remove();
    
    let popup = $(`
        <div class="insufficient-popup">
            <div class="insufficient-content">
                <img src="images/tower/lose.webp" class="popup-bg-img">
                <div class="popup-text">
                    <div class="oops-text">Insufficient Fund</div>
                    <a href="/deposit.php" class="deposit-btn">DEPOSIT</a>
                </div>
            </div>
        </div>
    `);
    
    $('.game-footer').append(popup);
    
    setTimeout(() => {
        popup.fadeOut(300, function() { $(this).remove(); });
    }, 2000);
}

// Lose Popup
function showLosePopup() {
    $('.result-popup').remove();
    
    let popup = $(`
        <div class="result-popup lose-popup">
            <div class="result-content">
                <img src="images/tower/lose.webp" class="popup-bg-img">
                <div class="popup-text">
                    <div class="oops-text">OOPS</div>
                </div>
            </div>
        </div>
    `);
    
    $('.game-footer').append(popup);
    
    setTimeout(() => {
        popup.fadeOut(300, function() { $(this).remove(); });
    }, 2000);
}

// Win Popup in bet section
function showWinPopup(winAmount, mult) {
    $('.result-popup').remove();
    
    let popup = $(`
        <div class="result-popup win-popup">
            <div class="result-content">
                <img src="images/tower/win.webp" class="popup-bg-img">
                <div class="popup-text">
                    <div class="win-title">YOU WIN</div>
                    <div class="win-amount">₹ ${winAmount}</div>
                    <div style="font-size:14px;color:#fff;margin-top:4px;font-weight:bold;text-shadow:1px 1px 2px rgba(0,0,0,0.7);">Multiplier: x${mult}</div>
                </div>
            </div>
        </div>
    `);
    
    $('.game-footer').append(popup);
    
    setTimeout(() => {
        popup.fadeOut(300, function() { $(this).remove(); });
    }, 2000);
}

// Big Win Popup (Center Screen)
function showBigWinPopup(winAmount, mult) {
    $('.bigwin-overlay').remove();
    
    let popup = $(`
        <div class="bigwin-overlay">
            <div class="bigwin-content">
                <img src="images/tower/won.webp" class="bigwin-bg-img">
                <div class="bigwin-text">
                    <div class="congrats-text">Congratulations</div>
                    <div class="bigwin-title">YOU WIN</div>
                    <div class="bigwin-amount">₹ ${winAmount}</div>
                    <div style="font-size:16px;color:#fff;margin-top:6px;font-weight:bold;text-shadow:1px 1px 2px rgba(0,0,0,0.7);">Multiplier: x${mult}</div>
                </div>
            </div>
        </div>
    `);
    
    $('body').append(popup);
    
    setTimeout(() => {
        popup.fadeOut(500, function() { $(this).remove(); });
    }, 2000);
}

function executeDrop() {
    if (!hangingBlock) return;
    canDrop = false;
    playSound('drop');

    let globalPos = hangingBlock.getGlobalPosition();
    let texture = hangingBlock.textureRef;
    craneArm.removeChild(hangingBlock);
    hangingBlock = null;

    // Pre-determine: is this drop a loss?
    let isLossDrop = (stack.length >= gameTarget);

    // Loss: drop with slight offset so it looks like crane timing was off
    let dropOffsetX = 0;
    if (isLossDrop) {
        dropOffsetX = (Math.random() > 0.5 ? 1 : -1) * (18 + Math.random() * 15);
    }

    let body = Bodies.rectangle(globalPos.x + dropOffsetX, globalPos.y, CONFIG.boxWidth - 4, CONFIG.boxHeight - 4, {
        restitution: 0.0, 
        friction: 0.8,
        density: 0.01, 
        angle: 0
    });
    
    Body.setAngularVelocity(body, 0);

    let sprite = new PIXI.Sprite(texture);
    sprite.anchor.set(0.5, 0.5);
    sprite.width = CONFIG.boxWidth;
    sprite.height = CONFIG.boxHeight;

    Composite.add(engine.world, body);
    worldContainer.addChild(sprite);
    fallingBlock = { 
        body: body, 
        sprite: sprite, 
        landed: false, 
        isLoss: isLossDrop, 
        touchedTop: false, 
        slideStarted: false, 
        slideTimer: 0,
        slideFrame: 0,
        slideDir: 0
    };

    setTimeout(() => {
        canDrop = true;
        if (isGameActive) spawnHangingBlock();
    }, isLossDrop ? 2500 : 1200);
}

function createSmokeEffect(x, y) {
    const smokeContainer = new PIXI.Container();
    worldContainer.addChild(smokeContainer);
    for (let i = 0; i < 10; i++) {
        const particle = new PIXI.Graphics().beginFill(0xDDDDDD, 0.5).drawCircle(0, 0, Math.random() * 12 + 4).endFill();
        particle.x = x + (Math.random() * 80 - 40);
        particle.y = y + (CONFIG.boxHeight / 2); 
        const vx = (Math.random() * 3 - 1.5); const vy = (Math.random() * -1);
        smokeContainer.addChild(particle);
        app.ticker.add(function smokeMove() {
            particle.x += vx; particle.y += vy; particle.alpha -= 0.02;
            if (particle.alpha <= 0) {
                smokeContainer.removeChild(particle);
                if (smokeContainer.children.length === 0) { worldContainer.removeChild(smokeContainer); app.ticker.remove(smokeMove); }
            }
        });
    }
}

function landBlock(item) {
    if(item.landed) return;
    item.landed = true;
    createSmokeEffect(item.body.position.x, item.body.position.y);

    setTimeout(() => {
        Body.setStatic(item.body, true);
        Body.setAngle(item.body, 0); 
        const lastBox = stack[stack.length - 2].body; 
        Body.setPosition(item.body, { x: item.body.position.x, y: lastBox.position.y - CONFIG.boxHeight });
    }, 100);

    stack.push(item);
    
    let currentIdx = stack.length - 2;
    multiplier = MULTIPLIERS[Math.min(currentIdx, MULTIPLIERS.length-1)];
    showMultiplierAnimation("x" + multiplier);
    
    $('#cashoutAmt').text((currentBetAmount * multiplier).toFixed(2));
    moveCamera();
}

function showMultiplierAnimation(val, isZero = false) {
    centerMultiplierText.text = val;
    centerMultiplierText.style.fill = isZero ? '#ff0000' : '#f1c40f';
    centerMultiplierText.x = app.screen.width / 2;
    centerMultiplierText.y = app.screen.height / 3;
    centerMultiplierText.scale.set(0.5);
    centerMultiplierText.visible = true;
    centerMultiplierText.alpha = 1;

    let start = Date.now();
    let timer = setInterval(() => {
        let elapsed = Date.now() - start;
        if (elapsed < 300) {
            centerMultiplierText.scale.set(0.5 + (elapsed/300) * 0.7);
        } else if (elapsed < 800) {
            // Stay in center
        } else if (!isZero) {
            centerMultiplierText.x += (app.screen.width - 50 - centerMultiplierText.x) * 0.2;
            centerMultiplierText.y += (100 - centerMultiplierText.y) * 0.2;
            centerMultiplierText.scale.set(centerMultiplierText.scale.x * 0.9);
            centerMultiplierText.alpha -= 0.1;
            if (centerMultiplierText.alpha <= 0) {
                clearInterval(timer);
                centerMultiplierText.visible = false;
                updateHistory(val);
            }
        } else {
            clearInterval(timer);
            setTimeout(() => centerMultiplierText.visible = false, 1000);
        }
    }, 30);
}

function updateHistory(val) {
    multiplierHistory.unshift(val);
    if (multiplierHistory.length > 4) multiplierHistory.pop();
    
    historyContainer.removeChildren();
    multiplierHistory.forEach((m, i) => {
        let box = new PIXI.Graphics()
            .lineStyle(2, 0xf1c40f) 
            .beginFill(0x000000, 0.5)
            .drawRoundedRect(0, 0, 60, 30, 5)
            .endFill();
        let txt = new PIXI.Text(m, { fontSize: 14, fill: '#fff', fontWeight: 'bold' });
        txt.anchor.set(0.5); txt.x = 30; txt.y = 15;
        box.addChild(txt);
        box.x = app.screen.width - 70;
        box.y = 80 + (i * 40);
        historyContainer.addChild(box);
    });
}

function moveCamera() {
    let shift = CONFIG.boxHeight;
    stack.forEach(item => Body.translate(item.body, { x: 0, y: shift }));
    Composite.allBodies(engine.world).forEach(b => { if (b.label === 'floor') Body.translate(b, { x: 0, y: shift }); });
    $('.move-layer').animate({ bottom: '-=' + shift + 'px' }, 500);
}

function gameOver() {
    if (!isGameActive) return;
    playSound('fall');
    isGameActive = false;
    showMultiplierAnimation("x0", true);
    
    // Show lose popup
    showLosePopup();
    
    $.post('api/tower.php', { action: 'game_over', game_id: gameId }, () => resetGame(true));
}

window.cashOut = function() {
    if (!isGameActive) return;
    playSound('cashout'); 
    $.post('api/tower.php', { action: 'cashout', game_id: gameId, multiplier: multiplier }, function(res) {
        let winAmount = res.win_amount;
        
        // 30% chance for big win popup
        let showBigWin = Math.random() < 0.3;
        
        if (showBigWin) {
            showBigWinPopup(winAmount, multiplier);
        } else {
            showWinPopup(winAmount, multiplier);
        }
        
        // Update balance
        $.get('api/get_balance.php', function(balRes) {
            if(balRes.balance) {
                $('#displayBalance').text(balRes.balance);
                if (typeof updateUserBalance === 'function') {
                    updateUserBalance(balRes.balance);
                }
            }
        });
        
        resetGame(true);
    });
};

function resetGame(full) {
    isGameActive = false;
    canDrop = true;
    gameTarget = 0;
    $('#buildBtn').removeClass('active-play');
    $('#cashoutBtn').removeClass('active-play');
    $('#btnText').text("BUILD");
    
    // Enable bet controls
    if (typeof enableBetControls === 'function') {
        enableBetControls();
    }
    
    if(full) {
        worldContainer.removeChildren();
        Composite.clear(engine.world, false); 
        stack = [];
        $('.move-layer').stop().css('bottom', ''); 
        setupInitialBase();
        multiplierHistory = [];
        historyContainer.removeChildren();
    }
    if(!hangingBlock) spawnHangingBlock();
}
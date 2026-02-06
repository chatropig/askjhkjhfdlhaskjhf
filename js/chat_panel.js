/* js/chat_panel.js */

// ✅ YOUR PROVIDED API KEY
const GIPHY_API_KEY = "XNl6BIXASiJoSlaYXeQRMOp58VLNQEgp"; 

// Default Search Terms (Mixed)
const DEFAULT_TOPICS = ["money", "winning", "party", "funny", "bollywood", "girl", "happy"];

let gifPool = []; 
let chatLoopInterval;
let onlineCountInterval;
let autoLikeInterval;
let searchTimeout;

// ✅ GAME MESSAGES POOL
const gameMessages = [
    "Bhai real app h ye", "Mera withdrawal aa gya", "10 min me paisa account me",
    "Fake bolne wale dur raho", "Signal 100% working h", "Admin god h bhai",
    "Mene 50k nikala aaj", "Loss recover ho gya pura", "Daro mat khelo bindas",
    "Fake apps se bacho ye real h", "Telegram join karlo sab", "Next round 2x pakka",
    "Pink aayega likh ke lelo", "Signal follow karo bas", "Trust me guys genuine h",
    "Risk mat lo jyada", "Small bet se start karo", "Mera 2 lakh ka profit h is month",
    "Instant withdrawal mila mujhe", "Koi cheat nahi h yaha", "Pattern samjho bas",
    "Aaj jackpot lagega", "Fly baby fly", "Rocket ban gya ye to",
    "Bhai withdrawal processing me h?", "Haan mera aa gya abhi", "Approved ho gya"
];

const randomMessages = [
    "Koi girl h kya yaha?", "Any girl from Delhi?", "Jaipur se koi h?", 
    "Mera mood ban gya aaj to", "Jeet gya ab party hogi", "Koi single ladki h?",
    "Insta id do apni", "Snapchat use karti ho?", "Hello ladies", 
    "Koi setting kara do yaar", "Paisa to aa gya ab bandi chaiye", 
    "Mumbai se kon h?", "Pune wale attendance lagao", "Bangalore girls dm",
    "Bhabhi mil gayi guys", "Are yaar koi baat hi nahi karta", 
    "Single boys like karo", "GF chaiye bas ab", "Mood off h yaar",
    "Koi dosti karega?", "Number do na", "Video call karogi?",
    "Akele bore ho rha hu", "Party tonight", "Gedi maarne chale?"
];

const msgParts = {
    start: ["Bhai", "Sir", "Admin", "Yaar", "Guys", "Bro", "Suno", "Dekho", "Oye", "Hello"],
    mid: ["paisa aa gaya", "withdrawal mil gaya", "signal mast h", "game real h", "loss cover ho gaya", "maza aa gaya"],
    end: ["gazab", "instant", "thank you", "love you", "op bolte", "fast h", "sahi h", "loot lo"]
};

$(document).ready(function() {
    // Inject Like Icon
    if($('#icon-thumb').length === 0) {
        $('body').append(`
            <svg style="display:none;">
                <symbol id="icon-thumb" viewBox="0 0 24 24">
                    <path d="M7 22h-5v-13h5v13zm9-18c-3.07 0-5.32 1.89-6 4h-2v11h2c.31 1.74 1.95 3 3.86 3h2.37c1.37 0 2.59-.92 2.92-2.24l1.79-7.15c.23-.92-.47-1.85-1.42-1.85h-4.52l.98-4.14c.15-.63-.33-1.25-.97-1.25-.43 0-.83.23-1.01.63z" />
                </symbol>
            </svg>
        `);
    }
    // Pre-load default GIFs
    fetchGifsFromApi(); 
});

// --- 1. GIF API & SEARCH LOGIC ---

function fetchGifsFromApi(query = "") {
    let url = "";
    if(query) {
        // Search specific
        url = `https://api.giphy.com/v1/gifs/search?api_key=${GIPHY_API_KEY}&q=${query}&limit=20&rating=pg-13`;
    } else {
        // Random mix
        let topic = DEFAULT_TOPICS[Math.floor(Math.random() * DEFAULT_TOPICS.length)];
        url = `https://api.giphy.com/v1/gifs/search?api_key=${GIPHY_API_KEY}&q=${topic}&limit=20&rating=pg-13`;
    }

    $('#gif_grid_container').html('<div class="loading-text">Loading...</div>');

    $.getJSON(url, function(data) {
        if(data && data.data && data.data.length > 0) {
            let html = "";
            // Update pool if it's a default load
            if(!query) {
                data.data.forEach(g => gifPool.push(g.images.fixed_height_small.url));
            }
            
            // Render in Grid
            data.data.forEach(gif => {
                let src = gif.images.fixed_height_small.url;
                html += `<img src="${src}" onclick="sendUserGif('${src}')">`;
            });
            $('#gif_grid_container').html(html);
        } else {
            $('#gif_grid_container').html('<div class="loading-text">No results found.</div>');
        }
    }).fail(function() {
        $('#gif_grid_container').html('<div class="loading-text">Error loading GIFs.</div>');
    });
}

function handleGifSearch(val) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        fetchGifsFromApi(val);
    }, 600); // 600ms debounce
}

function toggleGifModal() {
    $('#gif_selector').toggle();
    // If opening and empty search, refresh randoms
    if($('#gif_selector').is(':visible') && $('#gif_search_input').val() === '') {
        fetchGifsFromApi();
    }
}

// --- 2. AUTO LIKE INCREASE LOGIC ---
function startAutoLiker() {
    clearInterval(autoLikeInterval);
    autoLikeInterval = setInterval(() => {
        // Find all visible messages
        let msgs = $('.chat-msg-row');
        if(msgs.length === 0) return;

        // Pick a random message
        let randomMsg = $(msgs[Math.floor(Math.random() * msgs.length)]);
        let likeBtn = randomMsg.find('.msg-like');
        let countSpan = likeBtn.find('.l-count');
        let currentLikes = parseInt(countSpan.text());

        // Increment if less than 5
        if(currentLikes < 5) {
            likeBtn.addClass('liked');
            countSpan.text(currentLikes + 1);
            // Visual pop
            likeBtn.css('transform', 'scale(1.2)');
            setTimeout(() => likeBtn.css('transform', 'scale(1)'), 200);
        }
    }, 2000); // Check every 2 seconds
}

// --- TOGGLE CHAT ---
function toggleChat(show) {
    if(show) {
        $('#game_chat_overlay').fadeIn(200);
        $('body').css('overflow', 'hidden'); 
        if($('#chat_list').children().length === 0) initChat();
        
        startOnlineCounter();
        startChatLoop();
        startAutoLiker(); // ✅ START LIKING
    } else {
        $('#game_chat_overlay').fadeOut(200);
        $('body').css('overflow', ''); 
        clearInterval(onlineCountInterval);
        clearInterval(chatLoopInterval);
        clearInterval(autoLikeInterval);
    }
}

// --- INITIAL LOAD ---
function initChat() {
    let html = '';
    for(let i=0; i<15; i++) {
        html += createRandomMessage(i);
    }
    $('#chat_list').html(html);
    scrollToBottom();
}

// --- LIVE CHAT LOOP ---
function startChatLoop() {
    clearInterval(chatLoopInterval);
    function loop() {
        let delay = Math.floor(Math.random() * 3000) + 3000;
        chatLoopInterval = setTimeout(() => {
            addNewMessage();
            loop(); 
        }, delay);
    }
    loop();
}

function addNewMessage() {
    let msgHTML = createRandomMessage();
    $('#chat_list').append(msgHTML);
    if($('#chat_list').children().length > 15) {
        $('#chat_list').children().first().remove();
    }
    scrollToBottom();
}

// --- MESSAGE CREATOR ---
function createRandomMessage(index = 0) {
    if(Math.random() > 0.95) {
        let banId = generateBotName();
        return `
        <div class="banned-box">
            <span class="banned-id">${banId}</span> has been <b>banned</b> from chat for 10000 min.<br>
            <span style="color:#888; font-size:11px;">Reason: Spamming / Abuse</span>
        </div>`;
    }

    let botName = generateBotName();
    let avId = Math.floor(Math.random() * 70) + 1;
    // ✅ Start with 1 like
    let likes = 1; 
    
    // GIF Logic
    let isGif = Math.random() < 0.70; 
    let content = '';
    
    if(isGif && gifPool.length > 0) {
        let g = gifPool[Math.floor(Math.random() * gifPool.length)];
        content = `<img src="${g}" class="chat-gif-img">`;
    } else {
        let txt = '';
        let r = Math.random();
        if(r < 0.4) txt = gameMessages[Math.floor(Math.random() * gameMessages.length)];
        else if (r < 0.7) txt = randomMessages[Math.floor(Math.random() * randomMessages.length)];
        else {
            let s = msgParts.start[Math.floor(Math.random() * msgParts.start.length)];
            let m = msgParts.mid[Math.floor(Math.random() * msgParts.mid.length)];
            let e = msgParts.end[Math.floor(Math.random() * msgParts.end.length)];
            txt = `${s} ${m} ${e}`;
        }
        content = `<span class="chat-text">${txt}</span>`;
    }

    return `
    <div class="chat-msg-row">
        <img src="images/av-${avId}.png" class="chat-avatar">
        <div class="msg-content">
            <div class="msg-top">
                <span class="chat-user-id">${botName}</span>
            </div>
            ${content}
        </div>
        <div class="msg-like liked" onclick="likeMsg(this)">
            <svg class="like-icon-svg"><use href="#icon-thumb"></use></svg>
            <span class="l-count">${likes}</span>
        </div>
    </div>`;
}

function generateBotName() {
    let s = Math.floor(Math.random() * 9) + 1;
    let e = Math.floor(Math.random() * 10);
    return `${s}***${e}`;
}

// --- USER ACTIONS ---
function sendUserMessage() {
    let txt = $('#chat_input').val();
    if(txt.trim() === '') return;
    appendUserMsg(`<span class="chat-text">${txt}</span>`);
    $('#chat_input').val('');
}

function sendUserGif(src) {
    appendUserMsg(`<img src="${src}" class="chat-gif-img">`);
    $('#gif_selector').hide();
}

function appendUserMsg(contentHtml) {
    let uid = "You";
    let html = `
    <div class="chat-msg-row" style="background: rgba(40,169,9,0.05); border-radius:5px; padding:5px;">
        <img src="images/av-1.png" class="chat-avatar">
        <div class="msg-content">
            <div class="msg-top">
                <span class="chat-user-id" style="color:#28a909; font-weight:bold;">${uid}</span>
            </div>
            ${contentHtml}
        </div>
    </div>`;
    
    $('#chat_list').append(html);
    if($('#chat_list').children().length > 15) {
        $('#chat_list').children().first().remove();
    }
    scrollToBottom();
}

function scrollToBottom() {
    let d = $('#chat_list');
    d.animate({ scrollTop: d.prop("scrollHeight") }, 300);
}

function likeMsg(el) {
    let countSpan = $(el).find('.l-count');
    let current = parseInt(countSpan.text());
    if(current >= 5) return; 
    $(el).addClass('liked');
    countSpan.text(current + 1);
    $(el).css('transform', 'scale(1.2)');
    setTimeout(() => $(el).css('transform', 'scale(1)'), 200);
}

function startOnlineCounter() {
    let count = Math.floor(Math.random() * (12000 - 7000 + 1)) + 7000;
    $('#chat_online_count').text(count);
    clearInterval(onlineCountInterval);
    onlineCountInterval = setInterval(() => {
        let change = Math.floor(Math.random() * 50) - 25;
        count += change;
        if(count < 7000) count = 7000;
        $('#chat_online_count').text(count);
    }, 2000);
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Chicken Road</title>
    <link rel="shortcut icon" href="images/logo.png" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/toastr.min.css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/chicken.css"> 
    <script>window.balance = 0;</script>
</head>
<body>

    <div id="pageLoader">
        <img src="images/logo.png" alt="INOUT" class="loader-logo">
        <div class="loader-spinner"></div>
        <div class="loader-text">Loading...</div>
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


    <div class="chicken-header">
        <div class="ch-left">
            <img src="images/chicken-road-logo.svg" alt="Logo" class="ch-logo" onerror="this.src='images/logo.png'">
            <div class="ch-balance">
                <span id="balanceDisplay">0.00</span>
                <div class="currency-circle-white">₹</div>
            </div>
        </div>
        <div class="ch-right">
            <i class="fas fa-bars ch-menu-icon" id="menuIcon"></i>
            
            <div class="menu-dropdown" id="menuDropdown">
                <div class="user-info">
                    <img src="images/default_avatar.png" alt="User">
                    <div>
                        <span class="user-name">52103</span>
                        <span class="change-avatar">Change avatar</span>
                    </div>
                </div>
                
                <div class="menu-toggle-row">
                    <span><i class="fas fa-volume-up"></i> Sound</span>
                    <label class="switch"><input type="checkbox" id="soundToggle" checked><span class="slider round"></span></label>
                </div>
                <div class="menu-toggle-row">
                    <span><i class="fas fa-music"></i> Music</span>
                    <label class="switch"><input type="checkbox" id="musicToggle" checked><span class="slider round"></span></label>
                </div>

                <div class="menu-item" id="provablyFairBtn"><i class="fas fa-shield-alt"></i> Provably fair settings</div>
                <div class="menu-item" id="gameRulesBtn"><i class="fas fa-file-alt"></i> Game rules</div>
                <div class="menu-item" id="betHistoryBtn"><i class="fas fa-history"></i> My bet history</div>
                <div class="menu-item" id="howToPlayBtn"><i class="fas fa-info-circle"></i> How to play?</div>
                
                <div class="powered-by">Powered by <img src="images/inout_logo.svg" alt="INOUT" onerror="this.style.display='none'"></div>
            </div>
        </div>
    </div>
<div class="live-wins-overlay">
    <div class="lw-header-pill">
        <span class="lw-title">Live wins</span>
        <span class="blink-dot"></span>
        <span class="lw-online">Online: <span id="active-users">3811</span></span>
    </div>

    <div id="winners-feed">
        </div>
</div>

<style>
    /* --- Layout & Positioning --- */
    .live-wins-overlay {
        position: absolute;
        top: 100px;  
        left: 10px;
        z-index: 999;
        font-family: 'Roboto', sans-serif;
        pointer-events: none; 
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    /* --- Header Design --- */
    .lw-header-pill {
        background: transparent !important; 
        box-shadow: none !important;
        border: none !important;
        padding: 5px 0px; 
        display: flex;
        align-items: center;
        width: fit-content;
    }

    .lw-title {
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        margin-right: 10px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.9);
    }

    .blink-dot {
        height: 6px;
        width: 6px;
        background-color: #00e676; 
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 0 6px #00e676;
    }

    .lw-online {
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.9);
    }

    /* --- Winner Row Design --- */
    .winner-card {
        background: linear-gradient(to right, rgba(22, 32, 50, 0.95) 0%, rgba(22, 32, 50, 0.5) 60%, rgba(22, 32, 50, 0) 100%);
        border-radius: 4px; 
        padding: 4px 10px 4px 4px; 
        display: flex;
        align-items: center;
        width: fit-content;
        min-width: 180px;
        animation: slideIn 0.4s ease-out;
        margin-top: 2px;
    }

    .avatar-wrapper {
        position: relative;
        width: 30px;
        height: 30px;
        margin-right: 8px;
        flex-shrink: 0;
    }

    .profile-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(0, 0, 0, 0.4);
        font-size: 12px;
    }

    .flag-icon {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 1px solid #fff; 
        object-fit: cover;
    }

    .user-data {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .username {
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        max-width: 110px; /* Name thoda lamba dikhane ke liye width badhai */
        overflow: hidden;
        text-overflow: ellipsis;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
        text-transform: capitalize; /* Har naam ka pehla akshar bada dikhega */
    }

    .win-amount {
        color: #4ade80; 
        font-weight: 800;
        font-size: 13px;
        text-shadow: 0 0 5px rgba(74, 222, 128, 0.6);
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    // ✅ Updated List (Split by comma and @)
    const users = [
        "barjraj", "ramdin verma", "sharat chandran", "birender mandal", "amit", "kushal", "kasid", "shiv prakash", "vikram singh", "sanjay", "abhi", "ram dutt gupta", "khadak singh", "gurmit singh", "chanderpal", "aman", "khursid", "rajeev", "durgesh", "nahar singh", "ram kumar", "sunder paal", "maansingh aswal", "rohit", "sparsh", "santosh", "punit khandelwal", "dinesh", "gulshan", "arvind kumar yadav", "nausad", "gurmit singh", "md. afsar", "shiv shakti singh", "moti lal", "kausal kumar", "mohabbat ali", "raj kumar", "jaswant singh", "sevak", "pitambar lal", "chotelal", "rupesh", "midda", "dharam singh", "manoj yadav", "manoj", "ram singh", "preetam kumar", "sarain", "pankaj kumar", "sheak shakir", "riyasat ali", "vinit katariya", "sumit", "arindra", "kali charan", "badshya khan", "vikash", "devinder chadda", "mohan singh", "hemant", "shivam", "yash mittal", "aakash", "chandesh", "sumit mitra", "supriyal sen", "gajender singh", "goldy", "pooran chand sharma", "irfan", "azaruddin", "mukul yadav", "sanjay charee", "raja babu", "pawan", "sandeep", "rajkumar chawla", "parvesh", "mohd ataullah", "neeraj kumar", "jamil khan", "yogita", "rijul aggarwal", "mohd shakib", "rahul kumar", "rajender", "suraj", "rizwan", "md mustafa", "har parsad", "deepak", "rahul", "abhishekh", "shelender yadav", "ankit", "mohd aakib", "surender singh chauhan", "arjun", "rahul sharma", "keshar ansari", "raju", "chhotu", "kuldeep singh", "santlal", "golu", "lalit rana", "pulkit sharma", "aman soni", "badal", "jahoor ahmed meer", "tammanne", "kailash kumar", "bhagwati prasad", "ajay", "silender", "akhilesh", "dipendra kumar", "nitin", "doodhnath pandit", "aslam allam", "jitender kumar", "adnan", "vijay", "yogesh", "kabir", "sarvesh", "rakesh sarkar", "akash gupta", "pintu thakur", "vivek", "mohd khairul", "farmaan khan", "vansu dev", "shyam kumar", "shafibul", "lalit kathuriya", "pooran chand", "aamir hussain", "kamal jit singh", "shiv kumar", "mayank chaudhary", "som dutt", "bablu regar", "rajkumar", "mubarik", "niraj", "sarbjeet", "ronak", "axat", "anubhav shrivastab", "akkash", "himanshu", "harsh dagar", "anil kumar", "vijay virmani", "vivek auhari", "sachin", "subhash chand bhatia", "bhupender", "raghunandan das", "ajay kumar", "yognder", "subhash", "arun", "vicky", "vikas", "vinod", "salman", "mohan kumar", "sandeep meghawal", "imamudeen", "sandeep kumar", "tarjan", "murari", "ramvilash", "jagdish", "vishal", "moni", "mohd shahid", "kuldeep", "talim", "nanku prasad", "bhola sarkar", "balraj", "ravindra kumar", "rohit kumar", "uttam kumar", "sanki", "babalu sen", "rustam shah", "sukhdev", "b vikjay kumar", "dolly", "rekha w/o monto shah", "gopal sharma", "beeru", "vipin", "manish garg", "guddu", "jatin", "sonu", "amit kumar", "shadab", "rakesh", "abhishek", "gulfam", "phoolwati", "phoolo devi", "mohit maan", "veer bhan singh", "dinesh kumar", "amarjeet", "satyadev", "mohd. mukhtaar", "rishi", "esrail khan", "suresh kumar", "pankaj chand", "ajay narayan", "mohit", "saddam", "nikhleshwar bhagat", "jai singh", "sunil kumar", "ram kishan", "virender", "bishun", "pritam singh", "kishan", "mohd kausar", "harman singh", "rajbir", "vinod lal", "chander shaker", "krishan", "ram ji", "jony", "mohammad ali", "ashok kumar s/o", "ravinder", "bacchi", "guman singh basyal", "amardeep", "bharat", "azaz", "raja kumar", "parveen", "mahabir prasad", "kartik", "kaku", "shubham yadav", "madan", "rashid", "jitender", "pawan kumar", "pintu kumar", "deep", "dharmbir", "rishi kakdia", "kunal", "kannu", "arman ansari", "avinsh", "karan", "sagar", "nikhil", "raman", "sujen manjhi", "abhijeet", "anshu", "sahil", "aditya som", "gaurav", "sunil", "ravi kumar", "shankar kumar", "vishvash", "sonia", "kayamuddin", "nandkishore karpenter", "lala bhai", "kishan rai", "mahender kumar", "mohd afzal", "satender", "shiv prasad singh", "mobin", "khokan sarkar", "krisana braman", "vipol", "mohd miraj ansari", "rajmani", "harbir singh", "mohan", "farid", "yuvraj kumar", "charan jeet singh", "satish kumar", "gappu", "nazeem", "aamir", "vivek sharma", "gutam", "prakul", "birjesh", "sahil tigga", "girishi chand", "pavan sharma", "ikramuddin", "sajan", "molu", "dilawar", "naval kishore", "ajahar", "sanjeev", "raman ralhan", "prem chand", "sandhaya", "ashish", "jang bahadur", "om parkash ahuja", "kamre alam", "md. raju", "satpal", "ram pyare", "suraj singh", "ashfaq", "shaid", "vikas gupta", "vijay singh", "hari ram", "manoj kumar", "parash das", "mehraj", "chetan", "bhanwar lal", "sanavvar", "mustaq", "ramkaran verma", "mukhtyar hussain", "vakil", "bilal malik", "radheshyam sen", "mukesh", "sunny", "jitender rajak", "brahamprakash s/o meer singh", "raju singh", "sobit saini", "inder dutt", "shakir", "haseen ahmed", "kiran", "gulam rashul", "rajan", "ayush", "sehboob", "sanjay kumar s/o", "manish", "amit kumar yadav", "divaraj", "kamlesh", "rajiv bagoriya", "abhinav chaudhary", "devender singh", "azruddin", "sanjay kumar", "pappu", "mushir ahmed", "vibhuti shyamal", "inderjeet", "lokesh", "neeraj kandari", "mukul verma", "rijakpal", "jai kishan", "munna lal jain", "jai prakash kashyap", "shishram", "parveen aggarwal", "pramod paswan", "ajit", "deelip", "aaftaab husan", "monu", "ramesh", "sawan gupta", "munna lal", "saurabh", "sarvesh kumar pandey", "avdhesh", "sohnal kumar singh", "najar hussan", "raman", "rancho", "lavtar singh", "nanak chand", "harprasad sahu", "vikas kumar", "ashsish kumar", "rajesh singh", "ashu", "manjeet", "jaipal", "jalil ansari", "deepak verma", "kasim", "monu kumar", "manish kumar saket", "udham", "saurabh s/o", "ravinder", "narayan gadri", "lakshman nath", "sachin kumar", "shahid", "munna", "ravi jaiswal", "ishtkar", "harish chand", "puneet jain", "rashab", "amit kumar shukla", "praful naag", "tarachand", "deepak rana", "puran singh rastogi", "narender", "lal babu prasad", "ankush", "lal chand", "pankaj", "kiran pal", "ranveer singh", "anwar", "sadab urf golu", "gorav", "raj kumar", "laxmikant", "kaka", "narayan parsad bhushal", "abbas", "avinash", "ravish", "hukum chand", "pappu", "mahender singh", "akash tomer", "mahesh chand tiwari", "rekhai", "gajender kumar", "vashudev", "bhanwar singh", "surender sain", "akshay kumar", "satyender", "kalu", "devender", "veer", "shera", "mohd. amir", "babloo", "bhavesh dass", "gourav", "guddu rai", "yogesh rawat", "amarapal", "rajesh agarwal", "tara singh rawat", "momin", "parnav kumar", "parminder", "mustafa", "ajay haldar", "dharmender", "gaurav sethi", "suresh", "parth madan", "abhimanyu", "rohan", "raju garg", "samir mishra", "ram dayal", "jagdish chand", "kanheya", "mushrraf", "prem", "pardeep kumar", "nithyanandham", "deepak goyal", "sunil ladkani", "gopal", "mahavir", "indra sain", "soni", "arun kumar", "ashok sharma", "veer singh", "aman dahiya", "laxmi narayan", "vikram dubey", "rima", "ramjan khan", "sunder", "omparkash", "alok tiwari", "vude bhadur", "prem singh bidla", "chetanya swaroop", "pinkoo", "shardanand", "henkhochon haokip", "gaurav shankar", "shsi kant", "md. tavrej", "amrudin", "shahnawaz", "brij raj", "aman kumar", "vijay kumar", "baban", "suresh", "subham kumar yadav", "sapna", "surendra", "naveen", "ram niwas", "amar", "nanhu khan", "raja ram", "rishab", "ziyabul", "jag mohan", "ritu raj kumar", "raj kapoor", "arvind agarwal", "pinto", "rajbir ahlawat", "mohd faijan", "shyama", "mohd. firoz", "bhag chand", "parbhat", "aamod & pramod", "chander shekhar", "nanagram", "gautam", "govind", "pramjot singh", "abhinav vashit", "usha", "vivek chabra", "nootan prakash yadav", "surender", "chhotelal", "abdul kadir", "sambhu", "bablu", "ram ldaike", "yasib", "sone lal shah", "chhotu harijan", "sushant", "om prakash", "manish kumar", "adersen", "mukesh kumar yogi", "gautam kumar", "hardeep", "hunny", "fitrat", "pankaj saini", "manish sehrawat", "ravi chandra natarajan", "karunakar dehra", "somdath", "shiva", "rajeev jha", "mukesh soni", "ashok kharkwal", "iswar sharan", "maj- koko khaing", "manni", "amrit patel", "tausin", "rajveer", "rupesh rathor", "dinesh singh rana", "bhrat narayn", "annu", "ombir singh", "anand", "rajesh kumar", "varun chandela", "yameen", "ravi singh", "jitendra singh", "iarfan mohammad", "vasim", "gaurav kumar", "prateek kumar tiwari", "birju", "pradeep", "raghubir singh", "ayub khan", "ram jatan", "azhar ali", "tufail", "afridi", "tahir", "ankit tiwari", "ravi", "abhay", "anuj tiwari", "vipiv malkania", "inderpal", "dinesh singh", "sanjit misra", "aasto", "charan singh", "dhansinghpuri", "chottu shah", "ram chander jha", "nirmal", "niranjan", "mantu kumar", "firakat ali", "ashshwer parsad", "akash", "andhav", "akhil kumar", "ranbir", "inderjeet mandal", "sikandar", "arjun singh", "vishal mishra", "dalip shah", "mohd. jafruddin", "satnosh", "sohan lal", "vinod kumar", "aasish kumar", "tavinder kumar", "laxman", "milan", "harishankar verma", "sri kant", "radheyshyam saini", "mohit", "damanjeet singh", "sameer", "bhushan sahay", "ramesh kumar", "samadh", "malkeet singh", "uma shankar", "kamla prasad", "mohd. iqbal", "tikku", "janesh", "lakshya chauhan", "lucky", "anoop singh", "dal chand", "pushpendra singh rathore", "harpal singh", "khimanand", "manoj kumar", "satesh kumar", "akshit", "chandan kumar", "vinay", "pancham", "ritu raj", "vinay kumar upadhayay", "shekher", "abhishek yadav", "manish khandelwal", "bir singh", "rajkumar saini", "mohd sajim", "shankarlal", "neeraj kishore", "ishwar", "bilal", "ravi parkash solanki", "rohit kumar tiwari", "pramod", "manjeet kumar", "vimal kumar", "abbas mehndi", "omprkash", "deepak rathore", "masoom", "deepak kamat", "ajju", "toquir ali", "shyam sundra", "sarthak dadwal", "armaan", "suvalin", "kunal kishore", "nabav shekh", "kasim ansari", "nitin parkash", "subin sugathan", "mayur agarwal", "madan lal", "vinay kumar", "ghansyam soni", "ram dutt", "sanjeev sharma", "asharam", "son pal", "sonu kumar", "badri prsad mishra", "azad ali", "jorj vargees", "naresh adhikari", "deepu", "pawan singh", "aashik", "amit kumar verma", "subham", "sugodh kumar", "ashok", "satish", "munender singh", "krishan kumar", "ashutosh", "saddam hussain", "harender", "jay kumar", "mohd imran", "munna", "shyam sunder", "parmod", "mangat singh", "aryan prateek", "rahul chauhan", "savan", "mohd siwam", "aarif", "rajender kumar", "ramesh singh negi", "patik", "nand kishor", "rajeev luka", "sarad raghuvansi", "ram prakash", "sh pratap singh", "liyakat ali", "bodh raj", "kala", "pankaj ratori", "leela dhar narang", "chanchal", "abdul rehman", "shamshad", "bittu paswan", "shashank sharma", "hare chatiyan", "vipulander", "abdul rahman", "khuma ram", "naresh chand", "komal / kabila", "mungeri", "deepak kumar mishra", "piyush", "lakhan", "nadim", "sahdab", "tufel", "tekchand", "bobby", "tejvir", "dilip", "ravi shankar", "subodh", "pramood", "dev", "tinku", "shri kant", "om parkash", "muntiyaj", "chetan pandey", "lilu", "surjeet", "sunder lal", "aman bhatt", "ratikant maghi", "deva", "firoz", "dr. hema hari pago", "raghuveer", "dheeraj", "sardar sarbjeet singh", "raman sharma", "lalit rastogi", "sita ram", "dharmbir singh", "ritik", "ketan", "angreg singh", "sitaram bairwa", "rampati", "karan bajaj", "ramsurat", "jitendra kumar", "lalit kumar", "jockyipai", "aslam ali", "suraj kumar", "murli dhar", "rehman khan", "gurdarshan singh", "ramsem", "shahrukh", "krishan gopal", "atul kumar", "shanwaz anwar", "samsuddin", "jyoti prakash", "sourav", "chain singh", "ravi", "rinkku", "somender", "sorabh", "phirdos alam", "aabid", "rajneesh kumar", "shakil", "ayan khan", "rajesh naydu", "monu", "lalit", "harsh singhal", "abhinav vashishat", "amil", "sidharath", "madan jain", "milap chand", "atul", "mohit chauhan", "amar singh mahar", "mannu", "santosh pandey", "sanny kumar", "roshan", "aashu", "jeeya lal", "sachin kumal taneja", "arjun yadav", "ishant", "ramesh malik", "sagar", "takla", "durganand", "chandan", "mohd parvez", "same singh", "vijay pal singh", "ramkishan gupta", "tarun sharma", "brijmohan", "montu", "tajuddin", "mannu yadav", "suhail", "shakti singh", "haider ali", "sok. mohmad", "pandit ram niwas", "baksi", "banwari lal bairwa", "suresh paswan", "madari", "krishan lal gulyani", "devraj", "man singh", "uday partap", "rakesh kumar", "kanhaiya lal", "kripal singh", "ram naresh yadav", "nand kishore", "kaif", "shyam", "arsh", "chirag", "prince", "tarif", "lalan devi", "ali sher", "sheru khan", "bhanu pratap singh", "sanni", "vanish khan", "firoj", "ram narayan meena", "kishan", "smt sunita", "ranjeet", "traun kumar", "lokesh varma", "sushil kumar", "subhakar", "ram suresh", "prem giri pradhan ji", "shabuddin shah", "surender singh", "dheeraj singh", "rakesh bhatia", "sanni singh", "surgayan kanwar", "rinki", "akram", "khemraj", "shri kant ghore", "neeraj", "sanjeev panday", "krishan kishore", "jatin kumar", "jeetu", "shubham chauhan", "chaterpal", "banti", "pankaj baisla", "vijay sharma", "khada chand", "shaukat khan", "bholu", "arman", "jay dev jha", "mo. aasif", "lekhraj", "praveen", "aayush", "punit kumar", "ankur", "ajeet kumar", "lok nath", "rattan vail", "rajaram", "ranjit", "sujeet gupta", "cheddi lal", "dheeraj kumar", "deepak upadhayaya", "shail", "naresh", "sandeep thakur", "sahrukh khan", "kalu luhar", "ishwar ram", "lekhraj pahuja", "tara dutt suyal", "gaurav raj", "gaurav sharam", "rahul parikh", "raja", "swapanesh gupta", "rupender", "shankar lal", "kumari ritu", "manjiv singh", "kamruddin", "jaiprakash", "mukesh kumar", "aditya kumar", "anurag", "vijay pal", "bal bahadur kayanchhaki", "raju rathor", "laksh", "dipanshu", "sanjay mandal", "jitendera singh", "jagmal", "pankaj tomar", "radhey shyam verma", "chandra dhar pande", "mahender lal", "abdul salam", "prasant", "vishal tiwari", "balwant ray arora", "rahul roy", "prahlad", "vipendra singh", "mujaffar", "musarraf", "sharukh", "ravinder singh rana", "harison", "danish", "gaurav malik", "inderjeet kumar", "anuj", "bandu khan", "sudhir", "dhrmveer singh", "aditya kasana", "adi", "sunil singh", "sachin chauhan", "multan", "riyaz", "sunil kumar singh", "sagar pahwa", "balbir singh", "bijender", "billu", "yogesh shukla", "mithlesh sharma", "mohak kaul", "divansh", "muneer", "yogesh kumar", "dhalchand", "bishan ram", "ramesh chander gupta", "paras", "farmaan aamin", "ganesh singh", "chanden", "shiva kumar", "sandeep kumar sharma", "deepak kumar", "sani", "virender bhatia", "roshan kumar", "suraj manda", "nirmal yadav", "aarif khan", "harsh", "chandrram", "shankar lal gopalani", "ansh", "ram subhak", "islam", "sohaib", "krishana", "sonali", "satyam", "viney parkash", "ram parkash teneja", "prem pal", "dhramender", "swami nathan", "rakesh panday", "murari lal maharaj", "narayan", "sartaj ali", "ramhetu", "jabir hussain", "shiv singh", "harvinder singh sandhu", "anandi lal", "mh. yameen", "sajjan", "prhalad kumar", "jatin", "partik munchal", "kapil", "sumit rathi", "yogesh budhiraja", "manoj jain", "salin malhotra", "raj", "shayam sunder", "vinod tiwari", "imran", "daya ram", "sameem", "chetanram", "ajman", "puspak kandpal", "desh deepak pandey", "shisupal", "vikarm", "shayamveer singh", "shyamveer", "balwant singh", "paul nepal", "ramchander", "harkesh", "anup kumar misgra", "sonu mishra", "randhir ram", "shashikant", "aadil sefi", "arvind", "jai bhagwan", "rajaram nayak", "smt. pooja", "vijay kukreja", "shyam narain pande", "anuj kumar", "mohhmad shahil ragraj", "bablu singh", "pancu", "ramtek", "gauri visht", "punarjyoti lahiri", "parteek", "hansraj", "deepu", "radha raman", "nadeem", "babu", "sameer khen", "ameen", "sanjiv pathak", "nizamuddin", "vijay ghimre", "rahul paswan", "suman", "dinesh garg", "manish maheshwari", "yash", "nand lal meena", "rani ranjan", "shayam", "mahipal", "ramprasad", "rohit ahlawat", "asif", "surender kumar singh", "sachin verma", "daniel gomes", "rajesh", "zakir hussain", "agyapad bhatya", "deepak maan", "suwadhin shriwastava", "arif", "noorjama", "tukun", "mohd israr", "yashin", "sukaa", "neeraj chauhan", "raviraj", "inder singh sawant", "shoab jamal", "teerath singh", "ankur divedi", "gautam rehan", "sone lal bhanderi", "harichand", "chatan", "mohd jahid", "deepchand", "jasveer singh", "deepender kumar", "deep chand"
    ];

    const profileColors = [
        '#ff8a80', '#82b1ff', '#b9f6ca', '#ea80fc', '#ffe57f', '#ffcc80', '#80d8ff'
    ];

    const userCountElement = document.getElementById('active-users');
    let currentUsers = 3811; 

    // Online Users Logic
    setInterval(() => {
        currentUsers += Math.floor(Math.random() * 10) - 3; 
        if (currentUsers < 3000) currentUsers = 3000;
        userCountElement.innerText = currentUsers;
    }, 3000); 

    const feedContainer = document.getElementById('winners-feed');

    function getRandomAmount() {
        return (Math.random() * (30000 - 1550) + 1550).toFixed(2);
    }

    function showNewWinner() {
        const randomUser = users[Math.floor(Math.random() * users.length)];
        const amount = getRandomAmount();
        const randomColor = profileColors[Math.floor(Math.random() * profileColors.length)];
        const flagUrl = "https://flagcdn.com/w40/in.png";

        const html = `
            <div class="winner-card">
                <div class="avatar-wrapper">
                    <div class="profile-circle" style="background-color: ${randomColor};">
                        <i class="fas fa-user"></i>
                    </div>
                    <img src="${flagUrl}" class="flag-icon" alt="IN">
                </div>
                <div class="user-data">
                    <span class="username">${randomUser}...</span>
                    <span class="win-amount">+₹${amount}</span>
                </div>
            </div>
        `;
        feedContainer.innerHTML = html;
    }

    showNewWinner();

    function loopWinners() {
        const randomTime = Math.floor(Math.random() * (3500 - 1500 + 1) + 1500);
        setTimeout(() => {
            showNewWinner();
            loopWinners();
        }, randomTime);
    }
    loopWinners(); 
</script>    <div class="game-container" id="gameContainer">
        <div class="image-wrapper" id="background-track"></div>
    </div>

    <div class="betx-section">  
        <div class="bet-section">
            <div class="bet-controls">
                <button class="bet-btn" id="minBetBtn">MIN</button>
                <div class="bet-input-wrapper"><input type="number" id="betAmountInput" class="bet-amount-input" value="10" min="10" max="100000"></div>
                <button class="bet-btn" id="maxBetBtn">MAX</button>
            </div>
            <div class="quick-bets">
                <button class="quick-bet" data-amount="20">20<div class="currency-circle-white">₹</div></button>
                <button class="quick-bet" data-amount="50">50<div class="currency-circle-white">₹</div></button>
                <button class="quick-bet" data-amount="100">100<div class="currency-circle-white">₹</div></button>
                <button class="quick-bet" data-amount="500">500<div class="currency-circle-white">₹</div></button>
            </div>
            <div class="mode-dropdown-container">
                <select id="modeSelect">
                    <option value="easy">Easy</option><option value="medium">Medium</option><option value="hard">Hard</option><option value="hardcore">Hardcore</option>
                </select>
            </div>
            <button class="play-btn" id="playBtn">Play</button>
            <div class="game-actions">
                <div class="cashout-btn" id="cashoutBtn">CASHOUT<div class="cashout-amount" id="cashoutAmount">0.00 <div class="currency-circle-white" style="width:12px;height:12px;font-size:8px;">₹</div></div></div>
                <button class="go-btn" id="goBtn">GO</button>
            </div>
        </div>

        <div id="cashoutPopup" class="cashout-popup">
            <p><span class="win-text">WIN !</span></p>
            <p><span id="popupMultiplier" class="multiplier-text"></span></p>
            <div class="popup-amount-row"><span id="popupCashoutAmount" class="amount-text"></span><div class="currency-circle">₹</div></div>
        </div>

        <div id="provablyFairModal" class="info-modal">
            <div class="info-modal-content">
                <div class="modal-header"><span class="modal-title">Provably fair settings</span><span class="close-modal">&times;</span></div>
                <div class="modal-body">
                    <p style="font-size:12px; color:#888; margin-bottom:15px;">This game uses Provably Fair technology to determine game result</p>
                    <div class="seed-group">
                        <label class="seed-label">Next client (Your) seed:</label>
                        <div style="font-size:11px; color:#666; margin-bottom:5px;">Round result is determined form combination of server seed and first 3 bets of the round.</div>
                        <label class="seed-label">Random on every game:</label>
                        <div class="seed-input-box"><span id="clientSeed">...</span><i class="fas fa-copy copy-icon"></i></div>
                    </div>
                    <div class="seed-group">
                        <label class="seed-label">Next server seed SHA256:</label>
                        <div class="seed-input-box"><span id="serverSeed">...</span><i class="fas fa-copy copy-icon"></i></div>
                    </div>
                    <p style="font-size:12px; color:#888; text-align:center;">You can check fairness of each bet from bets history</p>
                </div>
            </div>
        </div>

        <div id="gameRulesModal" class="info-modal">
            <div class="info-modal-content">
                <div class="modal-header"><span class="modal-title">Game rules</span><span class="close-modal">&times;</span></div>
                <div class="modal-body">
                    <p>Bet limits are presented below</p>
                    <div class="seed-input-box" style="margin-bottom:10px;"><span>Min bet:</span><span>10 INR</span></div>
                    <div class="seed-input-box" style="margin-bottom:10px;"><span>Max bet:</span><span>100000 INR</span></div>
                    <div class="seed-input-box" style="margin-bottom:10px;"><span>Max win:</span><span>1000000 INR</span></div>
                    <p style="font-size:12px; color:#888;">Malfunction voids all pays and plays</p>
                </div>
            </div>
        </div>

        <div id="howToPlayModal" class="info-modal">
            <div class="info-modal-content">
                <div class="modal-header"><span class="modal-title">How to play?</span><span class="close-modal">&times;</span></div>
                <div class="modal-body">
                    <ol class="rules-list">
                        <li>Specify the amount of your bet.</li>
                        <li>Choose a difficulty level... Easy (24 lines), Medium (22 lines), Hard (20 lines), Hardcore (15 lines).</li>
                        <li>Press "Play" button.</li>
                        <li>Your goal is to get through as many lines as possible without getting fried.</li>
                        <li>You can withdraw your winnings at any stage.</li>
                        <li>Malfunction voids all pays and plays.</li>
                    </ol>
                </div>
            </div>
        </div>

        <div id="betHistoryModal" class="info-modal">
            <div class="info-modal-content">
                <div class="modal-header"><span class="modal-title">My bet history</span><span class="close-modal">&times;</span></div>
                <div class="modal-body">
                    <div id="historyContent">Loading...</div>
                </div>
            </div>
        </div>

        <audio id="burnAudio" src="audio/burn.mp3" preload="auto"></audio>
        <audio id="buttonClickAudio" src="audio/button.mp3" preload="auto"></audio>
        <audio id="backgroundAudio" src="audio/bg.mp3" loop preload="auto"></audio>
        <audio id="jumpAudio" src="audio/jump.mp3" preload="auto"></audio>
        <audio id="cashoutAudio" src="audio/cashout1.mp3" preload="auto"></audio>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/toastr.min.js"></script>
    <script src="js/chicken_game.js"></script> 
<script defer src="js/vcd15cbe7772f49c399c6a5babf22c1241717689176015.js" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"b4db3be8d00d4fe6859924dd0298e0b2","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>
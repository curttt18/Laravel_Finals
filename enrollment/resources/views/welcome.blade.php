<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>🌈 Little Stars Daycare - Adventure Awaits!</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fredoka-one:400|nunito:400,600,700,800,900&display=swap" rel="stylesheet" />
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html {
            overflow: hidden;
            height: 100%;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
            overflow-y: scroll;
            height: 100vh;
        }
        
        /* Hide scrollbar for cleaner look */
        body::-webkit-scrollbar { width: 0; display: none; }
        body { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Each section is full viewport */
        section {
            height: 100vh;
            width: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        
        /* Confetti Canvas - lightweight */
        #confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }
        
        /* ========== SECTION 1: HERO ========== */
        .hero {
            background: linear-gradient(180deg, #74b9ff 0%, #81ecec 50%, #55efc4 100%);
        }
        
        /* Animated clouds */
        .cloud {
            position: absolute;
            background: white;
            border-radius: 100px;
            box-shadow: 0 10px 30px rgba(255,255,255,0.5);
        }
        
        .cloud::before, .cloud::after {
            content: '';
            position: absolute;
            background: white;
            border-radius: 50%;
        }
        
        .cloud-1 { width: 200px; height: 60px; top: 10%; left: -200px; animation: cloudMove 30s linear infinite; }
        .cloud-1::before { width: 100px; height: 100px; top: -50px; left: 20px; }
        .cloud-1::after { width: 70px; height: 70px; top: -35px; right: 30px; }
        
        .cloud-2 { width: 150px; height: 45px; top: 25%; left: -150px; animation: cloudMove 40s linear infinite; animation-delay: -15s; }
        .cloud-2::before { width: 70px; height: 70px; top: -35px; left: 15px; }
        .cloud-2::after { width: 50px; height: 50px; top: -25px; right: 20px; }
        
        .cloud-3 { width: 180px; height: 55px; top: 5%; left: -180px; animation: cloudMove 35s linear infinite; animation-delay: -25s; }
        .cloud-3::before { width: 90px; height: 90px; top: -45px; left: 25px; }
        .cloud-3::after { width: 60px; height: 60px; top: -30px; right: 25px; }
        
        @keyframes cloudMove { 0% { left: -250px; } 100% { left: 110%; } }
        
        /* Sun */
        .sun {
            position: absolute;
            top: 50px;
            right: 100px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, #fff176 0%, #ffeb3b 50%, #ffc107 100%);
            border-radius: 50%;
            box-shadow: 0 0 80px #ffeb3b, 0 0 150px rgba(255,235,59,0.5);
            animation: sunPulse 4s ease-in-out infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }
        
        @keyframes sunPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        
        /* Ground */
        .ground {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 180px;
            background: linear-gradient(180deg, #55efc4 0%, #00b894 50%, #00a085 100%);
        }
        
        /* Interactive Mascot */
        .mascot-container { position: absolute; bottom: 180px; left: 50%; transform: translateX(-50%); z-index: 10; }
        
        .mascot {
            font-size: 150px;
            cursor: pointer;
            transition: transform 0.3s ease;
            animation: mascotBounce 2s ease-in-out infinite;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.2));
        }
        
        .mascot:hover { transform: scale(1.2) rotate(10deg); animation: none; }
        
        @keyframes mascotBounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        
        .speech-bubble {
            position: absolute;
            top: -80px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 15px 25px;
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: 700;
            color: #6c5ce7;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .speech-bubble::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border: 15px solid transparent;
            border-top-color: white;
        }
        
        .mascot-container:hover .speech-bubble { opacity: 1; }
        
        /* Hero content */
        .hero-content { position: relative; z-index: 5; text-align: center; margin-top: -180px; }
        
        .hero-title {
            font-family: 'Fredoka One', cursive;
            font-size: 5rem;
            color: white;
            text-shadow: 4px 4px 0 #6c5ce7, 8px 8px 0 rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        
        .hero-subtitle {
            font-size: 1.8rem;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        /* Floating navigation */
        .nav-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 15px;
        }
        
        .nav-btn {
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .nav-btn-login { background: white; color: #6c5ce7; box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
        .nav-btn-register { background: linear-gradient(135deg, #fd79a8, #e84393); color: white; box-shadow: 0 5px 20px rgba(253,121,168,0.5); }
        .nav-btn:hover { transform: translateY(-5px) scale(1.1); }
        
        /* ========== SECTION 2: ACTIVITIES ========== */
        .activities {
            background: linear-gradient(180deg, #a29bfe 0%, #6c5ce7 100%);
            padding: 60px 20px;
        }

        .activities::before,
        .game-section::before {
            content: '🎈 ⭐ 🖍️ 🌈 🧩';
            position: absolute;
            font-size: 80px;
            opacity: 0.08;
            top: 10%;
            left: 5%;
            transform: rotate(-10deg);
            pointer-events: none;
        }

        
        .section-title {
            font-family: 'Fredoka One', cursive;
            font-size: 3.5rem;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 3px 3px 0 rgba(0,0,0,0.2);
        }
        
        .section-subtitle {
            text-align: center;
            color: rgba(255,255,255,0.9);
            font-size: 1.3rem;
            margin-bottom: 50px;
        }
        
        /* 3D Flip Cards */
        .activity-grid {
            display: grid;
            grid-template-columns: repeat(4, 280px);
            gap: 30px;
            justify-content: center;
            perspective: 1000px;
        }
        
        .activity-card {
            height: 350px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s ease;
            cursor: pointer;
        }
        
        .activity-card:hover { transform: rotateY(180deg); }

        /* Cute wobble instead of stiff hover */
        @keyframes wobble {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(2deg); }
            50% { transform: rotate(-2deg); }
            75% { transform: rotate(1deg); }
            100% { transform: rotate(0deg); }
        }

        .activity-card:hover {
            animation: wobble 0.6s ease;
        }

        
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        /* Softer cards */
        .card-front, .card-back,
        .testimonial-card,
        .game-container {
            border-radius: 32px;
            box-shadow:
                0 15px 40px rgba(0,0,0,0.2),
                inset 0 4px 0 rgba(255,255,255,0.4);
        }

        
        .card-front { background: white; }
        .card-back { background: linear-gradient(135deg, #fd79a8, #e84393); transform: rotateY(180deg); color: white; }
        
        .card-front .icon { font-size: 80px; margin-bottom: 15px; }
        .card-front h3 { font-family: 'Fredoka One', cursive; font-size: 1.5rem; color: #6c5ce7; margin-bottom: 10px; }
        .card-front p { color: #666; text-align: center; font-size: 1rem; }
        
        .card-back h3 { font-size: 1.3rem; margin-bottom: 15px; }
        .card-back ul { list-style: none; text-align: left; }
        .card-back li { padding: 6px 0; font-size: 1rem; }
        .card-back li::before { content: '✨ '; }
        
        /* ========== SECTION 3: GAME ========== */
        .game-section {
            background: linear-gradient(180deg, #ffeaa7 0%, #fdcb6e 100%);
            padding: 60px 20px;
        }
        
        .game-container {
            max-width: 700px;
            width: 90%;
            background: white;
            border-radius: 40px;
            padding: 40px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.2);
        }
        
        .game-title { font-family: 'Fredoka One', cursive; font-size: 2.2rem; color: #e17055; margin-bottom: 20px; text-align: center; }
        
        .catch-game {
            height: 250px;
            background: linear-gradient(180deg, #74b9ff, #a29bfe);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            cursor: crosshair;
            margin-bottom: 20px;
        }
        
        .catch-item { position: absolute; font-size: 45px; cursor: pointer; user-select: none; transition: transform 0.1s; }
        .catch-item:hover { transform: scale(1.3); }
        
        .game-score { font-size: 1.3rem; font-weight: 800; color: #6c5ce7; text-align: center; }
        .game-instructions { color: #666; margin-bottom: 15px; font-size: 1.1rem; text-align: center; }
        
        /* ========== SECTION 4: TESTIMONIALS ========== */
        .testimonials {
            background: linear-gradient(180deg, #fd79a8 0%, #e84393 100%);
            padding: 60px 20px;
        }
        
        .testimonial-track {
            display: flex;
            animation: scroll 25s linear infinite;
            width: max-content;
        }
        
        .testimonial-track:hover { animation-play-state: paused; }
        
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        
        .testimonial-card {
            background: white;
            border-radius: 25px;
            padding: 35px;
            margin: 0 15px;
            min-width: 320px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .testimonial-avatar { font-size: 60px; margin-bottom: 15px; }
        .testimonial-text { font-size: 1rem; color: #666; line-height: 1.7; margin-bottom: 15px; }
        .testimonial-name { font-weight: 800; color: #6c5ce7; font-size: 1.1rem; }
        
        /* ========== SECTION 5: CTA ========== */
        .cta-section {
            background: linear-gradient(135deg, #2d3436 0%, #636e72 100%);
            padding: 60px 20px;
        }
        
        .cta-stars {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
        }
        
        .cta-star {
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.2;
            animation: twinkle 3s ease-in-out infinite;
        }
        
        @keyframes twinkle { 0%, 100% { opacity: 0.2; } 50% { opacity: 0.5; } }
        
        .cta-content { position: relative; z-index: 1; text-align: center; }
        
        .cta-section h2 { font-family: 'Fredoka One', cursive; font-size: 3.5rem; color: white; margin-bottom: 20px; }
        .cta-section p { font-size: 1.4rem; color: rgba(255,255,255,0.8); margin-bottom: 40px; }
        
        .mega-btn {
            display: inline-block;
            padding: 22px 55px;
            font-family: 'Fredoka One', cursive;
            font-size: 1.8rem;
            color: white;
            background: linear-gradient(135deg, #00cec9, #00b894);
            border-radius: 60px;
            text-decoration: none;
            box-shadow: 0 10px 40px rgba(0,206,201,0.5);
            transition: all 0.3s ease;
        }
        
        .mega-btn:hover { transform: translateY(-10px) scale(1.05); box-shadow: 0 20px 60px rgba(0,206,201,0.6); }
        
        /* Footer within CTA */
        .footer-text { margin-top: 60px; color: rgba(255,255,255,0.6); font-size: 0.95rem; }
        .footer-text a { color: #00cec9; text-decoration: none; font-weight: 600; }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .activity-grid { grid-template-columns: repeat(2, 280px); }
        }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 2.8rem; }
            .mascot { font-size: 100px; }
            .section-title { font-size: 2.2rem; }
            .activity-grid { grid-template-columns: 280px; }
            .nav-float { top: 10px; right: 10px; }
            .nav-btn { padding: 10px 20px; font-size: 0.9rem; }
            .cta-section h2 { font-size: 2.2rem; }
        }
    </style>
</head>
<body>
    <!-- Minimal Confetti Canvas -->
    <canvas id="confetti-canvas"></canvas>
    
    <!-- Floating Navigation -->
    <div class="nav-float">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-btn nav-btn-login">🎯 Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-btn nav-btn-login">👋 Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-btn nav-btn-register">🎉 Join!</a>
                @endif
            @endauth
        @endif
    </div>
    
    <!-- SECTION 1: Hero -->
    <section class="hero">
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>
        <div class="cloud cloud-3"></div>
        <div class="sun">😊</div>
        
        <div class="hero-content">
            <h1 class="hero-title">Little Stars Daycare 🌟</h1>
            <p class="hero-subtitle">Where Every Day is a New Adventure!</p>
        </div>
        
        <div class="mascot-container">
            <div class="speech-bubble" id="speech">Click me! 🎁</div>
            <div class="mascot" id="mascot" onclick="mascotClick()">🧸</div>
        </div>
        
        <!-- Ground -->
        <div class="ground"></div>
    </section>
    
    <!-- SECTION 2: Activities -->
    <section class="activities">
        <h2 class="section-title">🎨 Fun Activities</h2>
        <p class="section-subtitle">Hover over the cards to flip them!</p>
        
        <div class="activity-grid">
            <div class="activity-card">
                <div class="card-front">
                    <div class="icon">🎨</div>
                    <h3>Art & Crafts</h3>
                    <p>Express yourself!</p>
                </div>
                <div class="card-back">
                    <h3>What You'll Create:</h3>
                    <ul>
                        <li>Finger painting</li>
                        <li>Paper craft animals</li>
                        <li>Colorful collages</li>
                    </ul>
                </div>
            </div>
            
            <div class="activity-card">
                <div class="card-front">
                    <div class="icon">📚</div>
                    <h3>Story Time</h3>
                    <p>Adventure awaits!</p>
                </div>
                <div class="card-back">
                    <h3>Magical Stories:</h3>
                    <ul>
                        <li>Fairy tales</li>
                        <li>Interactive stories</li>
                        <li>Puppet shows</li>
                    </ul>
                </div>
            </div>
            
            <div class="activity-card">
                <div class="card-front">
                    <div class="icon">🎵</div>
                    <h3>Music & Dance</h3>
                    <p>Let's groove!</p>
                </div>
                <div class="card-back">
                    <h3>Get Moving:</h3>
                    <ul>
                        <li>Sing-along sessions</li>
                        <li>Dance parties</li>
                        <li>Instruments</li>
                    </ul>
                </div>
            </div>
            
            <div class="activity-card">
                <div class="card-front">
                    <div class="icon">🏃</div>
                    <h3>Outdoor Play</h3>
                    <p>Fresh air fun!</p>
                </div>
                <div class="card-back">
                    <h3>Outside Fun:</h3>
                    <ul>
                        <li>Playground</li>
                        <li>Nature walks</li>
                        <li>Sports games</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- SECTION 3: Game -->
    <section class="game-section">
        <div class="game-container">
            <h2 class="game-title">🎮 Catch the Stars!</h2>
            <p class="game-instructions">Click the stars as fast as you can!</p>
            <div class="catch-game" id="catchGame"></div>
            <p class="game-score">Score: <span id="score">0</span> ⭐</p>
        </div>
    </section>
    
    <!-- SECTION 4: Testimonials -->
    <section class="testimonials">
        <h2 class="section-title" style="margin-bottom: 50px;">💖 Happy Parents</h2>
        <div class="testimonial-track">
            <div class="testimonial-card">
                <div class="testimonial-avatar">👨‍👩‍👧</div>
                <p class="testimonial-text">"My daughter can't wait to go to school every day!"</p>
                <p class="testimonial-name">- Maria & Family</p>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-avatar">👨‍👩‍👦</div>
                <p class="testimonial-text">"The teachers are amazing and truly care!"</p>
                <p class="testimonial-name">- Juan's Parents</p>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-avatar">👩‍👧‍👦</div>
                <p class="testimonial-text">"Best decision we ever made for our kids!"</p>
                <p class="testimonial-name">- The Garcia Family</p>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-avatar">👨‍👩‍👧‍👦</div>
                <p class="testimonial-text">"Safe, fun, and educational!"</p>
                <p class="testimonial-name">- The Santos Family</p>
            </div>
            <!-- Duplicates for seamless loop -->
            <div class="testimonial-card">
                <div class="testimonial-avatar">👨‍👩‍👧</div>
                <p class="testimonial-text">"My daughter can't wait to go to school every day!"</p>
                <p class="testimonial-name">- Maria & Family</p>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-avatar">👨‍👩‍👦</div>
                <p class="testimonial-text">"The teachers are amazing and truly care!"</p>
                <p class="testimonial-name">- Juan's Parents</p>
            </div>
        </div>
    </section>
    
    <!-- SECTION 5: CTA -->
    <section class="cta-section">
        <div class="cta-stars" id="ctaStars"></div>
        <div class="cta-content">
            <h2>Ready for an Adventure? 🚀</h2>
            <p>Join Little Stars and watch your child shine!</p>
            <a href="{{ route('register') }}" class="mega-btn">🌟 Enroll Now! 🌟</a>
            <p class="footer-text">Made with 💖 | <a href="{{ route('login') }}">Staff Portal</a></p>
        </div>
    </section>
    
    <script>
        // Generate stars for CTA section
        const ctaStars = document.getElementById('ctaStars');
        for (let i = 0; i < 30; i++) {
            const star = document.createElement('span');
            star.className = 'cta-star';
            star.textContent = '⭐';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 3 + 's';
            ctaStars.appendChild(star);
        }
        
        // Lightweight confetti - only on mascot click
        const canvas = document.getElementById('confetti-canvas');
        const ctx = canvas.getContext('2d');
        let confetti = [];
        const MAX_CONFETTI = 30;
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);
        
        class Confetto {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.size = Math.random() * 12 + 8;
                this.speedX = (Math.random() - 0.5) * 12;
                this.speedY = Math.random() * -12 - 5;
                this.gravity = 0.4;
                this.rotation = Math.random() * 360;
                this.rotationSpeed = (Math.random() - 0.5) * 8;
                this.emoji = ['⭐', '🌟', '✨', '💖'][Math.floor(Math.random() * 4)];
            }
            
            update() {
                this.speedY += this.gravity;
                this.x += this.speedX;
                this.y += this.speedY;
                this.rotation += this.rotationSpeed;
            }
            
            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.rotation * Math.PI / 180);
                ctx.font = this.size + 'px Arial';
                ctx.fillText(this.emoji, 0, 0);
                ctx.restore();
            }
        }
        
        function triggerConfetti(x, y) {
            const toAdd = Math.min(8, MAX_CONFETTI - confetti.length);
            for (let i = 0; i < toAdd; i++) {
                confetti.push(new Confetto(x, y));
            }
        }
        
        function animateConfetti() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            confetti = confetti.filter(c => c.y < canvas.height + 50);
            confetti.forEach(c => { c.update(); c.draw(); });
            requestAnimationFrame(animateConfetti);
        }
        animateConfetti();
        
        // Mascot interaction
        const mascots = ['🧸', '🐰', '🦁', '🐱', '🐶', '🦊', '🐼', '🐨'];
        let mascotIndex = 0;
        const speeches = ["Hi friend! 👋", "Want to play? 🎮", "Learning is fun! 📚", "Let's be friends! 💖", "You're amazing! ⭐"];
        
        function mascotClick() {
            mascotIndex = (mascotIndex + 1) % mascots.length;
            document.getElementById('mascot').textContent = mascots[mascotIndex];
            document.getElementById('speech').textContent = speeches[Math.floor(Math.random() * speeches.length)];
            document.getElementById('speech').style.opacity = 1;
            
            const rect = document.getElementById('mascot').getBoundingClientRect();
            triggerConfetti(rect.left + rect.width / 2, rect.top);
            
            setTimeout(() => { document.getElementById('speech').style.opacity = 0; }, 2000);
        }
        
        // Star catching game
        let score = 0;
        const gameArea = document.getElementById('catchGame');
        const emojis = ['⭐', '🌟', '💫', '✨'];
        
        function spawnStar() {
            if (!gameArea) return;
            const star = document.createElement('div');
            star.className = 'catch-item';
            star.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            star.style.left = Math.random() * (gameArea.offsetWidth - 50) + 'px';
            star.style.top = '-50px';
            gameArea.appendChild(star);
            
            star.addEventListener('click', () => {
                score++;
                document.getElementById('score').textContent = score;
                star.style.transform = 'scale(2)';
                star.style.opacity = '0';
                setTimeout(() => star.remove(), 150);
            });
            
            let posY = -50;
            const fall = setInterval(() => {
                posY += 2.5;
                star.style.top = posY + 'px';
                if (posY > gameArea.offsetHeight) {
                    clearInterval(fall);
                    star.remove();
                }
            }, 30);
        }
        
        setInterval(spawnStar, 1200);
        
        // Smooth scroll between sections
        const sections = document.querySelectorAll('section');
        let currentSection = 0;
        let isScrolling = false;
        
        function smoothScrollTo(element, duration) {
            const targetPosition = element.offsetTop;
            const startPosition = document.body.scrollTop;
            const distance = targetPosition - startPosition;
            let startTime = null;
            
            function easeInOutCubic(t) {
                return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
            }
            
            function animation(currentTime) {
                if (startTime === null) startTime = currentTime;
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeProgress = easeInOutCubic(progress);
                
                document.body.scrollTop = startPosition + (distance * easeProgress);
                
                if (elapsed < duration) {
                    requestAnimationFrame(animation);
                } else {
                    isScrolling = false;
                }
            }
            
            requestAnimationFrame(animation);
        }
        
        function scrollToSection(index) {
            if (index < 0 || index >= sections.length || isScrolling) return;
            isScrolling = true;
            currentSection = index;
            smoothScrollTo(sections[index], 800);
        }
        
        // Handle wheel events
        let wheelTimeout;
        document.body.addEventListener('wheel', (e) => {
            e.preventDefault();
            
            if (isScrolling) return;
            
            clearTimeout(wheelTimeout);
            wheelTimeout = setTimeout(() => {
                if (e.deltaY > 0 && currentSection < sections.length - 1) {
                    scrollToSection(currentSection + 1);
                } else if (e.deltaY < 0 && currentSection > 0) {
                    scrollToSection(currentSection - 1);
                }
            }, 50);
        }, { passive: false });
        
        // Handle touch events for mobile
        let touchStartY = 0;
        document.body.addEventListener('touchstart', (e) => {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });
        
        document.body.addEventListener('touchend', (e) => {
            if (isScrolling) return;
            const touchEndY = e.changedTouches[0].clientY;
            const diff = touchStartY - touchEndY;
            
            if (Math.abs(diff) > 50) {
                if (diff > 0 && currentSection < sections.length - 1) {
                    scrollToSection(currentSection + 1);
                } else if (diff < 0 && currentSection > 0) {
                    scrollToSection(currentSection - 1);
                }
            }
        }, { passive: true });
        
        // Handle keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (isScrolling) return;
            if (e.key === 'ArrowDown' || e.key === 'PageDown') {
                e.preventDefault();
                scrollToSection(currentSection + 1);
            } else if (e.key === 'ArrowUp' || e.key === 'PageUp') {
                e.preventDefault();
                scrollToSection(currentSection - 1);
            }
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Little Stars') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        /* --- 1. COLORS --- */
        :root {
            --bg-cream: #FFFCF5;
            --bg-white: #FFFFFF;
            --c-blue: #3F9AAE;
            --c-teal: #79C9C5;
            --c-yellow: #FFE2AF;
            --c-coral: #F96E5B;
            --c-dark: #2D3748;
            
            --border-thick: 3px solid var(--c-dark);
            --shadow-hard: 5px 5px 0px 0px var(--c-dark);
        }

        /* --- 2. RESET --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-cream);
            color: var(--c-dark);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3 { font-family: 'Fredoka', sans-serif; line-height: 1.1; letter-spacing: 0.01em; }
        a { text-decoration: none; color: inherit; transition: all 0.2s; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 2; }

        /* --- 3. WAVE DIVIDERS (FIXED STRATEGY) --- */
        /* We place the wave at the BOTTOM of a section, filled with the color of the NEXT section. */
        .wave-bottom {
            position: absolute;
            bottom: -1px; /* Slight overlap to prevent gaps */
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: 5;
            pointer-events: none;
        }

        .wave-bottom svg {
            position: relative;
            display: block;
            width: calc(100% + 20px); /* Wider than screen to prevent side gaps */
            height: 60px;
            margin-left: -10px;
        }

        /* Transition Fills */
        .fill-blue { fill: var(--c-blue); }   /* Cream -> Blue */
        .fill-cream { fill: var(--bg-cream); } /* Blue -> Cream */
        .fill-dark { fill: var(--c-dark); }    /* Cream -> Footer */

        /* --- 4. COMPONENTS --- */
        .navbar {
            padding: 24px 0; position: sticky; top: 0; z-index: 100;
            background: rgba(255, 252, 245, 0.95); backdrop-filter: blur(12px);
            border-bottom: 2px solid rgba(63, 154, 174, 0.1);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Fredoka', sans-serif; font-size: 1.8rem; font-weight: 700; color: var(--c-blue); display: flex; align-items: center; gap: 8px; transition: transform 0.3s; }
        .logo:hover { transform: rotate(-3deg) scale(1.05); }
        .logo i { color: var(--c-coral); font-size: 2rem; transform: rotate(-10deg); filter: drop-shadow(2px 2px 0px var(--c-yellow)); }
        
        .nav-links { display: flex; gap: 32px; }
        .nav-links a { font-weight: 700; color: #64748b; position: relative; font-size: 1rem; display: inline-block; }
        .nav-links a:hover { color: var(--c-blue); }
        .nav-links a::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0%; height: 4px; background: var(--c-teal); transition: width 0.2s; border-radius: 4px; }
        .nav-links a:hover::after { width: 100%; }
        .nav-actions { display: flex; align-items: center; gap: 16px; }

        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 14px 32px; font-weight: 700; border-radius: 100px; border: var(--border-thick); font-size: 1.05rem; cursor: pointer; transition: all 0.2s; text-transform: uppercase; }
        .btn:hover { transform: translate(-4px, -4px); box-shadow: var(--shadow-hard); }
        .btn:active { transform: translate(0, 0); box-shadow: none; }
        .btn-primary { background-color: var(--c-coral); color: white; }
        .btn-secondary { background-color: var(--c-yellow); color: var(--c-dark); }

        /* --- 5. ANIMATIONS --- */
        .reveal { opacity: 0; transform: translateY(50px) scale(0.95); transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .reveal.active { opacity: 1; transform: translateY(0) scale(1); }
        .stagger-1 { transition-delay: 100ms; }
        .stagger-2 { transition-delay: 200ms; }
        .stagger-3 { transition-delay: 300ms; }
        .stagger-4 { transition-delay: 400ms; }
        @keyframes rubberBand { 0% { transform: scale(1); } 30% { transform: scale(1.25, 0.75); } 40% { transform: scale(0.75, 1.25); } 50% { transform: scale(1.15, 0.85); } 65% { transform: scale(0.95, 1.05); } 75% { transform: scale(1.05, 0.95); } 100% { transform: scale(1); } }
        .click-animate { animation: rubberBand 0.6s; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        /* --- 6. SECTIONS --- */
        .hero-wrapper { position: relative; overflow: hidden; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden; pointer-events: none; }
        .floating-shape { position: absolute; border-radius: 50%; opacity: 0.6; animation: floatShape 8s ease-in-out infinite; }
        .floating-shape.star { background: transparent; opacity: 1; }
        .floating-shape.star::before { content: '★'; font-size: inherit; color: inherit; }
        .floating-shape.bubble { border: 3px solid; background: transparent; }
        .floating-shape.blob { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        .fs-1 { width: 80px; height: 80px; background: var(--c-coral); top: 10%; left: 5%; animation-delay: 0s; animation-duration: 7s; }
        .fs-2 { width: 60px; height: 60px; background: var(--c-teal); top: 60%; left: 8%; animation-delay: 1.5s; animation-duration: 9s; }
        .fs-3 { width: 100px; height: 100px; background: var(--c-yellow); top: 20%; right: 10%; animation-delay: 0.5s; animation-duration: 8s; }
        .fs-4 { width: 50px; height: 50px; background: var(--c-blue); top: 70%; right: 5%; animation-delay: 2s; animation-duration: 6s; }
        .fs-5 { width: 40px; height: 40px; border-color: var(--c-coral); top: 40%; left: 3%; animation-delay: 1s; animation-duration: 10s; }
        .fs-6 { width: 70px; height: 70px; border-color: var(--c-teal); top: 80%; right: 15%; animation-delay: 3s; animation-duration: 7s; }
        .fs-7 { font-size: 2.5rem; color: var(--c-yellow); top: 15%; right: 5%; animation-delay: 0.8s; animation-duration: 5s; }
        .fs-8 { font-size: 1.8rem; color: var(--c-coral); top: 50%; left: 2%; animation-delay: 2.5s; animation-duration: 6s; }
        .fs-9 { font-size: 2rem; color: var(--c-blue); top: 85%; left: 15%; animation-delay: 1.2s; animation-duration: 8s; }
        .fs-10 { width: 90px; height: 90px; background: rgba(249, 110, 91, 0.3); top: 30%; right: 3%; animation-delay: 0.3s; animation-duration: 9s; }
        .fs-11 { width: 55px; height: 55px; background: rgba(121, 201, 197, 0.4); top: 75%; left: 20%; animation-delay: 1.8s; animation-duration: 7s; }
        .fs-12 { width: 45px; height: 45px; border-color: var(--c-blue); top: 25%; left: 12%; animation-delay: 2.2s; animation-duration: 11s; }
        .fs-13 { font-size: 1.5rem; color: var(--c-teal); top: 65%; right: 8%; animation-delay: 0.6s; animation-duration: 6.5s; }
        .fs-14 { width: 35px; height: 35px; background: var(--c-yellow); opacity: 0.5; top: 5%; left: 25%; animation-delay: 3.5s; animation-duration: 8.5s; }
        .fs-15 { width: 65px; height: 65px; background: rgba(63, 154, 174, 0.3); top: 45%; right: 20%; animation-delay: 1.4s; animation-duration: 10s; }
        @keyframes floatShape { 0%, 100% { transform: translateY(0) rotate(0deg) scale(1); } 25% { transform: translateY(-20px) rotate(5deg) scale(1.05); } 50% { transform: translateY(-10px) rotate(-3deg) scale(0.98); } 75% { transform: translateY(-25px) rotate(8deg) scale(1.02); } }
        .hero { padding: 100px 0 100px; text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 1; }
        .hero-badge { background: var(--c-blue); color: white; padding: 10px 24px; border-radius: 50px; font-weight: 700; margin-bottom: 32px; display: inline-flex; gap: 8px; align-items: center; border: var(--border-thick); box-shadow: 4px 4px 0px var(--c-teal); transform: rotate(-2deg); animation: float 3s ease-in-out infinite; }
        .hero-title { font-size: 5rem; margin-bottom: 24px; color: var(--c-dark); }
        .hero-title span { color: var(--c-blue); position: relative; display: inline-block; }
        .hero-title span::after { content: ''; position: absolute; bottom: 10px; left: -5px; right: -5px; height: 12px; background: var(--c-yellow); z-index: -1; transform: skewX(-10deg); opacity: 0.8; }
        .hero-text { font-size: 1.35rem; color: #555; max-width: 650px; margin: 0 auto 48px; line-height: 1.6; font-weight: 500; }
        
        .section { padding: 100px 0; position: relative; }
        .section-title { font-size: 3.5rem; text-align: center; margin-bottom: 60px; color: var(--c-dark); }
        .section-title span { color: var(--c-coral); text-decoration: underline; text-decoration-color: var(--c-teal); text-decoration-thickness: 6px;}

        /* Activities */
        .activities-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; }
        .activity-card { background: white; border: var(--border-thick); border-radius: 28px; padding: 40px 24px; text-align: center; transition: transform 0.3s; display: flex; flex-direction: column; align-items: center; position: relative; overflow: hidden; }
        .activity-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 16px; border-bottom: var(--border-thick); }
        .ac-1::before { background: var(--c-coral); } .ac-2::before { background: var(--c-blue); } .ac-3::before { background: var(--c-teal); } .ac-4::before { background: var(--c-yellow); }
        .activity-card:hover { transform: translateY(-12px); box-shadow: var(--shadow-hard); }
        .icon-circle { width: 90px; height: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin-bottom: 24px; border: var(--border-thick); box-shadow: 4px 4px 0px var(--c-dark); color: white; }
        .ic-1 { background-color: var(--c-coral); } .ic-2 { background-color: var(--c-blue); } .ic-3 { background-color: var(--c-teal); } .ic-4 { background-color: var(--c-yellow); color: var(--c-dark); }

        /* Game Section */
        .game-section { background-color: var(--c-blue); padding: 120px 0; color: white; position: relative; }
        .game-container { max-width: 900px; margin: 0 auto; text-align: center; position: relative; z-index: 2; }
        .game-board { background: white; border: var(--border-thick); border-radius: 28px; height: 450px; position: relative; overflow: hidden; margin-top: 40px; box-shadow: var(--shadow-hard); cursor: crosshair; }
        .game-target { position: absolute; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; font-size: 3rem; cursor: pointer; user-select: none; transition: transform 0.1s; animation: popUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); border: var(--border-thick); border-radius: 50%; box-shadow: 4px 4px 0px var(--c-dark); }
        .game-target:active { transform: scale(0.9); }
        @keyframes popUp { from { transform: scale(0) rotate(-180deg); } to { transform: scale(1) rotate(0deg); } }
        .score-board { font-family: 'Fredoka', sans-serif; font-size: 2.5rem; background: var(--c-yellow); color: var(--c-dark); padding: 12px 40px; border-radius: 50px; border: var(--border-thick); display: inline-block; margin-bottom: 20px; box-shadow: 6px 6px 0px var(--c-dark); transform: rotate(-2deg); }

        /* Reviews */
        .reviews-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        .review-card { background: white; border: var(--border-thick); border-radius: 28px; padding: 32px; position: relative; }
        .review-card::after { content: '“'; position: absolute; top: 10px; right: 20px; font-size: 6rem; color: var(--c-yellow); font-family: serif; opacity: 1; line-height: 0; }
        .reviewer { display: flex; align-items: center; gap: 16px; margin-top: 24px; }
        .avatar { width: 50px; height: 50px; border-radius: 50%; border: var(--border-thick); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; color: white; }

        /* Footer */
        footer { padding: 120px 0 40px; background: var(--c-dark); color: white; position: relative; }
        .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 60px;}
        .footer-col h4 { color: var(--c-yellow); margin-bottom: 24px; font-weight: 800; font-size: 1.2rem; letter-spacing: 0.05em; text-transform: uppercase; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 14px; opacity: 0.8; font-weight: 500; }
        .footer-col ul li:hover { opacity: 1; color: var(--c-teal); cursor: pointer; text-decoration: underline; }
        .footer-logo { font-family: 'Fredoka', sans-serif; font-size: 2rem; color: var(--c-teal); margin-bottom: 20px; display: inline-block;}

        /* Responsive */
        @media (max-width: 1024px) { .activities-grid, .reviews-grid { grid-template-columns: repeat(2, 1fr); } .hero-title { font-size: 4rem; } }
        @media (max-width: 768px) { .nav-links { display: none; } .footer-grid { grid-template-columns: 1fr; gap: 40px; text-align: center; } .hero-title { font-size: 3rem; } .activities-grid, .reviews-grid { grid-template-columns: 1fr; } .hero-btns { flex-direction: column; width: 100%; } .btn { width: 100%; } }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container nav-wrapper">
            <a href="/" class="logo">
                <i class="ri-shining-2-fill"></i> Little Stars
            </a>
            <div class="nav-links">
                <a href="#activities" class="nav-item">Activities</a>
                <a href="#playzone" class="nav-item">Play Zone</a>
                <a href="#reviews" class="nav-item">Reviews</a>
                <a href="#contact" class="nav-item">Contact</a>
            </div>
            <div class="nav-actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" style="margin-right: 8px; font-weight: 800;">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary" style="padding: 10px 24px;">Enroll Now</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <div class="hero-wrapper">
        <!-- Dynamic Floating Background -->
        <div class="hero-bg">
            <!-- Blobs -->
            <div class="floating-shape blob fs-1"></div>
            <div class="floating-shape blob fs-2"></div>
            <div class="floating-shape blob fs-3"></div>
            <div class="floating-shape blob fs-4"></div>
            <div class="floating-shape blob fs-10"></div>
            <div class="floating-shape blob fs-11"></div>
            <div class="floating-shape blob fs-14"></div>
            <div class="floating-shape blob fs-15"></div>
            <!-- Bubbles -->
            <div class="floating-shape bubble fs-5"></div>
            <div class="floating-shape bubble fs-6"></div>
            <div class="floating-shape bubble fs-12"></div>
            <!-- Stars -->
            <div class="floating-shape star fs-7"></div>
            <div class="floating-shape star fs-8"></div>
            <div class="floating-shape star fs-9"></div>
            <div class="floating-shape star fs-13"></div>
        </div>

        <div class="container">
            <section class="hero">
                <div class="hero-badge reveal">
                    <i class="ri-rocket-2-fill"></i> Enrollment Open for 2025!
                </div>
                <h1 class="hero-title reveal stagger-1">
                    Spark Your Child's <br> <span>Imagination!</span>
                </h1>
                <p class="hero-text reveal stagger-2">
                    Welcome to a world of color, creativity, and care. We turn everyday moments into magical learning adventures.
                </p>
                <div class="hero-btns reveal stagger-3">
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 18px 40px; font-size: 1.2rem;">Start The Adventure <i class="ri-arrow-right-line" style="margin-left: 10px;"></i></a>
                    <button class="btn btn-secondary" style="padding: 18px 36px; font-size: 1.2rem;">Virtual Tour</button>
                </div>
            </section>
        </div>
    </div>

    <section class="section" id="activities" style="background-color: var(--bg-cream); padding-top: 0;">
        <div class="container">
            <h2 class="section-title reveal">Fun <span>Activities</span> We Offer</h2>
            <div class="activities-grid">
                <div class="activity-card ac-1 reveal stagger-1">
                    <div class="icon-circle ic-1"><i class="ri-lightbulb-flash-fill"></i></div>
                    <h3>Cognitive Skills</h3>
                    <p style="margin-top: 16px; color: #666; font-weight: 500;">Puzzles, problem-solving games, and learning adventures that build critical thinking.</p>
                </div>
                <div class="activity-card ac-2 reveal stagger-2">
                    <div class="icon-circle ic-2"><i class="ri-run-fill"></i></div>
                    <h3>Motor Skills</h3>
                    <p style="margin-top: 16px; color: #666; font-weight: 500;">Active play, dance, and hands-on activities for coordination and physical development.</p>
                </div>
                <div class="activity-card ac-3 reveal stagger-3">
                    <div class="icon-circle ic-3"><i class="ri-team-fill"></i></div>
                    <h3>Social Skills</h3>
                    <p style="margin-top: 16px; color: #666; font-weight: 500;">Circle time, group projects, and cooperative play to nurture friendships and teamwork.</p>
                </div>
                <div class="activity-card ac-4 reveal stagger-4">
                    <div class="icon-circle ic-4"><i class="ri-heart-pulse-fill"></i></div>
                    <h3>Emotional Growth</h3>
                    <p style="margin-top: 16px; color: #666; font-weight: 500;">Creative expression, storytelling, and mindfulness to develop self-awareness and empathy.</p>
                </div>
            </div>
        </div>

        <div class="wave-bottom">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="fill-blue"></path>
            </svg>
        </div>
    </section>

    <section class="game-section" id="playzone">
        <div class="container game-container">
            <h2 style="font-size: 4rem; margin-bottom: 10px; font-family: 'Fredoka'; text-shadow: 3px 3px 0px rgba(0,0,0,0.1);" class="reveal">Play Zone!</h2>
            <p style="font-size: 1.4rem; margin-bottom: 30px; font-weight: 600;" class="reveal stagger-1">Can you catch the floating toys?</p>
            
            <div class="score-board reveal stagger-2">Score: <span id="score">0</span></div>

            <div class="game-board reveal stagger-3" id="gameBoard">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10;" id="startMsg">
                    <button class="btn btn-secondary" style="font-size: 1.8rem; padding: 24px 48px; box-shadow: 0 10px 20px rgba(0,0,0,0.2);" onclick="startGame()">Start Game ▶</button>
                </div>
            </div>
        </div>

        <div class="wave-bottom">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="fill-cream"></path>
            </svg>
        </div>
    </section>

    <section class="section" id="reviews">
        <div class="container">
            <h2 class="section-title reveal">Happy <span>Parents</span></h2>
            <div class="reviews-grid">
                <div class="review-card reveal stagger-1">
                    <div style="color: var(--c-coral); margin-bottom: 15px; font-size: 1.2rem;">★★★★★</div>
                    <p style="font-size: 1.1rem; line-height: 1.6; font-weight: 600;">"My son loves the Creative Arts program. He brings home masterpieces every week!"</p>
                    <div class="reviewer">
                        <div class="avatar" style="background: var(--c-coral);">S</div>
                        <div><strong>Sarah Jenkins</strong><br><span style="font-size: 0.9rem; opacity: 0.7;">Mom of Noah (4)</span></div>
                    </div>
                </div>
                <div class="review-card reveal stagger-2">
                    <div style="color: var(--c-coral); margin-bottom: 15px; font-size: 1.2rem;">★★★★★</div>
                    <p style="font-size: 1.1rem; line-height: 1.6; font-weight: 600;">"The staff is amazing. I feel so safe leaving my daughter here. The app updates are great."</p>
                    <div class="reviewer">
                        <div class="avatar" style="background: var(--c-blue);">M</div>
                        <div><strong>Mike Ross</strong><br><span style="font-size: 0.9rem; opacity: 0.7;">Dad of Lily (2)</span></div>
                    </div>
                </div>
                <div class="review-card reveal stagger-3">
                    <div style="color: var(--c-coral); margin-bottom: 15px; font-size: 1.2rem;">★★★★★</div>
                    <p style="font-size: 1.1rem; line-height: 1.6; font-weight: 600;">"Finally a daycare that understands active kids! The outdoor play area is huge."</p>
                    <div class="reviewer">
                        <div class="avatar" style="background: var(--c-teal);">J</div>
                        <div><strong>Jessica Lee</strong><br><span style="font-size: 0.9rem; opacity: 0.7;">Mom of Ben (5)</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wave-bottom">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="fill-dark"></path>
            </svg>
        </div>
    </section>

    <footer id="contact">
        <div class="container reveal">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo"><i class="ri-shining-2-fill"></i> Little Stars</div>
                    <p style="line-height: 1.8; opacity: 0.8;">Creating bright futures, one little star at a time.</p>
                </div>
                <div class="footer-col">
                    <h4>Programs</h4>
                    <ul><li>Toddler Play</li><li>Preschool</li><li>Summer Camp</li></ul>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul><li>About Us</li><li>Careers</li><li>Privacy Policy</li></ul>
                </div>
                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <ul>
                        <li><i class="ri-map-pin-line" style="vertical-align: middle; margin-right: 8px;"></i> 123 Sunshine Ave</li>
                        <li><i class="ri-phone-line" style="vertical-align: middle; margin-right: 8px;"></i> (555) 123-4567</li>
                        <li><i class="ri-mail-line" style="vertical-align: middle; margin-right: 8px;"></i> hello@littlestars.com</li>
                    </ul>
                </div>
            </div>
            <div style="text-align: center; border-top: 2px solid rgba(255,255,255,0.1); padding-top: 30px;">
                <p style="opacity: 0.6; font-size: 0.9rem;">&copy; {{ date('Y') }} Little Stars Daycare. Built with joy.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('active');
                });
            }, { root: null, rootMargin: '0px', threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            document.querySelectorAll('.nav-item').forEach(link => {
                link.addEventListener('click', function(e) {
                    this.classList.add('click-animate');
                    setTimeout(() => { this.classList.remove('click-animate'); }, 600);
                });
            });
        });

        let score = 0;
        let gameActive = false;
        const gameBoard = document.getElementById('gameBoard');
        const scoreDisplay = document.getElementById('score');
        const items = ['🎈', '⭐', '🚀', '🎨', '🧸', '🍭', '🍦', '🌞'];

        function startGame() {
            document.getElementById('startMsg').style.display = 'none';
            score = 0;
            scoreDisplay.innerText = score;
            gameActive = true;
            spawnItem();
        }

        function spawnItem() {
            if (!gameActive) return;
            const item = document.createElement('div');
            item.classList.add('game-target');
            item.innerText = items[Math.floor(Math.random() * items.length)];
            const x = Math.random() * (gameBoard.clientWidth - 90);
            const y = Math.random() * (gameBoard.clientHeight - 90);
            item.style.left = `${x}px`;
            item.style.top = `${y}px`;
            const colors = ['#3F9AAE', '#79C9C5', '#FFE2AF', '#F96E5B'];
            item.style.background = colors[Math.floor(Math.random() * colors.length)];
            
            item.onclick = () => {
                score++;
                scoreDisplay.innerText = score;
                item.style.transform = 'scale(1.5) rotate(20deg)';
                item.style.opacity = '0';
                setTimeout(() => item.remove(), 200);
            };
            gameBoard.appendChild(item);
            setTimeout(() => {
                if (item.parentNode) {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.5)';
                    setTimeout(() => { if(item.parentNode) item.remove() }, 300);
                }
            }, 1500);
            let speed = 900;
            if(score > 5) speed = 700;
            if(score > 10) speed = 500;
            setTimeout(spawnItem, speed);
        }
    </script>
</body>
</html>
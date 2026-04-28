<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Movie Hub - Movie Collection</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif;}
:root{--primary:#FF69B4;--dark:#FF1493;--bg:#F5F5F5;--text:#1A1A1A;--light:#FFF;}
header{background:var(--primary);padding:16px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.logo{color:var(--light);font-size:32px;font-weight:900;text-decoration:none;}
.search-bar{flex:1;max-width:480px;margin:0 20px;}
.search-bar input{width:100%;padding:12px 20px;border-radius:24px;border:none;font-size:16px;background:rgba(255,255,255,0.2);color:var(--light);outline:none;}
.search-bar input::placeholder{color:rgba(255,255,255,0.8);}
.header-links{display:flex;gap:24px;align-items:center;}
.header-links a{color:var(--light);text-decoration:none;font-size:16px;font-weight:600;}
.main-nav{background:var(--dark);padding:14px 24px;display:flex;gap:32px;justify-content:center;flex-wrap:wrap;}
.main-nav a{color:var(--light);text-decoration:none;font-size:18px;font-weight:600;transition:opacity 0.2s;}
.main-nav a:hover{opacity:0.8;}
.trending-bar{background:#FF8FBF;padding:10px 24px;display:flex;gap:20px;overflow-x:auto;}
.trending-bar a{color:var(--light);text-decoration:none;font-size:15px;font-weight:600;white-space:nowrap;}
.banner{position:relative;height:420px;background:#000;overflow:hidden;}
.banner-slide{position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;transition:opacity 0.8s;}
.banner-slide.active{opacity:1;}
.banner-slide img{width:100%;height:100%;object-fit:cover;opacity:0.85;}
.banner-text{position:absolute;bottom:60px;left:40px;color:var(--light);max-width:600px;}
.banner-text h2{font-size:28px;margin-bottom:10px;background:rgba(0,0,0,0.6);display:inline-block;padding:6px 12px;border-radius:4px;}
.banner-text p{font-size:18px;line-height:1.5;background:rgba(0,0,0,0.6);display:inline-block;padding:4px 12px;border-radius:4px;}
.banner-nav{position:absolute;top:50%;transform:translateY(-50%);width:100%;display:flex;justify-content:space-between;padding:0 20px;}
.banner-btn{width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,0.9);border:none;font-size:24px;cursor:pointer;display:flex;align-items:center;justify-content:center;}
.banner-dots{position:absolute;bottom:20px;left:50%;transform:translateX(-50%);display:flex;gap:10px;}
.dot{width:12px;height:12px;border-radius:50%;background:rgba(255,255,255,0.5);cursor:pointer;}
.dot.active{background:var(--primary);}
.container{max-width:1400px;margin:0 auto;padding:30px 24px;}
.section-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;padding-bottom:12px;border-bottom:2px solid #eee;}
.section-header h2{font-size:26px;color:var(--text);font-weight:70;}
.view-all{color:var(--primary);text-decoration:none;font-size:16px;font-weight:600;}
.trend-section{margin-bottom:40px;}
.trend-tabs{display:flex;gap:10px;margin-bottom:20px;}
.trend-tab{padding:8px 20px;border-radius:20px;border:none;font-weight:600;cursor:pointer;}
.trend-tab.active{background:#000;color:#fff;}
.trend-tab:not(.active){background:#fff;color:#000;border:1px solid #000;}
.trend-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:20px;overflow-x:auto;padding-bottom:10px;}
.trend-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.1);text-align:center;}
.trend-card img{width:100%;height:225px;object-fit:cover;}
.trend-card .info{padding:10px;}
.trend-card .title{font-size:14px;font-weight:600;margin-bottom:4px;}
.trend-card .date{font-size:12px;color:#666;}
.trailer-section{background:#1A3A5F;color:#fff;padding:30px 24px;margin-bottom:40px;}
.trailer-tabs{display:flex;gap:10px;margin-bottom:20px;}
.trailer-tab{padding:8px 20px;border-radius:20px;border:none;font-weight:600;cursor:pointer;}
.trailer-tab.active{background:#4CAF50;color:#fff;}
.trailer-tab:not(.active){background:transparent;color:#fff;border:1px solid #4CAF50;}
.trailer-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;}
.trailer-card{border-radius:12px;overflow:hidden;position:relative;cursor:pointer;}
.trailer-card img{width:100%;height:160px;object-fit:cover;}
.trailer-card .play-btn{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:50px;height:50px;border-radius:50%;background:rgba(255,255,255,0.8);display:flex;align-items:center;justify-content:center;font-size:20px;color:#000;}
.trailer-card .info{padding:10px;}
.trailer-card .title{font-size:16px;font-weight:600;margin-bottom:4px;}
.trailer-card .desc{font-size:14px;opacity:0.8;}
.join-section{background:#4B1A5F;color:#fff;padding:40px 24px;margin-bottom:40px;}
.join-content{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:30px;}
.join-text h2{font-size:32px;margin-bottom:15px;}
.join-text p{font-size:18px;line-height:1.6;margin-bottom:20px;}
.join-btn{padding:12px 24px;background:#7B42F5;color:#fff;border:none;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;}
.join-benefits{list-style:none;}
.join-benefits li{margin:8px 0;}
.contributor-section{margin-bottom:40px;}
.contributor-header{display:flex;gap:10px;margin-bottom:20px;}
.contributor-legend{display:flex;gap:15px;}
.contributor-legend span{display:flex;align-items:center;gap:5px;}
.contributor-legend span::before{content:'';display:inline-block;width:10px;height:10px;border-radius:50%;}
.contributor-legend .total::before{background:#4CAF50;}
.contributor-legend .week::before{background:#FF6347;}
.contributor-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;}
.contributor-card{background:#fff;padding:15px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.1);}
.contributor-top{display:flex;align-items:center;gap:10px;margin-bottom:10px;}
.contributor-avatar{width:40px;height:40px;border-radius:50%;background:#ddd;display:flex;align-items:center;justify-content:center;font-weight:bold;}
.contributor-name{font-weight:600;}
.contributor-bar{height:8px;border-radius:4px;background:#eee;overflow:hidden;}
.contributor-bar .green{height:100%;background:#4CAF50;width:70%;}
.contributor-bar .red{height:100%;background:#FF6347;width:30%;}
.movies-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:24px;}
.movie-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.1);transition:0.3s;cursor:pointer;}
.movie-card:hover{transform:translateY(-6px);box-shadow:0 8px 20px rgba(0,0,0,0.15);}
.movie-card img{width:100%;height:270px;object-fit:cover;}
.movie-info{padding:14px;}
.movie-title{font-size:16px;font-weight:700;color:var(--text);margin-bottom:6px;line-height:1.3;}
.movie-desc{font-size:14px;color:#666;line-height:1.4;}
.quick-access{background:var(--bg);padding:40px 24px;text-align:center;}
.quick-access h2{font-size:28px;color:var(--text);margin-bottom:24px;}
.btn-group{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;}
.action-btn{padding:14px 28px;background:var(--primary);color:var(--light);text-decoration:none;border-radius:24px;font-size:16px;font-weight:600;transition:background 0.3s;}
.action-btn:hover{background:var(--dark);}

.video-modal{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);display:flex;align-items:center;justify-content:center;z-index:9999;display:none;}
.video-modal video{max-width:90%;max-height:90%;outline:none;}
.video-modal .close{position:absolute;top:20px;right:30px;color:#fff;font-size:30px;cursor:pointer;}

@media(max-width:768px){
.banner{height:320px;}
.banner-text{left:20px;bottom:30px;}
.banner-text h2{font-size:22px;}
.banner-text p{font-size:15px;}
.trend-grid{grid-template-columns:repeat(auto-fill,minmax(120px,1fr));}
.trailer-grid{grid-template-columns:repeat(auto-fill,minmax(200px,1fr));}
.movies-grid{grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:16px;}
.movie-card img{height:210px;}
}
</style>
</head>
<body>

<header>
    <a href="index.php" class="logo">Movie Hub</a>
    <div class="search-bar"><input type="text" placeholder="Search movies, TV shows, and more..."></div>
    <div class="header-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span style="color:white; font-weight:600;">👤 <?= $_SESSION['username'] ?? 'User' ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="pages/login.html">LOGIN/SIGNUP</a>
        <?php endif; ?>
    </div>
</header>

<nav class="main-nav">
    <a href="index.php">HOME</a>
    <a href="pages/movie-list.html">MOVIES</a>
    <a href="pages/news.html">NEWS</a>
    <a href="pages/star.html">STARS</a>
</nav>

<div class="trending-bar">
    <a href="#">TRENDING ON MOVIE HUB</a>
    <a href="#">New Releases 2026</a>
    <a href="#">Upcoming Blockbusters</a>
    <a href="#">Top Rated Films</a>
</div>

<div class="banner">
  <div class="banner-slide active">
    <img src="images/唐探3 1602207730_772087.jpg">
    <div class="banner-text">
      <h2>Welcome to Movie Hub</h2>
      <p>Your ultimate destination to explore movies, shows and endless entertainment.</p>
    </div>
  </div>

  <div class="banner-slide">
    <img src="images/哥斯拉大战2 t019bd39f260de77968.jpg">
    <div class="banner-text">
      <h2>Discover Amazing Stories</h2>
      <p>Find your favorite films, track releases, and enjoy a world of cinema.</p>
    </div>
  </div>

  <div class="banner-slide">
    <img src="images/芭比.jpg">
    <div class="banner-text">
      <h2>Join Our Community</h2>
      <p>Create your own lists, share reviews, and stay connected with movies.</p>
    </div>
  </div>

    <div class="banner-nav">
        <button class="banner-btn" id="prevBtn">&lt;</button>
        <button class="banner-btn" id="nextBtn">&gt;</button>
    </div>
    <div class="banner-dots">
        <span class="dot" data-index="0"></span>
        <span class="dot" data-index="1"></span>
        <span class="dot" data-index="2"></span>
    </div>
</div>

<div class="container">
    <div class="trend-section">
        <h2 class="section-header">Trending</h2>
        <div class="trend-tabs">
            <button class="trend-tab active" onclick="showToday()">Today</button>
            <button class="trend-tab" onclick="showWeek()">This Week</button>
        </div>

        <div class="trend-grid" id="todayMovies">
            <a href="movie_detail.php?id=10" style="text-decoration:none;color:inherit">
            <div class="trend-card">
                <img src="images/抖擞.jpg">
                <div class="info">
                    <div class="title">Next Goal Wins</div>
                    <div class="date">Apr 15, 2026</div>
                </div>
            </div>
            </a>

            <a href="movie_detail.php?id=11" style="text-decoration:none;color:inherit">
            <div class="trend-card">
                <img src="images/怒呛人生p2890296057.jpg">
                <div class="info">
                    <div class="title">Beef</div>
                    <div class="date">Apr 06, 2023</div>
                </div>
            </div>
            </a>

            <a href="movie_detail.php?id=12" style="text-decoration:none;color:inherit">
            <div class="trend-card">
                <img src="images/黑豹纠察队.jpg">
                <div class="info">
                    <div class="title">The Boys</div>
                    <div class="date">Jul 25, 2019</div>
                </div>
            </div>
            </a>

            <a href="movie_detail.php?id=13" style="text-decoration:none;color:inherit">
            <div class="trend-card">
                <img src="images/巅峰对决.jpg">
                <div class="info">
                    <div class="title">Heated Rivalry</div>
                    <div class="date">Nov 28, 2025</div>
                </div>
            </div>
            </a>
        </div>

        <div class="trend-grid" id="weekMovies" style="display:none;">
            <a href="movie_detail.php?id=14" style="text-decoration:none;color:inherit">
            <div class="trend-card">
                <img src="images/安昂传奇：最后的气宗.jpg">
                <div class="info">
                    <div class="title">Avatar: The Last Airbender</div>
                    <div class="date">Oct 09, 2026</div>
                </div>
            </div>
            </a>

            <a href="movie_detail.php?id=15" style="text-decoration:none;color:inherit">
            <div class="trend-card">
                <img src="images/木乃伊.jpg">
                <div class="info">
                    <div class="title">The Mummy</div>
                    <div class="date">Apr 07, 2026</div>
                </div>
            </div>
            </a>

            <a href="movie_detail.php?id=16" style="text-decoration:none;color:inherit">
            <div class="trend-card">
                <img src="images/亢奋.jpg">
                <div class="info">
                    <div class="title">Euphoria</div>
                    <div class="date">Jun 16, 2019</div>
                </div>
            </div>
            </a>
        </div>
    </div>

<section class="new-releases" style="margin:40px 0;">
  <div class="section-header" style="padding:0 24px;">
    <h2>New Releases</h2>
    <a href="#" class="view-all">VIEW ALL</a>
  </div>

  <div class="movies-grid" style="padding:0 24px;">
    
    <a href="movie_detail.php?id=20" style="text-decoration:none;color:inherit">
    <div class="movie-card">
      <img src="images/黄蜂4.jpg" alt="Wasp 4">
      <div class="movie-info">
        <div class="movie-title">Wasp 4</div>
        <div class="movie-desc">A high-stakes action thriller featuring the iconic Wasp in her most dangerous mission yet, filled with intense battles and shocking twists.</div>
      </div>
    </div>
    </a>

    <a href="movie_detail.php?id=21" style="text-decoration:none;color:inherit">
    <div class="movie-card">
      <img src="images/头号外交官4.jpg" alt="Top Diplomat">
      <div class="movie-info">
        <div class="movie-title">Top Diplomat</div>
        <div class="movie-desc">A gripping political drama about a seasoned ambassador navigating complex global conflicts and high-stakes negotiations.</div>
      </div>
    </div>
    </a>

    <a href="movie_detail.php?id=22" style="text-decoration:none;color:inherit">
    <div class="movie-card">
      <img src="images/暗影蜘蛛侠.jpg" alt="Shadow Spider">
      <div class="movie-info">
        <div class="movie-title">Shadow Spider</div>
        <div class="movie-desc">A dark and gritty superhero story following a vigilante spider who fights crime in the shadows of a corrupted city.</div>
      </div>
    </div>
    </a>

    <a href="movie_detail.php?id=23" style="text-decoration:none;color:inherit">
    <div class="movie-card">
      <img src="images/消失之人 Vanished.jpg" alt="The Vanished">
      <div class="movie-info">
        <div class="movie-title">The Vanished</div>
        <div class="movie-desc">A mysterious thriller about a detective searching for a missing person, uncovering dark secrets and a web of lies along the way.</div>
      </div>
    </div>
    </a>

    <a href="movie_detail.php?id=24" style="text-decoration:none;color:inherit">
    <div class="movie-card">
      <img src="images/猪猪侠大电影之竞速小英雄.jpg" alt="GG Bond: Racing Heroes">
      <div class="movie-info">
        <div class="movie-title">GG Bond: Racing Heroes</div>
        <div class="movie-desc">An animated adventure comedy featuring GG Bond and his friends as they compete in an international racing championship.</div>
      </div>
    </div>
    </a>

    <a href="movie_detail.php?id=25" style="text-decoration:none;color:inherit">
    <div class="movie-card">
      <img src="images/穿普拉达的女王2.jpg" alt="The Devil Wears Prada 2">
      <div class="movie-info">
        <div class="movie-title">The Devil Wears Prada 2</div>
        <div class="movie-desc">A glamorous fashion drama sequel following the lives of ambitious journalists and the cutthroat world of high-end fashion.</div>
      </div>
    </div>
    </a>

  </div>
</section>

    <div class="section-header">
        <h2>Movies in Theaters</h2>
        <a href="pages/movie-list.html" class="view-all">VIEW ALL</a>
    </div>
    <div class="movies-grid">
        <a href="movie_detail.php?id=1" style="text-decoration:none;color:inherit">
        <div class="movie-card">
            <img src="images/唐探3 1602207730_772087.jpg">
            <div class="movie-info">
                <div class="movie-title">Detective Chinatown 3</div>
                <div class="movie-desc">Qin Feng and Tang Ren head to Tokyo to solve a bizarre murder case.</div>
            </div>
        </div>
        </a>

        <a href="movie_detail.php?id=2" style="text-decoration:none;color:inherit">
        <div class="movie-card">
            <img src="images/哥斯拉大战2 t019bd39f260de77968.jpg">
            <div class="movie-info">
                <div class="movie-title">Godzilla x Kong: The New Empire</div>
                <div class="movie-desc">Monsters unite to face a new ancient threat in the MonsterVerse.</div>
            </div>
        </div>
        </a>

        <a href="movie_detail.php?id=3" style="text-decoration:none;color:inherit">
        <div class="movie-card">
            <img src="images/芭比.jpg">
            <div class="movie-info">
                <div class="movie-title">Barbie</div>
                <div class="movie-desc">Barbie and Ken journey to the real world in this vibrant comedy.</div>
            </div>
        </div>
        </a>


        <a href="movie_detail.php?id=4" style="text-decoration:none;color:inherit">
        <div class="movie-card">
            <img src="images/沙丘2.jpg">
            <div class="movie-info">
                <div class="movie-title">Dune: Part Two</div>
                <div class="movie-desc">Paul Atreides joins forces with the Fremen to wage war against those who destroyed his family.</div>
            </div>
        </div>
        </a>

        <a href="movie_detail.php?id=5" style="text-decoration:none;color:inherit">
        <div class="movie-card">
            <img src="images/死侍与金刚狼.jpg">
            <div class="movie-info">
                <div class="movie-title">Deadpool & Wolverine</div>
                <div class="movie-desc">R-rated Marvel team-up with time-travel chaos and mutant action.</div>
            </div>
        </div>
        </a>

        <a href="movie_detail.php?id=6" style="text-decoration:none;color:inherit">
        <div class="movie-card">
            <img src="images/头脑特工队2.jpg">
            <div class="movie-info">
                <div class="movie-title">Inside Out 2</div>
                <div class="movie-desc">Riley's emotions face new challenges as Anxiety arrives in her mind.</div>
            </div>
        </div>
        </a>
    </div>
</div>


<div class="trailer-section">
    <h2 style="margin-bottom:15px;">Latest Trailers</h2>
    <div class="trailer-tabs">
        <button class="trailer-tab active">Popular</button>
        <button class="trailer-tab">In Theaters</button>
    </div>
    <div class="trailer-grid">
        <a href="movie_detail.php?id=30" style="text-decoration:none;color:inherit">
        <div class="trailer-card" onclick="openVideo('video/petal_20260417_110445.mp4')">
            <img src="images/曼达洛人与古古.jpg">
            <div class="play-btn">▶</div>
            <div class="info">
                <div class="title">The Mandalorian & Grogu</div>
                <div class="desc">A bounty hunter and his companion's new adventure.</div>
            </div>
        </div>
        </a>

        <a href="movie_detail.php?id=31" style="text-decoration:none;color:inherit">
        <div class="trailer-card">
            <img src="images/反叛 .jpg">
            <div class="play-btn">▶</div>
            <div class="info">
                <div class="title">Rebel</div>
                <div class="desc">No hesitation, no mercy.</div>
            </div>
        </div>
        </a>

        <a href="movie_detail.php?id=32" style="text-decoration:none;color:inherit">
        <div class="trailer-card">
            <img src="images/真人快打2.jpg">
            <div class="play-btn">▶</div>
            <div class="info">
                <div class="title">Tekken 2</div>
                <div class="desc">Fight to become the King of Iron Fist.</div>
            </div>
        </div>
        </a>

        <a href="movie_detail.php?id=33" style="text-decoration:none;color:inherit">
        <div class="trailer-card">
            <img src="images/奇迹少女.jpg">
            <div class="play-btn">▶</div>
            <div class="info">
                <div class="title">Miraculous Ladybug</div>
                <div class="desc">Rising to protect Paris from villains.</div>
            </div>
        </div>
        </a>
    </div>
</div>

<div class="join-section">
    <div class="join-content">
        <div class="join-text">
            <h2>Join Now</h2>
            <p>Get access to maintain your own custom personal lists, track what you've seen and search and filter for what to watch next—regardless if it's in theatres or on TV.</p>
            <button class="join-btn">Register</button>
        </div>
        <ul class="join-benefits">
            <li>• Maintain personal watchlists</li>
            <li>• Filter content by your subscribed streaming services</li>
            <li>• Log movies and shows you've watched</li>
            <li>• Create personalized lists</li>
            <li>• Help improve our database</li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="contributor-section">
        <h2 class="section-header">Contributor Board</h2>
        <div class="contributor-header">
            <div class="contributor-legend">
                <span class="total">Total Edits</span>
                <span class="week">Weekly Edits</span>
            </div>
        </div>
        <div class="contributor-grid">
            <div class="contributor-card">
                <div class="contributor-top">
                    <div class="contributor-avatar">R</div>
                    <div class="contributor-name">RuiZafon</div>
                </div>
                <div class="contributor-bar">
                    <div class="green" style="width:70%"></div>
                    <div class="red" style="width:30%"></div>
                </div>
            </div>
            <div class="contributor-card">
                <div class="contributor-top">
                    <div class="contributor-avatar">E</div>
                    <div class="contributor-name">enterpr1se</div>
                </div>
                <div class="contributor-bar">
                    <div class="green" style="width:80%"></div>
                    <div class="red" style="width:20%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="quick-access">
    <h2>Quick Access</h2>
    <div class="btn-group">
        <a href="pages/login.html" class="action-btn">Login</a>
        <a href="pages/register.html" class="action-btn">Register</a>
        <a href="pages/movie-list.html" class="action-btn">My Movies</a>
        <a href="pages/profile.html" class="action-btn">Profile</a>
    </div>
</div>

<div class="video-modal" id="videoModal">
    <span class="close" onclick="closeVideo()">×</span>
    <video id="mainVideo" controls></video>
</div>

<script>
const slides = document.querySelectorAll('.banner-slide');
const dots = document.querySelectorAll('.dot');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
let current = 0;

function show(i){
    slides.forEach(s=>s.classList.remove('active'));
    dots.forEach(d=>d.classList.remove('active'));
    slides[i].classList.add('active');
    dots[i].classList.add('active');
    current = i;
}

prevBtn.onclick=()=>show((current-1+slides.length)%slides.length);
nextBtn.onclick=()=>show((current+1)%slides.length);
dots.forEach((d,i)=>d.onclick=()=>show(i));
setInterval(()=>show((current+1)%slides.length),5000);

function showToday(){
    document.getElementById('todayMovies').style.display = 'grid';
    document.getElementById('weekMovies').style.display = 'none';
    document.querySelectorAll('.trend-tab')[0].classList.add('active');
    document.querySelectorAll('.trend-tab')[1].classList.remove('active');
}
function showWeek(){
    document.getElementById('todayMovies').style.display = 'none';
    document.getElementById('weekMovies').style.display = 'grid';
    document.querySelectorAll('.trend-tab')[1].classList.add('active');
    document.querySelectorAll('.trend-tab')[0].classList.remove('active');
}

const trailerTabs = document.querySelectorAll('.trailer-tab');
trailerTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        trailerTabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    });
});

function openVideo(src){
    document.getElementById('mainVideo').src=src;
    document.getElementById('videoModal').style.display='flex';
}
function closeVideo(){
    let v=document.getElementById('mainVideo');
    v.pause();
    v.src='';
    document.getElementById('videoModal').style.display='none';
}
</script>
</body>
</html>
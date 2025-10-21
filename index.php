<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$name = $_SESSION['name'] ?? 'User';
$role = strtolower($_SESSION['role'] ?? 'user');
$isAdmin = ($role === 'admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduPath</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    html {
      scroll-behavior: smooth;
    }
    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 0.5rem;
      min-width: 200px;
      z-index: 50;
      opacity: 0;
      transform: translateY(-4px);
      transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
    }
    .dropdown-menu.active {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-4px); }
      to { opacity: 1; transform: translateY(0); }
    }
    #mobile-nav {
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }
    #mobile-nav.open {
      max-height: 600px;
      opacity: 1;
    }
    @media (max-width: 767px) {
      .dropdown-menu {
        position: static;
        min-width: auto;
        background-color: transparent;
        border: none;
        backdrop-filter: none;
        border-radius: 0;
        opacity: 1;
        transform: none;
        transition: none;
        display: none;
      }
      .dropdown-menu.active {
        display: block;
      }
      .mobile-submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
      }
      .mobile-submenu.active {
        max-height: 200px;
      }
    }
    .feature-card {
      transition: all 0.3s ease-in-out;
    }
    .feature-card:hover {
      transform: translateY(-4px);
    }
  </style>
</head>
<body class="min-h-screen bg-slate-900 text-white">

 <!-- Header -->
  <header class="bg-gradient-to-r from-blue-900 via-purple-900 to-indigo-900 shadow-2xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3">
      <div class="flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
          <i data-lucide="brain" class="h-7 w-7 text-cyan-400 transition-transform hover:scale-110"></i>
          <span class="text-xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 gradient-text">EduPath</span>
        </div>

        <!-- Mobile menu button -->
        <button id="mobile-menu-btn" class="md:hidden flex items-center p-2 hover:bg-white/10 rounded transition-all duration-300">
          <i data-lucide="menu" class="h-6 w-6 transition-transform"></i>
        </button>

        <!-- Navigation (desktop) -->
        <nav class="hidden md:flex items-center space-x-6 text-sm relative">
          <a href="#" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out">
            <i data-lucide="home" class="h-4 w-4 mr-1 transition-transform"></i> Home
          </a>
          <a href="<?php echo $isLoggedIn ? 'about.php' : 'javascript:redirectToLogin()'; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out">
            <i data-lucide="users" class="h-4 w-4 mr-1 transition-transform"></i> About
          </a>

          <!-- Calendar dropdown -->
          <div class="relative">
            <button onclick="<?php echo $isLoggedIn ? "toggleDropdown('calendar-menu')" : "redirectToLogin()"; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out">
              <i data-lucide="calendar" class="h-4 w-4 mr-1 transition-transform"></i> Calendar
              <i data-lucide="chevron-down" class="h-4 w-4 ml-1 transition-transform"></i>
            </button>
            <div id="calendar-menu" class="dropdown-menu mt-2 text-gray-300 text-sm">
              <a href="<?php echo $isLoggedIn ? 'news.php' : 'javascript:redirectToLogin()'; ?>" class="block px-4 py-2 hover:bg-white/10 transition-all duration-200">Announcements / News</a>
              <a href="<?php echo $isLoggedIn ? 'calendar.php' : 'javascript:redirectToLogin()'; ?>" class="block px-4 py-2 hover:bg-white/10 transition-all duration-200">Events</a>
              <a href="<?php echo $isLoggedIn ? 'programs.php' : 'javascript:redirectToLogin()'; ?>" class="block px-4 py-2 hover:bg-white/10 transition-all duration-200">Academic Programs</a>
            </div>
          </div>

          <!-- Contact dropdown -->
          <div class="relative">
            <button onclick="<?php echo $isLoggedIn ? "toggleDropdown('contact-menu')" : "redirectToLogin()"; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out">
              <i data-lucide="phone" class="h-4 w-4 mr-1 transition-transform"></i> Contact
              <i data-lucide="chevron-down" class="h-4 w-4 ml-1 transition-transform"></i>
            </button>
            <div id="contact-menu" class="dropdown-menu mt-2 text-gray-300 text-sm">
              <a href="<?php echo $isLoggedIn ? 'contact.php' : 'javascript:redirectToLogin()'; ?>" class="block px-4 py-2 hover:bg-white/10 transition-all duration-200">Contact Us</a>
              <a href="<?php echo $isLoggedIn ? 'staff.php' : 'javascript:redirectToLogin()'; ?>" class="block px-4 py-2 hover:bg-white/10 transition-all duration-200">Staff Directory</a>
            </div>
          </div>

          <a href="<?php echo $isLoggedIn ? 'gallery.php' : 'javascript:redirectToLogin()'; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out">
            <i data-lucide="camera" class="h-4 w-4 mr-1 transition-transform"></i> Gallery
          </a>

          <a href="<?php echo $isLoggedIn ? 'ai.php' : 'javascript:redirectToLogin()'; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out">
            <i data-lucide="brain-circuit" class="h-4 w-4 mr-1 transition-transform"></i> AI Tools
          </a>

          <a href="<?php echo $isLoggedIn ? 'portal.php' : 'javascript:redirectToLogin()'; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out">
            <i data-lucide="user-square-2" class="h-4 w-4 mr-1 transition-transform"></i> User Portal
          </a>
        </nav>

        <!-- Profile Dropdown -->
        <div class="relative">
          <?php if ($isLoggedIn): ?>
            <button onclick="toggleDropdown('profile-menu')" class="flex items-center bg-white/10 border border-white/20 px-3 py-2 rounded-lg hover:bg-white/20 transition-all duration-300 ease-in-out">
              <i data-lucide="user" class="h-4 w-4 mr-2 transition-transform"></i>
              <span class="hidden sm:inline"><?php echo htmlspecialchars($name); ?></span>
              <i data-lucide="chevron-down" class="h-4 w-4 ml-1 transition-transform"></i>
            </button>
            <div id="profile-menu" class="dropdown-menu right-0 mt-2 text-gray-300 text-sm">
              <a href="profile.php" class="block px-4 py-2 hover:bg-white/10 rounded-t-lg transition-all duration-200">Profile</a>
              <?php if ($isAdmin): ?>
                <a href="admin_panel.php" class="block px-4 py-2 hover:bg-white/10 transition-all duration-200">Admin Panel</a>
              <?php endif; ?>
              <a href="logout.php" class="block px-4 py-2 hover:bg-white/10 rounded-b-lg text-red-400 transition-all duration-200">Logout</a>
            </div>
          <?php else: ?>
            <a href="login.php" class="flex items-center bg-cyan-500 border border-cyan-400 px-4 py-2 rounded-lg hover:bg-cyan-600 transition-all duration-300 ease-in-out font-semibold">
              <i data-lucide="log-in" class="h-4 w-4 mr-2 transition-transform"></i>
              Login
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Mobile Navigation -->
      <div id="mobile-nav" class="md:hidden bg-slate-900 border-t border-white/10 w-full">
        <nav class="px-4 py-4 space-y-4 text-sm">
          <a href="#" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out py-2">
            <i data-lucide="home" class="h-4 w-4 mr-2 transition-transform"></i> Home
          </a>
          <a href="<?php echo $isLoggedIn ? 'about.php' : 'javascript:redirectToLogin()'; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out py-2">
            <i data-lucide="users" class="h-4 w-4 mr-2 transition-transform"></i> About
          </a>

          <!-- Mobile Calendar -->
          <div class="relative">
            <button onclick="<?php echo $isLoggedIn ? "toggleMobileDropdown('mobile-calendar-menu')" : "redirectToLogin()"; ?>" class="flex items-center w-full text-left hover:text-cyan-400 transition-all duration-300 ease-in-out py-2">
              <i data-lucide="calendar" class="h-4 w-4 mr-2 transition-transform"></i> Calendar
              <i data-lucide="chevron-down" class="h-4 w-4 ml-auto transition-transform"></i>
            </button>
            <div id="mobile-calendar-menu" class="mobile-submenu pl-4 space-y-1">
              <a href="<?php echo $isLoggedIn ? 'news.php' : 'javascript:redirectToLogin()'; ?>" class="block py-2 hover:bg-white/10 transition-all duration-200 pl-4">Announcements / News</a>
              <a href="<?php echo $isLoggedIn ? 'calendar.php' : 'javascript:redirectToLogin()'; ?>" class="block py-2 hover:bg-white/10 transition-all duration-200 pl-4">Events</a>
              <a href="<?php echo $isLoggedIn ? 'programs.php' : 'javascript:redirectToLogin()'; ?>" class="block py-2 hover:bg-white/10 transition-all duration-200 pl-4">Academic Programs</a>
            </div>
          </div>

          <!-- Mobile Contact -->
          <div class="relative">
            <button onclick="<?php echo $isLoggedIn ? "toggleMobileDropdown('mobile-contact-menu')" : "redirectToLogin()"; ?>" class="flex items-center w-full text-left hover:text-cyan-400 transition-all duration-300 ease-in-out py-2">
              <i data-lucide="phone" class="h-4 w-4 mr-2 transition-transform"></i> Contact
              <i data-lucide="chevron-down" class="h-4 w-4 ml-auto transition-transform"></i>
            </button>
            <div id="mobile-contact-menu" class="mobile-submenu pl-4 space-y-1">
              <a href="<?php echo $isLoggedIn ? 'contact.php' : 'javascript:redirectToLogin()'; ?>" class="block py-2 hover:bg-white/10 transition-all duration-200 pl-4">Contact Us</a>
              <a href="<?php echo $isLoggedIn ? 'staff.php' : 'javascript:redirectToLogin()'; ?>" class="block py-2 hover:bg-white/10 transition-all duration-200 pl-4">Staff Directory</a>
            </div>
          </div>

          <a href="<?php echo $isLoggedIn ? 'gallery.php' : 'javascript:redirectToLogin()'; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out py-2">
            <i data-lucide="camera" class="h-4 w-4 mr-2 transition-transform"></i> Gallery
          </a>

          <a href="<?php echo $isLoggedIn ? 'ai.php' : 'javascript:redirectToLogin()'; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out py-2">
            <i data-lucide="brain-circuit" class="h-4 w-4 mr-2 transition-transform"></i> AI Tools
          </a>

          <a href="<?php echo $isLoggedIn ? 'portal.php' : 'javascript:redirectToLogin()'; ?>" class="flex items-center hover:text-cyan-400 transition-all duration-300 ease-in-out py-2">
            <i data-lucide="user-square-2" class="h-4 w-4 mr-2 transition-transform"></i> My Portal
          </a>
        </nav>
      </div>
    </div>
  </header>


<!-- 🔹 Landing Content -->
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
  <div class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/20 to-purple-500/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
      <h1 class="text-5xl md:text-7xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 gradient-text mb-6 animate-fade-in">
        Welcome to EduPath
      </h1>
      <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto animate-fade-in animation-delay-300">
        Empowering students with AI-driven career exploration and intelligent study tools
      </p>

     <!-- Top two rounded cards -->
<div class="flex flex-col md:flex-row gap-6 justify-center items-center mb-16">
  <!-- Career Explorer Card -->
  <button 
    onclick="handleFeatureClick('career_explorer.php')"
    class="feature-card bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 ease-in-out group max-w-sm w-full animate-fade-in animation-delay-600">
    <div class="text-cyan-400 mb-4 group-hover:scale-110 transition-all duration-300 ease-in-out">
      <i data-lucide="target" class="h-12 w-12 mx-auto transition-transform duration-300"></i>
    </div>
    <h3 class="text-xl font-bold text-white mb-2">High School</h3>
    <p class="text-gray-300">I want to Explore A Career.</p>
  </button>

  <!-- Quiz Generator Card -->
  <button 
    onclick="handleFeatureClick('quiz_generator.php')"
    class="feature-card bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 ease-in-out group max-w-sm w-full animate-fade-in animation-delay-900">
    <div class="text-purple-400 mb-4 group-hover:scale-110 transition-all duration-300 ease-in-out">
      <i data-lucide="brain" class="h-12 w-12 mx-auto transition-transform duration-300"></i>
    </div>
    <h3 class="text-xl font-bold text-white mb-2">University</h3>
    <p class="text-gray-300">AI-generated quizzes from my study notes</p>
  </button>
</div>


  <!-- Bottom three feature cards -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid md:grid-cols-3 gap-8">
      <div onclick="handleFeatureClick('career_discovery.php')" class="feature-card bg-gradient-to-br from-cyan-500/20 to-blue-500/20 p-6 rounded-xl border border-cyan-500/30 hover:bg-cyan-500/30 transition-all duration-300 ease-in-out cursor-pointer animate-fade-in animation-delay-1200">
        <i data-lucide="search" class="h-8 w-8 text-cyan-400 mb-4 transition-transform duration-300 hover:scale-110"></i>
        <h3 class="text-xl font-bold text-white mb-2">Career Discovery</h3>
        <p class="text-gray-300">Explore careers based on your interests and skills with AI recommendations</p>
      </div>
      <div onclick="handleFeatureClick('quiz_generator.php')" class="feature-card bg-gradient-to-br from-purple-500/20 to-pink-500/20 p-6 rounded-xl border border-purple-500/30 hover:bg-purple-500/30 transition-all duration-300 ease-in-out cursor-pointer animate-fade-in animation-delay-1500">
        <i data-lucide="file-text" class="h-8 w-8 text-purple-400 mb-4 transition-transform duration-300 hover:scale-110"></i>
        <h3 class="text-xl font-bold text-white mb-2">Smart Quizzes</h3>
        <p class="text-gray-300">Upload notes and get AI-generated quizzes to test your knowledge</p>
      </div>
      <div onclick="handleFeatureClick('progress_tracking.php')" class="feature-card bg-gradient-to-br from-green-500/20 to-emerald-500/20 p-6 rounded-xl border border-green-500/30 hover:bg-green-500/30 transition-all duration-300 ease-in-out cursor-pointer animate-fade-in animation-delay-1800">
        <i data-lucide="trending-up" class="h-8 w-8 text-green-400 mb-4 transition-transform duration-300 hover:scale-110"></i>
        <h3 class="text-xl font-bold text-white mb-2">Progress Tracking</h3>
        <p class="text-gray-300">Monitor your learning journey and career exploration progress</p>
      </div>
    </div>
  </div>
</div>

<!-- 🔹 Footer -->
<footer class="bg-black/40 border-t border-white/10 py-6 text-center text-gray-400">
  © <?php echo date("Y"); ?> EduPath. All Rights Reserved.
</footer>

 <script>
    lucide.createIcons();

    // Redirect to login if not logged in
    function redirectToLogin() {
      window.location.href = 'login.php';
    }

    // Handle feature card clicks
    function handleFeatureClick(page) {
      <?php if (!$isLoggedIn): ?>
        redirectToLogin();
      <?php else: ?>
        window.location.href = page;
      <?php endif; ?>
    }

    // Toggle desktop dropdowns
    function toggleDropdown(id) {
      document.querySelectorAll('.dropdown-menu').forEach(menu => {
        if (menu.id === id) {
          menu.classList.toggle('active');
        } else {
          menu.classList.remove('active');
        }
      });
    }

    // Toggle mobile submenus
    function toggleMobileDropdown(id) {
      const menu = document.getElementById(id);
      if (menu) {
        menu.classList.toggle('active');
      }
      // Close other mobile submenus
      document.querySelectorAll('.mobile-submenu').forEach(m => {
        if (m.id !== id) m.classList.remove('active');
      });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', e => {
      if (!e.target.closest('button') && !e.target.closest('.dropdown-menu') && !e.target.closest('.mobile-submenu')) {
        document.querySelectorAll('.dropdown-menu, .mobile-submenu').forEach(menu => menu.classList.remove('active'));
      }
    });

    // Mobile menu toggle
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileNav = document.getElementById('mobile-nav');

    if (mobileBtn && mobileNav) {
      mobileBtn.addEventListener('click', () => {
        mobileNav.classList.toggle('open');
        const icon = mobileBtn.querySelector('i');
        icon.setAttribute('data-lucide', mobileNav.classList.contains('open') ? 'x' : 'menu');
        lucide.createIcons();
      });
    }

    // Simple fade-in animation on load
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, observerOptions);

    document.querySelectorAll('.animate-fade-in').forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
      observer.observe(el);
    });
  </script>

</body>
</html>
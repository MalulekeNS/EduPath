<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About – EduPath</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }
    body { opacity: 0; transition: opacity .3s ease; }
    body.fade-in { opacity: 1; }
    body.fade-out { opacity: 0; }
  </style>
</head>

<body class="min-h-screen bg-slate-900 text-white">

  <!-- ✅ Updated Header (Structure Only, Colors Kept) -->
  <header class="bg-gradient-to-r from-blue-900 via-purple-900 to-indigo-900 shadow-2xl sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
      <!-- Brain Icon -->
      <div class="flex items-center space-x-2">
        <i data-lucide="brain" class="h-7 w-7 text-cyan-400"></i>
        <span class="text-xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 gradient-text">EduPath</span>
      </div>

      <!-- Back + Home Buttons -->
      <div class="flex space-x-2">
        <button onclick="history.back()" 
          class="px-3 py-2 bg-white/10 border border-white/20 rounded-lg hover:bg-white/20 transition flex items-center space-x-1">
          <i data-lucide='arrow-left' class='h-4 w-4'></i><span>Back</span>
        </button>
        <button onclick="window.location.href='index.php'" 
          class="px-3 py-2 bg-white/10 border border-white/20 rounded-lg hover:bg-white/20 transition flex items-center space-x-1">
          <i data-lucide='home' class='h-4 w-4'></i><span>Home</span>
        </button>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <div class="fade-in">
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 p-4">
      <div class="max-w-4xl mx-auto pt-8">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 gradient-text mb-8 text-center">
          About EduPath
        </h1>

        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 mb-8">
          <h2 class="text-2xl font-bold text-white mb-4">Our Mission</h2>
          <p class="text-gray-300 text-lg leading-relaxed mb-6">
            EduPath redefines education through the power of Artificial Intelligence.  
            We believe every learner deserves tailored guidance and interactive tools  
            that adapt to their pace, strengths, and ambitions.
          </p>

          <div class="grid md:grid-cols-2 gap-8">
            <div>
              <h3 class="text-xl font-semibold text-cyan-400 mb-3">For High School Students</h3>
              <p class="text-gray-300">AI-driven career exploration reveals your strengths and aligns them with real-world opportunities, helping you make confident academic choices early.</p>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-purple-400 mb-3">For University Students</h3>
              <p class="text-gray-300">Transform your notes into smart quizzes and insights that boost retention, engagement, and exam readiness using our intelligent quiz generator.</p>
            </div>
          </div>
        </div>

        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
          <h2 class="text-2xl font-bold text-white mb-4">Our Story</h2>
          <p class="text-gray-300 leading-relaxed">
            Founded with a vision to make personalized education accessible worldwide,  
            EduPath blends modern AI research with proven learning strategies.  
            Thousands of students now use EduPath to navigate their career paths,  
            develop digital literacy, and master lifelong learning skills.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-black/40 border-t border-white/10 py-6 text-center text-gray-400">
    © <?php echo date("Y"); ?> EduPath. All Rights Reserved.
  </footer>

  <script>
    lucide.createIcons();
    document.addEventListener("DOMContentLoaded", () => document.body.classList.add("fade-in"));
    document.querySelectorAll('a, button[href]').forEach(link => {
      if (link.href && link.target !== "_blank" && link.href.includes(window.location.origin)) {
        link.addEventListener('click', e => {
          e.preventDefault();
          document.body.classList.remove("fade-in");
          document.body.classList.add("fade-out");
          setTimeout(() => { window.location = link.href; }, 200);
        });
      }
    });
  </script>
</body>
</html>

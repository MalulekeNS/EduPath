<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AI Tools – EduPath</title>
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
    .ai-card {
      transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
    }
    .ai-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body class="min-h-screen bg-slate-900 text-white">

  <!-- Header -->
  <header class="bg-gradient-to-r from-blue-900 via-purple-900 to-indigo-900 shadow-2xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
      <!-- Back Button -->
      <button onclick="history.back()" class="flex items-center text-gray-300 hover:text-cyan-400 transition">
        <i data-lucide="arrow-left" class="h-5 w-5 mr-1"></i>Back
      </button>

      <!-- Logo -->
      <div class="flex items-center space-x-2">
        <i data-lucide="brain" class="h-7 w-7 text-cyan-400"></i>
        <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 gradient-text">EduPath</span>
      </div>

      <!-- Home Button -->
      <a href="index.php" class="flex items-center text-gray-300 hover:text-cyan-400 transition">
        Home <i data-lucide="home" class="h-5 w-5 ml-1"></i>
      </a>
    </div>
  </header>

  <!-- AI Tools Section -->
  <div class="fade-in">
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-6">
      <div class="max-w-5xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 gradient-text mb-4">
          AI Learning Tools
        </h1>
        <p class="text-gray-300 text-lg mb-12">
          Choose an AI-powered tool to get started with your learning journey.
        </p>

        <div class="grid md:grid-cols-2 gap-10">
          <!-- Career Explorer Card -->
          <a href="career_explorer.php" class="block ai-card rounded-2xl p-10 text-left transform transition-all bg-gradient-to-r from-purple-600 to-cyan-400 hover:from-purple-700 hover:to-cyan-500">
            <div class="text-6xl mb-6">💼</div>
            <h2 class="text-2xl font-bold text-white mb-3">High School: Explore A Career</h2>
            <p class="text-gray-100 text-base leading-relaxed">
              Search careers aligned with your interests — what you love to do. Just describe what excites you most.
            </p>
          </a>

          <!-- Quiz Generator Card -->
          <a href="quiz_generator.php" class="block ai-card rounded-2xl p-10 text-left transform transition-all bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700">
            <div class="text-6xl mb-6">🧠</div>
            <h2 class="text-2xl font-bold text-white mb-3">Tertiary Student: Generate A Quiz</h2>
            <p class="text-gray-100 text-base leading-relaxed">
              Turn your notes into quizzes — test yourself and confirm you truly understand every concept 100%.
            </p>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-black/40 border-t border-white/10 py-6 text-center text-gray-400">
    © <?php echo date("Y"); ?> EduPath. All Rights Reserved.
  </footer>

  <!-- Scripts -->
  <script>
    lucide.createIcons();
    document.addEventListener("DOMContentLoaded", () => document.body.classList.add("fade-in"));
    document.querySelectorAll('a').forEach(link => {
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

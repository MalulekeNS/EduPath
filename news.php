<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>News & Announcements – EduPath</title>
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

  <!-- ✅ Unified Header (structure only, color theme preserved) -->
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
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-red-900 to-slate-900 p-4">
      <div class="max-w-6xl mx-auto pt-8">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-red-400 to-pink-400 gradient-text mb-12 text-center">
          News & Announcements
        </h1>

        <div class="grid gap-8">
          <?php
            $newsItems = [
              [
                "title" => "New AI Quiz Generator Feature Launched",
                "date" => "November 3, 2025",
                "excerpt" => "Students can now upload their study notes and generate personalized quizzes using advanced AI models that adapt to their learning style.",
                "category" => "Technology"
              ],
              [
                "title" => "Career Exploration Program Expansion",
                "date" => "October 28, 2025",
                "excerpt" => "EduPath expands its AI-powered career exploration to include partnerships with top universities and career hubs.",
                "category" => "Programs"
              ],
              [
                "title" => "Fall Semester Registration Now Open",
                "date" => "October 25, 2025",
                "excerpt" => "Students can now register for the fall semester courses and access early academic support through their EduPath accounts.",
                "category" => "Admissions"
              ],
              [
                "title" => "AI Literacy Certification Program Launch",
                "date" => "September 20, 2025",
                "excerpt" => "EduPath introduces a new certification path to boost AI literacy among students preparing for the digital workforce.",
                "category" => "Education"
              ]
            ];

            foreach ($newsItems as $news) {
              echo '
              <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition-all">
                <div class="flex justify-between items-start mb-4">
                  <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-sm font-semibold">'.htmlspecialchars($news["category"]).'</span>
                  <span class="text-gray-400 text-sm">'.htmlspecialchars($news["date"]).'</span>
                </div>
                <h2 class="text-2xl font-bold text-white mb-3">'.htmlspecialchars($news["title"]).'</h2>
                <p class="text-gray-300 leading-relaxed">'.htmlspecialchars($news["excerpt"]).'</p>
                <button class="mt-4 text-red-400 hover:text-red-300 font-semibold transition-colors flex items-center">
                  Read More <i data-lucide="arrow-right" class="h-4 w-4 ml-1"></i>
                </button>
              </div>';
            }
          ?>
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

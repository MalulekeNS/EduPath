<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Academic Programs – EduPath</title>
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

  <!-- ✅ Unified Header (only structure updated) -->
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
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-green-900 to-slate-900 p-4">
      <div class="max-w-6xl mx-auto pt-8">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-green-400 to-blue-400 gradient-text mb-12 text-center">
          Academic Programs
        </h1>

        <div class="grid md:grid-cols-2 gap-8">
          <?php
            $programs = [
              [
                "icon" => "target",
                "color" => "text-green-400",
                "title" => "Career Exploration Program",
                "desc" => "Comprehensive AI-powered guidance designed to help students identify, analyze, and match their interests to viable career options.",
                "bullets" => [
                  "Interest and skills assessment",
                  "Career matching algorithms",
                  "College program recommendations",
                  "Industry insights and job trends"
                ]
              ],
              [
                "icon" => "brain",
                "color" => "text-blue-400",
                "title" => "AI Study Assistant",
                "desc" => "Transform your notes into quizzes, summaries, and personalized learning recommendations.",
                "bullets" => [
                  "AI-generated quizzes",
                  "Adaptive study schedules",
                  "Performance analytics",
                  "Smart learning reminders"
                ]
              ],
              [
                "icon" => "book-open",
                "color" => "text-purple-400",
                "title" => "Digital Literacy Program",
                "desc" => "Gain essential digital skills for today’s workforce with an emphasis on AI and data-driven decision-making.",
                "bullets" => [
                  "AI and ML fundamentals",
                  "Digital citizenship and ethics",
                  "Intro to data visualization",
                  "Foundations of programming"
                ]
              ],
              [
                "icon" => "award",
                "color" => "text-yellow-400",
                "title" => "Certification & Readiness",
                "desc" => "Earn recognized credentials that validate your skills and prepare you for real-world success.",
                "bullets" => [
                  "AI Literacy Certification",
                  "Digital Skills Validation",
                  "Career Readiness Certificates",
                  "Study Skills Mastery"
                ]
              ]
            ];

            foreach ($programs as $prog) {
              echo '
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition-all">
                  <i data-lucide="'.$prog["icon"].'" class="h-12 w-12 '.$prog["color"].' mb-4"></i>
                  <h2 class="text-2xl font-bold text-white mb-4">'.htmlspecialchars($prog["title"]).'</h2>
                  <p class="text-gray-300 mb-4">'.htmlspecialchars($prog["desc"]).'</p>
                  <ul class="text-gray-300 space-y-2">';
              foreach ($prog["bullets"] as $b) {
                echo '<li>• '.htmlspecialchars($b).'</li>';
              }
              echo '</ul></div>';
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

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Portal – EduPath</title>
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

  <!-- ✅ Updated Header (Structure Only, Colors Unchanged) -->
  <header class="bg-gradient-to-r from-blue-900 via-purple-900 to-indigo-900 shadow-2xl sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
      <!-- Brain Logo -->
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
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-violet-900 to-slate-900 p-4">
      <div class="max-w-6xl mx-auto pt-8">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-violet-400 to-purple-400 gradient-text mb-12 text-center">
          Student Portal
        </h1>

        <!-- Portal Features -->
        <div class="grid md:grid-cols-3 gap-8">
          <?php
            $features = [
              ["icon" => "book-open", "title" => "Grades", "text" => "View your academic progress and performance trends."],
              ["icon" => "check-circle", "title" => "Attendance", "text" => "Monitor your attendance records and participation."],
              ["icon" => "calendar", "title" => "Schedule", "text" => "Stay organized with your class schedule and upcoming deadlines."],
              ["icon" => "file-text", "title" => "Assignments", "text" => "Track, upload, and view feedback on assignments."],
              ["icon" => "user", "title" => "Profile", "text" => "Edit and manage your personal student details."],
              ["icon" => "brain", "title" => "AI Tools", "text" => "Access EduPath’s career and quiz AI modules anytime."]
            ];

            foreach ($features as $f) {
              echo '
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 text-center hover:bg-white/20 transition-all cursor-pointer">
                  <i data-lucide="'.$f["icon"].'" class="h-12 w-12 text-violet-400 mx-auto mb-4"></i>
                  <h2 class="text-xl font-bold text-white mb-2">'.htmlspecialchars($f["title"]).'</h2>
                  <p class="text-gray-300">'.htmlspecialchars($f["text"]).'</p>
                </div>
              ';
            }
          ?>
        </div>

        <!-- Quick Stats -->
        <div class="mt-12 bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
          <h2 class="text-2xl font-bold text-white mb-6">Quick Stats</h2>
          <div class="grid md:grid-cols-4 gap-6">
            <?php
              $stats = [
                ["value" => "85%", "label" => "Overall Grade", "color" => "text-violet-400"],
                ["value" => "94%", "label" => "Attendance", "color" => "text-green-400"],
                ["value" => "12", "label" => "Completed Quizzes", "color" => "text-blue-400"],
                ["value" => "5", "label" => "Career Matches", "color" => "text-yellow-400"]
              ];

              foreach ($stats as $s) {
                echo '
                  <div class="text-center">
                    <div class="text-3xl font-bold '.$s["color"].' mb-2">'.$s["value"].'</div>
                    <div class="text-gray-300">'.$s["label"].'</div>
                  </div>
                ';
              }
            ?>
          </div>
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

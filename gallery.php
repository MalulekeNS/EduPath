<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Photo Gallery – EduPath</title>
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

  <!-- ✅ Updated Header (structure unified, colors kept) -->
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
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-pink-900 to-slate-900 p-4">
      <div class="max-w-6xl mx-auto pt-8">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-400 to-rose-400 gradient-text mb-12 text-center">
          Photo Gallery
        </h1>

        <div class="grid md:grid-cols-3 gap-6">
          <?php
            $gallery = [
              ["title" => "Campus Life", "desc" => "Students enjoying campus activities"],
              ["title" => "AI Lab", "desc" => "State-of-the-art AI learning facilities"],
              ["title" => "Career Fair", "desc" => "Annual career exploration fair"],
              ["title" => "Study Groups", "desc" => "Collaborative learning sessions"],
              ["title" => "Graduation", "desc" => "Celebrating student achievements"],
              ["title" => "Workshops", "desc" => "Hands-on learning and skill development"],
              ["title" => "Events", "desc" => "Exciting and inspiring student events"],
              ["title" => "Student Community", "desc" => "Empowering a diverse student body"],
              ["title" => "Modern Facilities", "desc" => "Innovative, technology-rich classrooms"]
            ];

            foreach ($gallery as $item) {
              echo '
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all cursor-pointer">
                  <div class="aspect-video bg-gradient-to-br from-pink-500/20 to-rose-500/20 rounded-lg flex items-center justify-center mb-4">
                    <i data-lucide="camera" class="h-12 w-12 text-pink-400"></i>
                  </div>
                  <h3 class="text-lg font-semibold text-white mb-2">'.htmlspecialchars($item["title"]).'</h3>
                  <p class="text-gray-400 text-sm">'.htmlspecialchars($item["desc"]).'</p>
                </div>
              ';
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

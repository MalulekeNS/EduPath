<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Team – EduPath</title>
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

  <!-- ✅ Unified Header (structure only; color theme kept) -->
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
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 p-4">
      <div class="max-w-6xl mx-auto pt-8">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 gradient-text mb-12 text-center">
          Our Team
        </h1>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
          <?php
            $staff = [
              ["name" => "Mr Maluleke", "role" => "Principal & AI Director", "email" => "Maluleke@edupath.edu"],
              ["name" => "Prof. Michael Baloyi", "role" => "Career Counseling Lead", "email" => "Baloyi.M@edupath.edu"],
              ["name" => "Dr. Emily Rodriguez", "role" => "Educational Technology Specialist", "email" => "emily.rodriguez@edupath.edu"],
              ["name" => "James Wilson", "role" => "AI Developer", "email" => "james.wilson@edupath.edu"],
              ["name" => "Lisa Thompson", "role" => "Student Success Coordinator", "email" => "lisa.thompson@edupath.edu"],
              ["name" => "Dr. Robert Kim", "role" => "Assessment Specialist", "email" => "robert.kim@edupath.edu"],
            ];

            foreach ($staff as $person) {
              echo '
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 text-center hover:bg-white/20 transition-all">
                  <div class="w-20 h-20 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i data-lucide="user" class="h-10 w-10 text-white"></i>
                  </div>
                  <h3 class="text-xl font-bold text-white mb-1">'.htmlspecialchars($person["name"]).'</h3>
                  <p class="text-indigo-400 mb-1">'.htmlspecialchars($person["role"]).'</p>
                  <p class="text-gray-300 text-sm">'.htmlspecialchars($person["email"]).'</p>
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

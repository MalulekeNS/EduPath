<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendar & Events – EduPath</title>
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

  <!-- ✅ Updated Header (structure only, colors kept) -->
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
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-orange-900 to-slate-900 p-4">
      <div class="max-w-6xl mx-auto pt-8">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-orange-400 to-red-400 gradient-text mb-12 text-center">
          Calendar & Events
        </h1>

        <div class="grid md:grid-cols-2 gap-8">
          <!-- Upcoming Events -->
          <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
            <h2 class="text-2xl font-bold text-white mb-6">Upcoming Events</h2>
            <div class="space-y-4">
              <?php
                $events = [
                  ["date" => "Oct 25", "title" => "AI Career Fair", "time" => "10:00 AM - 4:00 PM"],
                  ["date" => "Nov 2", "title" => "Study Skills Workshop", "time" => "2:00 PM - 4:00 PM"],
                  ["date" => "Nov 10", "title" => "University Info Session", "time" => "6:00 PM - 8:00 PM"],
                  ["date" => "Nov 20", "title" => "Quiz Generation Demo", "time" => "1:00 PM - 2:30 PM"],
                  ["date" => "Dec 5", "title" => "Career Counseling Day", "time" => "9:00 AM - 5:00 PM"]
                ];

                foreach ($events as $e) {
                  echo '
                  <div class="flex items-center p-4 bg-white/5 rounded-lg border border-white/10 hover:bg-white/10 transition">
                    <div class="bg-orange-500/20 text-orange-400 px-3 py-2 rounded-lg font-bold mr-4 min-w-fit">'.$e["date"].'</div>
                    <div class="flex-1">
                      <h3 class="text-white font-semibold">'.$e["title"].'</h3>
                      <p class="text-gray-400 text-sm">'.$e["time"].'</p>
                    </div>
                    <i data-lucide="calendar" class="h-5 w-5 text-gray-400"></i>
                  </div>';
                }
              ?>
            </div>
          </div>

          <!-- Academic Calendar -->
          <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
            <h2 class="text-2xl font-bold text-white mb-6">Academic Calendar</h2>
            <div class="space-y-6">
              <div>
                <h3 class="text-lg font-semibold text-orange-400 mb-2">Fall Semester 2025</h3>
                <ul class="text-gray-300 space-y-1">
                  <li>• Classes Begin: September 1</li>
                  <li>• Midterm Exams: October 15 - 19</li>
                  <li>• Break: November 25 - 29</li>
                  <li>• Final Exams: December 10 - 14</li>
                </ul>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-orange-400 mb-2">Spring Semester 2026</h3>
                <ul class="text-gray-300 space-y-1">
                  <li>• Classes Begin: January 15</li>
                  <li>• Spring Break: March 9 - 13</li>
                  <li>• Midterm Exams: March 23 - 27</li>
                  <li>• Final Exams: May 4 - 8</li>
                </ul>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-orange-400 mb-2">Important Deadlines</h3>
                <ul class="text-gray-300 space-y-1">
                  <li>• Registration Opens: November 1</li>
                  <li>• Scholarship Applications: December 15</li>
                  <li>• Career Fair Registration: January 30</li>
                </ul>
              </div>
            </div>
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

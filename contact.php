<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact – EduPath</title>
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

  <!-- ✅ Updated Header (structure only, color theme preserved) -->
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
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-teal-900 to-slate-900 p-4">
      <div class="max-w-5xl mx-auto pt-8">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-teal-400 to-cyan-400 gradient-text mb-12 text-center">
          Contact Us
        </h1>

        <div class="grid md:grid-cols-2 gap-8">
          <!-- Left Column: Contact Info -->
          <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
            <h2 class="text-2xl font-bold text-white mb-6">Get in Touch</h2>

            <div class="space-y-4">
              <div class="flex items-center">
                <i data-lucide="phone" class="h-5 w-5 text-teal-400 mr-3"></i>
                <span class="text-gray-300">+27 (0)83 943 8335</span>
              </div>
              <div class="flex items-center">
                <i data-lucide="mail" class="h-5 w-5 text-teal-400 mr-3"></i>
                <span class="text-gray-300">info@edupath.edu</span>
              </div>
              <div class="flex items-center">
                <i data-lucide="map-pin" class="h-5 w-5 text-teal-400 mr-3"></i>
                <span class="text-gray-300">5 Diagonal Street, Grand Central, Midrand, 1685</span>
              </div>
            </div>

            <div class="mt-8">
              <h3 class="text-lg font-semibold text-white mb-4">Office Hours</h3>
              <div class="text-gray-300 space-y-2">
                <p>Monday - Friday: 8:00 AM - 6:00 PM</p>
                <p>Saturday: 9:00 AM - 4:00 PM</p>
                <p>Sunday: Closed</p>
              </div>
            </div>
          </div>

          <!-- Right Column: Contact Form -->
          <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
            <h2 class="text-2xl font-bold text-white mb-6">Send us a Message</h2>

            <form action="#" method="post" class="space-y-4">
              <input type="text" name="name" placeholder="Your Name" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-teal-400">

              <input type="email" name="email" placeholder="Your Email" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-teal-400">

              <select name="topic" class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white focus:outline-none focus:border-teal-400">
                <option value="">Select Topic</option>
                <option value="career">Career Exploration</option>
                <option value="quiz">AI Quiz Generator</option>
                <option value="support">Technical Support</option>
                <option value="other">Other</option>
              </select>

              <textarea name="message" placeholder="Your Message" rows="4" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 resize-none focus:outline-none focus:border-teal-400"></textarea>

              <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white rounded-lg font-semibold transition-all">
                <i data-lucide="send" class="h-5 w-5 inline-block mr-2"></i>Send Message
              </button>
            </form>
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

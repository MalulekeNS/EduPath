<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduPath – Career Explorer</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: "Inter", sans-serif;
    }
    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }
    .spinner {
      width: 48px;
      height: 48px;
      border: 4px solid rgba(255,255,255,0.3);
      border-top-color: #38bdf8;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      margin: 0 auto;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .fade-in { animation: fadeIn 0.5s ease forwards; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Demand colors */
    .text-green { color: #22c55e; font-weight: 600; }
    .text-yellow { color: #facc15; font-weight: 600; }
    .text-red { color: #ef4444; font-weight: 600; }

    .career-card {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      backdrop-filter: blur(10px);
      transition: 0.3s ease;
    }
    .career-card:hover {
      background: rgba(255,255,255,0.1);
      transform: translateY(-3px);
    }
    .career-title {
      font-family: "Poppins", sans-serif;
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    .career-desc {
      color: #d1d5db;
      font-size: 1.05rem;
      margin-bottom: 0.75rem;
      line-height: 1.6;
    }
    .career-meta {
      font-size: 0.95rem;
      line-height: 1.5;
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white">
  <!-- Header -->
  <header class="bg-gradient-to-r from-blue-900 via-purple-900 to-indigo-900 shadow-2xl sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <i data-lucide="brain" class="h-7 w-7 text-cyan-400"></i>
        <span class="text-xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 gradient-text">EduPath</span>
      </div>
      <div class="flex space-x-2">
        <button onclick="history.back()" class="px-3 py-2 bg-white/10 border border-white/20 rounded-lg hover:bg-white/20 transition flex items-center space-x-1">
          <i data-lucide='arrow-left' class='h-4 w-4'></i><span>Back</span>
        </button>
        <button onclick="window.location.href='index.php'" class="px-3 py-2 bg-white/10 border border-white/20 rounded-lg hover:bg-white/20 transition flex items-center space-x-1">
          <i data-lucide='home' class='h-4 w-4'></i><span>Home</span>
        </button>
      </div>
    </div>
  </header>

  <!-- Main -->
  <main class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-cyan-400 to-blue-400 gradient-text mb-8 text-center font-poppins">
      AI Career Explorer
    </h1>

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 mb-8">
      <h2 class="text-2xl font-bold text-white mb-4">Tell us about your interests</h2>
      <textarea id="interests" placeholder="Describe your interests, skills, and what you enjoy doing..."
        class="w-full h-40 p-4 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 resize-none focus:outline-none focus:border-cyan-400 mb-6"></textarea>
      <button id="exploreBtn"
        class="w-full py-4 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white rounded-lg font-bold text-lg transition-all flex items-center justify-center">
        <i data-lucide="search" class="h-5 w-5 mr-2"></i> Explore Career Paths
      </button>
    </div>

    <!-- Results -->
    <div id="outputContainer" class="hidden fade-in">
      <div id="loadingPanel" class="hidden text-center py-8">
        <div class="spinner"></div>
        <p class="mt-4 text-gray-300">Analyzing your interests and preparing personalized career insights...</p>
      </div>
      <div id="careerResults" class="space-y-6"></div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-black/40 border-t border-white/10 py-6 text-center text-gray-400">
    © <?php echo date("Y"); ?> EduPath. All Rights Reserved.
  </footer>

  <script>
    lucide.createIcons();

    const btn = document.getElementById("exploreBtn");
    const interests = document.getElementById("interests");
    const outputContainer = document.getElementById("outputContainer");
    const careerResults = document.getElementById("careerResults");
    const loadingPanel = document.getElementById("loadingPanel");

    btn.addEventListener("click", async () => {
      const value = interests.value.trim();
      if (!value) {
        outputContainer.classList.remove("hidden");
        careerResults.innerHTML = "<p class='text-red-400 text-center'>⚠️ Please describe your interests first.</p>";
        return;
      }

      // Spinner ON
      outputContainer.classList.remove("hidden");
      careerResults.innerHTML = "";
      loadingPanel.classList.remove("hidden");

      try {
        const res = await fetch("career_explorer_api.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ interests: value }),
        });
        const data = await res.json();

        loadingPanel.classList.add("hidden");

        if (data.message) {
          // Split by sections
          const sections = data.message.split("───────────────");
          careerResults.innerHTML = sections.map((section) => {
            const demandMatch = section.match(/(✅|⚠️|❌)\s(.*?)$/m);
            let demandText = demandMatch ? demandMatch[0] : "";
            let demandColor = "text-yellow";
            let demandPercent = "65%";

            if (demandText.includes("In-Demand")) { demandColor = "text-green"; demandPercent = "90%"; }
            else if (demandText.includes("Low")) { demandColor = "text-red"; demandPercent = "35%"; }

            return `
              <div class="career-card">
                <div class="career-title">${section.match(/🎯 (.*)/)?.[1] || "Career"}</div>
                <div class="career-desc">${section.match(/\n(.*?)\n\n🧠/)?.[1] || ""}</div>
                <div class="career-meta">
                  ${section.replace(/🎯.*\n/, "").replace(demandText, "")}
                  <div class="mt-3 ${demandColor}">
                    ${demandText}<br>
                    <span class="opacity-80 text-sm">📊 Estimated Demand: ${demandPercent} in SA Job Market</span>
                  </div>
                </div>
              </div>
            `;
          }).join("");
        } else {
          careerResults.innerHTML = `<p class="text-center text-red-400">⚠️ ${data.error || "An unknown error occurred."}</p>`;
        }
      } catch (err) {
        loadingPanel.classList.add("hidden");
        careerResults.innerHTML = `<p class="text-center text-red-400">⚠️ Connection error. Please try again.</p>`;
      }
    });
  </script>
</body>
</html>

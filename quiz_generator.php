<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
$name = $_SESSION['name'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduPath – AI Quiz Generator</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">

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
      border-top-color: #a855f7;
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

    .question-card {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 24px;
      margin-bottom: 20px;
      backdrop-filter: blur(10px);
      transition: 0.3s ease;
    }
    .question-card:hover {
      background: rgba(255,255,255,0.08);
      transform: translateY(-3px);
    }
    .option {
      border: 1px solid rgba(255,255,255,0.1);
      padding: 12px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.25s ease;
    }
    .option:hover { background: rgba(255,255,255,0.1); }
    .option.correct { background: rgba(34,197,94,0.2); border-color: #22c55e; }
    .option.wrong { background: rgba(239,68,68,0.2); border-color: #ef4444; }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white">
  <!-- Header -->
  <header class="bg-gradient-to-r from-purple-900 via-pink-900 to-fuchsia-900 shadow-2xl sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <i data-lucide="brain" class="h-7 w-7 text-pink-400"></i>
        <span class="text-xl font-bold bg-gradient-to-r from-pink-400 to-fuchsia-400 gradient-text">EduPath</span>
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
  <main class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-400 to-fuchsia-400 gradient-text mb-8 text-center font-poppins">
      AI Quiz Generator
    </h1>

    <!-- Upload / Input -->
    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 mb-8">
      <h2 class="text-2xl font-bold mb-4">Upload or Paste Your Notes</h2>
      <input type="file" id="fileInput" accept=".txt,.md,.docx,.pdf"
        class="block w-full text-sm text-gray-300 mb-4 bg-transparent border border-white/20 p-2 rounded-lg cursor-pointer" />
      <textarea id="notes" placeholder="Paste your study notes here..."
        class="w-full h-48 p-4 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 resize-none focus:outline-none focus:border-pink-400 mb-6"></textarea>
      <button id="generateBtn"
        class="w-full py-4 bg-gradient-to-r from-pink-600 to-fuchsia-600 hover:from-pink-700 hover:to-fuchsia-700 text-white rounded-lg font-bold text-lg transition-all flex items-center justify-center">
        <i data-lucide="sparkles" class="h-5 w-5 mr-2"></i> Generate Quiz
      </button>
    </div>

    <!-- Output -->
    <div id="outputContainer" class="hidden fade-in">
      <div id="loadingPanel" class="hidden text-center py-8">
        <div class="spinner"></div>
        <p class="mt-4 text-gray-300">Generating quiz questions based on your notes...</p>
      </div>
      <div id="quizContainer" class="space-y-6"></div>
      <div id="resultsPanel" class="hidden text-center py-8">
        <i data-lucide="award" class="h-12 w-12 text-yellow-400 mx-auto mb-3"></i>
        <h2 class="text-3xl font-bold text-white mb-2">Quiz Complete!</h2>
        <p id="scoreText" class="text-xl text-pink-300 mb-4"></p>
        <button onclick="resetQuiz()" class="px-6 py-3 bg-gradient-to-r from-pink-600 to-fuchsia-600 hover:from-pink-700 hover:to-fuchsia-700 rounded-lg font-semibold">Try Another Quiz</button>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-black/40 border-t border-white/10 py-6 text-center text-gray-400">
    © <?php echo date("Y"); ?> EduPath. All Rights Reserved.
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
  <script>
    lucide.createIcons();

    const fileInput = document.getElementById("fileInput");
    const notesArea = document.getElementById("notes");
    const generateBtn = document.getElementById("generateBtn");
    const outputContainer = document.getElementById("outputContainer");
    const loadingPanel = document.getElementById("loadingPanel");
    const quizContainer = document.getElementById("quizContainer");
    const resultsPanel = document.getElementById("resultsPanel");
    const scoreText = document.getElementById("scoreText");

    let quizData = [];
    let score = 0;
    let answered = 0;

    // ✅ PDF Reader (extract text)
    fileInput.addEventListener("change", async (e) => {
      const file = e.target.files[0];
      if (!file) return;
      if (file.type === "application/pdf") {
        const arrayBuffer = await file.arrayBuffer();
        const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
        let text = "";
        for (let i = 1; i <= pdf.numPages; i++) {
          const page = await pdf.getPage(i);
          const content = await page.getTextContent();
          text += content.items.map(t => t.str).join(" ") + "\n";
        }
        notesArea.value = text.trim().slice(0, 3000);
      } else {
        const reader = new FileReader();
        reader.onload = () => notesArea.value = reader.result.slice(0, 3000);
        reader.readAsText(file);
      }
    });

    // ✅ Generate quiz
    generateBtn.addEventListener("click", async () => {
      const notes = notesArea.value.trim();
      if (!notes) return alert("Please paste or upload your notes first.");

      outputContainer.classList.remove("hidden");
      loadingPanel.classList.remove("hidden");
      quizContainer.innerHTML = "";
      resultsPanel.classList.add("hidden");

      try {
        const res = await fetch("quiz_generator_api.php", {
          method: "POST",
          headers: { "Content-Type": "application/json; charset=utf-8" },
          body: JSON.stringify({ notes: notesArea.value }),
        });
        const data = await res.json();

        loadingPanel.classList.add("hidden");

        if (!data.questions) {
          quizContainer.innerHTML = `<p class='text-red-400 text-center'>⚠️ ${data.error || "No questions generated."}</p>`;
          return;
        }

        quizData = data.questions;
        score = 0;
        answered = 0;

        quizContainer.innerHTML = data.questions.map((q, idx) => `
          <div class="question-card">
            <h3 class="text-xl font-semibold mb-3">${idx + 1}. ${q.question}</h3>
            <div class="space-y-2">
              ${q.options.map((opt, i) => `
                <div class="option" onclick="selectOption(${idx}, ${i}, this)">
                  ${String.fromCharCode(65 + i)}. ${opt}
                </div>
              `).join("")}
            </div>
          </div>
        `).join("");
      } catch (err) {
        loadingPanel.classList.add("hidden");
        quizContainer.innerHTML = `<p class='text-red-400 text-center'>⚠️ Connection error. Please try again.</p>`;
      }
    });

    function selectOption(qIndex, optIndex, element) {
      const correct = quizData[qIndex].answer;
      const options = element.parentElement.querySelectorAll(".option");
      options.forEach(o => o.onclick = null);

      if (optIndex === correct) {
        element.classList.add("correct");
        score++;
      } else {
        element.classList.add("wrong");
        options[correct].classList.add("correct");
      }

      answered++;
      if (answered === quizData.length) showResults();
    }

    function showResults() {
      quizContainer.innerHTML = "";
      resultsPanel.classList.remove("hidden");
      scoreText.textContent = `Your Score: ${score} / ${quizData.length}`;
    }

    function resetQuiz() {
      resultsPanel.classList.add("hidden");
      notesArea.value = "";
      quizData = [];
      score = 0;
      answered = 0;
      outputContainer.classList.add("hidden");
    }
  </script>
</body>
</html>

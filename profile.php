<?php
// Error visibility for setup (disable later)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Include your backend/db.php file
$db_path = __DIR__ . '/backend/db.php';
if (!file_exists($db_path)) {
    die("<p style='color:red; text-align:center; margin-top:50px;'>❌ Database file not found at <b>$db_path</b>. Please verify your folder structure.</p>");
}
require_once $db_path;

// ✅ Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// ✅ Verify PDO connection
if (!isset($pdo)) {
    die("<p style='color:red; text-align:center; margin-top:50px;'>⚠️ Database connection unavailable. Please check backend/db.php.</p>");
}

// ✅ Fetch user info
$user_id = $_SESSION['user_id'];
try {
    $stmt = $pdo->prepare("SELECT name, email, role, created_at FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<p style='color:red; text-align:center; margin-top:50px;'>Database query failed: " . htmlspecialchars($e->getMessage()) . "</p>");
}

if (!$user) {
    die("<p style='color:red; text-align:center; margin-top:50px;'>User record not found.</p>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduPath – My Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body { font-family: "Inter", sans-serif; }
    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }
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

  <!-- Main Content -->
  <main class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-400 to-fuchsia-400 gradient-text mb-8 text-center font-poppins">
      My Profile
    </h1>

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
      <div class="flex flex-col items-center mb-6">
        <i data-lucide="user" class="h-20 w-20 text-pink-400 mb-3"></i>
        <h2 class="text-2xl font-semibold"><?php echo htmlspecialchars($user['name']); ?></h2>
        <p class="text-gray-300"><?php echo htmlspecialchars($user['email']); ?></p>
      </div>

      <div class="border-t border-white/10 pt-6">
        <p><strong class="text-pink-300">Role:</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
        <p><strong class="text-pink-300">Member Since:</strong> <?php echo date("F j, Y", strtotime($user['created_at'])); ?></p>
      </div>

      <div class="mt-8 text-center">
        <button onclick="window.location.href='edit_profile.php'" 
          class="px-6 py-3 bg-gradient-to-r from-pink-600 to-fuchsia-600 hover:from-pink-700 hover:to-fuchsia-700 rounded-lg font-semibold">
          Edit Profile
        </button>
        <button onclick="window.location.href='logout.php'"
          class="ml-3 px-6 py-3 bg-white/10 border border-white/20 rounded-lg hover:bg-white/20 font-semibold text-gray-200">
          Logout
        </button>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-black/40 border-t border-white/10 py-6 text-center text-gray-400">
    © <?php echo date("Y"); ?> EduPath. All Rights Reserved.
  </footer>

  <script> lucide.createIcons(); </script>
</body>
</html>

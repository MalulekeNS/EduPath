<?php
// Enable errors (disable after setup)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Include your backend connection
require_once __DIR__ . '/backend/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// ✅ Fetch current user info
try {
    $stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

if (!$user) {
    die("User not found.");
}

// ✅ Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name && $email) {
        try {
            if ($password) {
                // Update with password
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=?");
                $stmt->execute([$name, $email, $hashed, $user_id]);
            } else {
                // Update without password
                $stmt = $pdo->prepare("UPDATE users SET name=?, email=? WHERE id=?");
                $stmt->execute([$name, $email, $user_id]);
            }
            $_SESSION['name'] = $name;
            $success = "✅ Profile updated successfully!";
        } catch (PDOException $e) {
            $error = "Update failed: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profile | EduPath</title>
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
    .popup {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }
    .popup-box {
      background: rgba(20,20,30,0.95);
      border: 1px solid rgba(255,255,255,0.15);
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      color: white;
      max-width: 400px;
      backdrop-filter: blur(10px);
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

  <!-- Main -->
  <main class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-400 to-fuchsia-400 gradient-text mb-8 text-center font-poppins">
      Edit Profile
    </h1>

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
      <?php if ($error): ?>
        <div class="mb-4 bg-red-500/20 text-red-300 border border-red-400/30 px-4 py-2 rounded-lg text-sm text-center">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form method="POST" class="space-y-6">
        <div>
          <label class="block text-gray-300 mb-2 font-semibold">Full Name</label>
          <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-pink-400">
        </div>

        <div>
          <label class="block text-gray-300 mb-2 font-semibold">Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-fuchsia-400">
        </div>

        <div>
          <label class="block text-gray-300 mb-2 font-semibold">New Password (optional)</label>
          <input type="password" name="password" placeholder="Leave blank to keep current password" class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-pink-400">
        </div>

        <button type="submit" class="w-full py-4 bg-gradient-to-r from-pink-600 to-fuchsia-600 hover:from-pink-700 hover:to-fuchsia-700 rounded-lg font-bold text-white transition-all flex items-center justify-center">
          <i data-lucide="save" class="h-5 w-5 mr-2"></i> Save Changes
        </button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-black/40 border-t border-white/10 py-6 text-center text-gray-400">
    © <?php echo date("Y"); ?> EduPath. All Rights Reserved.
  </footer>

  <!-- ✅ Popup for success -->
  <?php if ($success): ?>
  <div class="popup" id="popup">
    <div class="popup-box">
      <i data-lucide="check-circle" class="h-12 w-12 text-green-400 mx-auto mb-3"></i>
      <h3 class="text-2xl font-bold mb-2">Profile Updated</h3>
      <p class="text-gray-300 mb-4"><?php echo htmlspecialchars($success); ?></p>
      <button onclick="document.getElementById('popup').remove()" 
        class="px-5 py-2 bg-gradient-to-r from-pink-600 to-fuchsia-600 hover:from-pink-700 hover:to-fuchsia-700 rounded-lg font-semibold">
        OK
      </button>
    </div>
  </div>
  <?php endif; ?>

  <script> lucide.createIcons(); </script>
</body>
</html>

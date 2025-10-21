<?php
session_start();
require_once __DIR__ . '/backend/db.php';

$message = '';
$type = ''; // success, error, or warning

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');

    if ($name && $email && $password && $confirm) {
        if ($password === $confirm) {
            $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$email]);
            if ($check->fetch()) {
                $message = 'An account with this email already exists.';
                $type = 'warning';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hash]);
                $message = 'Registration successful! You can now log in.';
                $type = 'success';
            }
        } else {
            $message = 'Passwords do not match.';
            $type = 'error';
        }
    } else {
        $message = 'All fields are required.';
        $type = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | EduPath</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }

    /* Popup box styling */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.6);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 999;
      animation: fadeIn 0.3s ease;
    }

    .popup-box {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(15px);
      border-radius: 16px;
      padding: 2rem;
      width: 90%;
      max-width: 420px;
      text-align: center;
      color: white;
      animation: popUp 0.3s ease;
    }

    .popup-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
    }

    .popup-success { background: rgba(34,197,94,0.2); border: 2px solid #22c55e; }
    .popup-error { background: rgba(239,68,68,0.2); border: 2px solid #ef4444; }
    .popup-warning { background: rgba(234,179,8,0.2); border: 2px solid #eab308; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes popUp { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white font-sans">

<div class="max-w-md w-full mx-4 bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl">
  <div class="text-center mb-8">
    <i data-lucide="user-plus" class="h-12 w-12 text-purple-400 mx-auto mb-3"></i>
    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 gradient-text">Create Your Account</h1>
    <p class="text-gray-400 mt-2">Join EduPath and explore your future</p>
  </div>

  <form method="POST" class="space-y-5">
    <div>
      <label class="block text-gray-300 mb-2">Full Name</label>
      <input type="text" name="name" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-pink-400">
    </div>

    <div>
      <label class="block text-gray-300 mb-2">Email</label>
      <input type="email" name="email" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-400">
    </div>

    <div>
      <label class="block text-gray-300 mb-2">Password</label>
      <input type="password" name="password" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-purple-400">
    </div>

    <div>
      <label class="block text-gray-300 mb-2">Confirm Password</label>
      <input type="password" name="confirm" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-purple-400">
    </div>

    <button type="submit" class="w-full py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-lg font-semibold text-white transition-all">
      <i data-lucide="check-circle" class="h-5 w-5 inline-block mr-2"></i> Register
    </button>
  </form>

  <p class="text-center text-gray-400 text-sm mt-6">
    Already have an account?
    <a href="login.php" class="text-purple-400 hover:underline">Log in here</a>
  </p>
</div>

<?php if ($message): ?>
  <div class="popup-overlay" id="popupBox">
    <div class="popup-box">
      <div class="popup-icon 
        <?php echo $type === 'success' ? 'popup-success' : ($type === 'error' ? 'popup-error' : 'popup-warning'); ?>">
        <i data-lucide="<?php 
          echo $type === 'success' ? 'check' : ($type === 'error' ? 'x' : 'alert-triangle'); ?>" 
          class="w-8 h-8"></i>
      </div>
      <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($message); ?></h2>
      <button onclick="closePopup()" class="mt-4 px-6 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-lg">OK</button>
    </div>
  </div>

  <script>
    lucide.createIcons();
    const popup = document.getElementById("popupBox");
    function closePopup() {
      popup.style.opacity = "0";
      setTimeout(() => popup.remove(), 300);
      <?php if ($type === 'success'): ?> 
        setTimeout(() => window.location.href = 'login.php', 500);
      <?php endif; ?>
    }
    // Auto close after 3s if user doesn’t click
    setTimeout(() => {
      if (popup) closePopup();
    }, 3000);
  </script>
<?php endif; ?>

<script>lucide.createIcons();</script>
</body>
</html>

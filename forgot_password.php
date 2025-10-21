<?php
session_start();
require_once __DIR__ . '/backend/db.php';

$message = '';
$token = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 1800); // 30 min expiry

            // store token
            $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)")
                ->execute([$email, $token, $expires]);

            $resetLink = "reset_password.php?token=$token";
            $message = "✅ Password reset link generated: <a href='$resetLink' class='underline text-cyan-300'>$resetLink</a>";
        } else {
            $message = 'No account found with that email.';
        }
    } else {
        $message = 'Please enter your email address.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password | EduPath</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>.gradient-text{background-clip:text;-webkit-background-clip:text;color:transparent;}</style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white font-sans">

<div class="max-w-md w-full mx-4 bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl">
  <div class="text-center mb-8">
    <i data-lucide="key-round" class="h-12 w-12 text-cyan-400 mx-auto mb-3"></i>
    <h1 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 gradient-text">Forgot Password</h1>
    <p class="text-gray-400 mt-2">Enter your email to reset your password</p>
  </div>

  <?php if ($message): ?>
    <div class="mb-4 bg-blue-500/20 text-blue-300 border border-blue-400/30 px-4 py-2 rounded-lg text-sm text-center">
      <?php echo $message; ?>
    </div>
  <?php endif; ?>

  <form method="POST" class="space-y-5">
    <div>
      <label class="block text-gray-300 mb-2">Email Address</label>
      <input type="email" name="email" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-400">
    </div>

    <button type="submit" class="w-full py-3 bg-gradient-to-r from-cyan-600 to-purple-600 hover:from-cyan-700 hover:to-purple-700 rounded-lg font-semibold text-white transition-all">
      <i data-lucide="send" class="h-5 w-5 inline-block mr-2"></i> Send Reset Link
    </button>
  </form>

  <p class="text-center text-gray-400 text-sm mt-6">
    Remembered your password? 
    <a href="login.php" class="text-cyan-400 hover:underline">Go back to login</a>
  </p>
</div>

<script>lucide.createIcons();</script>
</body>
</html>

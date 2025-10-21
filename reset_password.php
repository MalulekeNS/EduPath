<?php
session_start();
require_once __DIR__ . '/backend/db.php';

$message = '';
$validToken = false;
$token = $_GET['token'] ?? '';

if ($token) {
    $stmt = $pdo->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
    $stmt->execute([$token]);
    $row = $stmt->fetch();

    if ($row && strtotime($row['expires_at']) > time()) {
        $validToken = true;
        $email = $row['email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim($_POST['password'] ?? '');
            $confirm = trim($_POST['confirm'] ?? '');

            if ($password && $password === $confirm) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $pdo->prepare("UPDATE users SET password=? WHERE email=?")->execute([$hash, $email]);
                $pdo->prepare("DELETE FROM password_resets WHERE email=?")->execute([$email]);
                $message = '✅ Password updated successfully! <a href="login.php" class="underline text-cyan-300">Login now</a>.';
                $validToken = false;
            } else {
                $message = 'Passwords do not match or are empty.';
            }
        }
    } else {
        $message = '❌ Invalid or expired reset link.';
    }
} else {
    $message = 'Invalid request.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | EduPath</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>.gradient-text{background-clip:text;-webkit-background-clip:text;color:transparent;}</style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white font-sans">

<div class="max-w-md w-full mx-4 bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl">
  <div class="text-center mb-8">
    <i data-lucide="lock" class="h-12 w-12 text-purple-400 mx-auto mb-3"></i>
    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 gradient-text">Reset Password</h1>
    <p class="text-gray-400 mt-2">Create a new secure password</p>
  </div>

  <?php if ($message): ?>
    <div class="mb-4 bg-blue-500/20 text-blue-300 border border-blue-400/30 px-4 py-2 rounded-lg text-sm text-center">
      <?php echo $message; ?>
    </div>
  <?php endif; ?>

  <?php if ($validToken): ?>
  <form method="POST" class="space-y-5">
    <div>
      <label class="block text-gray-300 mb-2">New Password</label>
      <input type="password" name="password" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-pink-400">
    </div>

    <div>
      <label class="block text-gray-300 mb-2">Confirm Password</label>
      <input type="password" name="confirm" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-pink-400">
    </div>

    <button type="submit" class="w-full py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-lg font-semibold text-white transition-all">
      <i data-lucide="check-circle" class="h-5 w-5 inline-block mr-2"></i> Update Password
    </button>
  </form>
  <?php endif; ?>
</div>

<script>lucide.createIcons();</script>
</body>
</html>

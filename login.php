<?php
session_start();
require_once __DIR__ . '/backend/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | EduPath</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white font-sans">

<div class="max-w-md w-full mx-4 bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl">
  <div class="text-center mb-8">
    <i data-lucide="brain" class="h-12 w-12 text-cyan-400 mx-auto mb-3"></i>
    <h1 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 gradient-text">Welcome Back</h1>
    <p class="text-gray-400 mt-2">Log in to continue your EduPath journey</p>
  </div>

  <?php if ($error): ?>
    <div class="mb-4 bg-red-500/20 text-red-300 border border-red-400/30 px-4 py-2 rounded-lg text-sm text-center">
      <?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>

  <form method="POST" class="space-y-5">
    <div>
      <label class="block text-gray-300 mb-2">Email</label>
      <input type="email" name="email" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-400">
    </div>

    <div>
      <label class="block text-gray-300 mb-2">Password</label>
      <input type="password" name="password" required class="w-full p-3 bg-black/30 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-purple-400">
    </div>

    <button type="submit" class="w-full py-3 bg-gradient-to-r from-cyan-600 to-purple-600 hover:from-cyan-700 hover:to-purple-700 rounded-lg font-semibold text-white transition-all">
      <i data-lucide="log-in" class="h-5 w-5 inline-block mr-2"></i> Log In
    </button>
  </form>

  <p class="text-center text-gray-400 text-sm mt-6">
    Don't have an account?
    <a href="register.php" class="text-cyan-400 hover:underline">Register here</a>
  </p>
</div>

<script>lucide.createIcons();</script>
</body>
</html>

<?php
session_start();

// Destroy the session only if user confirmed logout
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
  session_unset();
  session_destroy();
  header("Refresh: 2; url=login.php"); // Redirect after showing success message
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout – EduPath</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      font-family: "Inter", sans-serif;
      background: linear-gradient(135deg, #0f172a, #3b0764);
      color: white;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: opacity 0.3s ease;
    }

    .card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      backdrop-filter: blur(10px);
      padding: 2rem;
      width: 90%;
      max-width: 420px;
      text-align: center;
      animation: fadeIn 0.4s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.75rem 1.25rem;
      border-radius: 10px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    .btn-yes {
      background: linear-gradient(to right, #22c55e, #16a34a);
    }

    .btn-no {
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .success-box {
      display: none;
      flex-direction: column;
      align-items: center;
      text-align: center;
      animation: fadeIn 0.4s ease forwards;
    }

    .success-icon {
      width: 60px;
      height: 60px;
      background: rgba(34, 197, 94, 0.2);
      border: 2px solid #22c55e;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
    }
  </style>
</head>

<body>
  <div class="card" id="confirmBox">
    <i data-lucide="log-out" class="w-12 h-12 text-purple-400 mx-auto mb-4"></i>
    <h2 class="text-2xl font-bold mb-4">Are you sure you want to log out?</h2>
    <div class="flex justify-center space-x-4">
      <button class="btn btn-yes" onclick="logoutUser()">Yes</button>
      <button class="btn btn-no" onclick="window.location.href='index.php'">Cancel</button>
    </div>
  </div>

  <div class="success-box" id="successBox">
    <div class="success-icon">
      <i data-lucide="check" class="text-green-400 w-8 h-8"></i>
    </div>
    <h2 class="text-2xl font-bold text-green-400 mb-2">Successfully Logged Out</h2>
    <p class="text-gray-300">...</p>
  </div>

  <script>
    lucide.createIcons();

    function logoutUser() {
      // Show success box
      document.getElementById('confirmBox').style.display = 'none';
      document.getElementById('successBox').style.display = 'flex';

      // Redirect after 2 seconds
      setTimeout(() => {
        window.location.href = 'logout.php?confirm=yes';
      }, 2000);
    }
  </script>
</body>
</html>

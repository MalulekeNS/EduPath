<?php
session_start();
echo json_encode(['active' => isset($_SESSION['user_id'])]);

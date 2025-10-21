import express from "express";
import pool from "../db.js";
const router = express.Router();

// Get quizzes
router.get("/", async (req, res) => {
  try {
    const conn = await pool.getConnection();
    const rows = await conn.query("SELECT * FROM quizzes ORDER BY created_at DESC");
    conn.end();
    res.json(rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Add quiz
router.post("/", async (req, res) => {
  const { user_id, title, total_questions, score } = req.body;
  try {
    const conn = await pool.getConnection();
    await conn.query(
      "INSERT INTO quizzes (user_id, title, total_questions, score) VALUES (?, ?, ?, ?)",
      [user_id, title, total_questions, score]
    );
    conn.end();
    res.json({ message: "Quiz created successfully" });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

export default router;

import express from "express";
import pool from "../db.js";
const router = express.Router();

router.get("/", async (req, res) => {
  try {
    const conn = await pool.getConnection();
    const rows = await conn.query("SELECT * FROM career_suggestions ORDER BY created_at DESC");
    conn.end();
    res.json(rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.post("/", async (req, res) => {
  const { user_id, title, description, match_percentage, skills, salary, growth } = req.body;
  try {
    const conn = await pool.getConnection();
    await conn.query(
      "INSERT INTO career_suggestions (user_id, title, description, match_percentage, skills, salary, growth) VALUES (?, ?, ?, ?, ?, ?, ?)",
      [user_id, title, description, match_percentage, skills, salary, growth]
    );
    conn.end();
    res.json({ message: "Career suggestion added" });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

export default router;

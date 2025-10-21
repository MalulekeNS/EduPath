import express from "express";
import pool from "../db.js";
const router = express.Router();

// Fetch announcements
router.get("/", async (req, res) => {
  try {
    const conn = await pool.getConnection();
    const rows = await conn.query("SELECT * FROM announcements ORDER BY posted_on DESC");
    conn.end();
    res.json(rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Add announcement
router.post("/", async (req, res) => {
  const { title, category, content, author } = req.body;
  try {
    const conn = await pool.getConnection();
    await conn.query(
      "INSERT INTO announcements (title, category, content, posted_on, author) VALUES (?, ?, ?, NOW(), ?)",
      [title, category, content, author]
    );
    conn.end();
    res.json({ message: "Announcement created successfully" });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

export default router;

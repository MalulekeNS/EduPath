import express from "express";
import cors from "cors";
import dotenv from "dotenv";

import userRoutes from "./routes/users.js";
import quizRoutes from "./routes/quizzes.js";
import careerRoutes from "./routes/careers.js";
import announcementRoutes from "./routes/announcements.js";

dotenv.config();
const app = express();

app.use(cors());
app.use(express.json());

// Routes
app.use("/api/users", userRoutes);
app.use("/api/quizzes", quizRoutes);
app.use("/api/careers", careerRoutes);
app.use("/api/announcements", announcementRoutes);

// Health check
app.get("/", (req, res) => {
  res.json({ message: "EduPath API running ✅" });
});

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`🚀 Server running on port ${PORT}`));

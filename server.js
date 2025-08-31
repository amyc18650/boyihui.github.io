// server.js
const express = require('express');
const fetch = require('node-fetch');
const app = express();

const API_KEY = 'c55bdf268950426faf49aff8c9aca36f'; // 替换为你的 football-data.org Key



// 提供 index.html
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});

// 最近 5 场英超比赛
app.get('/api/matches', async (req, res) => {
  try {
    const response = await fetch(
      'https://api.football-data.org/v4/matches?competitions=PL&status=FINISHED&limit=5',
      { headers: { 'X-Auth-Token': API_KEY } }
    );
    const data = await response.json();
    res.json(data);
  } catch (err) {
    res.status(500).json({ error: '获取比赛数据失败' });
  }
});

// 英超积分榜
app.get('/api/standings', async (req, res) => {
  try {
    const response = await fetch(
      'https://api.football-data.org/v4/competitions/PL/standings',
      { headers: { 'X-Auth-Token': API_KEY } }
    );
    const data = await response.json();
    res.json(data);
  } catch (err) {
    res.status(500).json({ error: '获取积分榜失败' });
  }
});

app.listen(3000, () => console.log('Server running at http://localhost:3000'));

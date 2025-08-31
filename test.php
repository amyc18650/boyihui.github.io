<?php
// 配置你的 football-data.org API Key
$apiKey = "c55bdf268950426faf49aff8c9aca36f";

// 封装函数获取 API 数据
function getFootballData($url, $apiKey) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Auth-Token: $apiKey"]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// 最近 5 场英超比赛
$matchesUrl = "https://api.football-data.org/v4/matches?competitions=PL&status=FINISHED&limit=5";
$matches = getFootballData($matchesUrl, $apiKey);

// 英超积分榜
$standingsUrl = "https://api.football-data.org/v4/competitions/PL/standings";
$standings = getFootballData($standingsUrl, $apiKey);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<title>英超比赛与积分榜</title>
<style>
  body { background:#121212; color:#fff; font-family:Arial, sans-serif; margin:20px; }
  h2 { text-align:center; margin:20px 0; }
  .card { background:#1e1e1e; padding:15px; border-radius:10px; margin-bottom:20px; box-shadow:0 0 10px rgba(0,0,0,0.5); }
  .match, .team { padding:8px; border-bottom:1px solid #333; }
  .team:last-child, .match:last-child { border-bottom:none; }
  .score { font-weight:bold; color:#4caf50; margin:0 10px; }
</style>
</head>
<body>

<h2>最近 5 场英超比赛结果</h2>
<div class="card">
<?php if (isset($matches['matches'])): ?>
  <?php foreach ($matches['matches'] as $m): ?>
    <div class="match">
      <?= htmlspecialchars($m['homeTeam']['name']) ?>
      <span class="score"><?= $m['score']['fullTime']['home'] ?> - <?= $m['score']['fullTime']['away'] ?></span>
      <?= htmlspecialchars($m['awayTeam']['name']) ?>
      <div style="font-size:12px; color:#aaa;">
        <?= date("Y-m-d", strtotime($m['utcDate'])) ?>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div>暂无比赛数据</div>
<?php endif; ?>
</div>

<h2>英超积分榜</h2>
<div class="card">
<?php if (isset($standings['standings'][0]['table'])): ?>
  <?php foreach ($standings['standings'][0]['table'] as $t): ?>
    <div class="team">
      <?= $t['position'] ?>. <?= htmlspecialchars($t['team']['name']) ?> - <?= $t['points'] ?> 分
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div>暂无积分榜数据</div>
<?php endif; ?>
</div>

</body>
</html>

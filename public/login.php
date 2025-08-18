<?php
require_once __DIR__ . '/../lib/Auth.php';
session_start();
$msg = null; $ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
  [$ok,$res] = Auth::login($_POST['username'], $_POST['password']);
  $msg = $ok ? 'Login successful.' : $res;
  if($ok){ header('Location: /catalogue.php'); exit; }
}
require_once __DIR__ . '/../templates/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">
<?php if($msg): ?><div class="alert <?= $ok?'ok':'err' ?>"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<form class="form" method="post">
  <div class="input"><label>Username</label><input name="username" required></div>
  <div class="input"><label>Password</label><input type="password" name="password" required></div>
  <button class="btn">Login</button>
</form>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>
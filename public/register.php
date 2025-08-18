<?php
require_once __DIR__ . '/../lib/Auth.php';
session_start();
$msg = null; $ok=false;
if($_SERVER['REQUEST_METHOD']==='POST'){
  [$ok,$res] = Auth::register($_POST['full_name'], $_POST['email'], $_POST['username'], $_POST['password']);
  $msg = $ok ? 'Registration successful. You may login now.' : $res;
}
require_once __DIR__ . '/../templates/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">
<?php if($msg): ?><div class="alert <?= $ok?'ok':'err' ?>"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<form class="form" method="post">
  <div class="input"><label>Full Name</label><input name="full_name" required></div>
  <div class="input"><label>Email</label><input type="email" name="email" required></div>
  <div class="input"><label>Username</label><input name="username" required></div>
  <div class="input"><label>Password</label><input type="password" name="password" required></div>
  <button class="btn">Register</button>
</form>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>
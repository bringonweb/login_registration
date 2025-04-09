<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard</a>
            <div class="navbar-nav">
                <a class="nav-link" href="<?= base_url('welcome/logout') ?>">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if($this->session->userdata('UserLoginSession')): ?>
            <?php $user = $this->session->userdata('UserLoginSession'); ?>
            <div class="alert alert-success">
                Welcome, <?= $user['username'] ?> (<?= $user['email'] ?>)
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                Session expired. Please login again.
            </div>
            <?php redirect(base_url('welcome/login')); ?>
        <?php endif; ?>
    </div>
</body>
</html>
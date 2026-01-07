<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
<center>
<h1>Admin Dashboard</h1>
<p>Welcome, <?= htmlspecialchars($username) ?></p>

<ul>
    <li><a href="/admin/news">Manage News</a></li>
    <li><a href="/admin/users">Manage Users</a></li>
</ul>

<a href="/auth/logout">Logout</a>
</center>
</body>
</html>

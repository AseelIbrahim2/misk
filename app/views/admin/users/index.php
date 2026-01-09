<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
</head>
<body>
<center>
<h1>Users List</h1>

<a href="/admin/users/create">Add New User</a>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Roles</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td>
            <?= isset($user['roles']) && is_array($user['roles']) ? implode(', ', $user['roles']) : '—' ?>
        </td>
        <td>
            <a href="/admin/users/edit/<?= $user['id'] ?>">Edit</a> |
            <a href="/admin/users/delete/<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</center>
</body>
</html>

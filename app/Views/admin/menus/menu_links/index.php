<h1>Links for <?= $menu['title'] ?></h1>
<a href="/menu-links/create/<?= $menu['id'] ?>" class="btn btn-success mb-2">Add Link</a>

<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>URL</th>
    <th>Parent</th>
    <th>Order</th>
    <th>Active</th>
    <th>Target</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach($links as $link): ?>
<tr>
    <td><?= $link['id'] ?></td>
    <td><?= $link['title'] ?></td>
    <td><?= $link['url'] ?></td>
    <td><?= $link['parent_id'] ?: '-' ?></td>
    <td><?= $link['order'] ?></td>
    <td><?= $link['is_active'] ? 'Yes' : 'No' ?></td>
    <td><?= $link['target'] ?></td>
    <td>
        <a href="/menu-links/edit/<?= $link['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <form action="/menu-links/delete/<?= $link['id'] ?>" method="POST" style="display:inline-block;">
            <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<center>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="usernameOrEmail" placeholder="Username or Email" required /><br/>
    <input type="password" name="password" placeholder="Password" required /><br/>
    <button type="submit">Login</button>
</form>
<a href="/auth/register">Register</a>
</center>

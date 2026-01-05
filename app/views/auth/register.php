<center>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required /><br/>
    <input type="email" name="email" placeholder="Email" required /><br/>
    <input type="password" name="password" placeholder="Password" required /><br/>
    <button type="submit">Register</button>
</form>
<a href="/auth/login">Login</a>
</center>

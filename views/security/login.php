<div class="content">
    <div class="navigation">
        <a href="/login">Login</a>
    </div>
    <div class="standard-form">
        <h2>Login</h2>
        <br />
        <form action="/login" method="post">
            <label for="Username">
                Username<br />
                <input class="text" name="username" style="width: 25em;" type="text" />
            </label>
            <label for="password">
                Password<br />
                <input class="text" name="password" style="width: 25em;" type="password" />
            </label>
            <label>
                <button type="submit" class="button">
                    <span>Log In</span>
                </button>
            </label>
        </form>  
    </div>
    <div class="standard-form help">
        <b>Forget your password?</b><br />
        <br />
        <a href="password-reset.php">Click here to reset your password.</a>
    </div>
</div>
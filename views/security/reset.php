<div class="content">
    <div class="navigation">
        <a href="/login">Login</a> / <a href="/login/password">Reset Password</a>
    </div>
    <div class="standard-form">
        <h2>Reset Password</h2>
        <br />
        <form action="/login/reset" method="post">
            <label for="Username">
                Email Address<br />
                <input class="text" name="email" style="width: 25em;" type="text" />
            </label>
            <label>
                <button type="submit" class="button">
                    <span>Reset</span>
                </button>
            </label>
        </form>  
    </div>
</div>
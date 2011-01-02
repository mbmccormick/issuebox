<div class="content">
    <div class="navigation">
        <a href="/login">Login</a> / <a href="/login/password">Reset Password</a>
    </div>
    <table cellpadding="0" cellspacing="0" style="width: 100%;">
        <tr valign="top">
            <td style="width: 50%;">
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
            </td>
            <td>
                <div class="spacer" style="width: 20px;">
                    &nbsp;
                </div>
            </td>
            <td style="width: 50%;">
                <div class="standard-form help">
                    <b>Forget your password?</b><br />
                    <br />
                    Enter your email address in the form on the left and we will email you a new password that you can use to log in to your account.
                </div>
            </td>
        </tr>
    </table>
</div>
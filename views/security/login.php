<div class="content">
    <div class="navigation">
        <a href="/login">Login</a>
    </div>
    <table cellpadding="0" cellspacing="0" style="width: 100%;">
        <tr valign="top">
            <td style="width: 50%;">
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
            </td>
            <td>
                <div class="spacer" style="width: 20px;">
                    &nbsp;
                </div>
            </td>
            <td style="width: 50%;">
                <div class="standard-form help">
                    <b>Need an account?</b><br />
                    <br />
                    <a href="mailto:<?php echo RetrieveSetting("OutgoingEmailAddress"); ?>">Click here to contact your administrator.</a>
                </div>
                <div class="standard-form help">
                    <b>Forget your password?</b><br />
                    <br />
                    <a href="/login/reset">Click here to reset your password.</a>
                </div>
            </td>
        </tr>
    </table>
</div>
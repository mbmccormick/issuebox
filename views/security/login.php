<div class="content">
    <div class="login-form">
        <table cellpadding="0" cellspacing="0" style="width: 100%;">
            <tr>
                <td align="left" valign="middle">
                    <h2><a href="/">Issuebox</a></h2>
                </td>
                <td align="right" valign="middle">
                    &nbsp;
                </td>
            </tr>
        </table>
        <br />
        <form id="login" action="/login" method="post">
            <label for="Username">
                Username<br />
                <input class="text" name="username" style="width: 290px;" type="text" />
            </label>
            <label for="password">
                Password <small>(<a href="/login/reset">Trouble logging in?</a>)</small><br />
                <input class="text" name="password" style="width: 290px;" type="password" />
            </label>
            <input name="identity" type="hidden" value="<?=$identity?>" />
            <br />
            <br />
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td align="left" valign="middle">
                        <button type="submit" class="button">
                            <span>Log In</span>
                        </button>
                    </td>
                    <td align="right" valign="middle">
                        <small><img src="/public/img/google.png" id="google" /><a onclick="authenticateOpenID()" href="#">Log In with your Google Account</a></small>
                    </td>
                </tr>
            </table>
        </form>  
    </div>
</div>

<script type="text/javascript">

    function authenticateOpenID()
    {
        document.getElementById("login").action = "/login/openid/google";
        document.getElementById("login").submit();
    }

</script>
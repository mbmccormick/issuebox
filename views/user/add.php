<div class="content">
    <div class="navigation">
        <a href="/user">Users</a> / <a href="/user/add">New User</a>
    </div>
    <table cellpadding="0" cellspacing="0" style="width: 100%;">
        <tr valign="top">
            <td style="width: 50%;">
                <div class="list">
                    <form id="user-new" action="/user/add" method="post">
                        <div class="list-item user">
                            <h3>New User</h3>
                            <br />
                            <b>Username</b><br />
                            <input type="text" name="username" style="width: 333px;" /><br />
                            <br />
                            <b>Email</b><br />                    
                            <input type="text" name="email" style="width: 333px;" /><br />
                            <br />
                            <br />
                            <b>Password</b><br />                    
                            <input type="password" name="password" style="width: 333px;" /><br />
                            <br />
                            <b>Confirm Password</b><br />                    
                            <input type="password" name="passwordconfirm" style="width: 333px;" /><br />
                            <br />
                            <br />
                            <input type="checkbox" name="isadministrator" value="1" /> <b>Is Administrator</b>
                        </div>
                        <br />
                        <button type="submit" class="button">
                            <span>Create User</span>
                        </button>
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
                    <b>Displaying avatars from Gravatar</b><br />
                    <br />
                    This email address well be used to display this user's avatar from <a href="http://www.gravatar.com/" target="_blank">Gravatar</a>.
                </div>
                <div class="standard-form help">
                    <b>Double check this email address</b><br />
                    <br />
                    This user must be able to receive email at this address in order to reset their password.
                </div>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    
    $("#user-new").submit(function validate() {
        var formData = $("#user-new").serializeArray();
        for (var i=0; i < formData.length; i++) { 
            if (!formData[i].value) { 
                $(document).showMessage({
                    thisMessage: ["Please complete all fields, check your input, and try again."],
                    className: "error",
                    opacity: 95,
                    displayNavigation: false,
                    autoClose: true,
                    delayTime: 5000
                });
                
                return false;
            }
        }
    });
    
</script>

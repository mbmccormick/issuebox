<div class="content">
    <div class="navigation">
        <a href="settings.php">Settings</a> / <a href="user.php">Users</a> / <a href="user-add.php">New User</a>
    </div>
    <div class="list">
        <form id="user-new" action="/user/add" method="post">
            <div class="list-item user">
                <h3>New User</h3>
                <br />
                <b>Username</b><br />
                <input type="text" name="username" style="width: 710px;" /><br />
                <br />
                <b>Email</b><br />                    
                <input type="text" name="email" style="width: 710px;" /><br />
                <br />
                <br />
                <b>Password</b><br />                    
                <input type="password" name="password" style="width: 710px;" /><br />
                <br />
                <b>Confirm Password</b><br />                    
                <input type="password" name="passwordconfirm" style="width: 710px;" /><br />
            </div>
            <br />
            <button type="submit" class="button">
                <span>Create User</span>
            </button>
        </form>
    </div>
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

<div class="content">
    <div class="navigation">
        <a href="/user">Users</a> / <a href="/user/<?=$user[id]?>/edit">Edit User</a>
    </div>
    <div class="list">
        <form id="user-edit" action="/user/<?=$user[id]?>/edit" method="post">
            <div class="list-item user">
                <h3>Edit User</h3>
                <br />
                <b>Username</b><br />
                <input type="text" name="username" style="width: 710px;" value="<?=$user[username]?>" /><br />
                <br />
                <b>Email</b><br />                    
                <input type="text" name="email" style="width: 710px;" value="<?=$user[email]?>" /><br />
                <br />
                <br />
                <b>Current Password</b><br />                    
                <input type="password" name="currentpassword" style="width: 710px;" /><br />
                <br />
                <br />
                <b>New Password</b><br />                    
                <input type="password" name="newpassword" style="width: 710px;" /><br />
                <br />
                <b>Confirm New Password</b><br />                    
                <input type="password" name="newpasswordconfirm" style="width: 710px;" /><br />
            </div>
            <br />
            <button type="submit" class="button">
                <span>Save User</span>
            </button>
            <button type="button" class="button danger" onclick="confirm('Are you sure you want to delete this user?') ? location.href='/user/<?=$user[id]?>/delete' : false;">
                <span>Delete</span>
            </button>
        </form>
    </div>
</div>
<script type="text/javascript">
    
    $("#user-edit").submit(function validate() {
        var formData = $("#user-edit").serializeArray();
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

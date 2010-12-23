<div class="content">
    <div class="navigation">
        <a href="/user">Users</a> / <a href="/user/<?=$user[id]?>"><?=$user[username]?></a>
    </div>
    <div class="list">
        <div class="list-item user">                    
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td valign="middle">
                        <img src="http://www.gravatar.com/avatar/<?=md5($user[email])?>?s=45" style="background-color: #ffffff; padding: 2px; border: solid 1px #dddddd;" />
                    </td>
                    <td>
                        &nbsp;&nbsp;
                    </td>
                    <td valign="middle" style="width: 100%;">
                        <h3><a href="/user/<?=$user[id]?>"><?=$user[username]?></a></h3>
                        <p>Created on <?=date("F j, Y", strtotime($user[createddate]))?></p>
                    </td>
                    </tr>
            </table>        
        </div>
        <?=$body?>
        <button type="button" class="button" onclick="location.href='/user/<?=$user[id]?>/edit';">
            <span>Edit User</span>
        </button>
        <button type="button" class="button danger" onclick="confirm('Are you sure you want to delete this user?') ? location.href='/user/<?=$user[id]?>/delete' : false;">
            <span>Delete</span>
        </button>
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

<div class="content">
    <div class="navigation">
        <a href="/">Projects</a> / <a href="/project/<?=$project[id]?>"><?=$project[name]?></a> / <a href="/issue/<?=$issue[id]?>/edit">Edit Issue</a>
    </div>
    <div class="list">
        <form id="issue-edit" action="/issue/<?=$issue[id]?>/edit" method="post">
            <div class="list-item issue">
                <table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td valign="middle">
                            <h3>Edit Issue</h3>
                        </td>
                        <td valign="middle" align="right">
                            <small>Issues are parsed with <a target="_blank" href="https://github.com/github/github-flavored-markdown">GitHub Flavored Markdown</a></small>
                        </td>
                    </tr>
                </table>
                <br />
                <b>Title</b><br />
                <input type="text" name="title" style="width: 710px;" value="<?=$issue[title]?>" /><br />
                <br />
                <b>Body</b><br />                    
                <textarea name="body" style="width: 710px;" rows="8"><?=$issue[body]?></textarea>
                <br />
                <p class="checkbox">
                    <input type="checkbox" name="isurgent" value="1" <?php if ($issue[isurgent] == "1") { echo "checked='checked'"; } ?> /> This is an urgent issue
                </p>
            </div>
            <br />
            <button type="submit" class="button">
                <span>Save Issue</span>
            </button>
            <button type="button" class="button danger" onclick="confirm('Are you sure you want to delete this issue and all of its comments?') ? location.href='issue-delete.php?id=<?=$_GET[id]?>' : false;">
                <span>Delete</span>
            </button>
        </form>
    </div>
</div>
<script type="text/javascript">
    
    $("#issue-edit").submit(function validate() {
        var formData = $("#issue-edit").serializeArray();
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

<div class="content">
    <table cellpadding="0" cellspacing="0" style="width: 100%; padding-bottom: 20px;">
        <tr>
            <td valign="middle">
                <div class="navigation" style="padding: 0px;">
                    <a href="index.php">Projects</a> / <a href="project.php?id=<?=$project[id]?>"><?=$project[name]?></a>
                </div>
            </td>
            <td valign="middle" align="right">
                <div class="filter">
                    <a class="filter-on open-indicator" title="Click here to hide open issues."><span>Open</span></a>
                    <a class="filter-off closed-indicator" title="Click here to show closed issues."><span>Closed</span></a>
                </div>
            </td>
        </tr>
    </table>
    <div class="list">
        <script type="text/javascript">            
            var converter = new Showdown.converter();            
        </script>
        <?=$body?>
        <div class="list-item issue none" style="display: none;">
            <p>There are no issues to display for this project.</p>
        </div>
        <div class="list-holder">
        </div>
        <div class="list-item issue-new">
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td valign="middle">
                        <h3>New Issue</h3>
                    </td>
                    <td valign="middle" align="right">
                        <small>Issues are parsed with <a target="_blank" href="https://github.com/github/github-flavored-markdown">GitHub Flavored Markdown</a></small>
                    </td>
                </tr>
            </table>
            <br />
            <form id="issue-new" action="issue-add.php?projectid=<?=$project[id]?>" method="post">
                <b>Title</b><br />
                <input type="text" name="title" style="width: 710px;" /><br />
                <br />
                <b>Body</b><br />                    
                <textarea name="body" style="width: 710px;" rows="6"></textarea>
                <br />
                <p class="checkbox">
                    <input type="checkbox" name="isurgent" value="1" /> This is an urgent issue
                </p>
                <br />
                <button type="submit" class="button">
                    <span>Create Issue</span>
                </button>
            </form>
        </div>
        <br />
        <button type="button" class="button" onclick="location.href='project-edit.php?id=<?=$project[id]?>';">
            <span>Edit Project</span>
        </button>
        <button type="button" class="button danger" onclick="confirm('Are you sure you want to delete this project and all of its issues?') ? location.href='project-delete.php?id=<?=$project[id]?>' : false;">
            <span>Delete</span>
        </button>
    </div>        
</div>
<script type="text/javascript"> 

    $(document).ready(function() { 
        $(".filter a").click(onFilterDisplayClick);
        
        checkDisplayNone();
        
        $("#issue-new").ajaxForm({ 
            data: { returnObject: "true" },
            beforeSubmit: onIssueNewSubmit,
            success: onIssueNewSuccess
        }); 
    });
    
    function onFilterDisplayClick() {
        var sender = $(this);
        
        if (sender.attr("class") == "filter-on open-indicator") {
            sender.attr("class", "filter-off open-indicator");
            $(".open").fadeOut();
        }
        else if (sender.attr("class") == "filter-off open-indicator") {
            sender.attr("class", "filter-on open-indicator");
            $(".open").fadeIn();
        }
        else if (sender.attr("class") == "filter-on closed-indicator") {
            sender.attr("class", "filter-off closed-indicator");
            $(".closed").fadeOut();
        }
        else if (sender.attr("class") == "filter-off closed-indicator") {
            sender.attr("class", "filter-on closed-indicator");
            $(".closed").fadeIn();
        }
        
        checkDisplayNone();
    }
    
    function onIssueNewSubmit(formData, jqForm, options) {
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
    }
    
    function onIssueNewSuccess(responseText, statusText, xhr, $form) { 
        $(".list-holder").append(responseText);
        $(".list-holder .list-item").last().hide().fadeIn();
        $("#issue-new input[name=title]").val("");
        $("#issue-new textarea[name=body]").val("");
        
        $(document).showMessage({
            thisMessage: ["Your issue was created successfully!"],
            className: "success",
            opacity: 95,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
        });
    }
    
    function checkDisplayNone() {
        if ($(".closed:visible").length == 0 && $(".open:visible").length == 0)
        {
            $(".none").show();
        }
        else
        {
            $(".none").hide();
        }
    }
    
</script>

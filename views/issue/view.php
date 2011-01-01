<div class="content">
    <div class="navigation">
        <a href="/">Projects</a> / <a href="/project/<?=$project[id]?>"><?=$project[name]?></a> / <a href="/issue/<?=$issue[id]?>">Issue #<?=$issue[number]?></a>
    </div>
    <div class="list"> 
        <script type="text/javascript">            
            var converter = new Showdown.converter();            
        </script>
        <div class="list-item issue">
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td valign="middle">
                        <h3>#<?=$issue[number]?>&nbsp;&nbsp;<a href="/issue/<?=$issue[id]?>"><?=$issue[title]?></a></h3>
                    </td>
                    <td valign="middle" align="right">
                        <?php
                            
                            if ($issue[isurgent] == "1")
                                echo "<em class='urgent-indicator'>Urgent</em>";
                            else
                                echo "<em class='urgent-indicator' style='display: none;'>Urgent</em>";
                        
                            if ($issue[isclosed] == "1")
                                echo "<em class='closed-indicator'>Closed</em>";
                            else
                                echo "<em class='closed-indicator' style='display: none;'>Closed</em>";
                        
                        ?>
                    </td>
                </tr>
            </table>
            <div id="issue<?=$issue[number]?>" class="wikiStyle"><?=$issue[body]?></div>
            <br />
            <div class="options">
                <span class="date">Created about <?=FriendlyDate(1, strtotime($issue[createddate])); ?></span> by <a href="/user/<?=$user[id]?>"><?=$user[username]?></a>
            </div>
            <script type="text/javascript">
                document.getElementById("issue<?=$issue[number]?>").innerHTML = converter.makeHtml(document.getElementById("issue<?=$issue[number]?>").innerHTML);
            </script>
        </div>
        <?=$body?>
        <?php if ($issue[isclosed] == "0") { ?>
        <div class="list-holder">
        </div>
        <div class="list-item comment-new">
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td valign="middle">
                        <h3>New Comment</h3>
                    </td>
                    <td valign="middle" align="right">
                        <small>Comments are parsed with <a target="_blank" href="https://github.com/github/github-flavored-markdown">GitHub Flavored Markdown</a></small>
                    </td>
                </tr>
            </table>
            <br />
            <form id="comment-new" action="/comment/add&issueid=<?=$issue[id]?>" method="post">
                <textarea name="body" style="width: 710px;" rows="6"></textarea>
                <br />
                <br />
                <div class="form-actions">
                    <button type="submit" name="commentandclose" class="button">
                        <span>Comment &amp; Close</span>
                    </button>
                    <button type="submit" name="comment" class="button">
                        <span>Comment</span>
                    </button>
                </div>
            </form>
        </div>
        <?php } else { ?>
        <div class="list-item comment-new">
            <p>This issue is closed, and no more comments can be added.</p>
        </div>
        <?php } ?>
        <br />
        <button type="button" class="button" onclick="location.href='/issue/<?=$issue[id]?>/edit';">
            <span>Edit Issue</span>
        </button>
        <button type="button" class="button danger" onclick="confirm('Are you sure you want to delete this issue and all of its comments?') ? location.href='/issue/<?=$issue[id]?>/delete' : false;">
            <span>Delete</span>
        </button>
    </div>        
</div>
<script type="text/javascript"> 

    $(document).ready(function() { 
        $(".comment > .options > a.minibutton").click(onCommentDeleteClick);
        
        $("#comment-new").ajaxForm({ 
            data: { returnObject: "true" },
            beforeSubmit: onCommentNewSubmit,
            success: onCommentNewSuccess
        });
    });
    
    function onCommentDeleteClick() {
        var sender = $(this).parent().parent();
        if (confirm("Are you sure you want to delete this comment?") == true)
        {
            $.get($(this).attr("postback"), function(data) {
                sender.fadeOut();
                
                $(document).showMessage({
                    thisMessage: ["Your comment was deleted successfully!"],
                    className: "success",
                    opacity: 95,
                    displayNavigation: false,
                    autoClose: true,
                    delayTime: 5000
                });
            });
        }
    }
    
    function onCommentNewSubmit(formData, jqForm, options) {
        var formData = $("#comment-new").serializeArray();
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
    
    function onCommentNewSuccess(responseText, statusText, xhr, $form) { 
        $(".list-holder").append(responseText);
        $(".list-holder .list-item").last().hide().fadeIn();
        $("#comment-new").resetForm();
        
        if ($("#issue-closed").length == 0)
        {
            $(document).showMessage({
                thisMessage: ["Your comment was created successfully!"],
                className: "success",
                opacity: 95,
                displayNavigation: false,
                autoClose: true,
                delayTime: 5000
            });
        }
        else
        {
            $(document).showMessage({
                thisMessage: ["Your comment was created successfully and this issue is now closed!"],
                className: "success",
                opacity: 95,
                displayNavigation: false,
                autoClose: true,
                delayTime: 5000
            });
            
            $(".comment-new").hide();
            $(".list-holder").append("<div class='list-item comment-new'><p>This issue is closed, and no more comments can be added.</p></div>").hide().fadeIn();
            $(".closed-indicator").fadeIn();
        }
        
        $(".comment > .options > a.minibutton").unbind();
        $(".comment > .options > a.minibutton").click(onCommentDeleteClick);
    }

</script>

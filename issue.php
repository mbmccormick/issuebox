<?php

    require "config.php";
    require "utils.php";
    require_once "security.php";
    
    authorize();
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);   
    
    $result = mysql_query("SELECT * FROM issue WHERE id = '$_GET[id]' ORDER BY id ASC");
    $issue = mysql_fetch_array($result);

    $result = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
    $project = mysql_fetch_array($result);
   
    $result = mysql_query("SELECT * FROM user WHERE id = '$issue[createdby]'");
    $user = mysql_fetch_array($result);
 
?>
<?php include "header.php"; ?>
    <?php SetPageTitle("Issue #" . $issue[number]); ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Projects</a> / <a href="project.php?id=<?php echo $project[id]; ?>"><?php echo $project[name]; ?></a> / <a href="issue.php?id=<?php echo $issue[id]; ?>">Issue #<?php echo $issue[number]; ?></a>
        </div>
        <div class="list"> 
            <script type="text/javascript">            
                var converter = new Showdown.converter();            
            </script>
            <div class="list-item issue">
                <table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td valign="middle">
                            <h3>#<?php echo $issue[number]; ?>&nbsp;&nbsp;<a href="issue.php?id=<?php echo $issue[id]; ?>"><?php echo $issue[title]; ?></a></h3>
                        </td>
                        <td valign="middle" align="right">
                            <?php
                            
                                if ($issue[isclosed] == "1")
                                    echo "<em class='closed-indicator'>Closed</span>";
                                else
                                    echo "<em class='closed-indicator' style='display: none;'>Closed</span>";
                            
                            ?>
                        </td>
                    </tr>
                </table>
                <div id="issue<?php echo $issue[number]; ?>" class="wikiStyle"><?php echo $issue[body]; ?></div>
                <br />
                <div class="options">
                    <a class="minibutton" href='issue-edit.php?id=<?php echo $issue[id]; ?>'><span>Edit</span></a>
                    <a class="minibutton" onclick="return confirm('Are you sure you want to delete this issue and all of its comments?');" href='issue-delete.php?id=<?php echo $issue[id]; ?>&projectid=<?php echo $issue[projectid]; ?>'><span>Delete</span></a>
                    &nbsp;&nbsp;<span class="date">Created about <?php echo FriendlyDate(1, strtotime($issue[createddate])); ?></span> by <a href="user-edit.php?id=<?php echo $user[id]; ?>"><?php echo $user[username]; ?></a>
                </div>
                <script type="text/javascript">
                    document.getElementById("issue<?php echo $issue[number]; ?>").innerHTML = converter.makeHtml(document.getElementById("issue<?php echo $issue[number]; ?>").innerHTML);
                </script>
            </div>
            <?php

                $result = mysql_query("SELECT * FROM comment WHERE issueid = '$issue[id]' ORDER BY id ASC");
                while($row = mysql_fetch_array($result))
                {
                    $sql = mysql_query("SELECT id, username FROM user WHERE id = '$row[createdby]'");
                    $user = mysql_fetch_array($sql);
                    
                    echo "<div class='list-item comment'>\n";
                    
                    echo "<div id='comment$row[id]' class='wikiStyle'>" . $row[body] . "</div>\n";
                    echo "<br />\n";
                    echo "<div class='options'>\n";
                    echo "<a class='minibutton' postback='comment-delete.php?id=$row[id]&issueid=$row[issueid]'><span>Delete</span></a>\n";
                    echo "&nbsp;&nbsp;" . date("F j, Y", strtotime($row[createddate]));
                    echo " by <a href='user-edit.php?id=$user[id]'>$user[username]</a>";
                    echo "</div>\n";
                    
                    echo "<script type='text/javascript'>\n";
                    echo "document.getElementById('comment$row[id]').innerHTML = converter.makeHtml(document.getElementById('comment$row[id]').innerHTML);\n";
                    echo "</script>\n";
                    
                    echo "</div>\n";
                }

            ?>
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
                <form id="comment-new" action="comment-add.php?issueid=<?php echo $issue[id]; ?>" method="post">
                    <textarea name="body" style="width: 710px;" rows="8"></textarea>
                    <br />
                    <br />
                    <button type="submit" name="comment" class="button">
                        <span>Comment</span>
                    </button>
                    <button type="submit" name="commentandclose" class="button">
                        <span>Comment &amp; Close</span>
                    </button>
                </form>
            </div>
            <?php } else { ?>
            <div class="list-item comment-new">
                <p>This issue is closed, and no more comments can be added.</p>
            </div>
            <?php } ?>
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
                        opacity: 100,
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
                        opacity: 100,
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
            $(".list-holder .list-item").last().hide().slideDown();
            $("#comment-new").resetForm();
            
            if ($("#issue-closed").length == 0)
            {
                $(document).showMessage({
                    thisMessage: ["Your comment was created successfully!"],
                    className: "success",
                    opacity: 100,
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
                    opacity: 100,
                    displayNavigation: false,
                    autoClose: true,
                    delayTime: 5000
                });
                
                $(".comment-new").hide();
                $(".list").append("<div class='list-item comment-new'><p>This issue is closed, and no more comments can be added.</p></div>").hide().fadeIn();
                $(".closed-indicator").fadeIn();
            }
            
            $(".comment > .options > a.minibutton").click(onCommentDeleteClick);
        }
        
        <?php if (isset($_GET[success]) == true) { ?>    
        $(document).ready(function() { 
            $(document).showMessage({
            thisMessage: ["This issue has been updated successfully!"],
            className: "success",
            opacity: 100,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
            });
        });    
        <?php } ?>
        <?php if (isset($_GET[delete]) == true) { ?>    
        $(document).ready(function() { 
            $(document).showMessage({
            thisMessage: ["Your issue has been deleted successfully!"],
            className: "success",
            opacity: 100,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
            });
        });    
        <?php } ?>
    </script>
<?php include "footer.php"; ?>

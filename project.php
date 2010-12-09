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

    $result = mysql_query("SELECT * FROM project WHERE id = '$_GET[id]'");
    $project = mysql_fetch_array($result);
    
?>
<?php include "header.php"; ?>
    <?php SetPageTitle($project[name]); ?>
    <div class="content">
        <table cellpadding="0" cellspacing="0" style="width: 100%; padding-bottom: 20px;">
            <tr>
                <td valign="middle">
                    <div class="navigation" style="padding: 0px;">
                        <a href="index.php">Projects</a> / <a href="project.php?id=<?php echo $project[id]; ?>"><?php echo $project[name]; ?></a>
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
            <?php
                
                $result = mysql_query("SELECT * FROM issue WHERE projectid = '$project[id]' ORDER BY isurgent DESC, number ASC"); 
                   
                while($row = mysql_fetch_array($result))
                {
                    $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM comment WHERE issueid = '$row[id]'");
                    $return = mysql_fetch_array($sql);
                    $count = $return[rowcount];
                    
                    $sql = mysql_query("SELECT id, username FROM user WHERE id = '$row[createdby]'");
                    $user = mysql_fetch_array($sql);
                    
                    if ($row[isclosed] == "0")
                        echo "<div class='list-item issue open'>\n";
                    else
                        echo "<div class='list-item issue closed' style='display: none;'>\n";
                    
                    echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
                    echo "<tr>\n";
                    echo "<td valign='middle'>\n";
                    echo "<h3>#$row[number]&nbsp;&nbsp;<a href='issue.php?id=$row[id]'>" . $row[title] . "</a></h3>";
                    echo "</td>\n";
                    echo "<td valign='middle' align='right'>\n";
                    if ($row[isurgent] == "1")
                        echo "<em class='urgent-indicator'>Urgent</span>";
                    if ($row[isclosed] == "1")
                        echo "<em class='closed-indicator'>Closed</span>";
                    echo "</td>\n";
                    echo "</tr>\n";
                    echo "</table>\n";
                    echo "<div id='issue$row[number]' class='wikiStyle'>" . $row[body] . "</div>\n";
                    echo "<br />\n";
                    echo "<div class='options'>\n";
                    if ($count == 1)
                        echo "<a href='issue.php?id=$row[id]'>$count comment</a>\n";
                    else
                        echo "<a href='issue.php?id=$row[id]'>$count comments</a>\n";
                    echo "&nbsp;Created about " . FriendlyDate(1, strtotime($row[createddate])) . " by <a href='user-edit.php?id=$user[id]'>$user[username]</a>";
                    echo "</div>\n";
                    
                    echo "<script type='text/javascript'>\n";
                    echo "document.getElementById('issue$row[number]').innerHTML = converter.makeHtml(document.getElementById('issue$row[number]').innerHTML);\n";
                    echo "</script>\n";
                    
                    echo "</div>\n";
                }
                
                if (mysql_num_rows($result) == 0)
                {
                    echo "<div class='list-item issue none'>\n";
                    echo "<p>There are no issues to display for this project.</p>\n";
                    echo "</div>\n";
                }
                
            ?>
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
                <form id="issue-new" action="issue-add.php?projectid=<?php echo $project[id]; ?>" method="post">
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
            <button type="button" class="button" onclick="location.href='project-edit.php?id=<?php echo $project[id]; ?>';">
                <span>Edit Project</span>
            </button>
            <button type="button" class="button danger" onclick="confirm('Are you sure you want to delete this project and all of its issues?') ? location.href='project-delete.php?id=<?php echo $project[id]; ?>' : false;">
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
                $(".open").hide();
            }
            else if (sender.attr("class") == "filter-off open-indicator") {
                sender.attr("class", "filter-on open-indicator");
                $(".open").show();
            }
            else if (sender.attr("class") == "filter-on closed-indicator") {
                sender.attr("class", "filter-off closed-indicator");
                $(".closed").hide();
            }
            else if (sender.attr("class") == "filter-off closed-indicator") {
                sender.attr("class", "filter-on closed-indicator");
                $(".closed").show();
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
        
        <?php if (isset($_GET[success]) == true) { ?>    
        $(document).ready(function() { 
            $(document).showMessage({
            thisMessage: ["This project has been updated successfully!"],
            className: "success",
            opacity: 95,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
            });
        });    
        <?php } ?>
        <?php if (isset($_GET[delete]) == true) { ?>    
        $(document).ready(function() { 
            $(document).showMessage({
            thisMessage: ["Your issue was deleted successfully!"],
            className: "success",
            opacity: 95,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
            });
        });    
        <?php } ?>
    </script>
<?php include "footer.php"; ?>

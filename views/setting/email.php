<div class="content">
    <div class="navigation">
        <a href="/settings">Settings</a> / <a href="/settings/email">Email Configuration</a>
    </div>
    <table cellpadding="0" cellspacing="0" style="width: 100%;">
        <tr valign="top">
            <td style="width: 50%;">
                <div class="list">
                    <form id="issue-edit" action="/settings/email" method="post">
                        <div class="list-item setting">
                            <h3>Email Configuration</h3>
                            <br />
                            <b>Contact Email Address</b><br />
                            <input type="text" name="contactEmailAddress" style="width: 333px;" value="<?php echo RetrieveSetting("ContactEmailAddress"); ?>" />
                        </div>
                        <br />
                        <button type="submit" class="button">
                            <span>Save Settings</span>
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
                    <b>What is this?</b><br />
                    <br />
                    This email address displayed to users when they need to contact an administrator.
                </div>
            </td>
        </tr>
    </table>
</div>
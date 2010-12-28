<div class="content">
    <div class="navigation">
        <a href="/settings">Settings</a> / <a href="/settings/email">Email Configuration</a>
    </div>
    <div class="list">
        <form id="issue-edit" action="/settings/email" method="post">
            <div class="list-item setting">
                <h3>Email configuration</h3>
                <br />
                <b>Outgoing Email Address</b><br />
                <input type="text" name="outgoingEmailAddress" style="width: 710px;" value="<?=$outgoingEmailAddress?>" />
            </div>
            <br />
            <button type="submit" class="button">
                <span>Save Settings</span>
            </button>
        </form>
    </div>
</div>
<div class="content">
    <div class="navigation">
        <a href="/">Projects</a> / <a href="/project/<?=$project[id]?>/edit">Edit Project</a>
    </div>
    <div class="list">
        <form id="project-edit" action="/project/<?=$project[id]?>/edit" method="post">
            <div class="list-item project">
                <h3>Edit Project</h3>
                <br />                    
                <b>Name</b><br />
                <input type="text" name="name" style="width: 732px;" value="<?=$project[name]?>" /><br />
                <br />
                <b>Description</b><br />                    
                <textarea name="description" style="width: 732px;" rows="5"><?=$project[description]?></textarea>                        
            </div>
            <br />
            <button type="submit" class="button">
                <span>Save Project</span>
            </button>
            <button type="button" class="button danger" onclick="confirm('Are you sure you want to delete this project and all of its issues?') ? location.href='/project/<?=$project[id]?>/delete' : false;">
                <span>Delete</span>
            </button>
        </form>
    </div>
</div>
<script type="text/javascript">
    
    $("#project-edit").submit(function validate() {
        var formData = $("#project-edit").serializeArray();
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
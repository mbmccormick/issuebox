<div class="content">
    <div class="navigation">
        <a href="/">Projects</a> / <a href="/project/add">New Project</a>
    </div>
    <div class="list">
        <form id="project-new" action="/project/add" method="post">
            <div class="list-item issue">
                <h3>New Project</h3>
                <br />
                <b>Name</b><br />
                <input type="text" name="name" style="width: 710px;" /><br />
                <br />
                <b>Description</b><br />                    
                <textarea name="description" style="width: 710px;" rows="5"></textarea>
            </div>        
            <br />
            <button type="submit" class="button">
                <span>Create Project</span>
            </button>
        </form>
    </div>
</div>
<script type="text/javascript">
    
    $("#project-new").submit(function validate() {
        var formData = $("#project-new").serializeArray();
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
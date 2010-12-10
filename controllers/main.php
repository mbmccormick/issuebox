<?php

    function render_css()
    {
        render_file("public/css/" . params('path'));
    }
    
    function render_img()
    {
        render_file("public/img/" . params('path'));
    }
    
    function render_js()
    {
        render_file("public/js/" . params('path'));
    }

?>
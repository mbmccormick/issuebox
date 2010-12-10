<?php

    require_once "library/limonade.php";
    
    require("config/config.php");
    require("library/utils.php");
    require("library/security.php");
    
    /* Establish Database Connection */
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }
    mysql_select_db($Database, $con);
    
    /* Modify Configuration Settings */
    function configure()
    {
        option('base_uri', '/nicedog');
        option('public_dir', 'public/');
        option('views_dir', 'views/');
        option('controllers_dir', 'controllers/');
    }
    
    function before()
    {
        layout('layout.php');
    }
    
    /* Declare Main Routes */
    dispatch('/css/:path', 'render_css');
    dispatch('/img/:path', 'render_img');
    dispatch('/js/:path', 'render_js');
    
    /* Declare Security Routes */
    dispatch('/login', 'login');
    dispatch_post('/login/post', 'login_post');
    dispatch('/logout', 'logout');
    
    /* Declare Project Routes */
    dispatch('/', 'project_list');
    dispatch('/project/:id', 'project_view');
    dispatch('/project/add', 'project_add');
    dispatch_post('/project/add/post', 'project_add_post');
    dispatch('/project/edit', 'project_edit');
    dispatch_post('/project/edit/post', 'project_edit_post');
    dispatch_delete('/project/delete', 'project_delete');
    
    /* Declare Issue Routes */
    dispatch('/issue/view', 'issue_view');
    dispatch('/issue/add', 'issue_add');
    dispatch_post('/issue/add/post', 'issue_add_post');
    dispatch('/issue/edit', 'issue_edit');
    dispatch_post('/issue/edit/post', 'issue_edit_post');
    dispatch_delete('/issue/delete', 'issue_delete');
    
    /* Declare Comment Routes */
    dispatch('/comment/add', 'comment_add');
    dispatch_post('/comment/add/post', 'comment_add_post');
    dispatch_delete('/comment/delete', 'comment_delete');
    
    run();
    
?>
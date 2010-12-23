<?php

    require_once "library/limonade.php";
    
    require("config/config.php");
    require("library/utils.php");
    require("library/security.php");
    
    /* Establish database connection */
    $con = mysql_connect($Server, $Username, $Password);
    mysql_select_db($Database, $con);
    
    /* Modify configuration settings */
    function configure()
    {
        option('base_uri', '/');
        option('public_dir', 'public/');
        option('views_dir', 'views/');
        option('controllers_dir', 'controllers/');
    }
    
    function before()
    {
        layout('layout.php');
    }
    
    /* Declare Project routes */
    dispatch('/', 'project_list');
    dispatch('/project/add', 'project_add');
    dispatch_post('/project/add', 'project_add_post');
    dispatch('/project/:id/edit', 'project_edit');
    dispatch_post('/project/:id/edit', 'project_edit_post');
    dispatch('/project/:id/delete', 'project_delete');
    dispatch('/project/:id', 'project_view');
        
    /* Declare Issue routes */
    dispatch_post('/issue/add', 'issue_add_post');
    dispatch('/issue/:id/edit', 'issue_edit');
    dispatch_post('/issue/:id/edit', 'issue_edit_post');
    dispatch('/issue/:id/delete', 'issue_delete');
    dispatch('/issue/:id', 'issue_view');
    
    /* Declare Comment routes */
    dispatch_post('/comment/add', 'comment_add_post');
    dispatch('/comment/:id/delete', 'comment_delete');
    
    /* Declare Security routes */
    dispatch('/login', 'login');
    dispatch_post('/login', 'login_post');
    dispatch('/logout', 'logout');
    
    /* Declare User routes */
    dispatch('/user', 'user_list');
    dispatch('/user/add', 'user_add');
    dispatch_post('/user/add', 'user_add_post');
    dispatch('/user/:id/edit', 'user_edit');
    dispatch_post('/user/:id/edit', 'user_edit_post');
    dispatch('/user/:id/delete', 'user_delete');
    dispatch('/user/:id', 'user_view');
    
    /* Declare Activity routes */
    dispatch('/activity', 'activity_list');
    dispatch('/activity/populate', 'activity_populate');
    
    run();
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Prank your friends with GoatAttack! Barrage their phone with goat pictures and puns." />
    <meta name="keywords" content="goat, goat attack, prank, goat prank, text prank, goat text" />
    <title><?php echo ($title); ?></title>
	<link href="/assets/bootstrap337/css/bootstrap.min.css" rel="stylesheet"/>    
	<link href="/assets/font_awesome/css/font-awesome.min.css" rel="stylesheet"/>
	<link href="/assets/styles/css.css" rel="stylesheet"/>
	<link href="/assets/styles/custom.css" rel="stylesheet">
  <link rel="manifest" href="/assets/manifest.json">
	<script defer type="text/javascript" src="/assets/jquery321.min.js"></script>
	<script defer type="text/javascript" src="/assets/bootstrap337/js/bootstrap.min.js"></script>    
  <script defer type="text/javascript" src="/assets/js/navbar.js"></script>  
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Welcome</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="main-collapse">
      <input type="hidden" value="<?php echo $menuid;?>" id="menuid">
      <input type="hidden" value="<?php echo $submenuid;?>" id="menuid">
      <ul class="nav navbar-nav">
        <li id="home"><a href="<?php echo site_url('home') ?>">Home</a></li>
        <li id="about"><a href="<?php echo site_url('about'); ?>">About</a></li>
        <?php
           $sess_id = $this->session->userdata('logged_in');

           if(!empty($sess_id) && $sess_id == TRUE)
           {
                echo('<li id="actions" class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="'.site_url('customers/index').'">Customers</a></li>
            <li><a href="'.site_url('smsmsg/index').'">ReceviedSms</a></li>
            <li><a href="'.site_url('chat/index').'">Chat with Client</a></li>
            <li class="divider"></li>
            <li><a href="'.site_url('smsmsg/sendsms').'">SendSms</a></li>
            <li><a href="'. site_url('users/logout')  .'">Logout</a></li>
          </ul>
        </li>');
           }else{
               
           }

        ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><p class="navbar-text">
        <?php 
            $sess_id = $this->session->userdata('logged_in');

           if(!empty($sess_id) && $sess_id == TRUE){
              echo ("Hi,".$this->session->userdata('username'));
           }else{
              echo ("Please log in to use all functions.");
           }

         ?>
         </p></li>
         <?php
            $e_msg='       <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
            <ul id="login-dp" class="dropdown-menu">
                <li>
                     <div class="row">
                            <div class="col-md-12">
                                 <form class="form" role="form" method="post" action="/users/login/" accept-charset="UTF-8" id="login-nav">
                                        <div class="form-group">
                                             <label class="sr-only" for="txtusername">User Name</label>
                                             <input type="text" class="form-control" id="txtusername" placeholder="User ID" required
                                               name="email">
                                        </div>
                                        <div class="form-group">
                                             <label class="sr-only" for="txtuserpwd">Password</label>
                                             <input type="password" class="form-control" id="txtuserpwd" placeholder="Password"  name="password" required>
                                             <div class="help-block text-right"><a href="">Forget the password ?</a></div>
                                        </div>
                                        <div class="form-group">
                                             <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                        </div>
                                 </form>
                            </div>
                     </div>
                </li>
            </ul>
        </li>';
        if(!empty($sess_id) && $sess_id == TRUE)
           {
              

           }
           else{
              echo($e_msg);
           }

         ?>
 
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

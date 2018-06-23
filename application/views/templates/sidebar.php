 <link href="/assets/styles/navbar.css" rel="stylesheet"/>
<div class="nav-side-menu">
    <div class="brand">Our Service</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
        <input type="hidden" id="menuid" value="<?php echo($menuid)?>" />
        <input type="hidden" id="subid" value="<?php echo($subid)?>" />
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
                <li id="dashboard">
                  <a href="#">
                  <i class="fa fa-dashboard fa-lg"></i> Dashboard
                  </a>
                </li>

                <li  data-toggle="collapse" data-target="#products" class="collapsed" id="gif">
                  <a href="#"><i class="fa fa-gift fa-lg"></i> Gif files managment <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse gif" id="products">
                    <li class="list"><a href="/images/list">List</a></li>
                    <li class="add"><a href="/images/add">Add</a></li>
                </ul>


                <li data-toggle="collapse" data-target="#service" class="collapsed" id="smstype">
                  <a href="#"><i class="fa fa-globe fa-lg"></i> Sms Type <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse smstype" id="service">
                  <li class="list"><a href="/smstype/list">List</a></li>
                  <li class="add"><a href="/smstype/add">Add</a></li>
                </ul>

                 <li>
                  <a href="/users/logout">
                  <i class="fa fa-users fa-lg"></i> Log out
                  </a>
                </li>
            </ul>
     </div>
</div>
<div class="maincontent">
   
</div>
<script defer src="/assets/js/navbar.js"></script>
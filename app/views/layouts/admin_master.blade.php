<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <title>다사다 물물교환 - 관리자</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content=''>
    <meta name='author' content=''>
    <?
		echo HTML::style('assets/css/bootstrap.css');
    echo HTML::style('assets/css/bootstrap-responsive.css');
    echo HTML::style('assets/css/prettify.css');

    echo HTML::script('assets/js/jquery.js');
    echo HTML::script('assets/js/jquery.tmpl.min.js');
    echo HTML::script('assets/js/prettify.js');
    echo HTML::script('assets/js/google_analytics.js');
		?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <?
    echo HTML::script('assets/js/html5shiv.js');
    ?>
    <![endif]-->    
    <style type='text/css'> 
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
  </head>
  <body onload='prettyPrint()'>
    <div class='navbar navbar-inverse navbar-fixed-top'>
      <div class='navbar-inner'>
        <div class='container-fluid' style='padding-top:6px;'>
          <button type='button' class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
          <a class='brand' href='../../admin/index'>물물교환 - 관리자</a>
          <div class='nav-collapse collapse'>
            <p class='navbar-text pull-right'>
              <!--Logged in as <a href='#' class='navbar-link'>Username</a>-->
            </p>
            <ul class='nav'>
              <li <?if(!strncmp($path, 'category', strlen('category'))){?>class='active'<?}?>><a href='../../admin/category/list_form'>카테고리 관리</a></li>
              <li <?if(!strncmp($path, 'item', strlen('item'))){?>class='active'<?}?>><a href='../../admin/item/list_form'>상품 관리</a></li>

              <li <?if(!strncmp($path, '#/', strlen('#/'))){?>class='_active'<?}?>>
                <?if($member_id != ''){?>
                  <a><span style='color:yellow;'><?=$member_id?></span> 
                  <?if($is_admin == 1){?>
                    <span style='color:#FFA500;font-weight:normal;'>[관리자]</span>
                  <?}?>
                  <span style='color:#AAAAFF;font-weight:normal;'>님 환영합니다!</span></a>
                <?}?>    
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class='container-fluid' style='height:500px;'>
      <div class='row-fluid' style='height:100%;'>

        <!-- body -->
        <div class='span12'>
 					@yield('content')
				</div><!--/span-->

      </div><!--/row-->

      <hr>

      <footer>
        <!--<p>&copy; BlueMarron 2013</p>-->
      </footer>

    </div><!--/.fluid-container-->

    <!-- Placed at the end of the document so the pages load faster -->
    <?
		echo HTML::script('assets/js/bootstrap-transition.js');
		echo HTML::script('assets/js/bootstrap-alert.js');
		echo HTML::script('assets/js/bootstrap-modal.js');
		echo HTML::script('assets/js/bootstrap-dropdown.js');
		echo HTML::script('assets/js/bootstrap-scrollspy.js');
		echo HTML::script('assets/js/bootstrap-tab.js');
		echo HTML::script('assets/js/bootstrap-tooltip.js');
		echo HTML::script('assets/js/bootstrap-popover.js');
		echo HTML::script('assets/js/bootstrap-button.js');
		echo HTML::script('assets/js/bootstrap-collapse.js');
		echo HTML::script('assets/js/bootstrap-carousel.js');
		echo HTML::script('assets/js/bootstrap-typeahead.js');
		?>
  </body>
</html>
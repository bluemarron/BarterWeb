<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <title>다사다 물물교환</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- meta http-equiv="X-UA-Compatible" content="IE=8" -->
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content=''>
    <meta name='author' content=''>
    <?
		echo HTML::style('assets/css/bootstrap.css');
    echo HTML::style('assets/css/bootstrap-responsive.css');
    echo HTML::style('assets/css/prettify.css');
		?>
    <style type='text/css'> 
      body {
        padding-top: 0px;
        padding-bottom: 0px;
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

    <?
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
  </head>
  <body onload='prettyPrint()'>
    <div class='navbar navbar-inverse navbar-fixed-top'>

    </div>

    <div class='container-fluid'>
      <div class='row-fluid' style='height:100%;'>
        <!-- body -->
        <div class='span12'>
 					@yield('content')
				</div><!--/span-->
      </div><!--/row-->
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
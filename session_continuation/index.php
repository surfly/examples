<?php
include('products.php');

if(isset($_GET['action']) && $_GET['action'] == 'addtocart')
{
	if(isset($_SESSION['cart']) && is_array($_SESSION['cart']))
	{
		if(isset($_SESSION['cart'][$_GET['pid']]))
			$_SESSION['cart'][$_GET['pid']] = $_SESSION['cart'][$_GET['pid']] + 1;
		else
			$_SESSION['cart'][$_GET['pid']] = 1;
	}
	else
		$_SESSION['cart'] = array($_GET['pid'] => 1);
		
	echo count($_SESSION['cart']);
	exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Custom Javascript Endpoint Dashboard - Surfly Code Samples</title>
		<link rel="stylesheet" href="style.css">
		<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
	</head>
	<body>
		<header>
			<a href=" https://www.surfly.com/ ">
				<img alt="Delicious Mint" src="https://www.surfly.com/wp-content/themes/delicious/img/mint/logo.png">
			</a>
		</header>
		<div class="main_container">
			<h1>Surfly Test Shop</h1>
			<div class="source_link">
				<p>
					<b>Source code</b> : <a href="https://github.com/surfly/examples/blob/gh-pages/session_continuation/index.php" target="_blank"> Github</a>
					<span class="overview"><a href="http://surfly.github.io/examples/">Surfly Example overview</a></span>
				</p>
			</div>
			<div class="products">
				<div class="cart_count"><a href="cart.php"><b>Cart:<span><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;?></span></b></a></div>
				<?php foreach($products as $k=>$pro){?>
				<div class="product_list">
					<img src="<?php echo $pro['image']; ?>">
					<h4><?php echo $pro['title']; ?></h4>
					<div>
						<span>$ <?php echo $pro['price']; ?></span>
						<button onclick="addtocart(<?php echo $k; ?>);">Add to cart</button>
					</div>
				</div>
				<?php }?>
			</div>
		</div>

		<script type="text/javascript">
			function addtocart(pid){
			   $.get("https://surfly-examples-vino247-1.c9.io/shop.php?action=addtocart&pid="+pid, function(res){
  					$(".cart_count span").text(res);
			   });
			}
			
			function getCookie(cname) {
			    var name = cname + "=";
			    var ca = document.cookie.split(';');
			    for(var i=0; i<ca.length; i++) {
			        var c = ca[i];
			        while (c.charAt(0)==' ') c = c.substring(1);
			        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
			    }
			    return "";
			}
			
			//Just paste a snippet code and customize option
			(function(){window['_surfly_settings']=window['_surfly_settings']||{"widgetkey": 
				"54731063bfa746ac826d1429f230a0b7",
				//"dd63242538b7475bb538d5f02305d8d1",
				"enable_sounds": true,
				"videochat": true,
				"QUEUE_CALLBACK": false,
				"min_width": 0,
				"agent_can_request_control": false,
				"on_end_redirect_follower_to_queue": true,
				"dock_top_position": false,
				"autohide_control": true,
				"splash": false,
				"theme_font_size": false,
				"hidden": false,
				"theme_font_color": false,
				"set_to_smallest": true,
				"newurl": true,
				"QUEUE_ENDPOINT": "",
				"agent_can_take_control": false,
				"max_height": 0,
				"white_label": false,
				"min_height": 0,
				"theme_inverted": true,
				"QUEUE_HANDLER": false,
				"autohide_button": false,
				"soft_session_end": false,
				"docked_only": false,
				"theme_font_background": false,
				"ui_off": false,
				"max_width": 0,
				"apiserver": "https://surfly.com/v2/",
				//"apiserver": "https://vinoth.sitesupport.net/v2/",
				"sharing_button": true,
				"auto_start": false,
				"position": "bottomleft",
				"stealth_mode": true};
				var e=document.createElement("script");e.type="text/javascript";e.async=!0;e.src="//surfly.com/static/js/widget.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n); 
				
				window['_surfly_settings'].headers = JSON.stringify([["Cookie", "PHPSESSID="+getCookie('PHPSESSID')]]);
			})();
		</script>
	</body>
</html>
<?php
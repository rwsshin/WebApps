<?php


	if(isset($_GET['login']) && isset($_GET['username']) && isset($_GET['password']) ){
			if(loginmember($_GET['username'], $_GET['password'])){
				$loginInfo = $_GET['username'] . "," . $_GET['password'];
				setcookie('username', $_GET['username'] ); 
				setcookie('password', $_GET['password']); 
				setcookie('logininfo', $loginInfo); 

				if (isset($_COOKIE['logininfo'])) {
					//echo $_COOKIE['logininfo'];
					//echo "YAY COOKIE IS SET";
					$favoritesRetrieved = getfavorites($_GET['username']);
					//echo "$_GET['username']";
					//echo "The favorites are: $favoritesRetrieved";
				}
			}
			else{
				echo "LOGIN UNSUCCESSFUL";
			}
	}	

	if(isset($_GET['itemnamesubmit'])){
		$listingToAdd = $_GET['itemname'];
		$listingToAdd = explode(",", $listingToAdd);
		//"$link,$img,$name,$price";
		$usernameToAppendTo = $listingToAdd[0];
		$linkToAdd = $listingToAdd[1];
		$imgToAdd = $listingToAdd[2];
		$nameToAdd = $listingToAdd[3];
		$priceToAdd = $listingToAdd[4];
		$storeToAdd = $listingToAdd[5];

		$favoriteToAdd = $linkToAdd . "," . $imgToAdd  . "," .  $nameToAdd  . "," . $priceToAdd . "," . $storeToAdd;

		$currentFavorites = getfavorites($usernameToAppendTo);
		if(strlen($currentFavorites) > 2){

	        $pos = strpos($currentFavorites, $favoriteToAdd, 0);            
	        if ($pos === false) {
				$currentFavorites = $currentFavorites . "," . $favoriteToAdd;
				insertmemberfavorite($usernameToAppendTo, $currentFavorites);
	        } 

		}
		else{
			$currentFavorites = $favoriteToAdd;
			insertmemberfavorite($usernameToAppendTo, $currentFavorites);
		}



 		//header('Location: index.php');
 	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Lisa Huang - Won Seok Shin</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script type="text/javascript">
		function display(itemname){
			alert("Item Added. " + itemname);
		}

		function getLinks() { 

			//var rawHTML = '<html><body><a href="foo">bar</a><a href="narf">zort</a></body></html>';


			

			var doc = document.createElement("html");
			doc.innerHTML = document.getElementById("ahrefs").innerHTML;
			var links = doc.getElementsByTagName("a")
			//var urls = [];

			var ahrefLinks = "<b>Anchor Tags:</b><br>===================================<br>";
			for (var i=0; i<links.length; i++) {
				ahrefLinks = ahrefLinks + links[i].getAttribute("href") + "<br>";
				//urls.push(links[i].getAttribute("href"));
			}

/*
			var m;
			var str = '<img src="http://site.org/one.jpg />\n <img src="http://site.org/two.jpg />',
			var rex = /<img[^>]+src="?([^"\s]+)"?\s*\/>/g;

			while ( m = rex.exec( str ) ) {
				ahrefLinks = ahrefLinks + m[1] + "<br>";
			}
*/



			var imglinks = doc.getElementsByTagName("img")
			//var urls = [];
			
			ahrefLinks = ahrefLinks + "<br><br><br><br><br><b>Image Links:" + "</b><br>===================================<br>";
			for (var i=0; i<imglinks.length; i++) {
				ahrefLinks = ahrefLinks + imglinks[i].getAttribute("src") + "<br>";
				//urls.push(links[i].getAttribute("href"));
			}



			document.getElementById("ahrefs").innerHTML = ahrefLinks;




			//alert(urls[0]);

		}
	</script>

  </head>
  <body>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php">WebApps</a>
		    </div>

		    <p class="navbar-text"> | </p>


		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <p class="navbar-text">Search All Supported Stores:</p>
		      </ul>
		      <form class="navbar-form navbar-left" role="search">
		        <div class="form-group">
		          <input type="text" class="form-control" name="search_term" placeholder="Product Name">
		        </div>
		        <button type="submit" class="btn btn-default" name="search_button">Search</button>
		      </form>
		      <p class="navbar-text"> | </p>


	          <p class="navbar-text">Analyze</p>
  		      <form class="navbar-form navbar-left" role="search">
		        <div class="form-group">
		          <input type="text" class="form-control" name="parse_url" placeholder="http://">
		        </div>
		        <button type="submit" class="btn btn-default" name="parse_button">Parse</button>
		      </form>

  		      <form class="navbar-form navbar-left" role="search">
		        <button type="submit" class="btn btn-default" name="members_area_button">Members Area</button>
		      </form>

		      <?php
			  	if(isset($_COOKIE['username'])){		
					$user = $_COOKIE['username'];

			  		echo "<div class='form-group'>
						  <br><a href='logout.php'>Log out: $user</a>
						  </div>";
			  	}

		      ?>




<!--
		      <ul class="nav navbar-nav navbar-right">
		         <li><a href="#">Members Center</a></li> 
		      </ul>
-->
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>


		<?php
			/*if(isset($_GET['itemnamesubmit'])){
				$currentFavorites = getfavorites($usernameToAppendTo);
				$currentFavorites = explode(",", $currentFavorites);
				//"$link,$img,$name,$price,store";

				echo "Favorites are:<br><br><br>";
				$count = 0;
				foreach($currentFavorites as $child) {
				   echo $child . "<br>";

				   $count = $count + 1;
				   if($count == 5){
				   		$count = 0;
						echo "<br>";
				   }
				}

				echo "This should print after redirecting when add to favorites is clicked";
				echo "<br><br><br><a href='logout.php'>Logout</a>";
				echo "<br><br><br><a href='googlespreadsheet.php'>As Google Spreadsheet</a>";

			}
			else*/ if(isset($_GET['members_area_button']) || isset($_GET['register']) || isset($_GET['login'])){
				if(!isset($_GET['register']) && !isset($_GET['login']) && !isset($_COOKIE['username'] )){
				echo "

				<form method='get'>
					<div class='container' style='height:400px; width:700px;'>
						<div class='jumbotron'>
							<h1>Members Area</h1>
							<p>Log in or sign up to keep track of favorite products.</p>

							<div class='input-group'>
								<span class='input-group-addon' id='basic-addon1'>Username</span>
								<input type='text' class='form-control' name='username' placeholder='Username' aria-describedby='basic-addon1'>
							</div>

							<br>

							<div class='input-group'>
								<span class='input-group-addon' id='basic-addon1'>Password</span>
								<input type='password' class='form-control' name='password' placeholder='Password' aria-describedby='basic-addon1'>
							</div>

							<br><br>

							<input type='submit' name='register' value='Register'>
							<input type='submit' name='login' value='Log In'>
						</div>
				  	</div>
				</form>";
}
else if(!isset($_GET['register']) && !isset($_GET['login']) && isset($_COOKIE['username']) ){
		$member_favorites = getfavorites($_COOKIE['username']);
		$member_favorites = explode(",", $member_favorites);

		echo "Favorites are:<br><br><br>";
		$count = 0;
		foreach($member_favorites as $child) {
		   echo $child . "<br>";

		   $count = $count + 1;
		   if($count == 5){
		   		$count = 0;
				echo "<br>";
		   }
		}

		echo "<br><br><br><a href='logout.php'>Logout</a>";
		echo "<br><br><br><a href='googlespreadsheet.php'>As Google Spreadsheet</a>";
}
else{
	if(isset($_GET['register']) && isset($_GET['username']) && isset($_GET['password']) ){
		if(!lookupmemberusername($_GET['username'])){
			insertnewmember($_GET['username'], $_GET['password']);
		}
	}
	else if(isset($_GET['login']) && isset($_GET['username']) && isset($_GET['password']) ){
		if(loginmember($_GET['username'], $_GET['password'])){
			echo "LOGIN SUCCESSFUL<br><br>";
			echo "<input type='hidden' name='register' value='Register'>";
			echo "<input type='hidden' name='login' value='login'>";
			$member_favorites = getfavorites($_GET['username']);



				$member_favorites = explode(",", $member_favorites);

				echo "Favorites are:<br><br><br>";
				$count = 0;
				foreach($member_favorites as $child) {
				   echo $child . "<br>";

				   $count = $count + 1;
				   if($count == 5){
				   		$count = 0;
						echo "<br>";
				   }
				}

				echo "<br><br><br><a href='logout.php'>Logout</a>";
				echo "<br><br><br><a href='googlespreadsheet.php'>As Google Spreadsheet</a>";
		}
		else{
			echo "LOGIN UNSUCCESSFUL";
		}
	}
}
			}
			else if(!isset($_GET['search_button']) && !isset($_GET['parse_button'])){
				echo
				"  <div class='container'>
				<div class='jumbotron'>
				  <h1>Basic Web Crawler</h1>
				  <h4>Spring 2015</h4>
				  <h2>Lisa Huang - Won Seok Shin</h2>
				  <p>
				  For our final project in professor Lowrie's Web Apps class, we decided to implement a web crawler. A web crawler follows links iteratively to scrape relevant information from the html content of each visited link.
				  </p>
				  <p>
				  The first component of our implementation parses the html of http GET search requests from Best Buy, RadioShack, Target, Amazon, Macy's, and Nordstrom. The html parsing must be supervised and done manually. This is not an efficient method, and often causes errors due to unpredictible html content that is returned. Furthermore, the html content that is returned from each of these company's websites is subject to change over time if the websites are updated and the structure of the underlying code is changed. Nonetheless, meaningul results are returned, and basic web scraping techniques through string manipulations were insightful. 
				  </p>
				  <p>
				  The second component of our crawler seeks to find resources, namely hyperlinks and images, that exist on a page. This seemed like an intuitive direction to take if one were to develop an indexing or search algorithm to categorize websites based on keywords, and eventually parse content to allow for price comparison functionality.
				  </p>
				  <p>
				  The third component of our crawler seeks to store data and manage users by allowing for users to keep track of their favorite searches. This was accomplished by using an SQL database. This is further enhanced by our fourth component.
				  </p>
				  <p>
				  The fourth component of our crawler, although lacking in robustness due to the volatile, uncertain, and morphic structure of html content, seeks to export the collected data into a google docs spreadsheet using the google apps script api for google docs.
				  </p>
				</div>
				</div>"
				;
			}
			else if(isset($_GET['parse_button']) && isset($_GET['parse_url'])){

				   $parse_url = $_GET['parse_url'];
	               $html_to_parse = fread_url($parse_url);

   				   echo "<label id='ahrefs'>$html_to_parse</label>";


             	    echo "<script> getLinks(); </script>";
             	    //'uploadPostComment($parentID, $comment);

			}
		 	 else if(isset($_GET['search_button']) && isset($_GET['search_term'])){

			
$search_term = $_GET['search_term'];
$search_term2 = $_GET['search_term'];

$nameToAdd = "";
if(isset($_GET['itemnamesubmit'])){
		$listingToAdd = $_GET['itemname'];
		$listingToAdd = explode(",", $listingToAdd);
		$nameToAdd = $listingToAdd[3];
}
				if(isset($_GET['itemnamesubmit'])){
		 	 	    echo "<script type='text/javascript'>display('$nameToAdd');</script>";
		 	 	}

echo "<span class='label label-success'>Showing Search Results for: $search_term</span><br>";
echo "<span class='label label-primary'>Searches are done on Best Buy, RadioShack, Target, Amazon, Macy's, and Nordstrom.</span><br><br>";
//echo "<span class='label label-danger'>Search terms may cause crashes. Infinite loops may occur when the search term is a name i.e. Britney Spears.</span><br><br>";

		 	 	// Provides: <body text='black'>
				$search_term = str_replace(" ", "+", $_GET['search_term']);

		            //scraping product listings from bestbuy.com
		                $best_buy_url = 'http://www.bestbuy.com/site/searchpage.jsp?keys=keys&ks=960&usc=All%20Categories&iht=y&list=n&qp=soldby_facet%3DSold%20By~Best%20Buy&sp=&nrp=15&cp=1&sc=Global&type=page&id=pcat17071&_dyncharset=UTF-8&st=' .$search_term;
		                $best_buy_html = fread_url($best_buy_url);
		                $item_listing_begin_tag   = '</div><div class="list-item"';
		                $pos = 0;
		                $count = 0;

		                while(true){
		                    //Search for the next product listing, if it does not exist, break from while loop 
		                    $pos = strpos($best_buy_html, $item_listing_begin_tag, $pos);            
		                    if ($pos === false) {
		                        //echo "The string was not found";
		                        break;
		                    } 

		                    $count += 1;

		                    //extract name, picture, price, description
		                    //data-name="..."
		                    $pos_name_beginning = strpos($best_buy_html, "data-name=", $pos);
		                    $pos_name_beginning = $pos_name_beginning + strlen("data-name=") + 1;

		                    $pos_name_ending = strpos($best_buy_html, "data-pricing-type=", $pos_name_beginning);
		                    $pos_name_ending = $pos_name_ending - 2;
		                    $name_string_length = $pos_name_ending - $pos_name_beginning ;
		                    $name = substr($best_buy_html, $pos_name_beginning, $name_string_length);

		                    //echo "name beg: $pos_name_beginning<br>";
		                    //echo "name end: $pos_name_ending<br>";
		                    //echo "name length: $name_string_length<br>";

		                    //data-price="..."
		                    $pos_price_beginning = strpos($best_buy_html, "data-price=", $pos);
		                    $pos_price_beginning = $pos_price_beginning + strlen("data-price=") + 1;

		                    $pos_price_ending = strpos($best_buy_html, '>', $pos_price_beginning);
		                    $pos_price_ending = $pos_price_ending - 2;
		                    $price_string_length = $pos_price_ending - $pos_price_beginning;
		                    $price = substr($best_buy_html, $pos_price_beginning, $price_string_length);
		                    //echo "price beg: $pos_price_beginning<br>";
		                    //echo "price end: $pos_price_ending<br>";
		                    //echo "price length: $price_string_length<br>";

		                    $pos_link_beginning = strpos($best_buy_html, "<a href=", $pos);
		                    $pos_link_beginning = $pos_link_beginning + strlen("<a href=") + 1;

		                    $pos_link_ending = strpos($best_buy_html, "\"" , $pos_link_beginning);
		                    $pos_link_ending = $pos_link_ending - 2;
		                    $link_string_length = $pos_link_ending - $pos_link_beginning;
		                    $link = "http://www.bestbuy.com" . substr($best_buy_html, $pos_link_beginning, $link_string_length);

		                    //Image
		                    $pos_img_beginning = strpos($best_buy_html, "<img src=", $pos);
		                    $pos_img_beginning = $pos_img_beginning + strlen("<img src=") + 1;

		                    $pos_img_ending = strpos($best_buy_html, "\"", $pos_img_beginning);
		                    $pos_img_ending = $pos_img_ending;
		                    $img_string_length = $pos_img_ending - $pos_img_beginning;
		                    $img = substr($best_buy_html, $pos_img_beginning, $img_string_length);
		                    //echo "image beg: $pos_img_beginning<br>";
		                    //echo "image end: $pos_img_ending<br>";
		                    //echo "image length: $img_string_length<br>";

		                    //Description
		                    $pos_description_beginning = strpos($best_buy_html, "<div class=\"short-description\">", $pos);
		                    $pos_description_beginning = $pos_description_beginning + strlen("<div class=\"short-description\">");

		                    $pos_description_ending = strpos($best_buy_html, "</div>", $pos_description_beginning);
		                    $pos_description_ending = $pos_description_ending;
		                    $description_string_length = $pos_description_ending - $pos_description_beginning;
		                    $description = substr($best_buy_html, $pos_description_beginning, $description_string_length);
		                    
		                    // Provides: <body text='black'>
		                    $description = str_replace("<li>", "", $description);
		                    $description = str_replace("<ul>", "", $description);
		                    $description = str_replace("<ol>", "", $description);
		                    $description = str_replace("</li>", "<br>", $description);

		                    //echo "description beg: $pos_description_beginning<br>";
		                    //echo "description end: $pos_description_ending<br>";
		                    //echo "description length: $description_string_length<br>";
		                    
		                    // Note use of ===.  Simply == would not work as expected
		                    // because the position of 'a' was the 0th (first) character.
		                    //echo "The string was found and exists at position $pos.<br>";

		                    if(strlen($name) > 100 || strlen($img) > 100 || strlen($price) > 100 || strlen($link) > 100){
		                    	$name = substr($name, 0, 100);

		                    	if(substr($name, 0, strlen("Sponsored")) == "Sponsored"){
		                    		$name = "Sponsored";
			                    	$img = '';
			                    	$name = '';
			                    	$link = '';
			                    	$price = 'Parse Error';
		                    	}
		                    }
		                    if(strlen($price) > 100){
		                    	$price = substr($price, 0, 100);
		                    }


							$name = str_replace(",", " - ",$name);
		                    $showAddToFavorites = "";
		                    $formatedFavoritesInfo = "$link,$img,$name,$price,Best Buy";
		                    if(isset($_COOKIE['username'])){

									$formatedFavoritesInfo = $_COOKIE['username'] . ',' . $formatedFavoritesInfo;
									$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'>
									<input type='hidden' name='itemname' value='$formatedFavoritesInfo'>
									<input type='hidden' name='search_button' value='clicked'>
									<input type='hidden' name='search_term' value='$search_term2'>
									";

		                    }
	echo "<form>
	  <div class='col-sm-4 col-md-4'>
	    <div class='thumbnail' style='height:400px; width:350px; text-align: center; background-color:#99ADEB;'>
	    <h4><u>Best Buy</u></h4>
	  	<br>
	      <a href='$link'><img src='$img' style='height:150px;'  alt='...'></a><br>
	        <b>$name</b><br>
	        \$$price<br><br>
	        <a href='$link' class='btn btn-primary' role='button'>Link</a>$showAddToFavorites
   	    </div>
	  </div>
	</form>";

	 


		                    $pos = $pos_description_ending;            

		                    if($count > 25)        
		                    	break;
		                }


		                //RADIOSHACK Product Listings - http://www.radioshack.com/search?q=phone
		                $radioshack_url = 'http://www.radioshack.com/search?q=' . $search_term;
		                $radioshack_html = fread_url($radioshack_url);
		                $item_listing_begin_tag   = "<a class=\"name-link\" href=\"";

		                $pos = 0;


		                while(true){
		                    //Search for the next product listing, if it does not exist, break from while loop 
		                    $pos = strpos($radioshack_html, $item_listing_begin_tag, $pos);            
		                    if ($pos === false) {
		                        //echo "The string was not found";
		                        break;
		                    } 

		                    //get link to item
		                    $pos += strlen($item_listing_begin_tag);
		                    $pos_link_ending = strpos($radioshack_html, "\"" , $pos);
		                    $pos_link_ending = $pos_link_ending;

		                    $item_link_length = $pos_link_ending - $pos;
		                    $item_link = substr($radioshack_html, $pos, $item_link_length);
		                    
		                    //load html of item page
		                    $item_html = fread_url($item_link);
		                    //scrape info
		                    	//title - <li><span class="last">Boost Mobile LG Volt No-Contract Phone</span></li>
		                    $title_beginning_pos = strpos($item_html, "<li><span class=\"last\">" , 0);
		                    $title_beginning_pos += strlen("<li><span class=\"last\">");
		                    $title_ending_pos = strpos($item_html, "</span>" , $title_beginning_pos);
		                    $title_length = $title_ending_pos - $title_beginning_pos;
		                    $title = substr($item_html, $title_beginning_pos, $title_length);
		                    	//link - $item_link
		                    	//price - 
		                    	//<span class="map-sale-price">
		//						$148.00
		//					</span>

		                    $price_beginning_pos = strpos($item_html, "price\">" , 0);
		                    $price_beginning_pos += strlen("price\">");
		                    $price_beginning_pos = strpos($item_html, "$" , $price_beginning_pos);
		                    $price_beginning_pos += 1;

		                    $price_ending_pos = strpos($item_html, " " , $price_beginning_pos);
		                    $price_length = $price_ending_pos - $price_beginning_pos;
		                    $price = substr($item_html, $price_beginning_pos, $price_length);


		                                        	//description

		//    				<div class="tab-content">
		//					Power and speed redefined.
		//					Enjoy the power of an Android smartphone, without a contract, with the Boost Mobile LG Volt No-Contract Phone.  It's powered by Android 4.4 and a 1.2GHz quad-core processor, so you'll be able to surf the Web, stream videos and share your memories faster than ever. Plus, Google Play gives you access to hundreds of thousands of books, music, movies, TV shows and apps.
		//					<ul><li>1.2GHz quad-core processor delivers seamless performance and power</li><li>Android 4.4 (KitKat) offers a more polished design, improved performance and new features</li><li>Experience all of your favorite media on the 4.7" qHD IPS display with durable Corning Gorilla Glass</li><li>QSlide Function gives you quick access to videos, calendars, your browser and more</li><li>Knock Code gives you quick, secure access to your phone with your personalized tap pattern</li><li>Powerful, removable 3000mAh battery delivers up to 24 hours of talk time*</li><li>Built-in 8MP rear-facing camera for crisp, sharp photos and 1080p HD video</li><li>Video chat using the 1.3-megapixel front-facing camera</li><li>Guest Mode gives you peace of mind when sharing your phone with others</li><li>Turn your LG Volt into a remote control for your multiple-room, home TV and cable box with QRemote</li><li>At Google Play, you can browse and download thousands of free and paid apps from around the world</li><li>One-click access to Facebook, Twitter and more</li><li>Wi-Fi connectivity: 802.11 b/g/n; Bluetooth connectivity: 4.0</li><li>8GB storage capacity expandable to 32GB via microSD memory cards (not included)</li></ul>
		//					<div class="right-description">

		                    $description_beginning_pos = strpos($item_html, "<div class=\"descr-long\">" , 0);
		                    $description_beginning_pos += strlen("<div class=\"descr-long\">");					                    
		                    $description_ending_pos = strpos($item_html, "</div" , $description_beginning_pos);
		                    $description_length = $description_ending_pos - $description_beginning_pos;
		                    $description = substr($item_html, $description_beginning_pos, $description_length);


		                    	//image
		//<img class="productthumbnail" src="http://demandware.edgesuite.net/sits_pod26/dw/image/v2/AASR_PRD/on/demandware.static/Sites-radioshack-Site/Sites-master-catalog/default/v1429999232272/images/01709883_01.jpg?sw=89&amp;sh=89&amp;sm=fit" alt="Boost Mobile LG Volt No-Contract Phone, " title="Boost Mobile LG Volt No-Contract PhoneBoost Mobile LG Volt No-Contract Phone, " data-lgimg='{"url":"http://demandware.edgesuite.net/sits_pod26/dw/image/v2/AASR_PRD/on/demandware.static/Sites-radioshack-Site/Sites-master-catalog/default/v1429999232272/images/01709883_01.jpg?sw=350&amp;sh=350&amp;sm=fit", "title":"Boost Mobile LG Volt No-Contract Phone, ", "alt":"Boost Mobile LG Volt No-Contract Phone, ", "hires":"http://demandware.edgesuite.net/aasr_prd/on/demandware.static/Sites-radioshack-Site/Sites-master-catalog/default/v1429999232272/images/01709883_01.jpg"}'/>								 
		//							</a>

		                    $image_beginning_pos = strpos($item_html, "<a class=\"mainimagezoom\" href=" , 0);
		                    $image_beginning_pos += strlen("<a class=\"mainimagezoom\" href=");					    
		                    $image_ending_pos = strpos($item_html, " " , $image_beginning_pos);
		                    $image_length = $image_ending_pos - $image_beginning_pos;
		                    $image = substr($item_html, $image_beginning_pos, $image_length);

		                    //add to table
		                    //continue
		                    //$description = str_replace("<li>", "", $description);
		                    //$description = str_replace("<ul>", "", $description);
		                    //$description = str_replace("<ol>", "", $description);
		                    //$description = str_replace("</li>", "<br>", $description);

		                    //echo "description beg: $pos_description_beginning<br>";
		                    //echo "description end: $pos_description_ending<br>";
		                    //echo "description length: $description_string_length<br>";
		                    
		                    // Note use of ===.  Simply == would not work as expected
		                    // because the position of 'a' was the 0th (first) character.
		                    //echo "The string was found and exists at position $pos.<br>";


							$title = str_replace(",", " - ",$title);
		                    $showAddToFavorites = "";
		                    $formatedFavoritesInfo = "$item_link,$image,$title,$price,RadioShack";
		                    if(isset($_COOKIE['username'])){
									$formatedFavoritesInfo = $_COOKIE['username'] . ',' . $formatedFavoritesInfo;
									//$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'><input type='hidden' name='itemname' value='$formatedFavoritesInfo'>";
									$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'>
									<input type='hidden' name='itemname' value='$formatedFavoritesInfo'>
									<input type='hidden' name='search_button' value='clicked'>
									<input type='hidden' name='search_term' value='$search_term2'>
									";

		                    }



	echo "<form>
	  <div class='col-sm-4 col-md-4'>
	    <div class='thumbnail' style='height:400px; width:350px; text-align: center; background-color:#E1A76C;'>
	    <h4><u>RadioShack</u></h4>
	  	<br>
	      <a href='$item_link'><img src='$image' style='height:150px;'  alt='...'></a><br>
	        <b>$title</b><br>
	        \$$price<br><br>
	        <a href='$item_link' class='btn btn-primary' role='button'>Link</a>$showAddToFavorites
	    </div>
	  </div>
	</form>";


		                    $pos = $pos_link_ending;                 
		                }

		                //RADIOSHACK Product Listings



		                //TARGET PRODUCT LISTINGS
		                //www.target.com/s?searchTerm=paper
		                $target_url = 'www.target.com/s?searchTerm=' . $search_term;
		                $target_html = fread_url($target_url);
		                $item_listing_begin_tag   = "<div class=\"tileImage\">";

		                $pos = 0;


		                while(true){
		                    //Search for the next product listing, if it does not exist, break from while loop 
		                    $pos = strpos($target_html, $item_listing_begin_tag, $pos);            
		                    if ($pos === false) {
		                        //echo "The string was not found";
		                        break;
		                    } 

		                    //get link to item
		                    $pos_link_beginning = strpos($target_html, "<a href=\"" , $pos);
		                    $pos_link_beginning += strlen("<a href=\"");
		                    $pos_link_ending = strpos($target_html, "\"" , $pos_link_beginning);

		                    $item_link_length = $pos_link_ending - $pos_link_beginning;
		                    $item_link = substr($target_html, $pos_link_beginning, $item_link_length);

		                    //scrape info
		                    	//title - <li><span class="last">Boost Mobile LG Volt No-Contract Phone</span></li>
		                    $title_beginning_pos = strpos($target_html, "title=\"" , $pos_link_ending);
		                    $title_beginning_pos += strlen("title=\"");
		                    $title_ending_pos = strpos($target_html, "\"" , $title_beginning_pos);
		                    $title_length = $title_ending_pos - $title_beginning_pos;
		                    $title = substr($target_html, $title_beginning_pos, $title_length);
		                    	//link - $item_link
		                    	//price - 
		                    	//<span class="map-sale-price">
		//						$148.00
		//					</span>

		                    $price_beginning_pos = strpos($target_html, "<p class=\"price price-label\">" , $title_ending_pos);
		                    $price_beginning_pos += strlen("<p class=\"price price-label\">");
		                    $price_beginning_pos = strpos($target_html, "$" , $price_beginning_pos);
		                    $price_beginning_pos += 1;

		                    	//if $ location is greater than the next item
		                    	$pos_next_item = strpos($target_html, $item_listing_begin_tag , $pos_link_ending);
		                    	if($price_beginning_pos > $pos_next_item && $pos_next_item !== false){
		                    		//no price is displayed
				                    $price = 'unknown';
		                    	}
		                    	else{
				                    $price_ending_pos = strpos($target_html, "." , $price_beginning_pos);
				                    $price_ending_pos+=3;
				                    $price_length = $price_ending_pos - $price_beginning_pos;
				                    $price = substr($target_html, $price_beginning_pos, $price_length);
		                    	}
		                    	//$price = str_replace("</p>", "", $price);






		                                        	//description

		//    				<div class="tab-content">
		//					Power and speed redefined.
		//					Enjoy the power of an Android smartphone, without a contract, with the Boost Mobile LG Volt No-Contract Phone.  It's powered by Android 4.4 and a 1.2GHz quad-core processor, so you'll be able to surf the Web, stream videos and share your memories faster than ever. Plus, Google Play gives you access to hundreds of thousands of books, music, movies, TV shows and apps.
		//					<ul><li>1.2GHz quad-core processor delivers seamless performance and power</li><li>Android 4.4 (KitKat) offers a more polished design, improved performance and new features</li><li>Experience all of your favorite media on the 4.7" qHD IPS display with durable Corning Gorilla Glass</li><li>QSlide Function gives you quick access to videos, calendars, your browser and more</li><li>Knock Code gives you quick, secure access to your phone with your personalized tap pattern</li><li>Powerful, removable 3000mAh battery delivers up to 24 hours of talk time*</li><li>Built-in 8MP rear-facing camera for crisp, sharp photos and 1080p HD video</li><li>Video chat using the 1.3-megapixel front-facing camera</li><li>Guest Mode gives you peace of mind when sharing your phone with others</li><li>Turn your LG Volt into a remote control for your multiple-room, home TV and cable box with QRemote</li><li>At Google Play, you can browse and download thousands of free and paid apps from around the world</li><li>One-click access to Facebook, Twitter and more</li><li>Wi-Fi connectivity: 802.11 b/g/n; Bluetooth connectivity: 4.0</li><li>8GB storage capacity expandable to 32GB via microSD memory cards (not included)</li></ul>
		//					<div class="right-description">
		                	$item_html = fread_url($item_link);


		                    $description_beginning_pos = strpos($item_html, "<span itemprop=\"description\">" , 0);
		                    if($description_beginning_pos === false){
			                    $description_beginning_pos = strpos($item_html, "<ul class=\"normal-list\">" , 0);
		                        $description_ending_pos = strpos($item_html, "</ul>" , $description_beginning_pos);
		 						$description_ending_pos += strlen("</ul>");	      
		                        $description_length = $description_ending_pos - $description_beginning_pos;
		                   		$description = substr($item_html, $description_beginning_pos, $description_length);                         	
		                    }
		                    else{
		                    	$description_beginning_pos += strlen("<span itemprop=\"description\">");
		                        $description_ending_pos = strpos($item_html, "</span>" , $description_beginning_pos);
		                        $description_length = $description_ending_pos - $description_beginning_pos;
		                   		$description = substr($item_html, $description_beginning_pos, $description_length);                         	


			                    $description_beginning_pos = strpos($item_html, "<ul class=\"normal-list\">" , 0);
		                        $description_ending_pos = strpos($item_html, "</ul>" , $description_beginning_pos);
		 						$description_ending_pos += strlen("</ul>");	      
		                        $description_length = $description_ending_pos - $description_beginning_pos;
		                   		$description = $description . "\n" . substr($item_html, $description_beginning_pos, $description_length);   
		                    }




		                    	//image
		//<img class="productthumbnail" src="http://demandware.edgesuite.net/sits_pod26/dw/image/v2/AASR_PRD/on/demandware.static/Sites-radioshack-Site/Sites-master-catalog/default/v1429999232272/images/01709883_01.jpg?sw=89&amp;sh=89&amp;sm=fit" alt="Boost Mobile LG Volt No-Contract Phone, " title="Boost Mobile LG Volt No-Contract PhoneBoost Mobile LG Volt No-Contract Phone, " data-lgimg='{"url":"http://demandware.edgesuite.net/sits_pod26/dw/image/v2/AASR_PRD/on/demandware.static/Sites-radioshack-Site/Sites-master-catalog/default/v1429999232272/images/01709883_01.jpg?sw=350&amp;sh=350&amp;sm=fit", "title":"Boost Mobile LG Volt No-Contract Phone, ", "alt":"Boost Mobile LG Volt No-Contract Phone, ", "hires":"http://demandware.edgesuite.net/aasr_prd/on/demandware.static/Sites-radioshack-Site/Sites-master-catalog/default/v1429999232272/images/01709883_01.jpg"}'/>								 
		//							</a>


		                    $image_beginning_pos = strpos($item_html, "<img itemprop=\"image\"", 0);
		                    $image_beginning_pos = strpos($item_html, "src=\"", $image_beginning_pos);
		                    $image_beginning_pos += strlen("src=\"");					    
		                    $image_ending_pos = strpos($item_html, "\"" , $image_beginning_pos);
		                    $image_length = $image_ending_pos - $image_beginning_pos;
		                    $image = substr($item_html, $image_beginning_pos, $image_length);
		                    

		                    //add to table
		                    //continue
		                    //$description = str_replace("<li>", "", $description);
		                    //$description = str_replace("<ul>", "", $description);
		                    //$description = str_replace("<ol>", "", $description);
		                    //$description = str_replace("</li>", "<br>", $description);

		                    //echo "description beg: $pos_description_beginning<br>";
		                    //echo "description end: $pos_description_ending<br>";
		                    //echo "description length: $description_string_length<br>";
		                    
		                    // Note use of ===.  Simply == would not work as expected
		                    // because the position of 'a' was the 0th (first) character.
		                    //echo "The string was found and exists at position $pos.<br>";
							$title = str_replace(",", " - ",$title);
		                    $showAddToFavorites = "";
		                    $formatedFavoritesInfo = "$item_link,$image,$title,$price,Target";
		                    if(isset($_COOKIE['username'])){
									$formatedFavoritesInfo = $_COOKIE['username'] . ',' . $formatedFavoritesInfo;
									//$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'><input type='hidden' name='itemname' value='$formatedFavoritesInfo'>";
									$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'>
									<input type='hidden' name='itemname' value='$formatedFavoritesInfo'>
									<input type='hidden' name='search_button' value='clicked'>
									<input type='hidden' name='search_term' value='$search_term2'>
									";

		                    }

	echo "<form>
	  <div class='col-sm-4 col-md-4'>
	    <div class='thumbnail' style='height:400px; width:350px; text-align: center; background-color:#FF5959;'>
	    <h4><u>Target</u></h4>
	  	<br>
	      <a href='$item_link'><img src='$image' style='height:150px;' alt='...'></a><br>
	        <b>$title</b><br>
	        \$$price<br><br>
	        <a href='$item_link' class='btn btn-primary' role='button'>Link</a>$showAddToFavorites
	    </div>
	  </div>
	</form>";

		                    $pos = $pos_link_ending;                 
		                }
		                //TARGET PRODUCT LISTINGS



		                //AMAZON PRODUCT LISTINGS
		                $amazon_url = 'http://www.amazon.com/s/ref=sr_ex_n_0?fst=as%3Aoff&rh=i%3Aaps%2Ck%3Ashoes&keywords=' . $search_term;
		                $amazon_html = fread_url($amazon_url);
		                $item_listing_begin_tag   = '<li id="result_';
		                $pos = 0;



		                while($item_listing_begin_tag){
		                    //Search for the next product listing, if it does not exist, break from while loop 
		                    $pos = strpos($amazon_html, $item_listing_begin_tag, $pos);            
		                    if ($pos === false) {
		                        //echo "The string was not found";
		                        break;
		                    } 


		                    //extract name, picture, price, description
		                    //data-name="..."
		                    $pos_name_beginning = strpos($amazon_html, 'a-text-normal">', $pos);
		                    $pos_name_beginning = $pos_name_beginning + strlen('a-text-normal">');

		                    $pos_name_ending = strpos($amazon_html, '</h2></a>', $pos_name_beginning);
		                    $pos_name_ending = $pos_name_ending;
		                    $name_string_length = $pos_name_ending - $pos_name_beginning ;
		                    $name = substr($amazon_html, $pos_name_beginning, $name_string_length);

		                    //echo "name beg: $pos_name_beginning<br>";
		                    //echo "name end: $pos_name_ending<br>";
		                    //echo "name length: $name_string_length<br>";

		                    //data-price="..."
		                    $pos_price_beginning = strpos($amazon_html, '<span class="a-size-base a-color-price s-price a-text-bold">', $pos);
		                    $pos_price_beginning = $pos_price_beginning + strlen('<span class="a-size-base a-color-price s-price a-text-bold">');

		                    $pos_price_ending = strpos($amazon_html, '</span></a>', $pos_price_beginning);
		                    $pos_price_ending = $pos_price_ending;
		                    $price_string_length = $pos_price_ending - $pos_price_beginning;
		                    $price = substr($amazon_html, $pos_price_beginning, $price_string_length);
		                    //echo "price beg: $pos_price_beginning<br>";
		                    //echo "price end: $pos_price_ending<br>";
		                    //echo "price length: $price_string_length<br>";

		                    $pos_link_beginning = strpos($amazon_html, '<a class="a-link-normal a-text-normal" href=', $pos);
		                    $pos_link_beginning = $pos_link_beginning + strlen("<a class='a-link-normal a-text-normal' href=") + 1;

		                    $pos_link_ending = strpos($amazon_html, '">' , $pos_link_beginning);
		                    $pos_link_ending = $pos_link_ending;
		                    $link_string_length = $pos_link_ending - $pos_link_beginning;
		                    $link = /*"http://www.amazon.com" . */substr($amazon_html, $pos_link_beginning, $link_string_length);

		                    //Image
		                    $pos_img_beginning = strpos($amazon_html, '<img alt="Product Details" src="', $pos);
		                    $pos_img_beginning = $pos_img_beginning + strlen('<img alt="Product Details" src="');

		                    $pos_img_ending = strpos($amazon_html, '" onload="', $pos_img_beginning);
		                    $pos_img_ending = $pos_img_ending;
		                    $img_string_length = $pos_img_ending - $pos_img_beginning;
		                    $img = substr($amazon_html, $pos_img_beginning, $img_string_length);
		                    //echo "image beg: $pos_img_beginning<br>";
		                    //echo "image end: $pos_img_ending<br>";
		                    //echo "image length: $img_string_length<br>";
		                    /*
		                    //Description
		                    $pos_description_beginning = strpos($amazon_html, 'Product Description</span><br><span class="a-size-small a-color-secondary">', $pos);
		                    $pos_description_beginning = $pos_description_beginning + strlen('Product Description</span><br><span class="a-size-small a-color-secondary">');

		                    $pos_description_ending = strpos($amazon_html,'</span></div><div class="a-row a-spacing-mini"><div class="a-row a-spacing-mini">', $pos_description_beginning);
		                    $pos_description_ending = $pos_description_ending;
		                    $description_string_length = $pos_description_ending - $pos_description_beginning;
		                    $description = substr($amazon_html, $pos_description_beginning, $description_string_length);
		                    
		                    // Provides: <body text='black'>
		                    $description = str_replace("<li>", "", $description);
		                    $description = str_replace("<ul>", "", $description);
		                    $description = str_replace("<ol>", "", $description);
		                    $description = str_replace("</li>", "<br>", $description);

		                    //echo "description beg: $pos_description_beginning<br>";
		                    //echo "description end: $pos_description_ending<br>";
		                    //echo "description length: $description_string_length<br>";
		                    */
		                    // Note use of ===.  Simply == would not work as expected
		                    // because the position of 'a' was the 0th (first) character.
		                    //echo "The string was found and exists at position $pos.<br>";
		                    if(strlen($name) > 100){
		                    	$name = substr($name, 0, 100);

		                    	if(substr($name, 0, strlen("Sponsored")) == "Sponsored"){
		                    		$name = "Sponsored";
			                    	$img = '';
			                    	$name = '';
			                    	$link = '';
			                    	$price = 'Parse Error';
		                    	}
		                    }
		                    if(strlen($price) > 100){
		                    	$price = substr($price, 0, 100);
		                    }

							$name = str_replace(",", " - ",$name);
		                    $showAddToFavorites = "";
		                    $formatedFavoritesInfo = "$link,$img,$name,$price,Amazon";
		                    if(isset($_COOKIE['username'])){
									$formatedFavoritesInfo = $_COOKIE['username'] . ',' . $formatedFavoritesInfo;
									//$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'><input type='hidden' name='itemname' value='$formatedFavoritesInfo'>";
									$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'>
									<input type='hidden' name='itemname' value='$formatedFavoritesInfo'>
									<input type='hidden' name='search_button' value='clicked'>
									<input type='hidden' name='search_term' value='$search_term2'>
									";

		                    }

	echo "<form>
	  <div class='col-sm-4 col-md-4'>
	    <div class='thumbnail' style='height:400px; width:350px; text-align: center; background-color:#FFC266;'>
	    <h4><u>Amazon</u></h4>
	  	<br>
	      <a href='$link'><img src='$img' style='height:150px;'  alt='...'></a><br>
	        <b>$name</b><br>
	        $price<br><br>
	        <a href='$link' class='btn btn-primary' role='button'>Link</a>$showAddToFavorites
	    </div>
	  </div>
	</form>";


		                    $pos = $pos_img_ending;                    
		                }
		                //AMAZON PRODUCT LISTINGS

		                //MACY'S PRODUCT LISTING
		                $macys_url = 'http://www1.macys.com/shop/search?keyword=' . $search_term;
		                $macys_html = fread_url($macys_url);
		                $item_listing_begin_tag   = 'productThumbnailJSON';
		                $pos = 0;

		                while(true){
		                    //Search for the next product listing, if it does not exist, break from while loop 
		                    $pos = strpos($macys_html, $item_listing_begin_tag, $pos);            
		                    if ($pos === false) {
		                        //echo "The string was not found";
		                        break;
		                    } 


		                    //extract name, picture, price, description
		                    //data-name="..."
		                    $pos_name_beginning = strpos($macys_html, "title=", $pos);
		                    $pos_name_beginning = $pos_name_beginning + strlen("title=") + 1;

		                    $pos_name_ending = strpos($macys_html, "alt=", $pos_name_beginning);
		                    $pos_name_ending = $pos_name_ending - 2;
		                    $name_string_length = $pos_name_ending - $pos_name_beginning ;
		                    $name = substr($macys_html, $pos_name_beginning, $name_string_length);

		                    //echo "name beg: $pos_name_beginning<br>";
		                    //echo "name end: $pos_name_ending<br>";
		                    //echo "name length: $name_string_length<br>";

		                    //data-price="..."
		                    $pos_price_beginning = strpos($macys_html, 'Reg. ', $pos);
		                    $pos_price_beginning = $pos_price_beginning + strlen('Reg. ');

		                    $pos_price_ending = strpos($macys_html, '</span><br />', $pos_price_beginning);
		                    $pos_price_ending = $pos_price_ending;
		                    $price_string_length = $pos_price_ending - $pos_price_beginning;
		                    $price = substr($macys_html, $pos_price_beginning, $price_string_length);
		                    //echo "price beg: $pos_price_beginning<br>";
		                    //echo "price end: $pos_price_ending<br>";
		                    //echo "price length: $price_string_length<br>";

		                    $pos_link_beginning = strpos($macys_html, '<a href="', $pos);
		                    $pos_link_beginning = $pos_link_beginning + strlen('<a href="');

		                    $pos_link_ending = strpos($macys_html, '" class=' , $pos_link_beginning);
		                    $pos_link_ending = $pos_link_ending;
		                    $link_string_length = $pos_link_ending - $pos_link_beginning;
		                    $link = "http://www1.macys.com" . substr($macys_html, $pos_link_beginning, $link_string_length);

		                    //Image
		                    $pos_img_beginning = strpos($macys_html, 'data-src="', $pos);
		                    $pos_img_beginning = $pos_img_beginning + strlen('data-src="');

		                    $pos_img_ending = strpos($macys_html, '"', $pos_img_beginning);
		                    $pos_img_ending = $pos_img_ending;
		                    $img_string_length = $pos_img_ending - $pos_img_beginning;
		                    $img = substr($macys_html, $pos_img_beginning, $img_string_length);
		                    //echo "image beg: $pos_img_beginning<br>";
		                    //echo "image end: $pos_img_ending<br>";
		                    //echo "image length: $img_string_length<br>";

		                    //Description
		                    /*
		                    $pos_description_ending = strpos($best_buy_html, "</div>", $pos_description_beginning);
		                    $pos_description_ending = $pos_description_ending;
		                    $description_string_length = $pos_description_ending - $pos_description_beginning;
		                    $description = substr($best_buy_html, $pos_description_beginning, $description_string_length);
		                    
		                    // Provides: <body text='black'>
		                    $description = str_replace("<li>", "", $description);
		                    $description = str_replace("<ul>", "", $description);
		                    $description = str_replace("<ol>", "", $description);
		                    $description = str_replace("</li>", "<br>", $description);
		                    */
		                    //echo "description beg: $pos_description_beginning<br>";
		                    //echo "description end: $pos_description_ending<br>";
		                    //echo "description length: $description_string_length<br>";
		                    
		                    // Note use of ===.  Simply == would not work as expected
		                    // because the position of 'a' was the 0th (first) character.
		                    //echo "The string was found and exists at position $pos.<br>";
		                    if(strlen($img) > 200){
		                    	$img = 'Image Parse Error';
		                    }
		                    if(strlen($name) > 200){
		                    	$name = 'Name Parse Error';
		                    }
		                    if(strlen($link) > 200){
		                    	$link = 'Link Parse Error';
		                    }		
		                    if(strlen($price) > 200){
		                    	$price = 'Price Parse Error';
		                    }

							$name = str_replace(",", " - ",$name);
		                    $showAddToFavorites = "";
		                    $formatedFavoritesInfo = "$link,$img,$name,$price,Macy's";
		                    if(isset($_COOKIE['username'])){
									$formatedFavoritesInfo = $_COOKIE['username'] . ',' . $formatedFavoritesInfo;
									//$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'><input type='hidden' name='itemname' value='$formatedFavoritesInfo'>";
									$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'>
									<input type='hidden' name='itemname' value='$formatedFavoritesInfo'>
									<input type='hidden' name='search_button' value='clicked'>
									<input type='hidden' name='search_term' value='$search_term2'>
									";

		                    }

	echo "<form>
	  <div class='col-sm-4 col-md-4'>
	    <div class='thumbnail' style='height:400px; width:350px; text-align: center; background-color:#FF4D4D;'>
	    <h4><u>Macy's</u></h4>
	  	<br>
	      <a href='$link'><img src='$img' style='height:150px;' alt='...'></a><br>
	        <b>$name</b><br>
	        $price<br><br>
	        <a href='$link' class='btn btn-primary' role='button'>Link</a>$showAddToFavorites
	    </div>
	  </div>
	</form>";


		                    $pos = $pos_img_ending;                    
		                }
		                //MACY'S PRODUCT LISTING


		                //NORDSTROM'S PRODUCT LISTING
                        $nord_url = 'http://shop.nordstrom.com/sr?origin=keywordsearch&contextualcategoryid=2375500&keyword=' . $search_term;
		                $nord_html = fread_url($nord_url);
		                $item_listing_begin_tag   = '<span class="ada-hidden" id="ada-title">';
		                $pos = 0;



		                while(true){
		                    //Search for the next product listing, if it does not exist, break from while loop 
		                    $pos = strpos($nord_html, $item_listing_begin_tag, $pos);            
		                    if ($pos === false) {
		                        //echo "The string was not found";
		                        break;
		                    } 


		                    //extract name, picture, price, description
		                    //data-name="..."
		                    $pos_name_beginning = strpos($nord_html, 'class="title">', $pos);
		                    $pos_name_beginning = $pos_name_beginning + strlen('class="title">');

		                    $pos_name_ending = strpos($nord_html, '</a><span class="price', $pos_name_beginning);
		                    $pos_name_ending = $pos_name_ending;
		                    $name_string_length = $pos_name_ending - $pos_name_beginning ;
		                    $name = substr($nord_html, $pos_name_beginning, $name_string_length);

		                    //echo "name beg: $pos_name_beginning<br>";
		                    //echo "name end: $pos_name_ending<br>";
		                    //echo "name length: $name_string_length<br>";

		                    //data-price="..."
		                    $pos_price_beginning = strpos($nord_html, '<span class="price regular">', $pos);
		                    $pos_price_beginning = $pos_price_beginning + strlen('<span class="price regular">');

		                    $pos_price_ending = strpos($nord_html, '</span>', $pos_price_beginning);
		                    $pos_price_ending = $pos_price_ending;
		                    $price_string_length = $pos_price_ending - $pos_price_beginning;
		                    $price = substr($nord_html, $pos_price_beginning, $price_string_length);
		                    //echo "price beg: $pos_price_beginning<br>";
		                    //echo "price end: $pos_price_ending<br>";
		                    //echo "price length: $price_string_length<br>";

		                    $pos_link_beginning = strpos($nord_html, '" href="', $pos);
		                    $pos_link_beginning = $pos_link_beginning + strlen('" href="');

		                    $pos_link_ending = strpos($nord_html, '" class="title">' , $pos_link_beginning);
		                    $pos_link_ending = $pos_link_ending;
		                    $link_string_length = $pos_link_ending - $pos_link_beginning;
		                    $link = "http://shop.nordstrom.com" . substr($nord_html, $pos_link_beginning, $link_string_length);

		                    //Image
		                    $pos_img_beginning = strpos($nord_html, 'data-original="', $pos);
		                    $pos_img_beginning = $pos_img_beginning + strlen('data-original="');

		                    $pos_img_ending = strpos($nord_html, '" />', $pos_img_beginning);
		                    $pos_img_ending = $pos_img_ending;
		                    $img_string_length = $pos_img_ending - $pos_img_beginning;
		                    $img = substr($nord_html, $pos_img_beginning, $img_string_length);
		                    //echo "image beg: $pos_img_beginning<br>";
		                    //echo "image end: $pos_img_ending<br>";
		                    //echo "image length: $img_string_length<br>";

		                    //Description
		                    /*
		                    $pos_description_ending = strpos($best_buy_html, "</div>", $pos_description_beginning);
		                    $pos_description_ending = $pos_description_ending;
		                    $description_string_length = $pos_description_ending - $pos_description_beginning;
		                    $description = substr($best_buy_html, $pos_description_beginning, $description_string_length);
		                    
		                    // Provides: <body text='black'>
		                    $description = str_replace("<li>", "", $description);
		                    $description = str_replace("<ul>", "", $description);
		                    $description = str_replace("<ol>", "", $description);
		                    $description = str_replace("</li>", "<br>", $description);
		                    */
		                    //echo "description beg: $pos_description_beginning<br>";
		                    //echo "description end: $pos_description_ending<br>";
		                    //echo "description length: $description_string_length<br>";
		                    
		                    // Note use of ===.  Simply == would not work as expected
		                    // because the position of 'a' was the 0th (first) character.
		                    //echo "The string was found and exists at position $pos.<br>";
		                    if(strlen($img) > 200){
		                    	$img = 'Image Parse Error';
		                    }
		                    if(strlen($name) > 200){
		                    	$name = 'Name Parse Error';
		                    }
		                    if(strlen($link) > 200){
		                    	$link = 'Link Parse Error';
		                    }		
		                    if(strlen($price) > 200){
		                    	$price = 'Price Parse Error';
		                    }

							$name = str_replace(",", " - ",$name);
		                    $showAddToFavorites = "";
		                    $formatedFavoritesInfo = "$link,$img,$name,$price,Nordstrom";
		                    if(isset($_COOKIE['username'])){
									$formatedFavoritesInfo = $_COOKIE['username'] . ',' . $formatedFavoritesInfo;
									//$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'><input type='hidden' name='itemname' value='$formatedFavoritesInfo'>";
									$showAddToFavorites = "&nbsp;&nbsp;<input type='submit' name='itemnamesubmit' value='Add'>
									<input type='hidden' name='itemname' value='$formatedFavoritesInfo'>
									<input type='hidden' name='search_button' value='clicked'>
									<input type='hidden' name='search_term' value='$search_term2'>
									";

		                    }

	echo "<form>
	  <div class='col-sm-4 col-md-4'>
	    <div class='thumbnail' style='height:400px; width:350px; text-align: center; background-color:#C0C0C0;'>
	    <h4><u>Nordstrom</u></h4>
	  	<br>
	      <a href='$link'><img src='$img' style='height:150px;' alt='...'></a><br>
	        <b>$name</b><br>
	        $price<br><br>
	        <a href='$link' class='btn btn-primary' role='button'>Link</a>$showAddToFavorites
	    </div>
	  </div>
	</form>";

		                    $pos = $pos_img_ending;                    
		                }
		                //NORDSTROM'S PRODUCT LISTING

		        //uncomment the following block to search for some hyperlinks listed on the website page located at url_base_to_crawl
		        /*
			    $var = fread_url($_GET['url_base_to_crawl']);
			    
			    //http://www.web-max.ca/PHP/misc_23.php
			    preg_match_all ("/a[\s]+[^>]*?href[\s]?=[\s\"\']+".
			                    "(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/", 
			                    $var, $matches);
			        
			    $matches = $matches[1];
			    $list = array();

			    foreach($matches as $var)
			    {    
			        print($var."<br>");
			    }
		        */


			}
		?>



		<?php
			//get hyperlinks from url
		    //function from: http://www.web-max.ca/PHP/misc_23.php
		    function fread_url($url,$ref="")
		    {
		        if(function_exists("curl_init")){
		            $ch = curl_init();
		            $user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; ".
		                          "Windows NT 5.0)";
		            $ch = curl_init();
		            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		            curl_setopt( $ch, CURLOPT_HTTPGET, 1 );
		            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION , 1 );
		            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION , 1 );
		            curl_setopt( $ch, CURLOPT_URL, $url );
		            curl_setopt( $ch, CURLOPT_REFERER, $ref );
		            curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		            $html = curl_exec($ch);
		            curl_close($ch);
		        }
		        else{
		            $hfile = fopen($url,"r");
		            if($hfile){
		                while(!feof($hfile)){
		                    $html.=fgets($hfile,1024);
		                }
		            }
		        }
		        return $html;
		    }
		?>




		<?php
	function getfavorites($username){
		$conn = mysqli_connect("localhost", "shinw", "Z57EBjVi", "shinw");
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

	   	$query = "SELECT favorites FROM crawler WHERE username='$username'";

	   	$favorites = "";


		if ($result = mysqli_query($conn, $query)) {
	   		while ($row = mysqli_fetch_assoc($result)) {
	   			$favorites = $row['favorites'];
	   		}
		    mysqli_free_result($result);
		}
	 	mysqli_close($conn);

	 	return $favorites;
	}

	function lookupmemberusername($username){
		$conn = mysqli_connect("localhost", "shinw", "Z57EBjVi", "shinw");
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

	   	$query = "SELECT * FROM crawler WHERE username='$username'";

	   	$memberfound = false;

		if ($result = mysqli_query($conn, $query)) {
	   		while ($row = mysqli_fetch_assoc($result)) {
	   			$memberfound = true;
	   		}
		    mysqli_free_result($result);
		}
	 	mysqli_close($conn);

	 	return $memberfound;
	}

	function loginmember($username, $password){
		$conn = mysqli_connect("localhost", "shinw", "Z57EBjVi", "shinw");
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

	   	$query = "SELECT * FROM crawler WHERE username='$username' AND password='$password'";

	   	$memberfound = false;

		if ($result = mysqli_query($conn, $query)) {
	   		while ($row = mysqli_fetch_assoc($result)) {
	   			$memberfound = true;
	   		}
		    mysqli_free_result($result);
		}
	 	mysqli_close($conn);

	 	return $memberfound;
	}

	function insertmemberfavorite($username, $favorite){
		$conn = mysqli_connect("localhost", "shinw", "Z57EBjVi", "shinw");
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

		$query = "UPDATE crawler SET favorites='$favorite' WHERE username='$username'";
		$result = mysqli_query($conn, $query);
	 	mysqli_close($conn);
	}

	function insertnewmember($username, $password){
		$conn = mysqli_connect("localhost", "shinw", "Z57EBjVi", "shinw");
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

		$query = "INSERT INTO crawler (username, password, favorites)
		   			   VALUES ('$username', '$password', '')";
		$result = mysqli_query($conn, $query);
	 	mysqli_close($conn);
	}



?>
  </body>
</html>
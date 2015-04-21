 <!DOCTYPE html>
 <!-- http://cscilab.bc.edu/~shinw/wonseokshin/assignments/finalproject/index.php -->
<html>
 <head>
  <meta charset="UTF-8">
  <title>Final Project - Lisa Huang - Won Seok Shin</title>

  <style>
      .bestbuytable {
        margin:0px;padding:0px;
        width:100%;
        box-shadow: 10px 10px 5px #888888;
        border:1px solid #000000;
        
        -moz-border-radius-bottomleft:25px;
        -webkit-border-bottom-left-radius:25px;
        border-bottom-left-radius:25px;
        
        -moz-border-radius-bottomright:25px;
        -webkit-border-bottom-right-radius:25px;
        border-bottom-right-radius:25px;
        
        -moz-border-radius-topright:25px;
        -webkit-border-top-right-radius:25px;
        border-top-right-radius:25px;
        
        -moz-border-radius-topleft:25px;
        -webkit-border-top-left-radius:25px;
        border-top-left-radius:25px;
    }.bestbuytable table{
        border-collapse: collapse;
            border-spacing: 0;
        width:100%;
        height:100%;
        margin:0px;padding:0px;
    }.bestbuytable tr:last-child td:last-child {
        -moz-border-radius-bottomright:25px;
        -webkit-border-bottom-right-radius:25px;
        border-bottom-right-radius:25px;
    }
    .bestbuytable table tr:first-child td:first-child {
        -moz-border-radius-topleft:25px;
        -webkit-border-top-left-radius:25px;
        border-top-left-radius:25px;
    }
    .bestbuytable table tr:first-child td:last-child {
        -moz-border-radius-topright:25px;
        -webkit-border-top-right-radius:25px;
        border-top-right-radius:25px;
    }.bestbuytable tr:last-child td:first-child{
        -moz-border-radius-bottomleft:25px;
        -webkit-border-bottom-left-radius:25px;
        border-bottom-left-radius:25px;
    }.bestbuytable tr:hover td{
        
    }
    .bestbuytable tr:nth-child(odd){ background-color:#ffff56; }
    .bestbuytable tr:nth-child(even)    { background-color:#007fff; }.bestbuytable td{
        vertical-align:middle;
        
        
        border:1px solid #000000;
        border-width:0px 1px 1px 0px;
        text-align:center;
        padding:7px;
        font-size:10px;
        font-family:Arial;
        font-weight:normal;
        color:#000000;
    }.bestbuytable tr:last-child td{
        border-width:0px 1px 0px 0px;
    }.bestbuytable tr td:last-child{
        border-width:0px 0px 1px 0px;
    }.bestbuytable tr:last-child td:last-child{
        border-width:0px 0px 0px 0px;
    }
    .bestbuytable tr:first-child td{
            background:-o-linear-gradient(bottom, #000000 5%, #ffffaa 100%);    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #000000), color-stop(1, #ffffaa) );
        background:-moz-linear-gradient( center top, #000000 5%, #ffffaa 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#000000", endColorstr="#ffffaa");  background: -o-linear-gradient(top,#000000,ffffaa);

        background-color:#000000;
        border:0px solid #000000;
        text-align:center;
        border-width:0px 0px 1px 1px;
        font-size:14px;
        font-family:Arial;
        font-weight:bold;
        color:#00ffff;
    }
    .bestbuytable tr:first-child:hover td{
        background:-o-linear-gradient(bottom, #000000 5%, #ffffaa 100%);    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #000000), color-stop(1, #ffffaa) );
        background:-moz-linear-gradient( center top, #000000 5%, #ffffaa 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#000000", endColorstr="#ffffaa");  background: -o-linear-gradient(top,#000000,ffffaa);

        background-color:#000000;
    }
    .bestbuytable tr:first-child td:first-child{
        border-width:0px 0px 1px 0px;
    }
    .bestbuytable tr:first-child td:last-child{
        border-width:0px 0px 1px 1px;
    }
  </style>
 </head>


 <body>
 	<form method="get">
 		<fieldset><legend>Crawl From Base URL</legend>
            Base URL: <input type="text" name="url_base_to_crawl"><br>
            Search Best Buy: <input type="text" name="best_buy_search_term"><br>
	 		<input type="submit" name="submitcrawl" value="Start Crawling">
 		</fieldset>
 	</form><br>



 	 <?php

 	 if(isset($_GET['submitcrawl']) && isset($_GET['url_base_to_crawl'])){
            //scraping product listings from bestbuy.com
            if(isset($_GET['best_buy_search_term'])){
                $best_buy_url = 'http://www.bestbuy.com/site/searchpage.jsp?keys=keys&ks=960&usc=All%20Categories&iht=y&list=n&qp=soldby_facet%3DSold%20By~Best%20Buy&sp=&nrp=15&cp=1&sc=Global&type=page&id=pcat17071&_dyncharset=UTF-8&st=' . $_GET['best_buy_search_term'];
                $best_buy_html = fread_url($best_buy_url);
                $item_listing_begin_tag   = '</div><div class="list-item"';
                $pos = 0;


                echo "<div class='bestbuytable'><table border='1'>";
                echo "<caption>From Best Buy</caption>";

                //Table Headers
                echo "<tr>";
                    echo "<td>Image</td>";
                    echo "<td> Name / Price / Description</td>";
                echo "</tr>";
                while(true){
                    //Search for the next product listing, if it does not exist, break from while loop 
                    $pos = strpos($best_buy_html, $item_listing_begin_tag, $pos);            
                    if ($pos === false) {
                        //echo "The string was not found";
                        break;
                    } 


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
                    echo "<tr>";
                        echo "<td><img src='$img' alt='thumbnail'></td>";

                        echo "<td>";
                        echo "<b>$name</b><br>";
                        echo "<i>  <a href='$link'>$link</a>         </i><br><br>";

                        echo "Price: $price<br><br>";
                        echo "$description";
                        echo "</td>";
                    echo "</tr>";


                    $pos = $pos_description_ending;                    
                }
                echo "</table></div>";
            }

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

 	if(isset($_GET['submitcrawl']) && isset($_GET['url_base_to_crawl'])){
	    $var = fread_url($_GET['url_base_to_crawl']);
	            
	    //http://stackoverflow.com/questions/18093990/php-regex-to-get-all-image-urls-on-the-page	
	    preg_match_all ( '~(http.*\.)(jpe?g|png|[tg]iff?|svg)~i', 
	                    $var, $matches);
	        
	    $matches = $matches[1];
	    $list = array();

	    foreach($matches as $var)
	    {    
	        print($var."<br>");
	    }
	}


// The fread_url function allows you to get a complete
// page. If CURL is not installed replace the contents with
// a fopen / fget loop

	//get hyperlinks from url
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
    //http://www.web-max.ca/PHP/misc_23.php






?>



 </body>


</html>

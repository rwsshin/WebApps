 <!DOCTYPE html>
 <!-- http://cscilab.bc.edu/~shinw/wonseokshin/assignments/finalproject/index.php -->
<html>
 <head>
  <meta charset="UTF-8">
  <title>Final Project - Lisa Huang - Won Seok Shin</title>

  <style>
  </style>
 </head>


 <body>
 	<form method="get">
 		<fieldset><legend>Crawl From Base URL</legend>
            Base URL: <input type="text" name="url_base_to_crawl"><br>
            Search Nordstrom's: <input type="text" name="nord_search_term"><br>
	 		<input type="submit" name="submitcrawl" value="Start Crawling">
 		</fieldset>
 	</form><br>



 	 <?php

 	 if(isset($_GET['submitcrawl']) && isset($_GET['url_base_to_crawl'])){
            //scraping product listings from nord.com
            if(isset($_GET['nord_search_term'])){
                $nord_url = 'http://shop.nordstrom.com/sr?origin=keywordsearch&contextualcategoryid=2375500&keyword=' . $_GET['nord_search_term'];
                $nord_html = fread_url($nord_url);
                $item_listing_begin_tag   = '<span class="ada-hidden" id="ada-title">';
                $pos = 0;


                echo "<div class='nordtable'><table border='1'>";
                echo "<caption>From Nordstrom's</caption>";

                //Table Headers
                echo "<tr>";
                    echo "<td>Image</td>";
                    echo "<td> Name / Price / Description</td>";
                echo "</tr>";
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
                    echo "<tr>";
                        echo "<td><img src='$img' alt='thumbnail'></td>";

                        echo "<td>";
                        echo "<b>$name</b><br>";
                        echo "<i>  <a href='$link'>$link</a>         </i><br><br>";

                        echo "Price: $price<br><br>";
                        //echo "$description";
                        echo "</td>";
                    echo "</tr>";


                    $pos = $pos_img_ending;                    
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

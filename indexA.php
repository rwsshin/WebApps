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
            Search Amazon: <input type="text" name="amazon_search_term"><br>
	 		<input type="submit" name="submitcrawl" value="Start Crawling">
 		</fieldset>
 	</form><br>



 	 <?php

 	 if(isset($_GET['submitcrawl']) && isset($_GET['url_base_to_crawl'])){
            //scraping product listings from amazon.com
            if(isset($_GET['amazon_search_term'])){
                $amazon_url = 'http://www.amazon.com/s/ref=sr_ex_n_0?fst=as%3Aoff&rh=i%3Aaps%2Ck%3Ashoes&keywords=' . $_GET['amazon_search_term'];
                $amazon_html = fread_url($amazon_url);
                $item_listing_begin_tag   = '<li id="result_';
                $pos = 0;


                echo "<div class='amazontable'><table border='1'>";
                echo "<caption>From Amazon</caption>";

                //Table Headers
                echo "<tr>";
                    echo "<td>Image</td>";
                    echo "<td> Name / Price / Description</td>";
                echo "</tr>";
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
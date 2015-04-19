 <!DOCTYPE html>
 <!-- http://cscilab.bc.edu/~shinw/wonseokshin/assignments/finalproject/index.php -->
<html>
 <head>
  <meta charset="UTF-8">
  <title>Final Project - Lisa Huang - Won Seok Shin</title>
 </head>


 <body>
 	<form method="get">
 		<fieldset><legend>Crawl From Base URL</legend>
	 		Base URL: <input type="text" name="url_base_to_crawl"><br>
	 		<input type="submit" name="submitcrawl" value="Start Crawling">
 		</fieldset>
 	</form><br>



 	 <?php

 	 if(isset($_GET['submitcrawl']) && isset($_GET['url_base_to_crawl'])){
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

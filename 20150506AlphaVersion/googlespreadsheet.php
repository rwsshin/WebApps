<?php
	$stringFavorites = getfavorites($_COOKIE['username']);
	$stringFavorites = urlencode($stringFavorites);

	$urlToCall = "https://script.google.com/a/macros/bc.edu/s/AKfycbyjKEQF7TmAU0YHXWzQ74rKRnviWpLC63VRICMgQxofqz3xF7C3/exec?favoritesstring=" . $stringFavorites;
	//$urlToCall = "https://script.google.com/a/macros/bc.edu/s/AKfycbyjKEQF7TmAU0YHXWzQ74rKRnviWpLC63VRICMgQxofqz3xF7C3/exec?favoritesstring=a,b,c,d,1";

	//fread_url($urlToCall);


	//fopen($urlToCall, "r");

    //$response = drupal_http_request($urlToCall);

	$xml = file_get_contents("$urlToCall");

	//$response = http_get($urlToCall, array("timeout"=>1), $info);
	//print_r($info);

	echo "<a href='https://docs.google.com/spreadsheets/d/1ACuOqrN3hjms41H0Rz2BOtTuxGHb-GWYUOr_ZVNCD_0/edit?usp=sharing'>View Favorites In Google Spreadsheet</a>";


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

?>
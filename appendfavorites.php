<?php
	insertmemberfavorite($_COOKIE['username'], $_GET['favoritesButton']);
	header( "Location: index.php");


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



	function insertmemberfavorite($username, $favorite){
		$currentFavorites = getfavorites($username);
		$favorite = $currentFavorites . "," . $favorite;

		$conn = mysqli_connect("localhost", "shinw", "Z57EBjVi", "shinw");
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

		$query = "UPDATE crawler SET favorites='$favorite' WHERE username='$username'";
		$result = mysqli_query($conn, $query);
	 	mysqli_close($conn);
	}


?>
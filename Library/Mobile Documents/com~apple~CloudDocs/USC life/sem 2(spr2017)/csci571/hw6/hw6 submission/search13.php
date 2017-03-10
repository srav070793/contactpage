<?php require_once __DIR__.'/php-graph-sdk-5.0.0/src/Facebook/autoload.php'; ?>

<html>
<head>
	<style type="text/css">
		.searchbox{
			position: absolute;
			border: 2px solid #C8C8C8;
			background-color: #F8F8F8;
			height: 170px;
			width: 700px;
			left: 20%;
			padding-left: 10px;
		}
		#formarea{
			height: 200px;
			width: 100%;
		}
		#resultarea{
			height: 1200px;
			width: 100%;
		}
		#boxtitle{
			text-align: center;
			font-size: 1.5em;
			font-style: italic;
			margin-top: 5px;
		}
		#typeselection{
			margin-left: 23px;
		}
		#subbtn{
			margin-left: 58px;
		}
		hr{
			width: 98%;
		}
		#placeval{
			visibility: <?php echo isset($_POST['locbox'])? "visible" :"hidden"; ?>
		}
		hr{
			position: absolute;
			margin-top: -15px;
		}
		#noresults,#albumres, #postres, #noAlbums, #noPosts{
			position: absolute;
			height:20px;
			width:750px;
			margin-left: -20px;
		}
		#noPosts{
			top: 250px;
		}
		#postres{
			top: 250px;
		}
		#resulttab, #albumrestab, #postrestab{
			position: absolute;
			border-collapse: collapse;
			left: 20%;
			padding-left: 10px;
		}
	
		#resulttab, td, th{
			border: 2px solid #C8C8C8;
			background-color: #F8F8F8;
		}
		.albumstabdivDisplay{
			position: absolute;
			top:250px;
			width: 750px;
			height: 500px;
			display: block;
		}
		.albumstabdivDontDisplay{
			display: none;
		}
		.postsDisplay{
			position: absolute;
			top:300px;
			width: 750px;
			height: 500px;
			display: block;
		}
		.postsDontDisplay{
			display: none;
		}
		th{
			background-color: #E8E8E8;
		}
		.displayImages{
			display: table;
		}
		.dontDisplayImages{
			display: none;
		}
		.displayPosts{
			display: block;
		}
		.dontDisplayPosts{
			display: none;
		}
	</style>
	<script type="text/javascript">

		function display_change(selectbox){
			//alert(selectbox.options[selectbox.selectedIndex].value);
			if (selectbox.options[selectbox.selectedIndex].value == "place") {
				document.getElementById("placeval").style["visibility"]= "visible";
				//document.getElementById("locboxid").required=1;
				//document.getElementById("distboxid").required=1;
			}
			else{
				document.getElementById("placeval").style["visibility"]="hidden";
				//document.getElementById("locboxid").required=0;
				//document.getElementById("distboxid").required=0;
			}
		}
		function clear_val(){
			document.getElementById("placeval").style["visibility"]="hidden";
			document.getElementById("locboxid").required=0;
			document.getElementById("distboxid").required=0;
			document.getElementById("keywordboxid").value="";
			document.getElementById("typeselection").selectedIndex=0;
			document.getElementById("resultarea").innerHTML ="";
			document.getElementById("locboxid").value="";
			document.getElementById("distboxid").value="";
		}
		function changeVisibility(element){
			
			var postsdiv = document.querySelector("#postres");
			var noPosts = document.querySelector("#noPosts");
			if(postsdiv!= null){
				var curtop=postsdiv.style.top;
			}
			else{
				var curtop = noPosts.style.top;
			}
			curtop=curtop.substring(0,curtop.length-2);
			//var tabstyle=document.querySelector("#postrestab"); /*sravani*/
			
			if( element.parentNode.nextSibling.className == "displayImages" ){

				element.parentNode.nextSibling.className = "dontDisplayImages";
				curtop=Number(curtop)-110;
				if (postsdiv!= null) {
					postsdiv.style.top=Math.max(250,curtop);
				}
				else{
					noPosts.style.top=Math.max(250,curtop); 
				}
				//tabstyle.style.top = Number(postsdiv.style.top.substring(0,postsdiv.style.top.length-2))+50; /*sravani*/
			
			}else if(element.parentNode.nextSibling.className == "dontDisplayImages"){
				element.parentNode.nextSibling.className = "displayImages";

				//calculate table's height
				var tableHeight=0;
				var tab=document.getElementById("albumrestab");
				for(var i=0,row;row=tab.rows[i];i++){
					
					if (row.className == "displayImages") {
						tableHeight+=100;
					}
					else if (row.className != "dontDisplayImages"){
						tableHeight+=30;
					}
					
				}

				//250 is the top position of the div displayAblumTabtoggle tag
				while (curtop<(tableHeight+250)) {
					curtop=Number(curtop)+110;
				}
				if (postsdiv!= null) {
					postsdiv.style.top=curtop;
				}
				else{
					noPosts.style.top = curtop;
				}
				//tabstyle.style.top = Number(postsdiv.style.top.substring(0,postsdiv.style.top.length-2))+50; /*sravani*/

				
			}
		}
		function resetVisibility(){
			//write table visibility functionality reset set all tr to dontDisplayImages
			//console.log(document.getElementById("albumrestab"));
			var tab=document.getElementById("albumrestab");
			for(var i=0,row;row=tab.rows[i];i++){
				//console.log(row.className);
				if (row.className == "displayImages") {
					row.className = "dontDisplayImages";
				}
			}
			//console.log(document.getElementById("albumres").nextSibling.className);
		}
		function changeVisual(divElement){
			var postsdiv = document.querySelector("#postres");
			var noPosts = document.querySelector("#noPosts");
			if (postsdiv != null) {
				var curtop=postsdiv.style.top;
			}
			else{
				var curtop = noPosts.style.top;
			}
			curtop=curtop.substring(0,curtop.length-2);

			var extent=document.getElementById("albumrestab").getElementsByTagName('th').length;
			//var tabstyle=document.querySelector("#postrestab"); /*sravani*/

			if (divElement.nextSibling.className == "albumstabdivDisplay") {
				divElement.nextSibling.className = "albumstabdivDontDisplay";
				
				//curtop=Number(curtop)-(Number(extent)*30);
				//postsdiv.style.top=Math.max(curtop,250);
				if(postsdiv!= null){
					postsdiv.style.top=250;
				}
				else{
					noPosts.style.top=250;
				}
				resetVisibility();
				//tabstyle.style.top = Number(postsdiv.style.top.substring(0,postsdiv.style.top.length-2))+50; /*sravani*/
			} 
			else if(divElement.nextSibling.className == "albumstabdivDontDisplay"){
				divElement.nextSibling.className = "albumstabdivDisplay";
				//console.log("inside changing to display");
				curtop=Number(curtop)+(Number(extent)*30);
				if(postsdiv!= null){
					postsdiv.style.top=curtop;

					if (document.getElementById("postrestab").className == "displayPosts") {
					changeVisPosts();
				}
				}
				else{
					noPosts.style.top=curtop;
				}
				//tabstyle.style.top = Number(postsdiv.style.top.substring(0,postsdiv.style.top.length-2))+50; /*sravani*/
				//console.log(document.getElementById("postrestab").className);
				
			}
		}
		function changeVisPosts(){
			//console.log(document.getElementById("postrestab"));
			var tab=document.getElementById("postrestab");
			var tabstyle=document.querySelector("#postrestab");
			//console.log(tab.previousSibling.previousSibling);
		
			var postsdiv = document.querySelector("#postres"); 
			//var noPosts = document.querySelector("#noPosts");
			var curtop = postsdiv.style.top;
			curtop=curtop.substring(0,curtop.length-2);
			//console.log(tab.className);
			if(tab.className == "displayPosts"){

				tab.className = "dontDisplayPosts";
				tabstyle.style.top = Number(curtop)+50;
			}
			else if(tab.className == "dontDisplayPosts"){
				tab.className = "displayPosts";
				tabstyle.style.top = Number(curtop)+50;

				//console.log(tab.previousSibling.previousSibling);
				if (tab.previousSibling.previousSibling.className == "albumstabdivDisplay") {
					changeVisual(tab.previousSibling.previousSibling.previousSibling);
					var resettop = postsdiv.style.top;
					resettop=resettop.substring(0,resettop.length-2);
					tabstyle.style.top = Number(resettop)+50;
				}
			}
		}
		function checkVisPlaceVal(){
			//alert("clicked");

			if (document.querySelector("#placeval").style.visibility == "hidden"){
				//console.log("hidden");
				document.querySelector("#placeval").style.visibility == "hidden";	
			}
			else{
				//console.log("visible");
				document.querySelector("#placeval").style.visibility == "visible";
			}
			
		}
		
	</script>
</head>
<body>
	<div id="formarea">
	<div class="searchbox">
		<p id="boxtitle">Facebook Search</p>
		<hr>
		<form name="searchform" id ="searchformid" method="post" validate>
			Keyword<input type="text" name="keywordbox" id = "keywordboxid" value="<?php echo isset($_POST['keywordbox']) && !isset($_POST['clearbtn']) ? $_POST['keywordbox'] : '' ?>" required><br>
			Type:<select id="typeselection" name="typebox" onchange="display_change(this)">
				<option value="user" <?php echo isset($_POST['typebox'])&&($_POST['typebox'] == "user")? ('selected'):('')?>>Users</option>
				<option value="page" <?php echo isset($_POST['typebox'])&&($_POST['typebox'] == "page")? ('selected'):('')?>>Pages</option>
				<option value="event" <?php echo isset($_POST['typebox'])&&($_POST['typebox'] == "event")? ('selected'):('')?>>Events</option>
				<option value="group" <?php echo isset($_POST['typebox'])&&($_POST['typebox'] == "group")? ('selected'):('')?>>Groups</option>
				<option value="place" <?php echo isset($_POST['typebox'])&&($_POST['typebox'] == "place")? ('selected'):('')?>>Places</option>
			</select><br>
			<div id="placeval" style="visibility: hidden">
			Location<input type="text" name="locbox" id="locboxid" value="<?php echo isset($_POST['locbox']) ? $_POST['locbox'] : '' ?>">
			Distance(meters)<input type="text" name="distbox" id="distboxid" value="<?php echo isset($_POST['distbox']) ? $_POST['distbox'] : '' ?>">
			</div>
			<input type="submit" name="submitbtn" value="Search" id="subbtn" onclick="checkVisPlaceVal()">
			<input type="reset" name="clearbtn" value="Clear" onclick="clear_val(); return false;">
		</form>
	</div>
	</div>
	<div id="resultarea">
	<?php 
		if($_SERVER["REQUEST_METHOD"] == "POST"){

			if (isset($_POST['typebox'])&&isset($_POST['keywordbox'])&&isset($_POST['submitbtn'])) {
				
			$searchType= $_POST['typebox'];
			$query_user = $_POST['keywordbox'];
			$query_user = str_replace(' ', '+', $query_user);
			$access_token="EAAULAQ5nmWIBAKJsm8hdYwqZARur3oOANv07bheHLCK2U6WmDcBRZC9kx60bYb6Nd8KHow4BK3ONreZAeptl7ZCqMiZCY877hONUufxBs91sJdgl2PQcsh4x4kotAOiav3e8eRc04pIjIpmTO6ItWwWYYc3CwPcYZD";
			
			if ($searchType == 'user' | $searchType == 'page' | $searchType == 'group') {
				//-----------------------------//

				$fb = new Facebook\Facebook(['app_id'=>'1419474048096610','app_secret'=>'7bd208ef074a9e5a5bbe2299a272081b', 'default_graph_version' => 'v2.5',]);
				
			//-----------------------------//
				if($_POST['keywordbox'] != "") {
					
					$call = "/search?q=".$query_user."&type=".$searchType."&fields=id,name,picture.width(700).height(700)";
				//-----------------------------------//
					try{
						$results1 = $fb->get($call, $access_token);
					}catch(Facebook\Exceptions\FacebookResponseException $e){
						echo "Facebook Exceptions returned an error".$e->getMessage();
						exit;
					}
					catch(Facebook\Exceptions\FacebookSDKException $e){
						echo "Facebook SDK returned an error".$e->getMessage();
						exit;
					}
					
					$results = ($results1->getDecodedBody());
				//------------------------------------//
					/*$ret_val=file_get_contents($call);
					
					$results= json_decode($ret_val);*/
					//if(is_object($results->{"data"})&& isset($results->{"data"})){
						//$results = $results->{"data"}[0];
					$results = $results["data"];
					//}
					

					if (count($results)>0) {
						
						$result_table= "<table id=resulttab>";
						$result_table.= "<tr>";
						$result_table.="<th>Profile Photo</th>";
						$result_table.="<th>Name</th>";
						$result_table.="<th>Details</th>";
						$result_table.="</tr>";
						$result_table.= "<tr>";
						foreach($results as $row) {	
							$result_table.="<tr>";
							$result_table.="<td width= 200px><a href=".$row['picture']['data']['url']." target=_blank><img src=".$row['picture']['data']['url']." width =30 height = 30></a></td>";
							$result_table.="<td width= 430px>".$row['name']."</td>";
							$result_table.="<td width= 100px><form name=loadAlbPosts id=loadid style=\"height:20px;\"method=POST><input type= submit name=detbtn value=Details style=\"position:absolute;left:660;margin-top:10px;text-decoration:underline;color:blue;background-color:transparent;border:none;font-size:14px;\"><input type=text name=idbox value=".$row["id"]." style=\"width:40px;display:none;\"></form></td>";
							$result_table.="</tr>";
						}
						$result_table.="</table>";		
					}
					else{
						$result_table = "<div id = noresults class= searchbox>";
						$result_table.="<center>No records has been found</center>";
						$result_table.="</div>";
					}
					echo $result_table;
				}
			}
			else if($searchType == 'event'){
				$fb = new Facebook\Facebook(['app_id'=>'1419474048096610','app_secret'=>'7bd208ef074a9e5a5bbe2299a272081b', 'default_graph_version' => 'v2.5',]);

				$call = "/search?q=".$query_user."&type=".$searchType."&fields=id,name,picture.width(700).height(700),place";

				try{
						$results1 = $fb->get($call, $access_token);
					}catch(Facebook\Exceptions\FacebookResponseException $e){
						echo "Facebook Exceptions returned an error".$e->getMessage();
						exit;
					}
					catch(Facebook\Exceptions\FacebookSDKException $e){
						echo "Facebook SDK returned an error".$e->getMessage();
						exit;
					}
 					$results = ($results1->getDecodedBody());

 				/*$ret_val=file_get_contents($call);
 				$results= json_decode($ret_val);*/
					$results = $results['data'];
					
					if (count($results)>0) {
					
						$result_table= "<table id=resulttab>";
						$result_table.= "<tr>";
						$result_table.="<th>Profile Photo</th>";
						$result_table.="<th>Name</th>";
						$result_table.="<th>Place</th>";
						$result_table.="</tr>";
						$result_table.= "<tr>";
						foreach($results as $row) {	
							$result_table.="<tr>";
							$result_table.="<td width= 200px><a href=".$row['picture']['data']['url']." target=_blank><img src=".$row['picture']['data']['url']." width =30 height = 30></a></td>";
							$result_table.="<td width= 430px>".$row['name']."</td>";
							$result_table.="<td width= 100px>".$row['place']['name']."</td>";
							$result_table.="</tr>";
						}
						$result_table.="</table>";		
					}
					else{
						$result_table = "<div id = noresults class= searchbox>";
						$result_table.="<center>No records has been found</center>";
						$result_table.="</div>";
					}
					echo $result_table;


			}
			else if($searchType == 'place'){

				$location = $_POST['locbox'];
				$dist =  $_POST['distbox'];

				$location = str_replace(' ', '+', $location);
				$g_call = "https://maps.googleapis.com/maps/api/geocode/json?address=".$location."&key=AIzaSyAcmvkY2dNI2MnXZO7XKEH4nAhPCtu_xLA";


				$geo_loc = file_get_contents($g_call);
				$geoJson = json_decode($geo_loc);

				$lat=$geoJson->results[0]->geometry->location->lat;
				$lng=$geoJson->results[0]->geometry->location->lng;

				$fb = new Facebook\Facebook(['app_id'=>'1419474048096610','app_secret'=>'7bd208ef074a9e5a5bbe2299a272081b', 'default_graph_version' => 'v2.5',]);

				$call = "/search?q=".$query_user."&type=".$searchType."&center=".$lat.",".$lng."&distance=".$dist."&fields=id,name,picture.width(700).height(700)";

				/*$ret_val=file_get_contents($call);
				$results= json_decode($ret_val);*/
				try{
						$results1 = $fb->get($call, $access_token);
					}catch(Facebook\Exceptions\FacebookResponseException $e){
						echo "Facebook Exceptions returned an error".$e->getMessage();
						exit;
					}
					catch(Facebook\Exceptions\FacebookSDKException $e){
						echo "Facebook SDK returned an error".$e->getMessage();
						exit;
					}
 					$results = ($results1->getDecodedBody());

				if ($results["data"]) {
					$results = $results["data"];
				}
				else{
					$results = "";
				}	
				if (count($results)>0) {
					
					$result_table= "<table id=resulttab>";
					$result_table.= "<tr>";
					$result_table.="<th>Profile Photo</th>";
					$result_table.="<th>Name</th>";
					$result_table.="<th>Details</th>";
					$result_table.="</tr>";
					$result_table.= "<tr>";
					foreach($results as $row) {	
						$result_table.="<tr>";
						$result_table.="<td width= 200px><a href=".$row['picture']['data']['url']." target=_blank><img src=".$row['picture']['data']['url']." width =30 height = 30></a></td>";
						$result_table.="<td width= 430px>".$row['name']."</td>";
						$result_table.="<td width= 100px><form name=loadAlbPosts style=\"height:20px;\"method=POST><input type= submit name=detbtn value=Details style=\"position:absolute;left:660;margin-top:10px;text-decoration:underline;color:blue;background-color:transparent;border:none;font-size:14px;\"><input type=text name=idbox value=".$row["id"]." style=\"width:40px;display:none;\"></form></td>";
						$result_table.="</tr>";
					}
					$result_table.="</table>";		
				}
				else{
					$result_table = "<div id = noresults class= searchbox>";
					$result_table.="<center>No records has been found</center>";
					$result_table.="</div>";
				}
				echo $result_table;
			}
			}	

			if (isset($_POST['detbtn'])) {
				$access_token="EAAULAQ5nmWIBAKJsm8hdYwqZARur3oOANv07bheHLCK2U6WmDcBRZC9kx60bYb6Nd8KHow4BK3ONreZAeptl7ZCqMiZCY877hONUufxBs91sJdgl2PQcsh4x4kotAOiav3e8eRc04pIjIpmTO6ItWwWYYc3CwPcYZD";
				
				//call to facebook api
				$fb = new Facebook\Facebook(['app_id'=>'1419474048096610','app_secret'=>'7bd208ef074a9e5a5bbe2299a272081b', 'default_graph_version' => 'v2.5',]);

				$albumsAndPosts=$_POST["idbox"]."?fields=id,name,picture.width(700).height(700),albums.limit(5){name,photos.limit(2){name,%20picture}},posts.limit(5)";	

				try{
						$results1 = $fb->get($albumsAndPosts, $access_token);
					}catch(Facebook\Exceptions\FacebookResponseException $e){
						echo "Facebook Exceptions returned an error".$e->getMessage();
						exit;
					}
					catch(Facebook\Exceptions\FacebookSDKException $e){
						echo "Facebook SDK returned an error".$e->getMessage();
						exit;
					}

				$albumsAndPostsDecoded = ($results1->getDecodedBody());

				//$albumsAndPostsDecoded=json_decode(file_get_contents($albumsAndPosts));
				
				if(isset($albumsAndPostsDecoded["albums"]["data"])){
					$albumDataFound = $albumsAndPostsDecoded["albums"]["data"];
				}
				else{
					$albumDataFound ="";
				}
				if (isset($albumsAndPostsDecoded["posts"]["data"])) {
					$postsDataFound = $albumsAndPostsDecoded["posts"]["data"];
				}
				else{
					$postsDataFound="";
				}

				if ($albumDataFound!=="") {
					//echo "albums div to be loaded";
					$resultsAlbums = "<div id = albumres onclick=changeVisual(this) style=\"background-color:#C8C8C8;color:blue;text-decoration:underline;\" class=searchbox>";
					$resultsAlbums.="<center style=\"cursor:pointer\">";
					$resultsAlbums.="Albums";
					$resultsAlbums.="</center>";
					$resultsAlbums.="</div>";

					if(is_object($albumDataFound)||is_array($albumDataFound)){
					$resultsAlbums.="<div class=albumstabdivDontDisplay id=albumstabtoggle>";
					$resultsAlbums.="<table id=albumrestab style=\"position:absolute;left:300px;\">";
					$hcount=0;
					//$row_count=0;
					//echo $albumDataFound->{"id"};
					
					foreach ($albumDataFound as $row) {

						$colspan=0;
						if(isset($row["photos"]["data"])){
							foreach ($row["photos"]["data"] as $pic) { 
								$colspan=$colspan+1;
							}
						}
						//echo $row->{"photos"}->{"data"}->{"id"};
						if(isset($row["photos"]["data"][0]["id"])){
							$resultsAlbums.="<tr><th style=\"cursor:pointer;text-decoration:underline;color:blue;\" onclick=changeVisibility(this) colspan=2 id=h".$hcount.">";
							$resultsAlbums.= $row["name"];
							$resultsAlbums.="</th></tr>";
						}
						else{

							$resultsAlbums.="<tr><th colspan=2 id=h".$hcount.">";
							$resultsAlbums.= $row["name"];
							$resultsAlbums.="</th></tr>";
						}
						//$row_count=$row_count+1;
						
						if(isset($row["photos"]["data"])){
							$resultsAlbums.="<tr class=dontDisplayImages>";
						
							foreach ($row["photos"]["data"] as $pictobLoaded) { //error
								if($pictobLoaded["id"]){

									$resultsAlbums.="<td>";
//----------------------------------------//
									$access_token="EAAULAQ5nmWIBAKJsm8hdYwqZARur3oOANv07bheHLCK2U6WmDcBRZC9kx60bYb6Nd8KHow4BK3ONreZAeptl7ZCqMiZCY877hONUufxBs91sJdgl2PQcsh4x4kotAOiav3e8eRc04pIjIpmTO6ItWwWYYc3CwPcYZD";
				
									//call to facebook api
									$fb = new Facebook\Facebook(['app_id'=>'1419474048096610','app_secret'=>'7bd208ef074a9e5a5bbe2299a272081b', 'default_graph_version' => 'v2.5',]);

									$facebook_call="/".$pictobLoaded["id"]."/picture?fields=url&redirect=false";
									try{
										$res = $fb->get($facebook_call, $access_token);
									}catch(Facebook\Exceptions\FacebookResponseException $e){
										echo "Facebook Exceptions returned an error".$e->getMessage();
										exit;
									}
									catch(Facebook\Exceptions\FacebookSDKException $e){
										echo "Facebook SDK returned an error".$e->getMessage();
										exit;
									}
									$resload = $res->getDecodedBody();
									$resimg = $resload['data']['url'];

									$resultsAlbums.="<a href=".$resimg." target=_blank><img height=100px width=100px src=".$resimg." alt=picture></a>";
									$resultsAlbums.="</td>";
								}
							}
						
							$resultsAlbums.="</tr>";
						}
						$hcount=$hcount+1;
						
					}	
					$resultsAlbums.="</table>";
					$resultsAlbums.="</div>";
					}
					/*else{
						$resultsAlbums = "<div id = noAlbums class= searchbox>";
						$resultsAlbums.="<center>No albums has been found</center>";
						$resultsAlbums.="</div>";
					}*/
					//posts div tag
					if ($postsDataFound !== "") {
					
						$resultsAlbums.="<div id = postres style=\"background-color:#C8C8C8;top:250px;color:blue;text-decoration:underline;\" class=searchbox onclick=changeVisPosts()>";
				
						$resultsAlbums.="<center style=\"cursor:pointer\">";
						$resultsAlbums.="Posts";
						$resultsAlbums.="</center>";
						$resultsAlbums.="</div>";
						
						if(is_object($postsDataFound)||is_array($postsDataFound)){
						$resultsAlbums.= "<table class=dontDisplayPosts id=postrestab style=\"position:absolute;width:750px;top:300px;left:19%;\">";
						$resultsAlbums.="<tr><th>Message</th></tr>";
						
						for($i=0; $i<5; $i++){
							if(isset($postsDataFound[$i]['message'])){
							if ($postsDataFound[$i]['message']!== "") {
								$resultsAlbums.="<tr>";
								$resultsAlbums.="<td>";
								$resultsAlbums.=$postsDataFound[$i]['message'];
								$resultsAlbums.="</td>";
								$resultsAlbums.="</tr>";
							}
							}
						}
						
						$resultsAlbums.="</table>";
						}
						/*else{
							$resultsAlbums.= "<div id = noPosts class= searchbox style=\"top:250px;\">";
							$resultsAlbums.="<center>No posts has been found</center>";
							$resultsAlbums.="</div>";
						}*/
						
					}
					else{

						$resultsAlbums.= "<div id = noPosts class= searchbox style=\"top:250px;\">";
						$resultsAlbums.="<center>No posts has been found</center>";
						$resultsAlbums.="</div>";
					}
				}
				else{
					//echo "empty div to be loaded";
					$resultsAlbums = "<div id = noAlbums class= searchbox>";
					$resultsAlbums.="<center>No albums has been found</center>";
					$resultsAlbums.="</div>";
					if ($postsDataFound!== ""){
					//more posts are there to be loaded
					$resultsAlbums.="<div id = postres style=\"background-color:#C8C8C8;top:250px;color:blue;text-decoration:underline;\" class=searchbox>";
				
					$resultsAlbums.="<center>";
					$resultsAlbums.="Posts";
					$resultsAlbums.="</center>";
					$resultsAlbums.="</div>";
					$resultsAlbums.= "<table class=dontDisplayPosts id=postrestab style=\"position:absolute;width:750px;top:300px;left:19%;\">";
						foreach($postsDataFound as $msg){
							if($msg->{"message"}){
								$resultsAlbums.="<tr>";
								$resultsAlbums.="<td>";
								$resultsAlbums.=$msg["message"];
								$resultsAlbums.="</td>";
								$resultsAlbums.="</tr>";
							}
						}

						$resultsAlbums.="</table>";
					}
					else{
						$resultsAlbums.= "<div id = noPosts class= searchbox style=\"top:250px;\">";
						$resultsAlbums.="<center>No posts has been found</center>";
						$resultsAlbums.="</div>";
					}
				}
				echo $resultsAlbums;
			}
		}	
	?>
	</div>
</body>
</html>

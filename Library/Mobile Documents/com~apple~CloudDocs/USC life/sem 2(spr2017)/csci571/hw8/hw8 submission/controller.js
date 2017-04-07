var myApp = angular.module('myApp', ['ngAnimate']);


myApp.controller('myFBController', function($scope,$http){

	$searchType = "Users";
	$scope.dataNext = '0';
	$scope.dataPrev = '0';
	$scope.albums = "Albums to be loaded";
	$scope.posts = "Posts to be loaded";
	$scope.photos = [];
	$scope.photoDisplay = {0:0,1:0,2:0,3:0,4:0};
	$scope.lastUserPage = [];$scope.lastPagesPage = [];$scope.lastEventsPage=[];
	$scope.lastPlacesPage = [];$scope.lastGroupsPage = [];$scope.previousState=[];
	$scope.callFrom = "";
	$scope.favList=[];
	$scope.favBtnClass= "glyphicon glyphicon-star-empty";
	$scope.favBtnClassActive = "glyphicon glyphicon-star";
	$scope.inFavTab =0;
	$scope.favBtnDelete= "glyphicon glyphicon-trash";
	$scope.displayTable = 1;
	$scope.displayDetails = 0;
	$scope.selectedPage=1;
	$scope.showProgress = 0;
	$scope.selectedProfilePic = "";
	$scope.locationSuccess = 0;
	$scope.crd;

	///-----------facebook SDK initialization-------------///
	window.fbAsyncInit = function() {
    FB.init({
      appId      : '1480854951947032',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  ///--------------get the location-------------------////
  	var options = {
  				enableHighAccuracy: true,
  				timeout: 5000,
  				maximumAge: 0
	};

	navigator.geolocation.getCurrentPosition(success, error, options);

	function success(pos) {
		$scope.crd=pos.coords;
		$scope.locationSuccess = 1;
	};
	
	function error(err) {
  		console.warn(`ERROR(${err.code}): ${err.message}`);
	};
	
	///-------get the local storage--------------------////
	$scope.readLocalStorage = function(){
			$scope.storedhashMap = JSON.parse(localStorage.getItem("hashMap"));
	};

	///--------------for retrieving from search button---------------////
	$scope.getData = function(){
		if ($scope.queryInput!=undefined) {
			$scope.showProgress = 1;
		
			if ($scope.selectedPage == 1) {
				$scope.getUsers();
			}
			else if($scope.selectedPage == 2){
				$scope.getPages();
			}
			else if($scope.selectedPage == 3){
				$scope.getGroups();
			}
			else if($scope.selectedPage == 4){
				$scope.getEvents();
			}
			else if($scope.selectedPage == 5){
				$scope.getPlaces();
			}
			else if($scope.selectedPage == 6){
				$scope.getFavorites();
			}
		}
	}

	////---------retrieving the users-------------///
    $scope.getUsers = function() {
    	$scope.callFrom = 'users';
    	
    	$scope.backFromDetails = "";

    	$scope.inFavTab =0;
    	$scope.selectedPage = 1;

    	if ($scope.queryInput == undefined) {}
    	else if ($scope.lastUserPage.length != 0) {
    		
    		$scope.result = $scope.lastUserPage;
    		$scope.showProgress = 0;
    	}
    	else{
    		$scope.showProgress = 1;
    		var data ={
				query: $scope.queryInput,
				searchType: 'user'
			};
			var config = {
				params:  data,
				headers: {'Accept' : 'application/json'}
			};
		
        	$http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(successCallback, errorCallback);
   		}
    };

    ///--------------for retrieving pages -----------------////
    $scope.getPages = function() {
    	$scope.callFrom = "pages";
    	$scope.inFavTab =0;
    	$scope.displayDetails = 0;
    	$scope.selectedPage = 2;

   		if ($scope.queryInput == undefined) {}
    	else if ($scope.lastPagesPage.length !=0) {

    		$scope.result = $scope.lastPagesPage;
    		$scope.showProgress = 0;
    	}
    	else{
    		$scope.showProgress = 1;
    		var data ={
				query: $scope.queryInput,
				searchType: 'page'
			};
			var config = {
				params:  data,
				headers: {'Accept' : 'application/json'}
			};
        	$http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(successCallback, errorCallback);
   		}
    };

    ///----------for retrieving groups ----------------///
    $scope.getGroups = function(){
    	$scope.callFrom = "groups";
    	$scope.inFavTab =0;
    	$scope.selectedPage = 3;
    	
    	if ($scope.queryInput == undefined) {}
    	else if ($scope.lastGroupsPage.length !=0) {
    		$scope.result = $scope.lastGroupsPage;
    		$scope.showProgress = 0;
    	}
    	else{
    		$scope.showProgress = 1;
    		var data ={
				query: $scope.queryInput,
				searchType: 'group'
			};
			var config = {
				params:  data,
				headers: {'Accept' : 'application/json'}
			};
        	$http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(successCallback, errorCallback);
    	}
    };

    ///-------------for retrieving events---------///
    $scope.getEvents = function(){
    	$scope.callFrom = "events";
    	$scope.inFavTab =0;
    	$scope.selectedPage = 4;
    	$scope.displayDetails = 0;

    	if ($scope.queryInput == undefined) {}
    	else if ($scope.lastEventsPage.length!=0) {
    		$scope.result = $scope.lastEventsPage;
    		$scope.showProgress = 0;
    	}
    	else{
    		$scope.showProgress = 1;
    		var data ={
				query: $scope.queryInput,
				searchType: 'event'
			};
			var config = {
				params:  data,
				headers: {'Accept' : 'application/json'}
			};
        	$http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(successCallback, errorCallback);
    	}
    };

    ///--------------for retrieving places-------------///
    $scope.getPlaces = function(){
    	$scope.callFrom = "places";
    	$scope.inFavTab =0;
    	$scope.selectedPage = 5;

    	if ($scope.queryInput == undefined) {}
   		else if ($scope.lastPlacesPage.length!=0) {
   			$scope.result = $scope.lastPlacesPage;
   			$scope.showProgress = 0;
   		}
   		else{
   			$scope.showProgress = 1;
   			

			if ($scope.locationSuccess == 1) {  //success function called for successful location

  				var data ={
					query: $scope.queryInput,
					queryLat: $scope.crd.latitude,
					queryLong: $scope.crd.longitude,
					searchType: 'place'
				};
				var config = {
					params:  data,
					headers: {'Accept' : 'application/json'}
				};
        		$http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(successCallback, errorCallback);
			}
		}
    };

    ///--------------for retrieving favorites--------------///  
    $scope.getFavorites = function(){
    	
    	$scope.th1 = '#';
        $scope.th2 = 'Profile Photo';
        $scope.th3 = 'Name';
        $scope.th4 = 'type';
        $scope.th5 = 'Favorite';
        $scope.th6 = 'Details';
        $scope.inFavTab =1;
        
        $scope.selectedPage = 6;

        var curfavList = JSON.parse(localStorage.getItem('favList')) || [];

    	if (curfavList.length > 0) {
    		/*if ($scope.callFrom == 'favorites') {}
    		else if($scope.callFrom == ''){

    			// if its the initial click-load from localStorage
    			$scope.result = curfavList;
    		}
    		else if($scope.callFrom != 'favorites'){

    			//if navigating to the favorites tab then update results
    			$scope.result=$scope.favList;
    		}*/
    		$scope.result=curfavList;
    	}
    	else{
    		$scope.result ={};
    	}
    	$scope.callFrom = 'favorites';
    }


    ////--------updating the favorites when clicked on star in table------------///
    $scope.updateFavorite = function( $row, $no, $event ){
    	$scope.inFavTab=0;
    	var inFav = 0;

    	if ($row == undefined) {
    		
   			
    		for(i=0;i<$scope.favList.length;i++){
    			
    			if($scope.favList[i].id == $scope.selectedFav){
    			inFav =1;
    			//delete from favList
    			$scope.favList.splice(i,1);
    			
    			var curfavList = JSON.parse(localStorage.getItem('favList')) || [];
    			console.log("printing the curfavList");
    			console.log(curfavList);
    			if(curfavList.length > 0){

    				//remove from the curfavList and update localStorage
    				curfavList.splice(i, 1);
    				localStorage.setItem('favList', JSON.stringify(curfavList));
    				
    				//update the hashMap
    				var localhash = JSON.parse(localStorage.getItem('hashMap'));
    				delete localhash[$scope.selectedFav];
					//localStorage.setItem('hashMap',JSON.stringify(localhash));
					localStorage.setItem('hashMap', JSON.stringify(localhash));
    			}
    			}
    		}
    	}
    	else{
    	for(i=0;i<$scope.favList.length;i++){
    		if($scope.favList[i].id == $row.id){
    			inFav =1;
    			//delete from favList
    			$scope.favList.splice(i,1);
    			
    			var curfavList = JSON.parse(localStorage.getItem('favList')) || [];
    			if(curfavList.length > 0){

    				//remove from the curfavList and update localStorage
    				curfavList.splice(i, 1);
    				localStorage.setItem('favList', JSON.stringify(curfavList));
    				
    				//update the hashMap
    				var localhash = JSON.parse(localStorage.getItem('hashMap'));
    				delete localhash[$row.id];
					//localStorage.setItem('hashMap',JSON.stringify(localhash));
					localStorage.setItem('hashMap', JSON.stringify(localhash));
    			}
    			
    		}
    	}

    	//add to favorite list and localStorage
    	if (inFav == 0) {
    		$row["type"]= $scope.callFrom;
    		$row["no"] = $no;
    		$row["picurl"] = $row["picture"]["data"]["url"];
    		
    		$scope.favList.push($row);

    		var curfavList =JSON.parse(localStorage.getItem('favList')) || [];
    		
    		var newItem = $row;
    		curfavList.push(newItem);
    		localStorage.setItem('favList', JSON.stringify(curfavList));

    		//update hashMap of LocalStorage
    		var localhash = JSON.parse(localStorage.getItem('hashMap'));
    		localhash[$row.id] = true;
			//localStorage.setItem('hashMap',JSON.stringify(localhash));
			localStorage.setItem('hashMap', JSON.stringify(localhash));
    	}
    	}
    }

    $scope.updateFavFromDetails = function(){
    	
    	for(i=0;i<$scope.favList.length;i++){
    		
    		if($scope.favList[i].id == $scope.selectedFav){
    			//delete from favList and update localStorage
    			$scope.favList.splice(i,1);

    			var curfavList = JSON.parse(localStorage.getItem('favList')) || [];
    			if(curfavList.length > 0){

    				//remove from the curfavList and update localStorage
    				curfavList.splice(i, 1);
    				localStorage.setItem('favList', JSON.stringify(curfavList));

    				///update hash map of local storage
    				var localhash = JSON.parse(localStorage.getItem('hashMap'));
    				delete localhash[$row.id];
					//localStorage.setItem('hashMap',JSON.stringify(localhash));
					localStorage.setItem('hashMap', JSON.stringify(localhash));
    			}

    			$scope.result=$scope.favList;
    		}
    	
    	}
    }
    ///---------------deleting from inside the favorites table-----------------///
    $scope.deleteAndUpdate = function( $row , $no, $event){
    	
    	for(i=0;i<$scope.favList.length;i++){
    		if($scope.favList[i].id == $row.id){

    			//delete from favList and update localStorage
    			$scope.favList.splice(i,1);
    			$scope.result = $scope.favList;

    			var curfavList = JSON.parse(localStorage.getItem('favList')) || [];
    			if(curfavList.length > 0){

    				//remove from the curfavList and update localStorage
    				curfavList.splice(i, 1);
    				localStorage.setItem('favList', JSON.stringify(curfavList));
    				
    				//update the hashmap of favorites
    				var localhash = JSON.parse(localStorage.getItem('hashMap'));
    				delete localhash[$row.id];
					//localStorage.setItem('hashMap',JSON.stringify(localhash));
					localStorage.setItem('hashMap', JSON.stringify(localhash));
					console.log(localStorage);
    			}
    		}
    	}
    	//after browser refreshes
    	if ($scope.favList.length == 0) {

    		var curfavList = JSON.parse(localStorage.getItem('favList')) || [];
    		
    		if(curfavList.length > 0){

    				//remove from the curfavList and update localStorage
    				curfavList.splice($no, 1);
    				localStorage.setItem('favList', JSON.stringify(curfavList));
    				
    				//update the hashmap of favorites
    				var localhash = JSON.parse(localStorage.getItem('hashMap'));
    				delete localhash[$row.id];
					//localStorage.setItem('hashMap',JSON.stringify(localhash));
					localStorage.setItem('hashMap', JSON.stringify(localhash));
					console.log(localStorage);
    		}
    		$scope.result = curfavList;
    	}
    }
    ///--------------for going back from albums and posts--------------------///
    $scope.goBack = function(){
    	$scope.displayTable = 1;
		$scope.displayDetails = 0;
		$scope.backFromDetails = "tableContainer";

    	/*if ($scope.callFrom == 'users') {
    		$scope.result = $scope.lastUserPage;
    		$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'pages') {
    		$scope.result = $scope.lastPagesPage;
    		$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'events') {
    		$scope.result = $scope.lastEventsPage;
    		$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'places') {
    		$scope.result = $scope.lastPlacesPage;
    		$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'groups') {
    		$scope.result = $scope.lastGroupsPage;
    		$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'favorites') {
    		$scope.inFavtab = 1;

    		$scope.getFavorites();
    	}*/

    	$scope.result=$scope.previousState;
    	$scope.showProgress =0;
    	$scope.inFavtab = 0;
    	$scope.readLocalStorage();

    	if($scope.callFrom == 'favorites'){
    		console.log($scope.callFrom);
    		$scope.inFavtab = 1;

    		$scope.getFavorites();
    	}

    	$scope.displayDetails =0;
    }

    ///--------------- for retrieving next -----------///
    $scope.getNextData = function(){
    	$scope.inFavtab =0;
    	$scope.showProgress = 1; 

    	var data ={
			query: $scope.paging['next'],
			searchType: 'next'
		};
		var config = {
			params:  data,
			headers: {'Accept' : 'application/json'}
		};

        $http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(successCallback, errorCallback);

    }

    ////------------------ for retrieving previous ------------------///
    $scope.getPrevData = function(){
    	$scope.inFavTab =0;
    	$scope.showProgress = 1;
    	
    	var data ={
			query: $scope.paging['previous'],
			searchType: 'prev'
		};
		var config = {
			params:  data,
			headers: {'Accept' : 'application/json'}
		};

        $http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(successCallback, errorCallback);
    	
    }


    ////----------------for getting details-------------------///
    $scope.getDetails = function( $row ){
    	$scope.inFavTab =0;
    	$scope.displayDetails = 1;
    	$scope.showProgress = 1;
    	$scope.selectedFav = $row.id;
    	$scope.selectedProfilePic = $row.picture.data.url;
    	$scope.displayTable = 0;
		$scope.displayDetails = 1;

		$scope.readLocalStorage();

		if ($scope.callFrom == 'users') {
    		//$scope.result = $scope.lastUserPage;
    		$scope.previousState=$scope.lastUserPage;
    		//$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'pages') {
    		//$scope.result = $scope.lastPagesPage;
    		$scope.previousState=$scope.lastPagesPage;
    		//$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'events') {
    		//$scope.result = $scope.lastEventsPage;
    		$scope.previousState=$scope.lastEventsPage;
    		//$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'places') {
    		//$scope.result = $scope.lastPlacesPage;
    		$scope.previousState=$scope.lastPlacesPage;
    		//$scope.showProgress =0;
    	}
    	else if ($scope.callFrom == 'groups') {
    		//$scope.result = $scope.lastGroupsPage;
    		$scope.previousState=$scope.lastGroupsPage;
    		//$scope.showProgress =0;
    	}
    	/*else if ($scope.callFrom == 'favorites') {
    		$scope.inFavtab = 1;

    		$scope.getFavorites();
    	}*/
		//$scope.callFrom = "details";

		
    	var data ={
			query: $row['id'],
			searchType: 'details'
		};
		var config = {
			params:  data,
			headers: {'Accept' : 'application/json'}
		};

        $http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(successDetCallback, errorDetCallback);
    };

    ////------------------for getting albums photos-----------------///
    $scope.retrievePhotos = function( $row, $index){   
    	$scope.inFavTab =0; 
    	
    	if ($index == 0) {
				$scope.photoDisplay[$index] = 1;
		}
		else{
			$scope.photoDisplay[$index] = 0;
		}
    	
		for (var i = 0; i <$row["photos"]["data"].length; i++) {
		
			$scope.photos = [];
		
    		var data ={
				query: $row["photos"]["data"][i].id,
				searchType: 'albumphotos'
			};
			var config = {
				params:  data,
				headers: {'Accept' : 'application/json'}
			};
		
        	$http.get("http://app12016spr-env.us-west-2.elasticbeanstalk.com/server.php", config).then(function successAlbumCallback(response){

				$scope.photos.push(response["data"]["data"]);

        	},function errorAlbumCallback(error){
        		console.log("error");
        	});
    	}

    };
    ///------------------for posting to FB---------------------///
    $scope.posttoFB = function(){

    	FB.ui({
 		app_id: '1480854951947032',
 		method: 'feed',
 		link: "http://www-scf.usc.edu/~sravania/hw81.html",
 		picture: $scope.selectedProfilePic,
 		name: "Sravani Anne",
 		caption: "FB SEARCH FROM USC CSCI571",
 		}, function(response){
 			if (response && !response.error_message){
 				
 				alert("Posted Successfully");
 			}
 			else{
 				alert("Not posted");
 			}
		});
    };

    ///--------------for clearing data-------------------///
    $scope.clearEverything = function(){
    	$scope.inFavtab =0;
    	$scope.displayTable = 0;
    	$scope.displayDetails = 0;
    }

    ///-----------------for toggling Display----------------------///
    $scope.toggleDisplay = function($index){
		$scope.inFavTab =0;

		if ($scope.photoDisplay[$index] == 1) {
			$scope.photoDisplay[$index] =0;
		}
		else if ($scope.photoDisplay[$index] == 0) {
			$scope.photoDisplay[$index] = 1;
		}
	};

    function successCallback(response){
 		       
        $scope.result = response['data']['data'];
        $scope.paging = response['data']['paging'];
        $scope.showProgress = 0;
        

        //setting next and previous button appropriately
		if (response['data'] != undefined && response['data']['paging'] != undefined) {       
        	if (response['data']['paging']['next']) {
        		$scope.dataNext = '1';
    		}
    		else{
    			$scope.dataNext ='0';
    		}
    	}
    	else{
    		$scope.dataNext = '0';
    	}
    	
    	if (response['data'] != undefined && response['data']['paging'] != undefined) {
    		if (response['data']['paging']['previous']){
    			$scope.dataPrev = '1';
    		}
    		else{
    			$scope.dataPrev = '0';
    		}
    	}	
    	else{
    		$scope.dataPrev = '0';
    	 
    	}

    	//setting the last state appropriately
    	if ($scope.callFrom == 'users') {
    		$scope.lastUserPage = $scope.result;
    	}
    	else if ($scope.callFrom == 'pages') {
    		$scope.lastPagesPage = $scope.result;
    	}
    	else if ($scope.callFrom == 'events') {
    		$scope.lastEventsPage = $scope.result;
    	}
    	else if ($scope.callFrom == 'places') {
    		$scope.lastPlacesPage = $scope.result;
    	}
    	else if ($scope.callFrom == 'groups') {
    		$scope.lastGroupsPage = $scope.result;
    	}

    	//set the display table to 1
    	$scope.displayTable = 1;
    	$scope.displayDetails = 0;

    	//setting the table headers
        $scope.th1 = '#';
        $scope.th2 = 'Profile Photo';
        $scope.th3 = 'Name';
        $scope.th4 = 'Favorite';
        $scope.th5 = 'Details';
    }

	function errorCallback(error){
		console.log("Error. Could not receive data");
	}

	function successDetCallback(response){
		$scope.showProgress = 0;
		$scope.profilepic = response['data']['picture']['data']['url'];
		$scope.profilename = response['data']['name'];

		if (response['data']['albums']){
			$scope.albums = response['data']['albums'];
		}
		else{
			$scope.albums = "No albums have been found";
		}
		if (response['data']['posts']) {
			$scope.posts = response['data']['posts'];
		}
		else{
			$scope.posts = "No posts have been found";
		}
	}

	function errorDetCallback(error){
		console.log("Error. Could not receive the details");
	}
});






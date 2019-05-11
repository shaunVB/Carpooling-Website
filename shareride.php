<?php 
  include "templates/head.php";
?>
<?php
/*
 * The landing page that lists all the problem
 */
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		connectdb();

?>

<?php
/*
 * Header for user pages
 */
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Car Pool </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="css/datetimepicker.css">

    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body onload="load()">
<!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <div class="container-fluid">
       
      </div> 

      <!-- Begin page content -->

<div class="container">
	<?php
        if(isset($_GET['changed']))
          echo("<div class=\"alert alert-info\">\nAccount details changed successfully!\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>



	<div class="row-fluid" id="main-content">
		<div class="span2"></div>
		<div class="span5"> 
			<h2 align="center"><small>Share your ride</small></h2>
			<hr>
      		<br/>
			<form method="post" action="update.php" class="form-horizontal well">
				<input type="hidden" name="action" value="shareride" /><br>
				<input type="hidden" id="total" name="totalRequests" value=0 />
       		    <input type="text" id="From" name="from" data-provide="typeahead" class="typeahead" placeholder="Source" required/><br/><br>
       		    <div class="inputs">
                     </div>
    	    	<input type="text" id="To" name="to" data-provide="typeahead" class="typeahead" placeholder="Destination"  required/><br/><br>
    	    	<div class="btn-group">
                    <button class="btn" id ="add">Add Via Routes</button>
                    <button class="btn" id="remove">Delete Via</button>
                    <button class="btn" id="reset">Reset Via </button>
                    <button class="btn" id="CheckOnMap" onclick="RefreshMap()">Refresh Map</button>
         </div>
		
		<br/><br/>
    	    	Start Time of your ride:
	      			<div id="uptimepicker" class="input-append date">
				      <input type="text" name="uptime" required></input>
				      <span class="add-on">
				        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				      </span>
				    </div> <br/>
            	Mode of Travel: <br/> <label class="radio inline">
					<input type="radio" name="vehicle" value="car">Car
				</label>
				<label class="radio inline">
					<input type="radio" name="vehicle" value="taxi">Taxi
				</label>
		 		<label class="radio inline">
					<input type="radio" name="vehicle" value="auto">Auto Rickshaw
				</label>
		 		 <br/> <br/>
		 		 <div class="input-append">
					<input type="text" name="time" placeholder="Approx duration of travel" required> </input>
					<span class="add-on">Hrs</span>
				</div><br>
   				<br/>
   				<input type="text" type="number" name="number" placeholder="Number of vacancies"></input> <br/><br>
   				<div class="input-prepend">
					<span class="add-on">Rs</span>
					 <input class="span10" id="prependedInput" type="number" name="cost" placeholder="Cost per person" required>
				</div><br/>
   				<br/>
   				<textarea width="500px" rows="3" name="description" placeholder="Any further details which might help people select your ride"></textarea> <br/>
    			<input class="btn" type="submit" name="submit" value="Share"/>
      		</form>
      	</div>
		<div class="span5" id="map" style="width: 400px; height: 600px;margin-top: 50px">
		</div>
	</div>
</div>
<div id="push"></div>
    </div> <!-- /wrap -->
    <div id="footer">
      <div class="container">
        <p class="muted credit">AutoCarPool AIT 2018</p>
      </div>
    </div>

    <!-- javascript files
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/datetimepicker.js"></script>
<!--     <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

 -->  
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpLkx1uRpSIyrXLh3sXXdoFWRUU_n8lZI&libraries=places&callback=initMap"
        async defer></script> 
  <script type="text/javascript">
      $('#uptimepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
      });
      $('#downtimepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
      });
    </script>
    <?php 
    $query = "SELECT city_name from cities";
	$result = mysql_query($query);
	echo "<script>var city = new Array();";
                while($row = mysql_fetch_array($result)){
                    //echo '<option value="' . $row["city_name"]. '"> ' . $row["city_name"].'</option>';
                    echo 'city.push("' . $row["city_name"]. '");';
    }
    echo '$(".typeahead").typeahead({source : city})';
    echo "</script>"

    ?>
<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          mapTypeControl: false,
          center: {lat: 19.0469653 , lng: 72.8880971},
          zoom: 13
        });

        new AutocompleteDirectionsHandler(map);
      }

       /**
        * @constructor
       */
      function AutocompleteDirectionsHandler(map) {
        this.map = map;
        this.originPlaceId = null;
        this.destinationPlaceId = null;
        this.travelMode = 'DRIVING';
        var originInput = document.getElementById('From');
        var destinationInput = document.getElementById('To');
        
        this.directionsService = new google.maps.DirectionsService;
        this.directionsDisplay = new google.maps.DirectionsRenderer;
        this.directionsDisplay.setMap(map);

        var originAutocomplete = new google.maps.places.Autocomplete(
            originInput, {placeIdOnly: true});
        var destinationAutocomplete = new google.maps.places.Autocomplete(
            destinationInput, {placeIdOnly: true});


        this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
        this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

        this.map.controls.push(originInput);
        this.map.controls.push(destinationInput);
        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
      }

      // Sets a listener on a radio button to change the filter type on Places
      // Autocomplete.
      AutocompleteDirectionsHandler.prototype.setupClickListener = function(id, mode) {
        var radioButton = document.getElementById(id);
        var me = this;
        radioButton.addEventListener('click', function() {
          me.travelMode = mode;
          me.route();
        });
      };

      AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
        var me = this;
        autocomplete.bindTo('bounds', this.map);
        autocomplete.addListener('place_changed', function() {
          var place = autocomplete.getPlace();
          if (!place.place_id) {
            window.alert("Please select an option from the dropdown list.");
            return;
          }
          if (mode === 'ORIG') {
            me.originPlaceId = place.place_id;
          } else {
            me.destinationPlaceId = place.place_id;
          }
          me.route();
        });

      };

      AutocompleteDirectionsHandler.prototype.route = function() {
        if (!this.originPlaceId || !this.destinationPlaceId) {
          return;
        }
        var me = this;

        this.directionsService.route({
          origin: {'placeId': this.originPlaceId},
          destination: {'placeId': this.destinationPlaceId},
          travelMode: this.travelMode
        }, function(response, status) {
          if (status === 'OK') {
            me.directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      };
      
     
    </script>
    

</body></html>
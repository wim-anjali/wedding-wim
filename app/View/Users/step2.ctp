<!DOCTYPE html>
<html>
<head>
<title>Shadi Season Step-2</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript">

		
	$(document).ready(function(){
		var geocoder;
		var map;
		var last_id = 3;
		$(".datepicker" ).datepicker({dateFormat: 'DD dd MM yy'});
		$( "#wedding_date" ).datepicker({dateFormat: 'DD dd MM yy'});
		$('.editable').addClass('hide');
		$('.edit_text').click(function(){
			$('#'+this.id).addClass('hide');
			var id = this.id.replace('span', '');
			$('.editable').removeClass('show');
			$('#input'+id).val($(this).html());
			$('#input'+id).removeClass('hide').focus();
			//$('#input'+id).addClass('show').focus();
			
		});
		$('.editable').focusout(function(){
			var id = this.id.replace('input', '');
			$('#span'+id).html(this.value);
			$('#'+this.id).addClass('hide');
			//$('.editable').removeClass('show');
			$('.edit_text').removeClass('hide');
			//$('#span'+id).addClass('show');		
		});
		$('.event').click(function(){
				var id = this.id;
				$('.edit_event').removeClass('show');
				$('.edit_'+id).addClass('show');
				$('.edit_'+id).addClass('show');
				$('.event').removeClass('border-blue');
				$('.event').addClass('border-gray');
				$('#'+id).removeClass('border-gray');	
				$('#'+id).addClass('border-blue');	
				
			});
		$('.addEventButton').click(function(){
			$.ajax({
					url:"new_event",
					data:{id:last_id},
					type:"GET",
					beforeSend:function(){
						//$('#loadgif').show();				
					},
					success: function(msg){
						//$('body').html(msg); return;
						//alert(msg);
						$('.event').last().after(msg);
						last_id++;
						var num = $('#no_of_events').val();
						$('#no_of_events').val(++num);
						
					}
				});
		});

		$(".map-image").click(function(){
			var id = this.id;
				$('#zoom_map_'+id).css('display','block')
				initialize_map('map_canvas_'+id);
				$('html').click(function (e){
				var container = $(".zoom_map");
				if (container.has(e.target).length === 0)
				{
						container.hide();
				}
				});
				
						event.stopPropagation();
				
			});
		$('.deleteEventButton').click(function(){
			$(this).closest('.event').fadeOut();
			var num = $('#no_of_events').val();
			$('#no_of_events').val(--num);
		});
		
		$('.address_input').keyup(function(){
			codeAddress(this.id);
		});
		$('.save_address').click(function(){
				var id = this.id.replace('save_', '');
				var address = $('#address'+id).val();
				$('#add_'+id).text(address);
		});

		$('#publish').on('click', function() {	
			var validate = true;
			var groom = $('#input_groom').val();			
			var bride = $('#input_bride').val();
			localStorage.setItem("url", groom+"weds"+bride);
			$('input.wedding').each(function() {
				if(this.value==''){
					validate = false;
					alert('Please fill all the details.');
					return false;
				}			
			});			
			if(validate){
				var data = 'user_name='+groom+'&bride_name='+bride+'&'+$('#wedding').serialize();
				var base_url = 'http://localhost/wedding-wim/';
				console.log(data);
				$.ajax({
					url:base_url+"events/add_event",
					data:data,
					type:"POST",
					beforeSend:function(){
						$('#preloader').css('display','block');								
					},
					success: function(msg){
						//$('body').html(msg); return;
						console.log(msg);
						$('#preloader').css('display','block');								
						window.location.href = "step3";
						
					}
			});
			};
     });    
	});
	function initialize_map(id) {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(28.667696,77.093969);
    var mapOptions = {
      zoom: 11,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById(id), mapOptions);
  }

  function codeAddress(id) {	
    var address = document.getElementById(id).value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
			console.log(results[0]);
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      }
    });
  }	
</script>
<noscript>
</noscript>
</head>
<body id="step2" >

<!-- top navigation and logo -->
<header role = "banner">
  <div class="container">
    <div class="row">
      <article class="col-md-6 col-lg-6 col-sm-6"> <img src="../img/logo.png" class="img-responsive" alt="" id="logo"> </article>
      <aside class="col-md-6 col-lg-6  col-sm-6 text-right" id="user-input"> <a href="#">Login</a> <a href="#">Register</a> </aside>
    </div>
    <!--end row--> 
    
  </div>
  <!-- end container --> 
  
</header>
<!--end header -->

<div id="header-wrapper" >
  <div id="edit-mode-box">
    <div class="black-bg">
      <section class="container">
        <article class="row ">
          <div class="col-md-8 center-align">
            <p>Now simply change the data in the design by clicking on it, yes and it auto saves</p>
          </div>
          <div class="row">
            <div class="col-md-4 center-align">
              <div class="row">
                <div class="col-md-6 col-xs-6 col-sm-6 ">
                  <button type="button" class="btn btn-info full-width initial-button-blue">Edit Mode</button>
                </div>
                <div class="col-md-6 col-xs-6 col-sm-6 ">
                  <button type="button" class="btn btn-default full-width no-bg  pr-button" id="publish">Publish</button>
                </div>
								<img src="../img/ajax-loader.gif" id="preloader"/>                
							</div>
            </div>
          </div>
        </article>
      </section>
    </div>
    <div class="container">
      <aside class="row" id="current-theme">
        <div class="col-md-8  center-align" id="theme-status">
          <p class="">Your Current Theme</p>
          <h3 class=""> Rich Hina </h3>
          <p class=" "> <a href="#">Change Theme</a> </p>
        </div>
      </aside>
    </div>
  </div>
</div>
<div role="main" id="main" class=" clearfix" >
  <div class="container">
    <header id="enter-details" class="row">
      <div class="col-md-8  center-align ">
        <hgroup class="row text-center" >				
          <h3 class="col-md-4" id="man-name"><span id="span_groom" class="edit_text wedding">Kapil</span><input type="text" name="groom"   id="input_groom" class="editable title_weds" value="Kapil"></h3>
          <h3 class="col-md-4" id="weds"><span>Weds</span></h3>
          <h3 class="col-md-4" id="woman-name"><span id="span_bride" class="edit_text wedding">Sonali</span><input type="text" name="bride"  id="input_bride" class="editable title_weds" value="Sonali"></h3>
        </hgroup>
        <div class="row">
          <h4 class="col-md-12 text-center"><input name="wedding_date" id="wedding_date" class="datepicker" value="Monday 14 April 2013"></h4>
        </div>
      </div>
    </header>
  </div>
  <!--<aside class="container">
    <nav class="relative-links">
      <ul>
        <li><span></span><a href="#">Details</a></li>
        <li><span></span><a href="#">Venue</a></li>
        <li><span></span><a href="#">RSVP</a></li>
      </ul>
    </nav>
  </aside>-->
  <div class="main-wrapper clearfix">
    <section  class=" container clearfix">
      <div class="row">
        <article id="content" class="col-md-9 center-align">
          <div class="row paddingBottom-3">
            <div class="col-md-10 center-align">
						<form id="wedding">
						<input type="hidden" name="no_of_events" id="no_of_events" value="3"/>
              <section name="event[]" id="event_1" class="final-template border-gray event clearfix  ">
                <div class="row">
                  <button type="button" class="btn btn-default deleteEventButton hide edit_event edit_event_1">Delete Event X</button>
                  <div class="col-md-12 text-center">
                    <div class="horz-border"></div>
                    <div class="up-textContainer"> <em class="edit_event edit_event_1 hide" id="upload">Upload Photo</em> <span class="upload-photo"> <img src="../img/Wendills.jpg" class="img-circle img-responsive center-align main-template-image"> </span> </div>
                    <hgroup class="template-heading">
                      <h2><span class="edit_text" id="span_event_name_1">Engagement</span>
												<input type="text" name="event_name[]" id="input_event_name_1" class="editable event_text wedding" value="Engagement">
											</h2>
                      <h3>
                        <input type="text" name="datepicker[]" id="datepicker_1" class="datepicker black wedding" value="Monday 14 April 2013" value=""/>
                      </h3>
                    </hgroup>
                    <div class="up-textContainer cal-text-gray"> <em>Add to calendar</em>
                      <div class="calendar center-align"> <span class="glyphicon glyphicon-calendar"></span> </div>
                    </div>
                    <div class="horz-border"></div>
                    <img src="../img/torino_google-map.png" class="img-circle  center-align map-image" id="1">
										<div class="zoom_map" id="zoom_map_1">																						
											<textarea name="address[]" id="address1" type="textbox" class="address_input wedding">address1</textarea>												
											<div id="map_canvas_1" class="map_canvas"></div>
											<input type="button" value="save" class="btn btn-info save_address" id="save_1"/>
										</div>						
                    <address>
                    <p id="add_1">Maharaja Grand Banquets<br>
                      A6.28 Paschim Vihar<br>
                      New Delhi<br>
                      110076<br>
                      <br>
                    </p>
                    <p> RSVP: <span class="edit_text" id="span_rsvp_1">8989893234</span>
											<input type="text" name="rsvp[]" id="input_rsvp_1" class="editable event_text wedding" value="8989893234">
										</p>
                    </address>
                    <div class=" phone-direction  col-md-5 col-md-offset-2">
                      <p>Get direction on phone <span class="glyphicon glyphicon-phone "></span> </p>
                    </div>
                  </div>
                </div>
                <br>
              </section>
              
              
              <!-- event loop-->
              
              <section name="event[]" id ="event_2" class="final-template event border-gray clearfix  ">
                <div class="row">
                  <button type="button" class="btn btn-default deleteEventButton  edit_event edit_event_2 hide">Delete Event X</button>
                  <div class="col-md-12 text-center">
                    <div class="horz-border"></div>
                    <div class="up-textContainer"> <em class="edit_event edit_event_2 hide">Upload Photo</em> 
										<span class="upload-photo"> <img src="../img/mehndi.jpg" class="img-circle img-responsive center-align main-template-image"> </span> </div>
                    <hgroup class="template-heading">
                      <h2><span class="edit_text" id="span_event_name_2">Mehndi</span>
												<input type="text" name="event_name[]" id="input_event_name_2" class="editable event_text wedding" value="Mehndi">
											</h2>
                      <h3>
                        <input type="text" name="datepicker[]" id="datepicker_2" class="datepicker black wedding" value="Monday 14 April 2013"/>
                      </h3>
                    </hgroup>
										<div class="up-textContainer cal-text-gray"> <em>Add to calendar</em>
											<div class="calendar center-align"> <span class="glyphicon glyphicon-calendar"></span> </div>
										</div>
                    <div class="horz-border"></div>
                    <img src="../img/torino_google-map.png" class="img-circle  center-align map-image" id="2">
										<div class="zoom_map" id="zoom_map_2">
											<textarea name="address[]" id="address2" type="textbox" class="address_input wedding">address2</textarea>												
											<div id="map_canvas_2" class="map_canvas"></div>
											<input type="button" value="save" class="btn btn-info save_address" id="save_2"/>
										</div>
                    <address>
                    <p id="add_2">Maharaja Grand Banquets<br>
                      A6.28 Paschim Vikar<br>
                      New Delhi<br>
                      110076<br>
                      <br>
                    </p>
                    <p> RSVP: <span class="edit_text" id="span_rsvp_2">8989893234</span>
											<input type="text" name="rsvp[]" id="input_rsvp_2" class="editable event_text wedding" value="8989893234">
										</p>
                    </address>
                    <div class=" phone-direction  col-md-5 col-md-offset-2">
                      <p>Get direction on phone <span class="glyphicon glyphicon-phone "></span> </p>
                    </div>
                  </div>
                </div>
                <br>
              </section>
              
              <!--end one event loop--> 
              
              <!-- event loop-->
              
              <section name="event[]" id="event_3" class="final-template event border-gray clearfix  ">
                <div class="row">
                  <button type="button" class="btn btn-default deleteEventButton hide edit_event edit_event_3">Delete Event X</button>
                  <div class="col-md-12 text-center">
                    <div class="horz-border"></div>
										<div class="up-textContainer"> <em class="edit_event edit_event_3 hide">Upload Photo</em> 
                    <span class="upload-photo"> <img src="../img/Indian-Bridal-Makeup-2.jpg" class="img-circle img-responsive center-align main-template-image-bigSize"> </span> </div>
                    <hgroup class="template-heading">
                      <h2><span class="edit_text" id="span_event_name_3">Wedding</span>
												<input type="text" name="event_name[]" id="input_event_name_3" class="editable event_text wedding" value="Wedding">
											</h2>
                      <h3>
                        <input type="text" name="datepicker[]" id="datepicker_3" class="datepicker black wedding" value="Monday 14 April 2013"/>
                      </h3>
                    </hgroup>
										<div class="up-textContainer cal-text-gray"> <em>Add to calendar</em>
											<div class="calendar center-align"> <span class="glyphicon glyphicon-calendar"></span> </div>
										</div>
                    <div class="horz-border"></div>
                    <img src="../img/torino_google-map.png" class="img-circle  center-align map-image" id="3">
										<div class="zoom_map" id="zoom_map_3">
											<textarea name="address[]" id="address3" type="textbox" class="address_input wedding">address3</textarea>												
											<div id="map_canvas_3" class="map_canvas"></div>
											<input type="button" value="save" class="btn btn-info save_address" id="save_3"/>
										</div>
                    <address>
                    <p id="add_3">Maharaja Grand Banquets<br>
                      A6.28 Paschim Vikar<br>
                      New Delhi<br>
                      110076<br>
                      <br>
                    </p>
                    <p> RSVP: <span class="edit_text" id="span_rsvp_3">8989893234</span>
											<input type="text" name="rsvp[]" id="input_rsvp_3" class="editable event_text wedding" value="8989893234">
										</p>
                    </address>
                    <div class=" phone-direction  col-md-5 col-md-offset-2">
                      <p>Get direction on phone <span class="glyphicon glyphicon-phone "></span> </p>
                    </div>
                  </div>
                </div>
                <br>
              </section>
              <div class="row">
                <div class="col-md-12 text-center">
                  <button type="button" class="btn btn-info addEventButton  initial-button-blue">Add Another Event</button>
                </div>
              </div>
              <!--end one event loop--> 
              
            </div>
						</form>
					</div>
        </article>
      </div>
    </section>
  </div>
</div>

<!--footer-->
<footer class="clearfix" id="step-2-footer">
  <article id="footer-bottom" class=" clearfix">
    <h4>You are just a step away now</h4>
    <button type="button" class="btn btn-info my-button auto-height1 ">
    <div>Register </div>
    <span>Keep saving your work and edit any time</span></button>
    <div id="footer-text">
      <p><small>Copyright 2014 Shaadi Season<br>
        <a href="#">About</a> | <a href="#">Contact</a></small></p>
    </div>
  </article>
</footer>


</body>
</html>

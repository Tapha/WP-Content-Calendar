(function( $ ) {
	//'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	 
	 // page is now ready, initialize the calendar...
	

	var wpcc_url = WPURLS.siteurl;		

	var first_wpcc_data = {
        'action': 'wpcontentcalendar_lite_get_all_posts'
    };

    $.post(ajaxurl, first_wpcc_data, function(response) {
        var the_wpcc_posts = response.slice(0,-1);
        e_jsonObj = [];
        //console.log(the_wpcc_posts);
		parsed_wpcc_data = $.parseJSON(the_wpcc_posts);  // parsing data          
		$.each(parsed_wpcc_data, function(i, the_wpcc_post) {
			if (the_wpcc_post.post_status != "draft")
			{
				var e_post_id = the_wpcc_post.ID;
			    var e_title = the_wpcc_post.post_title;
			    var e_start = the_wpcc_post.post_date;
			
			    e_item = {}
			    e_item ["id"] = e_post_id;
			    e_item ["title"] = e_title;
			    e_item ["start"] = e_start;
			
			    e_jsonObj.push(e_item);
			}
		             
		
		});
		//console.log(e_jsonObj);
		$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,basicWeek,basicDay'
				},
				height: 650,
				editable: true,
				eventLimit: false, // allow "more" link when too many events
				events: e_jsonObj,
				eventMouseover: function(event, jsEvent, view) {
			        $( this ).append( "<span id='wpcc_post_manipulation_box_"+ event.id +"' class='wpcc_post_manipulation_box'><a id='wpcc_edit_post_"+ event.id +"' href='"+ wpcc_url +"/wp-admin/post.php?post="+ event.id +"&action=edit' class='wpcc_edit_post'>edit | </a>" + "<a id='wpcc_quick_edit_post_"+ event.id +"' class='wpcc_quick_edit_post' rel='ajax:modal'>quick edit | </a>" + "<a id='wpcc_delete_post_"+ event.id +"' class='wpcc_delete_post'>delete | </a>" + "<a id='wpcc_view_post_"+ event.id +"' href='"+ wpcc_url +"/?p="+ event.id +"&preview=true' class='wpcc_view_post'>view</a></span>");
					
					$('a[rel="ajax:modal"]').click(function(){
						//Get event id
						the_wpcc_event_id = $( this ).attr('id');
						the_edit_ajax_wpcc_event_id = the_wpcc_event_id.replace('wpcc_quick_edit_post_','');
						
						//Get post data and then load the modal
						var wpcc_get_post_date_edit = {
					        'action': 'wpcontentcalendar_lite_get_post_data_for_edit',
					        'wpcc_post_id_for_edit': the_edit_ajax_wpcc_event_id
					    };
					
					    $.post(ajaxurl, wpcc_get_post_date_edit, function(newHTML) {					    	
					    	$(newHTML).appendTo('#wpbody');
					    	$('#this_modal').modal({
					    		overlay: "transparent"
					    	});
					    	// process the form
						    $('.wpcc_edit_box_form').submit(function(event) {
						
							        // get the form data
							        // there are many ways to get this data using jQuery (you can use the class or id also)
							        var wpcc_edit_id = $('input[name=wpcc_editid]').val();
							        var wpcc_edit_date = $('input[name=wpcc_editdate]').val();
							        var wpcc_edit_title = $('input[name=title]').val();
							        var wpcc_edit_slug = $('input[name=slug]').val();
							        var wpcc_edit_time = $('input[name=time]').val();
							        var wpcc_edit_status = $( "#wpcc_editselect" ).val();
							        							        
							
							        // process the form
							        var wpcc_get_post_date_edit = {
								        'action': 'wpcontentcalendar_lite_submit_post_data_for_edit',
								        'wpcc_post_id_for_edit_submit': wpcc_edit_id,
								        'wpcc_post_date_for_edit_submit': wpcc_edit_date,
								        'wpcc_post_title_for_edit_submit': wpcc_edit_title,
								        'wpcc_post_slug_for_edit_submit': wpcc_edit_slug,
								        'wpcc_post_time_for_edit_submit': wpcc_edit_time,
								        'wpcc_post_status_for_edit_submit': wpcc_edit_status
								    };
								
								    $.post(ajaxurl, wpcc_get_post_date_edit, function(response) {
										//render new event
										$.modal.close();
							        	console.log('success');							        	
							        });
							    // stop the form from submitting the normal way and refreshing the page    
								event.preventDefault();
							});
					    	$('#this_modal').on($.modal.CLOSE, function(event, modal) {
							  $(this).remove();
							});					    					    	
					    });	
					
					  return false;
					});
					
					$('.wpcc_delete_post').click(function(){
						var wpcc_confirmation = confirm("Confirm you would like to delete this post?");
						if (wpcc_confirmation == true) {
						    var wpcc_delete_post_data = {
						        'action': 'wpcontentcalendar_lite_delete_post',
						        'wpcc_delete_post_id': event.id
						    };
						
						    $.post(ajaxurl, wpcc_delete_post_data, function(response) {
						    	if (response != false)
						    	{
						    		$('#calendar').fullCalendar('removeEvents', event.id);
						    	}				    	
						    });
						} else {
						    console.log('Cancelled.');
						}											
					
					});
			    },
			    eventMouseout: function(event, jsEvent, view) {
			        //$( '#' +  'wpcc_add_new_post_' + event.id).remove();
			        $( '#' +  'wpcc_post_manipulation_box_' + event.id).remove();
			    },
			    dayClick: function(date, jsEvent, view) {

			        //alert('Clicked on: ' + date.format());
			
			        var wpcc_new_post_from_click = {
				        'action': 'wpcontentcalendar_lite_new_post_from_click',
				        'wpcc_post_date': date.format()
				    };
				
				    $.post(ajaxurl, wpcc_new_post_from_click, function(newpostHTML) {
				    	$(newpostHTML).appendTo('#wpbody');
				    	$('#new_post_this_modal').modal({
					    		overlay: "transparent"
					   	});
					   	$('#new_post_this_modal').on($.modal.CLOSE, function(event, modal) {
							  $(this).remove();
						});
						$('.wpcc_new_box_form').submit(function(event) {
						
								// stop the form from submitting the normal way and refreshing the page    
								event.preventDefault();
								
						        // get the form data
						        // there are many ways to get this data using jQuery (you can use the class or id also)
						        var wpcc_post_date = $('input[name=wpcc_newdate]').val();
						        var wpcc_post_title = $('input[name=title]').val();
						        var wpcc_post_time = $('input[name=time]').val();
						        var wpcc_post_status = $( "#wpcc_postselect" ).val();
						        							        
						
						        // process the form
						        var wpcc_get_post_date_post = {
							        'action': 'wpcontentcalendar_lite_submit_post_data_for_post',
							        'wpcc_post_date_for_post_submit': wpcc_post_date,
							        'wpcc_post_title_for_post_submit': wpcc_post_title,
							        'wpcc_post_time_for_post_submit': wpcc_post_time,
							        'wpcc_post_status_for_post_submit': wpcc_post_status
							    };
							
							    $.post(ajaxurl, wpcc_get_post_date_post, function(response) {
									//render new event
									$.modal.close();
									//alert();
									var newEvent = {
						                id: response.slice(0,-1),
						                title: wpcc_post_title,
						                start: wpcc_post_date
						            };
						            $('#calendar').fullCalendar( 'renderEvent', newEvent , 'stick');
						        	console.log('success');							        	
						        });
					    		
							});					    					    	
					    });
			
			    },
			    eventDrop: function(event, delta, revertFunc) {			
			    
			    	var wpcc_new_date_data = {
				        'action': 'wpcontentcalendar_lite_update_post_date',
				        'wpcc_post_id': event.id,
				        'wpcc_post_date': event.start.format()
				    };
				
				    $.post(ajaxurl, wpcc_new_date_data, function(response) {
				    	//alert(response);				    	
				    });
			
			    },
			    droppable: true, // this allows things to be dropped onto the calendar !!!
			    eventReceive: function(event) {
			    	//alert(event.id);
			    	
			    	
			    },
				drop: function(date) { // this function is called when something is dropped
				
					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');
					
					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);
					
					// assign it the date that was reported
					copiedEventObject.start = date;
					
					//assign id to the event
					the_wpcc_event_id = $( this ).attr('id');
					copiedEventObject.id = the_wpcc_event_id.replace('wpcc_event_','');
					
					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					
					var wpcc_new_post_data = {
				        'action': 'wpcontentcalendar_lite_add_post_date',
				        'wpcc_post_id': copiedEventObject.id,
				        'wpcc_post_date': copiedEventObject.start.format()
				    };
				
				    $.post(ajaxurl, wpcc_new_post_data, function(response) {
				    	//alert(response);				    	
				    });
				    
					$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					
					$(this).remove();					
					
				},
				eventRender: function (event, element, view) {
					$(element).css("margin-bottom", "5px");		
		 		}
		});
		
		$('#external-events .fc-event').each(function() {
		
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});				
		
    });
    

})( jQuery );

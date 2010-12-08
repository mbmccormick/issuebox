/*global jQuery setTimeout window parent document event clearTimeout */
/* 
 * jQuery.showMessage.js 2.2 - jQuery plugin
 * Author: Andrew Alba
 * http://showMessage.dingobytes.com/
 *
 * Copyright (c) 2009-2010 Andrew Alba (http://dingobytes.com)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Built for jQuery library
 * http://jquery.com
 * 
 * Date: Mon May 06 15:52:00 2010 -0500
 */

(function($) {
		var showMessage_t;
		$.fn.showMessage = function(options){
			// DEFAULT CONFIGURATION PROPERTIES
			var defaults = {
					thisMessage:		[''],
					className:			'notification',
					position:			'top',
					opacity:			90,
					useEsc:				true,
					displayNavigation:		true,
					autoClose:			false,
					delayTime:			5000,
					closeText:			'close',
					escText:			'Esc Key or'
			};
			var option = $.extend(defaults, options);
			this.each( function() {
			    //first clear all ui=widget
			    if ( $('#showMessage', window.parent.document).length )
			    {
					$('#showMessage', window.parent.document).remove();
				}
			    // create an messageHolder div
			    var messageHolder = $('<div></div>').css({
						'display': 'none',
						'position': 'fixed',
						'z-index': 101,
						'left': 0,
						'width':'100%',
						'margin':0,
						'filter': 'Alpha(Opacity=' + option.opacity + ')',
						'opacity': option.opacity/100
					})
					.attr('id','showMessage')
					.addClass(option.className);
				if( option.position == 'top' )
				{
					$(messageHolder).css('top', 0);
				}
				else
				{
					$(messageHolder).css('bottom', 0);
				}
				if( option.useEsc )
				{
					$(window).keydown( function(e) {
						var keycode;
						if ( e === null )
						{ // ie
							keycode = event.keyCode;
						}
						else
						{ // mozilla
							keycode = e.which;
						}
						if(keycode == 27)
						{ // close
							$('#showMessage', window.parent.document).slideUp();
							if( typeof(showMessage_t) != 'undefined' )
							{
								clearTimeout(showMessage_t);
							}
						}
					});
				}
				else
				{
					$(window).unbind('keydown');
				}
				if( option.displayNavigation )
				{
					var messageNavigation = $('<span></span>')
							.css({
								'float':'right',
								'padding-right':'1em',
								'font-weight':'bold',
								'font-size':'small'
							});
							if( option.useEsc )
							{
								$(messageNavigation).html(option.escText + ' ');
							}
							var closeText = $('<a></a>')
								.attr({
										'href': '',
										'title':option.closeText
								})
								.css('text-decoration','underline')
								.click( function() {
										$('#showMessage', window.parent.document).slideUp();
										clearTimeout(showMessage_t);
										return false;
								})
								.text(option.closeText);
						$(messageNavigation).append(closeText);
					$(messageHolder).append(messageNavigation);
				}
				else
				{
					$(window).click(function() {
						if( $('#showMessage', window.parent.document).length )
						{
							$('#showMessage', window.parent.document).slideUp();
							$(window).unbind('click');
							if( typeof(showMessage_t) != 'undefined' )
							{
								clearTimeout(showMessage_t);
							}
						}
					});
				}
				var stateHolder = $('<div></div>')
						.css({
								'width':'90%',
								'margin':'1em auto',
								'padding':0
						});
					    var showmessageul = $('<ul></ul>')
								.css({
										'font-size':'large',
										'font-weight':'bold',
										'margin-left':0,
										'padding-left':0
							});
					    
						    for (var i = 0; i < option.thisMessage.length; i++)
						    {
						        var showmessageli = $('<li></li>')
										.html(option.thisMessage[i])
										.css({
											'list-style-image':'none',
											'list-style-position':'outside',
											'list-style-type':'none'
										});
						        $(showmessageul).append(showmessageli);
						    }
						$(stateHolder).append(showmessageul);
					$(messageHolder).append(stateHolder);
				if( option.position == 'top' )
				{
					$('body', window.parent.document).prepend(messageHolder);
				}
				else
				{
					$('body', window.parent.document).append(messageHolder);
				}
				$(messageHolder).slideDown();
				if ( option.autoClose )
				{
					if( typeof(showMessage_t) != 'undefined' )
					{
						clearTimeout(showMessage_t);
					}
					showMessage_t = setTimeout( function() { 
								$('#showMessage', window.parent.document).slideUp();
						}, option.delayTime);
				}
			});
		};
		$.fn.showMessage.closeMessage = function(txt)
		{
			if( $('#showMessage', window.parent.document).length )
			{
				clearTimeout(showMessage_t);
				$('#showMessage', window.parent.document).slideUp();
			}
		};
})(jQuery);
$(document).ready(function() {
	$('a.minibutton').bind({
		mousedown: function() {
			$(this).addClass('mousedown');
		},
		blur: function() {
			$(this).removeClass('mousedown');
		},
		mouseup: function() {
			$(this).removeClass('mousedown');
		}
	});
    
    $('.button').bind({
		mousedown: function() {
			$(this).addClass('mousedown');
		},
		blur: function() {
			$(this).removeClass('mousedown');
		},
		mouseup: function() {
			$(this).removeClass('mousedown');
		}
	});
});

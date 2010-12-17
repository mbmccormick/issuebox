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

$(document).ready(function() {
    if (getParameterByName("success") != "") {
        $(document).showMessage({
            thisMessage: [getParameterByName("success")],
            className: "success",
            opacity: 95,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
        });
    }
    
    if (getParameterByName("error") != "") {
        $(document).showMessage({
            thisMessage: [getParameterByName("error")],
            className: "error",
            opacity: 95,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
        });
    }
});

function getParameterByName(name)
{
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( window.location.href );
    if(results == null)
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}
// slight update to account for browsers not supporting e.which
var ctrlPressed = 0;

function disableRefresh(e) {
	var keycode;
	var isFistLoop = false;
	
	if (window.event)
		keycode = window.event.keyCode;
	else if (e)
		keycode = e.which;

	if (e.ctrlKey || (keycode == 17))
		ctrlPressed = 1;
		isFistLoop = true;
		
	if ((keycode == 116) || (keycode == 82 && ctrlPressed == 1)) {
		e.preventDefault();
		e.stopPropagation();
		ctrlPressed = 0;
		return false;
	}
	
	if (!isFistLoop)
		ctrlPressed = 0;
};

// To disable f5
$(document).on("keydown", disableRefresh);

// To re-enable f5
//$(document).off("keydown", disableRefresh);
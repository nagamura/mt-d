const idleTime = 60000; // ミリ秒
function Timer(func, time) {
    var timerObj = setInterval(func, time);

    this.stop = () => {
	if (timerObj) {
	    clearInterval(timerObj);
	    timerObj = null;
	}
	return this;
    };

    // start timer using current settings (if it's not already running)
    this.start = () => {
	if (!timerObj) {
	    this.stop();
	    timerObj = setInterval(func, time);
	}
	return this;
    };

    // start with new interval, stop current interval
    this.reset = (newTime) => {
	time = newTime;
	return this.stop().start();
    };
}

var timer = new Timer(function () {
    // your function here
    if (
	((document.activeElement.type == "textarea" ||
	  document.activeElement.type == "text") &&
	 document.activeElement.value != undefined &&
	 document.activeElement.value.length > 0) ||
	    (/inputText-/.test(document.activeElement.id) &&
	     document.activeElement.innerText != undefined &&
	     document.activeElement.innerText.length > 0) ||
	    (/body-/.test(document.activeElement.id) &&
	     document.activeElement.innerText != undefined &&
	     document.activeElement.innerText.length > 0)
    )
	return;
    //location.reload();
}, idleTime);

window.addEventListener(
    "keypress",
    (resetTimer = () => {
	timer.reset(idleTime);
	return false;
    })
);

window.addEventListener(
    "click",
    (resetTimer = () => {
	timer.reset(idleTime);
	return false;
    })
);

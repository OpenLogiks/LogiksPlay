parent.waitingDialog.hide();

//Use CDN to load JS Libraries
function lgksLoadJS(scriptLib, callback) {
    if(Array.isArray(scriptLib)) {
        var counter = 0;
        scriptLib.forEach(function(src) {
            $.getScript("https://unpkg.com/"+src, function(data, textStatus, jqxhr) {
                counter++;
                if(counter>=scriptLib.length) {
                    if(typeof callback == "function") callback(textStatus, data);
                }
            })
        });
    } else {
        $.getScript("https://unpkg.com/"+scriptLib, function(data, textStatus, jqxhr) {
            if(typeof callback == "function") callback(textStatus, data);
        })
    }
}
window.onload = function() {
    document.addEventListener("contextmenu", function(e){
      e.preventDefault();
    }, false);
    document.addEventListener("keydown", function(e) {
          //document.onkeydown = function(e) {
            // "I" key
            if (e.ctrlKey && e.shiftKey && e.key == 'I') {
              disabledEvent(e);
            }
            // "J" key
            if (e.ctrlKey && e.shiftKey && e.key == 'J') {
              disabledEvent(e);
            }
            // "S" key + macOS
            if (e.key == 'S' && (navigator.userAgentData.match("Mac") ? e.metaKey : e.ctrlKey)) {
              disabledEvent(e);
            }
            // "U" key
            if (e.ctrlKey && (e.key == 'U' || e.key == 'u')) {
              disabledEvent(e);
            }
            // "F12" key
            if (e.key == 'F12') {
              disabledEvent(e);
            }
          }, false);
    function disabledEvent(e){
      if (e.stopPropagation){
        e.stopPropagation();
      } else if (window.event){
        window.event.cancelBubble = true;
      }
      e.preventDefault();
      return false;
    }
  };
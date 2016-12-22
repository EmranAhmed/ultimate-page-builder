(function () {

    function init() {

        // Create the <style> tag
        var style = document.createElement("style");

        // WebKit hack
        style.appendChild(document.createTextNode(""));

        // Add the <style> element to the page
        document.head.appendChild(style);

        // insertRule to body
        style.sheet.insertRule("body { visibility: hidden; }", 0);
    }

    function scoper(css, prefix) {

        var re = new RegExp("([^\r\n,{}]+)(,(?=[^}]*{)|\s*{)", "g");

        css = css.replace(re, function (g0, g1, g2) {

            if (g1.match(/^\s*(@media|@keyframes|to|from|@font-face)/)) {
                return g1 + g2;
            }

            if (g1.match(/:scope/)) {
                g1 = g1.replace(/([^\s]*):scope/, function (h0, h1) {
                    if (h1 === "") {
                        return ""; // "> *"
                    }
                    else {
                        return "> " + h1;
                    }
                });
            }

            g1 = g1.replace(/^(\s*)/, "$1" + prefix + " ");

            return g1 + g2;
        });

        return css;
    }

    function process() {

        var styles = document.body.querySelectorAll("style[scoped]");

        if (styles.length === 0) {
            document.getElementsByTagName("body")[0].style.visibility = "visible";
            return;
        }

        var head = document.head || document.getElementsByTagName("head")[0];

        // Create the <style> tag
        var newstyle   = document.createElement("style");
        newstyle.type  = 'text/css';
        newstyle.media = "screen";

        // CSS Rules
        var csses = "";

        for (var i = 0; i < styles.length; i++) {

            var style = styles[i];

            var css = style.innerHTML;

            if (css && (style.parentElement.nodeName !== "BODY")) {

                var element = style.parentNode;

                var id = "_upb_scoped-" + i;

                // <style> prefixed
                var prefix = element.tagName.toLowerCase() + "[" + id + "]";

                // Add _upb_scoped on each element
                element.setAttributeNode(document.createAttribute(id));

                // Remove Scoped Style Tag
                style.parentNode.removeChild(style);

                csses += scoper(css, prefix);

            }
        }

        if (newstyle.styleSheet) {
            newstyle.styleSheet.cssText = csses;
        }
        else {
            newstyle.appendChild(document.createTextNode(csses));
        }

        head.appendChild(newstyle);
        document.getElementsByTagName("body")[0].style.visibility = "visible";
    }

    if ("scoped" in document.createElement("style")) {
        return;
    }

    // init();

    if (document.readyState === "complete" || document.readyState === "loaded") {
        process();
    }
    else {
        document.addEventListener("DOMContentLoaded", process);
    }
}());
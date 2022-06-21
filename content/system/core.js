function loadImgs() {
    var z, i, file, elmnt, xhttp;
    z = document.getElementsByTagName("*");
    for (i = 0; i < z.length; i++) {
        elmnt = z[i];
        file = elmnt.getAttribute("load-image");
        if (file) {
            var thumbnail = document.createElement("IMG");
            thumbnail.setAttribute("style", "display:none;");
            thumbnail.setAttribute("onload", 'this.setAttribute("style", "display:block;");this.parentElement.classList.add("loaded");');
            thumbnail.src = file;
            thumbnail.setAttribute("alt", "Failed to load");
            thumbnail.setAttribute("class", "linkim");
            elmnt.appendChild(thumbnail);
            elmnt.removeAttribute("load-image");
            if (this.status == 404) { thumbnail.setAttribute("style", "display:block;");  continue; }
        }
    }
}
loadImgs();

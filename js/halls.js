var dialog = document.getElementById("halls-add-dialog");
var dialogProgram = document.getElementById("hall-add-seat-dialog");
var dialogImport = document.getElementById("hall-import-dialog");

function openDialog() {
    dialog.style.display = "flex";
}

function closeDialog() {
    dialog.style.display = "none";
}

function openDialogProgram() {
    dialogProgram.style.display = "flex";
}

function closeDialogProgram() {
    dialogProgram.style.display = "none";
}

function openDialogImport() {
    dialogImport.style.display = "flex";
}

function closeDialogImport() {
    dialogImport.style.display = "none";
}

function exportHall() {
    var xhr = new XMLHttpRequest();
    var temp = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;
    var url = temp.substr(0, temp.lastIndexOf("/")) + "/actions/export.php";
    xhr.open("GET", url, true);
    xhr.responseType = "blob";
    xhr.onload = function () {
        var tag = document.createElement('a');
        var urlCreator = window.URL || window.webkitURL;
        var url = urlCreator.createObjectURL(this.response);
        tag.href = url;
        tag.download = "export.json";
        document.body.appendChild(tag);
        tag.click();
        document.body.removeChild(tag);
    };
    xhr.send();
}
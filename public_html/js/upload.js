/**
 * Created by Rickardh on 2016-05-16.
 */
var rowNumber = 0;
function addRow(id, name) {
    var div = document.createElement('div');
    div.className = "form-group input-group col-md-12"
    div.id = "row" + rowNumber;
    div.innerHTML = "<span class='input-group-btn'><button id='remove" + rowNumber + "' onclick=\"removeRow(" + rowNumber + ");\" type=\"button\" class=\"btn btn-danger\">-</button></span><input name='" + name + "[]' placeholder='" + name + "' type='text' class='form-control'>";
    document.getElementById(id).appendChild(div);
    document.getElementById(id).removeChild(document.getElementById("add" + name));
    var button = document.createElement('div');
    button.id = "add" + name;
    button.className = "form-group input-group col-md-12";
    button.innerHTML = '<button id="add' + name + '" onclick="addRow(\'' + name + 's\', \'' + name + '\');" type="button" class="btn btn-success">+</button>';
    document.getElementById(id).appendChild(button);
    rowNumber++;
}
function removeRow(number) {
    var child = document.getElementById("row" + number);
    child.parentNode.removeChild(child);
}
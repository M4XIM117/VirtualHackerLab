// Only handles the switchTab for Terminals
function switchTab(evt, tabName) {
  var i, tabs, terminals;

  tabs = document.getElementsByClassName("tab");
  for (i = 0; i < tabs.length; i++) {
    tabs[i].className = tabs[i].className.replace(" active", "");
  }

  terminals = document.getElementsByClassName("vhlterminal");
  for (i = 0; i < terminals.length; i++) {
    terminals[i].style.display = "none";
  }

  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

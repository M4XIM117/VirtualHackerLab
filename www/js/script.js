function onStart() {
    var i, tabcontent;
    
    
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
      
  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
}


function openPage(pageName, elmnt, color) {
    // Hide all elements with class="tabcontent" by default */
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    
  
    // Remove the background color of all tablinks/buttons
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.backgroundColor = "";
    }
  
    // Show the specific tab content
    document.getElementById(pageName).style.display = "block";
    const targetElement = document.getElementById(pageName);

    fetch("Anleitungen/webshell_" + pageName.toLowerCase() + ".html")
      .then(response => response.text())
      .then(content => {
        targetElement.innerHTML = content;
      })
      .catch(error => console.error(error));

  
    // Add the specific color to the button used to open the tab content
    elmnt.style.backgroundColor = color;
  }




const tabs = document.querySelectorAll('.tab-btn');
const tabContent = document.querySelectorAll('.tab-item');

tabs.forEach(tab => {
  tab.addEventListener('click', function() {
    const tabId = this.getAttribute('id');
    const current = document.querySelector(`.tab-item.show`);

    current.classList.remove('show');
    document.querySelector(`#${tabId.replace('-btn', '')}`).classList.add('show');
  });
});

tabContent[0].classList.add('show');


// function test() {
//   const targetElement = document.getElementById("Einleitung");
//   targetElement.innerHTML = "<?php include '/Anleitungen/webshell_einleitung.html'; ?>";
// }

document.addEventListener("DOMContentLoaded", function() {

  const accordionBtns = document.querySelectorAll(".toggle-item");
    accordionBtns.forEach((accordion) => {
      accordion.onclick = function () {
        this.classList.toggle("is-open");
  
        let content = this.nextElementSibling;
  
        if (content.style.maxHeight) {
          //this is if the accordion is open
          content.style.maxHeight = null;
        } else {
          //if the accordion is currently closed
          content.style.maxHeight = content.scrollHeight + "px";
          console.log(content.style.maxHeight);
        }
      };
    })
    
  });
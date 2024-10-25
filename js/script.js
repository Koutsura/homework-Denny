function showContent(section) {
    const content = document.getElementById("content");
    const dashboard = document.getElementById("dashboard");
    const tugas = document.getElementById("tugas");
  
    if (section === "dashboard") {
      content.scrollTop = dashboard.offsetTop; // Scroll ke bagian dashboard
    } else if (section === "tugas") {
      content.scrollTop = tugas.offsetTop; // Scroll ke bagian tugas
    }
  }
  
  function setActive(link) {
    // Menghapus kelas 'active' dari semua tautan
    var links = document.querySelectorAll(".nav-link");
    links.forEach(function (link) {
      link.classList.remove("active");
    });
  
    // Menambahkan kelas 'active' ke tautan yang diklik
    link.classList.add("active");
  }
  
  // Secara otomatis mengaktifkan menu berdasarkan bagian yang terlihat saat menggulir
  window.addEventListener("scroll", function () {
    var sections = document.querySelectorAll("section");
    var scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;
  
    sections.forEach(function (section) {
      if (
        scrollPosition >= section.offsetTop - 70 &&
        scrollPosition < section.offsetTop + section.offsetHeight - 70
      ) {
        var currentId = section.getAttribute("id");
        var activeLink = document.querySelector('.nav-link[href="#' + currentId + '"]');
        if (activeLink) {
          setActive(activeLink);
        }
      }
    });
  });
  
  



// JavaScript untuk kloning elemen logo agar looping lebih mulus
/* const logoContainer = document.querySelector('.logo-container');
const logo = document.querySelector('.logo');
const clone = logo.cloneNode(true);
logoContainer.appendChild(clone); */
const logo = document.querySelector(".logo").cloneNode(true);
document.querySelector(".logo-container").appendChild(logo);



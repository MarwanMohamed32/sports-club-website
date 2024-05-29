// Sticky Header
window.addEventListener("scroll", function () {
  var header = document.querySelector("header");
  header.classList.toggle("sticky", window.scrollY > 10);
});

// SIDE ANIMATION
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add("show");
    } else {
      entry.target.classList.remove("show");
    }
  });
});

const hiddenElements = document.querySelectorAll(".hidden");
hiddenElements.forEach((el) => observer.observe(el));

// RESPONSIBLE FOR LOG IN
document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");
  const userData = document.getElementById("userData");
  const errorSpan = document.querySelector(".error");
  const loginLayoutRight = document.querySelector(".login-layout-right");

  loginForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(loginForm);

    fetch(loginForm.getAttribute("action"), {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        if (
          data === "Invalid password" ||
          data === "No account found with that name"
        ) {
          loginLayoutRight.style.display = "flex";
          // Display error span
          userData.style.display = "none";
          errorSpan.style.display = "block";
        } else {
          loginLayoutRight.style.display = "none";
          userData.style.display = "flex";
          // Hide error span
          errorSpan.style.display = "none";
          const userDataArray = data.split("|");
          document.getElementById("name-data").textContent += userDataArray[0];
          document.getElementById("email-data").textContent += userDataArray[1];
          document.getElementById("membership-start-data").textContent +=
            userDataArray[2];
          document.getElementById("membership-end-data").textContent +=
            userDataArray[3];
        }
      })
      .catch((error) => console.error("Error:", error));
  });
});

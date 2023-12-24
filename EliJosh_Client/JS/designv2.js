document.addEventListener("scroll", function () {
    const navbar = document.getElementsByClassName("Mainnavigation")[0];
    const scrollPosition = window.scrollY;
    const triggerPosition =90 * window.innerHeight / 100; // 100vh

    const hoverableListItems = document.querySelectorAll(".Mainnavigation ul li a");
    const hoverableListItems2 = document.querySelectorAll(".USERVALUE a");
    const hoverableListItems3 = document.querySelectorAll(".USERVALUE svg");

    if (scrollPosition > triggerPosition) {
        navbar.classList.add("glassylink")
        //hoverableListItems.style.backgroundColor = "red"; // Change the background color on scroll
    } else {
        navbar.classList.remove("glassylink")
    }

});

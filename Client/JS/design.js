document.addEventListener("scroll", function () {
    const navbar = document.getElementsByClassName("Mainnavigation")[0];
    const scrollPosition = window.scrollY;
    const triggerPosition =90 * window.innerHeight / 100; // 100vh

    const hoverableListItems = document.querySelectorAll(".Mainnavigation ul li a");
    const hoverableListItems2 = document.querySelectorAll(".USERVALUE a");
    const hoverableListItems3 = document.querySelectorAll(".USERVALUE svg");

    if (scrollPosition > triggerPosition) {
        console.log(123)
        hoverableListItems.forEach(function (element) {
            // Apply your styles or perform actions on the elements here
            element.style.color = "#333"; // Example: Change the text color of hovered items that are not .HOMETITLELI
        });
        hoverableListItems2.forEach(function (element) {
            // Apply your styles or perform actions on the elements here
            element.style.color = "#333"; // Example: Change the text color of hovered items that are not .HOMETITLELI
        });
        hoverableListItems3.forEach(function (element) {
            element.style.fill = "#333"; // Change the fill color to red
        });
       
        navbar.classList.add("glassylink")

        //hoverableListItems.style.backgroundColor = "red"; // Change the background color on scroll
    } else {
        hoverableListItems.forEach(function (element) {
            // Apply your styles or perform actions on the elements here
            element.style.color = "#fff"; // Example: Change the text color of hovered items that are not .HOMETITLELI
        });
        hoverableListItems2.forEach(function (element) {
            // Apply your styles or perform actions on the elements here
            element.style.color = "#333"; // Example: Change the text color of hovered items that are not .HOMETITLELI
        });
        hoverableListItems3.forEach(function (element) {
            element.style.fill = "#fff"; // Change the fill color to red
        });
        navbar.classList.remove("glassylink")

    }
});
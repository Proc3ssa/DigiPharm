setInterval(function() {
    //location.reload();
}, 2000);

let currentIndex = 0;
    const itemsToShow = 4; // Number of <li> elements to show in one view
    const slider = document.getElementById('slider');
    const listItems = slider.querySelectorAll('li');
    const totalItems = listItems.length;

    // Function to handle sliding
    function slide(direction) {
        const maxIndex = totalItems - itemsToShow;
        currentIndex += direction;

        if (currentIndex < 0) {
            currentIndex = 0;
        } else if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }

        const offset = currentIndex * (listItems[0].offsetWidth + 15); // 15px is the margin-right
        slider.style.transform = `translateX(-${offset}px)`;
    }

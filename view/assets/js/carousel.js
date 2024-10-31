$(document).ready(function () {
    function addCarouselItem(imageSrc, title, description) {
        const newItem = `
            <div class="carousel-item">
                <img src="${imageSrc}" class="d-block w-100" alt="${title}" style="object-fit: cover; object-position: center;">
                <div class="carousel-caption d-none d-md-block text-start">
                    <h5 class="text-uppercase">${title}</h5>
                    <p>${description}</p>
                    <a href="#" class="btn btn-outline-light">Ver Curso</a>
                </div>
            </div>
        `;
        $('.carousel-inner').append(newItem);
    }

    addCarouselItem('./assets/images/course-thumbnail.jpg', 'Lorem Ipsum 5', 'New description for image 5...');
    addCarouselItem('./assets/images/modal_header.png', 'Lorem Ipsum 5', 'New description for image 5...');

    $('#courseCarousel').carousel({
        interval: 3000
    });
});
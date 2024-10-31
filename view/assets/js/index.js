$(document).ready(function () {
    console.log("hello")
    $('#courseModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const title = button.data('title');
        const description = button.data('description');
        const thumbnail = button.data('thumbnail');
        console.log(thumbnail)
        console.log(title)
        console.log(description)
        $('#modalTitle').text(title);
        $('#modalDescription').text(description);
        $('#modalThumbnail').attr('src', thumbnail);
    });
});
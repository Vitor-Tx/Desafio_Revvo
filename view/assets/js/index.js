$(document).ready(function () {
    showWelcomeModal();
    $('#courseModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        setModalData(button);
    });
    $('#deleteCourseBtn').on('click', deleteCourse);
    $('#editCourseBtn').on('click', startEditingCourse);
    $('#cancelEditBtn').on('click', cancelEdit);
    $('#saveEditBtn').on('click', saveCourseEdits);
    $('#createCourseForm').on('submit', createCourse);
    $('#courseSearch').on('input', function () {
        filterCourses($(this).val().toLowerCase());
    });

    function showWelcomeModal() {
        if (!localStorage.getItem('welcomeModalShown')) {
            $('#welcomeModal').modal('show');
            localStorage.setItem('welcomeModalShown', 'true');
        }
    }

    function setModalData(button) {
        const courseId = button.data('id');
        const title = button.data('title');
        const description = button.data('description');
        const thumbnail = button.data('thumbnail');
        const link = button.data('link');

        $('#modalTitle').text(title);
        $('#modalDescription').text(description);
        $('#modalThumbnail').attr('src', thumbnail);

        $('#editTitle').val(title);
        $('#editDescription').val(description);
        $('#editLink').val(link);

        $('#deleteCourseBtn, #editCourseBtn').data('id', courseId);
    }

    function deleteCourse() {
        const courseId = $(this).data('id');
        console.log(courseId);

        $.ajax({
            url: 'http://localhost/revvo-test/api/index.php',
            type: 'DELETE',
            contentType: 'application/json',
            data: JSON.stringify({ id: courseId }),
            success: function () {
                $(`a[data-id="${courseId}"]`).closest('.course-card').remove();
                $('#courseModal').modal('hide');
                alert("Curso Excluído!");
            },
            error: function (xhr, status, error) {
                console.error("Failed to delete course:", error);
                alert("Failed to delete course. Please try again.");
            }
        });
    }

    function startEditingCourse() {
        $('#editCourseForm').show();
        $('#modalTitle, #modalDescription, #editCourseBtn, #deleteCourseBtn, .modal-img').hide();
        $(".modal-header").addClass("modal-create-header");
        $(".modal-illustration").append(`<h5 class="modal-title text-center">Editar curso</h5>`);
    }

    function cancelEdit() {
        $('#editCourseForm').hide();
        $('#modalTitle, #modalDescription, #editCourseBtn, #deleteCourseBtn, .modal-img').show();
        $(".modal-header").removeClass("modal-create-header");
        $(".modal-illustration h5").remove();
    }

    function saveCourseEdits() {
        const courseId = $('#editCourseBtn').data('id');
        const updatedTitle = $('#editTitle').val();
        const updatedDescription = $('#editDescription').val();
        const updatedLink = $('#editLink').val();

        $.ajax({
            url: 'http://localhost/revvo-test/api/index.php',
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
                id: courseId,
                title: updatedTitle,
                description: updatedDescription,
                thumbnail: "thumbnail.jpg",
                images: ["uploads/react1.jpg", "uploads/react2.jpg"],
                link: updatedLink
            }),
            success: function () {
                updateCourseCard(courseId, updatedTitle, updatedDescription);
                alert("Course updated successfully!");
            },
            error: function (xhr, status, error) {
                console.error("Failed to update course:", error);
                alert("Failed to update course. Please try again.");
            }
        });
    }

    function updateCourseCard(courseId, title, description) {
        const courseCard = $(`.course-card[id='${courseId}']`);
        const courseModal = $('#courseModal');

        courseCard.find('.card-title').text(title);
        courseCard.find('.card-text').text(description);

        courseModal.find('.modal-title').text(title);
        courseModal.find('.modal-description').text(description);

        $('#modalTitle').text(title);
        $('#modalDescription').text(description);

        $('#courseModal').modal('hide');
    }

    function createCourse(e) {
        e.preventDefault();

        const courseData = {
            title: $('#courseTitle').val(),
            description: $('#courseDescription').val(),
            thumbnail: "thumbnail.jpg",
            images: ["uploads/react1.jpg", "uploads/react2.jpg"],
            link: $('#courseLink').val()
        };

        $.ajax({
            url: 'http://localhost/revvo-test/api/index.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(courseData),
            success: function () {
                addNewCourse(courseData);
                $('#createCourseModal').modal('hide');
                $('#createCourseForm')[0].reset();
            },
            error: function (xhr, status, error) {
                console.error("Failed to create course:", error);
                alert("Failed to create course. Please try again.");
            }
        });
    }

    function addNewCourse(courseData) {
        const newCourseHtml = `
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card">
                    <img src="./assets/images/course-thumbnail.jpg" class="card-img-top" alt="Course">
                    <div class="card-body text-center">
                        <h5 class="card-title">${courseData.title}</h5>
                        <p class="card-text">${courseData.description}</p>
                        <a href="#"
                            class="btn btn-success card-button view-course-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#courseModal"
                            data-title="${courseData.title}"
                            data-description="${courseData.description}"
                            data-thumbnail="./assets/images/course-thumbnail.jpg">
                            Ver Curso
                        </a>
                    </div>
                </div>
            </div>
        `;
        $('.courses-list').append(newCourseHtml);
    }

    function filterCourses(searchText) {
        console.log("searchText: " + searchText);
        $('.course-card').each(function () {
            const courseTitle = $(this).find('.card-title').text().toLowerCase();
            console.log("courseTitle: " + courseTitle);
            if (courseTitle.includes(searchText)) {
                console.log("shown");
                $(this).show();
            } else {
                console.log("hidden");
                $(this).hide();
            }
        });
    }
});
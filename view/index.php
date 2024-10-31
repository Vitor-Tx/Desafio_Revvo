<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Revvo - Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>

    <header class="header bg-white py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <img src="./assets/images/logo.webp" alt="Logo" class="logo">
            <div class="header__search d-none d-md-flex align-items-center">
                <input type="text" class="form-control" placeholder="Pesquisar cursos...">
                <button class="btn btn-link text-muted">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="header__profile d-flex align-items-center">
                <img src="./assets/images/profile_photo.jpeg" alt="User" class="rounded-circle" width="70" height="70">
                <div class="ms-2">
                    <p class="mb-0 small text-muted">Seja bem-vindo</p>
                    <p class="mb-0 fw-bold">John Doe</p>
                </div>
            </div>
        </div>
    </header>

    <div id="courseCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./assets/images/banner.jpeg" class="d-block w-100" alt="Carousel Image">
                <div class="carousel-caption d-none d-md-block text-start">
                    <h5 class="text-uppercase">Lorem Ipsum</h5>
                    <p>Aenean lacinia bibendum nulla sed consectetur...</p>
                    <a href="#" class="btn btn-outline-light">Ver Curso</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#courseCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#courseCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <section class="container my-5">
        <h2>Meus Cursos</h2>
        <div class="row">
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card add-course d-flex justify-content-center align-items-center">
                    <i class="fas fa-plus fa-3x"></i>
                    <p>Adicionar Curso</p>
                </div>
            </div>
            <?php
            $apiUrl = 'http://localhost/revvo-test/api/index.php';
            $response = file_get_contents($apiUrl);
            $courses = json_decode($response, true);

            if ($courses && isset($courses['data'])) {
                foreach ($courses['data'] as $course) {
                    echo '
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card">
                            <img src="./assets/images/course-thumbnail.jpg" class="card-img-top" alt="Course">
                            <div class="card-body text-center">
                                <h5 class="card-title">' . htmlspecialchars($course['title'] ?? "") . '</h5>
                                <p class="card-text">' . htmlspecialchars($course['description'] ?? "") . '</p>
                                <a href="#"
                                    class="btn btn-success card-button view-course-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#courseModal"
                                    data-title="' . htmlspecialchars($course['title'] ?? "") . '"
                                    data-description="' . htmlspecialchars($course['description'] ?? "") . '"
                                    data-thumbnail="./assets/images/course-thumbnail.jpg">
                                    Ver Curso
                                </a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No courses found.</p>';
            }
            ?>
        </div>
    </section>
    <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <img id="modalThumbnail" src="" alt="Course Thumbnail" class="w-100 rounded-top">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="modalTitle" class="modal-title"></h5>
                    <p id="modalDescription"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer bg-light py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                    <img src="./assets/images/logo.webp" alt="Logo" class="footer-logo mb-2">
                    <p class="text-muted small">Maecenas faucibus mollis interdum. Morbi leo risus, porta ac consectetur
                        ac, vestibulum at eros.</p>
                </div>
                <div class="col-md-4 text-center text-md-center mb-3 mb-md-0">
                    <h6 class="text-uppercase text-muted fw-bold">// Contato</h6>
                    <p class="text-muted small mb-0">(21) 98765-3434</p>
                    <p class="text-muted small mb-0">contato@leoelearning.com</p>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <h6 class="text-uppercase text-muted fw-bold">// Redes Sociais</h6>
                    <div class="footer-social-icons">
                        <a href="#" class="text-muted mx-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted mx-2"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-muted mx-2"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="text-muted small mb-0">Copyright 2017 - All rights reserved.</p>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./assets/js/index.js"></script>
</body>

</html>
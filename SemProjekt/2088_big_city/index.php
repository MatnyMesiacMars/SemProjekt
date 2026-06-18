<?php
session_start();

require_once 'auth.php';
require_once 'classes/Database.php';
require_once 'classes/CommentRepository.php';

$comments = [];
$databaseError = '';

try {
    $database = new Database();
    $commentRepository = new CommentRepository($database->getConnection());
    $comments = $commentRepository->getAll();
} catch (PDOException $exception) {
    $databaseError = 'Nepodarilo sa pripojiť k databáze. Skontroluj XAMPP MySQL, databázu semprojekt a db/config.php.';
}
?>
<!DOCTYPE html>
<html lang="sk">

<?php
$file_path = 'Header a footer/header.php';
if (!include($file_path)) {
    echo 'Failed to include ' . htmlspecialchars($file_path);
}
?>

<body>

    <div class="cd-bg-video-wrapper" data-video="video/bangkok-city">
        <!-- video element will be loaded using jQuery -->
    </div>

    <!-- Content -->
    <div class="cd-hero">

        <!-- Navigation -->
        <div class="cd-slider-nav">
            <div class="container">
                <nav class="navbar">
                    <div class="tm-navbar-bg">
                        <a class="navbar-brand text-uppercase" href="index.php">Black-Market</a>

                        <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#tmNavbar">
                            &#9776;
                        </button>

                        <div class="collapse navbar-toggleable-md text-xs-center text-uppercase tm-navbar" id="tmNavbar">
                            <ul class="nav navbar-nav">
                                <li class="nav-item active selected">
                                    <a class="nav-link" href="#0" data-no="1">
                                        Home <span class="sr-only">(current)</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#0" data-no="2">Otázky</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#0" data-no="3">Galéria</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#0" data-no="4">Kontakt</a>
                                </li>

                                <?php if (!isLoggedIn()): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="login.php">Login</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="register.php">Register</a>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="comment_create.php">Pridať</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <?= htmlspecialchars($_SESSION['username']) ?>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="logout.php">Logout</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <div style="background:#28a745;color:white;padding:14px;text-align:center;font-weight:bold;font-size:20px;">
                ADMIN
            </div>
        <?php endif; ?>

        <ul class="cd-hero-slider">

            <!-- Page 1 Home -->
            <li class="selected">
                <div class="cd-full-width">
                    <div class="container js-tm-page-content tm-page-1 tm-section-margin-t-small" data-page-no="1">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="tm-home-container-outer">
                                    <div class="tm-home-container">
                                        <div class="tm-home-title-container">
                                            <h2 class="tm-text-title text-xs-center tm-home-title">
                                                Vitaj v BlackMarket
                                            </h2>
                                        </div>

                                        <div class="tm-home-description-container tm-bg-dark-blue">
                                            <div class="text-xs-left tm-textbox">
                                                <p class="tm-text tm-home-description">
                                                   Vitaj na našom fóre BlackMarket, kde môžeš klásť otázky ohľadom fantasy zbraní a dostávať odpovede od adminov.
                                                </p>

                                                <p class="tm-text tm-home-description">
                                                    Môžeš sa prihlásiť alebo zaregistrovať, aby si mohol pridávať otázky a odpovede.
                                                </p>

                                                <?php if (!isLoggedIn()): ?>
                                                    <p>
                                                        <a href="login.php" class="btn btn-primary">Prihlásiť sa</a>
                                                        <a href="register.php" class="btn btn-success">Registrovať sa</a>
                                                    </p>
                                                <?php else: ?>
                                                    <p>
                                                        <a href="comment_create.php" class="btn btn-success">Pridať otázku</a>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tm-home-container-bg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Page 2 Questions  -->
            <li>
                <div class="cd-full-width">
                    <div class="container js-tm-page-content tm-section-margin-t" data-page-no="2">
                        <div class="row tm-margin-b">
                            <div class="col-xs-12">
                                <div class="tm-bg-white tm-textbox-padding">
                                    <h2 class="tm-text-title tm-margin-b-0">Otázky a odpovede</h2>
                                </div>
                            </div>
                        </div>

                        <?php if ($databaseError !== ''): ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding">
                                        <p class="tm-text"><?= htmlspecialchars($databaseError) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (isLoggedIn()): ?>
                            <div class="row tm-margin-b">
                                <div class="col-xs-12">
                                    <a href="comment_create.php" class="btn btn-success">Pridať novú otázku</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row tm-margin-b">
                                <div class="col-xs-12">
                                    <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding">
                                        <p class="tm-text">
                                            Pre pridanie otázky sa najprv prihlás alebo zaregistruj.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($comments) && $databaseError === ''): ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding">
                                        <p class="tm-text">Zatiaľ neexistuje žiadna otázka.</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($comments as $comment): ?>
                            <div class="row tm-margin-b">
                                <div class="col-xs-12">
                                    <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding">
                                        <h3 class="tm-text-title tm-text-title-small">
                                            <?= htmlspecialchars($comment['question']) ?>
                                        </h3>

                                        <p class="tm-text">
                                            <strong>Odpoveď:</strong>
                                            <?php if (trim((string) $comment['answer']) !== ''): ?>
                                                <?= nl2br(htmlspecialchars($comment['answer'])) ?>
                                            <?php else: ?>
                                                <em>Zatiaľ bez odpovede.</em>
                                            <?php endif; ?>
                                        </p>

                                        <p class="tm-text">
                                            Autor: <?= htmlspecialchars($comment['username']) ?>
                                            | Vytvorené: <?= htmlspecialchars($comment['created_at']) ?>
                                        </p>

                                        <?php if (isAdmin()): ?>
                                            <a href="comment_edit.php?id=<?= (int) $comment['id'] ?>" class="btn btn-primary">
                                                Upraviť
                                            </a>

                                            <a
                                                href="comment_delete.php?id=<?= (int) $comment['id'] ?>"
                                                class="btn btn-danger"
                                                onclick="return confirm('Naozaj chceš vymazať tento záznam?');"
                                            >
                                                Vymazať
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </li>

            <!-- Page 3 Gallery -->
            <li>
                <div class="cd-full-width">
                    <div class="container js-tm-page-content tm-section-margin-t" data-page-no="3">
                        <div class="row tm-margin-b">
                            <div class="col-xs-12">
                                <div class="tm-img-gallery-container">
                                    <div class="tm-img-gallery gallery-first">
                                        <div class="tm-gallery-title-container">
                                            <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding tm-margin-b">
                                                <h2 class="tm-text-title tm-gallery-title tm-margin-b-0">
                                                    <span class="tm-white">Prvá galéria</span>
                                                </h2>
                                            </div>
                                            <div class="tm-bg-white-half"></div>
                                        </div>

                                        <?php for ($i = 1; $i <= 6; $i++): ?>
                                            <?php $num = str_pad((string) $i, 2, '0', STR_PAD_LEFT); ?>
                                            <div class="grid-item">
                                                <a href="img/tm-img-<?= $num ?>.jpg">
                                                    <img src="img/tm-img-<?= $num ?>-tn.jpg" alt="Image" class="img-fluid tm-img">
                                                </a>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="tm-img-gallery-container">
                                    <div class="tm-img-gallery gallery-second">
                                        <div class="tm-gallery-title-container">
                                            <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding tm-margin-b">
                                                <h2 class="tm-text-title tm-gallery-title tm-margin-b-0">
                                                    <span class="tm-white">Druhá galéria</span>
                                                </h2>
                                            </div>
                                            <div class="tm-bg-white-half"></div>
                                        </div>

                                        <?php for ($i = 7; $i <= 12; $i++): ?>
                                            <?php $num = str_pad((string) $i, 2, '0', STR_PAD_LEFT); ?>
                                            <div class="grid-item <?= $i <= 8 ? 'grid-item-big' : 'grid-item-square' ?>">
                                                <a href="img/tm-img-<?= $num ?>.jpg">
                                                    <img src="img/tm-img-<?= $num ?>-tn.jpg" alt="Image" class="img-fluid tm-img-no-border">
                                                </a>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Page 4 Contact -->
            <li>
                <div class="cd-full-width">
                    <div class="container js-tm-page-content tm-section-margin-t-small" data-page-no="4">
                        <div class="tm-contact-page">
                            <div class="row tm-margin-b">
                                <div class="col-xs-12">
                                    <div class="tm-bg-white tm-textbox-padding">
                                        <h2 class="tm-text-title tm-margin-b-0">Kontakt</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tm-flex tm-contact-container tm-bg-dark-blue">
                                        <div class="text-xs-left tm-textbox tm-2-col-textbox-2 tm-textbox-padding tm-textbox-padding-contact">
                                            <p class="tm-text">
                                                Text3
                                            </p>
                                            <p class="tm-text">
                                                Text4
                                            </p>
                                        </div>

                                        <div class="text-xs-left tm-textbox tm-2-col-textbox-2 tm-textbox-padding tm-textbox-padding-contact">
                                            <form action="index.php" method="post" class="tm-contact-form">
                                                <div class="form-group">
                                                    <input type="text" id="contact_name" name="contact_name" class="form-control" placeholder="Name" required>
                                                </div>

                                                <div class="form-group">
                                                    <input type="email" id="contact_email" name="contact_email" class="form-control" placeholder="Email" required>
                                                </div>

                                                <div class="form-group">
                                                    <textarea id="contact_message" name="contact_message" class="form-control" rows="5" placeholder="Your message" required></textarea>
                                                </div>

                                                <button type="submit" class="tm-submit-btn">Send</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <?php
        $file_path = 'Header a footer/footer.php';
        if (!include($file_path)) {
            echo 'Failed to include ' . htmlspecialchars($file_path);
        }
        ?>

    </div>

    <!-- Preloader -->
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

    <!-- load JS files -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/isInViewport.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/hero-slider-main.js?v=2"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>

    <script>
        function adjustHeightOfPage(pageNo) {
            var offset = 80;
            var pageContentHeight = $(".cd-hero-slider li:nth-of-type(" + pageNo + ") .js-tm-page-content").height();

            if ($(window).width() >= 992) {
                offset = 120;
            } else if ($(window).width() < 480) {
                offset = 40;
            }

            var totalPageHeight = 335 + $('.cd-slider-nav').height()
                + pageContentHeight + offset + $('.tm-footer').height();

            if (totalPageHeight > $(window).height()) {
                $('.cd-hero-slider').addClass('small-screen');
                $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", totalPageHeight + "px");
            } else {
                $('.cd-hero-slider').removeClass('small-screen');
                $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", "100%");
            }
        }

        function uploadVideo() {
            var videoWrapper = $('.cd-bg-video-wrapper');

            if (videoWrapper.is(':visible')) {
                var videoUrl = videoWrapper.data('video');
                var video = $('<video autoplay loop><source src="' + videoUrl + '.mp4" type="video/mp4" /></video>');
                video.appendTo(videoWrapper);

                if (videoWrapper.parent('.cd-bg-video.selected').length > 0) {
                    video.get(0).play();
                }
            }
        }

        $(window).load(function () {
            adjustHeightOfPage(1);

            if ($(window).width() > 800) {
                uploadVideo();
            }

            $('.gallery-first').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {enabled: true}
            });

            $('.gallery-second').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {enabled: true}
            });

            $('#tmNavbar a').click(function () {
                $('#tmNavbar').collapse('hide');

                var pageNo = $(this).data("no");

                if (pageNo) {
                    adjustHeightOfPage(pageNo);
                }
            });

            $(window).resize(function () {
                var currentPageNo = $(".cd-hero-slider li.selected .js-tm-page-content").data("page-no");

                setTimeout(function () {
                    adjustHeightOfPage(currentPageNo);
                }, 3000);

                if ($(window).width() > 800) {
                    uploadVideo();
                }
            });

            $('video').each(function () {
                if ($(this).is(":in-viewport")) {
                    $(this)[0].play();
                } else {
                    $(this)[0].pause();
                }
            });

            $('body').addClass('loaded');
            $('.tm-current-year').text(new Date().getFullYear());
        });
    </script>
</body>
</html>

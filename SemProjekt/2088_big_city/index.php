<!DOCTYPE html>
<html>

<?php
$filePath = "Header a footer/header.php";
if (!include($filePath)) {
    echo "Failed to include $filePath";
}

require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/CommentRepository.php';

$config = require __DIR__ . '/config.php';
$repository = null;
$comments = [];
$editComment = null;
$flashMessage = '';
$errorMessage = '';

try {
    $database = new Database($config['db']);
    $repository = new CommentRepository($database->getConnection());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $author = trim($_POST['author'] ?? '');
        $question = trim($_POST['question'] ?? '');
        $answer = trim($_POST['answer'] ?? '');
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

        if (in_array($action, ['create', 'update'], true)) {
            if ($author === '' || $question === '' || $answer === '') {
                $errorMessage = 'Please fill in author, question and answer.';
            } else {
                if ($action === 'create') {
                    $repository->create($author, $question, $answer);
                    $flashMessage = 'Comment was created.';
                }

                if ($action === 'update' && $id > 0) {
                    $repository->update($id, $author, $question, $answer);
                    $flashMessage = 'Comment was updated.';
                }
            }
        }

        if ($action === 'delete' && $id > 0) {
            $repository->delete($id);
            $flashMessage = 'Comment was deleted.';
        }
    }

    if ($repository !== null) {
        $comments = $repository->getAll();
    }

    $editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
    if ($repository !== null && $editId > 0) {
        $editComment = $repository->findById($editId);
    }
} catch (Throwable $exception) {
    $errorMessage = 'Database error: ' . $exception->getMessage();
}
?>


    <body>

        <div class="cd-bg-video-wrapper" data-video="video/bangkok-city">
            <!-- video element will be loaded using jQuery -->
        </div> <!-- .cd-bg-video-wrapper -->
        
        <!-- Content -->
        <div class="cd-hero">

            <!-- Navigation -->        
            <div class="cd-slider-nav">
                <div class="container">
                    <nav class="navbar">
                        <div class="tm-navbar-bg">                            
                            <a class="navbar-brand text-uppercase" href="#">Big City</a>
                            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#tmNavbar">
                                &#9776;
                            </button>
                            <div class="collapse navbar-toggleable-md text-xs-center text-uppercase tm-navbar" id="tmNavbar">
                                <ul class="nav navbar-nav">
                                    <li class="nav-item active selected">
                                        <a class="nav-link" href="#0" data-no="1">Home <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#0" data-no="2">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#0" data-no="3">Gallery</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#0" data-no="4">Contact</a>
                                    </li>
                                </ul>
                            </div>                        
                        </div>
                    </nav>
                </div>                
            </div> 

            <ul class="cd-hero-slider">  <!-- autoplay -->

                <!-- Page 1 Home -->
                <li class="selected">
                    <div class="cd-full-width">
                        <div class="container js-tm-page-content tm-page-1 tm-section-margin-t-small" data-page-no="1">
                            <div class="row">                            
                                <div class="col-xs-12">
                                    <div class="tm-home-container-outer">
                                        <div class="tm-home-container">
                                            <div class="tm-home-title-container">
                                                <h2 class="tm-text-title text-xs-center tm-home-title">Welcome to BIG city!</h2>    
                                            </div>
                                            <div class="tm-home-description-container tm-bg-dark-blue">
                                                <div class="text-xs-left tm-textbox">                                            
                                                    <p class="tm-text tm-home-description">Big City HTML CSS Template is provided by Tooplate website. Feel free to use this layout for your web projects. Please tell your friends about Tooplate. Thank you. Video BG credit: <a href="https://youtu.be/OeBdM7tykUg" target="_blank">Bangkok Sunset</a></p>
                                                    <p class="tm-text tm-home-description">Quisque mattis pellentesque diam eu vestibulum. Pellentesque augue urna, ultrices sit amet luctus eget, ultricies sit amet ipsum. Nulla sem nisi, commodo sed auctor sed, euismod nec dui. Morbi vitae enim id massa sodales tincidunt a et mi.</p>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="tm-home-container-bg"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .cd-full-width -->
                </li>
                
                <!-- Page 2 About -->
                <li>
                    <div class="cd-full-width">
                        <div class="container js-tm-page-content tm-section-margin-t" data-page-no="2">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tm-flex">
                                        <div class="col-lg-6 tm-white-header-container-outer tm-margin-b tm-2-col-left">
                                            <div class="tm-bg-white tm-white-header-container">
                                                <h2 class="tm-text-title tm-text-title-small">Donec dictum aliquam</h2>
                                            </div>
                                            <div class="tm-bg-dark-blue text-xs-left tm-textbox tm-textbox-padding tm-white-header-body tm-white-border tm-2-col-equal-height">
                                                <p class="tm-text">Nulla scelerisque vitae augue non viverra. Mauris nibh eros, gravida id rutrum eu, placerat quis enim. Ut massa mi, convallis eget pharetra eget, laoreet sit amet orci. Sed tincidunt nisi ut lectus pellentesque viverra. Aliquam condimentum lacinia.</p>                                            
                                            </div>    
                                        </div>
                                        <div class="col-lg-6 tm-white-header-container-outer tm-margin-b tm-2-col-right">
                                            <div class="tm-bg-white tm-white-header-container">
                                                <h2 class="tm-text-title tm-text-title-small">Vivamus quis lacinia</h2>
                                            </div>
                                            <div class="tm-bg-dark-blue text-xs-left tm-textbox tm-textbox-padding tm-white-header-body tm-white-border tm-2-col-equal-height">
                                                <p class="tm-text">Integer posuere massa ipsum, ac pharetra metus dapibus vel. Duis aliquet ac lacus quis efficitur. Morbi in vulputate sapien. Sed nec mi fringilla metus vehicula porttitor. Donec sit amet arcu quis massa mollis condimentum tempor eleifend enim.</p>                                            
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tm-flex">
                                        <div class="col-lg-6 tm-margin-b tm-2-col-left">
                                            <div class="tm-bg-white tm-textbox-padding tm-height-100">
                                                <h2 class="tm-text-title tm-text-title-small tm-header-margin-b">Proin fringilla felis quam</h2>
                                                <p class="tm-text">Ut massa mi, convallis eget pharetra eget, laoreet sit amet orci. Sed tincidunt nisi ut lectus pellentesque viverra. Aliquam condimentum lacinia.</p>    
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 tm-margin-b tm-2-col-right">
                                            <div class="tm-bg-white tm-textbox-padding tm-height-100">
                                                <h2 class="tm-text-title tm-text-title-small tm-header-margin-b">Sed rhoncus egestas</h2>
                                                <p class="tm-text">Pellentesque augue urna, ultrices sit amet luctus eget, ultricies sit amet ipsum. Nulla sem nisi, commodo sed auctor sed, euismod nec dui.</p>
                                            </div>
                                        </div>  
                                    </div>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tm-flex">
                                        <div class="col-lg-4 tm-margin-b">
                                            <div class="tm-bg-brown tm-white-border tm-textbox-padding tm-height-100">                                
                                                <p class="tm-text">Aliquam facilisis ut purus non ultricies. Mauris a auctor turpis. Ut in consequat quam. Integer ex dui, eleifend non mi val, eleifend varius orci.</p>
                                            </div>    
                                        </div>
                                        <div class="col-lg-4 tm-margin-b">
                                            <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding tm-height-100">
                                                <p class="tm-text">Mauris tempor, massa quis viverra suscipit, sapien ipsum condimentum nulla, sed faucibus tellus libero eget dolor. In ornare posuere.</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 tm-margin-b">
                                            <div class="tm-bg-dark-brown tm-white-border tm-textbox-padding tm-height-100">
                                                <p class="tm-text">Donec placerat eget enim vel fringilla. Vivamus nibh nisl, viverra vel nisl eget, feugiat fringilla quam. Naecenas sodales, magna sed.</p>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tm-flex">
                                        <div class="col-lg-4 tm-sm-margin-b">
                                            <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding tm-height-100">
                                                <p class="tm-text">Quisque mattis pellentesque. Etiam rutrum neque at diam imperdiet, efficitur tincidunt turpis dignissim. Cras placerat placerat tempor.</p>
                                            </div>    
                                        </div>
                                        <div class="col-lg-4 tm-sm-margin-b">
                                            <div class="tm-bg-white tm-white-border tm-textbox-padding tm-height-100">
                                                <p class="tm-text">Sed nec mi fringilla metus vehicula porttitor. Donec sit amet arcu quis massa mollis condimentum tempor eleifend enim.</p>
                                            </div>    
                                        </div>
                                        <div class="col-lg-4 tm-sm-margin-b">
                                            <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding tm-height-100">
                                                <p class="tm-text">In pellentesque, ipsum vitae dapibus ultrices, dui nunc fringilla enim, sit amet placerat nulla felis et nisl.</p>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>                                
                            </div>
                        </div>                                                
                    </div> <!-- .cd-full-width -->

                </li>
               
                <!-- Page 3 Gallery -->
                <li>
                    <div class="cd-full-width">                        
                        <div class="container js-tm-page-content tm-section-margin-t" data-page-no="3">
                            <div class="row tm-margin-b">
                                <div class="col-xs-12">
                                    <div class="tm-img-gallery-container">

                                        <div class="tm-img-gallery gallery-first">
                                        <!-- Gallery Two pop up connected with JS code below -->

                                            <div class="tm-gallery-title-container">
                                                <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding tm-margin-b">                                    
                                                    <h2 class="tm-text-title tm-gallery-title tm-margin-b-0"><span class="tm-white">First Gallery</span></h2>                                        
                                                </div>
                                                <div class="tm-bg-white-half"></div>
                                            </div>

                                            <div class="grid-item">
                                                <a href="img/tm-img-01.jpg">                                                
                                                    <img src="img/tm-img-01-tn.jpg" alt="Image" class="img-fluid tm-img">                                              
                                                </a>
                                            </div>
                                            <div class="grid-item">
                                                <a href="img/tm-img-02.jpg">                                                
                                                    <img src="img/tm-img-02-tn.jpg" alt="Image" class="img-fluid tm-img">                                                
                                                </a>
                                            </div>
                                            <div class="grid-item">
                                                <a href="img/tm-img-03.jpg">                                                
                                                    <img src="img/tm-img-03-tn.jpg" alt="Image" class="img-fluid tm-img">                                                
                                                </a>
                                            </div>
                                            <div class="grid-item">
                                                <a href="img/tm-img-04.jpg">                                                
                                                    <img src="img/tm-img-04-tn.jpg" alt="Image" class="img-fluid tm-img">                                                
                                                </a>
                                            </div>
                                            <div class="grid-item">
                                                <a href="img/tm-img-05.jpg">                                                
                                                    <img src="img/tm-img-05-tn.jpg" alt="Image" class="img-fluid tm-img">                                                
                                                </a>
                                            </div>
                                            <div class="grid-item">
                                                <a href="img/tm-img-06.jpg">                                                
                                                    <img src="img/tm-img-06-tn.jpg" alt="Image" class="img-fluid tm-img">                                                
                                                </a>
                                            </div>                                                                           
                                        </div>                                         
                                    </div> <!-- .tm-img-gallery-container -->  

                                </div>
                            </div> <!-- row -->
                            <div class="row">                                
                                <div class="col-xs-12">
                                    <div class="tm-img-gallery-container">

                                        <div class="tm-img-gallery gallery-second">
                                        <!-- Gallery Two pop up connected with JS code below -->

                                            <div class="tm-gallery-title-container">
                                                <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding tm-margin-b">                                    
                                                    <h2 class="tm-text-title tm-gallery-title tm-margin-b-0"><span class="tm-white">Second Gallery</span></h2>                                        
                                                </div>
                                                <div class="tm-bg-white-half"></div>
                                            </div>

                                            <div class="grid-item grid-item-big">
                                                <a href="img/tm-img-07.jpg">                                                
                                                    <img src="img/tm-img-07-tn.jpg" alt="Image" class="img-fluid tm-img-no-border">                                              
                                                </a>
                                            </div>
                                            <div class="grid-item grid-item-big">
                                                <a href="img/tm-img-08.jpg">                                                
                                                    <img src="img/tm-img-08-tn.jpg" alt="Image" class="img-fluid tm-img-no-border">                                                
                                                </a>
                                            </div>
                                            <div class="grid-item grid-item-square">
                                                <a href="img/tm-img-09.jpg">                                                
                                                    <img src="img/tm-img-09-tn.jpg" alt="Image" class="img-fluid tm-img-no-border">                                                
                                                </a>
                                            </div>
                                            <div class="grid-item grid-item-square">
                                                <a href="img/tm-img-10.jpg">                                                
                                                    <img src="img/tm-img-10-tn.jpg" alt="Image" class="img-fluid tm-img-no-border">                                                
                                                </a>
                                            </div>
                                            <div class="grid-item grid-item-square">
                                                <a href="img/tm-img-11.jpg">                                                
                                                    <img src="img/tm-img-11-tn.jpg" alt="Image" class="img-fluid tm-img-no-border">                                                
                                                </a>
                                            </div>
                                            <div class="grid-item grid-item-square">
                                                <a href="img/tm-img-12.jpg">                                                
                                                    <img src="img/tm-img-12-tn.jpg" alt="Image" class="img-fluid tm-img-no-border">                                                
                                                </a>
                                            </div>                                                                            
                                        </div>                                         
                                    </div> <!-- .tm-img-gallery-container -->                                     
                                </div>  <!-- col-xs-12 -->                          
                            </div> <!-- row --> 
                        </div> <!-- .container -->
                                                    
                    </div> <!-- .cd-full-width -->
                    
                </li>
                
                <!-- Page 4 Contact -->
                <li>
                    <div class="cd-full-width">
                        <div class="container js-tm-page-content tm-section-margin-t-small" data-page-no="4">                            
                            <div class="tm-contact-page">
                                <div class="row tm-margin-b">
                                    <div class="col-xs-12">
                                        <div class="tm-bg-white tm-textbox-padding">
                                            <h2 class="tm-text-title tm-margin-b-0">Contact Us</h2>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="tm-flex tm-contact-container tm-bg-dark-blue">                                
                                            <div class="text-xs-left tm-textbox tm-2-col-textbox-2 tm-textbox-padding tm-textbox-padding-contact">
                                                <p class="tm-text">Phasellus lacus mi, porta vel sodales nec, faucibus non eros. Nulla at quam vel risus laoreet tincidunt in in sem.</p>                                                                                                                                                 
                                                <p class="tm-text">88-99 Etiam mauris erat,<br>Vestibulum eu augue nec, 10890<br>Nam consequat<br></p>
                                                <p class="tm-text">Tel: 010-020-0340<br>Fax: 090-080-0980</p>
                                            </div>

                                            <div class="text-xs-left tm-textbox tm-2-col-textbox-2 tm-textbox-padding tm-textbox-padding-contact">
                                                <?php if ($flashMessage !== ''): ?>
                                                    <p class="tm-text" style="color:#80ff80; margin-bottom:15px;"><?php echo htmlspecialchars($flashMessage, ENT_QUOTES, 'UTF-8'); ?></p>
                                                <?php endif; ?>
                                                <?php if ($errorMessage !== ''): ?>
                                                    <p class="tm-text" style="color:#ff9898; margin-bottom:15px;"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p>
                                                <?php endif; ?>

                                                <form action="index.php#0" method="post" class="tm-contact-form">
                                                    <input type="hidden" name="action" value="<?php echo $editComment ? 'update' : 'create'; ?>">
                                                    <?php if ($editComment): ?>
                                                        <input type="hidden" name="id" value="<?php echo (int) $editComment['id']; ?>">
                                                    <?php endif; ?>
                                                    <div class="form-group">
                                                        <input type="text" id="author" name="author" class="form-control" placeholder="Author" value="<?php echo htmlspecialchars($editComment['author'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required/>
                                                    </div>                                                                                                            
                                                    <div class="form-group">
                                                        <textarea id="question" name="question" class="form-control" rows="3" placeholder="Question" required><?php echo htmlspecialchars($editComment['question'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </div>                                                    
                                                    <div class="form-group">
                                                        <textarea id="answer" name="answer" class="form-control" rows="4" placeholder="Answer" required><?php echo htmlspecialchars($editComment['answer'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </div>
                                                    <button type="submit" class="tm-submit-btn"><?php echo $editComment ? 'Update' : 'Create'; ?></button>
                                                    <?php if ($editComment): ?>
                                                        <a href="index.php#0" class="tm-submit-btn" style="display:inline-block;text-decoration:none;margin-left:8px;">Cancel</a>
                                                    <?php endif; ?>
                                                </form> 

                                                <hr>
                                                <h3 class="tm-text-title tm-text-title-small">Q&A Comments</h3>
                                                <?php if (count($comments) === 0): ?>
                                                    <p class="tm-text">No comments yet.</p>
                                                <?php else: ?>
                                                    <?php foreach ($comments as $comment): ?>
                                                        <div style="border:1px solid #4d648d; padding:12px; margin-bottom:10px;">
                                                            <p class="tm-text" style="margin:0 0 8px;"><strong><?php echo htmlspecialchars($comment['author'], ENT_QUOTES, 'UTF-8'); ?></strong> <small>(<?php echo htmlspecialchars($comment['created_at'], ENT_QUOTES, 'UTF-8'); ?>)</small></p>
                                                            <p class="tm-text" style="margin:0 0 6px;"><strong>Q:</strong> <?php echo nl2br(htmlspecialchars($comment['question'], ENT_QUOTES, 'UTF-8')); ?></p>
                                                            <p class="tm-text" style="margin:0 0 10px;"><strong>A:</strong> <?php echo nl2br(htmlspecialchars($comment['answer'], ENT_QUOTES, 'UTF-8')); ?></p>
                                                            <a href="index.php?edit=<?php echo (int) $comment['id']; ?>#0" class="tm-submit-btn" style="display:inline-block;text-decoration:none;">Edit</a>
                                                            <form action="index.php#0" method="post" style="display:inline-block; margin-left:8px;">
                                                                <input type="hidden" name="action" value="delete">
                                                                <input type="hidden" name="id" value="<?php echo (int) $comment['id']; ?>">
                                                                <button type="submit" class="tm-submit-btn" onclick="return confirm('Delete this comment?');">Delete</button>
                                                            </form>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div> <!-- .cd-full-width -->
                </li>
            </ul> <!-- .cd-hero-slider -->
            <?php
            $filePath = "Header a footer/footer.php";
            if (!include($filePath)) {
                echo "Failed to include $filePath";
            }
            ?>

        </div> <!-- .cd-hero -->        

        <!-- Preloader, https://ihatetomatoes.net/create-custom-preloading-screen/ -->
        <div id="loader-wrapper">            
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        
        <!-- load JS files -->
        <script src="js/jquery-1.11.3.min.js"></script>         <!-- jQuery (https://jquery.com/download/) -->
        <script src="js/tether.min.js"></script>                <!-- http://tether.io/ -->
        <script src="js/isInViewport.min.js"></script>          <!-- isInViewport js (https://github.com/zeusdeux/isInViewport) -->
        <script src="js/bootstrap.min.js"></script>             <!-- Bootstrap js (v4-alpha.getbootstrap.com/) -->
        <script src="js/hero-slider-main.js"></script>          <!-- Hero slider (https://codyhouse.co/gem/hero-slider/) -->
        <script src="js/jquery.magnific-popup.min.js"></script> <!-- Magnific popup (http://dimsemenov.com/plugins/magnific-popup/) -->
        
        <script>

            function adjustHeightOfPage(pageNo) {

                var offset = 80;
                var pageContentHeight = $(".cd-hero-slider li:nth-of-type(" + pageNo + ") .js-tm-page-content").height();

                if($(window).width() >= 992) { offset = 120; }
                else if($(window).width() < 480) { offset = 40; }
               
                // Get the page height
                var totalPageHeight = 335 + $('.cd-slider-nav').height()
                                        + pageContentHeight + offset
                                        + $('.tm-footer').height();

                // Adjust layout based on page height and window height
                if(totalPageHeight > $(window).height()) 
                {
                    $('.cd-hero-slider').addClass('small-screen');
                    $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", totalPageHeight + "px");
                }
                else 
                {
                    $('.cd-hero-slider').removeClass('small-screen');
                    $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", "100%");
                }
            }

            function uploadVideo() {

                var videoWrapper = $('.cd-bg-video-wrapper');
                if( videoWrapper.is(':visible') ) {
                    // if visible - we are not on a mobile device 
                    var videoUrl = videoWrapper.data('video'),
                        
                    video = $('<video autoplay loop><source src="'+videoUrl+'.mp4" type="video/mp4" /></video>');
                    video.appendTo(videoWrapper);

                    // play video if first slide
                    if(videoWrapper.parent('.cd-bg-video.selected').length > 0) video.get(0).play();                 
                }
            }

            // Everything is loaded including images.            
            $(window).load(function(){

                adjustHeightOfPage(1); // Adjust page height

                // Background Video
                if($( window ).width() > 800) {
                    uploadVideo();
                }

                /* Gallery One pop up
                -----------------------------------------*/
                $('.gallery-first').magnificPopup({
                    delegate: 'a', // child items selector, by clicking on it popup will open
                    type: 'image',
                    gallery:{enabled:true}                
                });

                /* Gallery Two pop up
                -----------------------------------------*/
                $('.gallery-second').magnificPopup({
                    delegate: 'a', // child items selector, by clicking on it popup will open
                    type: 'image',
                    gallery:{enabled:true}                
                });
				
                /* Collapse menu after click 
                -----------------------------------------*/
                $('#tmNavbar a').click(function(){
                    $('#tmNavbar').collapse('hide');

                    adjustHeightOfPage($(this).data("no")); // Adjust page height       
                });

                /* Browser resized 
                -----------------------------------------*/
                $( window ).resize(function() {
                    var currentPageNo = $(".cd-hero-slider li.selected .js-tm-page-content").data("page-no");
                    
                    // wait 3 seconds
                    setTimeout(function() {
                        adjustHeightOfPage( currentPageNo );
                    }, 3000);

                    if($( window ).width() > 800) {
                       uploadVideo();
                    }
                    
                });

                // Play video only when visible
                // https://stackoverflow.com/questions/21163756/html5-and-javascript-to-play-videos-only-when-visible
                $('video').each(function(){
                    if ($(this).is(":in-viewport")) {
                        $(this)[0].play();
                    } else {
                        $(this)[0].pause();
                    }
                })
        
                // Remove preloader (https://ihatetomatoes.net/create-custom-preloading-screen/)
                $('body').addClass('loaded');
                $('.tm-current-year').text(new Date().getFullYear());
                           
            });

        </script>            

</body>
</html>
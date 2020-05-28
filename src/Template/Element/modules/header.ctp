<header class="navbar navbar-dark fixed-top navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="<?= $this->request->webroot ?>">
            <img src="<?= $this->request->webroot ?>images/logo.svg" width="50" height="auto" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse justify-content-md-end navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav">
                <?php if ($home) : ?>
                    <?php if (count($images) > 0) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#images"><strong>HÌNH ẢNH</strong></a>
                        </li>
                    <?php endif; ?>
                    <?php if (count($news) > 0) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#news"><strong>TIN TỨC</strong></a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#project-overview"><strong>TỔNG QUAN</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#area-links"><strong>LIÊN KẾT VÙNG</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#quality"><strong>TIỆN ÍCH</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#featured-products"><strong>SẢN PHẨM</strong></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>
<div class="page-visual-slider">
    <div id="page-visual">
        <div class="single-visual" order="1">

        </div>
        <div class="single-visual" order="2">

        </div>
        <div class="single-visual" order="3">

        </div>
    </div>
    <div class="visual-text-container">
        <div class="container position-relative w-100 h-100">
            <div class="visual-text">
                <strong class="content" style="text-transform: uppercase;">Cặp Nền Góc Đường Số 7 [195m2] Chỉ 1,7 Tỷ</strong>
                <div>
                    <span class="cta cta-golden open-popup"><strong>ĐĂNG KÝ</strong></span>
                </div>
            </div>
        </div>
    </div>
</div>

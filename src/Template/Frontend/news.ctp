<section class="mt-3 mb-3 page news d-none" id="reading">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1>
                    <?= $page_content->title ?>
                </h1>
                <div class="page-content">
                    <?= $page_content->content ?>
                </div>
            </div>
            <div class="col-md-3">
                <h2>Các tin khác</h2>
                <?php foreach ($news_related as $single_news_related) : ?>
                    <a style="display: block;" href="<?= $this->request->webroot ?>tin-tuc/<?= $single_news_related-> id?>"><?= $single_news_related-> title ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

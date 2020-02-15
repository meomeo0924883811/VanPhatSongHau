<div class="block news-block" id="news">
    <div class="container">
        <h1>Tin tức mới nhất</h1>
        <div class="row align-items-center justify-content-center" id="news-list">
            <?php foreach ($news as $single_news) : ?>
                <a href="<?= $this->request->webroot.'tin-tuc/'.$single_news->id ?>" class="single-news">
                    <img class="img-fluid" src="<?= $this->request->webroot . $single_news->thumbnail ?>"
                         alt=""/>
                    <b><?= $single_news->title ?></b>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

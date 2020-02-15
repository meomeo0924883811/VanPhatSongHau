<div class="block images-block" id="images">
    <div class="container">
        <h1>Hình ảnh mới nhất</h1>
        <div class="row align-items-center justify-content-center" id="newest-image">
            <?php foreach ($images as $image) : ?>
                <div class="newest-image">
                    <img class="img-fluid open-image-popup" src="<?= $this->request->webroot . $image->path ?>"
                         alt=""/>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


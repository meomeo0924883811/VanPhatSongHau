<section class="page home">
    <?php
        echo $this->element ('modules/home/video');
        echo $this->element ('modules/home/diemcong');
        echo $this->element ('modules/home/tongquanduan');
        echo $this->element ('modules/home/nhanthongtinduanvauudai');
        echo $this->element ('modules/home/chatluongkietxuat');
        echo $this->element ('modules/home/sanphamnoibat');
        echo $this->element ('modules/home/chinhsachthanhtoan');
        if (count($news) != 0) echo $this->element ('modules/home/tintuc');
        if (count($images) != 0) echo $this->element ('modules/home/hinhanhmoinhat');
        echo $this->element ('modules/home/9yeuto');
    ?>
</section>

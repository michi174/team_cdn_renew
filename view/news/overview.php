<?php 
use controller\news\News;

foreach ($this->allnews as $news): ?>
<div class="section-body" id="news-overview-nwrapper">

<h4><a href="<?=$this->createUrlString("news", "detailview")?>&<?= News::ID_NAME ?>=<?=$news['id']?>"><?= utf8_encode($news['title']); ?></a></h4>
<div class="additional-info">verfasst von <?= $news['autor']; ?> am <?= date("d.m.Y, H:i", $news['createTimestamp']); ?></div><br>
    <div><?= nl2br(utf8_encode($news['text']))?></div>
    <?php if($news['hasHeadline'] === true):?>
        <div class="tips_topic_readmore right">
            <a href="<?=$this->createUrlString("news", "detailview")?>&<?= News::ID_NAME ?>=<?=$news['id']?>">Weiterlesen </a>
        </div>
        <div class="clearing"></div>
    <?php endif;?>
</div>
<br><br>
<?php endforeach; ?>

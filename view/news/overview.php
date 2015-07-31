<?php 
use controller\news\News;

foreach ($this->allnews as $news): ?>
<div class="section-body" id="news-overview-nwrapper">

<h4><a href="<?=$this->createUrlString("news", "detailview")?>&<?= News::ID_NAME ?>=<?=$news['id']?>"><?= utf8_encode($news['title']); ?></a></h4>
<div class="additional-info">verfasst von <?= $news['autor']; ?> am <?= date("d.m.Y, H:i", $news['createTimestamp']); ?></div><br>
    <div>
        <div id="news-pic" class="left" style="display:table-cell"><img src="template/default/gfx/other/picture.png" style="max-height:100px; max-width:100px; margin-top:4px;"></div>
        <div id="news-text" class="left" style="max-width:80%; display:table-cell; margin-left:20px;"><?= nl2br(utf8_encode($news['text']))?></div>
        <div class="clearing"></div>
    </div>
    <?php if($news['hasHeadline'] === true):?>
        <div class="tips_topic_readmore right">
            <a href="<?=$this->createUrlString("news", "detailview")?>&<?= News::ID_NAME ?>=<?=$news['id']?>">Weiterlesen </a>
        </div>
        <div class="clearing"></div>
    <?php endif;?>
</div>
<br>
<?php endforeach; ?>

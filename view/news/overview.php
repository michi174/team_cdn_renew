
<?php foreach ($this->allnews as $news): ?>
<div class="section-body" id="news-overview-nwrapper">
<h4><?= $news['title']; ?></h4>
<div class="additional-info">verfasst von <?= $news['autor']; ?> am <?= date("d.m.Y, H:i", $news['createTimestamp']); ?></div><br>
    <?= nl2br(utf8_encode($news['text']))?>
    <?php if($news['hasHeadline'] === true):?>
    <br><div class="tips_topic_readmore"><a href="?site=tips&action=detailview&id={TOPIC.ID}">Weiterlesen </a></div>
    <?php endif;?>
</div><br><br>
<?php endforeach; ?>

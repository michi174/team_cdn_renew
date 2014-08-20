<?php 
use wsc\application\Application;
use controller\news\News;

foreach ($this->allnews as $news): ?>
<div class="section-body" id="news-overview-nwrapper">
<h4><a href="?<?= Application::getInstance()->load("config")->get("ControllerName")?>=news&<?= Application::getInstance()->load("config")->get("ActionName")?>=detailview&<?= News::ID_NAME ?>=<?=$news['id']?>"><?= $news['title']; ?></a></h4>
<div class="additional-info">verfasst von <?= $news['autor']; ?> am <?= date("d.m.Y, H:i", $news['createTimestamp']); ?></div><br>
    <?= nl2br(utf8_encode($news['text']))?>
    <?php if($news['hasHeadline'] === true):?>
    <br><div class="tips_topic_readmore"><a href="?<?= Application::getInstance()->load("config")->get("ControllerName")?>=news&<?= Application::getInstance()->load("config")->get("ActionName")?>=detailview&<?= News::ID_NAME ?>=<?=$news['id']?>">Weiterlesen </a></div>
    <?php endif;?>
</div><br><br>
<?php endforeach; ?>

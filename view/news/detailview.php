<div class="section-body" id="news-detailview-nwrapper" style="position:relative">
    <a class="button-cms edit-cms " id="edit-cms" href="<?=$this->createUrlString("admintopics", "update")?>&id=<?=$this->id?>">Bearbeiten</a>
    <a class="button-cms delete-cms confirm-yes-no" id="delete-cms-<?=$this->id?>" href="<?=$this->createUrlString("admintopics", "delete")?>&id=<?=$this->id?>&next=<?=urlencode($_SERVER['HTTP_REFERER'])?>&autoredirect" title="Datensatz l&ouml;schen" message="Soll der Datensatz samt dazugeh&ouml;rigen Beitr&auml;gen wirklich entfernt werden?">Entfernen</a>
    <h2 class="headline"><?=utf8_encode($this->title)?></h2>
    
    <div class="subline">geschrieben von <?=$this->autor?> am <?= date('d.m.Y \u\m H:i', $this->date); ?></div>
    <div>
        <div id="news-pic" class="left" style="display:table-cell"><img src="template/default/gfx/other/picture.png" style="max-height:100px; max-width:100px; margin-top:4px;"></div>
        <div class="left" style="font-weight:bold; -webkit-font-smoothing: antialiased; max-width:80%; margin-left:15px;"><?=nl2br(utf8_encode($this->headline))?></div>
        <div class="clearing"></div>
    </div>
    <div class="step_line"></div>
	<?=nl2br(utf8_encode($this->text))?>
    <br>
    <div class="post-bar">
    	<ul>
    		<li class="facebook"><a href="#">Facebook</a></li>
    		<li class="twitter"><a href="#">Twitter</a></li>
    		<li class="google"><a href="#">Google+</a></li>
    		<li class="kommentare"><a href="#">0 Kommentare &raquo;</a></li>
    	</ul>
    </div>
</div>
<div class="section-body" id="news-detailview-nwrapper">
    <h2 class="headline"><?=$this->title?></h2>
    <div style="border-bottom:4px solid #c02424;"></div>
    
    <div class="subline">geschrieben von <?=$this->autor?> am <?= date('d.m.Y \u\m H:i', $this->date); ?></div>
    <br>
    <div style="font-weight:bold"><?=nl2br(utf8_encode($this->headline))?></div>
    <div style="border-bottom:1px solid #efefef; margin: 15px 0 15px 0"></div>
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

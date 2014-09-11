<?=$this->notify ?>
<?php if($this->valid !== true): ?>
	<?=$this->form()->openTag($this->topic); ?>
    <div id="add-topic-wrapper" class="default-form">
        <div class="section-title s-t-top addtopic">
            <img src="template/default/gfx/header/icons/add_topic.png" style="vertical-align:middle;">
            <?=$this->title?>
        </div>
        <div class="section-body addtopic"> 
            <div class="left">
                <?= $this->formRow($this->topic->get("board")) ?><br>
            </div>
            <div class="right">
                <?= $this->formRow($this->topic->get("autor")) ?><br>
            </div>
            <div class="clearing"></div>
            <?= $this->formRow($this->topic->get("title")) ?><br>
            <?= $this->formRow($this->topic->get("text")) ?><br>
            <?= $this->formCheckbox($this->topic->get("replys")) ?>
            <?= $this->formLabel($this->topic->get("replys"))?><br>
            <?= $this->formCheckbox($this->topic->get("important")) ?>
            <?= $this->formLabel($this->topic->get("important"))?><br>
        </div>
        <div class="section-title s-t-bottom addtopic" style="text-align:center">
            <?= $this->formRow($this->topic->get("submitform")) ?><br>
        </div>
    </div>
    <?=$this->form()->closeTag()?>
<?php endif ?>
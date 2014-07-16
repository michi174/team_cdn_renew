<?=$this->notify ?>
<?php if($this->valid !== true): ?>
	<?=$this->form()->openTag($this->board); ?>
    <div id="add-menu-item-wrapper" class="default-form">
        <div class="section-title s-t-top additem">
            <img src="template/default/gfx/header/icons/add_item.png" style="vertical-align:middle;">
            Neues Board erstellen
        </div>
        <div class="section-body additem"> 
            <div class="left">
                <?= $this->formRow($this->board->get("name")) ?><br>
                <?= $this->formRow($this->board->get("description")) ?><br>
            </div>
            <div class="right">
                <?= $this->formRow($this->board->get("area")) ?><br>
                <?= $this->formRow($this->board->get("parent")) ?><br>
                <?= $this->formCheckbox($this->board->get("allow_topics")) ?>
                <?= $this->formLabel($this->board->get("allow_topics"))?><br>
                <?= $this->formCheckbox($this->board->get("allow_subboards"))?>
                <?= $this->formLabel($this->board->get("allow_subboards"))?><br>
    
            </div>
            <div class="clearing"></div>
        </div>
        <div class="section-title s-t-bottom additem" style="text-align:center">
            <?= $this->formRow($this->board->get("addboard")) ?><br>
        </div>
    </div>
    <?=$this->form()->closeTag()?>
<?php endif ?>
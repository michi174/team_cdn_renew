<?= $this->notification; ?>
<?php if($this->valid !== true): ?>
<?=$this->form()->openTag($this->menuitem); ?>
    <div id="add-menu-item-wrapper" class="default-form">
        <div class="section-title s-t-top additem">
        	<img src="template/default/gfx/header/icons/add_item.png" style="vertical-align:middle;">
        	Neues Men&uuml;element erstellen
        </div>
        <div class="section-body additem"> 
            <div class="left">
               	<?=$this->formRow($this->menuitem->get("pname"))?><br>
                <?=$this->formRow($this->menuitem->get("disp_name"))?><br>
                <?=$this->formLabel($this->menuitem->get("parent"))?><br>
                <?=$this->formSelect($this->menuitem->get("parent"))?>
            </div>
            <div class="right">
                <?=$this->formRow($this->menuitem->get("style"))?><br>
                <?=$this->formRow($this->menuitem->get("sort"))?><br>
                <?=$this->formRow($this->menuitem->get("action"))?><br>
            </div>
            <div class="clearing"></div>
        </div>
        <div class="section-title s-t-bottom additem" style="text-align:center">
            <?=$this->formRow($this->menuitem->get("additem"))?>
        </div>
    </div>
<?=$this->form()->closeTag() ?>
<?php endif ?>
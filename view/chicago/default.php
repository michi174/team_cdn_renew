<style>
.cube
{
	height:100px; 
	width:100px; 
	border:1px solid #ccc;
	margin-left:10px;
	display:table-cell;
	vertical-align:middle;
	text-align:center;
	cursor:pointer;
}
.cube-hover			{background-color:#EEE;}
.cube-hover-hold	{opacity:0.8}

.table
{
	display:table;
	border-collapse:separate;
	border-spacing:10px;
}
.row
{
	display: table-row;
}
.hold
{
	background-color:#9FFF00;
}

.roll
{
	height:20px;
	display:inline-block;
	padding: 3px 10px 3px 10px;
	margin-left:5px;
	border:1px solid #ccc;
	cursor:pointer;
	
}
.roll:hover
{
	background-color:#EEE;
}

.chicago
{
	width:98%;
}
.cell
{
	display:table-cell;
}

#results, #results-title	{display:none}
#gamefield, #gamefield-title	{display:none}

</style>


<h4 id="settings-title">Einstellungen</h4>
<div class="section-body chicago" id="settings">
	Anzahl Spieler:&nbsp;<input type="text" id="anz_player" style="width:30px"><input type="button" id="start-game" value="Los!">
</div>
<br><h4 id="gamefield-title">Das Spielfeld</h4>
<div class="section-body chicago" id="gamefield">
    <div class="table">
        <div class="row">
            <div id="cube-1" class="cube">W&uuml;rfel 1</div>
            <div id="cube-2" class="cube">W&uuml;rfel 2</div>
            <div id="cube-3" class="cube">W&uuml;rfel 3</div>
        </div>
        <br>
        <div class="row">
        	<div style="display:table-cell">Akt. Spieler:</div>
            <div style="display:table-cell" id="player">Spieler</div>
        </div>  
        <div class="row">
        	<div style="display:table-cell">Anzahl würfe:</div>
            <div style="display:table-cell" id="anz_rolls">0</div>
        </div>
        <div class="row">
        	<div style="display:table-cell">Punkte:</div>
            <div style="display:table-cell" id="act-points">0</div>
        </div>        
    </div>
    <div class="table">
    	<div class="row">
        	<div style="display:table-cell" id="info">&nbsp;</div>
        </div>
    </div>
    <input type="hidden" id="cval-1" cube-id="cube-1" value="6">
    <input type="hidden" id="cval-2" cube-id="cube-2" value="0">
    <input type="hidden" id="cval-3" cube-id="cube-3" value="0">
    
    <div class="roll" id="roll">
        W&uuml;rfeln
    </div>
    <div class="roll" id="next-player">
        Nächster Spieler
    </div>
    <div class="roll" id="new-round">
        Nächste Runde
    </div>

</div>
<br><h4 id="results-title">Ergebnisse</h4>
<div class="section-body chicago" id="results">
	<div class="table" id="result-table">
    	<div class="row">
        	<div class="cell" style="width:200px;">Spieler</div>
            <div class="cell" style="width:200px;">Punkte (aktuelle Runde)</div>
            <div class="cell" style="width:100px;">Bierdeckel</div>
        </div>
    </div>
</div>
$(document).ready(function(){
    //jQuery Code
	
	//Chicago
	var rolls			= 0;
	var max_rolls		= 3;
	var last_rolls		= 0;
	var players			= [];
	var active_player	= 0;
	
	$('#start-game').click(function(){
		num_players	= $('#anz_player').val();	
		
		for(i=0; i<num_players; i++)
		{
			players[i]			= new Array();
			players[i]["name"]		= "Spieler " +(i+1);	//Punkte in aktueller Runde
			players[i]["points"]		= 0;			//Anzahl Punkte
			players[i]["bierdeckel"]	= 0;			//Anzahl Punkte
			players[i]["id"]		= i;			//Eindeutige Kennung des Spielers
			players[i]["earned_bd"]		= false;		//hat er den zustehenden Bierdeckel bereits bekommen?
			
			$('#result-table').append("<div class=\"row\"><div class=\"cell\">"+players[i]["name"]+":</div><div class=\"cell\"><span id=\"points-p"+i+"\">"+players[i]["points"]+"</span> Punkte</div><div class=\"cell\"><span id=\"cards-p"+i+"\">"+players[i]["bierdeckel"]+"</span> Bierdeckel</div></div>");
		}
		active_player	= players[0];
		$('#settings, #settings-title').hide();
		$('#gamefield, #gamefield-title').show();
		$('#results, #results-title').show();
		$('#player').text(active_player["name"]);
	});
	
	//W�rfel fixieren
	$('.cube').click(function(){
		
		cubeid	= $(this).attr('id');
		
		if($(this).hasClass("hold") == false)
		{
			if(rolls > 0)
			{
				$(this).addClass("hold");
			}
		}
		else
		{
			$(this).removeClass("hold");
			$('input[cube-id='+cubeid+']').val(0);
		}
	});	
	
	//Hover
	$('.cube').hover(function(){
        if($(this).hasClass("hold") == false)
		{
			$(this).addClass("cube-hover");
		}
		else
		{
			$(this).addClass("cube-hover-hold");
		}
    }, function(){
			$(this).removeClass("cube-hover");
			$(this).removeClass("cube-hover-hold");
	});
	
	//W�rfeln
	$('#roll').click(function(){
		
		$unlocked_cubes	= $('.cube').not('.hold');
		
		if(last_rolls != 0)
		{
			max_rolls	= last_rolls;
		}
		
		if(rolls < max_rolls)
		{
			rolls++;
			
			anz_cubes	= $unlocked_cubes.length;
			
			$unlocked_cubes.each(function(index, element) {
				
				r_zahl	= Math.floor(Math.random() * (6 - 1 + 1)) + 1;
				
				$(this).text(r_zahl);
				
			});
	
			$('#anz_rolls').text(rolls);
			$('#act-points').text(determinePoints());
			players[active_player["id"]]["points"]	= determinePoints();
			active_player = players[active_player["id"]];
			
			if(rolls+1 > max_rolls)
			{
				$('#points-p'+active_player["id"]).text(active_player["points"]);
				
				if(active_player["id"] + 1 > players.length-1)
				{
					assignBierdeckel();
				}
			}
		}
		else
		{
			$('#info').text("Du kannst nicht mehr als "+max_rolls+" mal w"+unescape("%FC")+"rfeln.");
		}
	});
	
	//Bierdeckel zuweisen
	function assignBierdeckel()
	{
		var bd_player;
		var min_points	= 0;
		
		for(var index in players)
		{
			if(min_points	== 0)
			{
				min_points	= players[index]["points"];
				bd_player	= index;
			}
			if(players[index]["points"] < min_points)
			{
				bd_player	= index;
			}
		}
		
		if((players[bd_player]["earned_bd"] == false) && (players[bd_player]["points"] > 0))
		{
			players[bd_player]["bierdeckel"]++;
			$('#cards-p'+bd_player).text(players[bd_player]["bierdeckel"]);
			players[bd_player]["earned_bd"] = true;
		}
	}
	
	function determinePoints()
	{
		$cubes		= $('.cube');
		only_fisch	= true;
		points		= 0;
	
		$cubes.each(function(){
			if($(this).text() == 1 || $(this).text() == 6)
			{
				only_fisch	= false;
			}
		});
	
		$cubes.each(function(){
			if(only_fisch == false)
			{
				if($(this).text() == 1)
				{
					points 	= points+100;
				}
				if($(this).text() == 6)
				{
					points	= points+60;
				}
			}
			else
			{
				points	= points+parseInt($(this).text());
			}
		});
		
		return points;
	}

	//Punkte der aktuellen Runde f�r alle Spieler zur�cksetzen. (Neue Runde)
	function resetPoints()
	{
		for(var index in players)
		{
			players[index]["points"]	= 0;
			players[index]["earned_bd"]	= false;
			$('#points-p'+index).text(0);
		}
	}
		
	//Wenn auf N�chster Spieler geklickt wird.
	$('#next-player').click(function(){
		if(rolls > 0)
		{
			$('#points-p'+active_player["id"]).text(active_player["points"]);
			setNextPlayer();
			$('#player').text(active_player["name"]);
			
			
		}
		else
		{
			$('#info').text("Du musst mindestens 1 mal wuerfeln");
		}
	});
	
	function setNextPlayer()
	{
		$('#info').text("");

		if(active_player["id"] + 1 < players.length)
		{			
			active_player	= players[(active_player["id"] + 1)];
			$('#player').text(active_player["name"]);
			$('#act-points').text(active_player["points"]);
			max_rolls = rolls;
			resetCubes();
		}
		else
		{
			$('#info').text("Es haben alle Spieler gew"+unescape("%FC")+"rfelt. Bitte Starte eine neue Runde!");
		}
	}
	
	//W�rfel zur�cksetzen
	function resetCubes()
	{
		$('.cube').text(0);
		$('.cube').removeClass("hold");
		rolls		= 0;
		$('#anz_rolls').text(rolls);
		$unlocked_cubes	= $('.cube').not('.hold');
		
	}

	//Wenn eine neue Runde gestartet wird.
	$('#new-round').click(function(){
		assignBierdeckel();
		active_player	= players[0];
		$('#player').text(active_player["name"]);
		resetCubes();
		resetPoints();
		
		max_rolls		= 3;
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//DevConsole
	
	$('#console-toggler').click(function(){
		$('#console').toggle(100);
	});
	
	
	if($('#num-log-entries').val() > 0)
	{
		$('#console-toggler').append(' ('+$('#num-log-entries').val()+')');
	}
	
	
	
	//Windows
	$('.window').draggable({
		handle:'.window-title',
		containment:'parent',
		stack: ".window",
	});
	

	
	//Closeables
	$closeable	= $(".closeable");
	
	
	$closeable.hover(function()
	{
		$closeable.removeClass('readytoclose');
		
		$(this).append("<div id='close-cross'></id>");		
		$(this).addClass('readytoclose');
		
		$('#close-cross').show().position({
			of:(this),
			my: 'right top',
			at: 'right-5 top+5'
		});
		
	}, function()
	{
		$(this).removeClass('readytoclose');
		$('#close-cross').remove();	
	});
	
	$(document).on('click', '#close-cross', function()
	{
		$('.readytoclose').hide(100);
		$('#darkbackground').hide();
	});
	
	//Sanftes scrollen zu Anker
	$('a[href*=#]').click(function(event)
	{
		event.preventDefault();
		
		var ziel = $(this).attr("href");

		$('html,body').animate({
			scrollTop: $(ziel).offset().top-180
		}, 500);
	});	
	
	//Zum Anfang scrollen
	$('#top-arrow').click(function()
	{
		$('html,body').animate({
			scrollTop: 0
		}, 500);
	});
	
	//Beim scrollen wird der Pfeil nach oben gezeigt.
	$(document).scroll(function()
	{
		if($(document).scrollTop() >= 500)
		{
			if($('#top-arrow').not(':visible'))
			{
				var pos	= $('#box_content_text').position();
				
				$('#top-arrow').show(0);
			}
		}
		else
		{
			$('#top-arrow').hide(0);
		}
	}).stop();
	//Wenn der Slider ber�hrt wird, dass wird angezeigt.
	$('#live_tile_slider').hover(function()
	{
		$('#box_content_tiles').show('slide',{direction:'right'});
	});
	
	//Beim Ber�hren von box_content_text wird der Tiles Container ausgeblendet, au�er cc_fixed ist wahr.
	$('#box_content_tiles').mouseleave(function()
	{
		if($.cookie("cc_fix") != "true")
		{
			$('#box_content_tiles').hide('slide',{direction:'right'});
		}
	})
	
	//Beim Klick auf den Benutzernamen wird der Tiles Container ein- bzw. ausgeblendet.
	$('#header-user-info').click(function()
	{
		$('#box_content_tiles').toggle('slide',{direction:'right'});
		$('#cc_fixed').val('true');
		
		if($.cookie("cc_fix") == "true")
		{
			$.removeCookie("cc_fix");
		}
		else
		{
			$.cookie("cc_fix", "true");
		}
	})
	
	if($.cookie("cc_fix") == "true")
	{
		$('#box_content_tiles').show(0);
	}
	
});

	function msgBox(message, title, fokus)
	{
		fokus = fokus || false;
		
		$('#console-content').html(message);
		$('#console-title').html(title);
		
		if(fokus === true)
		{
			$('#darkbackground').show();
		}
			
		$('#console').show();
	}

function changeContent(id, shtml)
{
	document.getElementById(id).innerHTML = shtml;
}


function showBox(id)
{
	document.getElementById(id).style.display = "block";
}


function hideBox(id)
{
	document.getElementById(id).style.display = "none";
}

function showSystemNotification(id)
{
	document.getElementById(id).style.opacity = "0";
}
    
window.setInterval("uhr()",1000);

function uhr()
{
d = new Date ();

h = (d.getHours () < 10 ? '0' + d.getHours () : d.getHours ());
m = (d.getMinutes () < 10 ? '0' + d.getMinutes () : d.getMinutes ());
s = (d.getSeconds () < 10 ? '0' + d.getSeconds () : d.getSeconds ());

document.getElementById("zeit").innerHTML = h + ':' + m + ':' + s;
}


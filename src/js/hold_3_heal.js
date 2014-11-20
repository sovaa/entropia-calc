
$(document).ready(function() {
  if ($("#hide-heal-enhancers").val() === '1') {
    $("#select-heal-enhancers").hide();
    $("#toggle-heal-enhancers").removeClass("arrow-desc").addClass("arrow-asc");
  }
  else {
    $("#select-heal-enhancers").show();
    $("#toggle-heal-enhancers").removeClass("arrow-asc").addClass("arrow-desc");
  }
  
  $("select.all-heal-enhancers").live('change', function() {
    var value = $(this).val();

    $("select.heal-enhancers").each(function() {
      $(this).val(value);
    });
    
    $.fn.changeHealEnhancers();
  });
  
  $("#toggle-heal-enhancers").live('click', function() {
    if ($("#hide-heal-enhancers").val() === '1') {
      $("#hide-heal-enhancers").val(0);
      $("#select-heal-enhancers").show();
      $("#toggle-heal-enhancers").removeClass("arrow-asc").addClass("arrow-desc");
    }
    else {
      $("#hide-heal-enhancers").val(1);
      $("#select-heal-enhancers").hide();
      $("#toggle-heal-enhancers").removeClass("arrow-desc").addClass("arrow-asc");
    }
  });
  
  $.fn.changeHealEnhancers = function() {
	  var tool = $("select#medical-tool").find(':selected').attr('title');
	  var title = eval("(function(){return " + tool + ";})()");
	  
	  /* no enhancers for mindforce */
	  if (title === undefined || title['type'].indexOf('Mindforce') !== -1) {
		  return;
	  }

	  var decay = parseFloat(title['decay']);
	  var effective = parseFloat(title['effective']);
	  var cost = parseFloat(title['cost']);
	  var uses = parseFloat(title['uses']);
	  
	  var economy = 1;
	  var heal = 1;

	  $("select.heal-enhancers").each(function() {
		  var text = $(this).find(':selected').text();

		  if (text.indexOf('Economy') !== -1) {
			  economy += 0.05;
		  }
		  else if (text.indexOf('Heal') !== -1) {
			  heal += 0.05;
		  }
		  else if (text.indexOf('Skill') !== -1) {
			  /* TODO */
		  }
	  });
	  
	  if (economy !== 1) {
	    decay = Math.round(1000 * decay / economy) / 1000;
	  }
	  
	  if (heal !== 1) {
        decay = Math.round(1000 * decay * heal) / 1000;
  	    effective = Math.round(100 * effective * heal) / 100;
	  }
	  
	  /* cost is decay plus ammo usage, but only mindforce uses ammo, and they don't use enhancers */
	  cost = decay;
	  
	  var hps = Math.round(100 * uses * effective / 60) / 100;
	  var eco = Math.round(100 * effective / cost)/100;
	  
	  if (isNaN(cost)) {
		  cost = '--';
		  decay = '--';
	  }
	  if (isNaN(eco)) {
		  eco = '--';
	  }
	  if (isNaN(effective)) {
		  effective = '--';
	  }
	  if (isNaN(hps)) {
		  hps = '--';
	  }

	  $("div#medical-info").find("span#heal-stats-cost").text(cost);
	  $("div#medical-info").find("span#heal-stats-decay").text(decay);
	  $("div#medical-info").find("span#heal-stats-eco").text(eco);
	  $("div#medical-info").find("span#heal-stats-effective").text(effective);
	  $("div#medical-info").find("span#heal-stats-hps").text(hps);
  };
  
  $("select#medical-tool").live('change', function() {
	var json = $(this).find(':selected').attr('title');
	var title = eval("(function(){return " + json + ";})()");
	var box = $("div#medical-info");
	
	for (var key in title) {
		var value = title[key];
		var target = box.find('span#heal-stats-' + key);
		
		if (target !== undefined) {
			target.text(value);
		}
	}
	
	if (title['name'].indexOf('(L)') !== -1) {
	  var markup = title['markup'];
	  
	  if (markup !== undefined && markup.length > 0) {
		  markup = markup.replace('PED', '');
		  markup = markup.replace('%', '');
		  markup = markup.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		  
		  if (!isNumber(markup)) {
			  markup = 100;
		  }
	  }
	  else {
		  markup = 100;
	  }
	}
	else {
		markup = 100;
	}
	
	$("input[name='player-heal-markup']").val(markup);
	
	$.fn.changeHealEnhancers();
  });
  
  $("select.heal-enhancers").each(function() {
	  $(this).live('change', $.fn.changeHealEnhancers);
  });
	  
  /* load this at the beginning */
  $.fn.changeHealEnhancers();
});
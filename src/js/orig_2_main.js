$(document).ready(function() { 
  $("#result").dataTable({
    "iDisplayLength": 100
  });

  $("#result").show();

  $("span.each-word").each(function() {
    var val = $(this).html();

    $(this).html(val.replace(
        /\b([a-z])([a-z]+)?\b/gim, 
        "<span class='first-letter'>$1</span>$2"
    ));
  });

  /* blur input when not focused */
  {   
    $('input[type="text"]').addClass("idleField");

    $('input[type="text"]').focus(function() {
      $(this).removeClass("idleField").addClass("focusField");
    }); 

    $('input[type="text"]').blur(function() {
      $(this).removeClass("focusField").addClass("idleField");
    }); 
  }

  if ($("input[name='use-enhancer-decay']").is(":checked")) {
    $('div#search-weapon-wrapper').css('width', '600px');
    $("span.enhancer-setting-wrapper").each(function() {
      $(this).show();
    });
  }
  else {
    $("span.enhancer-setting-wrapper").each(function() {
      $(this).hide();
    });
  }

  $("input[name='use-enhancer-decay']").change(function() {
    if ($(this).is(":checked")) {
      $('div#search-weapon-wrapper').css('width', '600px');

      $("span.enhancer-setting-wrapper").each(function() {
        $(this).show();
      });
    }
    else {
      $('div#search-weapon-wrapper').css('width', '300px');

      $("span.enhancer-setting-wrapper").each(function() {
        $(this).hide();
      });
    }
  });

  $('th[title]').qtip({
    style: {
      classes: 'ui-tooltip-tipsy ui-tooltip-shadow'
    },
    position: {
      my: 'bottom center',
      at: 'top center',
      target: 'event'
    },
    show: {
      delay: 1000
    }
  });

  $('td[title]').qtip({
    style: {
      classes: 'ui-tooltip-tipsy ui-tooltip-shadow'
    },
    position: {
      my: 'left center',
      at: 'right center',
      target: 'event'
    },
    show: {
      delay: 1000
    }
  });

  $('select.enhancers').change(function () {
    var name = $(this).children("option:selected").text();
    var slotname = $(this).children().first().text();
    var slot = slotname.substring(slotname.length - 2).trim();
    var stats = $("span[id='enhancer-stats-" + name + "']").text().split(';');

    var markup = stats[0].replace('PED', '').trim();
    var decay = stats[1];

    $('input#enhancer-markup-' + slot).attr('value', markup);
    $('input#enhancer-decay-' + slot).attr('value', decay);
    $('input#enhancer-type-' + slot).attr('value', name);
  });

  $('input[name="find-finishers"]').live('click', function() {
    $('div#search-finisher-wrapper').toggle();
    
    if ($('input[name="find-creatures"]').is(':checked')) {
    	$('input[name="find-creatures"]').removeAttr('checked');
    }
  });
  $('input[name="find-creatures"]').live('click', function() {
    if ($('input[name="find-finishers"]').is(':checked')) {
    	$('input[name="find-finishers"]').removeAttr('checked');
        $('div#search-finisher-wrapper').toggle();
    }
  });

  $('input[name="skip-limited"]').live('click', function() {
    if ($('input[name="use-weapon-markup"]').is(':checked')) {
    	$('input[name="use-weapon-markup"]').removeAttr('checked');
    }
  });
  $('input[name="use-weapon-markup"]').live('click', function() {
    if ($('input[name="skip-limited"]').is(':checked')) {
    	$('input[name="skip-limited"]').removeAttr('checked');
    }
  });

  if ($('input[name="find-finishers"]').is(':checked')) {
    $('div#search-finisher-wrapper').show();
  }
  else {
    $('div#search-finisher-wrapper').hide();
  }

  var $buffCheckbox = $('input[name="find-buffs"]');
  $buffCheckbox.live('click', function() {
    $('div#search-buff-wrapper').toggle();
  });

  if ($buffCheckbox.is(':checked')) {
    $('div#search-buff-wrapper').show();
  }
  else {
    $('div#search-buff-wrapper').hide();
  }

  $('select#setting-creature').live('change', function() {
    var set = $('select#setting-creature option:selected').attr('title').split(':');

    if (set !== undefined && set.length > 0) {
      var hp = set[0];
      var regen = set[1];

      $('input#setting-creature-hp').val(hp);
      $('input#setting-creature-regen').val(regen);
    }
  });

  $('input#reset').live('click', function() {
    $('input#setting-creature-hp').val('');
    $('input#setting-creature-regen').val('');
    $('input#setting-weapon-id').val('');
    $("select#skip-list").empty();

    $('select.setting').each(function() {
      if ($(this) !== undefined && $(this).length > 0) {
        $(this)[0].selectedIndex = 0;
      }
    });

    $('select.enhancers').each(function() {
      if ($(this) !== undefined && $(this).length > 0) {
        $(this)[0].selectedIndex = 0;
      }
    });

    $('select.heal-enhancers').each(function() {
      if ($(this) !== undefined && $(this).length > 0) {
        $(this)[0].selectedIndex = 0;
      }
    });

    $('input[name="maximize"]').removeAttr('checked');
    $('input[name="use-weapon-markup"]').removeAttr('checked');
    $('input[name="find-finishers"]').removeAttr('checked');
    $('input[name="find-creatures"]').removeAttr('checked');
    $('input[name="find-amplifiers"]').removeAttr('checked');
    $('input[name="skip-limited"]').removeAttr('checked');
    $('input[name="ignore-regen"]').removeAttr('checked');
    $('input[name="skip-unknown-skill"]').removeAttr('checked');
    $('input[name="amp-markup"]').val('');
    $('input[name="hit-profession"]').val('');
    $('input[name="damage-profession"]').val('');

    $("#hide-enhancers").val('1');
    $("#select-enhancers").hide();
    $("#toggle-enhancers").removeClass("arrow-desc").removeClass("arrow-asc").addClass("arrow-asc");

    $("#hide-heal-enhancers").val('1');
    $("#select-heal-enhancers").hide();
    $("#toggle-heal-enhancers").removeClass("arrow-desc").removeClass("arrow-asc").addClass("arrow-asc");

    $('div#search-finisher-wrapper').hide();
    
    var allEnhancers = $('select[name="all-enhancers"]');
    var allHealEnhancers = $('select[name="all-heal-enhancers"]');

    if (allEnhancers !== undefined && allEnhancers.length > 0) {
      allEnhancers[0].selectedIndex = 0;
    }

    if (allHealEnhancers !== undefined && allHealEnhancers.length > 0) {
      allHealEnhancers[0].selectedIndex = 0;
    }
  
    var fsize = $(".filter-entry").size();

    if (fsize != null && fsize > 0) {
      while (fsize > 1) {
        $(".filter-entry :last").parent().parent().remove();
        fsize = $(".filter-entry").size();
      }

      $('input[name="filter-column-value[]"]').first().val('');

      var columnMatch = $('select[name="filter-column-match[]"]');
      var columnName = $('select[name="filter-column-name[]"]');

      if (columnMatch !== undefined && columnMatch.length > 0) {
        columnMatch[0].selectedIndex = 0;
      }

      if (columnName !== undefined && columnName.length > 0) {
        columnName[0].selectedIndex = 0;
      }

      $("#filters").val(1);
    }
  });

  $('<div id="container" />').css({
    pointerEvents: "none",
    zoom: 1,
    filter: "alpha(opacity=50)",
    opacity: 0.5,
    width: "100%",
    height: "100%",
    position: "fixed",
    top: 0,
    left: 0,
    zIndex: 2998,
    backgroundColor: "rgb(100, 100, 100)",
    display: "none"
  }).appendTo("body");

  $("form#search-form").submit(function() {
    $("select#skip-list").children().each(function() {
      $(this).attr("selected", "selected");
    });

    return true;
  });

  $("input#skip-list-clear").click(function() {
    $("select#skip-list").empty();
  });

  $("input#skip-list-remove").click(function() {
    $("select#skip-list").children(":selected").each(function() {
      $(this).remove();
    });
  });

  $('#container').live('click', function() {
    $("span#help-link").click();
  });

  $("span#help-link").live('click', function() {
    $('#container').css({opacity: 0.0});
    $('#container').toggle();
    $('#container').animate({opacity: 0.5}, 200);

    $('#container').css({pointerEvents: "none"});
    $('#container:visible').css({pointerEvents: ""});

    if ($("#result").length > 0 && $("th.cost").length > 0) {
      var pos = $("th.cost").offset();
      var width = $("th.cost").width();
  
      if (pos != null) {
        var helper = $("div#cost-helper");
        pos.top -= parseInt(helper.css('height').replace('px', ''));
        pos.top -= 16;
  
        pos.left -= parseInt(helper.css('width').replace('px', '')) / 2;
        pos.left -= 8;
  
        helper.css({ "left": (pos.left + width) + "px", "top":pos.top + "px" });

        helper.toggle();
      }
    }

    if (!$('div#search-wrapper').is(':visible')) {
        return;
    }

    {
      var skill = $("td#skill-inputs");
      var pos = skill.offset();

      if (pos != null) {
        var helper = $("div#skill-helper");
        pos.top -= parseInt(helper.css('height').replace('px', '')) / 2;
        pos.top += parseInt(skill.css('height').replace('px', '')) / 2;
        pos.top -= 5;

        var left = parseInt(skill.css('width').replace('px', ''));

        helper.css({'left': (pos.left + left) + "px", 'top': pos.top + "px"});

        helper.toggle();
      }
    }

    {
      var creature = $("select#setting-creature");
      var pos = creature.offset();

      if (pos != null) {
        var helper = $("div#creature-helper");
        pos.top -= parseInt(helper.css('height').replace('px', ''))/ 2;
        pos.top += parseInt(creature.css('height').replace('px', '')) / 2;
        pos.top -= 5;

        var left = parseInt(creature.css('width').replace('px', ''));

        helper.css({'left': (pos.left + left) + "px", 'top': pos.top + "px"});

        helper.toggle();
      }
    }

    {
      var creature = $("div#toggle-enhancers");
      var pos = creature.offset();

      if (pos != null) {
        var helper = $("div#enhancer-helper");
        pos.top -= parseInt(helper.css('height').replace('px', ''))/ 2;
        pos.top += parseInt(creature.css('height').replace('px', '')) / 2;
        pos.top -= 5;

        var left = parseInt(creature.css('width').replace('px', ''));
        left += 5;

        helper.css({'left': (pos.left + left) + "px", 'top': pos.top + "px"});

        helper.toggle();
      }
    }
  });

  if ($("#hide-enhancers").val() === '1') {
    $("#select-enhancers").hide();
    $("#toggle-enhancers").removeClass("arrow-desc").addClass("arrow-asc");
  }
  else {
    $("#select-enhancers").show();
    $("#toggle-enhancers").removeClass("arrow-asc").addClass("arrow-desc");
  }

  $("tr.rr").live('click', function() {
    $(this).toggleClass('selected-row');
  });

  $("#add-filter").live('click', function() {
    var filters = parseInt($("#filters").val());

    if (filters != NaN) {
      $(".filter-entry").first().clone().appendTo($("#filter-list"));
      $("#filters").val(filters + 1);
    }
  });

  $(".remove-filter").live('click', function() {
    if ($(".filter-entry").size() == 1) {
      return;
    }

    $(this).parent().parent().remove();

    var filters = parseInt($("#filters").val());
    if (filters != NaN) {
      $("#filters").val(filters - 1);
    }
  });

  $("select.all-enhancers").live('change', function() {
    var value = $(this).val();

    $("select.enhancers").each(function() {
      $(this).val(value);

      var name = $(this).children("option:selected").text();
      var slotname = $(this).children().first().text();
      var slot = slotname.substring(slotname.length - 2).trim();

      if (name.indexOf('Select') !== -1) {
        $('input#enhancer-markup-' + slot).attr('value', '');
        $('input#enhancer-decay-' + slot).attr('value', '');
        $('input#enhancer-type-' + slot).attr('value', '');
        return;
      }

      var stats = $("span[id='enhancer-stats-" + name + "']").text().split(';');

      var markup = stats[0].replace('PED', '').trim();
      var decay = stats[1];

      if (markup.trim().length == 0) {
        markup = 0;
      }

      if (decay.trim().length == 0) {
        decay = 1000;
      }

      $('input#enhancer-markup-' + slot).attr('value', markup);
      $('input#enhancer-decay-' + slot).attr('value', decay);
      $('input#enhancer-type-' + slot).attr('value', name);
    })
  });

  $("#toggle-enhancers").live('click', function() {
    if ($("#hide-enhancers").val() === '1') {
      $("#hide-enhancers").val(0);
      $("#select-enhancers").show();
      $("#toggle-enhancers").removeClass("arrow-asc").addClass("arrow-desc");
    }
    else {
      $("#hide-enhancers").val(1);
      $("#select-enhancers").hide();
      $("#toggle-enhancers").removeClass("arrow-desc").addClass("arrow-asc");
    }
  });

  $("div#result-wrapper-div").on('click', 'td.cost', function() {
    var id = $(this).attr('id').split('-')[1];
    var element = $("#result-" + id);
    var details = $(element).remove();

    var classes = details.find("td[class^='colspan']").attr('class').split(' ');
    var colspan = 19; // default

    for (var i = 0; i < classes.length; i++) {
      if (classes[i].indexOf('colspan-') === 0) {
          colspan = parseInt(classes[i].substring("colspan-".length));
      }
    }

    // set the colspan
    details.find("td.cost-details").attr('colspan', colspan);

    if (element.is(":visible")) {
      $("#hidden-details").after(details);
    }
    else {
      $(this).parent().after(details);
    }

    buildTable(details, ".table-creator-finishers", ".table-target-finishers");
    buildTable(details, ".table-creator-amplifiers", ".table-target-amplifiers");
    buildTable(details, ".table-creator-creatures", ".table-target-creatures");

    var creatures = details.find(".other-creatures-table");

    if (creatures.not('.initialized')) {
        creatures.addClass('initialized');

        creatures.find("td[class^='bgp-'],td[class*=' bgp-']").each(function() {
          var classes = $(this).attr('class').split(" ");
          var bgp = null;

          for (i in classes) {
            var name = classes[i];
            if (name.substring(0, 'bgp-'.length) === 'bgp-') {
              bgp = name.substring('bgp-'.length, name.length);
              break;
            }
          }

          $(this).css('background-color', getColor(bgp));
          $(this).css('color', '#000');
        });

        creatures.dataTable({
            "iDisplayLength": 25,
            "aaSorting": [[ 1, "asc" ]]
        });

        creatures.toggle();
    }

    details.toggle();

    $('th[title]').qtip({
      style: {
        classes: 'ui-tooltip-tipsy ui-tooltip-shadow'
      },
      position: {
        my: 'bottom left',
        at: 'top-center',
        target: 'event'
      },
      show: {
        delay: 1000
      }
    });

    $('div.tip[title]').qtip({
      style: {
        classes: 'ui-tooltip-tipsy ui-tooltip-shadow'
      },
      position: {
        my: 'bottom left',
        at: 'top-center',
        target: 'event'
      },
      show: {
        delay: 1000
      }
    });
  });

  $('a#hide-search').click(function() {
    $('div#search-wrapper').toggle(250);
  });
}); 

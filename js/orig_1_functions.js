function ca(id, type) {
    if (!isNumber(id)) {
        alert("ID not numeric.");
        return;
    }

    if (type == null || type == '') {
        alert("Blank amplifier type.");
        return;
    }

    if (type === 'Laser') {
        $('select[name="amp_energy"]').val(id);
    }
    else if (type === 'BLP') {
        $('select[name="amp_blp"]').val(id);
    }
    else {
        alert("Unknown amplifier type.");
        return;
    }

    $('#search-form').submit();
}

function skip(id, name) {
    $("select#skip-list").prepend('<option value="' + name + '">' + name + '</option>');
    $("tr#row-" + id).remove();
    $("tr#result-" + id).remove();
}

function cc(id) {
    if (!isNumber(id)) {
        alert("ID not numeric.");
        return;
    }
    
    $('select#setting-creature').val(id);
    
    var title = $('select#setting-creature').find(':selected').attr('title').split(':');
    var hp = title[0];
    var regen = title[1];

    $('input#setting-creature-hp').val(hp);
    $('input#setting-creature-regen').val(regen);
    
    $('#search-form').submit();
}

var percentColors = [
    { pct: 0.0, color: { r: 0x00, g: 0xff, b: 0 } },
    { pct: 0.5, color: { r: 0xff, g: 0xff, b: 0 } },
    { pct: 1.0, color: { r: 0xff, g: 0x00, b: 0 } } ];

var getInvertColor = function (pct) {
    if (pct == 0) {
        return 'rgb(CC,CC,CC)';
    }
    for (var i = 0; i < percentColors.length; i++) {
        if (pct <= percentColors[i].pct) {
            var lower = percentColors[i - 1] || {
                pct: 0.1,
                color: {
                    r: 0x0,
                    g: 0x00,
                    b: 0
                }
            };
            var upper = percentColors[i];
            var range = upper.pct - lower.pct;
            var rangePct = (pct - lower.pct) / range;
            var pctLower = 1 - rangePct;
            var pctUpper = rangePct;
            var color = {
                r: 255 - Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper),
                g: 255 - Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper),
                b: 255 - Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper)
            };
            return 'rgb(' + [color.r, color.g, color.b].join(',') + ')';
        }
    }
};

var getColor = function (pct) {
    if (pct == 0) {
        return 'rgb(CC,CC,CC)';
    }
    for (var i = 0; i < percentColors.length; i++) {
        if (pct <= percentColors[i].pct) {
            var lower = percentColors[i - 1] || {
                pct: 0.1,
                color: {
                    r: 0x0,
                    g: 0x00,
                    b: 0
                }
            };
            var upper = percentColors[i];
            var range = upper.pct - lower.pct;
            var rangePct = (pct - lower.pct) / range;
            var pctLower = 1 - rangePct;
            var pctUpper = rangePct;
            var color = {
                r: Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper),
                g: Math.floor(lower.color.g * pctLower + upper.color.g * pctUpper),
                b: Math.floor(lower.color.b * pctLower + upper.color.b * pctUpper)
            };
            return 'rgb(' + [color.r, color.g, color.b].join(',') + ')';
        }
    }
};

function buildTable(parent, sourceClass, targetClass) {
  var container = parent.find(sourceClass);

  var tbl = eval(container.find(".creator-table").html());
  var hdr = eval(container.find(".creator-header").html());
  var bdy = eval(container.find(".creator-body").html());

  var target = parent.find(targetClass);

  var table = '<table'; 
  var tableclass = '';

  for (var post in tbl) {
    tableclass = tbl[post].c;
  }

  if (tableclass !== undefined) {
    table += ' class="' + tableclass + '"';
  }

  table += ' cellspacing="0" cellpadding="0"><thead><tr>';

  for (var post in hdr) {
    var row = '<th class="';

    row += hdr[post].c + '" title="' + hdr[post].t + '">';
    row += hdr[post].v + '</th>';
 
    table += row;
  }

  table += '</tr></thead><tbody>';

  var i = 0;
  for (var post in bdy) {
    var row = '<tr class="' + (i % 2 == 0 ? 'odd' : 'even') + '">';
    i++;

    row += '<td class="' + bdy[post].c0 + '"><a ' + bdy[post].v000;

    if (bdy[post].v001 !== undefined) {
        row += ' ' + bdy[post].v001;
    }
    
    row += '>' + bdy[post].v01 + '</a></td>';
    row += '<td class="' + bdy[post].c1 + '">' + bdy[post].v10 + '</td>';
    row += '<td class="' + bdy[post].c2 + '">';
    
    if (bdy[post].v21 !== undefined) {
        row += '<span ' + bdy[post].v20 + '>' + bdy[post].v21 + '</span></td>';
    }
    else {
        row += bdy[post].v20 + '</td>';
    }
    
    if (bdy[post].c3 !== undefined) {
        row += '<td class="' + bdy[post].c3 + '">';
        
        if (bdy[post].v31 !== undefined) {
            row += '<span ' + bdy[post].v30 + '>' +  bdy[post].v31 + '</span>';
        }
        else {
        	row += bdy[post].v30;
        }
        
        row += '</td>';
    }

    if (bdy[post].c4 !== undefined) {
        row += '<td class="' + bdy[post].c4 + '">' + bdy[post].v40 + '</td>';
    }

    if (bdy[post].c5 !== undefined) {
        row += '<td class="' + bdy[post].c5 + '">';
        
        if (bdy[post].v50 == '--') {
            row += '<span style="color: #666">' + bdy[post].v50 + '</span>';
        }
        else {
            row += bdy[post].v50;
        }
        
        row += '</td>';
    }

    if (bdy[post].c6 !== undefined) {
        row += '<td class="' + bdy[post].c6 + '">' + bdy[post].v60 + '</td>';
    }

    if (bdy[post].c7 !== undefined) {
        row += '<td class="' + bdy[post].c7 + '">' + bdy[post].v70 + '</td>';
    }

    row += '</tr>';
 
    table += row;
  }
 
  table += '</tbody></table>';

  target.html(table);
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

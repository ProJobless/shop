/*****************************************************************
 Copyright 2010, Kjell.Ericson@haxx.se, version 2010-12-16

The script uses classes for defining what parts to use for scrolling.
You shall mark the things:

1) One id for the table.
2) One class name for to row cells to lock
3) One class name for the column cells to lock

You init the function by calling:

  TableLock("table_class_name", "left_class_name", "headline_class_name");

The table is made up like this:

 <table class='table_class_name'>
  <tr>
    <td>empty cell or whatever</td>
    <td class='headline_class_name'>column 1</td>
    <td class='headline_class_name'>column 2</td>
    <td class='headline_class_name'>column 3</td>
  </tr>
  <tr>
    <td class='left_class_name'>row 1</td>
    <td>data 1</td>
    <td>data 2</td>
    <td>data 3</td>
  </tr>
  <tr>
    <td class='left_class_name'>row 2</td>
    <td>data 1</td>
    <td>data 2</td>
    <td>data 3</td>
  </tr>
</table>

******************************/

TL_tables = new Array();

function TL_settings()
{
    this.last_x = -1;
    this.row_elements = new Array();
    this.col_elements = new Array();
    this.lock_elements = new Array();

    this.min_x = 10000;
    this.min_y = 10000;

    this.max_x = 0;
    this.max_y = 0;
}

function TL_struct(node, oldnode, xpos, ypos)
{
    this.node = node;
    this.oldnode = oldnode;
    this.x = xpos;
    this.y = ypos;
}

function TableLock(table_id, left_class_name, headline_class_name, 
                   lock_class_name) 
{
    var tlt = new TL_settings();
    tlt.table_element = document.getElementById(table_id);
    if (tlt.table_element == undefined) {
        alert("TableLock can't find table " + table_id);
        return;
    }

    var tags = new Array("td", "th");
    var max = 2000;
    for(var t = 0; t < tags.length; t++){
        var tag = tags[t];
        var elements = document.getElementsByTagName(tag);
        for(var i = 0; i < elements.length; i++){
            var node = elements.item(i);
            for(var j = 0; j < node.attributes.length; j++) {
                var n = node.attributes.item(j); 
                if(n.nodeName == 'class' &&
                   (n.nodeValue.indexOf(left_class_name) >= 0 ||
                    n.nodeValue.indexOf(lock_class_name) >= 0 ||
                    n.nodeValue.indexOf(headline_class_name) >= 0)) {
                    var newNode = document.createElement("div");
                    var pos = TL_getPos(node);
                    for (var p in node.style) {
                        try {
                            newNode.style[p] = node.style[p]
                                }
                        catch (e) {
                        }
                    }
                    newNode.innerHTML = node.innerHTML;
                    newNode.style.height = node.offsetHeight + "px";
                    newNode.style.width = node.offsetWidth + "px";
                    newNode.style.position = "absolute";
                    // newNode.class = node.class;
                    newNode.style.left = pos.x + "px";
                    newNode.style.top = pos.y + "px";

                    // Store bounderies for table.
                    if (pos.x < tlt.min_x)
                        tlt.min_x = pos.x
                    if (pos.y < tlt.min_y)
                        tlt.min_y = pos.y

                    if (pos.x > tlt.max_x)
                        tlt.max_x = pos.x
                    if (pos.y > tlt.max_y)
                        tlt.max_y = pos.y


                    if (max-- == 0) return;
                    if (node.attributes.item(j).nodeValue.indexOf(headline_class_name) >= 0)
                        tlt.col_elements.push(new TL_struct(newNode, node, pos.x, pos.y));
                    else if (node.attributes.item(j).nodeValue.indexOf(lock_class_name) >= 0)
                        tlt.lock_elements.push(new TL_struct(newNode, node, pos.x, pos.y));
                    else
                        tlt.row_elements.push(new TL_struct(newNode, node, pos.x, pos.y));
                }
            }
        }
    }
    for(var i = 0; i < tlt.row_elements.length; i++){
        var obj = tlt.row_elements[i];
        //obj.oldnode.parentNode.insertBefore(obj.node, obj.oldnode);
        document.body.appendChild(obj.node);
    }
    for(var i = 0; i < tlt.col_elements.length; i++){
        var obj = tlt.col_elements[i];
        document.body.appendChild(obj.node);
    }
    for(var i = 0; i < tlt.lock_elements.length; i++){
        var obj = tlt.lock_elements[i];
        document.body.appendChild(obj.node);
    }
    this.onscroll = TableLock_update;
    TL_tables.push(tlt);
    TableLock_update();
 }

function TableLock_update() 
{
    var iebody=(document.compatMode && document.compatMode != "BackCompat")? document.documentElement : document.body;
    
    var scroll_left=document.all? iebody.scrollLeft : pageXOffset;
    var scroll_top=document.all? iebody.scrollTop : pageYOffset;

    for(var t = 0; t < TL_tables.length; t++){
        var tlt = TL_tables[t];
        for(var i = 0; i < tlt.row_elements.length; i++){
	    var obj = tlt.row_elements[i];
            var x = obj.x;
            if (scroll_left > tlt.min_x)
                x = scroll_left - tlt.min_x + x;
            if (x > tlt.max_x)
                x = tlt.max_x;
	    obj.node.style.left = x + "px";
	}
	for(var i = 0; i < tlt.col_elements.length; i++){
	    var obj = tlt.col_elements[i];
            var y = obj.y;
            if (scroll_top > tlt.min_y)
                y = scroll_top - tlt.min_y + y;
            if (y > tlt.max_y)
                y = tlt.max_y;
            obj.node.style.top = y + "px";
	}
	for(var i = 0; i < tlt.lock_elements.length; i++){
	    var obj = tlt.lock_elements[i];
            var x = obj.x;
            if (scroll_left > tlt.min_x)
                x = scroll_left - tlt.min_x + x;
            if (x > tlt.max_x)
                x = tlt.max_x;
	    obj.node.style.left = x + "px";
            var y = obj.y;
            if (scroll_top > tlt.min_y)
                y = scroll_top - tlt.min_y + y;
            if (y > tlt.max_y)
                y = tlt.max_y;
            obj.node.style.top = y + "px";
	}
    }
}

function TL_getPos( oElement )
{
    var y = 0;
    var x = 0;
    while( oElement != null ) {
        y += oElement.offsetTop;
        x += oElement.offsetLeft;
        oElement = oElement.offsetParent;
    }
    return {x:x, y:y};
}


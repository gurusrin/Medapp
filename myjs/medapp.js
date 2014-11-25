var splnList = [{id: 'HS', name: 'Heart Specialist'}, {id: 'NE', name: 'Nephrologist'},
                {id: 'GP', name: 'General Practitioner'}];

require(["dijit/form/TextBox", "dojo/domReady!"], function(TextBox){
    var myTextBox = new dijit.form.TextBox({
        name: "zipcode",
        value: "" /* no or empty value! */,
        placeHolder: "type in your zip"
    }, "zipcode");
});

/* This is the code for the specialization drop down box */
require([
         "dojo/store/Memory", "dijit/form/FilteringSelect",
         "dijit/registry", "dojo/domReady!"
     ], function(Memory, FilteringSelect, registry){
         var splnStore = new Memory({
        	 data : splnList
         });

         var filteringSelect = new FilteringSelect({
             id: "splnSelect",
             name: "spln",
             value: "NE",
             store: splnStore,
             searchAttr: "name"
         }, "splnSelect").startup();
     });
/* date picker */

require(["dojo/parser", "dijit/form/DateTextBox"]);

/* Validation of input */
//var node = dom.byId("search");

//on(dom.byId("search"), "click", function() {validate_input()});

/*function validate_input()
{
        var node_zip = dijit.byId("zipcode");
        if(node_zip.value.length == 6)
        {
	  alert("The zip code has to b 6 digits long");
        }
        re = /^\d+$/;

        if(re.test(node_zip.value))
        {
	  alert("Zip code will contain only numbers");
        }

        var node_spl = dom.byId("specialiaztion");
        re = /^\d+$/;
        if(!re.test(node_spl.value))
        {
          alert("Select a specialization from the list");
        }       
}*/

function checkValues()
{
	var node = dijit.byId("zipcode");
	var pattern  = /^\d{6}$/; 

	if (node.value.length != 6)
	{
		alert("Length of the PIN code should be 6 digits.");
	}
	else if (! pattern.test(node.value))
	{
		alert("PIN should be only numbers.");
	}

	alert("Date: " + dijit.byId("date1").value.toDateString())
}
/* dialog */

require(["dijit/Dialog", "dojo/domReady!"], function(Dialog){
    myDialog = new Dialog({
        title: "My Dialog",
        content: "Test content.",
        style: "width: 300px"
    });
});

/* data grid */

require(['dojo/_base/lang', 'dojox/grid/DataGrid', 'dojo/data/ItemFileWriteStore', 'dojo/dom', 'dojo/domReady!'],
	    function(lang, DataGrid, ItemFileWriteStore, dom){

	    /*set up data store*/
	    var data = {
	      identifier: "id",
	      items: []
	    };
	    var data_list = [
	      { col1: "normal", col2: false, col3: 'But are not followed by two hexadecimal', col4: 29.91},
	      { col1: "important", col2: false, col3: 'Because a % sign always indicates', col4: 9.33},
	      { col1: "important", col2: false, col3: 'Signs can be selectively', col4: 19.34}
	    ];
	    var rows = 60;
	    for(var i = 0, l = data_list.length; i < rows; i++){
	        data.items.push(lang.mixin({ id: i+1 }, data_list[i%l]));
	    }
	    var store = new ItemFileWriteStore({data: data});

	    /*set up layout*/
	    var layout = [[
	      {'name': 'Column 1', 'field': 'id', 'width': '100px'},
	      {'name': 'Column 2', 'field': 'col2', 'width': '100px'},
	      {'name': 'Column 3', 'field': 'col3', 'width': '200px'},
	      {'name': 'Column 4', 'field': 'col4', 'width': '150px'}
	    ]];

	    /*create a new grid*/
	    var grid = new DataGrid({
	        id: 'grid',
	        store: store,
	        structure: layout,
	        rowSelector: '20px'});

	        /*append the new grid to the div*/
	        grid.placeAt("gridDiv");

	        /*Call startup() to render the grid*/
	        grid.startup();
	        
	     // Our grid is stored in a variable called "grid":
	        grid.on("RowClick", function(evt){
	            //var idx = evt.rowIndex,
	                //rowData = grid.getItem(idx);
	            // The rowData is returned in an object, last is the last name, first is the first name
	            
	            	myDialog.show();
	        }, true);

	});

/*
 * 
 * 
 */
/*dojo.require("dijit.layout.BorderContainer");
dojo.require("dijit.layout.ContentPane");

dojo.ready(function(){
  var outerBc = new dijit.layout.BorderContainer({
    "design": "sidebar",
    "style": "height: 400px;"
  }, "uiContainer");

  var leftSidebar = new dijit.layout.ContentPane({
    "region": "leading",
    "style": "width: 200px;",
    "splitter": "true"
  });
  outerBc.addChild(leftSidebar);

  var rightContent = new dijit.layout.BorderContainer({
    "id": "uiContent",
    "region": "center"
  });

  var topContent = new dijit.layout.ContentPane({
    "region": "center",
    "splitter": "true"
  });
  rightContent.addChild(topContent);

  var bottomContent = new dijit.layout.ContentPane({
    "region": "bottom",
    "style": "height: 100px;",
    "splitter": "true"
  });
  rightContent.addChild(bottomContent);

  outerBc.addChild(rightContent);
  // rightContent.startup();
  outerBc.startup();
});
*/
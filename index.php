<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Demo: dojo/request/xhr JSON</title>
        <link rel="stylesheet" href="scripts/dijit/themes/claro/claro.css">
	<link rel="stylesheet" href="scripts/dojox/grid/resources/claroGrid.css">
        <style>
            #gridDiv {
                height: 30em;
                width: 80em;
            } 
        </style>
		<!-- <link rel="stylesheet" href="style.css" media="screen"> -->
        <script>dojoConfig = {async: true, parseOnLoad: true}</script>
		<script src="scripts/dojo/dojo.js"></script>
        <script>
            /* Store for the specialization list. */
            var splnList = {};
            var filteringSelect = {};

            require(["dojo/parser", "dijit/form/ValidationTextBox"]);
            require(["dojo/parser", "dijit/Calendar"]);
            require(["dojo/data/ItemFileWriteStore"]);

            require(["dijit/Dialog",
                     "dijit/form/Button",
                     "dojo/dom",
                     "dojo/request",
                     "dojo/json",
                     "dojo/_base/array",
                     "dojox/grid/DataGrid",
                     "dojo/data/ItemFileWriteStore",
                     "dojo/domReady!"],
                function (Dialog, Button, dom, request, json, arrayUtil, DataGrid, ItemFileWriteStore) {
                    var srchDlg = new Dialog({
                        'title' : 'Fetching information...',
                        'style' : 'width: 400px'
                    });

                    var srchBtn = new Button({
                        'label' : 'Search',
                        onClick : function() {
                            var pincode  = dijit.byId("pincode").get('value');
                            var spln     = dijit.byId("splnSelect").value;
                            var srchDate = dojo.byId("searchDate").value;

                            /* Set the default values. */
                            if (pincode.length == 0) pincode = 0;
                            if (spln.length == 0) spln = -1;

                            /* Compose the path info. */
                            var pathInfo = "/srch/" + pincode +
                                           "/" + spln +
                                           "/" + srchDate;

                            srchDlg.set("content", pathInfo +"<br>");
                            // srchDlg.show();

                            request.get("fetchdata.php" + pathInfo, {
                                handleAs: "json"
                            }).then(function(jsonData){
                                if (jsonData.type == "error")
                                {
                                    srchDlg.set("content", "Error Occurred: " + jsonData.msg);
                                    srchDlg.show();
                                }
                                else
                                {
                                    var newStore = new ItemFileWriteStore({
                                        data: {
                                            "identifier" : "id",
                                            "items" : jsonData.data
                                        }
                                    });

                                    var myGrid = dijit.byId("grid");
                                    myGrid.setStore(newStore);
                                }
                            });
                        }
                    }, "search").startup();
                }
            );

            require(['dojo/_base/lang',
                     'dojox/grid/DataGrid',
                     'dojo/data/ItemFileWriteStore',
                     'dojo/dom',
                     'dijit/Dialog',
                     "dojo/request",
                     "dojo/json",
                     "dojo/_base/array",
                     'dojo/domReady!'],
                function(lang, DataGrid, ItemFileWriteStore, dom, Dialog, request, json, arrayUtil){
                    var store = new ItemFileWriteStore({data: {
                        identifier : 'id',
                        items : [
                          { is: '--', id: "--", name: '--', edu: '--', spln: '--', state: '--'}
                        ]
                    }});

                    /*set up layout*/
                    var layout = [[
                      {'name': 'Name', 'field': 'name', 'width': '200px'},
                      {'name': 'Education', 'field': 'edu', 'width': '175px'},
                      {'name': 'Specialization', 'field': 'spln', 'width': '170px'},
                      {'name': 'Location', 'field': 'state', 'width': '125px'}
                    ]];

                    /*create a new grid*/
                    var grid = new DataGrid({
                        id: 'grid',
                        store: store,
                        structure: layout,
                        rowSelector: '20px',
                        autoWidth: true,
                        autoHeight: true
                    });

                        /*append the new grid to the div*/
                        grid.placeAt("gridDiv");

                        /*Call startup() to render the grid*/
                        grid.startup();
                        
                     // Our grid is stored in a variable called "grid":
                        grid.on("RowClick", function(evt){
                            var idx = evt.rowIndex;
                            var rowData = grid.getItem(idx);
                            // The rowData is returned in an object, last is the last name, first is the first name

                            /* Compose the URL. */
                            var url = "fetchdata.php";

                            if (rowData.is == "M") url += "/hi";
                            if (rowData.is == "D") url += "/di";
                            url += "/" + rowData.id;

                            
                            var addrInfo = new Dialog({
                                title: 'Row info',
                                style: 'width: 400px',
                                content: "Fetching address of the selected row..."
                            });

                            request.get(url, {
                                handleAs: "json"
                            }).then(function(jsonData){
                                var addrMsg = new Dialog({
                                    title: 'Row info',
                                    style: 'width: 400px',
                                    content: "URL: " + JSON.stringfy(jsonData)
                                });
                                // addrMsg.set("content", JSON.stringfy(jsonData));
                                addrMsg.show();
                            }, function(error) {
                                addrInfo.set("content", "Error occurred: " + error);
                            });

                            addrInfo.show();
                        }, true);
            });

            /* Get the specialization list. */
            require(["dojo/dom", "dojo/request", "dojo/json",
                     "dojo/_base/array", "dojo/domReady!"],
                function(dom, request, JSON, arrayUtil){
                    // Results will be displayed in resultDiv
                    // var resultDiv = dom.byId("resultDiv");

                    // Request the JSON data from the server
                    request.get("fetchdata.php", {
                        // Parse data from JSON to a JavaScript object
                        handleAs: "json"
                    }).then(function(data){
                        // Display the data sent from the server
                        // resultDiv.innerHTML = "<p><code>" + JSON.stringify(data) + "</code></p>";
                        // Store the JSON into the variable.
                        splnList = data;
                        
                        populateCtrls();
                    },
                    function(error){
                        // Display the error returned
                        // resultDiv.innerHTML = error;
                    });
                }
            );

            function populateCtrls()
            {
                /* Set the drop for the specialization. */
                require([
                     "dojo/store/Memory", "dijit/form/FilteringSelect",
                     "dijit/registry", "dojo/domReady!"
                 ], function(Memory, FilteringSelect, registry){
                     var splnStore = new Memory({
                         data : splnList
                     });

                     filteringSelect = new FilteringSelect({
                         id: "splnSelect",
                         name: "spln",
                         value: "AL",
                         store: splnStore,
                         searchAttr: "name"
                     }, "splnSelect").startup();
                 });
            } /* End of function: populateCtrls() */

        </script>
	</head>
	<body class="claro">
        <p>
            <h1>Mediclopedia: Search for Medical Help</h1>
        </p>
		<p>
            In order to get the list doctors or medical centres, provide the
            filter options like PIN Code, Specialization and/or date when you
            would like to seek the appointment.<br/><br/>
            The doctor's address, contact and availability information can be
            obtained upon clicking the doctor/medical centre row.
        </p>
		<div id="resultDiv"></div>
        <div style="float: left; margin-right: 20px">
            <button id="search" name="search" type="button"></button>
            <br/>
            <label for="pincode">6-Digit Pincode only.</label>
            <br/>
            <input type="text" id="pincode" name="pincode" value="" required="true"
                data-dojo-type="dijit/form/ValidationTextBox"
                data-dojo-props="placeHolder: 'enter PIN code', regExp:'\\d{6}', invalidMessage:'Invalid PIN code.'" />

            <hr/>
            Specialization<br/>
            <input name="splnSelect" id="splnSelect"/><br/>
            <hr/>
            Select a date<br/>
            <div data-dojo-type="dijit/Calendar">
                <script type="dojo/method" data-dojo-event="onChange" data-dojo-args="value">
                    require(["dojo/dom", "dojo/date/locale"], function(dom, locale){
                        dom.byId('searchDate').value = locale.format(value, {datePattern: 'yyyy-MM-dd', selector:'date'});
                    });
                </script>
            </div>
            <em>You selected:</em>
            <input type="text" disabled="disabled" name="searchDate" size="12" id="searchDate">
        </div>
        <div>
            <div id="gridDiv">
                <div id="results" class="results"></div>
            </div>
        </div>
	</body>
</html>
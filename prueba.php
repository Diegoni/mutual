<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>jQuery UI Autocomplete - Custom data and display</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <style>
  #project-label {
    display: block;
    font-weight: bold;
    margin-bottom: 1em;
  }
  #project-icon {
    float: left;
    height: 32px;
    width: 32px;
  }
  #project-description {
    margin: 0;
    padding: 0;
  }
  </style>
  <script>
  $(function() {
    var projects = [
      {
        value: "jquery",
        desc: "the write less, do more, JavaScript library"

      },
      {
        value: "jquery-ui",
        desc: "the official user interface library for jQuery"
      },
      {
        value: "sizzlejs",
        desc: "a pure-JavaScript CSS selector engine"
      }
    ];
 
    $( "#project" ).autocomplete({
      minLength: 0,
      source: projects,
      focus: function( event, ui ) {
        $( "#project" ).val( ui.item.label );
        return false;
      },
     
    })
    .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
        .appendTo( ul );
    };
  });
  </script>
</head>
<body>
 
<div id="project-label">Select a project (type "j" for a start):</div>
<img id="project-icon" src="images/transparent_1x1.png" class="ui-state-default" alt="" />
<input id="project" />
<input type="hidden" id="project-id" />
<p id="project-description"></p>
 
 
</body>
</html>
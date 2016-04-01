 <script>
  $(function() {
    var availableTags = [
      <?php include 'commaCities.php'; ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  </script>
</head>
<body>
 
 <form action="readWeatherData.php" method="get">
  <div class="ui-widget">
    <label for="tags">Search: </label>
    <input id="tags" name="c">
  </div>
  <input type="submit" value="Go" />
</form>
 
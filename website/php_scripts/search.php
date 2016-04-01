 <script>
  $(function() {
    var availableTags = [
      <?php include dirname(__DIR__).'/php_scripts/commaCities.php'; ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  </script>

 <form action="readWeatherData.php" method="get">
  <div class="ui-widget">
    <label for="tags">Search: </label>
    <input id="tags" name="c">
  </div>
  <input type="submit" value="Go" />
</form>
 
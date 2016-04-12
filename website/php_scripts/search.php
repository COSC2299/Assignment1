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

 <form action="city.php" method="get">
  <div class="ui-widget">
    <label for="tags">Search: </label>
    <input id="tags" name="c">
    <input type="submit" value="Go" />
  </div>
</form>
 
 <script>
  $(function() {
    var availableTags = [
      <?php include dirname(__DIR__).'/php_scripts/commaCities.php'; ?>
    ];
    $( "#searchTags" ).autocomplete({
      source: availableTags
    });
  });
  </script>

 <form action="city.php" method="get">
  <div class="ui-widget">
    <p><input id="searchTags" name="c"></p>
    <p><input type="submit" value="Search"></p>
  </div>
</form>
 
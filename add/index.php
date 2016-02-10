<!doctype html>
<html>
  <head>
    <title>Shorten the URL</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- load MUI -->
    <link href="//cdn.muicss.com/mui-0.1.18/css/mui.min.css" rel="stylesheet" type="text/css" />
    <script src="//cdn.muicss.com/mui-0.1.18/js/mui.min.js"></script>
    <link href="custom.css" rel="stylesheet" type="text/css" />

    <script src="//code.jquery.com/jquery-latest.js"></script> <!-- load jquery via CDN -->
    <script>
        $(document).ready(function() {//start document ready
            $('.mui-btn').click(function (e){
            e.preventDefault();

            $.ajax({
                type: 'GET',
                url: 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/shorten.php?url=' + encodeURIComponent($("#url").val()) + '&s=1',
                success: function(d){
                    if (d.indexOf(" ") > -1) {
                      $("#result1").val(d);
                      $("#result2").val(d);
                      $("#result3").val(d);
                      $("#result4").val(d);
                      $("#result5").val(d);
                    } else {
                      $("#result1").val('http://clop.xyz/' + d);
                      $("#result2").val('http://brony.xyz/' + d);
                      $("#result3").val('http://bronies.xyz/' + d);
                      $("#result4").val('http://ponies.xyz/' + d);
                      $("#result5").val('http://nlr.pw/' + d);
                    }
                }
            });
        });
      });//end document ready
    </script>


  </head>
  <body>
    <div class="mui-container">
      <div class="mui-panel">
        <h1>Shorten the URL</h1>
        <form>
          <div class="mui-form-group">
            <input type="url" class="mui-form-control" id="url" required>
            <label class="mui-form-floating-label">URL to shorten</label>
          </div>
          <button type="submit" class="mui-btn mui-btn-default mui-btn-raised">Submit</button>
        </form>
        <form class="mui-form-inline">
         <input type="text" class="mui-form-control" id="result1" value="http://clop.xyz/">
         <input type="text" class="mui-form-control" id="result2" value="http://brony.xyz/">
         <input type="text" class="mui-form-control" id="result3" value="http://bronies.xyz/">
         <input type="text" class="mui-form-control" id="result4" value="http://ponies.xyz/">
         <input type="text" class="mui-form-control" id="result5" value="http://nlr.pw/">
        </form>
      </div>
      <div class="mui-panel">
        <h2>API</h2>
        <p>Replace <code><u>[url]</u></code> with your long URL.</p>
        <p>
          Returns the short URL from the domain:
          <div class="highlight"><pre><code>http://<?php echo $_SERVER['HTTP_HOST']; ?>/shorten.php?url=<u>[url]</u></code></pre></div>
        </p>
        <p>
          Returns only the slug:
          <div class="highlight"><pre><code>http://<?php echo $_SERVER['HTTP_HOST']; ?>/shorten.php?<b>s&</b>url=<u>[url]</u></code></pre></div>
        </p>
      </div>
    </div>
  </body>
</html>

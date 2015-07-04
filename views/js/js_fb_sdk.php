<?php
// use cronnos\helpers\Arr;
// $s = Arr::get($_SESSION, 'params', '');
?>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '',
            xfbml      : true,
            version    : 'v2.3'
        });
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function shareBtn() {
        FB.ui({
          method: 'share',
          href: 'http://event.yam.com/find21bear'
      }, function(response){
          console.log(response);
      });
    }
</script>

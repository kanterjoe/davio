<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/26/17
 * Time: 2:09 PM
 */
/** @var STRING $other_js string to include other javascript after BS and JQuery*/
$other_js = (isset($other_js)? $other_js:"");


?>

</div>




<!-- jQuery first, then Tether, then Bootstrap JS. -->

<script src="/js/jquery.js"></script>
<script src="/js/tether.js"></script>
<script src="/js/bootstrap.min.js"></script>
<?php echo $other_js;?>

</html>


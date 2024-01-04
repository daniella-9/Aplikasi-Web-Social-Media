<?php
if(isset($_SESSION['error'])) :
    $error = $_SESSION['error'];
?>

<script>
    alert("<?= $error ?>");
</script>

<?php 
    unset($_SESSION['error']);
endif;
?>
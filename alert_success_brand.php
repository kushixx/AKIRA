 <?php
    if(isset($_SESSION['alert-success-brand'])):
 ?>
 
 
    <div class="alert alert-success  alert-dismissible fade  show d-flex justify-content-center" role="alert">
            <strong>Success!</strong>&nbsp;&nbsp;<?= $_SESSION['alert-success-brand'];?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>


<?php
 unset($_SESSION['alert-success-brand']);
    endif;
?>
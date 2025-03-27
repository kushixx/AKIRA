 <?php
    if(isset($_SESSION['message'])):
 ?>
 
 
    <div class="alert alert-success pr-0 pl-0 alert-dismissible fade  show d-flex justify-content-center" role="alert">
            <strong>Success!</strong>&nbsp;&nbsp;<?= $_SESSION['message'];?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>


<?php
 unset($_SESSION['message']);
    endif;
?>
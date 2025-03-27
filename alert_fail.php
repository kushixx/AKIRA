 <?php
    if(isset($_SESSION['alert-fail'])):
 ?>
 
 
    <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-center" role="alert">
            <?= $_SESSION['alert-fail'];?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>


<?php
 unset($_SESSION['alert-fail']);
    endif;
?>
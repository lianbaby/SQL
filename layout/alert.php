<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/layout/link_css.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/layout/scripts.php";

    $msg = $_GET['msg'] ?? null;
    $type = $_GET['msg_type'] ?? null;
?>
<style>
    .alert {
        position: fixed; 
        top: 10px; 
        right: 10px; 
        min-width: 150px; 
        width: auto;
    }
    .alert button.close {
        height: 100%;
        line-height: 1.5rem;
    }
</style>
<?php if ($type === 'info' && $msg): ?>
    <div class="alert alert-dismissible alert-primary show fade" role="alert">
        <?= $msg ?>
        <button type="button" class="pr-3 pl-2 close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if ($type === 'success' && $msg): ?>
    <div class="alert alert-dismissible alert-success show fade" role="alert">
        <?= $msg ?>
        <button type="button" class="pr-3 pl-2 close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if ($type === 'error' && $msg): ?>
    <div class="alert alert-dismissible alert-danger show fade" role="alert">
        <?= $msg ?>
        <button type="button" class="pr-3 pl-2 close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if ($type === 'waring' && $msg): ?>
    <div class="alert alert-dismissible alert-warning show fade" role="alert">
        <?= $msg ?>
        <button type="button" class="pr-3 pl-2 close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
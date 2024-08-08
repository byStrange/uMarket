<?php

/** @var string $message */

?>


<div class="modal-body text-center" data-id="<?= isset($id) ? $id : '' ?>" data-action="<?= isset($action) ? $action : '' ?>">
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button>
  <div class="tt-modal-messages">
    <i class="pe-7s-check"></i> <?= $message ?>
  </div>
</div>

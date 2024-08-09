<?php

/** @var string $message */
/** @var array $dataAttributes */
?>

<div class="modal-body text-center"
  <?php if (isset($dataAttributes)): ?>
  <?php foreach ($dataAttributes as $name => $value): ?>
  data-<?= htmlspecialchars($name) ?>="<?= htmlspecialchars($value) ?>"
  <?php endforeach; ?>
  <?php endif ?>>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
    <i class="pe-7s-close"></i>
  </button>
  <div class="tt-modal-messages">
    <i class="pe-7s-check"></i> <?= htmlspecialchars($message) ?>
  </div>
</div>

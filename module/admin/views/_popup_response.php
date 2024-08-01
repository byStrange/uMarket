<?php
/*var_dump($model->id);*/
?>

<script data-model-data='{"id": "<?= $model->id ?>", "repr": "<?= strval(
    $model
) ?>" }'>
opener.fire(window, "<?= $model->id ?>",  "<?= strval($model) ?>")
</script>

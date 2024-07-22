<?php
use yii\bootstrap5\Button;

?>

<div class="admin-default-index">
 <?php


 echo Button::widget([
    'label' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM64 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L96 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>',
    'encodeLabel' => false, // Adjust icon class as needed
    'options' => [
        'class' => 'btn  p-1 btn-light navbar-toggler',
        'type' => 'button',
        'data-bs-toggle' => 'offcanvas',
        'data-bs-target' => '#sidebar-offcanvas', // Use the same ID from Offcanvas
    ],
]);

 ?>   
 <h1>Welcome to admin panel</h1>
    <p>Open menu, and navigate to one of the pages</p>
</div>

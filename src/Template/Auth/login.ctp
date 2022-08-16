<?php
/**
* @var \App\View\AppView $this
 */
?>

<div class="wrapper fadeInDown">
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <!-- Login Form -->
                    <?= $this->Form->create(); ?>

                    <?= $this->Form->control('username', ['class' => 'form-control mb-3']); ?>
                    <?= $this->Form->control('password', ['class' => 'form-control mb-3', 'type' => 'password']); ?>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

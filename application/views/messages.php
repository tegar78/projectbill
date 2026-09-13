<?php
$msg_success = $this->session->flashdata('success');
if (!empty($msg_success)) {
    unset($_SESSION['success'], $_SESSION['__ci_vars']['success']);
?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-check"></i> <?= $msg_success; ?>
    </div>
<?php } ?>

<?php
$msg_success_payment = $this->session->flashdata('success-payment');
if (!empty($msg_success_payment)) {
    unset($_SESSION['success-payment'], $_SESSION['__ci_vars']['success-payment']);
?>
    <script>
        Swal.fire({
            icon: 'success',
            html: '<?= $msg_success_payment; ?>',
            showConfirmButton: true,
        })
    </script>
<?php } ?>

<?php
$msg_success_sendsms = $this->session->flashdata('success-sendsms');
if (!empty($msg_success_sendsms)) {
    unset($_SESSION['success-sendsms'], $_SESSION['__ci_vars']['success-sendsms']);
?>
    <script>
        Swal.fire({
            icon: 'success',
            html: '<?= $msg_success_sendsms; ?>',
            showConfirmButton: true,
        })
    </script>
<?php } ?>

<?php
$msg_error_sendsms = $this->session->flashdata('error-sendsms');
if (!empty($msg_error_sendsms)) {
    unset($_SESSION['error-sendsms'], $_SESSION['__ci_vars']['error-sendsms']);
?>
    <script>
        Swal.fire({
            icon: 'error',
            html: '<?= $msg_error_sendsms; ?>',
            showConfirmButton: true,
        })
    </script>
<?php } ?>

<?php
$msg_error = $this->session->flashdata('error');
if (!empty($msg_error)) {
    unset($_SESSION['error'], $_SESSION['__ci_vars']['error']);
?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-ban"></i> <?= $msg_error; ?>
    </div>
<?php } ?>

<?php
$msg_success_sweet = $this->session->flashdata('success-sweet');
if (!empty($msg_success_sweet)) {
    unset($_SESSION['success-sweet'], $_SESSION['__ci_vars']['success-sweet']);
?>
    <script>
        Swal.fire({
            icon: 'success',
            html: '<?= $msg_success_sweet; ?>',
            showConfirmButton: true,
        })
    </script>
<?php } ?>

<?php
$msg_error_sweet = $this->session->flashdata('error-sweet');
if (!empty($msg_error_sweet)) {
    unset($_SESSION['error-sweet'], $_SESSION['__ci_vars']['error-sweet']);
?>
    <script>
        Swal.fire({
            icon: 'error',
            html: '<?= $msg_error_sweet; ?>',
            showConfirmButton: true,
        })
    </script>
<?php } ?>
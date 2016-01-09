<?php
    $this->load_fragment('auth/form_header', ['heading' => 'Register' ]);
?>
<?php if ($sent): ?>
    <div class="success">Mail sent.</div>
<?php else: ?>
<form action="register_email/" method="post" class="pure-form pure-form-stacked">
    <fieldset>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br/>
        <input type="submit" name="register" value="Next" class="pure-button pure-button-primary">
    </fieldset>
</form>
<?php endif; ?>
<?php $this->load_fragment('auth/form_footer'); ?>

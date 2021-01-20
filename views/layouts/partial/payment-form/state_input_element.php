<?php
/**
 * @var string $value
 */
?>

<input class="input-field js-user-state"
       id="state"
       name="User[state]"
       maxlength="50"
       placeholder="State / County"
       type="text"
       value="<?= $value ?? '' ?>"
>
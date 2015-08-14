<form action="/subscriber/update" method="post">
    <input type="text" name="list_id" value="<?php echo $list_id; ?>">
    <input type="text" name="email" value="<?php echo $email; ?>">
    <input type="text" name="status" value="subscribed">
    <button type="submit">Subscribe</button>
</form>
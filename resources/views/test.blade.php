<h1>hello world</h1>

<?php echo URL::temporarySignedRoute('test.show',now()->addSeconds(5),['title'=>14]);?>


<h3>test link</h3>
<a href="<?php echo URL::temporarySignedRoute('test.show',now()->addSeconds(5),['title'=>14]);?>">link</a>
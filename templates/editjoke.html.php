<?php if ($userId == $joke['author_id'] || empty($joke)): ?>
<form action="" method="post">
	<input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? ''?>">
	<label for="joke[text]">A vicc szövege:</label>
	<textarea id="text" name="joke[text]" rows="3" cols="40"><?=$joke['text'] ?? ''?></textarea>
	<input type="submit" name="submit" value="Küldés">
</form>
<?php else: ?>
<p>Csak az általad feltöltött vicceket szerkesztheted.</p>
<?php endif; ?>
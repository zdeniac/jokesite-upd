<form action="" method="post">
	<input type="hidden" name="id" value="<?=$joke['id']?>">
	<label for="text">A vicc szövege:</label>
	<textarea id="text" name="text" rows="3" cols="40"><?=$joke['text']?></textarea>
	<input type="submit" name="submit" value="Küldés">
</form>
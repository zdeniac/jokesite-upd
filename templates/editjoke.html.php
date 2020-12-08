<form action="" method="post">
	<input type="hidden" name="id" value="<?=$joke['id']?>">
	<label for="joketext">A vicc szövege:</label>
	<textarea id="joketext" name="joketext" rows="3" cols="40"><?=$joke['text']?></textarea>
	<input type="submit" name="submit" value="Küldés">
</form>
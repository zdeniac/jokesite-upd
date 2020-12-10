<p>Összesen <?=$countJokes?> vicc szerepel az adatbázisban</p>
<?php foreach ($jokes as $joke): ?>
<blockquote>
	<?=htmlspecialchars($joke['text'], ENT_QUOTES, 'UTF-8')?>
	<p>
		A viccet feltöltötte:
		<a href="mailto:<?=htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8')?>">
			<?=htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8')?>
		</a>
		<?php
			$date = new DateTime($joke['date']);
		?>
		(<time><?=$date->format('Y.m.d. H:i')?></time>)
	</p>
	<p>
		<a href="editjoke.php?id=<?=$joke['id']?>">Szerkesztés</a>
		<form action="deletejoke.php" method="post">
			<input type="hidden" name="id" value="<?=$joke['id']?>">
			<input type="submit" value="Törlés">
		</form>
	</p>
</blockquote>
<?php endforeach; ?>
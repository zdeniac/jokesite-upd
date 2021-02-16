<input type="text" id="joke_search" placeholder="Keresés a vicc szövegében">
<p>Összesen <?=$countJokes?> vicc szerepel az adatbázisban:</p>
<br>
<div id="jokes">
<?php if (!empty($jokes)): ?>
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
	<?php if ($userId == $joke['author_id']): ?>
		<p>
			<a href="/novice_to_ninja/joke/edit?id=<?=$joke['id']?>">Szerkesztés</a>
			<form action="/novice_to_ninja/joke/delete" method="post">
				<input type="hidden" name="id" value="<?=$joke['id']?>">
				<input type="submit" value="Törlés">
			</form>
		</p>
	<?php endif; ?>
	</blockquote>
	<br>
	<?php endforeach; ?>
<?php else: ?>
	<p>Nincsenek rekordok.</p>
<?php endif; ?>
</div>
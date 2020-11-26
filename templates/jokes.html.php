<?php foreach ($jokes as $joke): ?>
<blockquote>
	<p>
		<?=htmlspecialchars($joke['text'], ENT_QUOTES, 'UTF-8')?>
		<span>
			<a href="mailto:<?=htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8')?>">
			<?=htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8')?>
			</a>
		</span>
		<form action="deletejoke.php" method="post">
			<input type="hidden" name="id" value="<?=$joke['id']?>">
			<input type="submit" value="Törlés">
		</form>
	</p>
</blockquote>
<?php endforeach; ?>
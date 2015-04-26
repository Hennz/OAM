<form action= <?php echo(BASE_URL); ?>/home/test method="post">
	<select name="coc[]" multiple>
	  <option value="volvo">Volvo</option>
	  <option value="saab">Saab</option>
	  <option value="opel">Opel</option>
	  <option value="audi">Audi</option>
	</select>
	<input type="submit" name="send" />
</form>
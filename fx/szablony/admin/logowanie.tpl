{* Strona logowania *}
{* plik: logowanie.tpl *}

<h1>Logowanie</h1>
<p>Aby uzyskaæ dostêp do panelu administracyjnego gazety nale¿y zalogowaæ siê, korzystaj±æ z poni¿szego formularza.</p>
<form method="post" action="index.php">
	<fieldset class="login">
		<legend>Logowanie</legend>
		<div>
			<label for="login">Identyfikator uzytkownika:</label>
			<input type="text" name="login" size="16" maxlength="16" value="" />
		</div>        

		<div>
			<label for="haslo">Haslo uzytkownika:</label>
			<input type="password" name="haslo" size="16" maxlength="16" value="" />
		</div>              
    {if $status.bledyFormularza}    
      <ul class="bledy">
        {foreach from=$status.bledyFormularza key=pole item=blad}
          <li>{$blad}</li>
        {/foreach}        
      </ul>                    
    {/if}		    
		<div>
		  <input type="submit" id="przycisk" name="przycisk" value="Zaloguj siê &raquo;" />
			<input type="hidden" name="wyslij" value="1" />
		</div>
	</fieldset>
</form>

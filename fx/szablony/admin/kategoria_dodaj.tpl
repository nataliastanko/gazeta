{* Formularz dodawania kategorii *}
{* plik: kategoria_dodaj.tpl *}

<form method="post" action="kategorie.php">
  <fieldset>
    <legend>Dodaj now± kategoriê</legend>
    <div>
      <label for="nazwa">Nazwa kategorii</label>
      <input type="text" name="nazwa" value="{$daneFormularza.nazwa}" id="nazwa"/>
    </div>                                                
    {if $status.bledyFormularza}    
      <ul class="bledy">
        {foreach from=$status.bledyFormularza key=pole item=blad}
          <li><strong>{$pole}:</strong> {$blad}</li>
        {/foreach}        
      </ul>                    
    {/if}
    <div>
      <input type="submit" name="dodaj" value="Dodaj kategoriê" id="dodaj"/>
    </div>
  </fieldset>
</form>
{* Formularz edycji kategorii *}
{* plik: kategoria_edytuj.tpl *}


<form method="post" action="kategorie.php">
  <fieldset>
    <legend>Zmie� istniej�c� kategori�</legend>
    <div>
      <label for="nazwa">Nazwa kategorii</label>
      <input type="text" name="nazwa" value="{$kategoria.nazwa}" id="nazwa"/>
    </div> 
    {if $status.bledyFormularza}    
      <ul class="bledy">
        {foreach from=$status.bledyFormularza key=pole item=blad}
          <li><strong>{$pole}:</strong> {$blad}</li>
        {/foreach}        
      </ul>                    
    {/if}
    <div>   
      <input type="hidden" name="id_kat" value="{$kategoria.id_kat}" id="id_kat"/>
      <input type="submit" name="edytuj" value="Zmie� kategori�" id="edytuj"/>
    </div>
  </fieldset>
</form>
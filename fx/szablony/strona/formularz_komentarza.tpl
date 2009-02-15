{* Formularz dodawania komentarzy *}
{* plik: formularz_komentarza.tpl *}

<form method="post" action="index.php?artykul={$artykul.id_art}#komentarze" class="komentarz">
  <fieldset>
    <legend>Dodaj w³asny komentarz</legend>
    
    <div>
      <label for="podpis">Twój podpis</label>
      <input type="text" class="text" name="podpis" id="podpis" value="{$daneFormularza.podpis}" />
    </div>                                                                 
    
    <div>
      <label for="email">Twój adres email</label>
      <input type="text" class="text" name="email" id="email" value="{$daneFormularza.email}" />
    </div>                                                                 
    
    <div>
      <label for="tresc">Tre¶æ komentarza</label>
      <textarea name="tresc" id="tresc" cols="40" rows="10">{$daneFormularza.tresc}</textarea>
    </div> 
    
    {if $status.bledyFormularza}    
      <ul class="bledy">
        {foreach from=$status.bledyFormularza key=pole item=blad}
          <li><strong>{$pole}:</strong> {$blad}</li>
        {/foreach}        
      </ul>                    
    {/if}                                                                
    
    <input type="submit" name="dodaj_komentarz" value="Dodaj komentarz"/>
    <input type="hidden" name="id_art" value="{$artykul.id_art}"/>
    
  </fieldset>
</form>
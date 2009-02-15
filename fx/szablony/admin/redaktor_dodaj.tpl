{* Formularz dodawania redaktora *}
{* plik: redaktor_dodaj.tpl *}

<form method="post" action="redaktorzy.php">
  <fieldset>
    <legend>Dodaj redaktora</legend>
    <div>
      <label for="login">Login:</label>
      <input type="text" name="login" value="{$daneFormularza.login}" id="login"/>
    </div>      
    <div>
      <label for="haslo">Has³o:</label>
      <input type="password" name="haslo" value="" id="haslo"/>
    </div>
    <div>
      <label for="email">Email:</label>
      <input type="text" name="email" value="{$daneFormularza.email}" id="email"/>
    </div>                                              
    <div> 
      <label for="bio">Nota biograficzna:</label>
      <textarea name="bio" rows="8" cols="40">{$daneFormularza.bio}</textarea>
    </div>    
    {if $status.bledyFormularza}    
      <ul class="bledy">
        {foreach from=$status.bledyFormularza key=pole item=blad}
          <li><strong>{$pole}:</strong> {$blad}</li>
        {/foreach}        
      </ul>                    
    {/if}    
    <div>
      <input type="submit" name="dodaj" value="Dodaj redaktora" id="dodaj"/>
    </div>
  </fieldset>
</form>

{* Formularz edycji redaktora *}
{* plik: redaktor_edytuj.tpl *}

<form method="post" action="redaktorzy.php">
  <fieldset>
    <legend>Edytuj redaktora</legend>
    <div>
      <label for="login">Login:</label>
      <input type="text" name="login" value="{$redaktor.login}" id="login"/>
    </div>      
    <div>
      <label for="haslo">Nowe has³o:</label>
      <input type="password" name="haslo" value="" id="haslo"/>
    </div>
    <div>
      <label for="email">Email:</label>
      <input type="text" name="email" value="{$redaktor.email}" id="email"/>
    </div>                                              
    <div> 
      <label for="bio">Nota biograficzna:</label>
      <textarea name="bio" rows="8" cols="40">{$redaktor.bio}</textarea>
    </div>  

    <div>                                         
      <label for="bio">Administrator</label>
      <input type="checkbox" {if $redaktor.admin}checked="checked" {/if}name="admin" value="1" id="admin"/>
    </div>  

    {if $status.bledyFormularza}    
      <ul class="bledy">
        {foreach from=$status.bledyFormularza key=pole item=blad}
          <li><strong>{$pole}:</strong> {$blad}</li>
        {/foreach}        
      </ul>                    
    {/if}    
    <div>
      <input type="hidden" name="id_redaktor" value="{$redaktor.id_redaktor}" id="id_redaktor"/>      
      <input type="submit" name="edytuj" value="Zmieñ redaktora" id="edytuj"/>
    </div>
  </fieldset>
</form>

{* Wyswietla listê redaktorów *}
{* plik: redaktorzy.tpl *}

<h1>Zarz±dzanie redaktorami</h1>
<div class="akcje">
  <a href="redaktorzy.php?akcja=dodaj">Dodaj redaktora</a>
</div>

<h2>Lista redaktorów</h2>
<table class="admin">
  <thead>
    <tr>
      <th class="id">Id</th>
      <th>Login</th>
      <th>Email</th>
      <th>Data do³±czenia</th>
      <th>Nota biograficzna</th>
      <th>Administrator</th>
      <th>Usuniêty</th>
      <th>Akcje</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$redaktorzy item=redaktor}  
    {if $redaktor.usuniety}
      <tr class="usuniety">
    {else}
      <tr>
    {/if}
        <td>{$redaktor.id_redaktor}</td>
        <td>{$redaktor.login}</td>
        <td>{$redaktor.email}</td>
        <td>{$redaktor.data_dolaczenia}</td>
        <td>{$redaktor.bio}</td> 
        <td>{if $redaktor.admin }TAK{else}NIE{/if}</td>
        <td>{if $redaktor.usuniety }TAK{else}NIE{/if}</td>
        <td>
          {if not $redaktor.usuniety}
            <a href="redaktorzy.php?akcja=edytuj&amp;id_redaktor={$redaktor.id_redaktor}">Edycja</a>  
            {if $redaktor.id_redaktor != $uzytkownik.id_redaktor}
             | <a href="redaktorzy.php?akcja=usun&amp;id_redaktor={$redaktor.id_redaktor}" onclick="return confirm('Czy na pewno chcesz usun±æ redaktora?');">Usuñ</a>          
            {/if}
          {else}
            <a href="redaktorzy.php?akcja=przywroc&amp;id_redaktor={$redaktor.id_redaktor}" onclick="return confirm('Czy na pewno chcesz przywróciæ redaktora?');">Przywróæ</a>                      
          {/if}
        </td>        
      </tr>
    {/foreach}
  </tbody>
</table>

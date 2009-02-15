{* wy¶wietlanie listy kategorii *}
{* plik: kategorie.tpl *}

<h1>Zarz±dzanie kategoriami</h1>

<div class="akcje">
  <a href="kategorie.php?akcja=dodaj">Dodaj now± kategoriê</a>
</div>

<table class="admin">
  <thead>
    <tr>
      <th class="id">Id</th>
      <th>Nazwa</th>
      <th>Akcje</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$kategorie key=id item=nazwa}
      <tr>
        <td>{$id}</td>
        <td>{$nazwa}</td>
        <td>
          <a href="kategorie.php?akcja=edytuj&amp;id_kat={$id}">Edycja</a> |  
          <a href="kategorie.php?akcja=usun&amp;id_kat={$id}" onclick="return confirm('Czy jeste¶ pewny');">Usuñ</a>
        </td>        
      </tr>
    {/foreach}
  </tbody>
</table>

{* Wy¶wietlanie listy komentarzy *}
{* plik: komentarze.tpl *}

<h1>Moderacja komentarzy</h1>
<p>Poni¿sze zestawienie umo¿liwia usuwanie komentarzy</p>
<table class="admin">
  <thead>
    <tr>
      <th>Id</th>
      <th>Podpis</th>
      <th>Email</th>
      <th>Tresc</th>
      <th>Data</th>
      <th>Akcje</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$komentarze item=kom}
      <tr>
        <td>{$kom.id_kom}</td>
        <td>{$kom.podpis}</td>
        <td>{$kom.email}</td>
        <td>{$kom.tresc}</td>
        <td>{$kom.data_kom}</td>
        <td>
          <a href="komentarze.php?akcja=usun&amp;id_kom={$kom.id_kom}" onclick="return confirm('Czy jeste¶ pewny');">Usuñ</a>
        </td>        
      </tr>
    {foreachelse}
      <tr>
        <td colspan="6">Brak komentarzy do moderacji</td>
      </tr>
    {/foreach}
  </tbody>
</table>

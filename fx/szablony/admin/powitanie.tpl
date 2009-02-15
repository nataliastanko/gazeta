{* Strona powitania w panelu admina *}
{* plik: artykul_dodaj.tpl *}

<h1>Witaj w panelu {if $uzytkownik.admin} administratora {else} redaktora {/if}</h1>
<p>Zalogowany jako: {$uzytkownik.login}</p>       

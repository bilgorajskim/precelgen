<!DOCTYPE HTML><html><head>{$head}<link rel="stylesheet" href="style.css" type="text/css" /></head><body>{$body}<div class="warp27"><div class="head90"><h1>{$h1}</h1><h3>{$h2}</h3></div><div class="g"><div class="menu"><h2 class="s">Menu</h2><ul>{foreach item=link from=$menu}<li><a href="{$link.link}">{$link.etykieta}</a></li>{/foreach}</ul></div><div class="content">{foreach from=$teksty item=tekst}<h2>{$tekst.tytul}</h2><p>{$tekst.tresc}</p>{/foreach}{if $nastepna_strona}<a href="{$nastepna_strona}" id="next_button">Następna strona</a>{/if}</div></div></div></body></html>
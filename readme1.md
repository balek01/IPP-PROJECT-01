# Implementační dokumentace k 1. úloze do IPP 2022/2023
Jméno a příjmení: Miroslav Bálek

Login: xbalek02
 

### Lexikální a syntaktická analýza
Skript parse.php čte vstup ze standartního vstupu po řádcích. Následně je vstup upraven (odstranění komentářů, nahrazení speciálních znaků). 
Analýza se provádí v PHP souboru assert.php, kde se na základě operačního kódu a pomocí regulárních výrazů ověřuje zda čtený vstup je v souladu s pravidly jazyka IPPcode23.
Pokud není vstupní kód korektní, je skript ukončen a na chybový výstup je vypsán příslušný kód.
V případě, že je vstup analýzou vzhodnocen jako korektní, je ve formě XML vypsán na standartní výstup.   

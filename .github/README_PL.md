# Kolejka Górska

Aplikacja obsługuje podstawowy mechanizm działania kolejki górskiej za pośrednictwem API. Dane są zapisywane w pamięci Redis.

- ### [API](README_PL_API.md)
- ### [Tryb produkcyjny/deweloperski](README_PL_PROD_DEV.md)
- ### [Symulacja](README_PL_SIM.md)

### Instalacja aplikacji

Instalacja projektu:
- w katalogu `project-root`, przekopiuj plik `env` z nazwą `.env` lub użyj komendy `cp project-root/env project-root/.env`
- uruchom komendę `docker-compose up -d`, pobiera i konfiguruje kontenery potrzebne do działania
- następnie `docker-compose exec php bash`, za jej pomocą dostajesz się do kontenera
- w kontenerze `composer install`, instaluje brakujący kod

I to już wszystko! Masz działający projekt kolejki górskiej. Sprawdź czy działa i odwiedź stronę [localhost](http://localhost/#).</br>
Polecam się teraz zapoznać z wypisanymi w spisie treści dostępnymi funkcjonalnościami.</br>
\* pamiętaj o tym, że niektóre przeglądarki jak np. Google Chrome blokują domeny http, w takim wypadku musisz zezwolić na działanie localhost w ustawieniach

### Redis
Wejście do kontenera `docker-compose exec redis bash`:
- wyczyszczenie pamięci `redis-cli flushall`
- wybranie bazy danych `redis-cli -n 0` lub `redis-cli -n 1`
- pobranie danych dla kolejki `get coaster:1`
- pobranie listy dostępnych kolejek `scan 0 MATCH *coaster*`

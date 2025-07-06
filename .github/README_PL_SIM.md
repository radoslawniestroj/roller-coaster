# Symulacja programu

## Uruchomienie
- `docker-compose exec php bash`
- `php spark monitor:coasters`

## Opis działania
System na bieżąco analizuje możliwości operacyjne zaimplementowanych kolejek górskich. Prezentuje aktualne dane oraz raportuje
ewentualne nieprawidłowości. Wszystkie informacje są aktualizowane w czasie rzeczywistym.

## Przykład działania
```text
[Kolejka coaster:1]
    1. Godziny działania: 8:00 - 18:00
    2. Liczba wagonów:: 4
    3. Dostępny personel:: 12/9
    4. Klienci dziennie:: 3000
    5. Status: OK

[Kolejka coaster:2]
    1. Godziny działania: 9:00 - 17:00
    2. Liczba wagonów:: 6
    3. Dostępny personel:: 10/13
    4. Klienci dziennie:: 150
    5. Problem: Brakuje 3 pracowników | Zbyt duża moc przerobowa: nadmiar na 3510 klientów

[Kolejka coaster:3]
    1. Godziny działania: 8:00 - 18:00
    2. Liczba wagonów:: 0
    3. Dostępny personel:: 12/1
    4. Klienci dziennie:: 200
    5. Problem: Zbyt dużo personelu: nadmiar 11 | Brakuje wydajności: 200 klientów nie zostanie obsłużony
```

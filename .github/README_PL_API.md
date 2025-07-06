# Api
\* opisane zapytania są już uzupełnione o przykładowe dane

## Obsługa kolejek
### Utworzenie nowej kolejki
POST `{{domain}}/api/coasters`
```json
{
  "liczba_personelu": 12,
  "liczba_klientow": 200,
  "dl_trasy": 100,
  "godziny_od": "8:00",
  "godziny_do": "18:00"
}
```
</br>odpowiedź
```json
{
    "message": "Kolejka została utworzona.",
    "coaster_id": 1
}
```

### Modyfikacja kolejki
\* podczas modyfikacji kolejki nie można zmienić jej długości</br>
PUT `{{domain}}/api/coasters/:id`
```json
{
  "liczba_personelu": 10,
  "liczba_klientow": 250,
  "godziny_od": "7:00",
  "godziny_do": "19:00"
}
```
</br>odpowiedź
```json
{
    "message": "Kolejka została zmodyfikowana."
}
```


## Obsługa wagoników

### Dodanie wagonika do kolejki
POST `{{domain}}/api/coasters/:coasterId/wagons`
```json
{
  "ilosc_miejsc": 10,
  "predkosc_wagonu": 1.2
}
```
</br>odpowiedź
```json
{
  "message": "Wagon został utworzony.",
  "coaster_id": 1,
  "wagon_id": 1
}
```

### Usunięcie wagonu z kolejki
DELETE `{{domain}}/api/coasters/:coasterId/wagons/:wagonsId`
</br>odpowiedź
```json
{
  "message": "Wagon został usunięty."
}
```


## Status kolejki
GET `{{domain}}/api/coasters/:coasterId/status`
</br>odpowiedź
```json
{
  "godziny": "9:00 - 17:00",
  "wagonow": 6,
  "personel": "10/13",
  "klientow": 150,
  "pojemnosc": 3660,
  "problemy": [
    "Brakuje 3 pracowników",
    "Zbyt duża moc przerobowa: nadmiar na 3510 klientów"
  ]
}
```

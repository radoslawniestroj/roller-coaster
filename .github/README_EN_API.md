# Api
\* described requests are already filled with example data

## Coaster Management
### Creating a new coaster
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
</br>response
```json
{
    "message": "Kolejka została utworzona.",
    "coaster_id": 1
}
```

### Updating a coaster
\* the track length cannot be changed when editing a coaster
PUT `{{domain}}/api/coasters/:id`
```json
{
  "liczba_personelu": 10,
  "liczba_klientow": 250,
  "godziny_od": "7:00",
  "godziny_do": "19:00"
}
```
</br>response
```json
{
    "message": "Kolejka została zmodyfikowana."
}
```


## Wagon management

### Add a wagon to a coaster
POST `{{domain}}/api/coasters/:coasterId/wagons`
```json
{
  "ilosc_miejsc": 10,
  "predkosc_wagonu": 1.2
}
```
</br>response
```json
{
  "message": "Wagon został utworzony.",
  "coaster_id": 1,
  "wagon_id": 1
}
```

### Remove a wagon from a coaster
DELETE `{{domain}}/api/coasters/:coasterId/wagons/:wagonsId`
</br>response
```json
{
  "message": "Wagon został usunięty."
}
```


## Coaster Status
GET `{{domain}}/api/coasters/:coasterId/status`
</br>response
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

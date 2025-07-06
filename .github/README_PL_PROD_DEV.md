# Tryb produkcyjny/deweloperski

## Tryb produkcyjny

* komenda: `php spark env production`
* tryb używa bazy o nr `1`, zmiana ustawienia jest możliwa w linii `project-root/app/Libraries/RedisService.php:15`
* logowane są tylko błędy typu errors (`4`) oraz warnings (`5`), zmiana ustawienia jest możliwa w linii `project-root/app/Config/Logger.php:41`

## Tryb deweloperski

* komenda: `php spark env development`
* tryb używa bazy o nr `0`, zmiana ustawienia jest możliwa w linii `project-root/app/Libraries/RedisService.php:15`
* logowane są tylko błędy każdego typu (`9`), zmiana ustawienia jest możliwa w linii `project-root/app/Config/Logger.php:41`
* zostało dodane ograniczenie IP, które nie pozwala na zewnętrzny dostęp do serwisu w określonym trybie,
modyfikacja dostępnych IP jest możliwa w linii `project-root/app/Filters/DevAccessFilter.php:14`

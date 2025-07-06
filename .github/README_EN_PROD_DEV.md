# Production vs development

## Production Mode

* command: `php spark env production`
* uses Redis database number `1`, you can change this in `project-root/app/Libraries/RedisService.php:15`
* only error (`4`) and warning (`5`) logs are recorded, configuration can be changed in `project-root/app/Config/Logger.php:41`

## Development Mode

* command: `php spark env development`
* uses Redis database number `0`, you can change this in `project-root/app/Libraries/RedisService.php:15`
* all log levels (`9`) are recorded, configuration can be changed in `project-root/app/Config/Logger.php:41`
* IP restriction has been added to block external access to the service in this mode,
you can modify allowed IPs in `project-root/app/Filters/DevAccessFilter.php:14`

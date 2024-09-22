### How to run
- Install docker, docker compose
- `docker-compose up -d`
- `docker exec -it php-fpm /bin/bash`
    - `php artisan migrate --seed`
- Open http://localhost

### Refactor the WolfService
- `app/Http/Controllers/InventoryController.php`
- `app/Http/Services/ItemStrategyFactory.php`
- `app/Http/Services/InventoryService.php`
- `app/Http/Services/ItemStrategy/AppleAirPodsStrategy.php`
- `app/Http/Services/ItemStrategy/DefaultItemStrategy.php`
- `app/Http/Services/ItemStrategy/ItemStrategy.php`
- `app/Http/Services/ItemStrategy/SamsungGalaxyS23Strategy.php`
- `app/Http/Services/ItemStrategy/XiaomiRedmiNote13Strategy.php`

### How to run test import Items
- `php artisan items:import`

### How to run API upload image
- `curl --location 'localhost/api/items/1/upload-image' \
--header 'Content-Type: multipart/form-data' \
--header 'Authorization: Basic YWRtaW46cGFzc3dvcmQ=' \
--form 'image=@"postman-cloud:///1ef7898b-e13b-4760-8c3e-10f175528489"'`

Use Basic Middleware
- `username: admin`
- `password: password`

File collection 
- `NTest.postman_collection.json`

### How to run Unit test
- `php artisan test`

However, with test case `it_uploads_image_successfully` for UploadImage, I have a bug. I'm fixing it.
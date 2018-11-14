### FIRST TIME INSTALLERS
- download Python 2.7.11: [https://www.python.org/downloads/release/python-2710/]
- add python to PATH
- npm config set python python2.7
- npm config set msvs_version 2015 --global

### DO THIS AT THE START
```sh
composer update
npm install
bower install
gulp copy
php artisan migrate --seed 
```
### Remember these!

##### Sumo Autogen
- type in console to generate from database
```sh
php artisan sumo:generate
```
- autogen will NOT override files that already exists
- autogen controller (Http/Controllers/AutogenController)
- autogen templates (resources/views/autogen/*)


##### Query Debugging
- Debug and Die
```sh
$product = Product::findOrFail($id);
dd($product)
```

- echo db queries
```sh
// import DB object
use Illuminate\Support\Facades\DB;
```

```sh
// enable and display query log
DB::enableQueryLog(); 
$product = Product::findOrFail($id);
dd(DB::getQueryLog());
```

### FAQs
- API is auto-generated in /Http/Controllers/Api (need to copy paste routes)
- Pag may error sa seed at migrations na gawa ng ibang dev, try "composer dump-autoload"
- Use Factory to make fake values; can also be used in a Seeder
- If you are getting errors during node-sass installation install https://github.com/felixrieseberg/npm-windows-upgrade

<p align="center"><img width="250px" src="https://inspima.com/images/logo-i.png"></p>


## Sistem Antrian - Laboratorium

### Instalasi

1. Clone project ```git clone```
2. Install composer ```composer install```
3. Konfigurasi aplikasi
   - copy file env.example jadi .env
   - Sesuaikan dengan koneksi database
   - generate key ```php artisan key:generate```
   - update storage ```php artisan storage:link```

4. Install database
   - Migrasi database ``` php artisan migrate:fresh --seed``` 
   - Pastikan database sudah ada
5. Run Project ```php artisan serve```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

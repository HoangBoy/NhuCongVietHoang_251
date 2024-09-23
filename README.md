<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# laravel_ecommerce

1. Route Model Binding
2. Route::resource
```
Khi bạn sử dụng Route::resource('/carts', CartController::class)->middleware(['auth']);, Laravel sẽ tự động tạo ra 7 endpoints tương ứng với các hành động CRUD (Create, Read, Update, Delete) cho CartController. Tất cả các route này sẽ được bảo vệ bởi middleware auth, nghĩa là người dùng phải đăng nhập mới có thể truy cập.

Dưới đây là các endpoint mà Route::resource('/carts', CartController::class) tạo ra:

1. GET /carts - index
Mô tả: Hiển thị danh sách tất cả các giỏ hàng (carts).
Action trong controller: CartController@index
Route name: carts.index
Middleware: auth
2. GET /carts/create - create
Mô tả: Hiển thị form để tạo giỏ hàng mới.
Action trong controller: CartController@create
Route name: carts.create
Middleware: auth
3. POST /carts - store
Mô tả: Lưu trữ giỏ hàng mới vào cơ sở dữ liệu.
Action trong controller: CartController@store
Route name: carts.store
Middleware: auth
4. GET /carts/{cart} - show
Mô tả: Hiển thị chi tiết một giỏ hàng cụ thể (dựa trên id).
Action trong controller: CartController@show
Route name: carts.show
Middleware: auth
5. GET /carts/{cart}/edit - edit
Mô tả: Hiển thị form để chỉnh sửa một giỏ hàng cụ thể.
Action trong controller: CartController@edit
Route name: carts.edit
Middleware: auth
6. PUT /carts/{cart} - update
Mô tả: Cập nhật thông tin của giỏ hàng cụ thể trong cơ sở dữ liệu.
Action trong controller: CartController@update
Route name: carts.update
Middleware: auth
7. DELETE /carts/{cart} - destroy
Mô tả: Xóa giỏ hàng cụ thể khỏi cơ sở dữ liệu.
Action trong controller: CartController@destroy
Route name: carts.destroy
Middleware: auth

------------------------------------------------------------
### Tổng kết các endpoint

| Method | URI                | Action | Route Name     |
|--------|--------------------|--------|----------------|
| GET    | /carts             | index  | carts.index    |
| GET    | /carts/create      | create | carts.create   |
| POST   | /carts             | store  | carts.store    |
| GET    | /carts/{cart}      | show   | carts.show     |
| GET    | /carts/{cart}/edit | edit   | carts.edit     |
| PUT    | /carts/{cart}      | update | carts.update   |
| DELETE | /carts/{cart}      | destroy| carts.destroy  |

-------------------------------------------------------------
Tất cả các route này đều được bảo vệ bởi middleware auth, yêu cầu người dùng phải đăng nhập mới có thể truy cập.
```
3. command artisan 
```
php artisan route:list
php artisan migrate:refresh
php artisan migrate
php artisan migrate:reset
php artisan make:controller --resource <name>

php artisan route:list

php artisan route:clear
php artisan route:cache
php artisan route:list


Xóa Cache Route:
php artisan route:clear
Xóa Cache Config:
php artisan config:clear
Xóa Cache View:
php artisan view:clear
Xóa Cache Application:
php artisan cache:clear
Tạo lại Cache
Sau khi đã xóa cache, bạn có thể tạo lại cache cho route và config để tăng hiệu suất:
Tạo Cache Route:
php artisan route:cache
Tạo Cache Config:
php artisan config:cache
```
4. khởi động dự án sau git clone 
```
#thư viện framework laravel thường chọn cài ngoài thay vì push lên git sẽ nặng và không cần
composer install
#thay cấu hình nhạy cảm db trong .env

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ecommerce2024
DB_USERNAME=root
DB_PASSWORD=

cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```
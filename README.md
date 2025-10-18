# DubDex


Start server:
php artisan db:wipe && php artisan migrate && php artisan db:seed && php artisan serve

Start queue:
php artisan horizon

Delete all failed Queus: 
php artisan horizon:forget --all


Queue: 
use App\Jobs\ImdbTitleListFetcher
ImdbTitleListFetcher::dispatch('Naruto')

<?
use App\Http\Controllers\PaymentController;
Route::post('/va-info', [PaymentController::class, 'getInfo']);
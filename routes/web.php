<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkstationController;
use App\Models\TrafficViolation;
use App\Models\ApprehendingOfficer;
use App\Models\TasFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\StockController;

use App\Http\Controllers\AccountController;

use App\Models\fileviolation;
use App\Models\G5ChatMessage;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/loginpage', [AuthController::class, 'loadlogin'])->name('login');


Route::middleware('auth')->group(function () {
    Route::get('/inventory/dashboard', [InventoryController::class, 'inventorydash'])->name('inventory.dashboard');
    Route::get('/inventory/add', [InventoryController::class, 'inventoryadd'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/list', [InventoryController::class, 'inventorylist'])->name('inventory.list');
    Route::get('/inventory/reports', [InventoryController::class, 'inventoryreports'])->name('inventory.reports');
    Route::get('/inventory/values', [InventoryController::class, 'values'])->name('inventory.values');
    Route::get('/inventory/asset', [InventoryController::class, 'asset'])->name('asset.inventory');
    Route::post('/inventory/values', [InventoryController::class, 'storeValue'])->name('inventory.values.store');
    Route::delete('/inventory/values/{option}', [InventoryController::class, 'deleteValue'])->name('inventory.values.delete');
    Route::delete('/inventory/bulk-delete', [InventoryController::class, 'bulkDelete'])->name('inventory.bulk-delete');
    Route::get('/inventory/gatepass', [InventoryController::class, 'gatepass'])->name('inventory.gatepass');
    Route::get('/inventory/gatepass/list', [InventoryController::class, 'gatepassList'])->name('inventory.gatepass.list');
    Route::get('/inventory/gatepass/create', [InventoryController::class, 'createGatepass'])->name('inventory.gatepass.create');
    Route::get('/inventory/gatepass/{gatepass}/edit', [InventoryController::class, 'editGatepass'])->name('inventory.gatepass.edit');
    Route::put('/inventory/gatepass/{gatepass}', [InventoryController::class, 'updateGatepass'])->name('inventory.gatepass.update');
    Route::get('/inventory/gatepass/{gatepass}', [InventoryController::class, 'showGatepass'])->name('inventory.gatepass.show');
    Route::get('/inventory/{inventoryItem}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventoryItem}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('/inventory/{inventoryItem}/gatepass', [InventoryController::class, 'gatepassForItem'])->name('inventory.gatepass.item');
    Route::get('/inventory/{inventoryItem}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::post(
'/inventory/gatepass/{id}/signature',
[InventoryController::class, 'attachSignature']
)->name('inventory.gatepass.signature');
    Route::post('/inventory/gatepass/save', [InventoryController::class, 'storeGatepass'])
    ->name('inventory.gatepass.save');

// STOCK INVENTORY
Route::get('/stock', [StockController::class, 'index'])
    ->name('stock.index');

Route::get('/stock/create', [StockController::class, 'create'])
    ->name('stock.create');

Route::post('/stock/store', [StockController::class, 'store'])
    ->name('stock.store');

Route::get('/stock/{id}', [StockController::class, 'show'])
    ->name('stock.show');

Route::get('/stock/{id}/edit', [StockController::class, 'edit'])
    ->name('stock.edit');

Route::put('/stock/{id}', [StockController::class, 'update'])
    ->name('stock.update');

Route::delete('/stock/{id}', [StockController::class, 'destroy'])
    ->name('stock.destroy');

Route::get('/stock-low-stock', [StockController::class, 'lowStock'])
    ->name('stock.low-stock');
    Route::get('/stock/{id}/in', [StockController::class, 'stockIn'])
    ->name('stock.in');

Route::post('/stock/{id}/in', [StockController::class, 'processStockIn'])
    ->name('stock.process.in');

Route::get('/stock/{id}/out', [StockController::class, 'stockOut'])
    ->name('stock.out');

Route::post('/stock/{id}/out', [StockController::class, 'processStockOut'])
    ->name('stock.process.out');

    Route::get('/inventory/gatepass', [InventoryController::class, 'gatepass'])
        ->name('inventory.gatepass');

    Route::get('/inventory/gatepass/list', [InventoryController::class, 'gatepassList'])
        ->name('inventory.gatepass.list');

    Route::get('/inventory/gatepass/{gatepass}/print', [InventoryController::class, 'printSavedGatepass'])
        ->name('inventory.gatepass.print');
    Route::post('/inventory/gatepass/{gatepass}/signature', [InventoryController::class, 'uploadGatepassSignature'])
        ->name('inventory.gatepass.signature');

    Route::get('/gatepasses', [InventoryController::class, 'gatepassList'])
        ->name('gatepasses.index');

    Route::get('/inventory/gatepass/create', [InventoryController::class, 'createGatepass'])
        ->name('inventory.gatepass.create');

  Route::get('/workstations', [WorkstationController::class, 'index'])
    ->name('workstations.index');

Route::get('/workstations/bulk-create', [WorkstationController::class, 'bulkCreate'])
    ->name('workstations.bulkCreate');

Route::post('/workstations/bulk-store', [WorkstationController::class, 'bulkStore'])
    ->name('workstations.bulkStore');

    Route::get('/floors/create', [WorkstationController::class, 'createFloor'])
    ->name('floors.create');

Route::post('/floors/store', [WorkstationController::class, 'storeFloor'])
    ->name('floor.store');
    

    // Fixed Asset Transfer
    Route::get('/asset/transfer/create', [InventoryController::class, 'createAssetTransfer'])
        ->name('asset.transfer.create');

    Route::post('/asset/transfer', [InventoryController::class, 'assetTransfer'])
        ->name('asset.transfer');

    // Transfer list for sidebar navigation
    Route::get('/asset/transfers', [InventoryController::class, 'assetTransferIndex'])
        ->name('asset-transfers.index');

    Route::post('/asset/transfer-list', [InventoryController::class, 'assetTransferList'])
        ->name('asset.transfer.list');

    Route::get('/asset/transfer/{inventoryItem}', [InventoryController::class, 'assetTransferForItem'])
        ->name('asset.transfer.item');
Route::get('/asset/transfers', [InventoryController::class, 'assetTransferList'])
    ->name('asset.transfer.index');

Route::get('/asset/transfer/{assetTransfer}/edit', [InventoryController::class, 'editAssetTransfer'])
    ->name('asset.transfer.edit');

Route::put('/asset/transfer/{assetTransfer}', [InventoryController::class, 'updateAssetTransfer'])
    ->name('asset.transfer.update');

Route::get('/asset/transfer/{assetTransfer}/print', [InventoryController::class, 'printAssetTransfer'])
    ->name('asset.transfer.print');

Route::delete('/asset/transfer/{assetTransfer}', [InventoryController::class, 'destroyAssetTransfer'])
    ->name('asset.transfer.destroy');
Route::post('/asset/transfer/{assetTransfer}/signature', [InventoryController::class, 'uploadAssetTransferSignature'])
    ->name('asset.transfer.signature');
   Route::get('/asset/transfer/create', [InventoryController::class, 'createAssetTransfer'])->name('asset.transfer.create');
Route::post('/asset/transfer', [InventoryController::class, 'assetTransfer'])->name('asset.transfer');
Route::post('/asset/transfer-list', [InventoryController::class, 'assetTransferList'])->name('asset.transfer.list');
Route::get('/asset/transfer/{inventoryItem}', [InventoryController::class, 'assetTransferForItem'])->name('asset.transfer.item');



Route::resource('accounts', AccountController::class);

Route::post('/accounts/import', [AccountController::class, 'import'])->name('accounts.import');
Route::get('/reset-password/{id}', [AuthController::class, 'loadResetPassword'])->name('auth.loadResetPassword');
Route::put('/reset-password/{id}', [AuthController::class, 'resetPassword'])->name('auth.resetPassword');


});


Route::get('/', function () {
    return view('welcome');
})->name('landpage');

Route::get('/loginpage', [AuthController::class, 'loadlogin'])->name('login');
Route::post('/loginpost', [AuthController::class, 'login'])->name('login.submit');

Route::get('/registerpage', [AuthController::class, 'loadregister'])->name('register');
Route::post('/registerpost', [AuthController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthController::class, 'logoutx'])->name('logout');

// Middleware routes for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'indexa'])->name('dashboard');
    Route::get('/tables', [DashboardController::class, 'tables'])->name('tables');
    Route::get('/manageTAS', [DashboardController::class, 'tasManage'])->name('tas.manage');
    Route::get('/admitTAS', [DashboardController::class, 'admitview'])->name('InventoryItem.view');
    Route::get('/admitTAS/admit.manageform', [DashboardController::class, 'admitmanage'])->name('InventoryItem.manage');
    Route::post('/admitTAS/admit.manageform', [DashboardController::class, 'InventoryItemsubmit'])->name('InventoryItemsubmit.tas');
    Route::get('/apprehendingofficer', [DashboardController::class, 'officergg'])->name('see.offi');
    Route::post('/apprehendingofficer/store.officer', [DashboardController::class, 'save_offi'])->name('save.offi');
    Route::get('/violation', [DashboardController::class, 'violationadd'])->name('see.vio');
    Route::post('/violation/save.violation', [DashboardController::class, 'addvio'])->name('add.violation');
    Route::get('/editofficer', [DashboardController::class, 'editoffi'])->name('edit.offi');
    Route::post('/admit-remarks', [DashboardController::class, 'admitremark'])->name('admitremark');
    Route::post('/viewTAS/save-remarks', [DashboardController::class, 'saveRemarks'])->name('save.remarks');
    Route::get('/getChartData', [DashboardController::class, 'getChartData']);
    Route::get('/{id}/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/{id}/profile/edit', [DashboardController::class, 'edit'])->name('profile.edit');
    Route::get('/manage-user', [DashboardController::class, 'management'])->name('user_management');
    Route::get('/manage-user/users/{id}/edit', [DashboardController::class, 'edit'])->name('users.edit');
    Route::delete('/manage-user/users/{user}', [DashboardController::class, 'userdestroy'])->name('users.destroy');
    Route::get('/manage-user/add-user', [DashboardController::class, 'add_user'])->name('add.user');
    Route::post('/manage-user/store-user', [DashboardController::class, 'store_user'])->name('store.user');
   Route::put('/{id}/profile/update', [DashboardController::class, 'update'])->name('profile.update');
    Route::get('/{id}/profile/change_password', [DashboardController::class, 'change'])->name('profile.change');
    Route::post('/{id}/profile/update_password', [DashboardController::class, 'updatePassword'])->name('profile.update_password');

    Route::put('/InventoryItem-cases/{id}', [DashboardController::class, 'updateInventoryItemCase'])->name('InventoryItem-cases.update');
    Route::get('/edit/contested', [DashboardController::class, 'updateContest'])->name('update.contest.index');
    Route::get('/edit/InventoryItem', [DashboardController::class, 'updateInventoryItem'])->name('update.admit.index');
    Route::get('/officers/{departmentName}', [DashboardController::class, 'getByDepartmentName']);
    Route::put('/edit/contested/violations/{id}', [DashboardController::class, 'updateTas'])->name('violations.updateTas');
    Route::delete('/edit/contested/violations/{id}', [DashboardController::class, 'deleteTas'])->name('violations.delete');
    Route::get('/history', [DashboardController::class, 'historyIndex'])->name('history.index');
    Route::get('/InventoryItemEdit', [DashboardController::class, 'editAdmit'])->name('edit.admit');
    Route::get('/print/{id}', [DashboardController::class, 'printsub'])->name('print.sub');
    Route::post('/update-status/{id}', [DashboardController::class, 'updateStatus'])->name('update.status');
    Route::post('/finish-case/{id}', [DashboardController::class, 'finishCase'])->name('finish.case');
    Route::put('/officers/{id}', [DashboardController::class, 'updateoffi'])->name('officers.update');
    Route::put('/edit/{id}/violation', [DashboardController::class, 'updateviolation'])->name('edit.violation');
    Route::get('/edit/violation', [DashboardController::class, 'edivio'])->name('edit.vio');

    Route::get('edit/violation/details/{id}', function ($id) {
        $violation = TrafficViolation::findOrFail($id);
        return view('ao.detailsviolation', compact('violation'));
    })->name('fetchingviolation');

    Route::get('officer/details/{id}', function ($id) {
        $officer = ApprehendingOfficer::findOrFail($id);
        return view('ao.detailsoffi', compact('officer'));
    })->name('fetchingofficer');

    Route::get('/viewTAS/tasfile{id}/details/', [DashboardController::class, 'detailstasfile'])->name('fetchingtasfile');
    Route::get('/tasfileedit{id}/details/', [DashboardController::class, 'detailsedit'])->name('fetchingeditfile');
    Route::get('InventoryItem/details/{id}', [DashboardController::class, 'detailsInventoryItem'])->name('fetchingInventoryItem');
    Route::get('/fetchFinishData/{id}', [DashboardController::class, 'fetchFinishData'])->name('fetchFinishData');
    Route::post('/finishCase/{id}', [DashboardController::class, 'finishCase'])->name('finish.case');

    Route::post('/tasfile/{id}/updateViolation', [DashboardController::class, 'UPDATEVIO'])->name('edit.updatevio');
    Route::get('/fetch-violations', [DashboardController::class, 'fetchViolations']);
Route::post('/tasfile/{id}/deleteViolation', [DashboardController::class, 'DELETEVIO'])->name('edit.viodelete');
Route::post('/delete-remark/',  [DashboardController::class, 'deleteRemark'])->name('edit.deleteremarks');
Route::post('/tas-files/{id}/add-attachment', [DashboardController::class, 'addAttachment'])->name('add.attachment');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////ANALYTICS
/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////
//////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////// COMMUNICATION  /////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::post('/chatstore/storeChat', [DashboardController::class, 'storeMessage'])->name('chat.store');
Route::get('/get-chat-data/{userId}', [DashboardController::class, 'getChatData'])->name('chat.messages');
Route::get('/chat/{userId?}', [DashboardController::class, 'chatIndex'])->name('chat.index');


Route::get('/user/{user}/messages', [UserController::class, 'getUserMessages']);
 
Route::get('/start-chat/{userId}', [UserController::class, 'startChat'])->name('chat.start');
Route::get('/check-new-messages/{userId}',  [DashboardController::class, 'checkNewMessages'])->name('check.chat');

});

Route::get('/fetch-remarks/?id={id}', [DashboardController::class, 'fetchRemarks'])->name('fetch.remarks'); 

Route::get('/subpoena', function () { 
    $tasFile = TasFile::findOrFail(115);
    $changes = $tasFile;
    $officerName = $changes->apprehending_officer;
    $officers = ApprehendingOfficer::where('officer', $officerName)->get();

    if (!empty($changes->violation)) {
        $violations = json_decode($changes->violation);
        if ($violations !== null) {
            $relatedViolations = TrafficViolation::whereIn('code', $violations)->get();
        } else {
            $relatedViolations = [];
        }
    } else {
        $relatedViolations = [];
    }

    $holidays = [
        '01-01', // New Year's Day
        '04-09', // Araw ng Kagitingan
        '05-01', // Labor Day
        '06-12', // Independence Day
        '08-26', // National Heroes Day
        '11-30', // Bonifacio Day
        '12-25', // Christmas Day
        '02-25', // EDSA People Power Revolution Anniversary
        '08-21', // Ninoy Aquino Day
        '11-01', // All Saints' Day
        '11-02', // All Souls' Day
        '12-30', // Rizal Day
        '02-14', // Valentine's Day
        '03-08', // International Women's Day
        '10-31', // Halloween
        '04-20', // 420 (Cannabis Culture)
        '07-04', // Independence Day (United States)
        '05-14', // Additional holiday declared by the government
        '11-15', // Regional holiday
    ];

    // Get the current date
    $startDate = Carbon::now();
    $formattedDate = $startDate->format('F j, Y');

    // Calculate the new date excluding weekends and holidays
    $currentDate = clone $startDate; // Clone to avoid modifying the original start date
    $numDays = 3;

    while ($numDays > 0) {
        $currentDate->addDay();

        // Check if the current day is a weekend or a holiday
        if ($currentDate->isWeekend() || in_array($currentDate->format('m-d'), $holidays)) {
            continue; // Skip weekends and holidays
        }

        $numDays--;
    }

    $endDate = $currentDate->format('F j, Y');

    $compactData = [
        'changes' => $changes,
        'officers' => $officers,
        'relatedViolations' => $relatedViolations,
        'date' => $formattedDate,
        'hearing' => $endDate,
    ];


    return view('subpoena', compact('tasFile', 'compactData'));
});

Route::group(['prefix' => 'user', 'middleware' => ['web', 'isUser']], function () {
});
?>

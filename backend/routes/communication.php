<?php
    use App\Http\Controllers\AdminCommunicationController;
    use App\Http\Controllers\AdminCommunicationContactController;
    use App\Http\Controllers\AdminCommunicationNewsletterController;
    use App\Http\Controllers\AdminCommunicationReviewController;
    use Illuminate\Support\Facades\Route;

    Route::resource('/communication', AdminCommunicationController::class)
        ->only('index')
        ->names([
            'index' => 'admin.communication'
        ]);
    Route::resource('/communication/contact', AdminCommunicationContactController::class)
        ->only('index')
        ->names([
            'index' => 'admin.communication.contact'
        ]);
    Route::resource('/communication/newsletter', AdminCommunicationNewsletterController::class)
        ->only('index')
        ->names([
            'index' => 'admin.communication.newsletter'
        ]);
    Route::resource('/communication/reviews', AdminCommunicationReviewController::class)
        ->only('index')
        ->names([
            'index' => 'admin.communication.review'
        ]);

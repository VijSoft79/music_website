<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuratorController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferTemplateController;
use App\Http\Controllers\CuratorWalletController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Middleware\UnderConstruction;   

use App\Http\Controllers\PageContentController;
use App\Http\Controllers\Admin\MusicianController;
use Illuminate\Support\Facades\Auth;

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/test-route', function () {
    return 'Test route works! 1';
});

Route::get('/auth/google', [App\Http\Controllers\SocialiteController::class, 'googleLogin'])->name('auth.google');
Route::get('/auth/google-callback', [App\Http\Controllers\SocialiteController::class, 'googleAuth'])->name('auth.google-callback');
// Route::get('/home', function () {
//     return view('underconstruction');
// });

Route::get('/test-route', function () {
    return 'Staging test route works! 1';
});

Route::get('/choose', function () {
    return view('user-choice');
})->name('user.type.choose');

Route::get('/underconstruct', function () {
    return view('underconstruction');
})->name('underconstruct');

Route::get('/thankyou/{payment}', function ($payment) {
    return view('payments.thank-you', compact('payment'));
})->name('thankyou');

Route::get('/about-us', function () {
    return view('pages.aboutUs');
})->name('page.aboutus');


// Auth::routes(['verify' => true]);
Auth::routes();

// Email preference routes - add after Auth::routes();
Route::get('/email/unsubscribe/{user}', [App\Http\Controllers\EmailPreferenceController::class, 'unsubscribe'])->name('email.unsubscribe');

// auth route
Route::get('/curator-register', function() {
    return view('auth.curator-register');
})->name('curator.register');
Route::post('/curator-register/save', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('curator.register.save');

Route::get('/musician-register', function() {
    return view('auth.musician-register');
})->name('musician.register');
Route::post('/musician-register/save', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('musician.register.save');

Route::get('/login', function() {
    return view('auth.login');
})->name('login');
Route::post('/login/save', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('curator.login.save');

 

Route::group(['prefix' => '/dashboard', 'middleware' => ['auth', 'role:administrator']], function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.home');
    Route::post('/song-price', [App\Http\Controllers\Admin\AdminController::class, 'changeSongPrice'])->name('admin.price');

    // campaigns
    Route::get('/campaigns', [App\Http\Controllers\Admin\CampaignController::class, 'index'])->name('admin.campaigns.index');
    Route::get('/campaigns/create', [App\Http\Controllers\Admin\CampaignController::class, 'create'])->name('admin.campaigns.create');
    Route::post('/campaigns/store', [App\Http\Controllers\Admin\CampaignController::class, 'store'])->name('admin.campaigns.store');
    Route::get('/campaigns/{campaign}', [App\Http\Controllers\Admin\CampaignController::class, 'show'])->name('admin.campaigns.show');
    Route::get('/campaigns/{campaign}/edit', [App\Http\Controllers\Admin\CampaignController::class, 'edit'])->name('admin.campaigns.edit');
    Route::post('/campaigns/{campaign}/update', [App\Http\Controllers\Admin\CampaignController::class, 'update'])->name('admin.campaigns.update');
    Route::delete('/campaigns/{campaign}', [App\Http\Controllers\Admin\CampaignController::class, 'destroy'])->name('admin.campaigns.destroy');

    // musician
    Route::get('/musicians', [App\Http\Controllers\Admin\MusicianController::class, 'index'])->name('admin.musicians.index');
    Route::post('/musicians/approve', [App\Http\Controllers\Admin\MusicianController::class, 'approveMusician'])->name('admin.musicians.approve');
    Route::get('/musicians/{user}', [App\Http\Controllers\Admin\MusicianController::class, 'show'])->name('admin.musicians.show');
    Route::post('/musicians/special/', [App\Http\Controllers\Admin\MusicianController::class, 'isSpecial'])->name('add.is.special');
    Route::get('/musicians/{user}/delete', [App\Http\Controllers\Admin\MusicianController::class, 'delete'])->name('admin.musicians.delete');
    Route::post('/musicians/verify/', [App\Http\Controllers\Admin\MusicianController::class, 'verify'])->name('musicians.verify');
    Route::get('/download-musician', [App\Http\Controllers\Admin\MusicianController::class, 'downloadMusician'])->name('musician.download');
    Route::get('/musicians/edit-artist-name', [App\Http\Controllers\Admin\MusicianController::class, 'editArtistName'])->name('admin.musicians.edit-artist-name');
    Route::post('/musicians/{id}/update-names', [MusicianController::class, 'updateNames'])->name('admin.musicians.update-names');

    // curator
    Route::get('/curators', [App\Http\Controllers\Admin\CuratorController::class, 'index'])->name('admin.curators.index');
    Route::post('/curators/update', [App\Http\Controllers\Admin\CuratorController::class, 'update'])->name('admin.curators.update');
    Route::post('/curators/approve', [App\Http\Controllers\Admin\CuratorController::class, 'approveCurator'])->name('admin.curators.approve');
    Route::get('/curators/{user}', [App\Http\Controllers\Admin\CuratorController::class, 'show'])->name('admin.curators.show');
    Route::get('/curators/{user}/edit', [App\Http\Controllers\Admin\CuratorController::class, 'edit'])->name('admin.curators.edit');
    Route::get('/curators/{user}/delete', [App\Http\Controllers\Admin\CuratorController::class, 'delete'])->name('admin.curators.delete');
    Route::get('/curators/{offer}/history', [App\Http\Controllers\Admin\CuratorController::class, 'history'])->name('admin.curators.history');
    Route::get('/download-curators', [App\Http\Controllers\Admin\CuratorController::class, 'downloadCurators'])->name('curators.download');

    // writer
    Route::get('/writers', [App\Http\Controllers\Admin\WriterController::class, 'index'])->name('admin.writers.index');
    Route::get('/writers/create', [App\Http\Controllers\Admin\WriterController::class, 'create'])->name('admin.writers.create');
    Route::post('/writer/save', [App\Http\Controllers\Auth\RegisterController::class, 'adminregisterAccount'])->name('admin.writers.save');

    //offer
    Route::get('/invitations', [App\Http\Controllers\Admin\InvitationController::class, 'index'])->name('admin.invitations.index');
    Route::get('/invitation/reports', [App\Http\Controllers\Admin\InvitationController::class, 'getInvitationReports'])->name('admin.invitation.reports');
    Route::get('/invitation/completed', [App\Http\Controllers\Admin\InvitationController::class, 'getCompletedInvites'])->name('admin.invitation.completed');
    Route::get('/invitation/{offer}', [App\Http\Controllers\Admin\InvitationController::class, 'show'])->name('admin.invitation.show');
    Route::post('/invitation/{offer}/completed', [App\Http\Controllers\Admin\InvitationController::class, 'invitationComplete'])->name('admin.invitation.complete');
    Route::post('/invitation/selected', [App\Http\Controllers\Admin\InvitationController::class, 'store'])->name('admin.invitation.store');

    //offer templates
    Route::get('/offer-templates', [App\Http\Controllers\Admin\OfferTemplateController::class, 'index'])->name('admin.templates.index');
    Route::get('/offer-templates/{OfferTemplate}/show', [App\Http\Controllers\Admin\OfferTemplateController::class, 'show'])->name('admin.templates.show');
    Route::get('/offer-templates/{OfferTemplate}/edit', [App\Http\Controllers\Admin\OfferTemplateController::class, 'edit'])->name('admin.templates.edit');
    Route::post('/offer-templates/{OfferTemplate}/update', [App\Http\Controllers\Admin\OfferTemplateController::class, 'update'])->name('admin.templates.update');
    Route::post('/offer-templates/delete', [App\Http\Controllers\Admin\OfferTemplateController::class, 'delete'])->name('admin.templates.delete');

    // music 
    Route::get('/musics', [App\Http\Controllers\Admin\MusicController::class, 'index'])->name('admin.music.index');
    Route::post('/musics/update', [App\Http\Controllers\Admin\MusicController::class, 'adminApproval'])->name('admin.music.approve');
    Route::get('/music/pending', [App\Http\Controllers\Admin\MusicController::class, 'getPendingMusic'])->name('admin.music.pending');
    Route::get('/music/approve', [App\Http\Controllers\Admin\MusicController::class, 'getApprovedMusic'])->name('admin.music.approved');
    Route::get('/music/unpaid', [App\Http\Controllers\Admin\MusicController::class, 'getUnpaidMusic'])->name('admin.music.unpaid');
    Route::get('/musics/{music}', [App\Http\Controllers\Admin\MusicController::class, 'show'])->name('admin.music.show');
    Route::post('/musics/{music}/update', [App\Http\Controllers\Admin\MusicController::class, 'update'])->name('admin.music.update');
    Route::get('/musics/{music}/delete', [App\Http\Controllers\Admin\MusicController::class, 'delete'])->name('admin.music.delete');
    Route::post('/musics/music/update-image/{music}', [App\Http\Controllers\Admin\MusicController::class, 'uploadImage'])->name('admin.music.update.image');

    // genre
    Route::get('/genres', [App\Http\Controllers\Admin\GenreController::class, 'index'])->name('admin.genre.index');
    Route::post('/genresCreate', [App\Http\Controllers\Admin\GenreController::class, 'create'])->name('admin.genre.create');
    Route::post('/genresUpdate', [App\Http\Controllers\Admin\GenreController::class, 'update'])->name('admin.genre.update');
    Route::post('/genresEdit', [App\Http\Controllers\Admin\GenreController::class, 'edit'])->name('admin.genre.edit');
    Route::delete('/genre/delete', [App\Http\Controllers\Admin\GenreController::class, 'destroy'])->name('admin.genre.delete');
    Route::post('/genre/retrieve', [App\Http\Controllers\Admin\GenreController::class, 'retrieve'])->name('admin.genre.retrieve');

    // emails
    Route::get('/emails', [App\Http\Controllers\Admin\EmailMessageController::class, 'index'])->name('admin.email.index');
    Route::get('/emails/create', [App\Http\Controllers\Admin\EmailMessageController::class, 'create'])->name('admin.email.create');
    Route::post('/emails/save', [App\Http\Controllers\Admin\EmailMessageController::class, 'save'])->name('admin.email.save');
    Route::get('/emails/{emailMessage}', [App\Http\Controllers\Admin\EmailMessageController::class, 'edit'])->name('admin.email.edit');
    Route::post('/emails/{emailMessage}/update', [App\Http\Controllers\Admin\EmailMessageController::class, 'update'])->name('admin.email.update');
    Route::delete('/emails/{emailMessage}/destroy', [App\Http\Controllers\Admin\EmailMessageController::class, 'destroy'])->name('admin.email.destroy');

    // page contents
    Route::get('/page-content/', [App\Http\Controllers\Admin\PageContentController::class, 'index'])->name('admin.page.content');
    Route::get('/page-content/create', [App\Http\Controllers\Admin\PageContentController::class, 'create'])->name('admin.page.content.create');
    Route::post('/page-content/save', [App\Http\Controllers\Admin\PageContentController::class, 'save'])->name('admin.page.content.save');
    Route::post('/page-content/update', [App\Http\Controllers\Admin\PageContentController::class, 'update'])->name('admin.page.content.update');
    Route::get('/page-content/{pageContent}', [App\Http\Controllers\Admin\PageContentController::class, 'show'])->name('admin.page.content.show');

    // updates
    Route::get('/updates/', [App\Http\Controllers\Admin\UpdateController::class, 'index'])->name('admin.updates.index');
    Route::get('/updates/create', [App\Http\Controllers\Admin\UpdateController::class, 'create'])->name('admin.updates.create');
    Route::post('/updates/save', [App\Http\Controllers\Admin\UpdateController::class, 'save'])->name('admin.updates.save');
    Route::get('/updates/{update}/edit', [App\Http\Controllers\Admin\UpdateController::class, 'edit'])->name('admin.updates.edit');
    Route::get('/updates/{update}/show', [App\Http\Controllers\Admin\UpdateController::class, 'show'])->name('admin.updates.show');
    Route::post('/updates/delete', [App\Http\Controllers\Admin\UpdateController::class, 'destroy'])->name('admin.updates.delete');

    // coupon
    Route::get('/coupon/', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupon/create', [App\Http\Controllers\Admin\CouponController::class, 'create'])->name('coupon.create');
    Route::post('/coupon/store', [App\Http\Controllers\Admin\CouponController::class, 'store'])->name('coupon.store');
    Route::post('/coupon/delete', [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('coupon.delete');
    Route::get('/coupon/{coupon}/edit', [App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('coupon.edit');
    Route::get('/coupon/{coupon}/update', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('coupon.update');
    Route::get('/generate-key', [App\Http\Controllers\Admin\CouponController::class, 'generateKey']);
    Route::get('/coupon/show/{coupon}', [App\Http\Controllers\Admin\CouponController::class, 'show'])->name('coupon.show');

    // withdraw
    Route::get('/withdrawal/', [App\Http\Controllers\Admin\CuratorWithdrawalController::class, 'index'])->name('widthrawal.index');
    Route::get('/withdrawal/{transaction}', [App\Http\Controllers\Admin\CuratorWithdrawalController::class, 'show'])->name('widthrawal.show');
    Route::post('/withdrawal/{transaction}/update', [App\Http\Controllers\Admin\CuratorWithdrawalController::class, 'update'])->name('widthrawal.update');

    //page-message
    Route::get('/page-messages/', [App\Http\Controllers\Admin\PageMessageController::class, 'index'])->name('page.messages.index');
    Route::post('/page-messages/save', [App\Http\Controllers\Admin\PageMessageController::class, 'save'])->name('page.messages.save');
    Route::get('/page-messages/{pageMessage}/edit', [App\Http\Controllers\Admin\PageMessageController::class, 'edit'])->name('page.messages.edit');
    Route::post('/page-messages/{pageMessage}/update', [App\Http\Controllers\Admin\PageMessageController::class, 'update'])->name('page.messages.update');

    //setting
    Route::get('/adminsetting', [App\Http\Controllers\Admin\AdminSettingController::class, 'index'])->name('admin.setting');
    Route::post('/adminset', [App\Http\Controllers\Admin\AdminSettingController::class, 'changestat'])->name('admin.setting.change');

    //transactions
    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transaction');
    
});

Route::group(['prefix' => '/dashboard', 'middleware' => ['auth', 'role:administrator|writer']], function () {
    
    // Blog Post
    Route::get('/blog-post/', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.blog.index');
    Route::get('/blog-post/create', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.blog.create');
    Route::post('/blog-post/save', [App\Http\Controllers\Admin\PostController::class, 'save'])->name('admin.blog.save');
    Route::get('/blog-post/{post}', [App\Http\Controllers\Admin\PostController::class, 'show'])->name('admin.blog.show');
    Route::get('/blog-post/{post}/edit', [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin.blog.edit');
    Route::post('/blog-post/{post}/update', [App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.blog.update');
    Route::get('/blog-post/{post}/delete', [App\Http\Controllers\Admin\PostController::class, 'delete'])->name('admin.blog.delete');

    // categories
    Route::get('/categories/', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/categories/save', [App\Http\Controllers\Admin\CategoryController::class, 'save'])->name('admin.category.save');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('/categories/show', [App\Http\Controllers\Admin\CategoryController::class, 'save'])->name('admin.category.show');
    Route::post('/categories/update', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.category.update');


    //profile
    Route::get('/profile', [CuratorController::class, 'show'])->name('curator.show');


});

Route::group(['prefix' => '/dashboard/curator', 'middleware' => ['auth', 'role:curator']], function () {
    Route::get('/', [CuratorController::class, 'index'])->name('curator.home');
    Route::post('/update', [CuratorController::class, 'update'])->name('curator.update');

    // profile
    Route::get('/profile', [CuratorController::class, 'show'])->name('curator.show');
    

    // submissions
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('curator.submissions.index');
    Route::post('/submissions/save-chossen-genre/', [SubmissionController::class, 'getChosenGenre'])->name('curator.save.chosen.genre');
    Route::get('/submissions/get-template/{offerTemplate}', [SubmissionController::class, 'getTemplate'])->name('curator.submissions.gettemplate');
    // Route::get('/submissions/get-template/{offerTemplate}', [App\Http\Controllers\SubmissionController::class, 'getTemplate'])->name('curator.submissions.gettemplate');
    Route::get('/submissions/{music}', [SubmissionController::class, 'show'])->name('curator.submissions.show');

    // offers
    Route::get('/offers/', [OfferController::class, 'index'])->name('curator.offers.index');
    Route::get('/offers/in-progress', [OfferController::class, 'getInProgressOffer'])->name('curator.offers.in.progress');
    Route::get('/offers/completed', [OfferController::class, 'getCompletedOffer'])->name('curator.offers.complete');
    Route::get('/offers/declined', [OfferController::class, 'getDeclinedOffer'])->name('curator.offers.complete');
    Route::get('/offers/reports', [OfferController::class, 'reports'])->name('curator.offers.report');
    Route::post('/offers/change-date', [OfferController::class, 'changeDate'])->name('curator.change.date');
    Route::post('/sendOffer', [OfferController::class, 'sendInvitation'])->name('curator.offers.send-offer');
    Route::post('/decline', [OfferController::class, 'declineMusic'])->name('curator.offers.decline');
    Route::delete('/{offer}/Destroy', [OfferController::class, 'destroy'])->name('curator.offers.destroy');
    Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('curator.offers.show');
    Route::post('/offers/{offer}/checking', [OfferController::class, 'saveForCheckingOffer'])->name('curator.offers.check');
    Route::post('/offers/{offer}/updateExpiry', [OfferController::class, 'updateExpiry'])->name('curator.offers.expiry');
    Route::post('curator/offers/retract', [OfferController::class, 'retractOffer'])->name('curator.offers.retract');

    // offer template
    Route::get('/offer-templates', [App\Http\Controllers\OfferTemplateController::class, 'index'])->name('curator.offer.template.index');
    Route::get('/offer-templates/create', [App\Http\Controllers\OfferTemplateController::class, 'create'])->name('curator.offer.template.create');
    Route::post('/offer-templates/save', [App\Http\Controllers\OfferTemplateController::class, 'save'])->name('curator.offer.template.save');
    Route::get('/offer-templates/{OfferTemplate}/show', [App\Http\Controllers\OfferTemplateController::class, 'show'])->name('curator.offer-templates.show');
    Route::get('/offer-templates/{OfferTemplate}/edit', [App\Http\Controllers\OfferTemplateController::class, 'edit'])->name('curator.offer-templates.edit');
    
    Route::post('/offer-templates/{OfferTemplate}/update', [App\Http\Controllers\OfferTemplateController::class, 'update'])->name('curator.offer.template.update');
    Route::post('/offer-templates/delete', [App\Http\Controllers\OfferTemplateController::class, 'destroy'])->name('curator.offer.template.delete');
    Route::post('/offer-templates/{offerTemplate}/toggle', [App\Http\Controllers\OfferTemplateController::class, 'toggleStatus'])->name('curator.offer.template.toggle');
    
    // wallet
    Route::get('/wallet', [CuratorWalletController::class, 'index'])->name('curator.wallet');
    Route::get('/wallet/{transaction}', [CuratorWalletController::class, 'show'])->name('curator.wallet.show');
    
    // withdraw
    Route::post('/widthraw-request/', [App\Http\Controllers\CuratorWithdrawController::class, 'withdrawRequest'])->name('withdraw.request');
    Route::get('/widthraw-request/check-users-wallet', [App\Http\Controllers\CuratorWithdrawController::class, 'checkUserwallet'])->name('wallet.check');

    // help
    Route::get('/help', [App\Http\Controllers\PageContentController::class, 'helpQuestion'])->name('curator.help');
    Route::post('/help/send', [App\Http\Controllers\PageContentController::class, 'sendHelpQuestion'])->name('curator.help.send');

    // settings
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('curator.settings.index');
    Route::post('/settings/save', [App\Http\Controllers\SettingsController::class, 'save'])->name('curator.settings.save');

    //report music
    Route::post('/report-music',[App\Http\Controllers\PageContentController::class, 'reportMusic'])->name('curator.report');

    //spotify playlist
    Route::get('/spotify/login', [App\Http\Controllers\SpotifyPlaylistController::class, 'login'])->name('spotify.login');
    Route::get('/spotify/callback', [App\Http\Controllers\SpotifyPlaylistController::class, 'callback'])->name('spotify.callback');
    Route::get('/spotify/playlists',[App\Http\Controllers\SpotifyPlaylistController::class, 'getPlaylists'])->name('spotify.playlists');
    Route::get('/spotify/playlist/{id}', [App\Http\Controllers\SpotifyPlaylistController::class, 'getPlaylist'])->name('spotify.playlist');
    Route::get('/spotify/logout', [App\Http\Controllers\SpotifyPlaylistController::class, 'logout'])->name('spotify.logout');
    Route::post('/spotify/add', [App\Http\Controllers\SpotifyPlaylistController::class, 'addTrack'])->name('spotify.add');

    
});

Route::group(['prefix' => '/dashboard/musician', 'middleware' => ['auth', 'role:musician']], function () {
    
    Route::get('/', [App\Http\Controllers\MusicianController::class, 'index'])->name('musician.index');
    Route::get('/profile', [App\Http\Controllers\MusicianController::class, 'show'])->name('musician.show');
    Route::post('/update', [App\Http\Controllers\MusicianController::class, 'update'])->name('musician.update');
    
    // music
    Route::get('/music', [App\Http\Controllers\Musician\MusicController::class, 'index'])->name('musician.music.index');
    Route::get('/music/create', [App\Http\Controllers\MusicController::class, 'musicCreate'])->name('musician.create.step.one');
    Route::post('/music/create-step-one/', [App\Http\Controllers\MusicController::class, 'postCreateStepOne'])->name('musician.create.step.one.post');
    Route::get('/music/create-step-two/', [App\Http\Controllers\MusicController::class, 'createStepTwo'])->name('musician.create.step.two');
    Route::post('/music/create-step-two/', [App\Http\Controllers\MusicController::class, 'postCreateStepTwo'])->name('musician.create.step.two.post');
    Route::get('/music/create-step-three/', [App\Http\Controllers\MusicController::class, 'createStepThree'])->name('musician.create.step.three');
    Route::post('/music/create-step-three/', [App\Http\Controllers\MusicController::class, 'postCreateStepThree'])->name('musician.create.step.three.post');
    Route::get('/music/create-step-four/', [App\Http\Controllers\MusicController::class, 'createStepFour'])->name('musician.create.step.four');
    Route::post('/music/create-step-four/', [App\Http\Controllers\MusicController::class, 'postCreateStepFour'])->name('musician.create.step.four.post');

    // music table
    Route::get('/music/{music}/', [App\Http\Controllers\Musician\MusicController::class, 'show'])->name('musician.music.show');
    Route::get('/music/{music}/edit', [App\Http\Controllers\MusicianController::class, 'musicEdit'])->name('musician.music.edit');
    Route::get('/music/{music}/update', [App\Http\Controllers\MusicController::class, 'update'])->name('musician.music.update');
    Route::delete('/music/{music}/destroy', [App\Http\Controllers\MusicianController::class, 'destroy'])->name('musician.music.destroy');
    Route::post('/music/{music}/add-images', [App\Http\Controllers\Musician\MusicController::class, 'addImages'])->name('musician.music.add-images');

    // invitation 
    Route::get('/invitations', [App\Http\Controllers\Musician\InvitationController::class, 'index'])->name('musician.invitation.index');
    Route::get('/invitations/in-progress', [App\Http\Controllers\Musician\InvitationController::class, 'getInProgressOffer'])->name('musician.invitation.inprogress');
    Route::post('/invitations/decline', [App\Http\Controllers\Musician\InvitationController::class, 'declineInvitation'])->name('musician.invitation.decline');
    Route::get('/invitations/completed', [App\Http\Controllers\Musician\InvitationController::class, 'getCompletedOffer'])->name('musician.invitation.completed');
    Route::get('/invitations/{offer}', [App\Http\Controllers\Musician\InvitationController::class, 'show'])->name('musician.invitation.show');

    Route::post('/invitations/{offer}/accept-payment', [App\Http\Controllers\InvitationPaymentController::class, 'Offerpayment'])->name('musician.invitation.approve');
    // Route::get('/invitations/{offer}/pay-invitation', [App\Http\Controllers\InvitationPaymentController::class, 'payCurator'])->name('musician.invitation.pay');
    Route::get('/invitation/pay/{offer}', [App\Http\Controllers\InvitationPaymentController::class, 'payCurator'])->name('musician.invitation.pay');


    //special approve 
    Route::post('/invitations/special-approve', [App\Http\Controllers\InvitationPaymentController::class, 'specialApprove'])->name('special.approve');
    
    // help
    Route::get('/help', [App\Http\Controllers\PageContentController::class, 'helpQuestion'])->name('musician.help');
    Route::post('/help/send', [App\Http\Controllers\PageContentController::class, 'sendHelpQuestion'])->name('musician.help.send');

    // payment
    Route::get('/payments/form', [App\Http\Controllers\MusicPaymentController::class, 'show'])->name('musician.payment.show');
    Route::post('/payments/form/proceed', [App\Http\Controllers\MusicPaymentController::class, 'checkout'])->name('musician.payment.proceed');
    Route::post('/payments/pay', [App\Http\Controllers\MusicPaymentController::class, 'processPayment'])->name('musician.payment.pay');
    Route::post('/validate-coupon', [App\Http\Controllers\MusicPaymentController::class, 'couponExist'])->name('coupon.validate');

    Route::get('/success-payment-music', [App\Http\Controllers\MusicPaymentController::class, 'successPayment'])->name('success.payment');

    // transactions
    Route::get('/transactions', [App\Http\Controllers\Musician\TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transactions/{transaction}', [App\Http\Controllers\Musician\TransactionController::class, 'show'])->name('musician.transaction.show');
});

Route::group(['prefix' => '/dashboard/contact', 'middleware' => ['auth']], function () {
    Route::post('/', [App\Http\Controllers\PageContentController::class, 'sendProbelm'])->name('send.problem');
});

Route::group(['prefix'=> '/dashboard/writer','middleware' => ['auth', 'role:writer']], function (){
    Route::get('/', [App\Http\Controllers\Writer\WriterController::class, 'index'])->name('writer.index');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/message', [App\Http\Controllers\ChatMessagesController::class, 'savemessage'])->name('chat.message.store');
    Route::get('chat/get', [App\Http\Controllers\ChatMessagesController::class, 'getChatDropdown'])->name('chat.get');

    Route::get('chat/index', [App\Http\Controllers\ChatMessagesController::class, 'index'])->name('chat.index');
    Route::get('chat/show/{offer}', [App\Http\Controllers\ChatMessagesController::class, 'show'])->name('chat.show');

});

// blogs
Route::group(['prefix' => '/blog'], function (){
    Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('page.blog.index');
    Route::get('/{slug}', [App\Http\Controllers\PostController::class, 'show'])->name('page.blog.show');
});

Route::get('/faqs', function () {
    return view('pages.faq');
})->name('page.faqs');


Route::get('/contact', [App\Http\Controllers\PageContentController::class, 'contact'])->name('page.contact');
Route::post('/contact/send', [App\Http\Controllers\PageContentController::class, 'send'])->name('contact.send');

// Catch-all route should be last
Route::get('/{pagename}', [App\Http\Controllers\PageContentController::class, 'show'])->name('page.curator');

// Route::

// Route::get('/curator', function () {
//     return view('pages.curator');
// })->name('page.curator');

Route::group(['prefix' => '/dashboard/email', 'middleware' => ['auth']], function () {
    Route::post('/preferences/toggle', [App\Http\Controllers\EmailPreferenceController::class, 'toggle'])->name('email.preferences.toggle');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/musicians/{id}/update-names', [MusicianController::class, 'updateNames'])->name('admin.musicians.update-names');
});

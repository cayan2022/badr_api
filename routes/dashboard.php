<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\ProjectController;
use App\Http\Controllers\Api\Dashboard\{BlogController,
    ContactUsController,
    RoleController,
    OfferController,
    AboutController,
    OrderController,
    DoctorController,
    SourceController,
    BranchController,
    StatusController,
    TidingController,
    CountryController,
    PartnerController,
    ServiceController,
    SettingController,
    ProfileController,
    CustomerController,
    CategoryController,
    SubStatusController,
    PermissionController,
    TestimonialController,
    ExportOrdersController,
    ImportOrdersController,
    ChangePasswordController,
    PortfolioCategoryController,
    PortfolioController,
    Reports\SourcesReportController,
    Reports\StatusesReportController,
    Reports\ModeratorsReportController};

/*permissions middleware
1-no permission for show or index methods
2-check the "check_permission" middleware it generates auto permission check for [create and delete] methods in api resource*/
Route:: as('dashboard.')
    ->middleware(['auth:sanctum'])
    ->prefix('dashboard')
    ->group(function () {
        //Profile
        Route:: as('profiles.')
            ->prefix('profile')
            ->group(function () {
            Route::get('all', [ProfileController::class, 'index'])->name('index');
            Route::get('show/{user}', [ProfileController::class, 'show'])->name('show');
            Route::post('store', [ProfileController::class, 'store'])->name('store')->middleware('can:create profiles');
            Route::post('update/{user}', [ProfileController::class, 'update'])->name('update')->middleware('can:update profiles');
            Route::post('change-password', ChangePasswordController::class)->name('changepassword')->middleware('can:update profiles');
            Route::post('logout/{user}', [ProfileController::class, 'logout'])->name('logout')->middleware('can:update profiles');
            Route::post('block/{user}', [ProfileController::class, 'block'])->name('block')->middleware('can:block profiles');
            Route::post('active/{user}', [ProfileController::class, 'active'])->name('active')->middleware('can:active profiles');
        });

        //Roles
        Route::group([], function () {
            Route::post('roles/assign', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign roles');
            Route::post('roles', [RoleController::class, 'store'])->name('roles.store')->middleware('can:create roles');
            Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('can:update roles');
            Route::apiResource('roles', RoleController::class)->only(['index', 'show']);
        });

        //Permissions
        Route:: as('permissions.')
            ->prefix('permissions')
            ->group(function () {
            Route::get('all', [PermissionController::class, 'all'])->name('all');
            Route::get('types', [PermissionController::class, 'types'])->name('types');
            Route::get('user', [PermissionController::class, 'user'])->name('user');
        });


        //Pages
        Route:: as('pages.')
            ->prefix('pages')
            ->group(function () {
            /*Doctors*/
            Route::group([], function () {
                Route::put('doctors/{doctor}/block', [DoctorController::class, 'block'])->name('doctors.block')->middleware('can:block doctors');
                Route::put('doctors/{doctor}/active', [DoctorController::class, 'active'])->name('doctors.active')->middleware('can:active doctors');
                Route::post('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update')->middleware('can:update doctors');
                Route::apiResource('doctors', DoctorController::class)->except('update')->middleware('check_permissions');
            });
            /*Testimonials*/
            Route::group([], function () {
                Route::put('testimonials/{testimonial}/block', [TestimonialController::class, 'block'])->name('testimonials.block')->middleware('can:block testimonials');
                Route::put('testimonials/{testimonial}/active', [TestimonialController::class, 'active'])->name('testimonials.active')->middleware('can:active testimonials');
                Route::post('testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update')->middleware('can:update testimonials');
                Route::apiResource('testimonials', TestimonialController::class)->except('update')->middleware('check_permissions');
            });
            /*Offers*/
            Route::group([], function () {
                Route::put('offers/{offer}/block', [OfferController::class, 'block'])->name('offers.block')->middleware('can:block offers');
                Route::put('offers/{offer}/active', [OfferController::class, 'active'])->name('offers.active')->middleware('can:active offers');
                Route::post('offers/{offer}', [OfferController::class, 'update'])->name('offers.update')->middleware('can:update offers');
                Route::apiResource('offers', OfferController::class)->except('update')->middleware('check_permissions');
            });
            /*Services*/
            Route::group([], function () {
                Route::put('services/{service}/block', [ServiceController::class, 'block'])->name('services.block')->middleware('can:block services');
                Route::put('services/{service}/active', [ServiceController::class, 'active'])->name('services.active')->middleware('can:active services');
                Route::post('services/{service}', [ServiceController::class, 'update'])->name('services.update')->middleware('can:update services');
                Route::apiResource('services', ServiceController::class)->except('update')->middleware('check_permissions');
            });
            /*Tidings*/
            Route::group([], function () {
                Route::put('tidings/{tiding}/active', [TidingController::class, 'active'])->name('tidings.active')->middleware('can:active tidings');
                Route::put('tidings/{tiding}/block', [TidingController::class, 'block'])->name('tidings.block')->middleware('can:block tidings');
                Route::post('tidings/{tiding}', [TidingController::class, 'update'])->name('tidings.update')->middleware('can:update tidings');
                Route::apiResource('tidings', TidingController::class)->except('update')->middleware('check_permissions');
            });
            /*Categories*/
            Route::group([], function () {
                Route::put('categories/{category}/block', [CategoryController::class, 'block'])->name('categories.block')->middleware('can:block categories');
                Route::put('categories/{category}/active', [CategoryController::class, 'active'])->name('categories.active')->middleware('can:active categories');
                Route::post('categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('can:update categories');
                Route::apiResource('categories', CategoryController::class)->except('update')->middleware('check_permissions');
            });
            // /*Blogs*/
            Route::group([], function () {
                Route::put('blogs/{blog}/block', [BlogController::class, 'block'])->name('blogs.block')->middleware('can:block blogs');
                Route::put('blogs/{blog}/active', [BlogController::class, 'active'])->name('blogs.active')->middleware('can:active blogs');
                Route::post('blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update')->middleware('can:update blogs');
                Route::apiResource('blogs', BlogController::class)->except('update')->middleware('check_permissions');
            });
            //  /*Abouts*/
            Route::group([], function () {
                Route::put('abouts/{about}/block', [AboutController::class, 'block'])->name('abouts.block')->middleware('can:block abouts');
                Route::put('abouts/{about}/active', [AboutController::class, 'active'])->name('abouts.active')->middleware('can:active abouts');
                Route::post('abouts/{about}', [AboutController::class, 'update'])->name('abouts.update')->middleware('can:update abouts');
                Route::apiResource('abouts', AboutController::class)->except('update')->middleware('check_permissions');
            });
            // /*Partners*/
            Route::group([], function () {
                Route::put('partners/{partner}/block', [PartnerController::class, 'block'])->name('partners.block')->middleware('can:block partners');
                Route::put('partners/{partner}/active', [PartnerController::class, 'active'])->name('partners.active')->middleware('can:active partners');
                Route::post('partners/{partner}', [PartnerController::class, 'update'])->name('partners.update')->middleware('can:update partners');
                Route::apiResource('partners', PartnerController::class)->except('update')->middleware('check_permissions');
            });
            /*Projects*/
            Route::group([], function () {
                Route::put('projects/{project}/block', [ProjectController::class, 'block'])->name('projects.block')->middleware('can:block projects');
                Route::put('projects/{project}/active', [ProjectController::class, 'active'])->name('projects.active')->middleware('can:active projects');
                Route::post('projects/{project}', [ProjectController::class, 'update'])->name('projects.update')->middleware('can:update projects');
                Route::apiResource('projects', ProjectController::class)->except('update')->middleware('check_permissions');
            });
            /*Source*/
            Route::group([], function () {
                Route::put('sources/{source}/block', [SourceController::class, 'block'])->name('sources.block')->middleware('can:block sources');
                Route::put('sources/{source}/active', [SourceController::class, 'active'])->name('sources.active')->middleware('can:active sources');
                Route::post('sources/{source}', [SourceController::class, 'update'])->name('sources.update')->middleware('can:update sources');
                Route::apiResource('sources', SourceController::class)->except('update')->middleware('check_permissions');
            });
            /*Branch*/
            Route::group([], function () {
                Route::put('branches/{branch}/block', [BranchController::class, 'block'])->name('branches.block')->middleware('can:block branches');
                Route::put('branches/{branch}/active', [BranchController::class, 'active'])->name('branches.active')->middleware('can:active branches');
                Route::post('branches/{branch}', [BranchController::class, 'update'])->name('branches.update')->middleware('can:update branches');
                Route::apiResource('branches', BranchController::class)->except('update')->middleware('check_permissions');
            });
            /*Customers*/
            Route:: as('customers.')->prefix('customers')->group(function () {
                Route::put('block/{user}', [CustomerController::class, 'block'])->name('block')->middleware('can:block customers');
                Route::put('active/{user}', [CustomerController::class, 'active'])->name('active')->middleware('can:active customers');
                Route::get('all', [CustomerController::class, 'index'])->name('index');
                Route::get('all_customers', [CustomerController::class, 'all'])->name('all');
                Route::post('store', [CustomerController::class, 'store'])->name('store')->middleware('can:create customers');
                Route::get('show/{user}', [CustomerController::class, 'show'])->name('show');
                Route::post('update/{user}', [CustomerController::class, 'update'])->name('update')->middleware('can:update customers');
                Route::delete('delete/{user}', [CustomerController::class, 'destroy'])->name('destroy')->middleware('can:delete customers');
            });
            /*Setting*/
            Route:: as('settings.')
                ->prefix('settings')
                ->group(function () {
                    Route::post('{setting}/update', [SettingController::class, 'update'])->name('update')->middleware('can:update settings');
                    Route::get('{setting}', [SettingController::class, 'show'])->name('show');
                });
            /*Orders*/
            Route::group([], function () {
                /*Export Orders in excel sheet*/
                Route::get('orders/export', ExportOrdersController::class)->name('orders.export')->middleware('can:show orders');
                /*Import Orders in excel sheet*/
                Route::post('orders/import', ImportOrdersController::class)->name('orders.import')->middleware('can:show orders');
                /*Follow Order*/
                Route::post('orders/follow-order', [OrderController::class, 'follow'])->name('orders.follow')->middleware('can:follow orders');
                Route::post('orders', [OrderController::class, 'store'])->name('orders.store')->middleware('can:create orders');
                Route::apiResource('orders', OrderController::class)->only(['index', 'show']);
            });
            /*statuses*/
            Route::group([], function () {
                /*Get substauses by status id*/
                Route::get('statuses/{status}/substatuses', [StatusController::class, 'substatuses'])->name('statuses.substatuses');
                Route::apiResource('statuses', StatusController::class)->only(['index', 'show']);
            });
            /*SubStatues*/
            Route::apiResource('substatuses', SubStatusController::class)->only(['index', 'show']);
            /*Countries*/
            Route::get('countries', CountryController::class)->name('countries');

            /*Portfolio Categories*/
            Route::group([], function () {
                Route::put('portfolio-categories/{portfolio_category}/block', [PortfolioCategoryController::class, 'block'])->name('portfolio-categories.block')->middleware('can:block portfolio-categories');
                Route::put('portfolio-categories/{portfolio_category}/active', [PortfolioCategoryController::class, 'active'])->name('portfolio-categories.active')->middleware('can:active portfolio-categories');
                Route::post('portfolio-categories/{portfolio_category}', [PortfolioCategoryController::class, 'update'])->name('portfolio-categories.update')->middleware('can:update portfolio-categories');
                Route::apiResource('portfolio-categories', PortfolioCategoryController::class)->except('update')->middleware('check_permissions');
            });
            /*ContactUs*/
            Route::group([], function () {
                Route::get('contactUs', [ContactUsController::class, 'index'])->name('index')->middleware('check_permissions');;
                Route::get('contactUs/{contactUs}', [ContactUsController::class, 'show'])->name('show')->middleware('check_permissions');;
            });

            /*Portfolios*/
            Route::group([], function () {
                Route::put('portfolios/{portfolio}/block', [PortfolioController::class, 'block'])->name('portfolios.block')->middleware('can:block portfolios');
                Route::put('portfolios/{portfolio}/active', [PortfolioController::class, 'active'])->name('portfolios.active')->middleware('can:active portfolios');
                Route::post('portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update')->middleware('can:update portfolios');
                Route::apiResource('portfolios', PortfolioController::class)->except('update')->middleware('check_permissions');
            });
        });
        //Reports
        Route:: as('reports.')
            ->prefix('reports')
            ->group(function () {
            Route::get('sources', SourcesReportController::class)->name('sources')->middleware('can:show sources reports');
            Route::get('moderators', ModeratorsReportController::class)->name('moderators')->middleware('can:show moderators reports');
            Route::get('statuses', StatusesReportController::class)->name('statuses')->middleware('can:show statuses reports');
        });
    });

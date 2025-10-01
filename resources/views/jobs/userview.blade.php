<?php
// unactive  controllers
use App\Http\Controllers\auth\AuthenticatedSessionController;
use App\Http\Middleware\RedirectBasedOnRole;
use App\Http\Controllers\SubAccountController;
use App\Http\Controllers\StaffPaymentController;


use Illuminate\Support\Facades\Route;


// Models baing used 
use App\Models\{
    Pricing,
    Package,
    Plan,
    LegalDocument,
};


// Authentication  controller
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
 

// public controllers
use App\Http\Controllers\{

DashboardController,
Personal_solutionsController,
ProfileController,
HomepageController,
SolutionController,
ServicesController,
PackageController,
MoreController,
EventController,
ContactController,
SubscriptionController,
AboutController

};

// user  controllers
use App\Http\Controllers\User\Account\ProfileAccountController;

use App\Http\Controllers\User\Finance\{
    ExpenseController,
    InvoiceController,
    ReportController,
    PaymentController,
    BudgetController,
    FinanceController
};

// staff  controllers



// admin  controllers
use App\Http\Controllers\Admin\Finance\{
   AdminPaymentController,
   AdminExpenseController,
   AdminBudgetController,
   AdminInvoiceController,
   AdminReportController,
   ReportExportController
};

// web controllers
use App\Http\Controllers\Web\{
    WebHomepageContentController,
    WebHomepageContentTableController,
    WebCompanyStatementController,
    WebServicesController,
    WebServicesTableController,
    WebPersonalSolutionController,
    WebIndustrialSolutionTableController ,
    WebPersonalSolutionTableController,
    WebIndustrialSolutionController,
    WebMoreController,
    WebMoreTableController,
    WebEventTableController,
    WebEventController,
    WebAboutController,
    WebAboutTableController,
    WebPackageController,
    WebPricingController,
    WebLegalController,
    WebUserController

};

use App\Http\Controllers\Web\General\{
FooterController,
SocialController,
LogoController,
PartnersController
};


// ----------------------------------------------- //
// Registration Pages (Custom for Admin Dashboard) //
// ----------------------------------------------- //

// Admin Registration Form (page loads inside iframe)
Route::get('/admin/register/admin', [RegisteredUserController::class, 'showAdminRegisterForm'])->name('admin.register.admin');

// Admin Registration Form Submit
Route::post('/admin/register/admin', [RegisteredUserController::class, 'storeAdmin'])->name('admin.register.admin.store');

// Staff Registration Form (page loads inside iframe)
Route::get('/admin/register/staff', [RegisteredUserController::class, 'showStaffRegisterForm'])->name('admin.register.staff');

// Staff Registration Form Submit
Route::post('/admin/register/staff', [RegisteredUserController::class, 'storeStaff'])->name('admin.register.staff.store');

// -------------------
// Public Routes
// -------------------
Route::get('/', [HomepageController::class, 'index']);
Route::get('/solutions', [SolutionController::class, 'showSolutions'])->name('solutions.index');
Route::get('/solutions/view/{id}', [SolutionController::class, 'showDetail'])->name('solutions.show');

Route::get('/personal_solutions', [Personal_solutionsController::class, 'showSolutions'])->name('personal_solutions.index');
Route::get('/personal_solutions/view/{id}', [Personal_solutionsController::class, 'showDetail'])->name('personal_solutions.show');

Route::get('/services', [ServicesController::class, 'showSolutions'])->name('services.index');
Route::get('/services/view/{id}', [ServicesController::class, 'show'])->name('services.show');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/more', [MoreController::class, 'showSolutions']);
Route::get('/pricing', [PackageController::class, 'pricingPage']);
Route::get('/premium', [PackageController::class, 'premiumPage']);

Route::get('/events', [EventController::class, 'showEvents'])->name('events.index');
Route::get('/events/view/{id}', [EventController::class, 'show'])->name('events.show');

Route::view('/loading_count_down', 'loading_count_down');
Route::view('/page_loading', 'page_loading');

Route::view('/emails/sales_contact_form', '/emails/sales_contact_form');

Route::get('/load-more-packages', [PackageController::class, 'loadMore']);

Route::get('/about', [AboutController::class, 'index'])->name('about.index');

Route::view('careers', 'careers');




Route::get('/legal/{slug}', function ($slug) {
    $document = LegalDocument::where('slug', $slug)->with(['sections.listItems'])->firstOrFail();
    return view('legal.show', compact('document'));
})->name('legal.show');




Route::get('/plan/compare', function () {
    $packages = Package::all(); // <-- fetch packages

    return view('plan.compare', compact('packages')); // <-- pass packages to view
})->name('compare');

Route::get('/pricing', function () {
    $pricing = Pricing::all();
    $packages = Package::with('plans.features')->get();
    return view('pricing-page', compact('pricing', 'packages'));
})->name('pricing.page');

Route::get('/plan/{id}', function ($id) {
    $plan = Plan::with('features')->findOrFail($id);
    $packages = Package::all(); // 

    return view('plan-detail', compact('plan', 'packages'));
})->name('plan.details');









// -------------------------------------
// Admin Dashboard (Role: admin only)
// -------------------------------------

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');



    
    // Subscriptions Management (Admin Panel)
    Route::prefix('admin/subscriptions')->controller(SubscriptionController::class)->name('admin.subscriptions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pending')->name('pending');
        Route::get('/approved', 'approved')->name('approved');
        Route::get('/rejected', 'rejected')->name('rejected');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}/', 'update')->name('update');
        Route::post('/{id}/approve', 'approve')->name('approve');
        Route::post('/{id}/reject', 'reject')->name('reject');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });



Route::prefix('admin/finance')->name('admin.finance.')->group(function () {
    
    Route::get('/', [AdminPaymentController::class, 'index'])->name('index');

});

Route::prefix('admin/finance/payments')->name('admin.finance.payments.')->middleware(['auth', 'role:1'])->group(function () {
    Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
    Route::get('/{payment}', [AdminPaymentController::class, 'show'])->name('show');
    Route::get('/{payment}/edit', [AdminPaymentController::class, 'edit'])->name('edit');
    Route::put('/{payment}', [AdminPaymentController::class, 'update'])->name('update');
});


Route::prefix('admin/finance/expenses')->name('admin.finance.expenses.')->middleware(['auth', 'role:1'])->group(function () {
    Route::get('/', [AdminExpenseController::class, 'index'])->name('index');
    Route::get('/{expense}', [AdminExpenseController::class, 'show'])->name('show');
    Route::get('/{expense}/edit', [AdminExpenseController::class, 'edit'])->name('edit');
    Route::put('/{expense}', [AdminExpenseController::class, 'update'])->name('update');
    Route::delete('/{expense}', [AdminExpenseController::class, 'destroy'])->name('destroy');
});


Route::prefix('admin/finance/budgets')->name('admin.finance.budgets.')->group(function () {
    Route::get('/', [AdminBudgetController::class, 'index'])->name('index');
    Route::get('/create', [AdminBudgetController::class, 'create'])->name('create');
    Route::post('/', [AdminBudgetController::class, 'store'])->name('store');
    Route::get('/{budget}', [AdminBudgetController::class, 'show'])->name('show');
    Route::get('/{budget}/edit', [AdminBudgetController::class, 'edit'])->name('edit');
    Route::put('/{budget}', [AdminBudgetController::class, 'update'])->name('update');
    Route::delete('/{budget}', [AdminBudgetController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/finance/invoices')->name('admin.finance.invoices.')->group(function () {
    Route::get('/', [AdminInvoiceController::class, 'index'])->name('index');
    Route::get('/create', [AdminInvoiceController::class, 'create'])->name('create');
    Route::post('/', [AdminInvoiceController::class, 'store'])->name('store');
    Route::get('/{invoice}', [AdminInvoiceController::class, 'show'])->name('show');
    Route::get('/{invoice}/edit', [AdminInvoiceController::class, 'edit'])->name('edit');
    Route::put('/{invoice}', [AdminInvoiceController::class, 'update'])->name('update');
    Route::delete('/{invoice}', [AdminInvoiceController::class, 'destroy'])->name('destroy');
});





Route::prefix('admin/finance/reports')->name('admin.finance.reports.')->group(function () {

    // 📊 Report Views


    Route::get('/', [AdminReportController::class, 'index'])->name('index');
    Route::get('/details/{type}', [AdminReportController::class, 'details'])->name('details');


 
    // 📦 Export Endpoints (CSV/XLSX)



    Route::get('/export/payments', [ReportExportController::class, 'exportPayments'])->name('reports.export.payments');
    Route::get('/export/invoices', [ReportExportController::class, 'exportInvoices'])->name('reports.export.invoices');
    Route::get('/export/expenses', action: [ReportExportController::class, 'exportExpenses'])->name('reports.export.expenses');
    Route::get('/export/budgets', [ReportExportController::class, 'exportBudgets'])->name('reports.export.budgets');







});











// web routes)

// --- Homepage Main Content ---
// web routes

// --- Homepage Main Content ---
Route::prefix('admin/web/homepage')->name('admin.web.homepage.')->group(function () {

    // Homepage Content
    Route::get('/content/edit', [WebHomepageContentController::class, 'edit'])->name('content.edit');
    Route::post('/content/update', [WebHomepageContentController::class, 'update'])->name('content.update');

    // Homepage Content Table
    Route::prefix('table')->name('table.')->group(function () {
        Route::get('/', [WebHomepageContentTableController::class, 'index'])->name('index');
        Route::get('/create', [WebHomepageContentTableController::class, 'create'])->name('create');
        Route::post('/', [WebHomepageContentTableController::class, 'store'])->name('store');
        Route::get('/{table}/edit', [WebHomepageContentTableController::class, 'edit'])->name('edit');
        Route::put('/{table}', [WebHomepageContentTableController::class, 'update'])->name('update');
        Route::delete('/{table}', [WebHomepageContentTableController::class, 'destroy'])->name('destroy');
    });

    // Company Statements
    Route::prefix('statements')->name('statements.')->group(function () {
        Route::get('/', [WebCompanyStatementController::class, 'index'])->name('index');
        Route::get('/create', [WebCompanyStatementController::class, 'create'])->name('create');
        Route::post('/store', [WebCompanyStatementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [WebCompanyStatementController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [WebCompanyStatementController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [WebCompanyStatementController::class, 'destroy'])->name('destroy');
    });


});



// --- terms and privacy Section ---

Route::prefix('admin/web/legal')->name('admin.web.legal.')->group(function() {
    Route::get('/', [WebLegalController::class, 'index'])->name('index');
    Route::get('/create', [WebLegalController::class, 'create'])->name('create');
    Route::post('/', [WebLegalController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [WebLegalController::class, 'edit'])->name('edit');
    Route::put('/{id}', [WebLegalController::class, 'update'])->name('update');
    Route::delete('/{id}', [WebLegalController::class, 'destroy'])->name('destroy');
});



// --- users Section ---

Route::prefix('admin/web/users')->name('admin.web.users.')->middleware('auth')->group(function () {
    Route::get('/', [WebUserController::class, 'index'])->name('index');
    Route::get('/create', [WebUserController::class, 'create'])->name('create');
    Route::post('/', [WebUserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [WebUserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [WebUserController::class, 'update'])->name('update');
    Route::delete('/{user}', [WebUserController::class, 'destroy'])->name('destroy');
});












// --- general Section ---



Route::prefix('admin/web/general/footer')->name('admin.web.general.footer.')->group(function () {

    // --- Footer Titles ---
    Route::get('/titles', [FooterController::class, 'titleIndex'])->name('titles.index');
    Route::get('/titles/create', [FooterController::class, 'titleCreate'])->name('titles.create');
    Route::post('/titles/store', [FooterController::class, 'titleStore'])->name('titles.store');
    Route::get('/titles/{title}/edit', [FooterController::class, 'titleEdit'])->name('titles.edit');
    Route::put('/titles/{title}/update', [FooterController::class, 'titleUpdate'])->name('titles.update');
    Route::delete('/titles/{title}', [FooterController::class, 'titleDestroy'])->name('titles.destroy');

    // --- Footer Items ---
    Route::get('/items', [FooterController::class, 'itemIndex'])->name('items.index');
    Route::get('/items/create', [FooterController::class, 'itemCreate'])->name('items.create');
    Route::post('/items/store', [FooterController::class, 'itemStore'])->name('items.store');
    Route::get('/items/{item}/edit', [FooterController::class, 'itemEdit'])->name('items.edit');
    Route::put('/items/{item}/update', [FooterController::class, 'itemUpdate'])->name('items.update');
    Route::delete('/items/{item}', [FooterController::class, 'itemDestroy'])->name('items.destroy');

});

   // --- socials  under general---
Route::prefix('admin/web/general/socials')->name('admin.web.general.socials.')->group(function () {
    Route::get('/', [SocialController::class, 'index'])->name('index');
    Route::get('/create', [SocialController::class, 'create'])->name('create');
    Route::post('/store', [SocialController::class, 'store'])->name('store');
    Route::get('/{social}/edit', [SocialController::class, 'edit'])->name('edit');
    Route::put('/{social}', [SocialController::class, 'update'])->name('update');
    Route::delete('/{social}', [SocialController::class, 'destroy'])->name('destroy');
});


// --- logo under general---

Route::prefix('admin/web/general/logo')->name('admin.web.general.logo.')->group(function () {
    Route::get('/', [LogoController::class, 'index'])->name('index');
    Route::get('/create', [LogoController::class, 'create'])->name('create');
    Route::post('/store', [LogoController::class, 'store'])->name('store');
    Route::get('/{logo}/edit', [LogoController::class, 'edit'])->name('edit');
    Route::put('/{logo}/update', [LogoController::class, 'update'])->name('update');
    Route::delete('/{logo}/delete', [LogoController::class, 'destroy'])->name('destroy');
});


// --- partiners under general---




Route::prefix('admin/web/general/partners')->name('admin.web.general.partners.')->group(function () {
    Route::get('/', [PartnersController::class, 'index'])->name('index');
    Route::get('/create', [PartnersController::class, 'create'])->name('create');
    Route::post('/store', [PartnersController::class, 'store'])->name('store');
    Route::get('/{partner}/edit', [PartnersController::class, 'edit'])->name('edit');
    Route::put('/{partner}/update', [PartnersController::class, 'update'])->name('update');
    Route::delete('/{partner}/delete', [PartnersController::class, 'destroy'])->name('destroy');
});



// --- more Section ---




Route::prefix('admin/web/more')->name('admin.web.more')->group(function () {

    // Main "More"  Content (Single Row)
    Route::prefix('/')->name('.')->group(function () {
        Route::get('/edit', [WebMoreController::class, 'edit'])->name('edit');
        Route::post('/update', [WebMoreController::class, 'update'])->name('update');
    });

    // "More"  Table (Multiple Rows)
    Route::prefix('/table')->name('.table.')->group(function () {
        Route::get('/', [WebMoreTableController::class, 'index'])->name('index');
        Route::get('/create', [WebMoreTableController::class, 'create'])->name('create');
        Route::post('/store', [WebMoreTableController::class, 'store'])->name('store');
        Route::get('/edit/{table}', [WebMoreTableController::class, 'edit'])->name('edit');
        Route::put('/update/{table}', [WebMoreTableController::class, 'update'])->name('update');
        Route::delete('/delete/{table}', [WebMoreTableController::class, 'destroy'])->name('destroy');
    });

});






// --- about Section ---

Route::prefix('admin/web/about')->name('admin.web.about')->group(function () {

    // Main About Content (Single Row)
    Route::prefix('/')->name('.')->group(function () {
        Route::get('/edit', [WebAboutController::class, 'edit'])->name('edit');
        Route::post('/update', [WebAboutController::class, 'update'])->name('update');
    });

    // About Table Content (Multiple Rows)
    Route::prefix('/table')->name('.table.')->group(function () {
        Route::get('/', [WebAboutTableController::class, 'index'])->name('index');
        Route::get('/create', [WebAboutTableController::class, 'create'])->name('create');
        Route::post('/store', [WebAboutTableController::class, 'store'])->name('store');
        Route::get('/edit/{table}', [WebAboutTableController::class, 'edit'])->name('edit');
        Route::post('/update/{table}', [WebAboutTableController::class, 'update'])->name('update');
        Route::delete('/delete/{table}', [WebAboutTableController::class, 'destroy'])->name('destroy');
    });

});


// --- Events Section ---
Route::prefix('admin/web/event')->name('admin.web.event')->group(function () {

    // Main Event Content (Single Row)
    Route::prefix('/')->name('.')->group(function () {
        Route::get('/edit', [WebEventController::class, 'edit'])->name('edit');
        Route::post('/update', [WebEventController::class, 'update'])->name('update');
    });

    // Event Table Content (Multiple Rows)
    Route::prefix('/table')->name('.table.')->group(function () {
        Route::get('/', [WebEventTableController::class, 'index'])->name('index');
        Route::get('/create', [WebEventTableController::class, 'create'])->name('create');
        Route::post('/store', [WebEventTableController::class, 'store'])->name('store');
        Route::get('/edit/{table}', [WebEventTableController::class, 'edit'])->name('edit');
        Route::put('/update/{table}', [WebEventTableController::class, 'update'])->name('update');
        Route::delete('/delete/{table}', [WebEventTableController::class, 'destroy'])->name('destroy');
    });

});




// --- pricing Section(page) ---




Route::prefix('admin/web/pricing')->name('admin.web.pricing.')->group(function () {
    Route::get('/edit', [WebPricingController::class, 'edit'])->name('edit');
    Route::put('/update', [WebPricingController::class, 'update'])->name('update');
});

// --- pricing page content

// Grouping under admin and web general namespace (adjust as needed)
Route::prefix('admin/web/package')->name('admin.web.package.')->group(function () {
    Route::get('/', [WebPackageController::class, 'index'])->name('index');
    Route::get('/create', [WebPackageController::class, 'create'])->name('create');
    Route::post('/', [WebPackageController::class, 'store'])->name('store');
    Route::get('/{package}/edit', [WebPackageController::class, 'edit'])->name('edit');
    Route::put('/{package}', [WebPackageController::class, 'update'])->name('update');
    Route::delete('/{package}', [WebPackageController::class, 'destroy'])->name('destroy');

});


// --- Solutions Section ---


// --- Industrial Solution Section ---
Route::prefix('admin/web/solution/industrial')->name('admin.web.solution.industrial')->group(function () {

    // Main Industrial Content (Single Row)
    Route::prefix('/')->name('.')->group(function () {
        Route::get('/edit', [WebIndustrialSolutionController::class, 'edit'])->name('edit');
        Route::post('update', [WebIndustrialSolutionController::class, 'update'])->name('update');
    });

    // Industrial Solution Table (Multiple Rows)
    Route::prefix('/table')->name('.table.')->group(function () {
        Route::get('/', [WebIndustrialSolutionTableController::class, 'index'])->name('index');
        Route::get('/create', [WebIndustrialSolutionTableController::class, 'create'])->name('create');
        Route::post('/store', [WebIndustrialSolutionTableController::class, 'store'])->name('store');
        Route::get('/edit/{table}', [WebIndustrialSolutionTableController::class, 'edit'])->name('edit');
        Route::put('/update/{table}', [WebIndustrialSolutionTableController::class, 'update'])->name('update');
        Route::delete('/delete/{table}', [WebIndustrialSolutionTableController::class, 'destroy'])->name('destroy');
    });

});



// --- personal-solutionSection ---
Route::prefix('admin/web/solution/personal')->name('admin.web.solution.personal.')->group(function () {

    // --- Personal Solution Main Content ---
    Route::get('/edit', [WebPersonalSolutionController::class, 'edit'])->name('edit');
    Route::put('/update', [WebPersonalSolutionController::class, 'update'])->name('update');

    // --- Personal Solution Table Section ---
    Route::prefix('/table')->name('table.')->group(function () {
        Route::get('/', [WebPersonalSolutionTableController::class, 'index'])->name('index');
        Route::get('/create', [WebPersonalSolutionTableController::class, 'create'])->name('create');
        Route::post('/store', [WebPersonalSolutionTableController::class, 'store'])->name('store');
        Route::get('/edit/{table}', [WebPersonalSolutionTableController::class, 'edit'])->name('edit');
        Route::put('/update/{table}', [WebPersonalSolutionTableController::class, 'update'])->name('update');
        Route::delete('/delete/{table}', [WebPersonalSolutionTableController::class, 'destroy'])->name('destroy');
    });

});










// --- Services Content ---
Route::prefix('admin/web/services')->name('admin.web.services.')->group(function () {

    // Services Content

Route::prefix('/')->name('')->group(function () {
Route::get('/edit', [WebServicesController::class, 'edit'])->name('edit');
Route::post('/update', [WebServicesController::class, 'update'])->name('update');
  });


Route::prefix('/table')->name('table.')->group(function () {
    Route::get('/', [WebServicesTableController::class, 'index'])->name('index');
    Route::get('/create', [WebServicesTableController::class, 'create'])->name('create');
    Route::post('/', [WebServicesTableController::class, 'store'])->name('store');
    Route::get('/{table}/edit', [WebServicesTableController::class, 'edit'])->name('edit');
    Route::put('/{table}', [WebServicesTableController::class, 'update'])->name('update');
    Route::delete('/{table}', [WebServicesTableController::class, 'destroy'])->name('destroy');
});

});








});








// -------------------------------------
// Staff Dashboard (Role: staff only)
// -------------------------------------
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');

    // Add more staff-specific routes here
    

    
});

// -------------------------------------
// User Dashboard (Role: user only)


Route::middleware(['auth', 'role:3'])->group(function () {

    // Dashboard
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // Subscription Plan Selection
    Route::get('/select-payment', [PaymentController::class, 'select'])->name('payment.select');
    Route::post('/user/finance/payments/subscription/apply', [SubscriptionController::class, 'apply'])->name('subscription.apply');


     Route::post('/subscription/apply', [SubscriptionController::class, 'apply'])->name('subscription.apply');
    Route::get('/finance/subscription/thankyou', [SubscriptionController::class, 'thankYou'])->name('finance.subscription.thankyou');

    // Finance Main Group
    Route::prefix('user/finance')->group(function () {

        // Finance Overview
        Route::get('/', [FinanceController::class, 'index'])->name('user.finance.index');

        // Expenses
        Route::prefix('expenses')->group(function () {
            Route::get('/', [ExpenseController::class, 'index'])->name('expenses.index');
            Route::get('/create', [ExpenseController::class, 'create'])->name('expenses.create');
            Route::post('/', [ExpenseController::class, 'store'])->name('expenses.store');
        });

         // Invoices
    Route::prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('user.finance.invoices.index');
    Route::get('/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/view/{invoice}', [InvoiceController::class, 'show'])->name('user.finance.invoices.view');


    // Invoice Payment Routes
    Route::get('/pay/{invoice}', [PaymentController::class, 'createFromInvoice'])->name('user.finance.invoices.pay');
    Route::post('/pay/{invoice}', [PaymentController::class, 'storeInvoicePayment'])->name('user.finance.invoices.pay.submit');
});

// Payments
Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/create/{subscription_id}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/', [PaymentController::class, 'store'])->name('payments.store');
    Route::delete('/{id}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');
     Route::get('/{id}', [PaymentController::class, 'show'])->name('payments.show');
     Route::get('/proceed/{payment}', [PaymentController::class, 'proceed'])->name('payments.proceed');


    // General Payment (not linked to subscription or invoice)
    Route::get('/general/create', [PaymentController::class, 'createGeneral'])->name('payments.general.create');
    Route::post('/general', [PaymentController::class, 'storeGeneral'])->name('payments.general.store');
});





        // Budgets
        Route::prefix('budgets')->group(function () {
            Route::get('/', [BudgetController::class, 'index'])->name('user.finance.budgets.index');
            Route::get('/create', [BudgetController::class, 'create'])->name('budgets.create');
            Route::post('/', [BudgetController::class, 'store'])->name('budgets.store');
        });

        // Reports
        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        });

     //subs
            Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscriptions.index');

    });

// Account Setup Profile Completion
    Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/user/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');

    //  Full Profile CRUD (post-setup)
    Route::get('/user/profile/account', [ProfileAccountController::class, 'index'])->name('user.profile.account.index');
    Route::get('/user/profile/account/edit', [ProfileAccountController::class, 'edit'])->name('user.profile.account.edit');
    Route::put('/user/profile/account', [ProfileAccountController::class, 'update'])->name('user.profile.account.update');
    Route::delete('/user/profile/account', [ProfileAccountController::class, 'destroy'])->name('user.profile.account.destroy');
});


// Keep this LAST so default auth routes don’t override custom ones

require __DIR__.'/auth.php';
Route::get('/auth/google/redirect', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook/redirect', [LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/auth/facebook/callback', [LoginController::class, 'handleFacebookCallback']);

Route::get('/auth/apple/redirect', [LoginController::class, 'redirectToApple'])->name('login.apple');
Route::get('/auth/apple/callback', [LoginController::class, 'handleAppleCallback']);




Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route(match (auth()->user()->role_id) {
            1 => 'admin.dashboard',
            2 => 'staff.dashboard',
            3 => 'user.dashboard',
        });
    }

    return view('auth.login');
})->name('login');
    
Route::get('/register', function () {
    if (auth()->check()) {
        return redirect()->route(match (auth()->user()->role_id) {
            1 => 'admin.dashboard',
            2 => 'staff.dashboard',
            3 => 'user.dashboard',
        });
    }

    return view('auth.register');
})->name('register');
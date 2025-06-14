<!-- Sidenav header -->
<div class="sidenav-header d-flex align-items-center">
    <a class="navbar-brand" href="#">
        <img src="<?php echo e(asset(Storage::url('logo/logo.png'))); ?>" class="navbar-brand-img" alt="...">
    </a>
    <div class="ml-auto">
        <!-- Sidenav toggler -->
        <div class="sidenav-toggler sidenav-toggler-dark d-md-none" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line bg-white"></i>
                <i class="sidenav-toggler-line bg-white"></i>
                <i class="sidenav-toggler-line bg-white"></i>
            </div>
        </div>
    </div>
</div>
<!-- User mini profile -->
<div class="sidenav-user d-flex flex-column align-items-center justify-content-between text-center">
    <!-- Avatar -->
    <div>
        <a href="#" class="avatar rounded-circle avatar-xl">
            <img class="avatar rounded-circle avatar-xl" <?php echo e(Auth::user()->img_avatar); ?> />
        </a>
        <div class="mt-4">
            <h5 class="mb-0 text-white"><?php echo e(Auth::user()->name); ?></h5>
            <span class="d-block text-sm text-white opacity-8 mb-3"><?php echo e(Auth::user()->email); ?></span>
            <?php if(Auth::user()->type != 'admin'): ?>
                <a href="<?php echo e(route('users.info',Auth::user()->id)); ?>" class="btn btn-sm btn-white btn-icon rounded-pill shadow hover-translate-y-n3">
                    <span class="btn-inner--icon"><i class="fas fa-coins"></i></span>
                    <span class="btn-inner--text"><?php echo e(__('My Overview')); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <!-- User info -->
    <!-- Actions -->
    <?php if(Auth::user()->type != 'admin'): ?>
        <div class="w-100 mt-4 actions">
            <a href="<?php echo e(route('profile')); ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo e(__('Profile')); ?>" class="action-item action-item-lg text-white pl-0 mr-5">
                <i class="fas fa-user"></i>
            </a>
            <a href="<?php echo e(route('expense.list')); ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo e(__('Expense')); ?>" class="action-item action-item-lg text-white pr-0">
                <i class="fas fa-receipt"></i>
            </a>
        </div>
    <?php endif; ?>
</div>
<!-- Application nav -->
<div class="nav-application clearfix">
    <a href="<?php echo e(route('home')); ?>" class="btn btn-square text-sm <?php echo e((Request::route()->getName() == 'home') ? 'active' : ''); ?>">
        <span class="btn-inner--icon d-block"><i class="fas fa-home fa-2x"></i></span>
        <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Home')); ?></span>
    </a>
    <?php if(Auth::user()->type != 'admin'): ?>
        <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('project*') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-project-diagram fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Projects')); ?></span>
        </a>
        <a href="<?php echo e(route('taskBoard.view')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('taskboard*') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-tasks fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Tasks')); ?></span>
        </a>
        <a href="<?php echo e(route('users')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('users*') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-users fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Members')); ?></span>
        </a>
        <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('invoices*') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-receipt fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Invoices')); ?></span>
        </a>
        <a href="<?php echo e(route('task.calendar',['all'])); ?>" class="btn btn-square text-sm <?php echo e(request()->is('calendar*') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-calendar-week fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Calendar')); ?></span>
        </a>
        <a href="<?php echo e(route('timesheet.list')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('timesheet-list') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-clock fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Timesheet')); ?></span>
        </a>
         <a href="<?php echo e(route('time.tracker')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('time-tracker') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-stopwatch fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Tracker')); ?></span>
        </a>
        <a href="<?php echo e(route('zoommeeting.index')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('zoommeeting*') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-video fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Zoom Meeting')); ?></span>
        </a>
        <a href="<?php echo e(url('chats')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('chats') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-comments fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Messages')); ?></span>
        </a>

    <?php endif; ?>
    <?php if(Auth::user()->type == 'admin'): ?>
        <a href="<?php echo e(route('lang',basename(App::getLocale()))); ?>" class="btn btn-square text-sm <?php echo e(request()->is('lang*') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-language fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Language')); ?></span>
        </a>
        <a href="<?php echo e(route('email_template.index')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('email_template*') ? 'active' : ''); ?>">
            <span class="btn-inner--icon d-block"><i class="fas fa-envelope fa-2x"></i></span>
            <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Email Template')); ?></span>
        </a>
    <?php endif; ?>
    <a href="<?php echo e(route('settings')); ?>" class="btn btn-square text-sm <?php echo e(request()->is('settings*') ? 'active' : ''); ?>">
        <span class="btn-inner--icon d-block"><i class="fas fa-cogs fa-2x"></i></span>
        <span class="btn-inner--icon d-block pt-2"><?php echo e(__('Settings')); ?></span>
    </a>
   
</div>
<?php /**PATH /home/wladiveras.com/public_html/resources/views/partials/admin/sidebar.blade.php ENDPATH**/ ?>
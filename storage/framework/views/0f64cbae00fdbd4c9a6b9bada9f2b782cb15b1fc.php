<aside class="customizer">
    <a href="javascript:void(0)" class="service-panel-toggle">
        <i class="fa fa-spin fa-cog"></i>
    </a>
    <div class="customizer-body">
        <ul class="nav customizer-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab
                " aria-controls="pills-home" aria-selected="true">
                <i class="mdi mdi-wrench font-20"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab
            " aria-controls="pills-contact" aria-selected="false">
            <i class="mdi mdi-star-circle font-20"></i>
        </a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <!-- Tab 1 -->
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="p-15 border-bottom">
            <!-- Sidebar -->
            <h5 class="font-medium m-b-10 m-t-10">Layout Settings</h5>
            <div class="custom-control custom-checkbox m-t-10">
                <input type="checkbox" class="custom-control-input" name="theme-view" id="theme-view">
                <label class="custom-control-label" for="theme-view">Dark Theme</label>
            </div>
            <div class="custom-control custom-checkbox m-t-10">
                <input type="checkbox" class="custom-control-input sidebartoggler" name="collapssidebar
                " id="collapssidebar">
                <label class="custom-control-label" for="collapssidebar">Collapse Sidebar</label>
            </div>
            <div class="custom-control custom-checkbox m-t-10">
                <input type="checkbox" class="custom-control-input" name="sidebar-position" id="sidebar-position">
                <label class="custom-control-label" for="sidebar-position">Fixed Sidebar</label>
            </div>
            <div class="custom-control custom-checkbox m-t-10">
                <input type="checkbox" class="custom-control-input" name="header-position" id="header-position">
                <label class="custom-control-label" for="header-position">Fixed Header</label>
            </div>
            <div class="custom-control custom-checkbox m-t-10">
                <input type="checkbox" class="custom-control-input" name="boxed-layout" id="boxed-layout">
                <label class="custom-control-label" for="boxed-layout">Boxed Layout</label>
            </div>
        </div>
        <div class="p-15 border-bottom">
            <!-- Logo BG -->
            <h5 class="font-medium m-b-10 m-t-10">Logo Backgrounds</h5>
            <ul class="theme-color">
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-logobg="skin1"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-logobg="skin2"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-logobg="skin3"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-logobg="skin4"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-logobg="skin5"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-logobg="skin6"></a>
                </li>
            </ul>
            <!-- Logo BG -->
        </div>
        <div class="p-15 border-bottom">
            <!-- Navbar BG -->
            <h5 class="font-medium m-b-10 m-t-10">Navbar Backgrounds</h5>
            <ul class="theme-color">
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-navbarbg="skin1"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-navbarbg="skin2"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-navbarbg="skin3"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-navbarbg="skin4"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-navbarbg="skin5"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-navbarbg="skin6"></a>
                </li>
            </ul>
            <!-- Navbar BG -->
        </div>
        <div class="p-15 border-bottom">
            <!-- Logo BG -->
            <h5 class="font-medium m-b-10 m-t-10">Sidebar Backgrounds</h5>
            <ul class="theme-color">
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin1"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin2"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin3"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin4"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin5"></a>
                </li>
                <li class="theme-item">
                    <a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin6"></a>
                </li>
            </ul>
            <!-- Logo BG -->
        </div>
    </div>
    <!-- End Tab 1 -->
    <!-- Tab 2 -->
    <div class="tab-pane fade p-15" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
        <h6 class="m-t-20 m-b-20">Activity Timeline</h6>
        <div class="steamline">
            <?php $__currentLoopData = activityTimeline(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="sl-item">
                <?php if($row->action == 'Create'): ?>
                <div class="sl-left bg-success">
                    <i class="ti-arrow-circle-up"></i>
                </div>
                <?php elseif($row->action == 'Read'): ?>
                <?php elseif($row->action == 'Update'): ?>
                <div class="sl-left bg-info">
                    <i class="ti-info"></i>
                </div>
                <?php elseif($row->action == 'Delete'): ?>
                <div class="sl-left bg-danger">
                    <i class="ti-trash"></i>
                </div>
                <?php endif; ?>
                
                <div class="sl-right">
                    <div class="font-medium"><?php echo e($row->page); ?>

                        <span class="sl-date"> <?php echo e(timeHumanReadable($row->created_at)); ?></span>
                    </div>
                    <div class="desc"><?php echo e($row->description); ?> </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <hr>
        <center><button class="btn btn-primary">View All</button></center>
    </div>
    <!-- End Tab 2 -->
</div>
</aside><?php /**PATH C:\xampp\htdocs\absensi\resources\views/components/customizer.blade.php ENDPATH**/ ?>
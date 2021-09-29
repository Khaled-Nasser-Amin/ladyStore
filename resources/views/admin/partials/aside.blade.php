<div class="left-side-menu" style="background-image: url('{{ asset('images/lady_logo.webp') }}'); background-size:contain;background-color:#e6dddd">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                    <li class="menu-title text-dark" >{{__('text.Navigation')}}</li>
                @can('isAdmin')
                    <li ><a href="{{route('admin.index_for_app')}}" class="text-dark"><i class="mdi mdi-view-dashboard"></i>{{__('text.Dashboard For App')}}</a></li>
                @endcan
                    <li ><a href="{{route('admin.index')}}" class="text-dark"><i class="mdi mdi-home"></i>{{__('text.Dashboard')}}</a></li>
                @can('isAdmin')
                    <li><a href="{{route('admin.categories')}}" class="text-dark"><i class="mdi mdi-hanger"></i>{{__('text.Categories')}}</a></li>
                @endcan
                    <li><a href="{{route('admin.products')}}" class="text-dark"> <i class="mdi mdi-tshirt-crew"></i>{{__('text.Products')}}</a></li>
                    <li><a href="{{route('admin.orders')}}" class="text-dark"> <i class="mdi mdi-book-open-variant "></i>{{__('text.Orders')}}</a></li>
                @can('isAdmin')
                    <li><a href="{{route('admin.vendors')}}" class="text-dark"><i class="mdi mdi-account-group"></i>{{__('text.Vendors')}}</a></li>
                    <li><a href="{{route('admin.customers')}}" class="text-dark"><i class="mdi mdi-account-multiple"></i>{{__('text.Users')}}</a></li>
                    <li><a href="{{route('admin.deliveryServiceProvider')}}" class="text-dark"><i class="mdi mdi-truck-delivery"></i>{{__('text.Delivery Service Provider')}}</a></li>
                    <li><a href="{{route('admin.shipping')}}" class="text-dark"><i class="mdi mdi-cash-marker"></i>{{__('text.Shipping Costs')}}</a></li>
                    <li><a href="{{route('admin.taxes')}}" class="text-dark"><i class="mdi mdi-currency-usd-off"></i>{{__('text.Taxes')}}</a></li>
                    <li><a href="{{route('admin.settings')}}" class="text-dark"><i class="mdi mdi-cogs"></i>{{__('text.Settings')}}</a></li>
                @endcan
                    <li><a href="{{route('admin.refunds')}}" class="text-dark"><i class="mdi mdi-cash-refund"></i>{{__('text.Refunds')}}</a></li>
                    <li><a href="{{route('admin.activities')}}" class="text-dark"><i class="mdi mdi-bell-ring"></i>{{__('text.Activities')}}</a></li>
                    <li><a href="{{route('admin.recycleBin')}}" class="text-dark"><i class="mdi mdi-delete"></i>{{__('text.Recycle Bin')}}</a></li>

            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>

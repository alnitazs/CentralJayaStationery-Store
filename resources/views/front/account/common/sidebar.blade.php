<ul id="account-panel" class="nav nav-pills flex-column" >
    <li class="nav-item">
        <a href="{{ route('account.profile') }}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-login" aria-expanded="false"><i class="fas fa-user-alt"></i>Profile Saya</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.orders') }}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-shopping-bag"></i>Pesanan Saya</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.wishlist') }}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-heart"></i>Wishlist</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.changePassword') }}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-lock"></i>Ganti Password</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('account.logout') }}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-sign-out-alt"></i>Keluar</a>
    </li>
</ul>
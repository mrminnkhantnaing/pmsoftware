@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
@endphp

<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/default/tkd_logo_element.png') }}" class="logo-icon" alt="the khant digital">
        </a>
        <div>
            <h4 class="logo-text">{{ config('app.name', 'PM Software') }}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    {{-- Navigation --}}
    <ul class="metismenu" id="menu">
        <li class="{{ $route === 'dashboard' ? 'mm-show' : '' }}">
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon">
                    <i class='bx bxs-dashboard' ></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-bar-chart-square'></i>
                </div>
                <div class="menu-title">Analytics</div>
            </a>
            <ul>
                <li class="{{ $route === 'analytics.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('analytics.index') }}"><i class="bx bx-right-arrow-alt"></i>Invoices</a>
                </li>
                <li class="{{ $route === 'analytics.tenants' ? 'mm-show' : '' }}">
                    <a href="{{ route('analytics.tenants') }}"><i class="bx bx-right-arrow-alt"></i>Tenants</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Invoice Management</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-file'></i>
                </div>
                <div class="menu-title">Transaction</div>
            </a>
            <ul>
                <li class="{{ $route === 'invoices.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('invoices.index') }}"><i class="bx bx-right-arrow-alt"></i>Invoices</a>
                </li>
                <li class="{{ $route === 'invoices.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('invoices.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-file-blank'></i>
                </div>
                <div class="menu-title">Pay Balance</div>
            </a>
            <ul>
                <li class="{{ $route === 'invoices.balance.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('invoices.balance.index') }}"><i class="bx bx-right-arrow-alt"></i>Invoices</a>
                </li>
                <li class="{{ $route === 'invoices.balance.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('invoices.balance.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-note'></i>
                </div>
                <div class="menu-title">Card Receipt</div>
            </a>
            <ul>
                <li class="{{ $route === 'invoices.cards.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('invoices.cards.index') }}"><i class="bx bx-right-arrow-alt"></i>Card Receipts</a>
                </li>
                <li class="{{ $route === 'invoices.cards.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('invoices.cards.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Parts Management</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bxs-city' ></i>
                </div>
                <div class="menu-title">Building</div>
            </a>
            <ul>
                <li class="{{ $route === 'buildings.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('buildings.index') }}"><i class="bx bx-right-arrow-alt"></i>All Buildings</a>
                </li>
                <li class="{{ $route === 'buildings.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('buildings.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-building'></i>
                </div>
                <div class="menu-title">Floor</div>
            </a>
            <ul>
                <li class="{{ $route === 'floors.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('floors.index') }}"><i class="bx bx-right-arrow-alt"></i>All Floors</a>
                </li>
                <li class="{{ $route === 'floors.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('floors.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-square-rounded' ></i>
                </div>
                <div class="menu-title">Flat</div>
            </a>
            <ul>
                <li class="{{ $route === 'flats.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('flats.index') }}"><i class="bx bx-right-arrow-alt"></i>All Flats</a>
                </li>
                <li class="{{ $route === 'flats.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('flats.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-grid'></i>
                </div>
                <div class="menu-title">Partition</div>
            </a>
            <ul>
                <li class="{{ $route === 'partitions.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('partitions.index') }}"><i class="bx bx-right-arrow-alt"></i>All Partitions</a>
                </li>
                <li class="{{ $route === 'partitions.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('partitions.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-credit-card-front bx-rotate-180' ></i>
                </div>
                <div class="menu-title">Card</div>
            </a>
            <ul>
                <li class="{{ $route === 'cards.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('cards.index') }}"><i class="bx bx-right-arrow-alt"></i>All Cards</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Notes Management</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-notepad'></i>
                </div>
                <div class="menu-title">Note</div>
            </a>
            <ul>
                <li class="{{ $route === 'notes.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('notes.index') }}"><i class="bx bx-right-arrow-alt"></i>All Notes</a>
                </li>
            </ul>
        </li>
        <li class="menu-label">Tenants Management</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-group'></i>
                </div>
                <div class="menu-title">Tenant</div>
            </a>
            <ul>
                <li class="{{ $route === 'tenants.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('tenants.index') }}"><i class="bx bx-right-arrow-alt"></i>All Tenants</a>
                </li>
                <li class="{{ $route === 'tenants.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('tenants.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon">
                    <i class='bx bx-street-view'></i>
                </div>
                <div class="menu-title">Referrer</div>
            </a>
            <ul>
                <li class="{{ $route === 'referrers.index' ? 'mm-show' : '' }}">
                    <a href="{{ route('referrers.index') }}"><i class="bx bx-right-arrow-alt"></i>All Referrers</a>
                </li>
                <li class="{{ $route === 'referrers.create' ? 'mm-show' : '' }}">
                    <a href="{{ route('referrers.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">@can('manage settings') Settings &  @endcan Others</li>
        @can('manage settings')
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                        <i class='bx bx-cog'></i>
                    </div>
                    <div class="menu-title">Settings</div>
                </a>
                <ul>
                    <li class="{{ $route === 'settings.general' ? 'mm-show' : '' }}">
                        <a href="{{ route('settings.general') }}"><i class="bx bx-right-arrow-alt"></i>General</a>
                    </li>
                    <li class="{{ $route === 'settings.invoice' ? 'mm-show' : '' }}">
                        <a href="{{ route('settings.invoice') }}"><i class="bx bx-right-arrow-alt"></i>Invoice</a>
                    </li>
                </ul>
            </li>
        @endcan

        <li class="{{ $route === 'profile.show' ? 'mm-show' : '' }}">
            <a href="/{{ Auth::user()->username }}">
                <div class="parent-icon">
                    <i class='bx bx-user'></i>
                </div>
                <div class="menu-title">Profile</div>
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <div class="parent-icon">
                    <i class='bx bx-log-out-circle'></i>
                </div>
                <div class="menu-title">Logout</div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>
        </li>
    </ul>
</div>
